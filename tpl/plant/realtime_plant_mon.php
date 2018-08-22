<div class="span3">
    <ul class="nav nav-tabs nav-stacked">
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
            <div class="span10">
                <select id="plant">
                    <?php

                    foreach($plants as $p){
                        echo '<option value='.$p->plant_name.'>'.$p->plant_name.'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Unit</div>
            <div class="span10">
                <select id="unit">
                    <?php

                    foreach($units as $u){
                        echo '<option value='.$u['resource_id'].'>'.$u['resource_id'].'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2"></div>
            <div class="span10">
                <a class="btn btn-primary" href="#" id="display">Display</a>
            </div>
        </div>
        <hr>
        <legend>Result</legend>
        <div id="result" class="row-fluid">
        <!--div style="background:#F0F2F5;float:left;width:100%"-->
            <div class="span4 alert alert-success" id="interval-box" style="border-radius:5px"></div>
            <div class="span4 alert alert-success" id="rtd-box" style="border-radius:5px"></div>
            <div class="span4 alert alert-success" id="actual-load-box" style="border-radius:5px"></div>
        <!--/div-->
        </div>
        <legend>Submit Report</legend>
        <div class="row-fluid">
            <div id="alerts"></div>
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

            <button id="submit_report" class="btn btn-primary">Submit Report</button><span id="alert-msg"></span><br><br>
            <table id="tbl_shift_report" class="table table-striped"></table>
        </div>
        <br><br><br>
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
<script>
//new nicEditors.allTextAreas({buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript','forecolor']})
$.extend({
    loadUnitDropDown: function(){
        $.post('../plant/resource_dropdown',{plant:$('#plant').val()},
            function(data){
                html = '';
                $.each(data.value, function(i,val){
                    html+='<option value="'+val.resource_id+'">'+val.resource_id+'</option>';
                })
                $('#unit').html(html);
                return false;
            });
    },
    loadData: function(){
        //$("#result").html('Creating Chart &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        
        $.post('../plant/realtime_plant_mon_action',{unit:$('#unit').val()},
            function(data){
                //alert(data)
                //return false;
                //$("#result").html('');
                if (data.total < 1){
                    $("#result").append('<span style="padding:10px">No Data to Display</span>');
                } else {
                    $.formatData(data);
                }
            });
            return false;
    },
    loadShiftReport: function(){
        $.post('../plant/plant_shift_report_load',{},
            function(data){
                data = $.parseJSON(data);
                
                html = '';
                
                $.each(data, function(i,val){
                    html+='<tr>';
                    html+='<td>Posted by: <b>'+val.posted_by+'</b> Date: <b>'+val.date+'</b> Time: <b>'+val.time+'</b></td>';
                    html+='</tr>';
                    html+='<tr><td style="background:#FFF">'+val.report+'</td></tr>';
                    
                })
                
                $('#tbl_shift_report').html(html)
            });
            return false;
    },
    saveShiftReport: function(){
        //$('#report').val($('div').find('.nicEdit-main').html())
        var report = $('#editor').html();
        //if ($('div').find('.nicEdit-main').text()) {
        if (report) {
            
            $('#alert-msg').html('Saving Report...')
            $.post('../plant/plant_shift_report_save',{report:report},
                function(data){
                    $('#alert-msg').html('')
                });
                
        }
        return false;
    },
    createGraph: function(data, title){
        RTD.chart = new Highcharts.Chart({
            chart: {
                    renderTo: 'result',
                    type: 'spline',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    exporting: 'enabled',
                    buttons : 'exporting.buttons',
                    height:250
            },
            title: {
                text: title
            },
            xAxis: [{
                categories: ['H1', 'H2', 'H3', 'H4', 'H5', 'H6','H7', 'H8', 'H9', 'H10', 'H11', 'H12',
                             'H13', 'H14', 'H15', 'H16', 'H17', 'H18', 'H19', 'H20', 'H21', 'H22', 'H23', 'H24'],
                tickPixelInterval:50,
                gridLineWidth: 1
            }],
            yAxis: [{
                labels: {
                    formatter: function() {
                        return this.value +'mw';
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
            }],
            tooltip: {
                shared: true

            },
            series: 
                data
        });
        return false;
    },
    formatData: function (data){
        /*var mw_data=[];
        var obj = {};
        var resource_id;

        $.each(data.value, function(i, val) {
            var name = i;
            var data = [];
            $.each(val, function(index,d){
                    data.push(d.mw)
            });
            resource_id = i;
            mw_data.push({name:i,data:data,id:i})
        })*/
        //$.createGraph(mw_data, 'Realtime Dispatch Schedules');
        var interval_htm = 'Current Interval <h3>'+data.value.interval.interval+' ('+data.value.interval.start+' - '+data.value.interval.end+'H)</h3>';
        $('#interval-box').html(interval_htm);

        var rtd_val = data.value.rtd;
        if ( typeof rtd_val != 'undefined' ) {
            if ( rtd_val != null ) {
                rtd_val = $.formatNumberToSpecificDecimalPlaces(parseFloat(rtd_val),1);
            }
        }
        var rtd_htm = 'RTD '+$('#unit option:selected').html()+' <h3>'+rtd_val+'</h3>';
        $('#rtd-box').html(rtd_htm);
        var actual_load_htm = 'Actual Unit '+$('#unit option:selected').html()+' <h3>'+data.value.actual_unit+'</h3>';
        $('#actual-load-box').html(actual_load_htm);
        
        
        return false;
    }
})
</script>
<script>
$.loadUnitDropDown();
$.loadData()
$.loadShiftReport();

$('#plant').change(function(){
    $.loadUnitDropDown();
})
$('#display').unbind('click').bind('click',function(){
    $.loadData();
})
$('#fullscreen').unbind('click').bind('click',function(){
    alert('ongoing development...')
})
$('#submit_report').unbind('click').bind('click', function(e){
    e.preventDefault();
    $.saveShiftReport();
    $.loadShiftReport();
})

var refreshId = setInterval(function()
{
     $.loadData();
}, 10000);

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

</script>
