
<style>
    .thumbnail {
        margin:0 5px 5px 0;
    }
    .ticker-buttons {
        font-size: 20px;
        cursor: pointer;
        margin:0;
    }
    .pointer {
        cursor: pointer;
    }
    .price {
        color : #62c462;
        font-weight: bold;
    }
    .ticker_container {
        margin-top:5px;
        padding-top:5px;
        padding-right:10px;
        background:#FFF;
        border-radius:5px
    }
    .ticker_row {
        background:#E0E0E0;
        border-radius:5px;
        padding-top:3px;
        margin-bottom:15px
    }
    .thumbnail {
        padding:0;
        margin-right:10px;
    }
    
    table.rtd-grid-table td.rtd-grid-box {
        background: none repeat scroll 0 0 #F9F9F9;
        border-radius: 3px 3px 3px 3px;
        margin: 10px;
        padding: 10px;
        min-width: 150px;
    }

    table.rtd-grid-table td.rtd-grid-section-title {
        background: none repeat scroll 0 0 #F9F9F9;
        font-weight:bold;
        font-size:13px;
        padding-bottom: 10px;
    }

    table.rtd-grid-table td.rtd-grid-section-data {
        background: none repeat scroll 0 0 #CBE0F1;
        border-radius: 3px 3px 3px 3px;
        margin: 10px;
        padding: 4px;
        height: 60px;
        text-align: center;
        vertical-align: middle;
        font-size:20px;
    }
    #content_rtem_bids_and_offers table tr:nth-child(1) td{
        text-align: center !important;
    }
    #content_rtem_bids_and_offers table tr td:nth-child(2){
        text-align: center !important;
    }
    #content_rtem_bids_and_offers table tr:nth-child(1n+2) td:nth-child(1n+4){
        text-align: right !important;
        min-width : 60px;
    }
</style>
<div id="loading_mask" style="width: 100%; height: 100%; position: fixed; background: #fff;z-index: 10">
    <blockquote class="pull-left">
        <h2>Loading Dashboard</h2>
        <p>Please wait...</p>
    </blockquote>
</div>





