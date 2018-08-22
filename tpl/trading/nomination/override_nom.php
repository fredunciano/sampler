<div class="span3">
    <ul class="nav nav-tabs nav-stacked" >
        <?php
        foreach ( $submenu as $sm ) {
            echo '<li><a href="'.$base_url.$sm['link'].'">'.$sm['title'].'</a></li>';
        }
        ?>
    </ul>    
</div>
<form name="frm1" id="frm1">
<div class="span12">
    <legend><h4><?=$title?> <small>&nbsp;</small></h4></legend>
<!--     <div class="row-fluid">
        <div class="span2">File</div>
        <div class="span10">
            <div class="fileupload fileupload-new span6" data-provides="fileupload">
                <div class="input-append">
                    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
                    <span class="btn btn-file"><span class="fileupload-new">Select file</span>
                        <span class="fileupload-exists">Change</span><input type="file" name="filebrowser" id="filebrowser" />
                    </span>
                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                    <a href="#" class="btn fileupload-exists btn-primary" data-dismiss="fileupload" id="submit_file">Upload</a>       
                </div>
            </div>
        </div>
    </div> -->
    <div class="row-fluid">
        <div class="span2">File</div>
        <div class="span7 input-append">
            <div class = "fileupload fileupload-new span5" data-provides = "fileupload">
                <div class = "input-a   ppend">
                    <div class = "uneditable-input span3"><i class = "icon-file fileupload-exists"></i><span class = "fileupload-preview"></span></div>
                    <span class = "btn btn-primary btn-file"><span class = "fileupload-new">Select file</span>
                        <span class = "fileupload-exists">Change</span><input type = "file" name = "filebrowser" id = "filebrowser" />
                    </span>
                    <a href = "#" id="remove_file" class = "btn fileupload-exists" data-dismiss = "fileupload">Remove</a>
                    <input type="submit" id="submit_file" value="Upload" class="btn fileupload-exists btn-primary">
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="row-fluid">
        <div class="span2">Participant</div>
        <div class="span10">
            <select id="participant">
                <?php
                foreach ($participants as $p) {
                    echo '<option>'.$p->participant.'</option>';
                }
                ?>
            </select>
        </div>
    </div> -->
    <div class="row-fluid">
        <div class="span2">Customer</div>
        <div class="span10"><select id="customer"></select></div>
    </div>
    <div class="row-fluid">
        <div class="span2">Delivery Date</div>
        <div class="span10 input-append">
            <input type="text" id="sdate" name="sdate" value="<?=$def_date?>" class="input-small">
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
    <textarea id="remarks" name="remarks" class="editor"></textarea>
    <br />
    <input id="save_btn" type="button" value="Save" class="btn btn-primary"/> 
    <input id="export_btn" type="button" value="Export to XLS" class="btn btn-success" /> <span class="pls_wait"></span>
    <br><br><br>
