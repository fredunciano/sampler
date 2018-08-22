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
    <legend><h4><?=$title?><small>&nbsp;</small></h4></legend>
    
    <form method="post">
            <input type="hidden" id="id" name="id">
            <table cellpadding="5" cellspacing="0" border="0" >
                <tr><td>Supplier Name</td><td><input type="text" class="input-medium important" id='supplier_name' label="Supplier Name" name="supplier_name"></td></tr>
                <tr><td>Resource ID</td><td><input type="text" id='resource_id' class="important" label="Resource ID" name="resource_id" readonly="readonly">
                	<a href="#modal_resource" role="button" data-toggle="modal" id="show_resources"><i class="icon-th"></i></a>
                </td></tr>
                <tr><td>Customers</td><td><input type="text" id='customer_name' class="important" label="Customers" name="customer_name" readonly="readonly">
                	<a href="#modal_customer" role="button" data-toggle="modal" id="show_customer"><i class="icon-th"></i></a>
                </td></tr>
            </table>
            <br \>
            <legend>Other Supplier Details</legend>
            <table cellpadding="5" cellspacing="0" border="0" >    
                <tr><td>Adress </td><td><textarea id='address' name="address"></textarea></td></tr>
                <tr><td>Email</td><td><input type="text" id='email' name="email"></td></tr>
                <tr>
                	<td>Account Officer 1</td><td><input type="text" id='ao_1' name="ao_1"></td>
                	<td>Acct. Off 1 Contact No.</td><td><input type="text" id='ao_1_cn' name="ao_1_cn"></td>
                </tr>
                <tr>
                	<td>Account Officer 2</td><td><input type="text" id='ao_2' name="ao_2"></td>
                	<td>Acct. Off 2 Contact No.</td><td><input type="text" id='ao_2_cn' name="ao_2_cn"></td>
                </tr>
                <tr>
                	<td>Account Officer 3</td><td><input type="text" id='ao_3' name="ao_3"></td>
                	<td>Acct. Off 3 Contact No.</td><td><input type="text" id='ao_3_cn' name="ao_3_cn"></td>
                </tr>
                <tr>
                	<td>Contact Person 1</td><td><input type="text" id='cp_1' name="cp_1"></td>
                	<td>Cont. Person 1 Contact No.</td><td><input type="text" id='cp_1_cn' name="cp_1_cn"></td>
                </tr>
                <tr>
                	<td>Contact Person 2</td><td><input type="text" id='cp_2' name="cp_2"></td>
                	<td>Cont. Person 2 Contact No.</td><td><input type="text" id='cp_2_cn' name="cp_2_cn"></td>
                </tr>
                <tr><td>Telephone No.</td><td><input type="text" id='tel_no' name="tel_no"></td></tr>
                <tr><td>TIN No.</td><td><input type="text" id='tin' name="tin"></td></tr>
                <tr><td>Desc/Remarks</td><td><textarea id="remarks" name="remarks"></textarea></td></tr>
                <tr><td>Status  </td><td>
                    <select id="status" name="status" class="input-medium">
                        <option value="active">active</option>
                        <option value="inactive">inactive</option>
                    </select>
                </td></tr>
                <tr><td></td><td><button id="submit" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Save</button>
                	<input type="reset" class="btn" data-dismiss="modal" aria-hidden="true" value="Reset">
                	<span id="alert_msg"></span></td></tr>
                
            </table>
            <div id="error_box"></div>
        </form>
</div>
<div class="modal fade in" id="modal_resource" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Choose a Resource ID</h4>
    </div>
    <div class="modal-body">
    	Type 
    	<select id="type">
    		<option>GEN</option>	
    		<option>LOAD</option>	
    	</select>
        <table id="list-table-res" class="table table-condensed table-bordered table-striped"></table>
    </div>
    <div class="modal-footer">
    	<button id="get_rid" class="btn" data-dismiss="modal" aria-hidden="true">Ok</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>
<div class="modal fade in" id="modal_customer" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Choose a Customer</h4>
    </div>
    <div class="modal-body">
    	<table id="list-table-cust" class="table table-condensed table-bordered table-striped"></table>
    </div>
    <div class="modal-footer">
    	<button id="get_cid" class="btn" data-dismiss="modal" aria-hidden="true">Ok</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>
