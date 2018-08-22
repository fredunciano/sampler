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
    <legend><h4><?=$title?> <small>&nbsp;( Trading )</small></h4></legend>
    <div class="row-fluid">
        <div class="span2">Source</div>
        <div class="span10">
            <select id="display_type_to_show" name="display_type_to_show" class="input-medium">
                <option value="po">Plant Operations</option>
                <option value="cu">Customers</option>
                <option value="" selected="true">Combined</option>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Delivery Date</div>
        <div class="span10 input-append input-prepend">
            <input id="sdate" type="text" value="<?php echo date('m/d/Y',strtotime('+1 day')); ?>" class="input-small"><span class="add-on">-</span>
            <input id="edate" type="text" value="<?php echo date('m/d/Y',strtotime('+1 day')); ?>" class="input-small">
            <button id="btn_display_records" class="btn btn-primary">Display</button>
        </div>
    </div>
    <hr>
    <div class="row-fluid">
        <div id="dan_dap_report_container_msg"></div>
        <div id="dan_dap_report_container" style="display: none;">
            <table cellspacing="1" id="dan_dap_list" class="table table-condensed table-bordered table-striped"></table>
        </div>
        <br><br><br>
    </div>
</div>

<!--style type="text/css">
    #dan_dap_list td {
        background-color: #ffffff;
        border: 1px solid #cccccc;
        padding:8px;
        border-radius: 4px;
        text-align: left;
    }

    #dan_dap_list th {
        background-color: #333333;
        border: 1px solid #cccccc;
        padding:8px;
        border-radius: 4px;
        text-align: center;
        color: #f5f5f5;
    }

    #dan_dap_list .sub-header {
        background-color: #636161;
    }


    .submitted-data {
        background-image: url("../images/bullet_green.png");
        background-position: center center;
        background-repeat: no-repeat;
        cursor: pointer;
        height: 32px;
        margin: 0;
        text-align: center;
    }

    .not-submitted-data {
        background-image: url("../images/bullet_red.png");
        background-position: center center;
        background-repeat: no-repeat;
        cursor: pointer;
        height: 32px;
        margin: 0;
        text-align: center;
    }


    #dan_dap_report_container {
        background: none repeat scroll 0 0 #EBF3F5;
        border: 1px solid #CCD8E6;
        border-radius: 5px 5px 5px 5px;
        margin-top:5px;
        overflow: auto;
        padding:4px;
    }
</style-->
<style>
    .submitted-data {
        background-image: url("../images/bullet_green.png");
        background-position: center center;
        background-repeat: no-repeat;
        cursor: pointer;
        height: 32px;
        margin: 0;
        text-align: center;
    }

    .not-submitted-data {
        background-image: url("../images/bullet_red.png");
        background-position: center center;
        background-repeat: no-repeat;
        cursor: pointer;
        height: 32px;
        margin: 0;
        text-align: center;
    }
</style>

<!--script src="../js/date.js"></script>
<script src="../js/jquery.pad.js"></script>
<script src="../js/jquery.form.js"></script>
<script src="../js/daterangepicker.jQuery.js"></script>
<script src="../js/jquery.cluetip.min.js"></script-->

