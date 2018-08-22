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
    <div class="row-fluid">
        <div class="span2">Plant</div>
        <div class="span10"><select id="cmb_plants" class="span3"></select></div>
    </div>
    <div class="row-fluid">
        <div class="span2">Unit</div>
        <div class="span10"><select id="cmb_plants_units" class="span3"></select></div>
    </div>
    <div class="row-fluid">
        <div class="span2"></div>
        <div class="span10">
            <a class="btn btn-primary" href="#" id="btn_display_records"><i class="icon-ok icon-white"></i>&nbsp;Display</a>
        </div>
    </div>
    <br>
    <legend>Result</legend>
    <div id="result_loader" class="loader" class="row-fluid"></div>
    <div id="result" class="row-fluid"></div>
    <div style="background:#F0F2F5;width:100%" class="row-fluid">
        <div class="square-box" id="interval-box">
            Current Interval
                0100H
        </div>
        <div class="square-box" id="rtd-box"></div>
        <div class="square-box" id="actual-load-box"></div>
    </div>
    <br>
    <legend>Shift Report</legend>
    <div class="row-fluid">
        <!--textarea style="width:100%" rows="5" id="submit_report"></textarea><br-->
        <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
            <div class="btn-group">
              <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font"><i class="icon-font"></i><b class="caret"></b></a>
                <ul class="dropdown-menu">
                <li><a data-edit="fontName Serif" style="font-family:'Serif'">Serif</a></li><li><a data-edit="fontName Sans" style="font-family:'Sans'">Sans</a></li><li><a data-edit="fontName Arial" style="font-family:'Arial'">Arial</a></li><li><a data-edit="fontName Arial Black" style="font-family:'Arial Black'">Arial Black</a></li><li><a data-edit="fontName Courier" style="font-family:'Courier'">Courier</a></li><li><a data-edit="fontName Courier New" style="font-family:'Courier New'">Courier New</a></li><li><a data-edit="fontName Comic Sans MS" style="font-family:'Comic Sans MS'">Comic Sans MS</a></li><li><a data-edit="fontName Helvetica" style="font-family:'Helvetica'">Helvetica</a></li><li><a data-edit="fontName Impact" style="font-family:'Impact'">Impact</a></li><li><a data-edit="fontName Lucida Grande" style="font-family:'Lucida Grande'">Lucida Grande</a></li><li><a data-edit="fontName Lucida Sans" style="font-family:'Lucida Sans'">Lucida Sans</a></li><li><a data-edit="fontName Tahoma" style="font-family:'Tahoma'">Tahoma</a></li><li><a data-edit="fontName Times" style="font-family:'Times'">Times</a></li><li><a data-edit="fontName Times New Roman" style="font-family:'Times New Roman'">Times New Roman</a></li><li><a data-edit="fontName Verdana" style="font-family:'Verdana'">Verdana</a></li></ul>
              </div>
            <div class="btn-group">
              <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
                <ul class="dropdown-menu">
                <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
                <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
                <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
                </ul>
            </div>
            <div class="btn-group">
              <a class="btn" data-edit="bold" title="" data-original-title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
              <a class="btn" data-edit="italic" title="" data-original-title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
              <a class="btn" data-edit="strikethrough" title="" data-original-title="Strikethrough"><i class="icon-strikethrough"></i></a>
              <a class="btn" data-edit="underline" title="" data-original-title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
            </div>
            <div class="btn-group">
              <a class="btn" data-edit="insertunorderedlist" title="" data-original-title="Bullet list"><i class="icon-list-ul"></i></a>
              <a class="btn" data-edit="insertorderedlist" title="" data-original-title="Number list"><i class="icon-list-ol"></i></a>
              <a class="btn" data-edit="outdent" title="" data-original-title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
              <a class="btn" data-edit="indent" title="" data-original-title="Indent (Tab)"><i class="icon-indent-right"></i></a>
            </div>
            <div class="btn-group">
              <a class="btn" data-edit="justifyleft" title="" data-original-title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
              <a class="btn" data-edit="justifycenter" title="" data-original-title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
              <a class="btn" data-edit="justifyright" title="" data-original-title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
              <a class="btn" data-edit="justifyfull" title="" data-original-title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
            </div>
            <div class="btn-group">
                <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Hyperlink"><i class="icon-link"></i></a>
                  <div class="dropdown-menu input-append">
                      <input class="span2" placeholder="URL" type="text" data-edit="createLink">
                      <button class="btn" type="button">Add</button>
              </div>
              <a class="btn" data-edit="unlink" title="" data-original-title="Remove Hyperlink"><i class="icon-cut"></i></a>

            </div>

            <div class="btn-group">
              <a class="btn" title="" id="pictureBtn" data-original-title="Insert picture (or just drag &amp; drop)"><i class="icon-picture"></i></a>
              <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" style="opacity: 0; position: absolute; top: 0px; left: 0px; width: 41px; height: 30px; ">
            </div>
            <div class="btn-group">
              <a class="btn" data-edit="undo" title="" data-original-title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
              <a class="btn" data-edit="redo" title="" data-original-title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
            </div>
            <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="" style="display: none; ">
        </div>
        <div id="editor" class="editor" contenteditable="true"></div>
        <a class="btn btn-primary" href="#" id="submit_report"><i class="icon-ok"></i>&nbsp;Submit Report</a>&nbsp;<span id="alerts"></span>
        <br><br>
        <table id="tbl_shift_report" class="table"></table>
        <input type="hidden"  id="rt_current_hour" value="">
        <input type="hidden" id="rt_current_interval" value="">
        <input type="hidden" id="current_date" value="<?php echo date('Y-m-d');?>">
        <div id="modal" style="display:none"></div>
    </div>
    <br><br><br><br>