<div>
    <input type="hidden" id="rt_current_hour" value="<?php echo date('H') ?>">
    <input type="hidden" id="rt_current_interval" value="">
    <input type="hidden" id="rt_current_timerange" value="">
    <input type="hidden" id="current_date" value="<?php echo date('Y-m-d');?>">
    
    <?php
    if (count($widgets)) {
        foreach ($widgets as $w) {   
            
            switch ($w['widget_id']) {
                case 1 : 
                    echo '
                            <div class="row-fluid ticker_row">
                                <div class="span4">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="make-switch switch-small" data-on-label="RTD" data-off-label="RTX" data-label-icon="icon-dashboard" id="report-div">
                                        <input type="radio" checked id="report">
                                    </div>
                                    <div class="make-switch switch-small" data-on-label="GEN" data-off-label="LOAD" data-label-icon="icon-dashboard">
                                        <input type="radio" checked id="type">
                                    </div>
                                    <div class="" style="display:inline-block;">
                                        <select class="input-medium" id="zone" style="margin-top:9px">';
                                            foreach($zones as $z) {
                                                echo '<option value="'.$z->zone_prefix.'">'.$z->zone.'</option>';
                                            }
                     echo '             </select>
                                    </div>
                                </div>
                                <div class="span7 ticker_container">
                                    &nbsp;<marquee behavior="scroll" scrollamount="2" direction="left" width="92%" id="ticker"></marquee>&nbsp;
                                    <div class="pull-right">
                                        <i class="icon icon-plus-sign-alt ticker-buttons"></i>
                                        <i class="icon icon-minus-sign-alt ticker-buttons"></i>
                                    </div>
                                </div>
                            </div>
                         ';
                    break;
                case 2 : 
                    $arr_resource = explode('|',$w['resource_ids']);
                    foreach ($arr_resource as $r) {
                        echo '
                                <div class="thumbnail span7">
                                    <div class="caption">
                                        <h5>RTD Graph&nbsp;<small>'.$r.'</small></h5>
                                        <input type="hidden" class="graph_resource_id" value="'.$r.'">
                                        <div id="result_'.$r.'" class="row-fluid"></div>
                                    </div>
                                </div>
                             ';
                    }
                    break;
                    
                    
                case 3 : 
                    $arr_resource = explode('|',$w['resource_ids']);
                    foreach ($arr_resource as $r)  {
                        echo '
                                <div class="thumbnail span7">
                                    <div class="caption">
                                        <h5>RTD Grid&nbsp;for&nbsp;<u>'.$r.'</u> with +-3%</h5>
                                        <input type="hidden" class="grid_resource_id" value="'.$r.'">
                                        <div id="loader_rtd_grid_'.$r.'" class="loading-msg-container"></div>
                                        <div class="dragbox-content" id="content_rtd_grid_'. $r .'" >&nbsp;</div>
                                    </div>
                                </div>
                             ';
                    }
                    break;
                case 4 : 
                    
                    echo '
                            <div class="thumbnail span7" >
                                <div class="caption">
                                <h4>System Messages</h4>
                                <small><label class="checkbox inline"><input type="checkbox" id="green" name="sys_msg_chkbox" checked>Green</label></small>
                                <small><label class="checkbox inline"><input type="checkbox" id="blue" name="sys_msg_chkbox" checked>Blue</label></small>
                                <small><label class="checkbox inline"><input type="checkbox" id="red" name="sys_msg_chkbox" checked>Red</label></small>
                                <div id="content_system_messages" style="height:300px;overflow:auto"></div>
                                </div>
                            </div>
                         ';
                    
                    break;
                case 5 : 
                    echo '<input type="hidden" name="arr_resource" id="rtem_arr_resource" value='.$w['resource_ids'].'>';
                    echo '
                            <div class="thumbnail span7">
                                <div class="caption">
                                <h4>RTEM Bids and Offers</h4>
                                <div id="content_rtem_bids_and_offers" style="height:300px;overflow:auto"></div>
                                </div>
                            </div>
                         ';
                    break;
                case 6 : 
                    echo '<input type="hidden" name="arr_resource" id="nodal_prices_arr_resource" value='.$w['resource_ids'].'>';
                    echo '
                            <div class="thumbnail span7">
                                <div class="caption">
                                <h4>Nodal Prices</h4>
                                <div id="content_nodal_prices" style="height:300px;overflow:auto">test</div>
                                </div>
                            </div>
                         ';
                    break;
                
                case 7 : 
                    echo '
                            <div class="thumbnail span7">
                                <div class="caption">
                                <h3>Nomination Report</h3>
                                <p>...</p>
                                </div>
                            </div>
                         ';
                    break;
                case 8 : 
                    echo '
                            <div class="thumbnail span7">
                                <div class="caption">
                                <h4>BCQ Report</h4>
                                <p>...</p>
                                </div>
                            </div>
                         ';
                    break;
                case 9 : 
                    
                    $icons[0]   = 'wi-tornado';
                    $icons[1]   = 'wi-storm-showers';
                    $icons[2]   = 'wi-tornado';
                    $icons[3]   = 'wi-thunderstorm';
                    $icons[4]   = 'wi-thunderstorm';
                    $icons[5]   = 'wi-rain-mix';
                    $icons[6]   = 'wi-rain-mix';
                    $icons[7]   = 'wi-snow';
                    $icons[8]   = 'wi-sprinkle';
                    $icons[9]   = 'wi-sprinkle';
                    $icons[10]  = 'wi-rain';
                    $icons[11]  = 'wi-showers';
                    $icons[12]  = 'wi-showers';
                    $icons[13]  = 'wi-snow';
                    $icons[14]  = 'wi-snow';
                    $icons[15]  = 'wi-snow';
                    $icons[16]  = 'wi-snow';
                    $icons[17]  = 'wi-hail';
                    $icons[18]  = 'wi-rain-mix';
                    $icons[19]  = 'wi-fog';
                    $icons[20]  = 'wi-fog';
                    $icons[21]  = 'wi-fog';
                    $icons[22]  = 'wi-fog';
                    $icons[23]  = 'wi-cloudy-gusts';
                    $icons[24]  = 'wi-cloudy-windy';
                    $icons[25]  = 'wi-cloudy-gusts';
                    $icons[26]  = 'wi-cloudy';
                    $icons[27]  = 'wi-night-cloudy';
                    $icons[28]  = 'wi-day-cloudy';
                    $icons[29]  = 'wi-night-cloudy';
                    $icons[30]  = 'wi-day-cloudy';
                    $icons[31]  = 'wi-night-clear';
                    $icons[32]  = 'wi-day-sunny';
                    $icons[33]  = 'wi-day-sunny-overcast';
                    $icons[34]  = 'wi-day-sunny';
                    $icons[35]  = 'wi-rain-mix';
                    $icons[36]  = 'wi-day-sunny';
                    $icons[37]  = 'wi-thunderstorm';
                    $icons[38]  = 'wi-thunderstorm';
                    $icons[39]  = 'wi-thunderstorm';
                    $icons[40]  = 'wi-showers';
                    $icons[41]  = 'wi-snow';
                    $icons[42]  = 'wi-snow';
                    $icons[43]  = 'wi-snow';
                    $icons[44]  = 'wi-day-cloudy';
                    $icons[45]  = 'wi-storm-showers';
                    $icons[46]  = 'wi-snow';
                    $icons[47]  = 'wi-day-thunderstorm';
                    $icons[3200]  = 'icon-question';
                    
                    $locations['Manila']    = '1199477';
                    $locations['Cebu']      = '1199079';
                    $locations['Batangas']  = '1198888';
                    $locations['La Union']  = '91464848';
                    $locations['Davao']     = '1199136';
                    $locations['Iloilo']    = '2346685';
                    
                    
                    
                    foreach ($locations as $city => $woeid) {
                        
                        $weather_feed = file_get_contents('https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid='.$woeid.'&format=json');
                        $weather_feed = json_decode($weather_feed);
                        

                        //echo $weather_feed->results;
                        /*
                        if(!$weather_feed) die('weather failed, check feed URL');
                        
                        $weather = simplexml_load_string($weather_feed);
                        
                        $channel_yweather = $weather->channel->children("http://xml.weather.yahoo.com/ns/rss/1.0");

                        foreach($channel_yweather as $x => $channel_item) {
                            foreach($channel_item->attributes() as $k => $attr) {
                                $yw_channel[$x][$k] = $attr;
                            }
                        }

                        $item_yweather = $weather->channel->item->children("http://xml.weather.yahoo.com/ns/rss/1.0");

                        foreach($item_yweather as $x => $yw_item) {

                            foreach($yw_item->attributes() as $k => $attr) {
                                if($k == 'day') {
                                    $day = $attr;
                                }
                                if($x == 'forecast') { 
                                    $yw_forecast[$x][$day . ''][$k] = (string) $attr;	
                                }

                                if ($x == 'condition') {

                                    $yw_forecast['condition'][$k] =  (string) $attr;

                                }


                            }
                        }
                        */
                        
                        //$city = (string) $yw_channel['location']['city'];
                        //$humidity = (string) $yw_channel['atmosphere']['humidity'];
                        //$visibility = (string) $yw_channel['atmosphere']['visibility'];
                        //$pressure = (string) $yw_channel['atmosphere']['pressure'];
                        //$sunrise = (string) $yw_channel['astronomy']['sunrise'];
                        //$sunset = (string) $yw_channel['astronomy']['sunset'];
                        $yw_channel = $weather_feed->query->results->channel;
                        
                        $city = (string) $yw_channel->location->city;
                        $humidity = (string) $yw_channel->atmosphere->humidity;
                        $visibility = (string) $yw_channel->atmosphere->visibility;
                        $pressure = (string) $yw_channel->atmosphere->pressure;
                        $sunrise = (string) $yw_channel->astronomy->sunrise;
                        $sunset = (string) $yw_channel->astronomy->sunset;
                        $yw_forecast = $yw_channel->item;

                        $data[$city] = array(
                            'humidity'      => $humidity,
                            'visibility'    => $visibility,
                            'pressure'      => $pressure,
                            'sunrise'       => $sunrise,
                            'sunset'        => $sunset,
                            'condition'     => $yw_forecast->condition,
                            'forecast'      => $yw_forecast->forecast
                        );

                        
                            
                    }
                    //foreach ($data as $city => $attr) {
                    //echo '<pre>';
                    //print_r($attr['condition']);
                    //echo '</pre>';
                    //}
                    
                    foreach ($data as $city => $attr) {
                        
                        echo '
                            <div class="thumbnail span5">
                                <div class="caption">
                            ';
                        echo '<table class="table table-condensed">
                                <tr><td><h4>'.$city.'</h4></td></tr>
                                <tr><td><br>
                                <i class="'.$icons[$attr['condition']->code].' wi-big"></i>
                                '.$attr['condition']->text.'<br>
                                <i class="wi-thermometer"></i>Temperature : '.$attr['condition']->temp.'&#176 F<br>
                                <small>Last Updated : '.$attr['condition']->date.'</small><br><br>
                            ';
                        echo 'Additional Info : <table class="table table-condensed table-bordered">
                                <tr>
                                    <td><i class="wi-windy"></i>humidity: <br>'.$attr['humidity'].'%</td>
                                    <td><i class="wi-cloud-down"></i>visibility: <br>'.$attr['visibility'].'km</td>
                                    <td><i class="wi-sprinkles"></i>pressure: <br>'.number_format($attr['pressure'], 0, '.', ',').'mb</td>
                                    <td><i class="wi-sunrise"></i>sunrise: <br>'.$attr['sunrise'].'</td>
                                    <td><i class="wi-sunset"></i>sunset: <br>'.$attr['sunset'].'<br></td>
                                </tr>
                              </table>';
                        echo '<big>Forecast</big><br>';
                        echo '<table class="table">';
                        foreach ($attr['forecast'] as $d => $fc) {
                            $date = date('d/M/Y',strtotime($fc->date));
                            echo '<tr><td>'.$fc->day.'</td><td>'.str_replace("/", "-", $date).'</td><td><i class="wi-down"></i>'.$fc->low.'&#176</td><td><i class="wi-up"></i>'.$fc->high.'&#176</td><td><i class="'.$icons[$fc->code].' wi-medium "></i></td></tr>';

                        }

                        echo '</table>';
                        echo'        
                            </td></tr>
                            </table>
                            ';
                        echo '</div></div>';
                    }
                    
                    break;
                case 10 : 
                    echo '
                            
                                <a class="twitter-timeline" data-width="500" data-height="800" href="https://twitter.com/acaciasoftgroup/lists/acacia-twitter-list">A Twitter List by acaciasoftgroup</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
                         ';
                    break;
                
                case 11 : 
                   echo '<input type="hidden" name="arr_resource" id="dap_arr_resource" value='.$w['resource_ids'].'>';
                   echo '
                            <div class="thumbnail span12">
                                <div class="caption">
                                    <h5>DAP&nbsp;Combined (Prices and Schedules)</h5>
                                    <div id="content_DAP"></div>
                                    <div id="grid_DAP" style="height:200px;overflow:auto"></div>
                                </div>
                            </div>
                         ';
                    break;
                case 12 :
                    echo '<input type="hidden" name="arr_resource" id="dap_price_arr_resource" value='.$w['resource_ids'].'>';
                    echo '
                            <div class="thumbnail span12">
                                <div class="caption">
                                    <h5>DAP&nbsp;Prices</h5>
                                    <div id="content_DAP_prices"></div>
                                    <div id="grid_DAP_prices" style="height:200px;overflow:auto"></div>
                                </div>
                            </div>
                         ';
                    break;
                case 13 :
                    echo '<input type="hidden" name="arr_resource" id="dap_sched_arr_resource" value='.$w['resource_ids'].'>';
                    echo '
                            <div class="thumbnail span12">
                                <div class="caption">
                                    <h5>DAP&nbsp;Schedules</h5>
                                    <div id="content_DAP_schedules"></div>
                                    <div id="grid_DAP_schedules" style="height:200px;overflow:auto"></div>
                                </div>
                            </div>
                         ';
                    break;
                case 14 : 
                   echo '
                                <input type="hidden" name="market_demand" id="" value="LUZON">
                                <div class="thumbnail span7">
                                    <div class="caption">
                                        <h5>Daily Market Demand&nbsp;<small>LUZON</small></h5>
                                        <div id="market_demand_LUZON" class="row-fluid"></div>
                                    </div>
                                </div>
                             ';
                    break;
                
                case 15 : 
                   echo '
                                <input type="hidden" name="market_exante_lwap" id="" value="LUZON">
                                <div class="thumbnail span7">
                                    <div class="caption">
                                        <h5>Daily Ex-Ante LWAP&nbsp;<small>LUZON</small></h5>
                                        <div id="market_exante_lwap_LUZON" class="row-fluid"></div>
                                    </div>
                                </div>
                             ';
                    break;
                
                
                case 16 : 
                   echo '
                                <input type="hidden" name="market_demand" id="" value="VISAYAS">
                                <div class="thumbnail span7">
                                    <div class="caption">
                                        <h5>Daily Market Demand&nbsp;<small>VISAYAS</small></h5>
                                        <div id="market_demand_VISAYAS" class="row-fluid"></div>
                                    </div>
                                </div>
                             ';
                    break;
                
                case 17 : 
                   echo '
                                <input type="hidden" name="market_exante_lwap" id="" value="VISAYAS">
                                <div class="thumbnail span7">
                                    <div class="caption">
                                        <h5>Daily Ex-Ante LWAP&nbsp;<small>VISAYAS</small></h5>
                                        <div id="market_exante_lwap_VISAYAS" class="row-fluid"></div>
                                    </div>
                                </div>
                             ';
                    break;
                default :
                    break;
            }
        }
    } else {
        echo '
                <blockquote class="pull-right">
                    <h2>Dashboard is empty</h2>
                    <p>Please configure your dashboard</p>
                </blockquote>
             ';
    }
    
    
    ?>
    
    
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>    

    
            
</div>
<script src="js/highcharts.custom.theme.js"></script>
<script src="js/jquery.marquee.js"></script>
<script src="js/bootstrap-switch.min.js"></script>

