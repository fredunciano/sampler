<div class="span-14" id="content-holder">
    <?php
    if ( count($portlets) == 0 && count($rtd_portlets) == 0 && $rtd_grid_portlets === 0 ){ ?>
        <h1><?=$content?></h1>
    <?php } else {?>
        <?php
        if (  $is_with_rtdrtx_ticker === 1 ) { ?>
            <div class="energy-flash-data" style="margin-left: 2px;">

                <!--<div id="radio_rtdrtx" style="width:80px;float:left; margin-top:4px;">-->
                <div id="radio_rtdrtx">
                    <input type="radio" id="radio1" value="RTD" name="radio_rtdrtx"  checked="checked" /><label for="radio1">RTD</label>
                    <input type="radio" id="radio2" value="RTX"  name="radio_rtdrtx" /><label for="radio2">RTX</label>
                </div>

                <!--<div id="radio_sortorder_container" style="width:155px;float:left; margin-top:4px;margin-right:10px;">-->
                <div id="radio_sortorder_container">
                    <div style="float:left; margin-top:4px;">Sort By : &nbsp;</div>
                    <div id="radio_sortorder">
                        <input type="radio" id="radioSort1" value="price" name="radio_sortorder"  /><label for="radioSort1">Price</label>
                        <input type="radio" id="radioSort2" value="resource_id"  name="radio_sortorder"  checked="checked" /><label for="radioSort2">Resource</label>
                    </div>
                </div>

                <div style="height:20px;max-height: 20px; float:right; width:70%;">
                    <div class="rtdrtx-marquee-controls">
                        <img src="images/pause_and_play.png" id="pause_flash_data"  title="Pause/Play" border="0" align="center" style="cursor:hand;">
                        <img src="images/plus2.gif" id="speed_plus_flash_data"  title="Increase speed" border="0" align="center" style="cursor:hand;">
                        <img src="images/minus.gif" id="speed_minus_flash_data" title="Decrease speed" border="0" align="center" style="cursor:hand;" >
                        <img src="images/left_button.gif" title="Left to Right" border="0" align="center" style="cursor:hand;" onclick="document.all.flash_data.direction='left';document.all.flash_data.start();">
                        <img src="images/right_button.gif"  border="0" align="center" style="cursor:hand;" onclick="document.all.flash_data.direction='right';document.all.flash_data.start();">
                    </div>
                    <div id="rtd_container">Updating .... </div>
                </div>
            </div>
        <?php } ?>




        <table id="dashboardportlets" width="100%" class="portlets">
        <tbody class="sortable-content">
        <?php
        $methods_arr = array();
        if (  count($rtd_portlets) > 0 && $is_with_rtd_portlet === 1 ) {
            array_push($methods_arr, 'populateRTD' );
            ?>
                    <tr><td><table width="100%" cellpadding="2" cellspacing="2" style="border-spacing: 4px;">
                    <tbody class="sortable-subcontent" id="rtd_graph_portlets">
                    <tr>

                        <?php foreach ($resources_list as $resource) {
                            $resource_id = $resource['resource_id'];
                            echo '<td style="width: 50%" ><div class="dragbox" id="itm_rtd_graph_'.$resource_id.'" >
                           <h2>RTD Graph '. $resource_id . '<span class="maximize">&nbsp;</span></h2>
                           <div id="loader_rtd_graph_'.$resource_id.'" class="loading-msg-container"></div>
                           <div class="dragbox-content" id="content_rtd_graph_'. $resource_id .'" >Please wait, updating ...</div>
                                </div>
                            </td>';
                        } ?>

                    </tr></tbody></table></td></tr>
        <?php } ?>


        <?php
        if (  count($rtd_grid_portlets) > 0 && $is_with_rtd_grid_portlet === 1 ) {
            array_push($methods_arr, 'populateRTDGrid' );
            ?>
            <tr><td><table width="100%" cellpadding="2" cellspacing="2" style="border-spacing: 4px;">
                        <tbody class="sortable-subcontent" id="rtd_graph_portlets">
                        <tr>

                            <?php foreach ($resources_list as $resource) {
                                $resource_id = $resource['resource_id'];
                                echo '<td style="width: 50%" ><div class="dragbox" id="itm_rtd_grid_'.$resource_id.'" >
                           <h2>RTD Grid for '. $resource_id . ' with +-3% <span class="maximize">&nbsp;</span></h2>
                           <div id="loader_rtd_grid_'.$resource_id.'" class="loading-msg-container"></div>
                           <div class="dragbox-content" id="content_rtd_grid_'. $resource_id .'" >&nbsp;</div>
                                </div>
                            </td>';
                            } ?>

                        </tr></tbody></table></td></tr>
        <?php } ?>

        <?php
        if (  count($portlets) > 0 ) { ?>
            <tr><td><table width="100%" cellpadding="2" cellspacing="2" style="border-spacing: 4px;">
                        <tbody class="sortable-subcontent" id="other_portlets">
                            <?php
                            $total_portlets =count($portlets);
                            $rows = floor($total_portlets/$column_count);
                            $remainder = $total_portlets % $column_count;
                            if ( $remainder >0 ){
                                $rows++;
                            }

                            $record_index = 0;
                            $total_counter = 1;
                            $col_width = '33';
                            if ($column_count === 2) {
                                $col_width = '50';
                            }
                            for ($row_ctr=0;$row_ctr<$rows;$row_ctr++){
                                echo '<tr>';
                                for ($col_ctr=0;$col_ctr<$column_count;$col_ctr++){
                                    if (  $total_counter > $total_portlets ) {
                                        break;
                                    }else {
                                        $portlet = $portlets[$record_index];
                                        $portlet_name  = $portlet['portlet_name'];
                                        $portlet_title = $portlet['portlet_title'];
                                        $portlet_method = trim($portlet['portlet_method']);

                                        if ( strlen($portlet_method) > 1 ) {
                                            array_push($methods_arr, $portlet['portlet_method'] );
                                        }

                                        echo '<td style="width: '.$col_width.'%" ><div class="dragbox" id="itm_'.$portlet_name.'" style="overflow:auto;">
                                       <h2>'. $portlet_title. '<span class="maximize">&nbsp;</span></h2>
                                       <div id="loader_'.$portlet_name.'" class="loading-msg-container"></div>
                                       <div class="dragbox-content" id="content_'. $portlet_name.'" >&nbsp;</div>
                                            </div>
                                        </td>';

                                        $record_index++;
                                        $total_counter++;

                                    }
                                }
                                echo '</tr>';
                                if (  $total_counter > $total_portlets ) {
                                    break;
                                }
                            }
                            ?>
                        </tbody></table></td></tr>
        <?php } ?>


        </tbody>
        </table>



    <?php }
    ?>





    <input type="hidden" id="rt_current_hour" value="">
    <input type="hidden" id="rt_current_interval" value="">
    <input type="hidden" id="rt_current_timerange" value="">
    <input type="hidden" id="current_date" value="<?php echo date('Y-m-d');?>">
    <hr style="clear:both;" />
