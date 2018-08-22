<div class="span3">
    <ul class="nav nav-tabs nav-stacked" >
        <?php
        foreach ( $submenu as $sm ) {
            echo '<li><a href="'.$base_url.$sm['link'].'">'.$sm['title'].'</a></li>';
        }
        ?>
    </ul>    
</div>
<div class="span12">
    <legend><h4><?=$title?> <small>&nbsp;</small></h4></legend>
    <form enctype="multipart/form-data" method="post">
    <div class="row-fluid">
        <div class="span2">Plant</div>
        <div class="span10"><select id="cmb_plants" class="span3"></select></div>
    </div>
    <div class="row-fluid">
        <div class="span2">Unit</div>
        <div class="span10"><select id="cmb_plants_units" class="span3"></select></div>
    </div>
    <div class="row-fluid">
        <div class="span2">Delivery Date</div>
        <div class="span10 input-append">
            <input type="text" id="datepicker" value="<?php echo date('m/d/Y'); ?>" class="input-small"/>
            <a class="btn btn-primary" href="#" id="btn_display_records"><i class="icon-ok icon-white"></i>&nbsp;Display</a>
        </div>
    </div>
    </form>
    <legend>Result</legend>
    <div id="result_loader" class="loader"></div>
    
    <div id="cur_interval_grd_container" class="row-fluid" style="overflow:scroll;width:1000px;">
        <table id="cur_interval_grd_list" class="table table-bordered table-striped" >
        </table>
    </div>

    
    <br><br><br><br>
    <input type="hidden" id="current_date" value="<?php echo date('Y-m-d'); ?>"/>
</div>
 <style type="text/css">
    .col-type {
        min-width: 90px;
    }

    .col-interval-data {
        min-width: 70px;
    }
 </style>


<script type="text/javascript">
REALTIME_CURRENT_INTERVAL_GRID = {
    plant_units : []
    ,units_id_list : []
    ,data_types : [
        {"key" : "rtd" , "label" : "RTD (MW)" , "availability" : true, 'is_average' : false}
        ,{"key" : "energy" , "label" : "Energy (MWH) " , "availability" : true, 'is_average' : false}
        ,{"key" : "snapshot" , "label" : "Snapshot (MWH) ", "availability" : true, 'is_average' : false}
        ,{"key" : "eap" , "label" : "EAP (P/MWH) " , "availability" : false , 'is_average' : true}
        ,{"key" : "epp" , "label" : "EPP (P/MWH) " , "availability" : false, 'is_average' : true}
    ]
    ,currentHour : 0
    ,timeoutObject : null
    ,withTimeout : false
    ,timeoutMs : 3000
};
RTDDate = '';

