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
    <form id="frm1" name="frm1" enctype="multipart/form-data" method="post">
    <input type="hidden" name="template_type" value="day_ahead">
    <div class="row-fluid">
        <div class="span2">File</div>
        <div class="span10">
            <div class="fileupload fileupload-new span6" data-provides="fileupload">
                <div class="input-append">
                    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
                    <span class="btn btn-primary btn-file"><span class="fileupload-new">Select file</span>
                        <span class="fileupload-exists">Change</span><input type="file" name="filebrowser" id="filebrowser" />
                    </span>
                    <a href="#" id="remove_file" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                    <!--a href="#" class="btn fileupload-exists btn-primary" data-dismiss="fileupload" id="submit_file">Upload</a-->
                    <input type="submit" value="Upload" class="btn fileupload-exists btn-primary" />
                </div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span2">Participant</div>
        <div class="span10"><select id="participant"></select></div>
    </div>
    <div class="row-fluid">
        <div class="span2">Contracted Capacity</div>
        <div class="span10"><span id="contracted_capacity"></span></div>
    </div>
    <div class="row-fluid">
        <div class="span2">Delivery Date</div>
        <div class="span10 input-append">
            <input type="text" id="datepicker" name="sdate" value="<?=$default_date?>" class="input-small">
            <button id="display_btn" class="btn btn-primary">Retrieve</button>
        </div>
    </div>
    <br>
    <legend><h5>Populate Fields</h5></legend>
    <div class="row-fluid">
        <div class="span2">Populate Text Box</div>
        <div class="span4 input-prepend input-append">
            <span class="add-on">&nbsp;Interval&nbsp;</span><input type="text" value="1-24" id="txt_interval" class="input-mini">
            <span class="add-on">&nbsp;Nomination&nbsp;</span><input type="text" value="1000" id="txt_mw" class="input-small">
            <button id="btn_populate_apply" type="button" class="btn btn-primary">Populate</button>
        </div>
    </div>
    <br>
    <div class="row-fluid" id="result"></div>
    <br>
    <legend><h5>Remarks</h5></legend>
    <!--textarea id="remarks" name="remarks" class="editor"></textarea-->
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
    <input id="save_btn" type="button" value="Submit" class="btn btn-primary"/>
    <!--input id="export_btn" type="button" value="Export to XLS" class="btn btn-success" /--> <span id="alert-msg" class="pls_wait"></span>
    </div>
    </form>
    <br><br><br>