</div>
<!--
<script src="js/jquery.ticker.js"></script>
<link rel="stylesheet" href="<?=$base_url?>/css/ticker-style.css" type="text/css" media="screen, projection" />
-->
<script type="text/javascript" src="<?=$base_url?>/js/date.js"></script>
<script src="js/jquery.marquee.js"></script>
<style type="text/css">
    .energy-flash-data {
        background: none repeat scroll 0 0 #455B39;
        border: 1px solid #DDDDDD;
        border-radius: 6px 6px 6px 6px;
        color: #FFFFFF;
        padding: 4px;
        /*    width: 90%;*/
        height: 30px;
    }
    #content-holder {
        margin: 20px;
    }

    #rtd_container {
        background-color: #8BA57C;
        border-radius: 2px 2px 2px 2px;
        color: #EDF7E8;
        display: block;
        font-size: 11px;
        margin-top: 4px;
        padding: 2px;
        height:20px;
        float:left;
        width:82%;
    }

    #radio_rtdrtx {
        width:8%;
        float:left;
        margin-top:4px;
    }

    #radio_sortorder_container {
        width:16%;
        float:left;
        margin-top:4px;
        margin-right:10px;
    }

    .rtdrtx-marquee-controls {
        margin-top : 4px;
        width: 15%;
        float: right;
    }

    .ui-button {
        cursor: pointer;
        display: inline-block;
        margin-right: 0.1em;
        overflow: visible;
        padding: 0;
        position: relative;
        text-align: center;
        text-decoration: none !important;
        background-color: #000000;
    }

    marquee span {
        font-weight: bold;
    }

    .dragbox-content table, dragbox-content-fix-height table {
        border-spacing: 2px;
        margin: 0;
        padding: 0;
    }

    .dragbox-content th, .dragbox-content td {
        background: none repeat scroll 0 0 #F0F2F5;
        border-radius: 3px 3px 3px 3px;
    }
    .dragbox-content tr {
        margin: 2px;
        padding: 2px;
    }

    .energy-flash-data img {
        cursor: pointer;
    }


    table.nodal_prices th {
        border-radius: 3px 3px 3px 3px;
        min-width: 30%;
        font-size: 11px;
        font-weight: bold;
        height: 30px;
        padding: 4px;
        text-align: center;
    }

    table.nodal_prices th:first-child {
        background-color: white;
        border: 0 solid red;
        border-radius: 0 0 0 0;
        min-width: 40%;
    }


    table.nodal_prices td.resource_name {
        background: none repeat scroll 0 0 #CEF9AE;
        color: #3D3D3D;
        font-size: 12px;
        font-weight: bolder;
        letter-spacing: 2px;
        padding: 6px;

    }

    #dashboardportlets .dragbox {
        background: none repeat scroll 0 0 #FFFFFF;
        border: 1px solid #DDDDDD;
        margin: 4px;
        position: relative;
        padding : 2px;
    }

    .sortable-subcontent td {
        vertical-align: top;
    }

    .portlets td{
        padding:0px;
        margin: 0px;
        min-width: 75px;
    }


    th.theader {
        text-align:center;
        background-color:#6897CA !important;
        padding:5px;
        color:#ffffff;
    }
    .theader {
        text-align:center;
    }


    td.cell-totals {
        text-align: right;
        font-weight: bold;
        vertical-align: middle;
        padding: 2px;

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
        background: none repeat scroll 0 0 #EEFFE0;
        border-radius: 3px 3px 3px 3px;
        margin: 10px;
        padding: 4px;
        height: 60px;
        text-align: center;
        vertical-align: middle;
        font-size:20px;
    }

</style>
<link rel="stylesheet" type="text/css" href="<?=$base_url?>/css/styles.css?uniqecall=<?php echo date("YmdHis");?>" />
<link rel="stylesheet" type="text/css" href="css/trontastic-buttonsonly/jquery-ui-1.8.24.custom.css" />
<script src="<?=$base_url?>/js/highcharts.custom.theme.js"></script>
<script type="text/javascript" >
    var CURRENT_SERVER_DATE = '<?php echo date("Y-m-d");?>';
    var RTD_CHARTS = [];
    var chartMap={}; // Initialize empty map
    var dataMap = {};
    var RTD_RTX_FLASH_PLAY = true;
    var RTD_RTX_FLASH_SPEED = 2;

    function sleep(milliseconds) {
        var start = new Date().getTime();
        for (var i = 0; i < 1e7; i++) {
            if ((new Date().getTime() - start) > milliseconds){
                break;
            }
        }
    }

    $.extend({
        getCurrentHourAndInterval : function(){
            $.ajax({
                type: "POST"
                ,url : 'dashboard/dashboard_action'
                ,data: {'action':'get-current-interval-by-rtdvalue', unit:'','is_clicked' : 0}
                ,dataType:'json'
                ,async: false
                ,success: function(data){
                    if (data.total >=0){
                        RTDDate = data.value.rtd_date;
                        $('#rt_current_hour').attr('value',data.value.interval.current_hour);
                        $('#rt_current_interval').attr('value',data.value.interval.interval);
                        $('#rt_current_timerange').attr('value',data.value.interval.start + ' : ' + data.value.interval.end);
                    }
                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    console.log("Error on accessing webservice data " + jqXHR.responseText );
                }
            });
        }

        ,validateServerTimeToIfNeededToGetNewData: function(){
            $.ajax({
                type: "POST"
                ,url : 'dashboard/dashboard_action'
                ,data: {'action':'get-server-datetime'}
                ,dataType:'json'
                ,async: true
                ,success: function(data){
                    var time = data.value.time;
                    var tmp = time.split(':');
                    var min = parseInt(tmp[1],10);

                    if ( min >= 0 && min <= 15) {
                        console.log('minute ' + min + ' try to get new data ');
                        $.updateDataPerChangeOfInterval();
                    }else if ( min >= 50 && min <= 59 ){
                        console.log('minute ' + min + ' try to get new data ');
                        $.updateDataPerChangeOfInterval();
                    }else {
                        console.log('minute ' + min + ' do not get new data ');
                    }


                }
            });
        }
        ,updateDataPerChangeOfInterval : function(){

            $.ajax({
                type: "POST"
                ,url : 'dashboard/dashboard_action'
                ,data: {'action' : 'get-current-interval-by-rtdvalue', unit:''}
                ,dataType:'json'
                ,async: false
                ,success: function(data){

                    var old_current_interval =  parseInt($('#rt_current_interval').val(),10);
                    if (data.total < 1){
                        $("#result").append('<span style="padding:10px">No Data to Display</span>');
                    } else {
                        var new_interval_data =  parseInt(data.value.interval.interval,10);
                        if ( old_current_interval != new_interval_data ) {
                            $('#rt_current_hour').attr('value',data.value.interval.current_hour);
                            $('#rt_current_interval').attr('value',data.value.interval.interval);
                            $('#rt_current_timerange').attr('value',data.value.interval.start + ' : ' + data.value.interval.end);
                            RTDDate = data.value.rtd_date;

                            var is_with_rtdrtx_ticker = parseInt('<?php echo $is_with_rtdrtx_ticker;?>',10);
                            if ( is_with_rtdrtx_ticker === 1 ) {
                                $.populateRtdRtxTicker();
                            }
                            var is_with_rtd_portlet = parseInt('<?php echo $is_with_rtd_portlet;?>',10);
                            if ( is_with_rtdrtx_ticker === 1 ) {
                                $.populateRTD();
                            }

                            var is_with_rtd_grid_portlet = parseInt('<?php echo $is_with_rtd_grid_portlet;?>',10);
                            if ( is_with_rtd_grid_portlet === 1 ) {
                                $.populateRTDGrid();
                            }


                            var is_with_rtems = parseInt('<?php echo $is_with_rtems;?>',10);
                            if ( is_with_rtems === 1 ) {
                                $.updateRTEMData();
                            }

                            var is_with_nodal_prices = parseInt('<?php echo $is_with_nodal_prices;?>',10);
                            if ( is_with_rtems === 1 ) {
                                $.populateNodalPrices();
                            }
                        }
                    }
                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    console.log("Error on accessing webservice data " + jqXHR.responseText );
                }
            });

        }
    });
</script>

