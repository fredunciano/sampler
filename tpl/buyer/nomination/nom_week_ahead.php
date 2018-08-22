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
    <input type="hidden" name="template_type" value="week_ahead">
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
            <input type="text" id="sdate" name="sdate" value="<?=$default_date?>" class="input-small">
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
    <div class="row-fluid">
        <div class="span2"><button class="btn" id="checkall"><i class="icon-ok"></i>&nbsp;<span id="btn_text">Uncheck All</span></button></div>
        <div class="span10" id="week_date_selection"></div>
    </div>
    <br>
    <div class="row-fluid" id="result"></div>
    <br>
    <legend><h5>Remarks</h5></legend>
    <textarea id="remarks" name="remarks" class="editor"></textarea>
    <br />
    <input id="save_btn" type="button" value="Submit" class="btn btn-primary"/>
    <!--input id="export_btn" type="button" value="Export to XLS" class="btn btn-success" /--> <span class="pls_wait"></span>
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

    $('#save_btn').click(function(){
        var conf = confirm('Are you sure you want to submit?');
        var error_count = 0;

       // Removed for validation : billy

       if(conf){
        for(y=0;y<=6;y++){
            for(x=1;x<=24;x++){
                var min_qty = $('#min_qty_'+y+'_'+x).val();
                var acc 	= $('#acc_'+y+'_'+x).val();
		}
		// Removed for validation : billy
		/*
                if(($('#nom_'+y+'_'+x).val()/1 < min_qty || $('#nom_'+y+'_'+x).val()/1 > acc) && $('#nom_'+y+'_'+x).val() != '') {
                    $('#err_nom_'+y+'_'+x).fadeIn('slow');
                    $('#nom_'+y+'_'+x).parent().css('background-color','#DC241F');
                }
            }


            if($('td.err_td:visible').length < 1 &&

            $('#nom_'+y+'_1').val() != '' && $('#nom_'+y+'2').val() != '' && $('#nom_'+y+'3').val() != ''
            && $('#nom_'+y+'4').val() != '' && $('#nom_'+y+'5').val() != '' && $('#nom_'+y+'6').val() != '' && $('#nom_'+y+'7').val() != ''
            && $('#nom_'+y+'8').val() != '' && $('#nom_'+y+'9').val() != '' && $('#nom_'+y+'10').val() != '' && $('#nom_'+y+'11').val() != ''
            && $('#nom_'+y+'12').val() != '' && $('#nom_'+y+'13').val() != '' && $('#nom_'+y+'14').val() != '' && $('#nom_'+y+'15').val() != ''
            && $('#nom_'+y+'16').val() != '' && $('#nom_'+y+'17').val() != '' && $('#nom_'+y+'18').val() != '' && $('#nom_'+y+'19').val() != ''
            && $('#nom_'+y+'20').val() != '' && $('#nom_'+y+'21').val() != '' && $('#nom_'+y+'22').val() != '' && $('#nom_'+y+'23').val() != ''
            && $('#nom_'+y+'24').val() != ''

            )
            {
                error_count = 0;
            }else{
                error_count = 1;
            }
            }

            if (error_count == 0){
                $.save();

            }else{
                alert('Please enter a value greater than the Minimum Quantity and lower than or equal to ACC');
            }


        }*/

        //$('#week_date_selection').html(weekday_sel);
       // return false;
       		}
        	$.save();
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
        var parameters = 'delivery_date='+Date.parse($('#delivery_date').attr('value')).toString("yyyy-MM-dd");
        $.download('http://' + location.host + '/APC/spreadsheet/cust_week_ahead_nom.php',parameters);
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
                var ret = $.parseJSON(data);
                $.each(ret, function(i, val){
                    $.each(val.mw, function(j, val2){
                        val2 = parseFloat(val2).toFixed(3)
                        $('input[name=mw_'+i+'_'+j+']').val(val2)
                        $.updateTotalNominationValue(i);
                    });
                });
                $('#resultbox').html('');
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
		/*
		$('input.nomination').live('blur', function(){
			var n = $(this).attr('name');
			n = n.split('_');

			var i = n[1];
			var x = n[2];
			if(x < 1) return false;
			var min_qty = $('#min_qty_'+i+'_'+x).val();
			var acc 	= $('#acc_'+i+'_'+x).val();

			if(($(this).val()/1 < min_qty || $(this).val()/1 > acc) || $(this).val()=='') {
				$('#err_'+$(this).attr('id')).fadeIn('slow');
				$(this).parent().css('background-color','#DC241F');
			}else{
				$('#err_'+$(this).attr('id')).fadeOut('slow');
				$(this).parent().css('background-color','#F0F2F5');
			}
		});
		*/
	/*
		$('#btn_populate_apply').bind('click',function(e){
			e.preventDefault();

			$('input[name="chk_wday"]:checked').each(function(){
				var chk_value =$(this).attr('value');
				var id = chk_value.replace(/wday/gi, "mw_");
				var identfier = chk_value.replace(/wday/gi, "");

				//var selected_tab_index = $("#tabs").tabs('option', 'selected') + 1;
				var selected_tab_index = identfier;
				var interval 	= $('#txt_interval').val();
				var mw 		= $('#txt_mw').val();
				var hour = interval.split('-');
				var start = hour[0]/1;
				var end = hour[1]/1;
				if (!end) end = start;

				for(x=start;x<=end;x++){
					if(!$('#nom_'+selected_tab_index+'_'+x).is(':disabled'))
						$('#nom_'+selected_tab_index+'_'+x).val(mw);
					var min_qty = $('#min_qty_'+selected_tab_index+'_'+x).val();
					var acc 	= $('#acc_'+selected_tab_index+'_'+x).val();

					if(($('#nom_'+selected_tab_index+'_'+x).val()/1 < min_qty || $('#nom_'+selected_tab_index+'_'+x).val()/1 > acc) && $('#nom_'+selected_tab_index+'_'+x).val() != '') {
						$('#err_nom_'+selected_tab_index+'_'+x).fadeIn('slow');
						$('#nom_'+selected_tab_index+'_'+x).parent().css('background-color','#DC241F');
					}else{
						$('#err_nom_'+selected_tab_index+'_'+x).fadeOut('slow');
						$('#nom_'+selected_tab_index+'_'+x).parent().css('background-color','#F0F2F5');
					}
				}
			});
		});
		*/
	//try
		$('#btn_populate_clear').bind('click',function(e){
			e.preventDefault();
			$('input[name="chk_wday"]:checked').each(function(){
				var chk_value =$(this).attr('value');
				var id = chk_value.replace(/wday/gi, "mw_");
				var identfier = chk_value.replace(/wday/gi, "");

				//var selected_tab_index = $("#tabs").tabs('option', 'selected') + 1;
				var selected_tab_index = identfier;
				var interval 	= $('#interval').val();
				var mw 		= $('#nom_txt_mw').val();
				var hour = interval.split('-');
				var start = hour[0]/1;
				var end = hour[1]/1;
				if (!end) end = start;

				for(x=start;x<=end;x++){
					$('#nom_'+selected_tab_index+'_'+x).val('');
					$('#err_nom_'+selected_tab_index+'_'+x).hide();
					$('#nom_'+selected_tab_index+'_'+x).parent().css('background-color','#F0F2F5');
				}

			});
		});

	});


	$.extend({
		renderIntervals: function (s)
		{
			$('.pls_wait').html('Please wait...');
			//$('#export_btn').hide();

			var url = 'http://' + location.host + '<?=$base_url?>' + '/buyer/nom_week_render_intervals'
			var parameters = "sdate=" + $('#sdate').val();

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

					$('#remarks').val(ret.remarks);

					var t = '<ul>';
					var h = '';
					var x = 0;
					var d = '';
					var j = 0;

					var weekday_sel = '';
					var total_mw = 0;

                    var tab_title = '';
                    var tab_content = '';

                    tab_title+='<ul class="nav nav-tabs">';
                    tab_content+='<div class="tab-content">';

					$.each(ret.data,function(i, v){
						x++;
                        if (x==1) {
                             active = 'active';
                         } else {
                             active = '';
                         }
						//d = i.replace('-','').replace('-','');
                        d = i;

						t += '<li><a href="#tabs-'+j+'">'+d+'</a></li>';

                        tab_title+='<li class="'+active+'"><a href="#c'+x+'" data-toggle="tab">'+d+'</a></li>';
                        tab_content+='<div class="tab-pane '+active+'" id="c'+x+'">'+
                                        '<p class="text-center text-info">Delivery Date : <b>'+d+'</b></p>'+
                                        '<table class="table table-striped">'+
                                        '<tr>'+
                                        '<th>Interval</th>'+
                                        '<th>MAX Allocation of <br />Contracted Capacity (kW)</th>'+
                                        '<th>MIN Allocation of <br />Contracted Capacity (kW)</th>'+
                                        '<th>Week Ahead <br />Nomination (kW)</th>'+
                                        '</tr>'

						//weekday_sel += '<input type="checkbox" name="chk_wday" class="chk-sidebyside" value="wday'+ j +'" /> ' + d;

						h += '<div id="tabs-'+j+'" class="tab_content" style="height:auto;overflow:hidden">'
							+ '<table id="tt'+j+'" class="list" cellpadding=0 cellspacing=1 width="100%" ><tr><td>Interval</td>'
							+ '<td>Allocation of <br />Contracted Capacity (kW)</td>'
							+ '<td>Min. Allowable <br />Nomination (kW)</td>'
							+ '<td colspan=2>Week Ahead <br />Nomination (kW)</td>'
							+ '</tr>';

						total_mw = 0;

						$.each(v, function(x, val){
							tab_content += '<tr>'
								+ '<td><b>'+val.delivery_hour_display+'</b></td>'
								+ '<td><input id="acc_'+j+'_'+x+'" name="acc_'+j+'_'+x+'" value="'+val.max_allow+'" readonly tabindex="-1" type="text"/></td>'
								+ '<td><input id="min_qty_'+j+'_'+x+'" name="min_qty_'+j+'_'+x+'" value="'+val.min_allow+'" readonly tabindex="-1" type="text" /></td>'
								+ '<td><input id="nom_'+j+'_'+x+'" name="mw_'+j+'_'+x+'" value="'+val.mw+'" type="text" '+readonly+' /></td>'
								//+ '<td class="err_td" style="display:none; color:#FFFFFF; background:#DC241F; width:250px" id="err_nom_'+j+'_'+x+'">'
								//+ 'Please enter a value greater than the Minimum Quantity and lower than or equal to ACC'
								+ '</td>'
								+ '</tr>';

							total_mw = total_mw + ($.trim(val.mw).length > 0 ? parseFloat(val.mw) : 0 );

						});

						// for total
						total_mw = total_mw.toFixed(3);
						total_mw =total_mw.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

						h += '<tr>'
							+ '<td colspan="3" style="text-align: right">Total :</td>'
							+ '<td colspan="2"><input class="value" disabled="true" id="total_mw_'+j+'" type="text" value="'+total_mw+'"/></td>'
							+ '</tr>'
							+ '</table></div>';

                        tab_content+='</table></div>';
                       	weekday_sel += '<label class="checkbox inline"><input type="checkbox" checked name="chk_wday" class="chk-sidebyside" date="'+ d  +'" value="wday'+ j +'" /> ' + d + '&nbsp;</label>';

						j++;
					});

                    tab_content+='</div>';
                    tab_title+='</ul>';

					t += '</ul>';

					//$("#tabs").html(t+h);
					//$("#tabs").tabs('destroy');
					//$("#tabs").tabs();

					$('#week_date_selection').html(weekday_sel);
					//$("input.nomination").numeric();
					$('#result').html(tab_title+tab_content)
					$('.pls_wait').html('');

			   },error: function(jqXHR, textStatus, errorThrown){
                    alert("Error:" + jqXHR.responseText );
                 }
			 });

			return false;
		}
	});

	$.extend({
		save: function ()
		{
			$('.pls_wait').html('Please wait...');

			var url = 'http://' + location.host + '<?=$base_url?>' + '/buyer/nom_week_save';
			var parameters = $('#frm1').serialize();

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
                    $('.pls_wait').html('Successfully Updated');
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
			if ( $('input[name="chk_wday"]:checked').length > 0 ) {

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
			$('input[name="chk_wday"]:checked').each(function(){
				var chk_value =$(this).attr('value');
				var id = chk_value.replace(/wday/gi, "mw_");
				var identfier = chk_value.replace(/wday/gi, "");
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
		}
		,clearPopulateValues : function()
		{
			if ( $('input[name="chk_wday"]:checked').length > 0 ) {

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

	$.extend({
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