<script>
var arr_interval
$.extend({
    getNodalPriceTicker : function() {
        //$('#ticker').html('Please wait...')
        var report  = $('#report').attr('checked') == 'checked' ? 'RTD' : 'RTX';
        var type    = $('#type').attr('checked') == 'checked' ? 'GEN' : 'LD';
        var zone    = $('#zone').val();
        
        $.ajax({
            type: "POST"
            ,url : '<?=$base_url?>/dashboard/getNodalPrice'
            ,dataType:'json'
            ,data:{report:report,type:type,zone:zone}
            ,async: true
            ,cache: false
            ,success: function(data){
                var html = '<b>'+report+'</b>'
                $.each(data, function(interval,val){
                    html+=' Interval '+interval+' '
                    $.each(val, function(resource, val2){
                        html+=' <b>'+resource+'</b>:'+'<span class="price">'+val2.price+'</span>'
                    })
                })
                $('#ticker').html(html)
                $('#loading_mask').fadeOut();
                
                var refreshId = setTimeout(function(){
                    $.getNodalPriceTicker();
                },  5000 );
            }
            ,error: function(jqXHR, textStatus, errorThrown){
                console.log("Error on accessing webservice data " + jqXHR.responseText );
            }
        });
        /*$.post('<?=$base_url?>/dashboard/getNodalPrice',{report:report,type:type,zone:zone},
            function(data){
                data = $.parseJSON(data)
                var html = '<b>'+report+'</b>'
                $.each(data, function(interval,val){
                    html+=' Interval '+interval+' '
                    $.each(val, function(resource, val2){
                        html+=' <b>'+resource+'</b>:'+'<span class="price">'+val2.price+'</span>'
                    })
                })
                $('#ticker').html(html)
                $('#loading_mask').fadeOut();
            })*/
    },
    getCurrentInterval : function(){
        $.ajax({
            type: "POST"
            ,url : '<?=$base_url?>/dashboard/getInterval'
            ,data: {hour:$('#rt_current_hour').val()}
            ,dataType:'json'
            ,async: false
            ,success: function(data){
                data = $.parseJSON(data)
                $('#rt_current_timerange').val(data.start+' - '+data.end)
                $('#rt_current_interval').val(data.interval)   
            }
        })
    },
    populateRTDGrid : function(resource){
        // get all unit available
        var parameters = { 'resource' : resource };
        var unit_val = '';
        $.ajax({
            type: "POST"
            ,url : '<?=$base_url?>/dashboard/getRTDGrid'
            ,data: parameters
            ,dataType:'json'
            ,async: true
            ,success: function(data){
                console.log(data)
                //console.log($('#rt_current_timerange').val())
                var units_array =typeof data.value != 'undefined' ? data.value : []
                    unit = null
                    ,aggregate_options = ''
                    ,chart_container = ''
                    ,contents = ''
                    ,cur_rtd_value =''
                    ,cur_rtd_int_val = 0
                    ,cur_rtd_formatted_val = ''
                    ,cur_rtd_minus3 = ''
                    ,cur_rtd_plus3 = ''
                    ,tmp = 0
                    ,tmpminus3 = 0
                    ,tmpplus3 = 0;
                
                var current_hour = parseInt($('#rt_current_hour').val(),10);
                var current_timerange = data.realtime.start+' - '+data.realtime.end
                var current_interval = data.realtime.interval

                
                //for (var i=0; i< units_array.length; i++){
                    //unit = units_array[i];
                    //unit_val = unit.resource_id;
                    //console.log(current_interval)
                    //return false;
                    cur_rtd_value  = data.value.mw;
                    //console.log('cur_rtd_value ' + cur_rtd_value)
                    cur_rtd_formatted_val = '';
                    cur_rtd_minus3 = '';
                    cur_rtd_plus3 = '';

                    if ( cur_rtd_value != null ) {
                        cur_rtd_int_val = parseFloat(cur_rtd_value);
                        cur_rtd_formatted_val = $.formatNumberToSpecificDecimalPlaces(cur_rtd_int_val,1);
                        tmp = cur_rtd_int_val*.03;
                        tmpminus3 = cur_rtd_int_val -tmp;
                        tmpplus3 =cur_rtd_int_val +tmp;
                        cur_rtd_minus3 = $.formatNumberToSpecificDecimalPlaces(tmpminus3,1);
                        cur_rtd_plus3 = $.formatNumberToSpecificDecimalPlaces(tmpplus3,1);
                    }

                    // condition to have autosize font when value is greater than 100
                    if  ( cur_rtd_formatted_val < 100 ) {
                        var rtd =  '<td class="rtd-grid-section-data" style="height:180px;font-size:13em">'+ cur_rtd_formatted_val + ' </td>' 
                    }else{
                        var rtd =  '<td class="rtd-grid-section-data" style="height:180px;font-size:10em">'+ cur_rtd_formatted_val + ' </td>' 
                    }


                    contents = '<table width="100%" class="rtd-grid-table" cellspacing="4" cellpadding="4" style="border-spacing: 4px;">' +
                        '<tr>' +
                        '<td rowspan="2" class="rtd-grid-box">' +
                        '<table width="100%">' +
                        '<tr><td class="rtd-grid-section-title">Current Interval '+ current_interval +' ('+current_timerange+'H)</td></tr>' +
                       // '<tr><td class="rtd-grid-section-data" style="height:180px;font-size:13em">'+ cur_rtd_formatted_val + ' </td></tr>' + // orig code default font size

                       '<tr>'+ rtd + '</tr>' + //autosize font
                        '</table>' +
                        '</td>' +
                        '<td class="rtd-grid-box">' +
                        '<table width="100%">' +
                        '<tr><td class="rtd-grid-section-title">-3%</td></tr>' +
                        '<tr><td class="rtd-grid-section-data">'+ cur_rtd_minus3 + ' MW</td></tr></table></td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td class="rtd-grid-box">' +
                        '<table width="100%"><tr><td class="rtd-grid-section-title">+3%</td></tr>' +
                        '<tr><td class="rtd-grid-section-data">'+ cur_rtd_plus3 + ' MW</td></tr></table></td>' +
                        '</tr></table>';
                    
                    $('#content_rtd_grid_'+resource).html(contents);
                    var refreshId = setTimeout(function(){
                    $.populateRTDGrid(resource);
                },  5000 );
                //}
            }
            ,error: function(jqXHR, textStatus, errorThrown){
                console.log("Error on accessing webservice data " + jqXHR.responseText );
            }
        });

    },
    populateSystemMessages : function(){
        $.ajax({
            type: "POST"
            ,url : '<?=$base_url?>/dashboard/getSystemMessages'
            ,data : {red:$('#red:checked').val(),green:$('#green:checked').val(),blue:$('#blue:checked').val()}
            ,dataType:'json'
            ,async: true
            ,cache: false
            ,success: function(data){
                
                var html = '<table id="sys_msg_tbl" class="table table-condensed"><tr><th style="width:120px">Date</th><th>Details</th></tr>';
                var x = 0;
                
                $.each(data,function(i,val){
                    
                    var bg;
                    x++;
                    if ( x % 2 === 0 ) bg = '#F0F2F5';
                    else bg = '#FFFFFF';

                    html+='<tr><td style="color:'+val.urgency+';background:'+bg+'">'+val.date+'</td><td style="color:'+val.urgency+';background:'+bg+'">'+val.message+'</td></tr>'
                })
                
                html+='</table>';
                $('#content_system_messages').html(html)

                var refreshId = setTimeout(function(){
                    $.populateSystemMessages();
                },  5000 );

            }
            ,error: function(jqXHR, textStatus, errorThrown){
                console.log("Error on accessing webservice data " + jqXHR.responseText );
            }
        });
    },
    populateRTEMBids : function(){

        $('#content_rtem_bids_and_offers').html('Updating ...');
        $.ajax({
            type: "POST"
            ,url : '<?=$base_url?>/dashboard/getRTEMBids'
            ,data: { 'resource_ids' : $('#rtem_arr_resource').val()}
            ,dataType:'json'
            ,async: true
            ,success: function(data){
                var content = '';
                $.each(data, function(i,val){
                    content+='<tr><td>'+val.date+'</td><td>'+val.interval+'</td><td>'+val.resource_id+'</td>';
                    content+='<td>'+$.formatNumberToCurrency(val.price1,2)+'</td><td>'+$.formatNumberToCurrency(val.qty1,2)+'</td>';
                    content+='<td>'+$.formatNumberToCurrency(val.price2,2)+'</td><td>'+$.formatNumberToCurrency(val.qty2,2)+'</td>';
                    content+='<td>'+$.formatNumberToCurrency(val.price3,2)+'</td><td>'+$.formatNumberToCurrency(val.qty3,2)+'</td>';
                    content+='<td>'+$.formatNumberToCurrency(val.price4,2)+'</td><td>'+$.formatNumberToCurrency(val.qty4,2)+'</td>';
                    content+='<td>'+$.formatNumberToCurrency(val.price5,2)+'</td><td>'+$.formatNumberToCurrency(val.qty5,2)+'</td>';
                    content+='<td>'+$.formatNumberToCurrency(val.price6,2)+'</td><td>'+$.formatNumberToCurrency(val.qty6,2)+'</td>';
                    content+='<td>'+$.formatNumberToCurrency(val.price7,2)+'</td><td>'+$.formatNumberToCurrency(val.qty7,2)+'</td>';
                    content+='<td>'+$.formatNumberToCurrency(val.price8,2)+'</td><td>'+$.formatNumberToCurrency(val.qty8,2)+'</td>';
                    content+='<td>'+$.formatNumberToCurrency(val.price9,2)+'</td><td>'+$.formatNumberToCurrency(val.qty9,2)+'</td>';
                    content+='<td>'+$.formatNumberToCurrency(val.price10,2)+'</td><td>'+$.formatNumberToCurrency(val.qty10,2)+'</td>';
                    content+='<td>'+$.formatNumberToCurrency(val.price11,2)+'</td><td>'+$.formatNumberToCurrency(val.qty11,2)+'</td>';
                    content+='<td>'+$.formatNumberToCurrency(val.rr_up1,2)+'</td><td>'+$.formatNumberToCurrency(val.rr_down1,2)+'</td><td>'+$.formatNumberToCurrency(val.rr_breakpoint1,2)+'</td>';
                    content+='<td>'+$.formatNumberToCurrency(val.rr_up2,2)+'</td><td>'+$.formatNumberToCurrency(val.rr_down2,2)+'</td><td>'+$.formatNumberToCurrency(val.rr_breakpoint2,2)+'</td>';
                    content+='<td>'+$.formatNumberToCurrency(val.rr_up3,2)+'</td><td>'+$.formatNumberToCurrency(val.rr_down3,2)+'</td><td>'+$.formatNumberToCurrency(val.rr_breakpoint3,2)+'</td>';
                    content+='<td>'+$.formatNumberToCurrency(val.rr_up4,2)+'</td><td>'+$.formatNumberToCurrency(val.rr_down4,2)+'</td><td>'+$.formatNumberToCurrency(val.rr_breakpoint4,2)+'</td>';
                    content+='<td>'+$.formatNumberToCurrency(val.rr_up5,2)+'</td><td>'+$.formatNumberToCurrency(val.rr_down5,2)+'</td><td>'+$.formatNumberToCurrency(val.rr_breakpoint5,2)+'</td>';
                    content+='<td>'+$.formatNumberToCurrency(val.rr_up6,2)+'</td><td>'+$.formatNumberToCurrency(val.rr_down6,2)+'</td><td>'+$.formatNumberToCurrency(val.rr_breakpoint6,2)+'</td>';
                    
                    content+='<td>'+val.reason+'</td>';
                    content+='</tr>';
                })
                

                var html='<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;Del&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;'+
                    '</td><td>Del&nbsp;Hour</td><td>Res&nbsp;ID</td>'+
                    '<td>P1</td><td>Q1</td><td>P2</td><td>Q2</td><td>P3</td><td>Q3</td>'+
                    '<td>P4</td><td>Q4</td><td>P5</td><td>Q5</td><td>P6</td><td>Q6</td>'+
                    '<td>P7</td><td>Q7</td><td>P8</td><td>Q8</td><td>P9</td><td>P9</td>'+
                    '<td>P10</td><td>Q10</td><td>P11</td><td>Q11</td>'+
                    '<td>rr_up1</td><td>rr_down1</td><td>rr_breakpoint1</td>'+
                    '<td>rr_up2</td><td>rr_down2</td><td>rr_breakpoint2</td>'+
                    '<td>rr_up3</td><td>rr_down3</td><td>rr_breakpoint3</td>'+
                    '<td>rr_up4</td><td>rr_down4</td><td>rr_breakpoint4</td>'+
                    '<td>rr_up5</td><td>rr_down5</td><td>rr_breakpoint5</td>'+
                    '<td>rr_up6</td><td>rr_down6</td><td>rr_breakpoint6</td>'+
                    '<td>reason</td>'+
                    '</tr>';
                html+=content;
                $('#content_rtem_bids_and_offers').html('<table class="table table-condensed table-striped table-bordered">'+ html +'</table>');
                //$('#content_rtem_bids_offer').addClass('dragbox-content-fix-height');

                //$('#content_rtem_bids_offer').html(JSON.stringify(data,''));
            }
            ,error: function(jqXHR, textStatus, errorThrown){
                console.log("Error on accessing webservice data " + jqXHR.responseText );
            }
        });
    },
    populateNodalPrices : function() {
        $('#content_nodal_prices').html('Updating ...');
        $.ajax({
            type: "POST"
            ,url : 'dashboard/getNodalPrices'
            ,data: { 'resource_ids' : $('#nodal_prices_arr_resource').val(),'hour':$('#rt_current_interval').val()}
            ,dataType:'json'
            ,async: true
            ,success: function(data){

                console.log(data)
                var h1 = $('#rt_current_hour').val();
                var h2 = parseInt($('#rt_current_hour').val()) + 1;
                console.log(h1)
                console.log(h2)
                
                var contents = '<table width="100%" class="nodal_prices table table-condensed table-bordered">' +
                               '<tr><th>&nbsp;</th>'+
                               '<th style="text-align:center;">Hour ' + h1 + '</th>' +
                               '<th style="text-align:center;">Hour ' + h2 + '</th>' +
                               '</tr>' ;
                
                $.each(data, function(i,val){

                    /*old codes
                    if (val.rtd[h1]) {
                        contents+='<tr><td><b><u>'+i+'</u></b></td><td>&nbsp;</td><td>&nbsp;</td></tr>';
                        contents+='<tr><td>RTD</td><td style="text-align:right;">'+$.formatNumberToSpecificDecimalPlaces(val.rtd[h1].price,2)+'</td><td  style="text-align:right;">'+$.formatNumberToSpecificDecimalPlaces(val.rtd[h2].price,2)+'</td></tr>';
                        contents+='<tr><td>RTX</td><td  style="text-align:right;">'+$.formatNumberToSpecificDecimalPlaces(val.rtx[h1].price,2)+'</td><td>&nbsp;</td></tr>';
                    }
                    */
                    var h1_rtd = '', h1_rtx = '', h2_rtd='', h2_rtx = '';
                    var h1_num = parseInt(h1,10);

                    if (val.rtd[h1_num]){
                        h1_rtd = $.formatNumberToSpecificDecimalPlaces(val.rtd[h1_num].price,2);
                    }

                    if (val.rtd[h2]){
                        h2_rtd = $.formatNumberToSpecificDecimalPlaces(val.rtd[h2].price,2);
                    }


                    if (val.rtx[h1_num]){
                        h1_rtx = $.formatNumberToSpecificDecimalPlaces(val.rtx[h1_num].price,2);
                    }

                    contents+='<tr><td><b><u>'+i+'</u></b></td><td>&nbsp;</td><td>&nbsp;</td></tr>';
                    contents+='<tr><td>RTD</td><td style="text-align:right;">'+h1_rtd+'</td><td  style="text-align:right;">'+h2_rtd+'</td></tr>';
                    contents+='<tr><td>RTX</td><td  style="text-align:right;">'+h1_rtx+'</td><td>&nbsp;</td></tr>';

                    
                })
                $('#content_nodal_prices').html(contents+'</table>');
                
            }
            ,error: function(jqXHR, textStatus, errorThrown){
                console.log("Error on accessing webservice data " + jqXHR.responseText );
            }
        });
        
    }
    ,populateDAPReport : function(){
        $('#content_DAP').html('Updating ...');
        $('#grid_DAP').html('');
        $.ajax({
            type: "POST"
            ,url : 'dashboard/getDAP'
            ,data: { 'resource_ids' : $('#dap_arr_resource').val()}
            ,dataType:'json'
            ,async: true
            ,success: function(data){
                // format data
                var list = data.value;
                var total = parseInt(data.total,10);
                var mw_data=[];
                var price_data=[];
                var resource_id;
                var colors = [ ['#0065FF','#2568CE'], ['#BA15DB','#7C0593']  , ['#1F6023','#0E7215']   , ['#BF550F','#9B582B']  , ['#1B723C','#417F58'], ['#D8A611','#D3B24E'] ];
                var ctr = 0;
                var content = "";
                var price_content='';
                var mw_content='';
                
                $.each(list, function(resource_id, resource_data) {
                    var data_mw = [];
                    var data_price = [];
                    var bg = (ctr%2) ? '#DEECFF' : '#F7FBFF'; 
                    var price_content='';
                    var mw_content='';
                    
                    content+='<tr style="background-color:'+bg+'"><td rowspan=2 style="vertical-align:middle"><b>'+resource_id+'</b></td><td>Price</td>';
                    
                    $.each(resource_data, function(hr,hr_data){
                        data_mw.push({y:hr_data.mw , 'type' : 'MW' });
                        data_price.push({y:hr_data.price , 'type' : 'Price' });
                        
                        price_content+= '<td>'+$.formatNumberToSpecificDecimalPlaces(hr_data.price,2)+'</td>';
                        mw_content+= '<td>'+$.formatNumberToSpecificDecimalPlaces(hr_data.mw,2)+'</td>';
        
                    });
                    mw_data.push({name:resource_id + ' (MW)',data:data_mw,id:'mw_'+resource_id,type : 'spline',lineWidth: 2,marker: { radius: 3 },shadow:false,color: colors[ctr][0]});
                    price_data.push({name:resource_id + ' (Price)',data:data_price,id:'price_'+resource_id,type : 'spline',lineWidth: 2,marker: { radius: 3 },shadow:false , 'yAxis': 1,color: colors[ctr][1]});
                    
                    // grid
                    content+=price_content;
                    content+='</tr><tr class="mw" style="background-color:'+bg+'"><td>MW</td>';
                    content+=mw_content;
                    content+='</tr>';
                    
                    ctr++;
                    if (ctr >= colors.length) {
                        ctr = 0;
                    }
                });
                
                
                
                if (total <= 0) {
                    $('#grid_DAP').html('').hide();
                    $('#content_DAP').html('No available data.');
                }else {
                    $('#grid_DAP').html('').show();
                    $('#content_DAP').html('');
                    // ########## format grid data ###############//
                    var html= '<tr><th>Resource ID</th><th>Type</th><th>H1</th><th>H2</th><th>H3</th><th>H4</th><th>H5</th><th>H6</th><th>H7</th><th>H8</th><th>H9</th><th>H10</th><th>H11</th><th>H12</th><th>H13</th><th>H14</th><th>H15</th><th>H16</th><th>H17</th><th>H18</th><th>H19</th><th>H20</th><th>H21</th><th>H22</th><th>H23</th><th>H24</th></tr>'
                    $('#grid_DAP').html('<table id="grid" class="table table-bordered table-condensed"></table>');
                    $("#grid").html(html);
                    $("#grid").append(content);
                    
                    // ########## format chart  ###############//
                    var series_data = mw_data.concat(price_data);
                    
                    DAP_chart = new Highcharts.Chart({
                        chart: {
                                renderTo: 'content_DAP',
                                type: 'spline',
                                ///plotBackgroundColor: null,
                                ///plotBorderWidth: null,
                                //plotShadow: false,
                                height:250
                        },
                        title: {
                            text: ''
                        },
                        xAxis: [{
                            categories: ['H1', 'H2', 'H3', 'H4', 'H5', 'H6','H7', 'H8', 'H9', 'H10', 'H11', 'H12',
                                         'H13', 'H14', 'H15', 'H16', 'H17', 'H18', 'H19', 'H20', 'H21', 'H22', 'H23', 'H24'],
                            tickPixelInterval:50,
                            gridLineWidth: 1
                            ,labels: {
                                rotation: -45
                                ,align: 'center'
                                ,style: {
                                    font: 'normal 9px Verdana'
                                }
                            }
                        }],
                        exporting : {
                            enabled : false
                        },
                        yAxis:  [{ // Primary yAxis
                            labels: {
                                formatter: function() {
                                    return $.formatNumberToSpecificDecimalPlaces(this.value,0) +'MW';
                                },
                                style: {
                                    color: '#4572A7'
                                }
                            },
                            title: {
                                text: 'MW',
                                style: {
                                    color: '#4572A7'
                                }
                            }

                        }, { // Secondary yAxis
                            gridLineWidth: 0,
                            title: {
                                text: 'Price',
                                style: {
                                    color: '#4572A7'
                                }
                            },
                            labels: {
                                formatter: function() {
                                    return $.formatNumberToSpecificDecimalPlaces(this.value,0) +' ';
                                },
                                style: {
                                    color: '#4572A7'
                                }
                            }
                            ,opposite: true

                        }]

                        ,tooltip: {
                            shared: true
                            ,formatter: function() {
                                var s = '<b>'+ this.x +'</b>';
                                var color = '';
                                var y_val = '';
                                var y_suffix = '';
                                $.each(this.points, function(i, point) {
                                    color = point.series.color;
                                    y_val = point.y;
                                    y_suffix = point.point.config.type === 'MW' ? ' MW ' : '';
                                    y_val = $.formatNumberToSpecificDecimalPlaces(y_val);
                                    s += '<br/><span style="color:'+color+'">'+ point.series.name +': '+
                                        y_val +y_suffix + '</span>';
                                });

                                return s;
                            }
                        },
                        series: series_data
                    });
                    
                    //})
                }
                
                return false;
                
                
            }
            ,error: function(jqXHR, textStatus, errorThrown){
                console.log("Error on accessing webservice data " + jqXHR.responseText );
            }
        });
    }
    ,populateDAPPrices : function(){
        $('#content_DAP_prices').html('Updating ...');
        $('#grid_DAP_prices').html('');
        $.ajax({
            type: "POST"
            ,url : 'dashboard/getDAPPrices'
            ,data: { 'resource_ids' : $('#dap_price_arr_resource').val()}
            ,dataType:'json'
            ,async: true
            ,success: function(data){
                
                // format data
                var list = data.value;
                var total = parseInt(data.total,10);
                var mw_data=[];
                var price_data=[];
                var resource_id;
                var colors = [ ['#0065FF','#2568CE'], ['#BA15DB','#7C0593']  , ['#1F6023','#0E7215']   , ['#BF550F','#9B582B']  , ['#1B723C','#417F58'], ['#D8A611','#D3B24E'] ];
                var ctr = 0;
                var content = "";
                var price_content='';
                var mw_content='';
                
                $.each(list, function(resource_id, resource_data) {
                    var data_mw = [];
                    var data_price = [];
                    var bg = (ctr%2) ? '#DEECFF' : '#F7FBFF'; 
                    var price_content='';
                    var mw_content='';
                    
                    content+='<tr style="background-color:'+bg+'"><td style="vertical-align:middle"><b>'+resource_id+'</b></td><td>Price</td>';
                    
                    $.each(resource_data, function(hr,hr_data){
                        data_price.push({y:hr_data.price , 'type' : 'Price' });
                        
                        price_content+= '<td>'+$.formatNumberToSpecificDecimalPlaces(hr_data.price,2)+'</td>';
        
                    });
                    price_data.push({name:resource_id + ' (Price)',data:data_price,id:'price_'+resource_id,type : 'spline',lineWidth: 2,marker: { radius: 3 },shadow:false , 'yAxis': 1,color: colors[ctr][1]});
                    
                    // grid
                    content+=price_content;
                    content+='</tr>';
                    
                    ctr++;
                    if (ctr >= colors.length) {
                        ctr = 0;
                    }
                });
                
                
                
                if (total <= 0) {
                    $('#grid_DAP_prices').html('').hide();
                    $('#content_DAP_prices').html('No available data.');
                }else {
                    $('#grid_DAP_prices').html('').show();
                    $('#content_DAP_prices').html('');
                    // ########## format grid data ###############//
                    var html= '<tr><th>Resource&nbsp;ID</th><th>Type</th><th>H1</th><th>H2</th><th>H3</th><th>H4</th><th>H5</th><th>H6</th><th>H7</th><th>H8</th><th>H9</th><th>H10</th><th>H11</th><th>H12</th><th>H13</th><th>H14</th><th>H15</th><th>H16</th><th>H17</th><th>H18</th><th>H19</th><th>H20</th><th>H21</th><th>H22</th><th>H23</th><th>H24</th></tr>'
                    $('#grid_DAP_prices').html('<table id="tbl_grid_dap_prices" class="table table-bordered table-condensed"></table>');
                    $("#tbl_grid_dap_prices").html(html);
                    $("#tbl_grid_dap_prices").append(content);

                    
                    // ########## format chart  ###############//
                    var series_data = mw_data.concat(price_data);
                    
                    DAP_chart = new Highcharts.Chart({
                        chart: {
                                renderTo: 'content_DAP_prices',
                                type: 'spline',
                                height:250
                        },
                        title: {
                            text: ''
                        },
                        xAxis: [{
                            categories: ['H1', 'H2', 'H3', 'H4', 'H5', 'H6','H7', 'H8', 'H9', 'H10', 'H11', 'H12',
                                         'H13', 'H14', 'H15', 'H16', 'H17', 'H18', 'H19', 'H20', 'H21', 'H22', 'H23', 'H24'],
                            tickPixelInterval:50,
                            gridLineWidth: 1
                            ,labels: {
                                rotation: -45
                                ,align: 'center'
                                ,style: {
                                    font: 'normal 9px Verdana'
                                }
                            }
                        }],
                        exporting : {
                            enabled : false
                        },
                        yAxis:  [{ // Primary yAxis
                            title: {
                                text: '',
                                style: {
                                    color: '#4572A7'
                                }
                            }

                        }, { // Secondary yAxis
                            gridLineWidth: 1,
                            title: {
                                text: 'Price',
                                style: {
                                    color: '#4572A7'
                                }
                            },
                            labels: {
                                formatter: function() {
                                    return $.formatNumberToSpecificDecimalPlaces(this.value,0) +' ';
                                },
                                style: {
                                    color: '#4572A7'
                                }
                            }
                            //,opposite: true

                        }]

                        ,tooltip: {
                            shared: true
                            ,formatter: function() {
                                var s = '<b>'+ this.x +'</b>';
                                var color = '';
                                var y_val = '';
                                var y_suffix = '';
                                $.each(this.points, function(i, point) {
                                    color = point.series.color;
                                    y_val = point.y;
                                    y_suffix = point.point.config.type === 'MW' ? ' MW ' : '';
                                    y_val = $.formatNumberToSpecificDecimalPlaces(y_val);
                                    s += '<br/><span style="color:'+color+'">'+ point.series.name +': '+
                                        y_val +y_suffix + '</span>';
                                });

                                return s;
                            }
                        },
                        series: series_data
                    });
                }
                
                return false;
                
                
            }
            ,error: function(jqXHR, textStatus, errorThrown){
                console.log("Error on accessing webservice data " + jqXHR.responseText );
            }
        });
    }
    ,populateDAPSchedules : function(){
        $('#content_DAP_schedules').html('Updating ...');
        $('#grid_DAP_schedules').html('');
        $.ajax({
            type: "POST"
            ,url : 'dashboard/getDAPSchedules'
            ,data: { 'resource_ids' : $('#dap_sched_arr_resource').val()}
            ,dataType:'json'
            ,async: true
            ,success: function(data){

                // format data
                var list = data.value;
                var total = parseInt(data.total,10);
                var mw_data=[];
                var resource_id;
                var colors = [ ['#0065FF','#2568CE'], ['#BA15DB','#7C0593']  , ['#1F6023','#0E7215']   , ['#BF550F','#9B582B']  , ['#1B723C','#417F58'], ['#D8A611','#D3B24E'] ];
                var ctr = 0;
                var content = "";
                var mw_content='';
                
                $.each(list, function(resource_id, resource_data) {
                    var data_mw = [];
                    var bg = (ctr%2) ? '#DEECFF' : '#F7FBFF'; 
                    var mw_content='';
                    
                    content+='<tr style="background-color:'+bg+'"><td style="vertical-align:middle"><b>'+resource_id+'</b></td><td>MW</td>';
                    
                    $.each(resource_data, function(hr,hr_data){
                        data_mw.push({y:hr_data.mw , 'type' : 'MW' });
                        mw_content+= '<td>'+$.formatNumberToSpecificDecimalPlaces(hr_data.mw,2)+'</td>';
        
                    });
                    mw_data.push({name:resource_id + ' (MW)',data:data_mw,id:'mw_'+resource_id,type : 'spline',lineWidth: 2,marker: { radius: 3 },shadow:false,color: colors[ctr][0]});
                    
                    content+=mw_content;
                    content+='</tr>';
                    
                    ctr++;
                    if (ctr >= colors.length) {
                        ctr = 0;
                    }
                });
                
                
                
                if (total <= 0) {
                    $('#grid_DAP_schedules').html('').hide();
                    $('#content_DAP_schedules').html('No available data.');
                }else {
                    $('#grid_DAP_schedules').html('').show();
                    $('#content_DAP_schedules').html('');
                    // ########## format grid data ###############//
                    var html= '<tr><th>Resource ID</th><th>Type</th><th>H1</th><th>H2</th><th>H3</th><th>H4</th><th>H5</th><th>H6</th><th>H7</th><th>H8</th><th>H9</th><th>H10</th><th>H11</th><th>H12</th><th>H13</th><th>H14</th><th>H15</th><th>H16</th><th>H17</th><th>H18</th><th>H19</th><th>H20</th><th>H21</th><th>H22</th><th>H23</th><th>H24</th></tr>'
                    $('#grid_DAP_schedules').html('<table id="tbl_grid_dap_schedules" class="table table-bordered table-condensed"></table>');
                    $("#tbl_grid_dap_schedules").html(html);
                    $("#tbl_grid_dap_schedules").append(content);

                    
                    // ########## format chart  ###############//
                    var series_data = mw_data;

                    DAP_chart = new Highcharts.Chart({
                        chart: {
                                renderTo: 'content_DAP_schedules',
                                type: 'spline',
                                height:250
                        },
                        title: {
                            text: ''
                        },
                        xAxis: [{
                            categories: ['H1', 'H2', 'H3', 'H4', 'H5', 'H6','H7', 'H8', 'H9', 'H10', 'H11', 'H12',
                                         'H13', 'H14', 'H15', 'H16', 'H17', 'H18', 'H19', 'H20', 'H21', 'H22', 'H23', 'H24'],
                            tickPixelInterval:50,
                            gridLineWidth: 1
                            ,labels: {
                                rotation: -45
                                ,align: 'center'
                                ,style: {
                                    font: 'normal 9px Verdana'
                                }
                            }
                        }],
                        exporting : {
                            enabled : false
                        },
                        yAxis:  [{ // Primary yAxis
                            labels: {
                                formatter: function() {
                                    return $.formatNumberToSpecificDecimalPlaces(this.value,0) +'MW';
                                },
                                style: {
                                    color: '#4572A7'
                                }
                            },
                            title: {
                                text: 'MW',
                                style: {
                                    color: '#4572A7'
                                }
                            }

                        }]

                        ,tooltip: {
                            shared: true
                            ,formatter: function() {
                                var s = '<b>'+ this.x +'</b>';
                                var color = '';
                                var y_val = '';
                                var y_suffix = '';
                                $.each(this.points, function(i, point) {
                                    color = point.series.color;
                                    y_val = point.y;
                                    y_suffix = point.point.config.type === 'MW' ? ' MW ' : '';
                                    y_val = $.formatNumberToSpecificDecimalPlaces(y_val);
                                    s += '<br/><span style="color:'+color+'">'+ point.series.name +': '+
                                        y_val +y_suffix + '</span>';
                                });

                                return s;
                            }
                        },
                        series: series_data
                    });
                    
                }
                
                return false;
                
                
            }
            ,error: function(jqXHR, textStatus, errorThrown){
                console.log("Error on accessing webservice data " + jqXHR.responseText );
            }
        });
    }
    ,populateMarketDemandGraph : function(region){
        var chartElm = 'market_demand_' + region;
        $('#'+chartElm).html('Updating ...');
        $.ajax({
            type: "POST"
            ,url : 'dashboard/getMarketDemand'
            ,data: { 'region' : region}
            ,dataType:'json'
            ,async: true
            ,success: function(data){
                
                var list = data.value;
                var total = parseInt(data.total);
                var region = data.region;
                var date_str = data.date_str;
                var current_hr = parseInt(data.current_hr,10);
                var chartElm = 'market_demand_' + region;
                if (total <= 0) {
                    $('#'+chartElm).html('No available records');
                }else {
                    // format data first
                    var rtd_data = [];
                    var rtx_data = [];
                    var dap_data = [];
                    var current_hour_rtd = null;
                    $.each(list, function(dte, hours_data) {
                        $.each(hours_data, function(hr,hr_data){
                            var rtd = parseInt(hr,10) > current_hr ? null : hr_data.rtd;
                            if (rtd != null ) rtd = parseFloat(hr_data.rtd);
                            
                            var rtx = parseInt(hr,10) > current_hr ? null : hr_data.rtx;
                            if (rtx != null ) rtx = parseFloat(hr_data.rtx);
                            
                            var dap = hr_data.dap;
                            if (dap != null ) dap = parseFloat(hr_data.dap);
                            
                            if (current_hr === parseInt(hr,10)) {
                                current_hour_rtd = rtd;
                            }
                            rtd_data.push({y:rtd , 'type' : 'RTD' });
                            rtx_data.push({y:rtx , 'type' : 'RTX' });
                            dap_data.push({y:dap , 'type' : 'DAP' });
                        });
                        return false;
                    });
                    var series_data = [];
                    series_data.push({name:'Day Ahead Projection (DAP)',data:dap_data,id:'market_demand_'+region+'_dap',lineWidth: 2,marker: { radius: 3 },shadow:false,color: '#FDDC05'});
                    series_data.push({name:'Hour Ahead Projection (RTD)',data:rtd_data,id:'market_demand_'+region+'_rtd' ,lineWidth: 2,marker: { radius: 3 },shadow:false,color: '#ffffff'});
                    series_data.push({name:'Current Demand (RTX)',data:rtx_data,id:'market_demand_'+region+'_rtx' ,lineWidth: 2,marker: { radius: 3 },shadow:false,color: '#00C7FF'});
                    
                    /// create chart for market demand
                    MARKET_DEMAND[region] = new Highcharts.Chart({
                        chart: {
                                renderTo: chartElm,
                                type: 'spline',
                                backgroundColor: '#00478C',
                                plotBorderColor : null,
                                plotBackgroundColor: { /// glen 
                                    //linearGradient: [0, 50, 0, 400],
                                    linearGradient: [0, 0, 400, 0],
                                    stops: [
                                        [0, '#B2D4F4'],
                                        [1, '#0D5091']
                                    ]
                                },
                                height:300
                        },
                        title: {
                            text: region.toProperCase() +' Market Demand (MW) - ' + date_str,
                            x: -20 //center,
                            ,style : {
                                    color: '#FDDC00',
                                    fontSize: '16px'
                            }

                        },
                        subtitle: {
                            text: 'Current Hour Demand : ' + $.formatNumberToSpecificDecimalPlaces(current_hour_rtd,2) + ' MW',
                            x: -20
                            ,style : {
                                    color: '#ABD5FF',
                                    fontSize: '16px'
                            }
                        },
                        xAxis: [{
                            categories: ['H1', 'H2', 'H3', 'H4', 'H5', 'H6','H7', 'H8', 'H9', 'H10', 'H11', 'H12',
                                         'H13', 'H14', 'H15', 'H16', 'H17', 'H18', 'H19', 'H20', 'H21', 'H22', 'H23', 'H24'],
                            gridLineWidth: 0,
                            gridLineColor: 'rgba(255, 255, 255, .4)', /* grid color vertical .opacity */
                            alternateGridColor: 'rgba(255, 255, 255, .05)',  
                            lineColor: '#fff',
                            tickColor: '#fff',
                            labels: {
                                rotation: -45
                                ,align: 'center'
                                ,style: {
                                    font: 'normal 9px Verdana'
                                    ,color: '#ffffff'
                                }
                            }
                        }],
                        exporting : {
                            enabled : false
                        },
                        legend: {
                            borderWidth: 0
                            ,itemStyle: {
                                color: '#ffffff'
                            }
                            ,align: 'center'
                            ,verticalAlign: 'bottom'
                            ,labelFormatter: function() {
                                return '<p>' + this.name +'</p>';
                            }
                            ,layout: 'vertical'
                        },
                        yAxis:  [{ // Primary yAxis
                            gridLineWidth: 1,
                            minorTickInterval: 'auto', /* horizontal gridline */
                            minorGridLineColor: 'rgba(255, 255, 255, .2)', /* color gridline */
                            gridLineColor: 'rgba(255, 255, 255, .1)',  /*grid color horizontal .opacity*/
                            lineColor: '#fff',
                            lineWidth: 1,
                            tickWidth: 1,
                            tickColor: '#fff',
                            labels: {
                                formatter: function() {
                                    return $.formatNumberToSpecificDecimalPlaces(this.value,0);
                                },
                                style: {
                                    color: '#ffffff'
                                }
                            },
                            title: {
                                text: 'MEGAWATT',
                                style: {
                                    color: '#ffffff'
                                }
                            }

                        }]
                        ,tooltip: {
                            enabled : true
                            ,formatter: function() {
                                return '<b>'+ this.series.name  +
                                    '</b> <br>'+ this.x + ': '+ $.formatNumberToSpecificDecimalPlaces(this.y,2) +' MW</b>';
                            }
                        },
                        series: series_data
                    });
                }
            }
            ,error: function(jqXHR, textStatus, errorThrown){
                console.log("Error on accessing webservice data " + jqXHR.responseText );
            }
        });
    }
    
    ,populateMarketLWAPGraph : function(region){
        var chartElm = 'market_exante_lwap_' + region;
        $('#'+chartElm).html('Updating ...');
        $.ajax({
            type: "POST"
            ,url : 'dashboard/getMarketLWAP'
            ,data: { 'region' : region}
            ,dataType:'json'
            ,async: true
            ,success: function(data){
                
                var list = data.value;
                var total = parseInt(data.total);
                var region = data.region;
                var date_str = data.date_str;
                var current_hr = parseInt(data.current_hr,10);
                var chartElm = 'market_exante_lwap_' + region;
                if (total <= 0) {
                    $('#'+chartElm).html('No available records');
                }else {
                    // format data first
                    var exante_data = [];
                    var expost_data = [];
                    var lwap_data = [];
                    var current_hour_rtd = null;
                    $.each(list, function(dte, hours_data) {
                        $.each(hours_data, function(hr,hr_data){
                            var rtd = parseInt(hr,10) > current_hr ? null : hr_data.rtd;
                            if (rtd != null ) rtd = parseFloat(hr_data.rtd);
                            
                            var rtx = parseInt(hr,10) > current_hr ? null : hr_data.rtx;
                            if (rtx != null ) rtx = parseFloat(hr_data.rtx);
                            
                            var dap = hr_data.dap;
                            if (dap != null ) dap = parseFloat(hr_data.dap);
                            
                            if (current_hr === parseInt(hr,10)) {
                                current_hour_rtd = rtd;
                            }
                            exante_data.push({y:rtd , 'type' : 'EXANTE' });
                            expost_data.push({y:rtx , 'type' : 'EXPOST' });
                            lwap_data.push({y:dap , 'type' : 'LWAP' });
                        });
                        return false;
                    });
                    var series_data = [];
                    series_data.push({name:'Day Ahead Projection LWAP',data:lwap_data,id:'market_exante_lwap_'+region+'_lwap',lineWidth: 2,marker: { radius: 3 },shadow:false,color: '#FDDC05'});
                    series_data.push({name:'Real-time Ex-Ante LWAP',data:exante_data,id:'market_exante_lwap_'+region+'_exante' ,lineWidth: 2,marker: { radius: 3 },shadow:false,color: '#ffffff'});
                    series_data.push({name:'Real-time Ex-Post LWAP',data:expost_data,id:'market_exante_lwap_'+region+'_expost' ,lineWidth: 2,marker: { radius: 3 },shadow:false,color: '#00C7FF'});
                    
                    /// create chart for market demand
                    MARKET_LWAP[region] = new Highcharts.Chart({
                        chart: {
                                renderTo: chartElm,
                                type: 'spline',
                                backgroundColor: '#00478C',
                                plotBorderColor : null,
                                plotBackgroundColor: { // glen
                                    //linearGradient: [0, 50, 0, 400],
                                    linearGradient: [0, 0, 400, 0],
                                    stops: [
                                        [0, '#B2D4F4'],
                                        [1, '#0D5091']
                                    ]
                                },
                                height:300
                        },
                        title: {
                            text: region.toProperCase() +' Ex-Ante LWAP (Php/MWh) - ' + date_str,
                            x: -20 //center,
                            ,style : {
                                    color: '#FDDC00',
                                    fontSize: '16px'
                            }

                        },
                        subtitle: {
                            text: 'Current Hour LWAP : Php' + $.formatNumberToSpecificDecimalPlaces(current_hour_rtd,2) + ' per MWh',
                            x: -20
                            ,style : {
                                    color: '#ABD5FF',
                                    fontSize: '16px'
                            }
                        },
                        xAxis: [{
                            categories: ['H1', 'H2', 'H3', 'H4', 'H5', 'H6','H7', 'H8', 'H9', 'H10', 'H11', 'H12',
                                         'H13', 'H14', 'H15', 'H16', 'H17', 'H18', 'H19', 'H20', 'H21', 'H22', 'H23', 'H24'],
                            gridLineWidth: 0,
                            gridLineColor: 'rgba(255, 255, 255, .4)', /* grid color vertical .opacity */
                            alternateGridColor: 'rgba(255, 255, 255, .05)',  
                            lineColor: '#fff',
                            tickColor: '#fff',
                            labels: {
                                rotation: -45
                                ,align: 'center'
                                ,style: {
                                    font: 'normal 9px Verdana'
                                    ,color: '#ffffff'
                                }
                            }
                        }],
                        exporting : {
                            enabled : false
                        },
                        legend: {
                            borderWidth: 0
                            ,itemStyle: {
                                color: '#ffffff'
                            }
                            ,align: 'center'
                            ,verticalAlign: 'bottom'
                            ,labelFormatter: function() {
                                return '<p>' + this.name +'</p>';
                            }
                            ,layout: 'vertical'
                        },
                        yAxis:  [{ // Primary yAxis
                            gridLineWidth: 1,
                            minorTickInterval: 'auto', /* horizontal gridline */
                            minorGridLineColor: 'rgba(255, 255, 255, .2)', /* color gridline */
                            gridLineColor: 'rgba(255, 255, 255, .1)',  /*grid color horizontal .opacity*/
                            lineColor: '#fff',
                            lineWidth: 1,
                            tickWidth: 1,
                            tickColor: '#fff',
                            labels: {
                                formatter: function() {
                                    return $.formatNumberToSpecificDecimalPlaces(this.value,0);
                                },
                                style: {
                                    color: '#ffffff'
                                }
                            },
                            title: {
                                text: 'PhP/MWh',
                                style: {
                                    color: '#ffffff'
                                }
                            }

                        }]
                        ,tooltip: {
                            enabled : true
                            ,formatter: function() {
                                return '<b>'+ this.series.name  +
                                    '</b> <br>'+ this.x + ': '+ $.formatNumberToSpecificDecimalPlaces(this.y,2) +' PhP/MWh</b>';
                            }
                        },
                        series: series_data
                    });
                }
            }
            ,error: function(jqXHR, textStatus, errorThrown){
                console.log("Error on accessing webservice data " + jqXHR.responseText );
            }
        });
    }
})
</script>