<?php
if ( $is_with_rtdrtx_ticker === 1 ) { ?>
    <script type="text/javascript" >
        $.extend({
            populateRtdRtxTicker : function(){
                $('#rtd_container').html('Please wait updating data...');
                var type = $.trim($('input[name=radio_rtdrtx]:checked').val().toUpperCase());
                var action = type === 'RTD' ? 'list-rtd' : 'list-rtx';
                var sort = $.trim($('input[name=radio_sortorder]:checked').val().toLowerCase());
                var sort_dir = 'desc';
                if (sort === 'resource_id'){
                    sort_dir = 'asc';
                }
                var rtdtxt_html = '<marquee id="flash_data" behavior="scroll" direction="left" scrollamount="2" width="100%"><span>';

                $.ajax({
                    type: "POST"
                    ,url : 'dashboard/dashboard_action'
                    ,data: { 'action' : action, 'sort' : sort , 'dir' : sort_dir}
                    ,dataType:'json'
                    ,async: true
                    ,success: function(data){

                        //$('#rtd_container').html(JSON.stringify(data, ' _ '));

                        var resource_list = data.value.data;
                        var current_date = data.value.current_date;
                        var current_interval = data.value.current_interval;
                        var demand_regions = data.value.demands;
                        var type = data.value.type;
                        var resource = null,region=null,resource_id='',region_id='',value =0;
                        var contents = '';
                        contents += '&nbsp;<span style="color:#7AFF49"> '+  type +' | </span>';
                        contents += '&nbsp;<span style="color:#FFF849"> Date : </span>'+ current_date;
                        contents += '&nbsp;<span style="color:#FFF849"> Interval : </span>'+ current_interval;
                        contents += '&nbsp;<span style="color:#FFF849"> Demands  </span>';

                        for (region_id in demand_regions){
                            region = demand_regions[region_id];
                            value = 0;
                            if ( type === 'RTD' ) {
                                value = region['demand_rtd'];
                            }else {
                                value = region['demand_rtx'];
                            }
                            contents += '&nbsp;<span style="color:#D3F23C;">'+ region_id + ' :</span> '+ $.formatNumberToCurrency(parseFloat(value));
                        }

                        contents += '&nbsp;<span style="color:#FFF849"> Prices  </span>';
                        for (resource_id in resource_list){
                            resource = resource_list[resource_id]
                            contents += '&nbsp;<span style="color:#FCAF0A;">'+ resource_id + '</span> : '+ $.formatNumberToCurrency(parseFloat(resource.price));
                        }

                        rtdtxt_html+=contents ;
                        rtdtxt_html+='</span></marquee>';
                        $('#rtd_container').html(rtdtxt_html);


                    }
                    ,error: function(jqXHR, textStatus, errorThrown){
                        console.log("Error on accessing webservice data " + jqXHR.responseText );
                    }
                });

            }
        });
    </script>

<?php } ?>


<?php
if ( $is_with_dan === 1 ) { ?>
    <script type="text/javascript" >
        $.extend({
            populateDANReport : function(){
                $('#loader_dan').html('Please wait updating data...');
                $('#conent_dan').html('').hide();
                $.ajax({
                    type: "POST"
                    ,url : 'dashboard/dashboard_action'
                    ,data: { 'action' : 'list-dan-report'}
                    ,dataType:'json'
                    ,async: true
                    ,success: function(data){
                        var list_data = data.value.nom,
                            trading_date = data.value.trading_date,
                            interval_data = null,
                            row_contents = '',
                            left_index = 1,
                            right_index = 100,
                            list_html = '';

                        list_html = ' <table>';
                        list_html+= '<tr>';
                        list_html+= '<th colspan="2" style="text-align:left;padding:5px;font-weight:bold;" class="tablestyle"> Trading date : '+trading_date+'</th>';
                        list_html+= '</tr>';

                        list_html+= '<tr>';
                        list_html+= '<td style="text-align:center;padding:5px" class="tablestyle">Interval</td>';
                        list_html+= '<td style="text-align:center;padding:5px" class="tablestyle">Nomination (kW)</td>';
                        list_html+= '</tr>';

                        for (var i=1;i<=24;i++){
                            row_contents = '<tr>';
                            row_contents+= '<td class="tablestyle" style="width:125px;padding-left:20px">'
                                + i +' ('+ $.strPad(left_index,4,'0') + 'H'
                                + '-' + $.strPad(right_index,4,'0')   +'H)'
                                + '</td>';


                            var acc_value = 0;
                            var min_value = 0;
                            var nom_value = 0;
                            if ( typeof list_data[i.toString()] != 'undefined') {
                                nom_value = typeof list_data[i.toString()] != 'undefined' ? list_data[i.toString()] : 0;
                            }



                            if ( nom_value == null  ) {
                                nom_value = 0;
                            }


                            nom_value = $.formatNumberToCurrency(parseFloat(nom_value));
                            row_contents+= '<td class="tablestyle" style="background-color:#F2F7B9;padding:12px;min-width: 120px;text-align: right;">&nbsp;'+ nom_value +'</td>'; // nom
                            row_contents+= '</tr>';

                            list_html+= row_contents;

                            left_index = left_index + 100;
                            right_index = right_index + 100;

                        }
                        list_html += '</table>';
                        $('#loader_dan').html('');
                        $('#content_dan').html(list_html).fadeIn("slow");
                        $('#content_dan').addClass('dragbox-content-fix-height');

                    }
                    ,error: function(jqXHR, textStatus, errorThrown){
                        console.log("Error on accessing webservice data " + jqXHR.responseText );
                    }
                });

            }
        });
    </script>

<?php } ?>

<?php
if ( $is_with_rtd_grid_portlet === 1 ) { ?>
    <script type="text/javascript" >
        $.extend({
            populateRTDGrid : function(){
                // get all unit available
                var parameters = { 'action' : 'list-resources-by-plant' , 'plant_id'  : 14 };
                var unit_val = '';
                $.ajax({
                    type: "POST"
                    ,url : 'dashboard/dashboard_action'
                    ,data: parameters
                    ,dataType:'json'
                    ,async: true
                    ,success: function(returnData){
                        var units_array =typeof returnData.value != 'undefined' ? returnData.value : []
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
                        var current_timerange = $('#rt_current_timerange').val();
                        var current_interval = $('#rt_current_interval').val();


                        for (var i=0; i< units_array.length; i++){
                            unit = units_array[i];
                            unit_val = unit.resource_id;

                            cur_rtd_value  = $.getRTDData(current_interval,unit_val,0,0);
                            console.log('cur_rtd_value ' + cur_rtd_value)
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


                            contents = '<table width="100%" class="rtd-grid-table" cellspacing="4" cellpadding="4" style="border-spacing: 4px;">' +
                                '<tr>' +
                                '<td rowspan="2" class="rtd-grid-box">' +
                                '<table width="100%">' +
                                '<tr><td class="rtd-grid-section-title">Current Interval '+ current_interval +' ('+current_timerange+'H)</td></tr>' +
                                '<tr><td class="rtd-grid-section-data" style="height:180px;">'+ cur_rtd_formatted_val + ' MW</td></tr>' +
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

                            $('#content_rtd_grid_'+unit_val).html(contents);
                        }
                    }
                    ,error: function(jqXHR, textStatus, errorThrown){
                        console.log("Error on accessing webservice data " + jqXHR.responseText );
                    }
                });

            }
        });
    </script>

<?php } ?>

