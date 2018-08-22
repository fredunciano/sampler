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
        <div class="span2">Date</div>
        <div class="span10"><input type="text" id="datepicker" style="width:150px;" value="<?=$date?>"></div>
    </div>
    <div class="row-fluid">
        <div class="span2">
            <label class="checkbox"><input type="checkbox" checked="checked" id="chk_all_traders">All Traders&nbsp;&nbsp;&nbsp;</label></div>
        <div class="span10">
            <select id="cmb_traders" disabled="true" class="span3">
            <?php 
                foreach ($userlist as $u) {
                    echo '<option value="'.$u->user.'">'.$u->user.'</option>';
                };
            ?>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Content</div>
        <div class="span10 input-append">
            <input type="text" id="search_content" placeholder="Content">
            <input type="button" id="search" value="Search" class="btn">
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">&nbsp;</div>
        <div class="span10"><input type="button" id="submit" value="Display" class="btn btn-primary"></div>
    </div>
    <br><br>
    <div class="row-fluid" id="result">
    </div>
    <button name="btn_generate_pdf_shift_report" id="btn_generate_pdf_shift_report" class="btn btn-success" style="float: right; margin-top: 20px; margin-right: 30px;" >Generate PDF</button>
    <br><br><br><br>
    
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
<div class="modal fade in" id="modal_acc" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">ACC</h4>
    </div>
    <div class="modal-body" id="modal_acc_body"></div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
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