</div>

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
$.extend({
    renderIntervals: function (s)
    {
        $('#alert-msg').html('Please wait...');
        //$('#export_btna').hide();

        var url = 'http://' + location.host + '<?=$base_url?>' + '/buyer/nom_day_render_intervals'
        var parameters = "delivery_date=" + $('#datepicker').val();

        $.ajax({
           type: "POST",
           url: url,
           data: parameters,
           success: function(msg){
                //console.log(msg);

                var ret = $.parseJSON(msg);
                var readonly = '';

                if(ret.allow_submit == false){
                    $('#upload_btn').attr('disabled', 'disabled');
                    $('#btn_populate_apply').attr('disabled', 'disabled');
                    $('#btn_populate_clear').attr('disabled', 'disabled');
                    $('#save_btn').attr('disabled', 'disabled');
                    $('#editor').attr('disabled', 'disabled');
                    readonly = 'readonly';
                }else{
                    $('#upload_btn').removeAttr('disabled');
                    $('#btn_populate_apply').removeAttr('disabled');
                    $('#btn_populate_clear').removeAttr('disabled');
                    $('#save_btn').removeAttr('disabled');
                    $('#editor').removeAttr('disabled');
                    readonly = '';
                }

                $('#editor').html(ret.remarks);

                var t = '';
                var h = '';
                var total_mw = 0;

                $.each(ret.data,function(i, v){

                    //t += '<ul><li><a href="#tabs-1">'+i+'</a></li></ul>';

                    h += '<p class="text-info">Delivery Date: <b>'+$('#datepicker').val()+'</b></p>'
                        + '<table class="table table-striped"><tr><th style="width:250px">Interval</th>'
                        + '<th>MAX Allocation of <br />Contracted Capacity (kW)</th>'
                        + '<th>MIN Allocation of <br />Contracted Capacity (kW)</th>'
                        + '<th colspan=2>Nomination (kW)</th>'
                        + '</tr>';

                    total_mw = 0;

                    $.each(v,function(x, val){
                        h += '<tr>'
                            + '<td><b>'+val.delivery_hour_display+'</b></td>'
                            + '<td><input type="text" id="acc_'+x+'" name="acc_'+x+'" value="'+val.max_allow+'" readonly tabindex="-1" /></td>'
                            + '<td><input type="text" id="min_qty_'+x+'" name="min_qty_'+x+'" value="'+val.min_allow+'" readonly tabindex="-1" /></td>'
                            + '<td><input class="nomination value" id="nom_'+x+'" name="mw_'+x+'" type="text" value="'+val.mw+'" '+readonly+' /></td>'
           					// Removed for validation : billy
                            //+ '<td class="err_td" style="display:none; color:#FFFFFF; background:#DC241F; width:250px" id="err_nom_'+x+'">'
                           // + 'Please enter a value greater than the Minimum Quantity and lower than or equal to ACC'
                            + '</td></tr>';

                        total_mw = total_mw + ($.trim(val.mw).length > 0 ? parseFloat(val.mw) : 0 );

                        if ( $.trim(val.mw).length > 0 ){
                            $('#export_btn').show();
                        }

                    });

                    // for total
                    total_mw = total_mw.toFixed(3);
                    total_mw = total_mw.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

                    h += '<tr>'
                        + '<td colspan="3" style="text-align: right">Total :</td>'
                        + '<td colspan="2"><input  disabled="true" class="value" id="total_mw" type="text" value="'+total_mw+'"/></td>'
                        + '</tr>';



                });

                h += '</table>';

                $('#result').html(t+h);
                $('#alert-msg').html('');
                //$("#tabs").tabs('destroy');
                //$("#tabs").tabs();

                //$("input.nomination").numeric();
                //$('.pls_wait').html('');

           }
         });
        return false;
    },
    save: function (s)
    {
        $('#alert-msg').html('Please wait...');

        var url = 'http://' + location.host + '<?=$base_url?>' + '/buyer/nom_day_save';
        var parameters = $('#frm1').serialize()+'&editor='+$('#editor').html();

        $.ajax({
           type: "POST",
           url: url,
           data: parameters,
           success: function(data){
                var ret = $.parseJSON(data);
                var h = ret.message + '<br />'
                        + 'Transaction Id: ' + ret.transaction_id + '<br />'
                        + 'Type: ' + ret.type + '<br />'
                        + 'Relevant date: ' + ret.delivery_date + '<br /><br />';

                $('#alert-msg').html(ret.message);
                bootbox.alert(h)
                /*$('#save_dialog_content').html(h);

                $('#save_dialog').dialog({width:300, modal:true, position:top});
                $(".ui-dialog-titlebar").hide();
                $('#close_dialog_btn').click(function(){
                    $('#save_dialog').dialog('close');
                });*/
           }
         });
        return false;
    },
    applyPopulateNominations : function()
    {
        var val_interval = $('#txt_interval').attr('value');
        val_interval = $.trim(val_interval);

        //var val_nominations = $('#txt_nominations').attr('value');
        var val_nominations = $('#txt_mw').attr('value');
        val_nominations = $.trim(val_nominations);

        if ( val_interval.length > 0 ) {
            var min_interval =  0;
            var max_interval =  0;

            if ( val_interval.indexOf("-") >=0  ) {
                min_interval =  parseInt(val_interval.split('-')[0],10);
                max_interval =  parseInt(val_interval.split('-')[1],10);
            } else {
                min_interval =  parseInt(val_interval,10);
                max_interval =  parseInt(val_interval,10);
            }
            $.updateNominationInputValues(min_interval,max_interval,val_nominations);
        } else {
            if ( val_interval.length <= 0 ) {
                bootbox.alert('Invalid interval value.');
                return false;
            }

            if ( val_nominations.length <= 0 ) {
                bootbox.alert('Invalid nominations value.');
                return false;
            }
        }

    },
    updateNominationInputValues : function(start,end,apply_value)
    {
        var id = 'mw_';
        for (var i=start; i<=end; i++){
            $('input[name="'+ id+i +'"]').attr('value',apply_value);
        }

        $.updateTotalNominationValue();
    },
    clearPopulateValues : function()
    {
        var val_interval = $('#txt_interval').attr('value');
        val_interval = $.trim(val_interval);

        if ( val_interval.length > 0 ) {
            var min_interval =  0;
            var max_interval =  0;

            if ( val_interval.indexOf("-") >=0  ) {
                min_interval =  parseInt(val_interval.split('-')[0],10);
                max_interval =  parseInt(val_interval.split('-')[1],10);
            } else {
                min_interval =  parseInt(val_interval,10);
                max_interval =  parseInt(val_interval,10);
            }
            $.updateNominationInputValues(min_interval,max_interval,'');
        } else {
            if ( val_interval.length <= 0 ) {
                alert('Invalid interval value.');
                return false;
            }
        }

    },
    updateTotalNominationValue : function()
    {
        //alert(1);

        var total_mw = 0;
        $('input[name^="mw_"]').each(function() {
            var cur_value = $(this).val();
            total_mw = total_mw + (  $.trim(cur_value).length > 0 ? parseFloat(cur_value) : 0 );
        });

        total_mw = total_mw.toFixed(3);
        total_mw = total_mw.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

        $('#total_mw').val(total_mw);
    },
    validateIntervalEntry : function(interval_inp)
    {

        var val = $('#'+ interval_inp).attr('value')
            ,valid_entry = true;

        if ( val.indexOf("-") > 0 ) {
            /*
            var re = new RegExp('([1-9]|1\d|2[0-4])-([1-9]|1\d|2[0-4])+');
            if (val.match(re)) {
                valid_entry = true;
            } else {
                valid_entry = false;
            }*/
            var reg_pattern = /(\d+)[-](\d+)$/;
            var isvalid = reg_pattern.test(val);
            valid_entry = false;
            if ( isvalid ) {
                var min_interval =  parseInt(val.split('-')[0],10);
                var max_interval =  parseInt(val.split('-')[1],10);
                valid_entry = false;
                if ( min_interval < 24 && max_interval <= 24 ) {
                  if (  min_interval < max_interval ) {
                      valid_entry = true;
                  }
                }

            }

        } else {
            var numRegex = /^[\d]+$/;
            valid_entry =  false;
            if(numRegex.test(val)){
                if ( parseInt(val,10) <= 24 ) {
                    valid_entry =  true;
                }

            }
        }

        if (valid_entry){
            $('#'+ interval_inp).removeClass('error');
        }else {
            $('#'+ interval_inp).addClass('error');
        }

        return valid_entry;
    },
    listParticipants : function()
    {
        $.post('../buyer/listParticipants',
        function(data){
            var data = data.split("|")
            $.each(data, function(i,val){
                $('#participant').append('<option>'+val+'</option>')
            })
            $.showContractedCapacity();
        });

    },
    showContractedCapacity : function()
    {
        $.post('../buyer/getContractedCapacity',{participant:$('#participant').val(),date:$('#datepicker').val()},
        function(data){
            $('#contracted_capacity').html('')
            $('#contracted_capacity').html(data)
        });
    }
});
</script>
<script type="text/javascript">

