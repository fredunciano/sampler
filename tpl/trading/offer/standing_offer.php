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
            <div class="span7">
                <input type="text" id="sdate" name="sdate" value="<?=$sdate?>" class="span3">
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Units</div>
            <div class="span7">
                <?php
                foreach($resources as $resource){
                	echo '<label><input name="resource_id" type="radio" value="'.$resource['resource_id'].'"/>';
                	echo $resource['resource_id'] . '</label> ';
                }
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Standing Day Type</div>
            <div class="span7">
                <select class="span3">
                    	<option>ALL</option>
                    	<option>MON</option>
                    	<option>TUE</option>
                    	<option>WED</option>
                    	<option>THU</option>
                    	<option>FRI</option>
                    	<option>SAT</option>
                    	<option>SUN</option>    	
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Standing Expiry Date</div>
            <div class="span7">YES</div>
        </div>
        <div class="row-fluid">
            <div class="span2">Standing Bid</div>
            <div class="span7"><input type="text" id="sdate" name="sdate" value="<?=$sdate?>" class="span3"></div>
        </div>
        <div class="row-fluid">
            <div class="span2">Action</div>
            <div class="span7">
                <select name="action" class="span3" disabled>
                    <option value="submit">SUBMIT</option>
                    <option value="cancel">CANCEL</option>
                </select>
            </div>
        </div><br>
        <div class="row-fluid">
            <div class="span2"></div>
            <div class="span7">
                <a class="btn" href="#"><i class="icon-align-right"></i>&nbsp;Retrieve</a>
            </div>
        </div><br>
        
        <legend>Upload Day Ahead Offer Template</legend>
        <div class="fileupload fileupload-new span5" data-provides="fileupload">
            <div class="input-append">
                <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
                <span class="btn btn-file"><span class="fileupload-new">Select file</span>
                    <span class="fileupload-exists">Change</span><input type="file" name="filebrowser" id="filebrowser" />
                </span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
            </div>
            
        </div>
        <div class="span3">
            <input type="hidden" name="template_type" value="day_ahead" />
            <input type="submit" value="Upload" class="btn" /><span id="resultbox"></span>
        </div>
        
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
            <li class="active"><a href="#web" data-toggle="tab" id="web_format_btn">Web</a></li>
            <li><a href="#xml" data-toggle="tab" id="xml_format_btn">XML</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="web">
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
					
					//print_r($gate_closure);
					
					for($i=1; $i<=24; $i++){
					
						echo '<tr id="tr'.$i.'">
                              <td>
                                  <label class="checkbox">
                                  <input name="go-'.$i.'" id="go-'.$i.'" type="checkbox" value="1"/> '.$i.'
                                  </label>
                              </td>
                              <td>
                                  <input name="web-price_qty-'.$i.'" type="text" class="input-xxlarge price_qty" />
                              </td>
                              <td>
                                  <input name="web-ramp_rate-'.$i.'" type="text" class="input-small ramp_rate" />
                              </td>
                              <td>
                                  <input name="web-remarks-'.$i.'" type="text" class="input-medium remarks" />
                              </td>
                              </tr>';
					}
					?>
                    </tbody>
				</table>
            </div>
            <div class="tab-pane" id="xml">
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
<script src="../js/jquery.form.js"></script>
<script>
    
    $('a.drop-down').click(function(e){
        e.preventDefault();
        $('#auto-options').html($(this).html())
        $('#auto-options').attr('value',$(this).attr('value'))
        
    })
	//populate by upload
	$('#frm1').submit(function(e){
		e.preventDefault();
		var selected_tab = $("ul#tabs li.active").find('a').attr('href')
		var url = 'http://' + location.host + '<?=$base_url?>' + '/trading/offer_template_parser';
		var options = {
			   //target:'#resultbox',
			   url:url,
			   data: {action:'upload', view: selected_tab},
			   beforeSubmit:	function() { 
                    $('#resultbox').addClass('text-info')
					$('#resultbox').html('&nbsp;&nbsp;&nbsp;Please&nbsp;wait...'); 
                    
			   },
			   success:	function(data) {
			   		
			   		$('#resultbox').html(''); 
			   		
			   		if(selected_tab == '#web'){
						var ret = $.parseJSON(data);
						$('#sdate').val(ret.delivery_date);
                        $('#'+ret.resource_id).attr('checked','checked');
                        
						$.each(ret.web[0].intervals, function(i, val){
							$('input[name=go-'+i+']').attr('checked','checked');
							$('input[name=web-price_qty-'+i+']').val(val.price_quantity);
							$('input[name=web-ramp_rate-'+i+']').val(val.ramp_rate);
							$('input[name=web-remarks-'+i+']').val(val.remarks);
						});
						
			   		}else{
			   			var decoded = $("<div/>").html(data).text();
			   			$('textarea[name=xml]').val(decoded);
			   		}
			   		
			   }};	
			   
		$("#frm1").ajaxSubmit(options);	
	});

	$('#update_btn').click(function(e){
        e.preventDefault();
		var auto_options = $('#auto-options').attr('value');
		var tmp_content = $('#tmp_content').val();
		var del = ',';
		
		if(auto_options == 'web-remarks'){
			var del = '*';
		}else{
			tmp_content = tmp_content.replace(';', '');
		}
		
		var tmp_arr = tmp_content.split(del);
		var interval_arr = tmp_arr[0].split('-');
		tmp_content = tmp_content.replace(tmp_arr[0]+del,'');
		
		if(!interval_arr[1]) interval_arr[1] = interval_arr[0];
		if(interval_arr[1]/1 < interval_arr[0]/1) return false;
		
		for(var i=interval_arr[0]/1; i<=interval_arr[1]/1; i++){
			$('input[name=go-'+i+']').attr('checked','checked');
			$('input[name='+auto_options+'-'+i+']').val(tmp_content);
		}
	});

	$('#clear_btn').click(function(){
		$('input.go').removeAttr('checked');
	
		var auto_options = $('#auto-options').val();
		var tmp_content = $('#tmp_content').val();
		var del = ',';
		
		if(auto_options == 'web-remarks'){
			var del = '*';
		}
		
		var tmp_arr = tmp_content.split(del);
		var interval_arr = tmp_arr[0].split('-');
		
		if(!interval_arr[1]) interval_arr[1] = interval_arr[0];
		if(interval_arr[1]/1 < interval_arr[0]/1) return false;
		
		for(var i=interval_arr[0]/1; i<=interval_arr[1]/1; i++){
			$('input[name=go-'+i+']').removeAttr('checked');
			$('input[name='+auto_options+'-'+i+']').val('');
		}
		
	});	

	$('#auto-options').change(function(){
	
		var auto_options = $(this).val();
		
		switch(auto_options){
			case "web-price_qty":
				$('#tmp_content').val('1-24,(2000.00,120.0),(2000.00,125.0),(3000.00,300.0);');
			break;
			
			case "web-ramp_rate":
				$('#tmp_content').val('1-24,(300.0,3.0,3.0);');
			break;
			
			case "web-remarks":
				$('#tmp_content').val('1-24*Other reasons');
			break;
		}
	});
	
	$('#check_all').bind('change', function(){
		var chk = $(this).attr('checked');
		
		if(chk){
            $('input[type=checkbox]').attr('checked', 'checked');
		}else{
            $('input[type=checkbox]').removeAttr('checked');
		}
		return false;
	});
	
	
	$('#web_format_btn').bind('click', function(){
		$('input.remarks').val('');
		$('input.price_qty').val('');
		$('input.ramp_rate').val('');
		$.getContent(0);
		
	});
	
	$('#xml_format_btn').bind('click', function(){
		$('textarea[name=xml]').val('');
		$.getContent(1);
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
			   		
					if(view == 0){
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
	
	$('#submit_offer').bind('click', function(){
		
		if(!$('input[name=resource_id]:checked').val()){
			alert("Resource is required.");
			return false;
		}
	
		var action = $("select[name=action]").val();
		var conf = confirm('Are you sure you want to '+action+'?');
		
		if(conf){
			$('#pls_wait_submit').html('Please wait...');
			var selected_tab = $('#tabs').tabs('option', 'selected');
			var url = 'http://' + location.host + '<?=$base_url?>' + '/trading/submit_offer';
			var parameters = $('#frm1').serialize() + '&view=' + selected_tab;
			//console.log("parameters: "+parameters);
			$.ajax({
			   type: "POST",
			   url: url,
			   data: parameters,
			   success: function(msg){
			   		$('#confirm_details_container').html(msg);
					$('#confirm_dialog').dialog({width:550,height:420});
					$('#pls_wait_submit').html('');
				}
			 });	
		 }
		return false;
	});
    
    $('#retrieve_btn').bind('click', function(){
		
		if(!$('input[name=resource_id]:checked').val()){
			alert("Resource is required.");
			return false;
		}
		
		var selected_tab = $('#tabs').tabs('option', 'selected');
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
                    if(selected_tab == 0){
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