<script>
	$("#show_resources").unbind('click').bind('click',function(e){
    e.preventDefault();
    $('#list-table-res').html('Please wait...')
    $.post('../admin/supplier_resource_list',{type : $('#type').val()},
        function(data){
        	
            if (data.total >= 1) { 
                var resource;
                var html;
                var x=0;
                html = '<tr>';
                $.each(data.value, function(i, val) {
                    x++;	
                    html+='<td id='+val+'><label class="checkbox"><input type="checkbox" id="r_id" name="r_id[]" value="'+val+'">'+val+'</label></td>';
                    if (x % 4 === 0) {
                            html+='</tr><tr>';
                    }
                    
                })
                html+='</tr>';
                $('#list-table-res').html(html)
                $('#list-table-res td').css('cursor','pointer');
            } else {
                $('#list-table-res').html('No Data Available');
            }
        });
});
$("#show_customer").unbind('click').bind('click',function(e){
    e.preventDefault();
    $('#list-table-cust').html('Please wait...')
    $.post('../admin/supplier_customer_list',
        function(data){
        	
            if (data.total >= 1) { 
                var resource;
                var html;
                var x=0;
                html = '<tr>';
                $.each(data.value, function(i, val) {
                    x++;	
                    html+='<td id='+val.name+'><label class="checkbox"><input type="checkbox" id="c_id" name="c_id[]" value="'+val.name+'">'+val.name+'</label></td>';
                    if (x % 4 === 0) {
                            html+='</tr><tr>';
                    }
                    
                })
                html+='</tr>';
                $('#list-table-cust').html(html)
                $('#list-table-cust td').css('cursor','pointer');
            } else {
                $('#list-table-cust').html('No Data Available');
            }
        });
});
$('#type').change(function(e){
	e.preventDefault();
    $('#list-table-res').html('Please wait...')
    $.post('../admin/supplier_resource_list',{type : $('#type').val()},
        function(data){
        	
            if (data.total >= 1) { 
                var resource;
                var html;
                var x=0;
                html = '<tr>';
                $.each(data.value, function(i, val) {
                    x++;	
                    html+='<td id='+val+'><label class="checkbox"><input type="checkbox" id="r_id" name="r_id[]" value="'+val+'">'+val+'</label></td>';
                    if (x % 4 === 0) {
                            html+='</tr><tr>';
                    }
                    
                })
                html+='</tr>';
                $('#list-table-res').html(html)
                $('#list-table-res td').css('cursor','pointer');
            } else {
                $('#list-table-res').html('No Data Available');
            }
        });
})
$('#get_rid').click(function(){
	$('#resource_id').val('');
	var arr_res_id = Array();
    $("#list-table-res input[type=checkbox]:checked").each(function() {
       arr_res_id.push($(this).val());
    });
   	$('#resource_id').val( arr_res_id.join( ","));
});
$('#get_cid').click(function(){
	$('#customer_name').val('');
	var arr_res_id = Array();
    $("#list-table-cust input[type=checkbox]:checked").each(function() {
       arr_res_id.push($(this).val());
    });
   	$('#customer_name').val( arr_res_id.join( ","));
});
$("#submit").unbind('click').bind('click',function(e){
    e.preventDefault();
    // validation
    var errors = [];

    $('input.important').each(function(){
        if(!$.trim($(this).val())){ 
            errors.push($(this).attr('label')+' required');
        }
    });
    if (errors.length > 0) {
        $("#error_box").attr('class','alert alert-info').html(errors.join('<br>'));
    } else {
        $('#error_box').html('Please wait...')
        $.post('../admin/add_supplier_action',{ name : $('#supplier_name').val(), res : $('#resource_id').val(),cust : $('#customer_name').val(),
        										address : $('#address').val(),email : $('#email').val(),ao_1 : $('#ao_1').val(),ao_2 : $('#ao_2').val(),
        										ao_3 : $('#ao_3').val(),ao_1_cn : $('#ao_1_cn').val(),ao_2_cn : $('#ao_2_cn').val(),ao_2_cn : $('#ao_2_cn').val(),ao_3_cn : $('#ao_3_cn').val(),
        										cp_1 : $('#cp_1').val(),cp_2 : $('#cp_2').val(),cp_1_cn : $('#cp_1_cn').val(),cp_2_cn : $('#cp_2_cn').val(),
        										tel_no : $('#tel_no').val(),tin : $('#tin').val(),remarks : $('#remarks').val(),status : $('#status').val() },
            function(data){
            	
            	ret = data.split('|');
                if (ret[0] == 1) {
                    $('#error_box').attr('class','alert alert-success');
                } else {
                    $('#error_box').attr('class','alert alert-error');
                }
                $('#error_box').html(ret[1]);
            	
             });
    }
});

</script>