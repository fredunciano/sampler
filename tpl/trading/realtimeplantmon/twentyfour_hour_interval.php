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
        <div class="span2">Relevant Trading Day</div>
        <div class="span10 input-append">
            <input type="text" id="datepicker" value="<?php echo date('m/d/Y'); ?>" class="input-small"/>
            <a class="btn btn-primary" href="#" id="btn_display_records"><i class="icon-ok icon-white"></i>&nbsp;Display</a>
        </div>
    </div>
    </form>
    <legend>Result</legend>
    <div id="result_loader" class="loader"></div>
    <div id="container"></div>
    <input type="hidden" name="current_date" id="current_date" value="<?php echo date('Y-m-d'); ?>" >
</div>

<script src="../js/highcharts.custom.theme.js"></script>
<script type="text/javascript">
    $.extend({
        populate24HIntervalPlantsDropdown : function(){
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
                     alert("Error on accessing webservice data " + jqXHR.responseText );
                     $("#result_loader").html('With errors');
                 }
             });
         }
        ,populate24HIntervalUnitsDropdown: function(){
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
                    alert("Error on accessing webservice data " + jqXHR.responseText );
                    $("#result_loader").html('With errors');
                }
            });

        }
        ,get24HReportData : function(){
            var plant_avail = {} ;
            var parameters = { 'action' : 'get-plant-avaiability-summary' , 'unit'  : $('#cmb_plants_units').val() , 'date' : $('#datepicker').val() };
            $.ajax({
                type: "POST"
                ,url : '../trading_realtimeplantmon/plant_monitoring_action'
                ,data: parameters
                ,dataType:'json'
                ,async: false
                ,success: function(returnData){
                    plant_avail =typeof returnData.value != 'undefined' ? returnData.value : {};
                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    alert("Error on accessing webservice data " + jqXHR.responseText );
                }
            });
            return plant_avail;
        }
        ,populate24HChartSeriesData : function(){
            var  series_data = []
                , rtd_series = []
                , snapshot_series = []
                , actual_series = []
                , plus3percent_series = []
                , minus3percent_series = []
                , unit_list = $('#cmb_plants_units').val().split(',')
                , resource_name = $.trim($('#cmb_plants_units option:selected').html())
                , is_aggregate_resources = $.trim(resource_name.toLowerCase()) === 'aggregate' ? true : false;


            var report_data =  $.get24HReportData();
            var from_ = 0,
                to_ = 100,
                rtd_interval = null,
                actual_interval = null,
                snapshot_interval = null,
                total_rtd = null,
                total_actual = null,
                total_snapshot = null,
                cur_unit_data = null,
                snapshot_interval = null,
                hr_key = '';

            for (var interval=1; interval<=24; interval++){
                rtd_interval = null;
                actual_interval = null;
                cur_unit_data = null;
                snapshot_interval = null;
                total_rtd = null;
                total_actual = null;
                total_snapshot = null;
                hr_key = 'hr_' + interval;
                for ( var o=0; o< unit_list.length; o++ ){
                    var unit_id = unit_list[o] ;
                    if (typeof report_data[unit_id] != 'undefined' ) {
                        cur_unit_data =  report_data[unit_id];

                        if ( typeof cur_unit_data[hr_key] != 'undefined') {
                            var unit_interval_data = cur_unit_data[hr_key];

                            if ( typeof unit_interval_data.rtd != 'undefined' && unit_interval_data.rtd != null ) {
                                rtd_interval =  parseFloat(unit_interval_data.rtd);
                            }

                            if ( typeof unit_interval_data.energy != 'undefined' && unit_interval_data.energy != null ) {
                                actual_interval =  parseFloat(unit_interval_data.energy);
                            }

                            if ( typeof unit_interval_data.snapshot != 'undefined' && unit_interval_data.snapshot != null ) {
                                snapshot_interval =  parseFloat(unit_interval_data.snapshot);
                            }
                        } else {
                            rtd_interval = null;
                            actual_interval = null;
                            snapshot_interval = null;
                        }
                    }else {
                        rtd_interval = null;
                        actual_interval = null;
                        snapshot_interval = null;
                    }

                    if ( is_aggregate_resources ) {
                        if ( rtd_interval != null ) {
                            total_rtd = total_rtd === null ? 0 : total_rtd;
                            total_rtd = parseFloat(total_rtd) + parseFloat(rtd_interval);
                        }

                        if ( actual_interval != null ) {
                            total_actual = total_actual === null ? 0 : total_actual;
                            total_actual = parseFloat(total_actual) + parseFloat(actual_interval);
                        }

                        if ( snapshot_interval != null ) {
                            total_snapshot = total_snapshot === null ? 0 : total_snapshot;
                            total_snapshot = parseFloat(total_snapshot) + parseFloat(snapshot_interval);
                        }
                    } else {
                        total_rtd = rtd_interval;
                        total_actual = actual_interval;
                        total_snapshot = snapshot_interval;
                    }
                }; //end of unit loop

                rtd_series.push(total_rtd);
                actual_series.push(total_actual);
                snapshot_series.push(total_snapshot);

                if ( total_rtd != null ) {
                    var compare_value = parseFloat(total_rtd) * .03 ;
                    plus3percent_series.push(total_rtd+compare_value);
                    minus3percent_series.push(total_rtd-compare_value);
                } else {
                    plus3percent_series.push(null);
                    minus3percent_series.push(null);
                }
            }  ///end of for loop



            /// formatting series data
            series_data.push({
                name:   is_aggregate_resources ? "+3% for Unit " + $('#cmb_plants_units').attr("value") : "+3%"
                ,type : 'scatter'
                ,data:  plus3percent_series
            });

            series_data.push({
                name:   is_aggregate_resources ? "RTD for Unit " + $('#cmb_plants_units').attr("value") : "RTD"
                ,type : 'spline'
                ,data:  rtd_series
            });



            series_data.push({
                name:   is_aggregate_resources ? "-3% for Unit " + $('#cmb_plants_units').attr("value") : "-3%"
                ,type : 'scatter'
                ,data:  minus3percent_series
            });



            series_data.push({
                name:   is_aggregate_resources ? "Energy for Unit " + $('#cmb_plants_units').attr("value") : "Energy"
                ,type : 'spline'
                ,data:  actual_series
            });

            series_data.push({
                name:   is_aggregate_resources ? "Snapshot for Unit " + $('#cmb_plants_units').attr("value") : "Snapshot"
                ,type : 'spline'
                ,data:  snapshot_series
            });

            $("#result_loader").html('');

            return series_data;
        }
        ,create24HChart : function(){
            var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
            var chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'container',
                    defaultSeriesType: 'line',
                    borderWidth: 0,
                    animation: {
                        duration: 1000
                    }
                },
                title: {
                    text: '24H Interval Plant Monitoring',
                    x: -20 //center
                },
                legend : {
                    enabled : true
                    ,align: 'center'
                    ,verticalAlign: 'bottom'
                },
                subtitle: {
                    text: ' ',
                    x: -20
                },
                xAxis: {
                    categories: [ 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24 ]
                    ,labels: {
                        rotation: -45,
                        align: 'right',
                        style: {
                            font: 'normal 8px Verdana, sans-serif'
                        }
                    }
                },
                exporting : {
                    enabled : false
                },
                loading: {
                    labelStyle: {
                        top: '45%'
                    }
                },
                yAxis: {
                    title: {
                        text: ' '
                    },
                    plotLines: [{
                        value: 0,
                        width: 1}]
                },
                tooltip: {
                    formatter: function() {
                        var mw_vaue = this.y.toFixed(2);
                        return '<b>' + this.series.name + '</b><br/>' + 'Interval ' + this.x + ' - ' + mw_vaue + ' MW';
                    }
                },
                series: $.populate24HChartSeriesData()
            });
        }

    });

    $(document).ready(function() {
        $('#datepicker').datepicker();
        $.populate24HIntervalPlantsDropdown();
        $('#cmb_plants').unbind().bind('change',function(){
            $.populate24HIntervalUnitsDropdown();
        });

        $('#btn_display_records').unbind().bind('click',function(){
             $.create24HChart();

        });

        $('#cmb_plants').change();
        $('#btn_display_records').trigger('click');


    });
</script>