$.extend({
    populateCurIntervalGridPlantsDropdown : function(){
        $("#result_loader").html('Please wait while plant dropdown is being populated &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif" />');
        var parameters = { 'action' : 'list-plants'};
        $.ajax({
            type: "POST"
            ,url : '../trading_realtimeplantmon/plant_monitoring_action'
            ,data: parameters
            ,dataType:'json'
            ,async: false
            ,success: function(returnData){
                var plants_array =typeof returnData.value != 'undefined' ? returnData.value : []
                    ,plants_options_html = ""
                    ,plant = null;

                for (var i=0; i< plants_array.length; i++){
                    plant = plants_array[i];
                    plants_options_html+= '<option value="'+ plant.plant_name +'">'+ plant.plant_name + '</option> ';
                }

                $('#cmb_plants').html(plants_options_html);
                if (plants_array.length > 0) {
                    $('#cmb_plants').prop("selectedIndex",0);
                    $('#cmb_plants').change();
                } else {
                    $('#cmb_plants').prop("selectedIndex",-1);
                }
                $("#result_loader").html('');
            }
            ,error: function(jqXHR, textStatus, errorThrown){
                //console.log("Error on accessing webservice data " + jqXHR.responseText );
                //$("#result_loader").html('With errors');
            }
        });
    }
    ,populateCurIntervalGridUnitsDropdown: function(){
        $("#result_loader").html('Please wait while units dropdown is being populated &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif" />');
        var parameters = { 'action' : 'list-resources-by-plant' , 'plant_id'  : $('#cmb_plants').val() };
        $.ajax({
            type: "POST"
            ,url : '../trading_realtimeplantmon/plant_monitoring_action'
            ,data: parameters
            ,dataType:'json'
            ,async: false
            ,success: function(returnData){
                var units_array =typeof returnData.value != 'undefined' ? returnData.value : []
                    ,options_html = ""
                    ,unit = null
                    ,aggregate_options = '';

                for (var i=0; i< units_array.length; i++){
                    unit = units_array[i];
                    options_html+= '<option value="'+ unit.resource_id +'">'+ unit.resource_name + '</option> ';

                    if ( aggregate_options.length > 0 ) {
                        aggregate_options+=',';
                    }
                    aggregate_options+=  unit.resource_id;
                }

                if (units_array.length > 0) {
                    options_html+= '<option value="'+ aggregate_options +'">Aggregate</option> ';
                    $('#cmb_plants_units').html(options_html);
                    $('#cmb_plants_units').prop("selectedIndex",0);
                } else {
                    $('#cmb_plants_units').prop("selectedIndex",-1);
                    $('#cmb_plants_units').html('');
                }
                $("#result_loader").html('');
            }
            ,error: function(jqXHR, textStatus, errorThrown){
                /*console.log("Error on accessing webservice data " + jqXHR.responseText );
                $("#result_loader").html('With errors');*/
            }
        });
    } //

    ,getPlantAvailabilitySummaryData : function(){
        var plant_avail = {} ;
        var parameters = { 'action' : 'get-plant-avaiability-summary' , 'unit'  : $('#cmb_plants_units').val() , 'date' : $('#datepicker').val() };
        $.ajax({
            type: "POST"
            ,url : '../trading_realtimeplantmon/plant_monitoring_action'
            ,data: parameters
            ,dataType:'json'
            ,timeout : 30000
            ,async: false
            ,success: function(returnData){
                plant_avail =typeof returnData.value != 'undefined' ? returnData.value : {};
            }
            ,error: function(jqXHR, textStatus, errorThrown){
                //console.log("Error on accessing webservice data " + jqXHR.responseText );
            }
        });
        return plant_avail;
    }

    ,getEapEppData : function(){
        var eap_epp = {} ;
        var parameters = { 'action' : 'get-eap-epp' , 'unit'  : $('#cmb_plants_units').val() , 'date' : $('#datepicker').val() };
        $.ajax({
            type: "POST"
            ,url : '../trading_realtimeplantmon/plant_monitoring_action'
            ,data: parameters
            ,dataType:'json'
            ,timeout : 30000
            ,async: false
            ,success: function(returnData){
                eap_epp =typeof returnData.value != 'undefined' ? returnData.value : {};
            }
            ,error: function(jqXHR, textStatus, errorThrown){
                //alert("Error on accessing webservice data " + jqXHR.responseText );
            }
        });
        return eap_epp;
    }

    ,populateCurrentIntervalGridList : function(){
        var report_header = ""
            , report_contents = ""
            , row = ""
            , date_selected =  Date.parse($("#datepicker").val()).toString("yyyy-MM-dd")
            , plant_id = $('#cmb_plants').attr('value')
            , resource_id = $('#cmb_plants_units').attr('value')
            , type = {}
            , i = 0
            , resource_name = $.trim($('#cmb_plants_units option:selected').html())
            , is_aggregate_resources = $.trim(resource_name.toLowerCase()) === 'aggregate' ? true : false
            , data_types = REALTIME_CURRENT_INTERVAL_GRID.data_types
            , unit_list = $('#cmb_plants_units').val().split(',');

        $('#cur_interval_grd_container').hide();
        $("#result_loader").html('Loading data &nbsp;&nbsp;&nbsp;<img src="images/ajax-loader.gif" />');

        var parameters = { 'action' : 'get-interval-grid-data' , 'unit'  : $('#cmb_plants_units').val() , 'date' : $('#datepicker').val() };
        $.ajax({
            type: "POST"
            ,url : '../trading_realtimeplantmon/plant_monitoring_action'
            ,data: parameters
            ,dataType:'json'
            ,timeout : 60000
            ,async: true
            ,success: function(data){
                var availability_summary_data = data.value.plant_avail;
                var price_data = data.value.eap_epp;

                report_header = '<tr><th class="col-type">&nbsp;</th>' ;
                for ( i=1; i<=24; i++ ){
                    report_header+= '<th class="col-interval-data">Interval '+ i +'</th>';
                }
                report_header+='</tr>';

                var data_value = null
                    ,total_data_value = null
                    ,data_content = ""
                    ,unit_id = ""
                    ,data = {}
                    ,interval_data = {}
                    ,hr_key = ''
                    ,total_units = 0
                    ,is_average = false
                    ,average_val = 0;

                for (var c=0;c<data_types.length;c++){
                    type = data_types[c];
                    data_value = null;
                    total_data_value = null;
                    is_average = typeof type.is_average === 'undefined' ? false : type.is_average;

                    row = '<tr>';
                    row+= '<td class="col-type">'+ type.label +'</td>';

                    for ( i=1; i<=24; i++){
                        data_value = null;
                        total_data_value = null;
                        hr_key = 'hr_' + i;
                        total_units = unit_list.length;
                        for ( var o=0; o< total_units; o++ ){
                            var unit_id = unit_list[o] ;

                            if ( type.availability ) {
                                data =  typeof availability_summary_data[unit_id] != 'undefined' ? availability_summary_data[unit_id] : {};
                                interval_data = data[hr_key];
                            } else {
                                data =  typeof price_data[unit_id] != 'undefined' ? price_data[unit_id] : {};
                                interval_data = data[hr_key];
                            }

                            if ( typeof interval_data != 'undefined' ) {
                                if ( typeof interval_data[type.key] != 'undefined' && interval_data[type.key] != null ) {
                                    data_value =  parseFloat(interval_data[type.key]).toFixed(1);
                                }
                            }  else {
                                data_value = null;
                            }

                            if ( is_aggregate_resources ) {
                                if ( data_value != null ) {
                                    total_data_value = total_data_value === null ? 0 : total_data_value;
                                    total_data_value = parseFloat(total_data_value) + parseFloat(data_value);
                                }
                            }else {
                                total_data_value = data_value;
                            }
                        } //end of each loop

                        if ( total_data_value === null ) {
                            data_content = "";
                        }else {

                            if ( is_average ) {
                                average_val = parseFloat(total_data_value) / total_units;
                                data_content = $.formatNumberToSpecificDecimalPlaces(parseFloat(average_val),1);
                            }else {
                                data_content = $.formatNumberToSpecificDecimalPlaces(parseFloat(total_data_value),1);
                            }

                        }

                        row+= '<td class="col-interval-data" style="text-align: right;" id="'+ type.key +'_interval_'+ i +'">'+ data_content +'</td>';

                    }
                    row+='</tr>';
                    report_contents+= row;
                }

                $('#cur_interval_grd_list').html(report_header+report_contents);
                $('#cur_interval_grd_container').show()
                $("#result_loader").html('');

                var current_date = Date.parse($('#current_date').val()).toString("yyyy-MM-dd");

                if ( date_selected === current_date ) {
                    //REALTIME_CURRENT_INTERVAL_GRID.timeoutObject =setInterval('$.updateCurrentIntervalGridData()',180000);
                    REALTIME_CURRENT_INTERVAL_GRID.timeoutObject =setInterval('$.validateIfNeedToGetNewData()',20000);

                } else {
                    window.clearInterval(REALTIME_CURRENT_INTERVAL_GRID.timeoutObject);
                }

            },error: function(jqXHR, textStatus, errorThrown){
                //console.log("Error on accessing webservice data " + jqXHR.responseText );
            }
        });
    }

    ,updateCurrentIntervalGridData : function(){
        var report_header = ""
            , report_contents = ""
            , row = ""
            , date_selected =  Date.parse($("#datepicker").val()).toString("yyyy-MM-dd")
            , plant_id = $('#cmb_plants').attr('value')
            , resource_id = $('#cmb_plants_units').attr('value')
            , type = {}
            , i = 0
            , resource_name = $.trim($('#cmb_plants_units option:selected').html())
            , is_aggregate_resources = $.trim(resource_name.toLowerCase()) === 'aggregate' ? true : false
            , data_types = REALTIME_CURRENT_INTERVAL_GRID.data_types
            , unit_list = $('#cmb_plants_units').val().split(',');

        $("#result_loader").html('Checking for updates ... &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif" />');
        var parameters = { 'action' : 'get-interval-grid-data' , 'unit'  : $('#cmb_plants_units').val() , 'date' : $('#datepicker').val() };

        $.ajax({
            type: "POST"
            ,url : '../trading_realtimeplantmon/plant_monitoring_action'
            ,data: parameters
            ,dataType:'json'
            ,timeout : 60000
            ,async: true
            ,success: function(data){
                var availability_summary_data = data.value.plant_avail;
                var price_data = data.value.eap_epp;

                var data_value = null
                    ,total_data_value = null
                    ,data_content = ""
                    ,unit_id = ""
                    ,data = {}
                    ,interval_data = {}
                    ,hr_key = ''
                    ,average_val = 0
                    ,is_average = false
                    ,total_units = 0;

                for (var c=0;c<data_types.length;c++){
                    type = data_types[c];
                    data_value = null;
                    total_data_value = null;
                    is_average = typeof type.is_average === 'undefined' ? false : type.is_average;

                    for ( i=1; i<=24; i++){
                        data_value = null;
                        total_data_value = null;
                        hr_key = 'hr_' + i;

                        total_units = unit_list.length;
                        for ( var o=0; o< total_units; o++ ){
                            var unit_id = unit_list[o] ;

                            if ( type.availability ) {
                                data =  typeof availability_summary_data[unit_id] != 'undefined' ? availability_summary_data[unit_id] : {};
                                interval_data = data[hr_key];
                            } else {
                                data =  typeof price_data[unit_id] != 'undefined' ? price_data[unit_id] : {};
                                interval_data = data[hr_key];
                            }

                            if ( typeof interval_data != 'undefined' ) {
                                if ( typeof interval_data[type.key] != 'undefined' && interval_data[type.key] != null ) {
                                    data_value =  parseFloat(interval_data[type.key]).toFixed(1);
                                }
                            }  else {
                                data_value = null;
                            }

                            if ( is_aggregate_resources ) { /* should add all units values*/
                                if ( data_value != null ) {
                                    total_data_value = total_data_value === null ? 0 : total_data_value;
                                    total_data_value = parseFloat(total_data_value) + parseFloat(data_value);
                                }
                            }else {
                                total_data_value = data_value;
                            }
                        }; //end of each loop

                        if ( total_data_value === null ) {
                            data_content = "";
                        }else {

                            if ( is_average ) {
                                average_val = parseFloat(total_data_value) / total_units;
                                data_content = $.formatNumberToSpecificDecimalPlaces(parseFloat(average_val),1);
                            }else {
                                data_content = $.formatNumberToSpecificDecimalPlaces(parseFloat(total_data_value),1);
                            }

                        }

                        var cell_id = type.key +'_interval_'+ i
                            ,current_cell_value = $('#' + cell_id).html();
                        if (data_content != current_cell_value) {
                            $('#' + cell_id).html(data_content);
                            $('#' + cell_id).hide();
                        }


                    }

                }

                $("#result_loader").html('');

            },error: function(jqXHR, textStatus, errorThrown){
                //console.log("Error on accessing webservice data " + jqXHR.responseText );
            }
        });
        /*var availability_summary_data = $.getPlantAvailabilitySummaryData();
        var price_data = $.getEapEppData();
        */
    }
    ,validateIfNeedToGetNewData : function(){
        $.ajax({
            type: "POST"
            ,url : '../trading_realtimeplantmon/plant_monitoring_action'
            ,data: {'action':'get-server-datetime'}
            ,dataType:'json'
            ,async: true
            ,success: function(data){
                var time = data.value.time;
                var tmp = time.split(':');
                var min = parseInt(tmp[1],10);
                var date = data.value.date;
                $('#current_date').attr('value',date);

                if ( min >= 0 && min <= 15) {
                    //console.log('minute ' + min + ' try to get new data ');
                    $.updateCurrentIntervalGridData();
                }else if ( min >= 50 && min <= 59 ){
                    //console.log('minute ' + min + ' try to get new data ');
                    $.updateCurrentIntervalGridData();
                }else {
                    //console.log('minute ' + min + ' do not get new data ');
                }


            }
            ,error: function(jqXHR, textStatus, errorThrown){
            }
        });
    }
});

$(document).ready(function() {
    //$('#cur_interval_grd_container').css("width",$('div.last').width()-20);

    $.populateCurIntervalGridPlantsDropdown();
    $('#cmb_plants').unbind().bind('change',function(){
        $.populateCurIntervalGridUnitsDropdown();
    });

    $('#btn_display_records').unbind().bind('click',function(){
         $.populateCurrentIntervalGridList();

    });

    $('#cmb_plants').change();
    $('#btn_display_records').trigger('click');
    $( "#datepicker" ).datepicker();


});
</script>