<?php
if ( $is_with_bcq_rep === 1 ) { ?>
    <script type="text/javascript" >
        $.extend({
            populateBcqReport : function(){
                $('#loader_bcq_report').html('Please wait updating data...');
                $('#conent_bcq_report').html('').hide();
                $.ajax({
                    type: "POST"
                    ,url : 'dashboard/dashboard_action'
                    ,data: { 'action' : 'list-bcq-report'}
                    ,dataType:'json'
                    ,async: true
                    ,success: function(data){

                        var end_date_val = data.value.end_date;
                        var start_date_val = data.value.start_date;
                        var start_date = Date.parse(start_date_val);
                        var end_date = Date.parse(end_date_val);
                        var loop_date = start_date.clone();
                        var html = '<table><tr><th class="theader">Interval</th>';
                        var loop_date_string = '', date_int_val = '',bcq_date_data = null, bcq_date_interval_data = null, int_bcq_date_interval_val=0;
                        var bcq_data = data.value.data;
                        var bcq_totals = {}, total =0;
                        var total_html = '<tr><th class="theader total-header">Total</th>';
                        while (loop_date<=end_date){
                            loop_date_string = loop_date.toString("d-MMM-yyyy");
                            html+='<th class="theader">'+loop_date_string+'</th>'
                            loop_date = loop_date.add(1).days();
                        }

                        for (var i=1;i<=24;i++){
                            html+='<tr><th class="theader">' + i + '</th>';
                            total = 0;
                            loop_date = start_date.clone();
                            while (loop_date<=end_date){
                                loop_date_string = loop_date.toString("yyyy-MM-dd");
                                date_int_val = '&nbsp;';
                                int_bcq_date_interval_val = 0;
                                if ( typeof bcq_data[loop_date_string] != 'undefined' ) {
                                    bcq_date_data = bcq_data[loop_date_string];
                                    if ( typeof bcq_date_data['hour'+i] != 'undefined' ) {
                                        bcq_date_interval_data = bcq_date_data['hour'+i];
                                        if ( bcq_date_interval_data != null ) {
                                            date_int_val = $.formatNumberToSpecificDecimalPlaces(parseFloat(bcq_date_interval_data),3)  ;
                                            int_bcq_date_interval_val = parseFloat(bcq_date_interval_data);
                                        }
                                    }
                                }

                                var cur_total = typeof bcq_totals[loop_date_string] != 'undefined' ? bcq_totals[loop_date_string] : 0;
                                total = cur_total + int_bcq_date_interval_val;
                                bcq_totals[loop_date_string] = total;
                                html+='<td style="text-align:right;padding:2px;">'+date_int_val+'</td>'
                                loop_date = loop_date.add(1).days();
                            }
                            html+='</tr>';
                        }

                        loop_date = start_date.clone();
                        while (loop_date<=end_date){
                            loop_date_string = loop_date.toString("yyyy-MM-dd");
                            var cur_total = typeof bcq_totals[loop_date_string] != 'undefined' ? bcq_totals[loop_date_string] : 0;
                            total_html+='<td class="cell-totals">'+ $.formatNumberToCurrency(cur_total)+'</td>'
                            loop_date = loop_date.add(1).days();
                        }
                        total_html+='</tr>';

                        $('#loader_bcq_report').html('');
                        $('#content_bcq_report').html(html+total_html+'</table>').fadeIn("slow");
                        $('#content_bcq_report').addClass('dragbox-content-fix-height');



                    }
                    ,error: function(jqXHR, textStatus, errorThrown){
                        console.log("Error on accessing webservice data " + jqXHR.responseText );
                    }
                });

            }
        });
    </script>

<?php } ?>


<?php
if ( $is_with_nom_rep === 1 ) { ?>
    <script type="text/javascript" >
        $.extend({
            populateNomReport : function(){
                $('#loader_nomination_report').html('Please wait updating data...');
                $('#content_nomination_report').html('').hide();
                $.ajax({
                    type: "POST"
                    ,url : 'dashboard/dashboard_action'
                    ,data: { 'action' : 'list-nom-report'}
                    ,dataType:'json'
                    ,async: true
                    ,success: function(data){
                        var end_date_val = data.value.end_date;
                        var start_date_val = data.value.start_date;
                        var start_date = Date.parse(start_date_val);
                        var end_date = Date.parse(end_date_val);
                        var loop_date = start_date.clone();
                        var html = '<table><tr><th class="theader">Interval</th>';
                        var loop_date_string = '', date_int_val = '',nom_date_data = null, nom_date_interval_data = null, int_nom_date_interval_val=0;
                        var nom_data = data.value.data;
                        var nom_totals = {}, total =0;
                        var total_html = '<tr><th class="theader total-header">Total</th>';
                        while (loop_date<=end_date){
                            loop_date_string = loop_date.toString("d-MMM-yyyy");
                            html+='<th class="theader">'+loop_date_string+'</th>'
                            loop_date = loop_date.add(1).days();
                        }

                        for (var i=1;i<=24;i++){
                            html+='<tr><th class="theader">' + i + '</th>';
                            total = 0;
                            loop_date = start_date.clone();
                            while (loop_date<=end_date){
                                loop_date_string = loop_date.toString("yyyy-MM-dd");
                                date_int_val = '&nbsp;';
                                int_nom_date_interval_val = 0;
                                if ( typeof nom_data[i] != 'undefined' ) {
                                    nom_date_interval_data = nom_data[i];
                                    if ( typeof nom_date_interval_data[loop_date_string] != 'undefined' ) {
                                        nom_date_data = nom_date_interval_data[loop_date_string];
                                        if ( nom_date_data != null ) {
                                            if ( isNaN(parseFloat(nom_date_data)) ) {
                                                // nothing
                                            }else {
                                                date_int_val = $.formatNumberToCurrency(parseFloat(nom_date_data))  ;
                                                int_nom_date_interval_val = parseFloat(nom_date_data);
                                            }

                                        }
                                    }
                                }

                                var cur_total = typeof nom_totals[loop_date_string] != 'undefined' ? nom_totals[loop_date_string] : 0;
                                total = cur_total + int_nom_date_interval_val;
                                nom_totals[loop_date_string] = total;
                                html+='<td style="text-align:right;padding:2px;">'+date_int_val+'</td>'
                                loop_date = loop_date.add(1).days();
                            }
                            html+='</tr>';
                        }

                        loop_date = start_date.clone();
                        while (loop_date<=end_date){
                            loop_date_string = loop_date.toString("yyyy-MM-dd");
                            var cur_total = typeof nom_totals[loop_date_string] != 'undefined' ? nom_totals[loop_date_string] : 0;
                            total_html+='<td class="cell-totals">'+ $.formatNumberToCurrency(cur_total)+'</td>'
                            loop_date = loop_date.add(1).days();
                        }
                        total_html+='</tr>';


                        $('#loader_nomination_report').html('');
                        $('#content_nomination_report').html(html+total_html+'</table>').fadeIn("slow");
                        $('#content_nomination_report').addClass('dragbox-content-fix-height');



                    }
                    ,error: function(jqXHR, textStatus, errorThrown){
                        console.log("Error on accessing webservice data " + jqXHR.responseText );
                    }
                });

            }
        });
    </script>

<?php } ?>


