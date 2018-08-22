<style>
th.text-center, td.text-center {
	text-align: center;
}
</style>
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
    <form id="frm1" name="frm1" enctype="multipart/form-data" method="post">
    <input type="hidden" name="template_type" value="month_ahead">
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
        <div class="span2">Billing Period</div>
        <div class="span10">
            <select name="month" class="input-small">
                <?php
                    $billing_start = $default_date;
                    $billing_start = date_parse($billing_start);
                    for($x=1;$x<=12;$x++){
                        $time_tmp = mktime (0, 0, 0, $x+1 , 0, 0);
                        $month = date('F',$time_tmp);
                        $sel = (($billing_start['month']) == $x) ? 'selected=selected' : '';
                        echo '<option value="'.$x.'" '.$sel.' >'.$month .'</option>';
                    }
                ?>
            </select>
            <select name="year" class="input-small">
                <?php
                    for($x=2006;$x<=date('Y')+5;$x++){
                        $sel = ($billing_start['year'] == $x) ? 'selected=selected' : '';
                        echo '<option value="'.$x.'" '.$sel.' >'.$x.'</option>';
                    }
                ?>
            </select>	
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2"></div>
        <div class="span10"><button class="btn btn-primary" id="display_btn">Retrieve</button></div>
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
    <div class="row-fluid">
       
        <div class="span2"><button class="btn" id="checkall"><i class="icon-ok"></i>&nbsp;<span id="btn_text">Uncheck All</span></button></div>
        <div class="span10" id="month_date_selection" style="overflow:scroll"></div>
    </div>
    <br>
    <div class="row-fluid" id="result"></div>
    <br>
    <legend><h5>Remarks</h5></legend>
    <textarea id="remarks" name="remarks" class="editor"></textarea>
    <br />
  
    <input id="save_btn" type="button" value="Save" class="btn btn-primary"/> 
    <input id="export_btn" type="button" value="Export to XLS" class="btn btn-success" /> <span class="pls_wait"></span>
    </form>
    <br><br><br>
</div>