</div>

<div class="modal fade in" id="modal_plant" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Plant Projections</h4>
    </div>
    <div class="modal-body" id="modal_plant_body"></div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>
<div class="modal fade in" id="modal_nom" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Nomination</h4>
    </div>
    <div class="modal-body" id="modal_nom_body"></div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>
<div class="modal fade in" id="modal_load_profile" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Load Profile</h4>
    </div>
    <div class="modal-body" id="modal_load_profile_body"></div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>
<div class="modal fade in" id="modal_offer" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Offer Log</h4>
    </div>
    <div class="modal-body" id="modal_offer_body"></div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>
<div class="modal fade in" id="modal_bcq" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">BCQ</h4>
    </div>
    <div class="modal-body" id="modal_bcq_body"></div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>

<style type="text/css">
    .square-box{
        background:#A8BAC8;
        margin:10px;
        float:left;
        width:270px;
        padding:10px;
        border-radius:3px;
    }
    .square-box h2{
        text-align: center;
    }

</style>
<!--script src="../js/nicEdit.js"></script-->
<script src="../js/highcharts.custom.theme.js"></script>
<script src="../js/shift_report_handlers.js"></script>

<script>
    
  $(function(){
    function initToolbarBootstrapBindings() {
      var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
      $.each(fonts, function (idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
      });
      $('a[title]').tooltip({container:'body'});
    	$('.dropdown-menu input').click(function() {return false;})
		    .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
        .keydown('esc', function () {this.value='';$(this).change();});

      $('[data-role=magic-overlay]').each(function () { 
        var overlay = $(this), target = $(overlay.data('target')); 
        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
      });
      if ("onwebkitspeechchange"  in document.createElement("input")) {
        var editorOffset = $('#editor').offset();
        $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
      } else {
        $('#voiceBtn').hide();
      }
	};
	function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	};
    initToolbarBootstrapBindings();  
	$('#editor').wysiwyg({ fileUploadError: showErrorAlert} );
    
  });