<?php
if ( $is_with_template_download === 1 ) { ?>
    <script type="text/javascript" >
        $.extend({
            populateTemplateDownload : function(){
                $('#loader_nomination_template').html('Please wait updating data...');
                var dan = '<?php echo $dan;?>';
                var wan = '<?php echo $wan;?>';
                var man = '<?php echo $man;?>';
                var default_date= '<?php echo $default_date;?>';
                var customer_filename = '<?php echo str_replace(' ','_', $customer_name);?>';
                customer_filename.replace(/ /gi, "_");

                var contents = '<input type="hidden" id="hDAN" value="'+ dan +'" >';
                contents+= '<input type="hidden" id="hWAN" value="'+ wan +'" />'
                contents+= '<input type="hidden" id="hMAN" value="'+man+'" />';
                contents+= '<table><tr><th width="150px">Date</th>' +
                    '<td>   ' +
                    '<input type="hidden" id="sdate" name="sdate" value="'+ default_date +'">' +
                    '<input style="width:200px" type="text" id="dateval" value="'+ default_date +'" disabled="disabled" />' +
                    '</td></tr>' +
                    '<tr><th>Templates</th>' +
                    '<td>' +
                    '<ul style="list-style: none; padding: 0px;"><li><input type="radio" value="DAN" name="template_type_rdo" checked="true">Day Ahead Nomination</li>' +
                    '<li><input type="radio" value="WAN" name="template_type_rdo" >Week Ahead Nomination</li>' +
                    '<li><input type="radio" value="MAN" name="template_type_rdo" >Month Ahead  Nomination</li>' +
                    '</ul></td></tr>' +
                    '<tr>' +
                    '<th>&nbsp;</th><td><span id="filename">' + customer_filename +'Nomination_' +
                    '<span id="type">DAN</span>_[<span id="date">'+ dan +'</span>].xlsx</span>' +
                    '<button id="btn_download" type="button">Download</button></td>' +
                    '</tr></table>';

                $('#loader_nomination_template').html('');
                $('#content_nomination_template').html(contents)

                $("input[name='template_type_rdo']").click(function(){
                    var type=$(this).val();
                    $('#type').html(type);
                    $('#date').html($('#h' + type).val());

                    if(type=='DAN'){
                        $('#dateval').val('<?php echo $default_date ?>');
                    }else if(type=='WAN'){
                        $('#dateval').val('<?php echo date("m/d/Y",strtotime($def_date_wan_start)).' - '. date("m/d/Y",strtotime($def_date_wan_end))?>');
                    }else if(type=='MAN'){
                        $('#dateval').val('<?php echo date("m/d/Y",strtotime($def_date_man_start)).' - '. date("m/d/Y",strtotime($def_date_man_end))?>');
                    }
                })

                $('#btn_download').unbind('click').live('click',function(e){
                    e.preventDefault();
                    var type = $('input[name="template_type_rdo"]:checked').val();
                    $.downloadTemplate(type);

                });
            }
            ,downloadTemplate : function(type){
                var url = 'http://' + location.host + '<?=$base_url?>' + '/buyer/file_nom_templates'
                var parameters = "sdate=" + $('#sdate').val()+"&filename="+$('#filename').text() + '&type='+type;
                $.download(url,parameters);
            }
        });
    </script>

<?php } ?>


<?php
    if ( $is_with_sysmsg_portlet === 1 ) { ?>
        <script type="text/javascript" >
            $.extend({
                populateSystemMessages : function(){
                    $.ajax({
                        type: "POST"
                        //,url : 'mms_data/rep_sys_mes_action'
                        ,url : 'dashboard/dashboard_action'
                        ,data: { 'action': 'list-system-messages', 'sdate' : CURRENT_SERVER_DATE, 'edate' : CURRENT_SERVER_DATE}
                        ,dataType:'json'
                        ,timeout : 30000
                        ,async: true
                        ,success: function(data){
                            //$('#content_system_messages').html(JSON.stringify(data,''));
                            var is_populate = true;
                            if ( typeof dataMap['system_messages'] != 'undefined' ) {
                                $('#loader_system_messages').html('Updating data <img src="images/ajax-loader.gif" />');
                                var diff = $.compareJsonObjects(dataMap['system_messages'],data);
                                if (diff.length === 0) {
                                    is_populate = false;
                                }
                            }
                            if ( is_populate ) {

                                var html = '<tr><th width="120px">Date</th><th>Details</th></tr>';
                                if ( data.total ) {
                                    dataMap['system_messages'] = data;
                                    var x=1;
                                    $.each(data.value,function(i,val){
                                        var bg;
                                        x++;
                                        if ( x % 2 === 0 ) bg = '#F0F2F5';
                                        else bg = '#FFFFFF';

                                        html+='<tr><td style="color:'+val.urgency+';background:'+bg+'">'+val.date+'</td><td style="color:'+val.urgency+';background:'+bg+'">'+val.message+'</td></tr>'
                                    })


                                    $('#content_system_messages').addClass('dragbox-content-fix-height');
                                    $('#content_system_messages').html('<table id="grid"></table>');
                                    $('#grid').html(html);
                                } else {
                                    $('#content_system_messages').html('No available records');
                                }
                            }
                            $('#loader_system_messages').html('');

                            var refreshId = setInterval(function(){
                                $.populateSystemMessages();
                            },  600000 );

                        }
                        ,error: function(jqXHR, textStatus, errorThrown){
                            console.log("Error on accessing webservice data " + jqXHR.responseText );
                        }
                    });
                }
            });
        </script>

<?php } ?>


<?php
if ( $is_with_rtems === 1 ) { ?>
    <script type="text/javascript" >
        $.extend({
            populateRTEMBidsAndOffers : function(){

                $('#content_rtem_bids_offer').html('Updating ...');
                $.ajax({
                    type: "POST"
                    ,url : 'dashboard/dashboard_action'
                    ,data: { 'action' : 'list-bids'}
                    ,dataType:'json'
                    ,async: true
                    ,success: function(data){
                        var content = '';
                        $.each(data.value, function(res, val) {
                            $.each(val, function(d, date){
                                $.each(date, function(i,intervals){
                                    var interval1 = (intervals.price1 !== null) ? intervals.price1.toFixed(2) : '';
                                    var interval2 = (intervals.price2 !== null) ? intervals.price2.toFixed(2) : '';
                                    var interval3 = (intervals.price3 !== null) ? intervals.price3.toFixed(2) : '';
                                    var interval4 = (intervals.price4 !== null) ? intervals.price4.toFixed(2) : '';
                                    var interval5 = (intervals.price5 !== null) ? intervals.price5.toFixed(2) : '';
                                    var interval6 = (intervals.price6 !== null) ? intervals.price6.toFixed(2) : '';
                                    var interval7 = (intervals.price7 !== null) ? intervals.price7.toFixed(2) : '';
                                    var interval8 = (intervals.price8 !== null) ? intervals.price8.toFixed(2) : '';
                                    var interval9 = (intervals.price9 !== null) ? intervals.price9.toFixed(2) : '';
                                    var interval10 = (intervals.price10 !== null) ? intervals.price10.toFixed(2) : '';
                                    var interval11 = (intervals.price11 !== null) ? intervals.price11.toFixed(2) : '';

                                    content+='<tr><td>'+d+'</td><td>'+i+'</td><td>'+res+'</td>';

                                    content+='<td>'+interval1+'</td><td>'+intervals.qty1+'</td>';
                                    content+='<td>'+interval2+'</td><td>'+intervals.qty2+'</td>';
                                    content+='<td>'+interval3+'</td><td>'+intervals.qty3+'</td>';
                                    content+='<td>'+interval4+'</td><td>'+intervals.qty4+'</td>';
                                    content+='<td>'+interval5+'</td><td>'+intervals.qty5+'</td>';
                                    content+='<td>'+interval6+'</td><td>'+intervals.qty6+'</td>';
                                    content+='<td>'+interval7+'</td><td>'+intervals.qty7+'</td>';
                                    content+='<td>'+interval8+'</td><td>'+intervals.qty8+'</td>';
                                    content+='<td>'+interval9+'</td><td>'+intervals.qty9+'</td>';
                                    content+='<td>'+interval10+'</td><td>'+intervals.qty10+'</td>';
                                    content+='<td>'+interval11+'</td><td>'+intervals.qty11+'</td>';
                                    content+='<td>'+intervals.rr_up1+'</td><td>'+intervals.rr_down1+'</td><td>'+intervals.rr_bp1+'</td>';
                                    content+='<td>'+intervals.rr_up2+'</td><td>'+intervals.rr_down2+'</td><td>'+intervals.rr_bp2+'</td>';
                                    content+='<td>'+intervals.rr_up3+'</td><td>'+intervals.rr_down3+'</td><td>'+intervals.rr_bp3+'</td>';
                                    content+='<td>'+intervals.rr_up4+'</td><td>'+intervals.rr_down4+'</td><td>'+intervals.rr_bp4+'</td>';
                                    content+='<td>'+intervals.rr_up5+'</td><td>'+intervals.rr_down5+'</td><td>'+intervals.rr_bp5+'</td>';
                                    content+='<td>'+intervals.rr_up6+'</td><td>'+intervals.rr_down6+'</td><td>'+intervals.rr_bp6+'</td>';
                                    content+='<td>'+intervals.reason+'</td>';
                                    content+='</tr>';
                                })
                            })
                        })

                        var html='<tr><td>Del&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
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
                        $('#content_rtem_bids_offer').html('<table>'+ html +'</table>');
                        $('#content_rtem_bids_offer').addClass('dragbox-content-fix-height');

                        //$('#content_rtem_bids_offer').html(JSON.stringify(data,''));
                    }
                    ,error: function(jqXHR, textStatus, errorThrown){
                        console.log("Error on accessing webservice data " + jqXHR.responseText );
                    }
                });
            }
            ,updateRTEMData : function(){

                $('#content_rtem_bids_offer').html('Getting Latest Bid from MMS...');
                $.ajax({
                    type: "POST"
                    ,url : 'mms_data/rep_latest_bids'
                    ,data: {}
                    ,dataType:'json'
                    ,async: true
                    ,success: function(data){
                        $.populateRTEMBidsAndOffers();
                    }
                    ,error: function(jqXHR, textStatus, errorThrown){
                        console.log("Error on accessing webservice data " + jqXHR.responseText );
                    }
                });
            }
        });
    </script>

<?php } ?>