$.listParticipants();

$('#participant, #datepicker').change(function(){
    $.showContractedCapacity();
})

//new nicEditors.allTextAreas({buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript','forecolor']})

// Removed for validation : billy
/*
$('input.nomination').live('blur', function(){
    var n = $(this).attr('name');
    n = n.split('_');

    var x = n[1];
    if(x < 1) return false;
    var min_qty = $('#min_qty_'+x).val();
    var acc 	= $('#acc_'+x).val();

    if(($(this).val()/1 < min_qty || $(this).val()/1 > acc) || $(this).val() == '') {
        $('#err_'+$(this).attr('id')).fadeIn('slow');
        $(this).parent().css('background-color','#DC241F');
    }else{
        //alert('#err_'+$(this).attr('id'));
        $('#err_'+$(this).attr('id')).fadeOut('slow');
        $(this).parent().css('background-color','#F0F2F5');
    }
}); */

//$("#tabs").tabs();
$.renderIntervals();

$('#display_btn').unbind('click').bind('click',function(e){
    e.preventDefault();
    $("#remove_file").trigger('click');
    $.renderIntervals();
});

$('#btn_populate_apply').live('click',function(){
    if ( $.validateIntervalEntry('txt_interval') ) {
        $.applyPopulateNominations();
    }
});

$('#btn_populate_clear').live('click',function(){
    if ( $.validateIntervalEntry('txt_interval') ) {
        $.clearPopulateValues();
    }
});


//$("#txt_nominations").numeric();
/*$("#txt_nominations").keydown(function(event) {
    //alert(event.keyCode);
    // Allow: backspace, delete, tab and escape
    if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 ||
        // Allow: Ctrl+A
        (event.keyCode == 65 && event.ctrlKey === true) ||
        // Allow: home, end, left, right
        (event.keyCode >= 35 && event.keyCode <= 39)) {
        // let it happen, don't do anything
        return;
    }
    else {
        // Ensure that it is a number and stop the keypress
        if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
            event.preventDefault();
        }
    }
});*/

$('#txt_interval').live('blur',function(event){
    event.preventDefault();
    $.validateIntervalEntry($(this).attr('id'));
});


$('input[name^="mw_"]').die('blur').live('blur',function(event){
    event.preventDefault();
    $.updateTotalNominationValue();
});

/*$('#export_btn').bind('click',function(){
	var parameters = 'delivery_date='+Date.parse($('#delivery_date').attr('value')).toString("yyyy-MM-dd");
	$.download('http://' + location.host + '/TRANSASIA/spreadsheet/cust_day_ahead_nom.php',parameters);
});*/