<script src="../js/shift_report_handlers.js"></script>
<script>
$.extend({
    loadData : function(){
    	
        $('#alert_msg').html('Loading...');
        
        var html = '';
        
        html+='<table class="table table-striped">';
        
        $.post('../trading_reports/shift_report_by_interval',{date:$('#datepicker').val()},
            function(data){
                $('#alert_msg').html('');
                data = $.parseJSON(data);
                for (x=1;x<=24;x++) {
                    start = x*100+1-100;
                    end = x*100;
                    xstart  = $.strPad(start,4);
                    xend    = $.strPad(end,4);
                    var r = '';
                    if (typeof data[x] === 'object') {
                        $.each(data[x], function(i1,val){
                            r+= '<div style="background:#FFF;margin:2px;padding:3px;border-radius:3px">'+
                                '<b>['+val.date+']</b> <b>['+val.time+']</b> <b>'+val.posted_by+'</b><br>'+
                                val.report+
                                '</div>';
                        })
                    }
                    
                    html+='<tr id="details"><td style="width:100px">Interval '+x+'<br> ('+xstart+'_'+xend+'H)'+
                    '&nbsp;&nbsp;<a href="#"><i class="icon-plus" id="'+x+'"><i/></a></td><td>'+r+'<br>'+
                    '<div id="textarea'+x+'" style="display:none" class="textarea">'+
                    //'<textarea style="width:600px" rows="5" id="int'+x+'"></textarea>'+
                    '<div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor'+x+'">'+
                    '<div class="btn-group">'+
                    '<a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font"><i class="icon-font"></i><b class="caret"></b></a>'+
                    '<ul class="dropdown-menu">'+
                    '<li><a data-edit="fontName Serif" style="font-family:Serif">Serif</a></li><li><a data-edit="fontName Sans" style="font-family:Sans">Sans</a></li><li><a data-edit="fontName Arial" style="font-family:Arial">Arial</a></li><li><a data-edit="fontName Arial Black" style="font-family:Arial Black">Arial Black</a></li><li><a data-edit="fontName Courier" style="font-family:Courier">Courier</a></li><li><a data-edit="fontName Courier New" style="font-family:Courier New">Courier New</a></li><li><a data-edit="fontName Comic Sans MS" style="font-family:Comic Sans MS">Comic Sans MS</a></li><li><a data-edit="fontName Helvetica" style="font-family:Helvetica">Helvetica</a></li><li><a data-edit="fontName Impact" style="font-family:Impact">Impact</a></li><li><a data-edit="fontName Lucida Grande" style="font-family:Lucida Grande">Lucida Grande</a></li><li><a data-edit="fontName Lucida Sans" style="font-family:Lucida Sans">Lucida Sans</a></li><li><a data-edit="fontName Tahoma" style="font-family:Tahoma">Tahoma</a></li><li><a data-edit="fontName Times" style="font-family:Times">Times</a></li><li><a data-edit="fontName Times New Roman" style="font-family:Times New Roman">Times New Roman</a></li><li><a data-edit="fontName Verdana" style="font-family:Verdana">Verdana</a></li></ul>'+
                    '</div>'+
                    '<div class="btn-group">'+
                    '<a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>'+
                    '<ul class="dropdown-menu">'+
                    '<li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>'+
                    '<li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>'+
                    '<li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>'+
                    '</ul>'+
                    '</div>'+
                    '<div class="btn-group">'+
                    '<a class="btn" data-edit="bold" title="" data-original-title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>'+
                    '<a class="btn" data-edit="italic" title="" data-original-title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>'+
                    '<a class="btn" data-edit="strikethrough" title="" data-original-title="Strikethrough"><i class="icon-strikethrough"></i></a>'+
                    '<a class="btn" data-edit="underline" title="" data-original-title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>'+
                    '</div>'+
                    '<div class="btn-group">'+
                    '<a class="btn" data-edit="insertunorderedlist" title="" data-original-title="Bullet list"><i class="icon-list-ul"></i></a>'+
                    '<a class="btn" data-edit="insertorderedlist" title="" data-original-title="Number list"><i class="icon-list-ol"></i></a>'+
                    '<a class="btn" data-edit="outdent" title="" data-original-title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>'+
                    '<a class="btn" data-edit="indent" title="" data-original-title="Indent (Tab)"><i class="icon-indent-right"></i></a>'+
                    '</div>'+
                    '<div class="btn-group">'+
                    '<a class="btn" data-edit="justifyleft" title="" data-original-title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>'+
                    '<a class="btn" data-edit="justifycenter" title="" data-original-title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>'+
                    '<a class="btn" data-edit="justifyright" title="" data-original-title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>'+
                    '<a class="btn" data-edit="justifyfull" title="" data-original-title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>'+
                    '</div>'+
                    '<div class="btn-group">'+
                    '<a class="btn" data-edit="undo" title="" data-original-title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>'+
                    '<a class="btn" data-edit="redo" title="" data-original-title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>'+
                    '</div>'+
                    '<input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="" style="display: none; ">'+
                    '</div>'+
                    '<div id="editor'+x+'" contenteditable="true" class="editor"></div>'+
                    '<button id="save'+x+'" class="hidden save btn btn-success">Save</button>&nbsp;'+
                    '<button id="cancel'+x+'" class="hidden btn btn-danger">Close</button>'+
                    '</div>'+
                    '<span id="msg'+x+'" class="hide"></span></td></tr>';
                    //'<button id="'+x+'" class="btn"><i class="icon-plus"><i/></button></td><td>'+r+'<br><span id="int'+x+'" class="hidden">'+
                }
                
                html+='</table>';
                $('#result').html(html)
                //new nicEditors.allTextAreas({buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript','forecolor']}) 
            });
            return false;
    },
    saveDetails : function(getint){
    	//$('button.hidden').hide();
    	$('#msg'+getint).html('Saving&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
    	var details = $('#editor'+getint).html();
        
    	var interval = getint;
    	$.post('../trading_reports/additional_report',{report : details, interval : interval, date : $('#datepicker').val()},
    	function(data){
    		$('#msg'+getint).html(data);
    		
    		$.loadData();
    	})
    	
    }

    ,searchContent : function(){
    	 $("#result").html('Please wait &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif" />');

            // ################ tab contents
            var is_all_traders = $('#chk_all_traders').is(':checked');
            var parameters =  {content : $('#search_content').val(), type : 'plant' };
            if (!is_all_traders) {
                parameters['trader'] =   $('#cmb_traders').attr('value');
            }
            $.ajax({
                type: "POST"
                ,url : '../trading_reports/search_action'
                ,data: parameters
                ,dataType:'json'
                ,async: true
                ,success: function(returnData){
                	//returnData = $.parseJSON(returnData);
                    var html = '';
        
        			html+='<table class="table" style="width:100%">';
        			html+='<tr><th>Posted By</th><th>Interval</th><th>Content</th><th>Date&nbsp;Posted</th></tr>'
        			$.each(returnData,function(i,val){
        				
        				//console.log(val.posted_by)
        				html+= '<tr id="s_result" class="'+val.date+'"><td>'+val.posted_by+'</td><td><b>'+val.interval+'</b></td><td>'+val.report+'</td><td>'+val.date+'</td></tr>';
        				
        			})
					//console.log(data);	
                    html += '</table>';
                    $("#result").html('');
                    $("#result").html(html)
                    
                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    alert("Error on accessing webservice data " + jqXHR.responseText );
                    $("#result").html('With errors');
                }
            });
    }
})
</script>
<script>
$('#datepicker').datepicker({autoclose: true});
$.loadData();
$('#submit').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.loadData();
});
$('button.save').die('click').live('click',function(e){
	e.preventDefault();
	var getint = $(this).attr('id');
	getint = getint.replace(/\D/g,'');
	//$('#msg'+getint).show();
	$.saveDetails(getint)
	//
  })
