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
    <section id="global">
        <form id="frm1" method='post' name='frm1' enctype="multipart/form-data" onsubmit='return false'>
        <legend><h4><?=$title?> <small>( Bids and Offers )</small></h4></legend>
        <div class="row-fluid">
            <div class="span2">Date</div>
            <div class="span10">
                <input type="text" name="sdate" id="sdate" value="<?=$sdate?>" class="datetext" readonly> 
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Action</div>
            <div class="span7">
                <select name="action" class="span3">
                    <option value="submit">SUBMIT</option>
                    <option value="cancel">CANCEL</option>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Units</div>
            <div class="span7">
                <?php
                foreach($resources as $resource){
                	echo '<label class="radio inline"><input name="resource_id" type="radio" value="'.$resource->resource_id.'"/>';
                	echo $resource->resource_id . '</label> ';
                }
                ?>
            </div>
        </div><br>
        <div class="row-fluid">
            <div class="span2"></div>
            <div class="span7">
                <a class="btn btn-primary" href="#" id="retrieve_btn"><i class="icon-arrow-down icon-white"></i>&nbsp;Retrieve</a>
                <span id="pls_wait_retrieve"></span>
            </div>
        </div><br>
        
        <legend>Populate Values</legend>
        <div class="row-fluid">
            <div class="input-prepend input-append">
                <div class="btn-group">
                <button class="btn dropdown-toggle" data-toggle="dropdown">
                  Select
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#" value="web-price_qty" class="drop-down">A) Price/Quantity</a></li>
                    <li><a href="#" value="web-ramp_rate" class="drop-down">B) Ramp Rate</a></li>
                    <li><a href="#" value="web-remarks" class="drop-down">C) Remarks</a></li>
                </ul>
                <span id="auto-options" class="uneditable-input span2" value="web-price_qty">A) Price/Quantity</span>
                <input id="tmp_content" type="text" class="span7" value="1-24,(2000.00,120.0),(2000.00,125.0),(3000.00,300.0);"/> 
                <button id="update_btn" type="button" class="btn">Update</button> 
                <button id="clear_btn" type="button" class="btn">Clear</button> 
                </div>
            </div>
        </div><br>
        <legend>Offer</legend>
        <ul class="nav nav-tabs" id="tabs">
            <li class="active" id="web"><a href="#web_content" data-toggle="tab" id="web_format_btn">Web</a></li>
            <li id="xml"><a href="#xml_content" data-toggle="tab" id="xml_format_btn">XML</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="web_content">
                <table class="table table-hover table-condensed table-bordered">
                    <thead>
					<tr >
                        <th>Hour <br /><label class="checkbox"><input id="check_all" type="checkbox" /> All</label></th>
                        <th><h6>Price / Quantity</h6></th>
						<th><h6>Ramp Rate</h6></th>
						<th><h6>Remarks</h6></th>
					</tr>
                    </thead>
                    <tbody>
					<?php
					for($i=1; $i<=24; $i++){
					
						$disabled = '';
                        $readonly = '';
					
						if(strtotime($sdate) < strtotime(date('Ymd'))){
							$disabled = 'disabled="disabled"';
                            $readonly = 'readonly="readonly"';
						
						}else if(strtotime($sdate) <= strtotime(date('Ymd')) && $i < $gate_closure['interval']){
							$disabled = 'disabled="disabled"';
                            $readonly = 'readonly="readonly"';
						}
						
						$bgcolor = ($i%2==0) ? '#EEEEEE' : '#F3F7EA';
					
						echo '<tr id="tr'.$i.'">
                              <td>
                                  <label class="checkbox">
                                  <input name="go-'.$i.'" id="go-'.$i.'" type="checkbox" value="1" '.$disabled.'/> '.$i.'
                                  </label>
                              </td>
                              <td>
                                  <input name="web-price_qty-'.$i.'" type="text" class="input-xxlarge" '.$readonly.' />
                              </td>
                              <td>
                                  <input name="web-ramp_rate-'.$i.'" type="text" class="input-small" '.$readonly.' />
                              </td>
                              <td>
                                  <input name="web-remarks-'.$i.'" type="text" class="input-medium" '.$readonly.' />
                              </td>
                              </tr>';
					}
					?>
                    </tbody>
				</table>
            </div>
            <div class="tab-pane" id="xml_content">
                <textarea name="xml" rows="20" style="width:95%;background-color:#F9F9D6;font-size:12px"><?php echo $xml_tmp ?></textarea>
            </div>
            
        </div>
        <button id="submit_offer" class="btn span2 btn-primary">Submit</button>
        <div id="result"></div>
        <div id="grid_data" class="container" style="margin-top: 10px"></div>
        </form>
        <span id="pls_wait_submit" style="background-color:yellow"></span>
        <div id="confirm_dialog" style="display:none" title="WESM RESPONSE CONFIRMATION">
            <div id="confirm_details_container" style="text-align:center; margin-top:20px" >Please wait...</div>
        </div>
    </section>