$('#save_btn').unbind('click').bind('click',function(e){
    e.preventDefault();

    $('#alert-msg').html('');
    bootbox.confirm('Are you sure you want to submit?',function(conf){
        if(conf){
            for(x=1;x<=24;x++){
                var min_qty = $('#min_qty_'+x).val();
                var acc 	= $('#acc_'+x).val();

				// Removed for validation : billy

               /* if(($('#nom_'+x).val()/1 < min_qty || $('#nom_'+x).val()/1 > acc) && $('#nom_'+x).val() != '') {
                    $('#err_nom_'+x).fadeIn('slow');
                    $('#nom_'+x).parent().css('background-color','#DC241F');

               } */
            }
            /*if($('td.err_td:visible').length < 1 && $('#nom_1').val() != '' && $('#nom_2').val() != '' && $('#nom_3').val() != ''
            && $('#nom_4').val() != '' && $('#nom_5').val() != '' && $('#nom_6').val() != '' && $('#nom_7').val() != ''
            && $('#nom_8').val() != '' && $('#nom_9').val() != '' && $('#nom_10').val() != '' && $('#nom_11').val() != ''
            && $('#nom_12').val() != '' && $('#nom_13').val() != '' && $('#nom_14').val() != '' && $('#nom_15').val() != ''
            && $('#nom_16').val() != '' && $('#nom_17').val() != '' && $('#nom_18').val() != '' && $('#nom_19').val() != ''
            && $('#nom_20').val() != '' && $('#nom_21').val() != '' && $('#nom_22').val() != '' && $('#nom_23').val() != ''
            && $('#nom_24').val() != ''){

            }else{
                bootbox.alert('Please enter a value greater than the Minimum Quantity and lower than or equal to ACC');
            }*/ $.save();
        }
    })
    //return false;
});

$('#frm1').submit(function(e){
    e.preventDefault();

    if($('#filebrowser').val() == "") return false;

    var url = 'http://' + location.host + '<?=$base_url?>' + '/buyer/nom_template_parser';
    //var params = 'template_type=day_ahead';

    var options = {
        target:'',
        url:url,
        //data:params,
        beforeSubmit: function() {
            $('#resultbox').html('Loading...');
        },
        success: function(data) {
            var ret = $.parseJSON(data);
            $.each(ret.mw, function(i, val){
                val = parseFloat(val).toFixed(3)
                $('input[name=mw_'+i+']').val(val);
            });
            $('#resultbox').html('');
            $.updateTotalNominationValue();
            bootbox.alert("Uploaded sucessfully");
        }
    };

    $("#frm1").ajaxSubmit(options);
});

$('input.nomination').live('change',function () {
    $(this).val(function(i, v) {
        if(v){
            return parseFloat(v).toFixed(3);
        }
    });
});

// Removed for validation : billy

/*$('input.nomination').live('blur', function(){
    var n = $(this).attr('name');
    n = n.split('_');

    var x = n[1];
    if(x < 1) return false;
    var min_qty = $('#min_qty_'+x).val();
    var acc 	= $('#acc_'+x).val();

    if(($(this).val()/1 < min_qty || $(this).val()/1 > acc) || $(this).val() == '') {
        $('#err_'+$(this).attr('id')).fadeIn('slow');
        $(this).parent().css('background-color','#DC241F');
    }else{
        //alert('#err_'+$(this).attr('id'));
        $('#err_'+$(this).attr('id')).fadeOut('slow');
        $(this).parent().css('background-color','#F0F2F5');
    }
}); */

/*
$('#btn_populate_apply').click(function(e){
    e.preventDefault();

    interval 	= $('#txt_interval').val();
    mw 			= $('#txt_nominations').val();
    hour = interval.split('-');
    start = hour[0]/1;
    end = hour[1]/1;
    if (!end) end = start;
    for(x=start;x<=end;x++){
        if(!$('#nom_'+x).is(':disabled'))
            $('#nom_'+x).val(mw);
        var min_qty = $('#min_qty_'+x).val();
        var acc 	= $('#acc_'+x).val();

        if(($('#nom_'+x).val()/1 < min_qty || $('#nom_'+x).val()/1 > acc) && $('#nom_'+x).val() != '') {
            $('#err_nom_'+x).fadeIn('slow');
            $('#nom_'+x).parent().css('background-color','#DC241F');
        }else{
            $('#err_nom_'+x).fadeOut('slow');
            $('#nom_'+x).parent().css('background-color','#F0F2F5');
        }
    }
});


$('#btn_populate_clear').click(function(e){
    e.preventDefault();
    interval 	= $('#txt_interval').val();
    mw 			= $('#txt_nominations').val();

    hour = interval.split('-');
    start = hour[0]/1;
    end = hour[1]/1;
    if (!end) end = start;

    for(x=start;x<=end;x++){
        $('#err_nom_'+x).hide();
        $('#nom_'+x).parent().css('background-color','#F0F2F5');
    }
});
*/


</script>