</script>
<script type="text/javascript">
    $('#editor').wysiwyg();
    //new nicEditors.allTextAreas({buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript','forecolor']})
    var CHART = null
        ,NEXTHOURRTDVALUE = null
        ,RTDDate = '';
    var triggerUpdateByRTD = false;
    $.extend({
        loadData: function(is_click){
            $.ajax({
                type: "POST"
                ,url : '../trading_realtimeplantmon/plant_monitoring_action'
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
                ,url : '../trading_realtimeplantmon/plant_monitoring_action'
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

        ,getRTDData : function(hour,is_next_date,is_previous_date){
            var rtd = null ;
            var parameters = { 'action' : 'get-rtd' , 'unit'  : $('#cmb_plants_units').val() , 'hour' : hour , 'is_next_date' : is_next_date, 'is_previous_date' : is_previous_date };
            $.ajax({
                type: "POST"
                ,url : '../trading_realtimeplantmon/plant_monitoring_action'
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

        ,createCurrentIntervalGraph : function(){
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


            var resource_name = $.trim($('#cmb_plants_units option:selected').html()) , is_aggregate_resources = $.trim(resource_name.toLowerCase()) === 'aggregate' ? true : false;

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
                    cur_rtd_value = $.getRTDData(cur_loop_hr,0,is_previous_date);
                }else if ( c === 1 ){
                    cur_rtd_value = $.getRTDData(cur_loop_hr,0,is_current_hour_previous_date);
                }else {
                    cur_rtd_value = $.getRTDData(cur_loop_hr,is_next_hour_next_day_date,0);
                }

                rtd_series_data.push({ x : rtd_x_axis, y : cur_rtd_value, hour : cur_loop_hr });
                x_axis_value_arr.push(cur_rtd_value);
                rtd_x_axis = rtd_x_axis + 13;
            }

            var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
            CHART = new Highcharts.Chart({

                chart: {
                    renderTo: 'result'
                },

                title: {
                    text: 'Realtime Plant Monitoring',
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
                ,url : '../trading_realtimeplantmon/plant_monitoring_action'
                ,data: {'action' : 'get-current-interval-by-rtdvalue', unit:$('#cmb_plants_units').val()}
                ,dataType:'json'
                ,async: false
                ,success: function(data){
                    if (data.total < 1){
                        $("#result").append('<span style="padding:10px">No Data to Display</span>');
                    } else {
                        var new_interval_data =  parseInt(data.value.interval.interval,10);
                        if ( old_current_interval != new_interval_data ) {
                            $.formatData(data);
                            triggerUpdateByRTD = false;
                            $('#btn_display_records').trigger('click');
                        } else {
                            triggerUpdateByRTD = false;
                            var current_hour = parseInt($('#rt_current_hour').val(),10);
                            var current_dcs = $.getDigCtrlSysData(current_hour);
                            $.updateChartDCSData(current_hour,current_dcs);

                            /*var cur_inteval = parseInt($('#rt_current_interval').val(),10)
                                ,next_interval = cur_inteval + 1
                                ,next_interval_rtd = null
                                ,current_time = '<?php echo date('H:i:s');?>'
                                ,current_time_min = parseInt(current_time.split(':')[1],10)
                                ,isGetDcsUpdates = false;

                            if ( current_time_min >= 45 ) {
                                isGetDcsUpdates = false;
                                next_interval_rtd = $.getRTDData(next_interval);
                                if ( next_interval_rtd != null && NEXTHOURRTDVALUE != next_interval_rtd ) {
                                    triggerUpdateByRTD = true;
                                    isGetDcsUpdates = false;
                                    NEXTHOURRTDVALUE = next_interval_rtd;
                                    var current_hour = parseInt($('#rt_current_hour').val(),10);
                                    var next_hr = current_hour == 23 ? 0 : ( current_hour + 1 );
                                    $('#rt_current_hour').attr('value',next_hr);
                                    $('#rt_current_interval').attr('value',data.value.interval.interval);
                                    $('#btn_display_records').trigger('click');
                                } else {
                                    isGetDcsUpdates = true;
                                }
                            }else {
                                isGetDcsUpdates = true;
                            }


                            if (isGetDcsUpdates) {
                                triggerUpdateByRTD = false;
                                var current_hour = parseInt($('#rt_current_hour').val(),10);
                                var current_dcs = $.getDigCtrlSysData(current_hour);
                                $.updateChartDCSData(current_hour,current_dcs);
                            }*/



                        }
                    }
                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    console.log("Error on accessing webservice data " + jqXHR.responseText );
                }
            });
            /*
            $.post('../plant/realtime_plant_mon_action',{unit:$('#cmb_plants_units').val()},
                function(data){
                    if (data.total < 1){
                        $("#result").append('<span style="padding:10px">No Data to Display</span>');
                    } else {
                        var new_interval_data =  parseInt(data.value.interval.interval,10);
                        if ( old_current_interval != new_interval_data ) {
                            $.formatData(data);
                            triggerUpdateByRTD = false;
                            $('#btn_display_records').trigger('click');
                        } else {

                            var cur_inteval = parseInt($('#rt_current_interval').val(),10)
                                //,next_interval = cur_inteval === 23 ? 0 : cur_inteval + 1
                                ,next_interval = cur_inteval + 1
                                ,next_interval_rtd = null
                                ,current_time = '<?php echo date('H:i:s');?>'
                                ,current_time_min = parseInt(current_time.split(':')[1],10)
                                ,isGetDcsUpdates = false;

                            if ( current_time_min >= 45 ) {
                                isGetDcsUpdates = false;
                                next_interval_rtd = $.getRTDData(next_interval);
                                if ( next_interval_rtd != null && NEXTHOURRTDVALUE != next_interval_rtd ) {
                                    triggerUpdateByRTD = true;
                                    isGetDcsUpdates = false;
                                    NEXTHOURRTDVALUE = next_interval_rtd;
                                    var current_hour = parseInt($('#rt_current_hour').val(),10);
                                    var next_hr = current_hour == 23 ? 0 : ( current_hour + 1 );
                                    $('#rt_current_hour').attr('value',next_hr);
                                    $('#rt_current_interval').attr('value',data.value.interval.interval);
                                    $('#btn_display_records').trigger('click');
                                } else {
                                    isGetDcsUpdates = true;
                                }
                            }else {
                                isGetDcsUpdates = true;
                            }


                            if (isGetDcsUpdates) {
                                triggerUpdateByRTD = false;
                                var current_hour = parseInt($('#rt_current_hour').val(),10);
                                var current_dcs = $.getDigCtrlSysData(current_hour);
                                $.updateChartDCSData(current_hour,current_dcs);
                            }



                        }
                    }
                });*/

        }

        ,loadShiftReport: function(){
            $.ajax({
                type: "POST"
                ,url : '../trading_realtimeplantmon/shift_report_load'
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
            $.post('../trading_realtimeplantmon/shift_report_save',{report:report},
                function(data){
                    $.loadShiftReport();
                    $('#alerts').html('');
                    $('#editor').html('')
                });
        }

        ,validateServerTimeToGetNewData: function(){
            $.ajax({
                type: "POST"
                ,url : '../trading_realtimeplantmon/plant_monitoring_action'
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

    $(document).ready(function() {
        //$.loadData();
        $.loadShiftReport();
        
        $('#btn_display_records').unbind('click').bind('click',function(e){
            e.preventDefault();
            if ( !triggerUpdateByRTD ) {
                $.loadData(true);
            }

            $.createCurrentIntervalGraph();
            var current_hour = parseInt($('#rt_current_hour').val(),10);
            var previous_hour = current_hour == 0 ? 23 :( current_hour -1 );
            var prev_dcs = $.getDigCtrlSysData(previous_hour);
            var current_dcs = $.getDigCtrlSysData(current_hour);
            $.updateChartDCSData(previous_hour,prev_dcs);
            $.updateChartDCSData(current_hour,current_dcs);
            //setInterval('$.updateChartChanges()',50000);
            setInterval('$.validateServerTimeToGetNewData()',20000);

        });

        $('#cmb_plants').change();
        $('#btn_display_records').trigger('click');

        
        /*
        $('.trans_link').die('click').live('click',function(e){
            e.preventDefault();
            $.showPlantAvail($(this).attr('id'));
        })*/

        $('.trans_link').die('click').live('click',function(e){
            e.preventDefault();
            if ( $(this).parent().text().indexOf('Nomination') >= 0 ) {
                $.showNominationAudit($(this).attr('id'));
            }else if ( $(this).parent().text().indexOf('Load Profile') >= 0 ) {
                $.downloadLoadProfileFile($(this).attr('id'));
            }else if ( $(this).parent().text().indexOf('Offer') >= 0 ) {
                $.showOfferLog($(this).attr('id'));
            }else if ( $(this).parent().text().indexOf('BCQ') >= 0 ) {
                $.showBCQAudit($(this).attr('id'));
            }else if ( $(this).parent().text().indexOf('ACC') >= 0 ) {
                $.downloadUploadedDanWanAccFile($(this).attr('id'));
            }else{
                $.showPlantAvail($(this).attr('id'));
            }



        })
        
        $('.trans_link').die('click').live('click',function(e){
            e.preventDefault();
            if ( $(this).parent().text().indexOf('Load Profile') >= 0 ) {
                $('#modal_load_profile').modal('show')
                $.downloadLoadProfileFile($(this).attr('id'));
            }else if ( $(this).parent().text().indexOf('Nomination') >= 0 ) {
                $('#modal_nom').modal('show')
                $.showNominationAudit($(this).attr('id'));
            }else if ( $(this).parent().text().indexOf('Load Profile') >= 0 ) {
                $('#modal_load_profile').modal('show')
                $.downloadLoadProfileFile($(this).attr('id'));
            }else if ( $(this).parent().text().indexOf('BCQ') >= 0 ) {
                $('#modal_bcq').modal('show')
                $.showBCQAudit($(this).attr('id'));
            }else if ( $(this).parent().text().indexOf('Offer') >= 0 ) {
                $('#modal_offer').modal('show')
                $.showOfferLog($(this).attr('id'));    
            }else {
                $('#modal_plant').modal('show')
                $.showPlantAvail($(this).attr('id'));
            }

        })
    });
</script>
<script>
$.populateCurIntervalPlantsDropdown();
$('#cmb_plants').unbind('change').bind('change',function(){
    $.populateCurIntervalUnitsDropdown();
});

$('#submit_report').unbind('click').bind('click', function(e){
    e.preventDefault();
    $.saveShiftReport();
});
</script>