</div>

<script>
	$('a.drop-down').click(function(e){
        e.preventDefault();
        $('#auto-options').html($(this).html())
        $('#auto-options').attr('value',$(this).attr('value'))
        
        var auto_options = $(this).attr('value');
        
        switch(auto_options){
			case "web-price_qty":
				$('#tmp_content').val('1-24,(2000.00,120.0),(2000.00,125.0),(3000.00,300.0);');
			break;
			
			case "web-ramp_rate":
				$('#tmp_content').val('1-24,(300.0,3.0,3.0);');
			break;
			
			case "web-remarks":
				$('#tmp_content').val('1-24,Other reasons');
			break;
		}
        
    })
	$('#update_btn').click(function(e){
		e.preventDefault();
		var auto_options = $('#auto-options').attr('value');
		var tmp_content = $('#tmp_content').val();
		var del = ',';
		
		
		
		var tmp_arr = tmp_content.split(del);
		var interval_arr = tmp_arr[0].split('-');
		tmp_content = tmp_content.replace(tmp_arr[0]+del,'');
		
		if(!interval_arr[1]) interval_arr[1] = interval_arr[0];
		if(interval_arr[1]/1 < interval_arr[0]/1) return false;
		
		for(var i=interval_arr[0]/1; i<=interval_arr[1]/1; i++){
			if($('input[name=go-'+i+']').attr("disabled") != "disabled"){
				$('input[name=go-'+i+']').attr('checked','checked');
				$('input[name='+auto_options+'-'+i+']').val(tmp_content);
			}
		}
	});

	$('#clear_btn').click(function(e){
        e.preventDefault();
		$('input.go').removeAttr('checked');
	
		var auto_options = $('#auto-options').attr('value');
		var tmp_content = $('#tmp_content').val();
		var del = ',';
		
		var tmp_arr = tmp_content.split(del);
		var interval_arr = tmp_arr[0].split('-');
		
		if(!interval_arr[1]) interval_arr[1] = interval_arr[0];
		if(interval_arr[1]/1 < interval_arr[0]/1) return false;
		
		for(var i=interval_arr[0]/1; i<=interval_arr[1]/1; i++){
			$('input[name=go-'+i+']').removeAttr('checked');
			$('input[name='+auto_options+'-'+i+']').val('');
		}
		
	});	
    
	$('#check_all').bind('change', function(){
		var chk = $(this).attr('checked');
		
		if(chk){
			//$('input.go').attr('checked', 'checked');
            $('input[type=checkbox]').attr('checked', 'checked');
		}else{
			//$('input.go').removeAttr('checked');
            $('input[type=checkbox]').removeAttr('checked');
		}
		return false;
	});
	
	
	$('#web_format_btn').bind('click', function(){
		$('input.remarks').val('');
		$('input.price_qty').val('');
		$('input.ramp_rate').val('');
		$.getContent('web');
		
	});
	
	$('#xml_format_btn').bind('click', function(){
		$('textarea[name=xml]').val('');
		$.getContent('xml');
	});
	
	$.extend({
		getContent: function (view){
			var url = 'http://' + location.host + '<?=$base_url?>' + '/trading/offer_content';
			var parameters = $('#frm1').serialize() + '&view=' + view;
			
			$.ajax({
			   type: "POST",
			   url: url,
			   data: parameters,
			   success: function(msg){
					//console.log(msg);
					
					if(view == 'web'){
						var ret = $.parseJSON(msg);
						
						if(ret.web != undefined){
							$.each(ret.web[0].intervals, function(i, val){
								if(val.gate_closure=="open"){
									$('input[name=go-'+i+']').attr('checked','checked');
								}else{
									$('input[name=go-'+i+']').attr('disabled','disabled');
									$('input[name=web-price_qty-'+i+']').attr('disabled','disabled');
									$('input[name=web-ramp_rate-'+i+']').attr('disabled','disabled');
									$('input[name=web-remarks-'+i+']').attr('disabled','disabled');
								}
								$('input[name=web-price_qty-'+i+']').val(val.price_quantity);
								$('input[name=web-ramp_rate-'+i+']').val(val.ramp_rate);
								$('input[name=web-remarks-'+i+']').val(val.remarks);
							});
						}
						
			   		}else{
			   			var decoded = $("<div/>").html(msg).text();
			   			$('textarea[name=xml]').val(decoded);
			   		}
			   		$('#resultbox').html(''); 
			   }
			 });						
			return false;
		}
	});
	
	$('#submit_offer').unbind('click').bind('click', function(){
		
		if(!$('input[name=resource_id]:checked').val()){
			alert("Resource is required.");
			return false;
		}
	
		var action = $("select[name=action]").val();
		var conf = confirm('Are you sure you want to '+action+'?');
		
		if(conf){
			$('#pls_wait_submit').html('Please wait...');
			//var selected_tab = $('#tabs').tabs('option', 'selected');
            var selected_tab = $("#tabs li.active").attr('id')
			var url = 'http://' + location.host + '<?=$base_url?>' + '/trading/submit_offer';
			var parameters = $('#frm1').serialize() + '&view=' + selected_tab;
			//console.log(parameters);
			$.ajax({
			   type: "POST",
			   url: url,
			   data: parameters,
			   success: function(msg){
                   //console.log(msg)
                   bootbox.alert(msg)
			   		//$('#confirm_details_container').html(msg);
					//$('#confirm_dialog').dialog({width:550,height:420});
					$('#pls_wait_submit').html('');
				}
			 });	
		 }
		return false;
	});
	
	$('#retrieve_btn').unbind('click').bind('click', function(){
		
		if(!$('input[name=resource_id]:checked').val()){
			alert("Resource is required.");
			return false;
		}
		
		//var selected_tab = $('#tabs').tabs('option', 'selected');
        var selected_tab = $("ul#tabs li.active").attr('id')
		var url = 'http://' + location.host + '<?=$base_url?>' + '/trading/retrieve_bids';
		var parameters = 'sdate='+$('#sdate').val()+'&view=' + selected_tab+'&resource_id='+$('input[name=resource_id]:checked').val();
		//console.log(parameters);
		$('#pls_wait_retrieve').css('color','black');
		$('#pls_wait_retrieve').html('Retrieving current bids.. Please wait..');
        
        for (i=1;i<=24;i++) {
            $('input[name=web-price_qty-'+i+']').val('');
            $('input[name=web-ramp_rate-'+i+']').val('');
            $('input[name=web-remarks-'+i+']').val('');
        }
        
		$.ajax({
		   type: "POST",
		   url: url,
		   data: parameters,
		   success: function(msg){
				if (msg) {
                    if(selected_tab == 'web'){
                        var ret = $.parseJSON(msg);
                        $('input.go').removeAttr('checked');
                        
                        if(ret.web != undefined){
                            $.each(ret.web[0].intervals, function(i, val){
                                if(val.gate_closure=="open"){
                                    $('input[name=go-'+i+']').attr('checked','checked');
                                }else{
                                    $('#tr'+i+' td').addClass("gclosed");
                                    $('input[name=go-'+i+']').attr('disabled','disabled');
                                    $('input[name=web-price_qty-'+i+']').attr('disabled','disabled');
                                    $('input[name=web-ramp_rate-'+i+']').attr('disabled','disabled');
                                    $('input[name=web-remarks-'+i+']').attr('disabled','disabled');
                                }

                                $('input[name=web-price_qty-'+i+']').val(val.price_quantity);
                                $('input[name=web-ramp_rate-'+i+']').val(val.ramp_rate);
                                $('input[name=web-remarks-'+i+']').val(val.remarks);
                            });
                        }

                    }else{
                        var decoded = $("<div/>").html(msg).text();
                        $('textarea[name=xml]').val(decoded);
                    }
                    $('#pls_wait_retrieve').html('');
                } else {
                    $('#pls_wait_retrieve').html('Unable to retrieve data');
                    $('#pls_wait_retrieve').css('color','red');
                }
                
				//$('#confirm_details_container').html(msg);
				//$('#confirm_dialog').dialog({width:550,height:420});
			}
		 });
        
		return false;
	});

</script>