$('.icon-plus').die('click').live('click',function(e){
	e.preventDefault();
    $('.textarea').css('display','none');
    $('#textarea'+$(this).attr('id')).css('display','');
    
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
        var editorOffset = $('#editor'+$(this).attr('id')).offset();
        $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor'+$(this).attr('id')).innerWidth()-35});
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
	$('#editor'+$(this).attr('id')).wysiwyg({ fileUploadError: showErrorAlert} );
  })
$('button.btn-danger').die('click').live('click',function(e){
	e.preventDefault();
	$('.textarea').css('display','none');
})
$('.trans_link').die('click').live('click',function(e){
    e.preventDefault();

    if ( $(this).parent().text().indexOf('Nomination') >= 0 ) {
        $('#modal_nom').modal('show')
        $.showNominationAudit($(this).attr('id'));
    }else if ( $(this).parent().text().indexOf('Load Profile') >= 0 ) {
        $('#modal_load_profile').modal('show')
        $.downloadLoadProfileFile($(this).attr('id'));
    }else if ( $(this).parent().text().indexOf('Offer') >= 0 ) {
        $('#modal_offer').modal('show')
        $.showOfferLog($(this).attr('id'));
    }else if ( $(this).parent().text().indexOf('BCQ') >= 0 ) {
        $('#modal_bcq').modal('show')
        $.showBCQAudit($(this).attr('id'));
    }else if ( $(this).parent().text().indexOf('ACC') >= 0 ) {
        $('#modal_acc').modal('show')
        $.downloadUploadedDanWanAccFile($(this).attr('id'));
    }else{
        $('#modal_plant').modal('show')
        $.showPlantAvail($(this).attr('id'));
    }
})
$('#search').unbind('click').bind('click',function(e){
	e.preventDefault();
	if ($('#search_content').val() == '' || $('#search_content').val() == ' '){
		alert('Please enter a value');
	}else{
	$.searchContent();
	
	}
});
$('#s_result').live('click',function(){
	
	var d = $(this).attr('class');
	$('#datepicker').datepicker("setDate",new Date(d));
	$("#result").html('Please wait &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif" />');
	$.loadData();
})
$('#chk_all_traders').unbind('click').bind('click',function(){
                var is_all_traders = $('#chk_all_traders').is(':checked');
                if (is_all_traders) {
                    $('#cmb_traders').attr('disabled',true);
                } else {
                    $('#cmb_traders').attr('disabled',false);
                }
            });
$("#btn_generate_pdf_shift_report").die('click').live('click',function(e){
    $.download('../trading_reports/file_plant_shift_report_by_interval','date=' + Date.parse($("#datepicker").val()).toString("yyyy-MM-dd") );
});
</script>