<?php
if ( $is_with_nodal_prices === 1 ) { ?>
    <script type="text/javascript" >
        $.extend({
            populateNodalPrices : function(){

                $('#content_nodal_prices').html('Updating ...');
                $.ajax({
                    type: "POST"
                    ,url : 'dashboard/dashboard_action'
                    ,data: { 'action' : 'list-prices-hour-specific'}
                    ,dataType:'json'
                    ,async: true
                    ,success: function(data){
                        var current_date = '<?php echo date("Ymd");?>';
                        if ( typeof data.value != 'undefined' ) {
                            var resources_data =  data.value;
                            var current_hour = parseInt($('#rt_current_hour').val(),10);
                            var previous_hour = current_hour == 0 ? 23 :( current_hour -1 );
                            /*if ( current_hour === 1 ) {
                                previous_hour = 24;
                            }else if ( current_hour === 0  ){
                                previous_hour = 23;
                            }else {
                                previous_hour = current_hour -1 ;
                            }*/

                            if ( current_hour === 0 ) {
                                current_hour = 24;
                            }

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
                            var resource_id = '', resource = null;
                            var prev_rtd = ''; cur_rtd = '';
                            var prev_rtx = ''; cur_rtx = '';

                            var contents = '<table width="100%" class="nodal_prices">' +
                                '<tr><th>&nbsp;</th>' +
                                '<th>Hour ' + previous_hour + '</th>' +
                                '<th>Hour ' + current_hour + '</th>' +
                                '</tr>' ;
                            for (resource_id in resources_data){
                                contents+='<tr><td colspan="3" class="resource_name">'+  resource_id +'</td></tr> ';
                                resource = resources_data[resource_id];
                                prev_rtd = '&nbsp;';
                                cur_rtd = '&nbsp;';
                                prev_rtx = '&nbsp;';
                                cur_rtx = '&nbsp;';

                                if ( typeof resource[previous_hour] != 'undefined' ) {
                                    prev_rtd = $.formatNumberToCurrency(parseFloat(resource[previous_hour].rtd_price));
                                    prev_rtx = $.formatNumberToCurrency(parseFloat(resource[previous_hour].rtx_price));
                                }

                                if ( typeof resource[current_hour] != 'undefined' ) {
                                    cur_rtd = $.formatNumberToCurrency(parseFloat(resource[current_hour].rtd_price));
                                    cur_rtx = $.formatNumberToCurrency(parseFloat(resource[current_hour].rtx_price));
                                }

                                contents += '<tr><td>RTD</td>' +
                                    '<td>'+ prev_rtd + '</td>' +
                                    '<td>'+ cur_rtd + '</td></tr>';

                                contents += '<tr><td>RTX</td>' +
                                    '<td>'+ prev_rtx + '</td>' +
                                    '<td>'+ cur_rtx + '</td></tr>';


                            }
                            $('#content_nodal_prices').html(contents+'</table>');
                        }else {
                            $('#content_nodal_prices').html('No data available');
                        }
                        $('#content_nodal_prices').removeClass('dragbox-content-fix-height');

                        /*$('#content_nodal_prices').html(JSON.stringify(data,''));*/
                    }
                    ,error: function(jqXHR, textStatus, errorThrown){
                        console.log("Error on accessing webservice data " + jqXHR.responseText );
                    }
                });
            }
            ,maximizeNodalPrices : function(){
                $('#content_nodal_prices').html('Updating ...');
                $.ajax({
                    type: "POST"
                    ,url : 'dashboard/dashboard_action'
                    ,data: { 'action' : 'list-prices'}
                    ,dataType:'json'
                    ,async: true
                    ,success: function(data){

                        var series=[];
                        var obj = {};
                        var content;
                        var total_html;
                        var total_rtd={};
                        var total_rtx={};
                        var total_rtd_html;
                        var total_rtx_html;
                        var total_rtd_cnt=[];
                        var total_rtx_cnt=[];
                        var rtd_price_int = 0,rtx_price_int= 0,rtd_price = 0,rtx_price=0;

                        $.each(data.value, function(i, val) {
                            $.each(val, function(i1, val2) {
                                var rtd_content;
                                var rtx_content;
                                content+='<tr class="rtd"><td>'+i+'</td><td rowspan="2" style="vertical-align:middle"><b>'+i1+'</b></td><td>RTD</td>';
                                for(x=1;x<=24;x++) {

                                    if (typeof val2[x] !== 'undefined') {
                                        rtd_price_int = val2[x].rtd_price;
                                        rtx_price_int = val2[x].rtx_price;
                                    } else {
                                        rtd_price_int = 0;
                                        rtx_price_int = 0;
                                    }

                                    //rtd_price = $.formatNumber(rtd_price_int, options);
                                    //rtx_price = $.formatNumber(rtx_price_int, options);

                                    rtd_price = rtd_price_int
                                    rtx_price = rtx_price_int

                                    rtd_content+= '<td>'+rtd_price+'</td>';
                                    if ( total_rtd[x] ) {
                                        total_rtd[x] = rtd_price_int + total_rtd[x];
                                        total_rtd_cnt[x]++;
                                    } else {
                                        total_rtd[x] = rtd_price_int;
                                        total_rtd_cnt[x] = 1;
                                    }

                                    if ( total_rtx[x] ) {
                                        total_rtx[x] = rtx_price_int + total_rtx[x];
                                        total_rtx_cnt[x]++;
                                    } else {
                                        total_rtx[x] = rtx_price_int
                                        total_rtx_cnt[x] = 1;
                                    }
                                    rtx_content+= '<td>'+rtx_price+'</td>';
                                }

                                content+=rtd_content;
                                content+='</tr><tr class="rtx"><td>'+i+'</td><td>RTX</td>';
                                content+=rtx_content;
                                content+='</tr>';
                            })
                        })

                        var html = '<tr><th>Date</th><th>Resource ID</th><th>Type</th><th>H1</th><th>H2</th><th>H3</th><th>H4</th><th>H5</th><th>H6</th><th>H7</th><th>H8</th><th>H9</th><th>H10</th><th>H11</th><th>H12</th><th>H13</th><th>H14</th><th>H15</th><th>H16</th><th>H17</th><th>H18</th><th>H19</th><th>H20</th><th>H21</th><th>H22</th><th>H23</th><th>H24</th></tr>'
                        var total = '<tr class="rtd"><td rowspan="2" colspan="2" style="vertical-align:middle"><b>Average</b></td><td>RTD</td>';

                        $.each(total_rtd,function(i, val){
                            var avg = val / total_rtd_cnt[i]
                            total_rtd_html+= '<td>'+avg+'</td>';
                        })

                        $.each(total_rtx,function(i, val){
                            var avg = val / total_rtx_cnt[i]
                            //avg.toFixed(2);
                            total_rtx_html+= '<td>'+avg+'</td>';
                        })
                        total+=total_rtd_html;
                        total+='</tr><tr class="rtx"><td>RTX</td>';
                        total+=total_rtx_html;
                        total+='</tr>';


                        $('#content_nodal_prices').html('<table id="grid_nodal">'+ html +'</table>');
                        $('#content_nodal_prices').addClass('dragbox-content-fix-height');

                        $("#grid_nodal").html(html)
                        $("#grid_nodal").append(content)

                    }
                    ,error: function(jqXHR, textStatus, errorThrown){
                        console.log("Error on accessing webservice data " + jqXHR.responseText );
                    }
                });

            }
            ,columnmizeNodalPrices : function(){
                $.populateNodalPrices();
            }
        });
    </script>

<?php } ?>