</div>
</form>
<script src="../js/nicEdit.js"></script>
<script>
new nicEditors.allTextAreas({buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript','forecolor']});
$.extend({
    renderIntervals: function (s)
    {   
        $('.pls_wait').html('Please wait...' + ' &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        //$('#export_btn').hide();

        var url = 'http://' + location.host + '<?=$base_url?>' + '/buyer/nom_day_render_intervals'
        var parameters = "delivery_date=" + $('#sdate').val() + "&customer_id=" + $("#customer").val();

        $.ajax({
           type: "POST",
           url: url,
           data: parameters,
           success: function(msg){
                var ret = $.parseJSON(msg);
                var readonly = '';

                if(ret.allow_submit == false){
                    $('#upload_btn').attr('disabled', 'disabled');
                    $('#btn_populate_apply').attr('disabled', 'disabled');
                    $('#btn_populate_clear').attr('disabled', 'disabled');
                    $('#save_btn').attr('disabled', 'disabled');
                    $('#remarks').attr('disabled', 'disabled');
                    readonly = 'readonly';
                }else{
                    $('#upload_btn').removeAttr('disabled');
                    $('#btn_populate_apply').removeAttr('disabled');
                    $('#btn_populate_clear').removeAttr('disabled');
                    $('#save_btn').removeAttr('disabled');
                    $('#remarks').removeAttr('disabled');
                    readonly = '';
                }

                var nicE = new nicEditors.findEditor('remarks');
                nicE.setContent(ret.remarks);

                var t = '';
                var h = '';
                var total_mw = 0;

                $.each(ret.data,function(i, v){

                    //t += '<ul><li><a href="#tabs-1">'+i+'</a></li></ul>';

                    h += '<p class="text-info">Delivery Date: <b>'+$('#sdate').val()+'</b></p>'
                        + '<table class="table table-striped"><tr><th style="width:250px">Interval</th>'
                        + '<th>MAX Allocation of <br />Contracted Capacity (kW)</th>'
                        + '<th>MIN Allocation of <br />Contracted Capacity (kW)</th>'
                        + '<th colspan=2>Nomination (kW)</th>'
                        + '</tr>';

                    total_mw = 0;

                    $.each(v,function(x, val){
                    // if (val.mw == 0){
                    //     val.mw = '';
                    // }
                        h += '<tr>'
                            + '<td><b>'+val.delivery_hour_display+'</b></td>'
                            + '<td><input type="text" id="acc_'+x+'" name="acc_'+x+'" value="'+val.max_allow+'" readonly tabindex="-1" /></td>'
                            + '<td><input type="text" id="min_qty_'+x+'" name="min_qty_'+x+'" value="'+val.min_allow+'" readonly tabindex="-1" /></td>'
                            + '<td><input class="nomination value" id="nom_'+x+'" name="mw_'+x+'" type="text" value="'+val.mw+'" '+readonly+' /></td>'
                            // + '<td class="err_td" style="display:none; color:#FFFFFF; background:#DC241F; width:250px" id="err_nom_'+x+'">'
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
                //$("#tabs").tabs('destroy');
                //$("#tabs").tabs();

                //$("input.nomination").numeric();
                $('.pls_wait').html('');

           }
         });						
        return false;
    },
    save: function (s)
    {
        var nicE = new nicEditors.findEditor('remarks');
        final_remarks = nicE.getContent();

        $('.pls_wait').html('Please wait... ' + ' &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');

        var url = 'http://' + location.host + '<?=$base_url?>' + '/buyer/nom_day_save';
        var parameters = $('#frm1').serialize();

        $.ajax({
           type: "POST",
           url: url,
           data: parameters + "&remarks=" + final_remarks + "&customer_id=" + $("#customer").val(),
           success: function(msg){
                var message = JSON.parse(msg).message;
                if (message == "Nomination successfully saved.") {
                    $('.pls_wait').html('Successfully saved.');
                    var ret = $.parseJSON(msg);
                    var h = ret.message + '<br />'
                            + 'Transaction Id: ' + ret.transaction_id + '<br />'
                            + 'Type: ' + ret.type + '<br />'
                            + 'Relevant date: ' + ret.delivery_date + '<br /><br />';

                    $('#save_dialog_content').html(h);
                    setTimeout(function(){ $('.pls_wait').html(''); }, 3000);
                    // $('#save_dialog').dialog({width:300, modal:true, position:top});
                    $(".ui-dialog-titlebar").hide();
                    $('#close_dialog_btn').click(function(){
                        $('#save_dialog').dialog('close');
                    });
                } else {
                    $('.pls_wait').html(message);
                    setTimeout(function(){ $('.pls_wait').html(''); }, 3000);
                }
           }
         });						
        return false;
    },
    applyPopulateNominations : function()
    {
        var val_interval = $('#txt_interval').attr('value');
        val_interval = $.trim(val_interval);

        var val_nominations = $('#txt_mw').attr('value');
        val_nominations = $.trim(val_nominations);

        if ( val_interval.length > 0 && val_nominations.length > 0  ) {
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
                alert('Invalid interval value.');
                return false;
            }

            // if ( val_nominations.length <= 0 ) {
            //     alert('Invalid nominations value.');
            //     return false;
            // }
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
    listCustomers : function()
    {
        //$.post('../buyer/listParticipants',
        $.post('../trading_nomination/listCustomers',{participant:$('#participant').val()},
        function(data){
            //data = $.parseJSON(data)
            //console.log(data)
            //return false;
            $('#customer').html('');
            $.each(data.value, function(i,val){
                $('#customer').append('<option>'+val.name+'</option>')
            })
        });  
    }
    
});
</script>
<script type="text/javascript">

$.listCustomers();

$('#participant, #sdate').change(function(){
    //$.showContractedCapacity();
})

$('#participant').change(function(){
    $.listCustomers();
})

// $('input.nomination').live('blur', function(){
//     var n = $(this).attr('name');
//     n = n.split('_');

//     var x = n[1];
//     if(x < 1) return false;
//     var min_qty = $('#min_qty_'+x).val();
//     var acc 	= $('#acc_'+x).val();

//     if(($(this).val()/1 < min_qty || $(this).val()/1 > acc) || $(this).val() == '') {
//         $('#err_'+$(this).attr('id')).fadeIn('slow');
//         $(this).parent().css('background-color','#DC241F');
//     }else{
//         //alert('#err_'+$(this).attr('id'));
//         $('#err_'+$(this).attr('id')).fadeOut('slow');
//         $(this).parent().css('background-color','#F0F2F5');
//     }
// });

//$("#tabs").tabs();

setTimeout(function(){ $.renderIntervals();}, 1000);

$('#display_btn').click(function(){
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

//$('#export_btn').bind('click',function(){
//	var parameters = 'delivery_date='+Date.parse($('#delivery_date').attr('value')).toString("yyyy-MM-dd");
//	$.download('http://' + location.host + '/APC/spreadsheet/cust_day_ahead_nom.php',parameters);
//});

$('#save_btn').click(function(){
    var conf = confirm('Are you sure you want to submit?');
    if(conf){
        // for(x=1;x<=24;x++){
        //     var min_qty = $('#min_qty_'+x).val();
        //     var acc 	= $('#acc_'+x).val();

        //     if(($('#nom_'+x).val()/1 < min_qty || $('#nom_'+x).val()/1 > acc) && $('#nom_'+x).val() != '') {
        //         $('#err_nom_'+x).fadeIn('slow');
        //         $('#nom_'+x).parent().css('background-color','#DC241F');

        //     }
        // }

        // if($('td.err_td:visible').length < 1 && $('#nom_1').val() != '' && $('#nom_2').val() != '' && $('#nom_3').val() != '' 
        // && $('#nom_4').val() != '' && $('#nom_5').val() != '' && $('#nom_6').val() != '' && $('#nom_7').val() != '' 
        // && $('#nom_8').val() != '' && $('#nom_9').val() != '' && $('#nom_10').val() != '' && $('#nom_11').val() != '' 
        // && $('#nom_12').val() != '' && $('#nom_13').val() != '' && $('#nom_14').val() != '' && $('#nom_15').val() != '' 
        // && $('#nom_16').val() != '' && $('#nom_17').val() != '' && $('#nom_18').val() != '' && $('#nom_19').val() != '' 
        // && $('#nom_20').val() != '' && $('#nom_21').val() != '' && $('#nom_22').val() != '' && $('#nom_23').val() != ''
        // && $('#nom_24').val() != '')
        // {
        $.save();
        // }else{
        //     alert('Please enter a value greater than the Minimum Quantity and lower than or equal to ACC');
        // }

    }
    return false;
});

$('#frm1').submit(function(e){
    e.preventDefault();
    // if($('#filebrowser').val() == "") return false;

    var url = 'http://' + location.host + '<?=$base_url?>' + '/buyer/nom_template_parser';

    var options = {
        target:'',
        data: {template_type:'day_ahead'},
        url:url,
        beforeSubmit:	function() { 
            $('#resultbox').html('Loading...'); 
        },
        success:	function(data) {
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

// $('input.nomination').live('blur', function(){
//     var n = $(this).attr('name');
//     n = n.split('_');

//     var x = n[1];
//     if(x < 1) return false;
//     var min_qty = $('#min_qty_'+x).val();
//     var acc 	= $('#acc_'+x).val();

//     if(($(this).val()/1 < min_qty || $(this).val()/1 > acc) || $(this).val() == '') {
//         $('#err_'+$(this).attr('id')).fadeIn('slow');
//         $(this).parent().css('background-color','#DC241F');
//     }else{
//         //alert('#err_'+$(this).attr('id'));
//         $('#err_'+$(this).attr('id')).fadeOut('slow');
//         $(this).parent().css('background-color','#F0F2F5');
//     }
// });

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
$('#sdate').datepicker();	
	
	
</script>