<script type="text/javascript">
	$(function(){
        $.listParticipants();
		//$("#tabs").tabs();
		$.renderIntervals();
		
		$('#display_btn').click(function(){
			$("#remove_file").trigger('click');
			$.renderIntervals();
		});
		
		$('#save_btn').click(function(){
			var conf = confirm('Are you sure you want to submit?');
			if(conf){
				if($('#nom_1').val() != '' && $('#nom_2').val() != '' && $('#nom_3').val() != '' 
				&& $('#nom_4').val() != '' && $('#nom_5').val() != '' && $('#nom_6').val() != '' && $('#nom_7').val() != ''
				&& $('#nom_8').val() != '' && $('#nom_9').val() != '' && $('#nom_10').val() != '' && $('#nom_11').val() != '' 
				&& $('#nom_12').val() != '' && $('#nom_13').val() != '' && $('#nom_14').val() != '' && $('#nom_15').val() != '' 
				&& $('#nom_16').val() != '' && $('#nom_17').val() != '' && $('#nom_18').val() != '' && $('#nom_19').val() != '' 
				&& $('#nom_20').val() != '' && $('#nom_21').val() != '' && $('#nom_22').val() != '' && $('#nom_23').val() != ''
				&& $('#nom_24').val() != ''){
					$.save();
				}else{
					alert('Please enter a value');
				}
			}
			return false;
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
			var tmp = $(this).attr('name').split('_');
			var identifier = tmp[1];
			$.updateTotalNominationValue(identifier);
		});
		
		
		/*$('#export_btn').die('click').live('click',function(){
			var parameters = 'month='+$('#frm1 select[name=month]').val()+'&year='+$('#frm1 select[name=year]').val();
			$.download('http://' + location.host + '/APC/spreadsheet/cust_month_ahead_nom.php',parameters);
		});*/
		
	$('#frm1').submit(function(e){
		e.preventDefault();
			 
			if($('#filebrowser').val() == "") return false;
			 
			var url = 'http://' + location.host + '<?=$base_url?>' + '/buyer/nom_template_parser';
		
			var options = {
				target:'',
				url:url,
				beforeSubmit:	function() { 
					$('#resultbox').html('Loading...'); 
				},
				success:	function(data) {
					//console.log(data); 
					//alert(data);
					var ret = $.parseJSON(data);
					var j =0;
					$.each(ret, function(i, val){
						//console.log(val);
						
						$.each(val.nom, function(x, val2){
							val2 = parseFloat(val2).toFixed(3)
							
							//alert(val2);
							//alert('mw_'+j+'_'+x);
							$('input[name=mw_'+j+'_'+x+']').val(val2);
							$.updateTotalNominationValue(i);
							
						});
						
						j++;
					});
					$('#resultbox').html('');
					bootbox.alert("Uploaded sucessfully");
				}
			};
			$("#frm1").ajaxSubmit(options);
		});
	});
				
		
		$('input.nomination').live('change',function () { 
			$(this).val(function(i, v) { 
				if(v){
					return parseFloat(v).toFixed(3); 
				}
			});
		});
	
	
	$.extend({
		renderIntervals: function (s)
		{
			
			//alert(s);
			$('.pls_wait').html('Please wait...');
			//$('#export_btn').hide();
			
			var url = 'http://' + location.host + '<?=$base_url?>' + '/buyer/nom_month_render_intervals'
			var parameters = 'month='+$('select[name=month]').val()+'&year='+$('select[name=year]').val();
			
			$.ajax({
			   type: "POST",
			   url: url,
			   data: parameters,
			   success: function(msg){
			   	//console.log(msg)
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
					//$('#remarks').val(ret.remarks);
					 $('#remarks').html(ret.remarks);
					var t = '<ul>';
					var h = '';
					var d = '';
					var total_mw = 0;
					var j = 0;
                    var date_selection = '';
                    var month_sel = '';
                    var tab_title = '';
                    var tab_content = '';
                    var x = 0;
                   /*
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
					}*/
                   // $('#remarks').val(ret.remarks);
                
                    tab_title+='<div style="overflow:scroll;width:100%">';
                    tab_title+='<ul class="nav nav-tabs" style="width:3150px">';
                    tab_content+='<div class="tab-content">';
                    
					$.each(ret,function(i, val){
                        x++;

                        if (i === 'remarks') {
                        	return true;
                        }
                        if (x==1) {
                            active = 'active';
                        } else {
                            active = '';
                        }
                        
                        d = i;
                        
                        tab_title+='<li class="'+active+'"><a href="#c'+x+'" data-toggle="tab">'+d+'</a></li>';
                        tab_content+='<div class="tab-pane '+active+'" id="c'+x+'">'+
                                        '<p class="text-center text-info">Delivery Date : <b>'+d+'</b></p>'+
                                        '<table class="table table-striped">'+
                                        '<tr>'+
                                        '<th class="text-center">Interval</th>'+
                                        '<th class="text-center">Nomination</th>'+
                                        '</tr>'
                        
                        $.each(val,function(i2, val2){
							
							tab_content += '<tr>'
                                        +'<th class="text-center">'+val2.delivery_hour_display+'</th>'
        								+'<td class="text-center"><input id="nom_'+i2+'" class="nomination value" name="mw_'+j+'_'+i2+'" value="'+val2.mw+'" type="text" /></td>'
                						+'</tr>';
								
							total_mw = total_mw + ($.trim(val2.mw).length > 0 ? parseFloat(val2.mw) : 0 );
	
							if ( $.trim(val2.mw).length > 0 ){
								$('#export_btn').show();
							}
							
						});
                        
                        tab_content+='</table></div>';
                        
                        date_selection+='<option>'+d+'</option>';

						//d = i.replace('-','').replace('-','');
                        
                        //month_sel += '<label class="checkbox inline"><input type="checkbox" checked name="chk_mday" class="chk-sidebyside" date="'+ d  +'" value="mday'+ j +'" /> ' + d + '&nbsp;</label>';
						month_sel += '<label class="checkbox inline"><input type="checkbox" checked name="rdo_populate" class="chk-sidebyside" date="'+ d  +'" value="mday'+ j +'" /> ' + d + '&nbsp;</label>';
						
			
						t += '<li><a href="#tabs-'+j+'">'+d+'</a></li>';
						
						h += '<div id="tabs-'+j+'" class="tab_content" style="height:auto;overflow:hidden">'
							+ '<table id="tt'+j+'" class="list" cellpadding=0 cellspacing=1 width="100%" ><tr><td width="130">Interval</td>'
							//+ '<td>Min. Allow.<br />Nomination</td>'
							//+ '<td>Max. Allow.<br />Nomination</td>'
							+ '<td>Nomination</td>'
							+ '</tr>';
							
						total_mw = 0;
						
						$.each(val,function(x, val2){
							
							h += '<tr>'
								+ '<td class="bg2">'+val2.delivery_hour_display+'</td>'
								//+ '<td class="bg1 value"><input id="acc_'+j+'_'+x+'" name="acc_'+j+'_'+x+'" value="'+val2.max_allow+'" readonly tabindex="-1" /></td>'
								//+ '<td class="bg1 value"><input id="min_qty_'+j+'_'+x+'" name="min_qty_'+j+'_'+x+'" value="'+val2.min_allow+'" readonly tabindex="-1" /></td>'
								
								//alert('mw_'+j+'_'+x);
								
								+ '<td style="text-align:left"><input id="nom_'+x+'" class="nomination value" name="mw_'+j+'_'+x+'" value="'+val2.mw+'" type="text" /></td>'
								+ '</tr>';
								
							total_mw = total_mw + ($.trim(val2.mw).length > 0 ? parseFloat(val2.mw) : 0 );
	
							if ( $.trim(val2.mw).length > 0 ){
								$('#export_btn').show();
							}
							
						});
	
	
						// for total
						total_mw = total_mw.toFixed(3);
						total_mw =total_mw.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
						
						h += '<tr>'
							+ '<td colspan="1" style="text-align: right">Total :</td>'
							+ '<td><input class="value" disabled="true" id="total_mw_'+j+'" type="text" value="'+total_mw+'"/></td>'
							+ '</tr>'
							+ '</table></div>';
						
						j++;
						
						h += '</table></div>';
					});
                    
                    tab_title+='</ul></div>';
                    tab_content+='</div>';
                    
                    //$('#date_selection').html(date_selection)
                    $('#result').html(tab_title+tab_content)
                    $('#month_date_selection').html('<div style="width:3150px">'+month_sel+'</div>');
					
					t += '</ul>';
					
					//$("#tabs").html(t+h);
					//$("#tabs").tabs('destroy');
					//$("#tabs").tabs();
					
                    
					//$("input.nomination").numeric();
					$('.pls_wait').html('');
			   }
               
			 });						
			return false;
		}
	});
	
	
	$.extend({
		save: function ()
		{
			$('.pls_wait').html('Please wait...');
			
			var url = 'http://' + location.host + '<?=$base_url?>' + '/buyer/nom_month_save';
			var parameters = $('#frm1').serialize();
			
			//console.log(parameters);
			
			$.ajax({
			   type: "POST",
			   url: url,
			   data: parameters,
			   success: function(msg){
					//console.log(msg);
					var ret = $.parseJSON(msg);
					var h = ret.message + '<br />'
							+ 'Transaction Id: ' + ret.transaction_id + '<br />'
							+ 'Type: ' + ret.type + '<br />'
							+ 'Relevant date: ' + ret.delivery_date + '<br /><br />'
							;
             	 	$('#alert-msg').html(ret.message);
                	bootbox.alert(h)
					$('.pls_wait').html('');
					/*$('#save_dialog_content').html(h);
					$('.pls_wait').html('');
					$('#save_dialog').dialog({width:300, modal:true, position:top});
					$(".ui-dialog-titlebar").hide();
					$('#close_dialog_btn').click(function(){
						$('#save_dialog').dialog('close');
					}); */
			   }
			 });						
			return false;
		}
	});
	
	$.extend({
		applyPopulateNominations : function()
		{
			// validate if at least one checkbox was selected
			if ( $('input[name="rdo_populate"]:checked').length > 0 ) {
	
				//validate other fields
				var val_interval = $('#txt_interval').attr('value');
				val_interval = $.trim(val_interval);
	
				//var val_nominations = $('#txt_nominations').attr('value');
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
	
					if ( val_nominations.length <= 0 ) {
						alert('Invalid nominations value.');
						return false;
					}
				}
			} else {
				alert('Please select at least one week date checkbox.');
			}
		}
		,updateNominationInputValues : function(start,end,apply_value)
		{
			$('input[name="rdo_populate"]:checked').each(function(){
				var chk_value =$(this).attr('value');
				var id = chk_value.replace(/mday/gi, "mw_");
				var identfier = chk_value.replace(/mday/gi, "");
				for (var i=start; i<=end; i++){
					$('input[name="'+ id+'_'+i +'"]').attr('value',apply_value);
					
					if(apply_value == ''){
						//alert(id+'_'+i);
						var tmp = id.replace("mw_", "");
						$('#err_nom_'+tmp+'_'+i).hide();
						$('#nom_'+tmp+'_'+i).parent().css('background-color','#F0F2F5');
					}
				}
	
				$.updateTotalNominationValue(identfier);
	
			});
			
			/*var rdo_populate_opt_value = $('input[name="rdo_populate"]:checked').val().toLowerCase();
			rdo_populate_opt_value = $.trim(rdo_populate_opt_value);
	
			if (rdo_populate_opt_value === 'current') {
				var id = $('li.ui-tabs-selected a').attr('href') ; // eg #tabs-18
				id = id.replace(/mday-/gi, "");
				var id_prefix = 'mw_'+id+'_';
	
				for (var i=start; i<=end; i++){
					$('input[name="'+ id_prefix+i +'"]').attr('value',apply_value);
				}
	
				$.updateTotalNominationValue(id);
	
			}   else if (rdo_populate_opt_value === 'all'){
	
				$('#tabs>ul a').each(function(){
					var id = $(this).attr('href');
					id = id.replace(/#tabs-/gi, "");
					var id_prefix = 'mw_'+id+'_';
	
					for (var i=start; i<=end; i++){
						$('input[name="'+ id_prefix+i +'"]').attr('value',apply_value);
					}
	
					$.updateTotalNominationValue(id);
				});
	
			}*/
		}
		,clearPopulateValues : function()
		{
			if ( $('input[name="rdo_populate"]:checked').length > 0 ) {
	
				//validate other fields
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
			} else {
				alert('Please select at least one week date checkbox.');
			}
		}
		,updateTotalNominationValue : function(container_identifier)
		{
			var total_mw = 0;
			$('input[name^="mw_'+ container_identifier +'_"]').each(function() {
				var cur_value = $(this).val();
				total_mw = total_mw + (  $.trim(cur_value).length > 0 ? parseFloat(cur_value) : 0 );
			});
	
			total_mw = total_mw.toFixed(3);
			total_mw =total_mw.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	
			$('#total_mw_'+ container_identifier).val(total_mw);
		}
	});
	
	
	/***
	 * Validations
	 */
	$.extend({
		validateIntervalEntry : function(interval_inp){
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
	
	
$('#checkall').toggle(
    function() {
        $('input[type="checkbox"]').attr('checked',false);
        $('#btn_text').text('Check All')
   
    },
    function() {
        $('input[type="checkbox"]').attr('checked',true);
        $('#btn_text').text('Uncheck All')
    }
);	
</script>