<script type="text/javascript">
    DAN_DAP_STATUS_MON = {
        sdate : null
        ,edate : null
        ,total_plant_operators_data : 0
        ,display_type : ''
        ,total_buyer_data : 0
        , columns : 0
        , showPlantOperations : true
        , showCustomers : true
    };

    $.extend({
        /*
        getPlantOperatorsData : function(){
            var plant_operators_data = [];
            $("#result_loader").html('Please wait &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif" />');
            
            $.ajax({
                type: "POST"
                ,url : '../trading_dandap/status_mon_action'
                ,data: { 'sdate' : DAN_DAP_STATUS_MON.sdate.toString("yyyy-MM-dd"), 'edate' : DAN_DAP_STATUS_MON.edate.toString("yyyy-MM-dd"),'action' : 'list-plant-operations'}
                //,data: { 'sdate' : $('#sdate').val(), 'edate' : $('#edate').val(),'action' : 'list-plant-operations'}
                ,dataType:'json'
                ,async: false
                ,success: function(returnData){
                    plant_operators_data = returnData.value;
                    $("#result_loader").html('');
                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    alert("Error on accessing webservice data " + jqXHR.responseText );
                    $("#result_loader").html('Error encountered');
                }
            });
            return plant_operators_data;
        }

        ,getBuyersData : function(){
            var buyers_data = [];
            $("#result_loader").html('Please wait &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif" />');
            $.ajax({
                type: "POST"
                ,url : '../trading_dandap/status_mon_action'
                ,data: { 'sdate' : DAN_DAP_STATUS_MON.sdate.toString("yyyy-MM-dd"), 'edate' : DAN_DAP_STATUS_MON.edate.toString("yyyy-MM-dd"),'action' : 'list-buyers-report'}
                ,dataType:'json'
                ,async: false
                ,success: function(returnData){
                    buyers_data = returnData.value;
                    $("#result_loader").html('');
                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    alert("Error on accessing webservice data " + jqXHR.responseText );
                    $("#result_loader").html('Error encountered');
                }
            });
            return buyers_data;
        }

        ,*/
        generatePlantOperatorsReport : function(plant_operators){
            var loop_date = DAN_DAP_STATUS_MON.sdate.clone(),
                end_date = DAN_DAP_STATUS_MON.edate.clone(),
                loop_date_string = "",
                loop_date_key ="",
                reports_html = "";
            var operator_data = null,
                operator_delivery_dates = {};

            DAN_DAP_STATUS_MON.total_plant_operators_data = plant_operators.length;

            for ( var i=0;i<plant_operators.length;i++ ){
                operator_data = plant_operators[i];
                operator_delivery_dates = operator_data.delivery_dates;

                row = "<tr>";
                // operator_data.user_name
                row+= '<td style="min-width:100px;vertical-align:middle"><b>Plant Operations</b></td>';

                loop_date = DAN_DAP_STATUS_MON.sdate.clone();
                while (loop_date<=end_date){
                    loop_date_string = loop_date.toString("d-MMM-yyyy");
                    loop_date_key = loop_date.toString("yyyy-MM-dd");

                    var delivery_date_values = operator_delivery_dates[loop_date_key]
                        ,is_dan = false
                        ,is_dap = false
                        ,is_wan = false
                        ,is_wap = false
                        ,dan_display = 'not-submitted-data'
                        ,dap_display = 'not-submitted-data'
                        ,wan_display = 'not-submitted-data'
                        ,wap_display = 'not-submitted-data'
                        ,dan_tooltip = ""
                        ,dap_tooltip = ""
                        ,wan_tooltip = ""
                        ,wap_tooltip = "";

                    if ( typeof delivery_date_values != 'undefined' ) {

                        is_dan =  typeof delivery_date_values.is_with_dan === 'undefined' ?  false :  delivery_date_values.is_with_dan ;
                        is_dap =  typeof delivery_date_values.is_with_dap === 'undefined' ?  false :  delivery_date_values.is_with_dap ;
                        is_wan =  typeof delivery_date_values.is_with_wan === 'undefined' ?  false :  delivery_date_values.is_with_wan ;
                        is_wap =  typeof delivery_date_values.is_with_wap === 'undefined' ?  false :  delivery_date_values.is_with_wap ;

                        if (is_dan) {
                            dan_display = 'submitted-data';
                            var dan_submitted_data_list = delivery_date_values.dan_submitted_data,
                                dan_tooltip = "",
                                obj = {};
                            for (var i=0; i< dan_submitted_data_list.length;i++){
                                obj = dan_submitted_data_list[i];
                                if ( i > 0 ) {
                                    dan_tooltip+='<br/>';
                                }
                                dan_tooltip += 'Submitted ' + Date.parse(obj.submitted_date).toString("MMM dd, yyyy hh:mm tt") + " by " + obj.submitted_by;
                            }
                        } else {
                            dan_tooltip = 'No Submitted Data for DAN '
                        }

                        if (is_dap) {
                            dap_display = 'submitted-data';
                            var dap_submitted_data_list = delivery_date_values.dap_submitted_data,
                                dap_tooltip = "",
                                obj = {};
                            for (var i=0; i< dap_submitted_data_list.length;i++){
                                obj = dap_submitted_data_list[i];
                                if ( i > 0 ) {
                                    dap_tooltip+='\n';
                                }
                                dap_tooltip += 'Submitted ' + Date.parse(obj.submitted_date).toString("MMM dd, yyyy hh:mm tt") + " by " + obj.submitted_by;
                            }
                        } else {
                            dap_tooltip = 'No Submitted Data for DAP '
                        }

                        if (is_wap) {
                            wap_display = 'submitted-data';
                            var wap_submitted_data_list = delivery_date_values.wap_submitted_data,
                                wap_tooltip = "",
                                obj = {};
                            for (var i=0; i< wap_submitted_data_list.length;i++){
                                obj = wap_submitted_data_list[i];
                                if ( i > 0 ) {
                                    wan_tooltip+='<br/>';
                                }
                                wap_tooltip += 'Submitted ' + Date.parse(obj.submitted_date).toString("MMM dd, yyyy hh:mm tt") + " by " + obj.submitted_by;
                            }
                        } else {
                            wap_tooltip = 'No Submitted Data for WAP '
                        }

                        if (is_wan) {
                            wan_display = 'submitted-data';
                            var wan_submitted_data_list = delivery_date_values.wan_submitted_data,
                                wan_tooltip = "",
                                obj = {};
                            for (var i=0; i< wan_submitted_data_list.length;i++){
                                obj = wan_submitted_data_list[i];
                                if ( i > 0 ) {
                                    wan_tooltip+='<br/>';
                                }
                                wan_tooltip += 'Submitted ' + Date.parse(obj.submitted_date).toString("MMM dd, yyyy hh:mm tt") + " by " + obj.submitted_by;
                            }
                        } else {
                            wan_tooltip = 'No Submitted Data for WAN '
                        }
                    }

                    if ( DAN_DAP_STATUS_MON.showCustomers ) {
                        row+= ' <td style="text-align: center;"><p class="'+dan_display+'" title="'+ dan_tooltip +'">&nbsp;</p> </td>';
                    }

                    if ( DAN_DAP_STATUS_MON.showPlantOperations ) {
                        row+= ' <td style="text-align: center;"><p class="'+dap_display+'" title="'+ dap_tooltip +'">&nbsp;</p> </td>';
                    }

                    if ( DAN_DAP_STATUS_MON.showCustomers ) {
                        row+= ' <td style="text-align: center;"><p class="'+wan_display+'" title="'+ wan_tooltip +'">&nbsp;</p> </td>';
                    }

                    if ( DAN_DAP_STATUS_MON.showPlantOperations ) {
                        row+= ' <td style="text-align: center;"><p class="'+wap_display+'" title="'+ wap_tooltip +'">&nbsp;</p> </td>';
                    }
                    loop_date = loop_date.add(1).days();
                }
                row+='</tr>';
                reports_html+=row;
            }
            //$('#dan_dap_list').html(reports_html);
            //$('#dan_dap_report_container').fadeIn(1000, "linear");
            $('#dan_dap_list').append(reports_html)//.hide().fadeIn(1000, "linear");
        }

        ,generateBuyersReport : function(buyers){
            var loop_date = DAN_DAP_STATUS_MON.sdate.clone(),
                end_date = DAN_DAP_STATUS_MON.edate.clone(),
                loop_date_string = "",
                loop_date_key ="";
            var buyer_data = null,
                buyer_delivery_dates = {}
            DAN_DAP_STATUS_MON.total_buyer_data = buyers.length;

            var reports_html = "";
            for ( var i=0;i<buyers.length;i++ ){
                buyer_data = buyers[i];
                buyer_delivery_dates = buyer_data.delivery_dates;

                row = "<tr>";
                row+= '<td style="min-width: 100px;vertical-align:middle"><b>'+ buyer_data.name +'</b></td>';

                loop_date = DAN_DAP_STATUS_MON.sdate.clone();
                while (loop_date<=end_date){
                    loop_date_string = loop_date.toString("d-MMM-yyyy");
                    loop_date_key = loop_date.toString("yyyy-MM-dd");

                    var delivery_date_values = buyer_delivery_dates[loop_date_key]
                        ,dan_css = "not-submitted-data"
                        ,dap_css = "not-submitted-data"
                        ,wan_css = "not-submitted-data"
                        ,wap_css = "not-submitted-data"
                        ,is_dan = false
                        ,is_dap = false
                        ,is_wan = false
                        ,is_wap = false
                        ,dan_display = 'not-submitted-data'
                        ,dap_display = 'not-submitted-data'
                        ,wan_display = 'not-submitted-data'
                        ,wap_display = 'not-submitted-data'
                        ,dan_tooltip = ""
                        ,dap_tooltip = ""
                        ,wan_tooltip = ""
                        ,wap_tooltip = ""

                    if ( typeof delivery_date_values != 'undefined' ) {

                        is_dan =  typeof delivery_date_values.is_with_dan === 'undefined' ?  false :  delivery_date_values.is_with_dan ;
                        is_dap =  typeof delivery_date_values.is_with_dap === 'undefined' ?  false :  delivery_date_values.is_with_dap ;
                        is_wan =  typeof delivery_date_values.is_with_wan === 'undefined' ?  false :  delivery_date_values.is_with_wan ;
                        is_wap =  typeof delivery_date_values.is_with_wap === 'undefined' ?  false :  delivery_date_values.is_with_wap ;

                        if (is_dan) {
                            dan_display = 'submitted-data';
                            dan_tooltip = 'Submitted on ' + Date.parse(delivery_date_values.dan_date_submitted).toString("MMM dd, yyyy hh:mm tt") + ' by ' + delivery_date_values.dan_submitted_by;
                        } else {
                            dan_tooltip = 'No Submitted Data for DAN '
                        }

                        if (is_dap) {
                            dap_display = 'submitted-data';
                            dap_tooltip = 'Submitted on ' + Date.parse(delivery_date_values.dap_date_submitted).toString("MMM dd, yyyy hh:mm tt") + ' by ' + delivery_date_values.dap_submitted_by;
                        } else {
                            dap_tooltip = 'No Submitted Data for DAP'
                        }

                        if (is_wap) {
                            wap_display = 'submitted-data';
                            wap_tooltip = 'Submitted on ' + Date.parse(delivery_date_values.wap_date_submitted).toString("MMM dd, yyyy hh:mm tt")+ ' by ' + delivery_date_values.wap_submitted_by;
                        } else {
                            wap_tooltip = 'No Submitted Data for WAP'
                        }

                        if (is_wan) {
                            wan_display = 'submitted-data';
                            wan_tooltip = 'Submitted on ' + Date.parse(delivery_date_values.wan_date_submitted).toString("MMM dd, yyyy hh:mm tt")+ ' by ' + delivery_date_values.wan_submitted_by;
                        } else {
                            wan_tooltip = 'No Submitted Data for WAN'
                        }


                    }


                    if ( DAN_DAP_STATUS_MON.showCustomers ) {
                        row+= ' <td style="text-align: center;"><p class="'+dan_display+'" title="'+ dan_tooltip +'">&nbsp;</p> </td>';
                    }

                    if ( DAN_DAP_STATUS_MON.showPlantOperations ) {
                        row+= ' <td style="text-align: center;"><p class="'+dap_display+'" title="'+ dap_tooltip +'">&nbsp;</p> </td>';
                    }

                    if ( DAN_DAP_STATUS_MON.showCustomers ) {
                        row+= ' <td style="text-align: center;"><p class="'+wan_display+'" title="'+ wan_tooltip +'">&nbsp;</p> </td>';
                    }

                    if ( DAN_DAP_STATUS_MON.showPlantOperations ) {
                        row+= ' <td style="text-align: center;"><p class="'+wap_display+'" title="'+ wap_tooltip +'">&nbsp;</p> </td>';
                    }

                    loop_date = loop_date.add(1).days();
                }
                row+='</tr>';
                reports_html+=row;
            }
            $('#dan_dap_list').append(reports_html)//.hide().fadeIn(1000, "linear");
        }

        ,generateHeaderColumns : function(){
            var loop_date = DAN_DAP_STATUS_MON.sdate.clone(),
                end_date = DAN_DAP_STATUS_MON.edate.clone(),
                loop_date_string = "",
                loop_date_key ="";
            var reports_html = "", header = "",sub_header = "";

            header = '<tr> <th rowspan="2">&nbsp;</th>';
            sub_header = ' <tr>';
            DAN_DAP_STATUS_MON.columns = 1;

            if ( DAN_DAP_STATUS_MON.showCustomers && DAN_DAP_STATUS_MON.showPlantOperations ) {
                var colspan = 4;
            }  else {
                var colspan = 2;
            }
            while (loop_date<=end_date){
                loop_date_string = loop_date.toString("d-MMM-yyyy");
                header+= ' <th colspan="'+ colspan +'" style="text-align:center">'+ loop_date_string +'</th>';

                if ( DAN_DAP_STATUS_MON.showCustomers ) {
                    sub_header+= '<th style="max-width:40px;min-width:40px;text-align:center" class="sub-header">DAN</th>';
                }

                if ( DAN_DAP_STATUS_MON.showPlantOperations ) {
                    sub_header+= '<th style="max-width:40px;min-width:40px;text-align:center" class="sub-header">DAP</th>';
                }

                if ( DAN_DAP_STATUS_MON.showCustomers ) {
                    sub_header+= '<th style="max-width:40px;min-width:40px;text-align:center" class="sub-header">WAN</th>';
                }

                if ( DAN_DAP_STATUS_MON.showPlantOperations ) {
                    sub_header+= '<th style="max-width:40px;min-width:40px;text-align:center" class="sub-header">WAP</th>';
                }

                DAN_DAP_STATUS_MON.columns = DAN_DAP_STATUS_MON.columns + 4;
                loop_date = loop_date.add(1).days();
            }
            header+= '</tr>';
            sub_header += ' </tr>';

            var reports_header_html = header+sub_header;

            $('#dan_dap_list').html(reports_header_html);
            $('#dan_dap_report_container').show()//.hide().fadeIn(1000, "linear");

        }

        ,displayDANDAPStatusMonList : function(){
            
            var sdate = Date.parse($('#sdate').val());
            var edate = Date.parse($('#edate').val());
            
            $('#dan_dap_report_container').hide();
            $('#dan_dap_list').html("");
            $('#dan_dap_report_container_msg').html('').removeAttr('css').hide();
            if (Date.compare(sdate, edate) === 1) {
                $('#dan_dap_report_container_msg').html('Invalid date selection').addClass('alert').addClass('alert-error').show();
            }else {
                
                var one_day=1000*60*60*24;
                var date_diff =  (  Math.round((edate.getTime()-sdate.getTime())/one_day)  );
                
                if ( date_diff > 13 ) {
                    $('#dan_dap_report_container_msg').html('Invalid date selection. Exceeded the maximum number of dates that can be selected').addClass('alert').addClass('alert-error').show();
                }else {
                    // create date range values
                    //var delivery_dates_values = $('#delivery_dates').val();
                    DAN_DAP_STATUS_MON.display_type = $.trim($("#display_type_to_show option:selected").attr('value').toLowerCase());

                    DAN_DAP_STATUS_MON.sdate = Date.parse($('#sdate').val());
                    DAN_DAP_STATUS_MON.edate = Date.parse($('#edate').val());

                    $('#dan_dap_list').html("");
                    $('#dan_dap_report_container').hide();

                    DAN_DAP_STATUS_MON.showPlantOperations = false;
                    DAN_DAP_STATUS_MON.showCustomers = false;
                    if ( DAN_DAP_STATUS_MON.display_type == 'po' ) {
                        DAN_DAP_STATUS_MON.showPlantOperations = true;
                    }  else if ( DAN_DAP_STATUS_MON.display_type == 'cu' ){
                        DAN_DAP_STATUS_MON.showCustomers = true;
                    }  else {
                        DAN_DAP_STATUS_MON.showPlantOperations = true;
                        DAN_DAP_STATUS_MON.showCustomers = true;
                    }
                    $.generateHeaderColumns();
                    $('#dan_dap_report_container_msg').html('Please wait ...').addClass('alert').addClass('alert-info').show();
                    $.ajax({
                        type: "POST"
                        ,url : '../trading_dandap/status_mon_action'
                        ,data: { 'sdate' : DAN_DAP_STATUS_MON.sdate.toString("yyyy-MM-dd")
                            , 'edate' : DAN_DAP_STATUS_MON.edate.toString("yyyy-MM-dd")
                            ,'action' : 'list-all'
                            ,'show_plant_operations' : DAN_DAP_STATUS_MON.showPlantOperations ? 1 : 0
                            ,'show_customers' : DAN_DAP_STATUS_MON.showCustomers  ? 1 : 0       
                         }
                        ,dataType:'json'
                        ,async: true
                        ,success: function(data){
                            var plant_avail = data.value.plant_avail;
                            var nominations = data.value.nominations;
                            var plant_avail_total = parseInt(data.value.plant_avail_total,10);
                            var nominations_total = parseInt(data.value.nominations_total,10);
                            if ( DAN_DAP_STATUS_MON.showPlantOperations ) {
                                $.generatePlantOperatorsReport(plant_avail);
                            }

                            if ( DAN_DAP_STATUS_MON.showCustomers ) {
                                $.generateBuyersReport(nominations);
                            }

                            if ( plant_avail_total == 0 && nominations_total === 0 ) {
                                $('#dan_dap_list').append('<tr><td colspan="'+ DAN_DAP_STATUS_MON.columns +'">No data available</td></tr>');
                            }

                            $('.not-submitted-data, .submitted-data').tooltip('hide');
                            $('#dan_dap_report_container_msg').html('').removeAttr('css').hide();
                            $('#dan_dap_report_container').css('width',$('#global').width()).css('overflow','auto');
                        }
                        ,error: function(jqXHR, textStatus, errorThrown){
                            alert("Error on accessing webservice data " + jqXHR.responseText );
                            $("#result_loader").html('Error encountered');
                        }
                    });

                }
                
                
            }
            
            
        }
    });

    $(document).ready(function() {
        
        $('#sdate, #edate').datepicker();

        /*$("#delivery_dates").daterangepicker({
            arrows: false
            ,dateFormat: 'mm/dd/yy'
            ,constrainDates : false
            ,presetRanges:[]
        });*/
        
        $.displayDANDAPStatusMonList();
        $('#btn_display_records').unbind('click').bind('click',function(){
            $.displayDANDAPStatusMonList();
            //$('.not-submitted-data, .submitted-data').tooltip('hide')
            //$.generatePlantOperatorsReport();
            //$.getPlantOperatorsData();
            
        });

        //var width_ = $('div.last').css('width').replace(/px/gi, "");
        //width_ = parseInt(width_,10) - 50;
        //$('#dan_dap_report_container').css('width',width_+'px');

        //$('#btn_display_records').trigger('click');
        
        //$('p').tooltip('hide')
        //$('a').tooltip('toggle')

    });
</script>