<?php
if ( $is_with_rtd_portlet === 1 ) { ?>
    <script type="text/javascript" >
        $.extend({
            getDigCtrlSysData: function(hour,unit){
                var dcs = null ;
                var parameters = { 'action' : 'get-dcs' , 'unit'  : unit , 'hour' : hour  };
                $.ajax({
                    type: "POST"
                    ,url : 'dashboard/dashboard_action'
                    ,data: parameters
                    ,dataType:'json'
                    ,async: false
                    ,success: function(returnData){
                        dcs =typeof returnData.value != 'undefined' ? returnData.value : null
                    }
                    ,error: function(jqXHR, textStatus, errorThrown){
                        console.log("Error on accessing webservice data " + jqXHR.responseText );
                    }
                });
                return dcs;

            }
            ,getRTDData : function(hour,unit,is_next_date,is_previous_date){
                var rtd = null ;
                var parameters = { 'action' : 'get-rtd' , 'unit'  : unit , 'hour' : hour , 'is_next_date' : is_next_date, 'is_previous_date' : is_previous_date  };
                $.ajax({
                    type: "POST"
                    ,url : 'dashboard/dashboard_action'
                    ,data: parameters
                    ,dataType:'json'
                    ,async: false
                    ,success: function(returnData){
                        rtd =typeof returnData.value != 'undefined' ? returnData.value.rtd : null
                    }
                    ,error: function(jqXHR, textStatus, errorThrown){
                        console.log("Error on accessing webservice data " + jqXHR.responseText );
                    }
                });
                return rtd;
            }
            ,updateChartDCSData : function(hour,series_data,chart_elm,unit){
                var hour_str = parseInt(hour,10), chart_point_id ='', chart_point = null, series_value = null;
                var chart=chartMap[chart_elm];
                for (var ii=1;ii<=59;ii+=5){
                    series_value = null;
                    chart_point_id = 'unit_'+unit+'_time_' + $.strPad(hour_str,2,'0') + $.strPad(ii.toString(),2,'0');
                    chart_point = chart.get( chart_point_id );
                    if ( typeof series_data[hour_str] != 'undefined' ) {
                        if ( typeof series_data[hour_str]['mn_'+ii]  != 'undefined' ) {
                            series_value = parseFloat(series_data[hour_str]['mn_'+ii]);
                        }
                        chart_point.update(series_value, false);
                    }

                }

                chart.redraw();
            } //eof
            ,createRTDUnitChart : function(containerElm,unit){

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

                var resource_name = unit , is_aggregate_resources = false;
                for( var h=0;h<hour_series.length;h++ ) {
                    loop_hr = hour_series[h];

                    x_categories.push($.strPad(loop_hr,2,'0')+': ' + $.strPad('0',2,'0'));
                    data_series_id = 'unit_'+unit+'_time_' + $.strPad(loop_hr,2,'0') + $.strPad('0',2,'0');
                    series_data.push({ 'id':data_series_id, 'y' : null });

                    for (var ii=1;ii<=59;ii+=5){
                        x_categories.push($.strPad(loop_hr,2,'0')+': ' + $.strPad(ii,2,'0'));
                        data_series_id = 'unit_'+unit+'_time_' + $.strPad(loop_hr,2,'0') + $.strPad(ii.toString(),2,'0');
                        series_data.push({ 'id':data_series_id, 'y' : null });
                    }
                }
                x_categories.push($.strPad(next_hour,2,'0')+': ' + $.strPad('0',2,'0'));
                data_series_id = 'unit_'+unit+'_time_' + $.strPad(next_hour,2,'0') + $.strPad('0',2,'0');
                series_data.push({ 'id':data_series_id, 'y' : null });


                // create the rtd series data
                var rtd_x_axis = 0;
                var rtd_series_data = [];
                var rtd_hour_series = [previous_hour,current_hour,next_hour];
                var cur_rtd_value = null, cur_loop_hr = null;
                for (var c=0;c<rtd_hour_series.length;c++){
                    cur_loop_hr = rtd_hour_series[c];
                    if ( c=== 0) {
                        cur_rtd_value = $.getRTDData(cur_loop_hr,unit,0,is_previous_date);
                    }else if ( c === 1 ){
                        cur_rtd_value = $.getRTDData(cur_loop_hr,unit,0,is_current_hour_previous_date);
                    }else {
                        cur_rtd_value = $.getRTDData(cur_loop_hr,unit,is_next_hour_next_day_date,0);
                    }
                    rtd_series_data.push({ x : rtd_x_axis, y : cur_rtd_value, hour : cur_loop_hr });
                    rtd_x_axis = rtd_x_axis + 13;
                }

                var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
                var unit_chart = new Highcharts.Chart({
                    chart: {
                        renderTo: containerElm
                        ,borderColor: '#D8D6D6'
                        ,borderWidth: 1
                        ,borderRadius: 2
                    },
                    reflow: true
                    ,title: {
                        text: unit ,
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
                        ,max: 350
                        ,min : 0
                        ,tickInterval: 50
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
                            ,name:  'Actual Load Unit ' + unit
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
                                radius: 5
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
                chartMap[unit_chart.renderTo.id]=unit_chart;
            }
            ,populateRTD : function(){
                // get all unit available
                var parameters = { 'action' : 'list-resources-by-plant' , 'plant_id'  : 14 };
                var unit_val = '';
                $.ajax({
                    type: "POST"
                    ,url : 'dashboard/dashboard_action'
                    ,data: parameters
                    ,dataType:'json'
                    ,async: true
                    ,success: function(returnData){
                        var units_array =typeof returnData.value != 'undefined' ? returnData.value : []
                            ,options_html = ""
                            ,unit = null
                            ,aggregate_options = ''
                            ,chart_container = '';


                        for (var i=0; i< units_array.length; i++){
                            unit = units_array[i];
                            unit_val = unit.resource_id;
                            chart_container = 'chart_elm_'+unit_val;
                            $('#content_rtd_graph_'+unit_val).html('');
                            $('#content_rtd_graph_'+unit_val).append('<div id="'+ chart_container +'"></div><br/>');


                            $.createRTDUnitChart(chart_container,unit_val);

                            // update chart plots
                            var current_hour = parseInt($('#rt_current_hour').val(),10);
                            var previous_hour = current_hour == 0 ? 23 :( current_hour -1 );
                            var prev_dcs = $.getDigCtrlSysData(previous_hour,unit_val);
                            var current_dcs = $.getDigCtrlSysData(current_hour,unit_val);

                            $.updateChartDCSData(previous_hour,prev_dcs,chart_container,unit_val);
                            $.updateChartDCSData(current_hour,current_dcs,chart_container,unit_val);
                        }
                    }
                    ,error: function(jqXHR, textStatus, errorThrown){
                        console.log("Error on accessing webservice data " + jqXHR.responseText );
                    }
                });
            }
        });
    </script>

<?php } ?>

<script type="text/javascript">
    RTDDate = '';
    $(document).ready(function() {
        $.getCurrentHourAndInterval();
        var container_width = $(document).width() - 100;
        $('#content-holder').css('width',container_width+'px');

        var col_count = parseInt('<?php echo $column_count;?>',10);
        var width_ = ($(document).width()-140)/col_count;
        $('#other_portlets div.dragbox').css('width',width_+'px');
        width_ = ($(document).width()-140)/2;
        $('#rtd_graph_portlets div.dragbox').css('width',width_+'px');


        $('.dragbox h2').unbind().live('click',function(e){
            $(this).siblings('.dragbox-content').toggle();
        });

        $('.dragbox h2 .maximize').unbind().live('click',function(e){
            var column_elm = $(this).parent().parent().attr('id');
            var container = $(this).parent().parent().attr('id');
            var title_text = $.trim($(this).parent().text().toUpperCase());
            var is_rtd = title_text.indexOf('RTD GRAPH') >= 0 ? true : false;
            var is_nodal_prices = title_text === 'NODAL PRICES' ? true : false;
            $(this).removeClass('maximize');
            $(this).addClass('columnmize');

            $('.sortable-content>tr>td').hide();
            $('.sortable-subcontent>tr>td').hide();

            $(this).parent().parent().parent().parent().parent().parent().parent().show();
            $(this).parent().parent().parent().show();

            $('#'+container).show('slow',function(){
                var column_elm = $(this).attr('id');
                var container_width = $(document).width() - 120
                    ,chart_width = container_width-30;
                $('#'+container).css('width',container_width+'px');

                // if rtd , change the charts sizes
                if ( is_rtd ) {
                    var resource_id = $.trim(column_elm.replace(/itm_rtd_graph_/gi, ""));
                    var chart_elm = ''
                        ,chart = chartMap['chart_elm_'+resource_id];

                    chart.setSize(chart_width, 400, true);

                }

                if (is_nodal_prices) {
                    $.maximizeNodalPrices();
                }

                $('#'+container + ' .dragbox-content').show();
            });

            e.stopPropagation();
        });


        $('.dragbox h2 .columnmize').unbind().live('click',function(e){
            var column_elm = $(this).parent().parent().parent().attr('id');
            var container = $(this).parent().parent().attr('id');
            var title_text = $.trim($(this).parent().text().toUpperCase());
            var is_rtd = title_text.indexOf('RTD GRAPH') >= 0 ? true : false;
            var is_nodal_prices = title_text === 'NODAL PRICES' ? true : false;
            $(this).removeClass('columnmize');
            $(this).addClass('maximize');


            $('.sortable-content td').show();
            $(this).parent().parent().parent().parent().parent().parent().parent().show();
            $(this).parent().parent().parent().show();

            $('#'+container).show('slow',function(){
                var column_elm = $(this).attr('id');
                var container_width = $(document).width() - 120
                    ,chart_width = (container_width/2)-20;

                // if rtd , change the charts sizes
                if ( is_rtd ) {
                    var resource_id = $.trim(column_elm.replace(/itm_rtd_graph_/gi, ""));
                    var chart_elm = ''
                        ,chart = chartMap['chart_elm_'+resource_id];
                    chart.setSize(chart_width, 400, true);
                }

                if (is_nodal_prices) {
                    $.columnmizeNodalPrices();
                }

                $('#'+container + ' .dragbox-content').show();

                var col_count = parseInt('<?php echo $column_count;?>',10);
                var width_ = ($(document).width()-140)/col_count;
                $('#other_portlets div.dragbox').css('width',width_+'px');
                width_ = ($(document).width()-140)/2;
                $('#rtd_graph_portlets div.dragbox').css('width',width_+'px');

                //$('#'+container).removeAttr('style');
            });
            e.stopPropagation();

        });


        var cnt_methods = parseInt('<?php echo count($methods_arr); ?>');
        if ( cnt_methods > 0 ) {
            var methods = $.trim('<?php echo implode(",", $methods_arr); ?>');
            if (  methods.length > 0 ) {
                var methods_arr = methods.split(',');
                var is_with_rtdrtx_ticker = parseInt('<?php echo isset($is_with_rtdrtx_ticker) ? $is_with_rtdrtx_ticker : 0;?>',10);
                if ( is_with_rtdrtx_ticker === 1 ) {


                    $( "#radio_rtdrtx" ).buttonset();
                    $( "#radio_sortorder" ).buttonset();

                    $('input[name=radio_rtdrtx]').unbind().bind('change',function(){
                        $.populateRtdRtxTicker();
                    });

                    $('input[name=radio_sortorder]').unbind().bind('change',function(){
                        $.populateRtdRtxTicker();
                    });

                    $('#pause_flash_data').unbind().bind('click',function(){
                        if (RTD_RTX_FLASH_PLAY ) {
                            RTD_RTX_FLASH_PLAY = false;
                            $('#flash_data').trigger('stop');
                        }else {
                            RTD_RTX_FLASH_PLAY = true;
                            $('#flash_data').trigger('start');
                        }
                    });

                    $('#speed_minus_flash_data').unbind().live('click',function(){
                        var tmp = RTD_RTX_FLASH_SPEED - 5;
                        if ( tmp > 1 ){
                            RTD_RTX_FLASH_SPEED = tmp;
                            document.all.flash_data.scrollAmount=RTD_RTX_FLASH_SPEED ;
                        }
                    });

                    $('#speed_plus_flash_data').unbind().live('click',function(){
                        var tmp = RTD_RTX_FLASH_SPEED + 5;
                        if ( tmp < 100 ){
                            RTD_RTX_FLASH_SPEED = tmp;
                            document.all.flash_data.scrollAmount=RTD_RTX_FLASH_SPEED ;
                        }
                    });

                    //$.populateRtdRtxTicker();
                    methods_arr.push('populateRtdRtxTicker');
                }


                var method = '';
                for (var i=0;i<methods_arr.length;i++){
                    method = methods_arr[i];

                    if (method.length > 0){
                        setTimeout('$.'+method+'()', 250);
                    }

                    //sleep(150); // pause
                    //eval('$.'+method+'();');
                }

                /// updater
                var refreshId = setInterval(function(){
                    $.validateServerTimeToIfNeededToGetNewData();
                },  20000 );



            }

        }
    });



</script>