<script>
var MARKET_DEMAND = {};
var MARKET_LWAP = {};
var CHART = null
    ,NEXTHOURRTDVALUE = null
    ,RTDDate = '';
    var triggerUpdateByRTD = false;
    $.extend({
        loadData: function(is_click){
            $.ajax({
                type: "POST"
                ,url : '<?=$base_url?>/trading_realtimeplantmon/plant_monitoring_action'
                ,data: {'action':'get-current-interval-by-rtdvalue', unit:$('#cmb_plants_units').val(),'is_clicked' : is_click ? 1:0}
                ,dataType:'json'
                ,async: false
                ,success: function(data){
                    if (data.total < 1){
                        $("#result").append('<span style="padding:10px">No Data to Display</span>');
                    } else {
                        RTDDate = data.value.rtd_date;
                        $.formatData(data);
                    }
                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    console.log("Error on accessing webservice data " + jqXHR.responseText );
                }
            });
        }

        ,formatData: function (data){
            $('#rt_current_hour').attr('value',data.value.interval.start.substr(0,2));
            $('#rt_current_interval').attr('value',data.value.interval.interval);
            var interval_htm = 'Current Interval <h3>'+data.value.interval.interval+' ('+data.value.interval.start+' - '+data.value.interval.end+'H)</h3>';
            $('#interval-box').html(interval_htm);
            var rtd_val = data.value.rtd
            if ( typeof rtd_val != 'undefined' ) {
                if ( rtd_val != null ) {
                    rtd_val = $.formatNumberToSpecificDecimalPlaces(parseFloat(rtd_val),1);
                }
            }
            var rtd_htm = 'RTD '+$('#cmb_plants_units option:selected').html()+' <h2>'+rtd_val+'</h2>';
            $('#rtd-box').html(rtd_htm);
            var actual_load_htm = 'Actual Unit '+$('#cmb_plants_units option:selected').html()+' <h2>'+data.value.actual_unit+'</h2>';
            $('#actual-load-box').html(actual_load_htm);
            return false;
        }
         ,populateCurIntervalPlantsDropdown : function(){
             $("#result_loader").html('Please wait while plant dropdown is being populated &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif" />');
             var parameters = { 'action' : 'list-plants'};
             $.ajax({
                 type: "POST"
                 ,url : '<?=$base_url?>/trading_realtimeplantmon/plant_monitoring_action'
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
        ,populateCurIntervalUnitsDropdown: function(){
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

        ,getDigCtrlSysData: function(hour){
            var dcs = null ;
            var parameters = { 'action' : 'get-dcs' , 'unit'  : $('#cmb_plants_units').val() , 'hour' : hour  };
            $.ajax({
                type: "POST"
                ,url : '<?=$base_url?>/trading_realtimeplantmon/plant_monitoring_action'
                ,data: parameters
                ,dataType:'json'
                ,async: false
                ,success: function(returnData){
                    dcs =typeof returnData.value != 'undefined' ? returnData.value : null
                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    alert("Error on accessing webservice data " + jqXHR.responseText );
                }
            });
            return dcs;

        }

        ,getRTDData : function(hour,is_next_date,is_previous_date,resource_id){
            var rtd = null ;
            var parameters = { 'action' : 'get-rtd' , 'unit'  : resource_id , 'hour' : hour , 'is_next_date' : is_next_date, 'is_previous_date' : is_previous_date };
            $.ajax({
                type: "POST"
                ,url : '<?=$base_url?>/trading_realtimeplantmon/plant_monitoring_action'
                ,data: parameters
                ,dataType:'json'
                ,async: false
                ,success: function(returnData){
                    rtd =typeof returnData.value != 'undefined' ? returnData.value.rtd : null
                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    alert("Error on accessing webservice data " + jqXHR.responseText );
                }
            });
            return rtd;
        }

        ,createCurrentIntervalGraph : function(resource_id){
            var x_categories = [], series_data = [], data_series_id = '', loop_hr = '', current_hour = parseInt($('#rt_current_hour').val(),10);
            var is_next_hour_next_day_date = 0;
            var is_current_hour_previous_date = 0;
            var is_previous_date = 0;
            if ( current_hour === 0 ) {
                current_hour = 24;
            }
            var previous_hour = current_hour == 0 ? 23 :( current_hour -1 );
            if (previous_hour === 0) {
                previous_hour = 24;
            }
            var hour_series = [previous_hour,current_hour] ;
            var next_hour = 0;
            if (current_hour === 24){
                next_hour = 1;
            }else {
                next_hour = current_hour+1;
            }

            var current_date = Date.parse( $('#current_date').val() );
            var return_rtd_date = Date.parse( RTDDate );

            if ( current_date < return_rtd_date ) {
                is_next_hour_next_day_date = 1;
            }else if (  current_date.toString('yyyy-MM-dd') === return_rtd_date.toString('yyyy-MM-dd') ){
                if ( current_hour === 24){
                    is_current_hour_previous_date = 1;
                }

                if ( previous_hour === 23 || previous_hour === 24 ){
                    is_previous_date = 1;
                }
            }


            var resource_name = $.trim(resource_id) , is_aggregate_resources = $.trim(resource_name.toLowerCase()) === 'aggregate' ? true : false;
            

            for( var h=0;h<hour_series.length;h++ ) {
               loop_hr = hour_series[h];

               x_categories.push($.strPad(loop_hr,2,'0')+': ' + $.strPad('0',2,'0'));
               data_series_id = 'time_' + $.strPad(loop_hr,2,'0') + $.strPad('0',2,'0');
               series_data.push({ 'id':data_series_id, 'y' : null });

               for (var ii=1;ii<=59;ii+=5){
                   x_categories.push($.strPad(loop_hr,2,'0')+': ' + $.strPad(ii,2,'0'));
                   data_series_id = 'time_' + $.strPad(loop_hr,2,'0') + $.strPad(ii.toString(),2,'0');
                   series_data.push({ 'id':data_series_id, 'y' : null });
               }
            }
            x_categories.push($.strPad(next_hour,2,'0')+': ' + $.strPad('0',2,'0'));
            data_series_id = 'time_' + $.strPad(next_hour,2,'0') + $.strPad('0',2,'0');
            series_data.push({ 'id':data_series_id, 'y' : null });


            // create the rtd series data
            var rtd_x_axis = 0;
            var rtd_series_data = [];
            var x_axis_value_arr = [];
            var rtd_hour_series = [previous_hour,current_hour,next_hour];
            var cur_rtd_value = null, cur_loop_hr = null;
            for (var c=0;c<rtd_hour_series.length;c++){
                cur_loop_hr = rtd_hour_series[c];
                if ( c=== 0) {
                    cur_rtd_value = $.getRTDData(cur_loop_hr,0,is_previous_date,resource_id);
                }else if ( c === 1 ){
                    cur_rtd_value = $.getRTDData(cur_loop_hr,0,is_current_hour_previous_date,resource_id);
                }else {
                    cur_rtd_value = $.getRTDData(cur_loop_hr,is_next_hour_next_day_date,0,resource_id);
                }

                rtd_series_data.push({ x : rtd_x_axis, y : cur_rtd_value, hour : cur_loop_hr });
                x_axis_value_arr.push(cur_rtd_value);
                rtd_x_axis = rtd_x_axis + 13;
            }

            var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
            CHART = new Highcharts.Chart({

                chart: {
                    renderTo: 'result_'+resource_id
                },

                title: {
                    text: resource_id,
                    x: -20 //center
                },
                legend : {
                    enabled : false
                },
                subtitle: {
                    text: ' ',
                    x: -20
                },
                xAxis: {
                    categories: x_categories
                    ,labels: {
                        rotation: -45
                        ,align: 'center'
                        ,style: {
                            font: 'normal 9px Verdana'
                        }
                    }
                },

                yAxis: {
                    allowDecimals: false
                    //,max: is_aggregate_resources? null : 350
                    ,min : 0
                    //,tickInterval: is_aggregate_resources? null : 50
                    ,title: {
                        text: ' '
                    },
                    plotLines: [{
                        value: 0,
                        width: 1}]
                },
                scrollbar: {
                    enabled: false
                },
                exporting : {
                    enabled : false
                } ,
                series: [
                    {
                        data: series_data
                        ,name: is_aggregate_resources ? 'Actual Load Aggregate' : 'Actual Load Unit ' + resource_name
                        ,type : 'spline'
                        ,lineWidth: 2
                        ,marker: { radius: 3 }
                        ,shadow:false
                    }
                    ,{
                        type: 'scatter'
                        ,name: 'Target RTD Load'
                        ,data: rtd_series_data
                        ,marker: {
                            radius: 8
                        }
                    }
                ]

                ,tooltip: {
                    formatter: function() {
                        var  time_now = this.x
                            ,hour_time = parseInt(time_now.split(":")[0],10)
                            ,minute_time = parseInt(time_now.split(":")[1],10)
                            ,interval_x = "";

                        if ( minute_time == 0  ) {
                            interval_x = hour_time;
                        } else{
                            interval_x = hour_time+1;
                        }

                        var y_val = $.formatNumberToSpecificDecimalPlaces(this.y,1);


                        if ( this.series.name === 'Target RTD Load' ) {
                            var point_hr = this.point.hour;
                            return '<b>' + this.series.name + '</b><br/>' + 'Interval ' + point_hr + ' | ' + y_val + 'MW';
                        }else {
                            return '<b>' + this.series.name + '</b><br/>' + 'Interval ' + interval_x + ' | ' + time_now + 'H | ' + y_val + 'MW';
                        }

                    }
                }
            });
            	
        }

        ,updateChartDCSData : function(hour,series_data){
            var hour_str = parseInt(hour,10), chart_point_id ='', chart_point = null, series_value = null;

            for (var ii=1;ii<=59;ii+=5){
                series_value = null;
                chart_point_id = 'time_' + $.strPad(hour_str,2,'0') + $.strPad(ii.toString(),2,'0');
                chart_point = CHART.get( chart_point_id );
                if ( typeof series_data[hour_str] != 'undefined' ) {
                    if ( typeof series_data[hour_str]['mn_'+ii]  != 'undefined' ) {
                        series_value = parseFloat(series_data[hour_str]['mn_'+ii]);
                    }
                    chart_point.update(series_value, false);
                }

            }
            CHART.redraw();
        } //eof

        ,updateChartChanges : function(){

            var old_current_interval = parseInt($('#rt_current_interval').val(),10);

            $.ajax({
                type: "POST"
                ,url : '<?=$base_url?>/trading_realtimeplantmon/plant_monitoring_action'
                ,data: {'action' : 'get-current-interval-by-rtdvalue', unit:$('#cmb_plants_units').val()}
                ,dataType:'json'
                ,async: false
                ,success: function(data){
                    if (data.total < 1){
                        $("#result").append('<span style="padding:10px">No Data to Display</span>');
                    } else {
                        var new_interval_data =  parseInt(data.value.interval.interval,10);
                        if ( old_current_interval != new_interval_data ) {
                            console.log('old interval')
                            $.formatData(data);
                            triggerUpdateByRTD = false;
                            $('#btn_display_records').trigger('click');
                        } else {
                        	console.log('new interval')
                            triggerUpdateByRTD = false;
                            var current_hour = parseInt($('#rt_current_hour').val(),10);
                            var current_dcs = $.getDigCtrlSysData(current_hour);
                            $.updateChartDCSData(current_hour,current_dcs);
                        }
                    }
                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    console.log("Error on accessing webservice data " + jqXHR.responseText );
                }
            });
        }

        ,loadShiftReport: function(){
            $.ajax({
                type: "POST"
                ,url : '<?=$base_url?>/trading_realtimeplantmon/shift_report_load'
                ,data: {}
                ,dataType:'json'
                ,async: false
                ,success: function(data){
                    var contents = '', val = null;
                    for (var i=0;i<data.length;i++){
                        val = data[i];
                        contents+='<tr>';
                        contents+='<td>Posted by: <b>'+val.posted_by+'</b> Date: <b>'+val.date+'</b> Time: <b>'+val.time+'</b></td>';
                        contents+='</tr>';
                        contents+='<tr><td style="background:#FFF">'+val.report+'</td></tr>';
                    }
                    $('#tbl_shift_report').html(contents)
                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    console.log("Error on accessing webservice data " + jqXHR.responseText );
                }
            });
        },
        saveShiftReport: function(){
        
            if (!$('#editor').html()) {
                return false;
            }
            
            var report = $('#editor').html()
            $('#alerts').html('Saving Report...')
            $.post('<?=$base_url?>/trading_realtimeplantmon/shift_report_save',{report:report},
                function(data){
                    $.loadShiftReport();
                    $('#alerts').html('');
                    $('#editor').html('')
                });
        }

        ,validateServerTimeToGetNewData: function(){
            $.ajax({
                type: "POST"
                ,url : '<?=$base_url?>/trading_realtimeplantmon/plant_monitoring_action'
                ,data: {'action':'get-server-datetime'}
                ,dataType:'json'
                ,async: true
                ,success: function(data){
                    var time = data.value.time;
                    var date = data.value.date;

                    $('#current_date').attr('value',date);
                    var tmp = time.split(':');
                    var min = parseInt(tmp[1],10);

                    if ( min >= 0 && min <= 15) {
                        //console.log('minute ' + min + ' try to get new data ');
                        $.updateChartChanges();
                    }else if ( min >= 50 && min <= 59 ){
                        //console.log('minute ' + min + ' try to get new data ');
                        $.updateChartChanges();
                    }else {
                        //console.log('minute ' + min + ' do not get new data ');
                    }


                }
                ,error: function(jqXHR, textStatus, errorThrown){

                    if ( jqXHR.responseText.indexOf('#login_box') >= 0 ) {
                        //alert("Error on accessing webservice data " + jqXHR.responseText );
                        window.location = '<?=$base_url?>/auth';
                    }else {
                        $("#result_loader").html('With errors');
                    }


                }
            });
        }
        
        
    });
</script>
<script>
$('.report').unbind('click').bind('click', function(e){
    e.preventDefault();  
})
$('.icon-plus-sign-alt').unbind('click').bind('click', function(e){
    e.preventDefault();
    var scrollamount = parseInt($('#ticker').attr('scrollamount'))
    scrollamount++;
    $('#ticker').attr('scrollamount',scrollamount)
})
$('.icon-minus-sign-alt').unbind('click').bind('click', function(e){
    e.preventDefault();
    var scrollamount = parseInt($('#ticker').attr('scrollamount'))
    if (scrollamount > 1) {
        scrollamount--;
    }
    $('#ticker').attr('scrollamount',scrollamount)
})
$('marquee').hover(
    function() {
        this.stop();
    },
    function() {
        this.start();
    }
)

</script>
<script>
$.getCurrentInterval();

$.getNodalPriceTicker()    
$('.make-switch, #zone').change(function(){
    $.getNodalPriceTicker()    
})

$('.graph_resource_id').each(function(i) {
    var resource_id = $(this).val()
    if ( !triggerUpdateByRTD ) {
    $.loadData(true);
    }

    $.createCurrentIntervalGraph(resource_id);
    var current_hour = parseInt($('#rt_current_hour').val(),10);
    var previous_hour = current_hour == 0 ? 23 :( current_hour -1 );
    var prev_dcs = $.getDigCtrlSysData(previous_hour);
    var current_dcs = $.getDigCtrlSysData(current_hour);
    $.updateChartDCSData(previous_hour,prev_dcs);
    $.updateChartDCSData(current_hour,current_dcs);
    //setInterval('$.updateChartChanges()',50000);
    setTimeout(function(){
                    $.validateServerTimeToGetNewData()
                },  20000 );
    
})

$('.grid_resource_id').each(function(i) {
    var resource_id = $(this).val()
    $.populateRTDGrid(resource_id)
})

//if ($('#content_rtem_bids_and_offers').html()){
    $.populateRTEMBids();
//}

if ($('#content_nodal_prices').html()) {
    $.populateNodalPrices();
}

if ($('#content_system_messages').length > 0) {
    $.populateSystemMessages();
    $('input[name=sys_msg_chkbox]').change(function(){
        $.populateSystemMessages();
    });
}

$.populateDAPReport();
$.populateDAPPrices();
$.populateDAPSchedules();
if ($('#content_DAP').length > 0) {
  
}

$('input[name=market_demand]').each(function(i) {
    var region = $(this).val();
    $.populateMarketDemandGraph(region);
})

$('input[name=market_demand]').each(function(i) {
    var region = $(this).val();
    $.populateMarketLWAPGraph(region);
})



</script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>





