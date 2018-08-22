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
<div id="grid_data"></div>
    <a href="<?=$base_url?>/admin/add_supplier" role="button" class="btn btn-primary"  id="add_button"><i class="icon-plus-sign"></i>&nbsp;&nbsp;Add Supplier </a>
    <br><br><br><br>
</div>
<div class="modal fade in" id="modal_supplier" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none;width:750px;margin-left:-375px;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Edit Supplier</h4>
    </div>
    <div class="modal-body">
    	<div id="error_box"></div>
    	 <input type="hidden" id="supplier_id" name="supplier_id">
            <table cellpadding="5" cellspacing="0" border="0" >
                <tr><td>Supplier Name</td><td><input type="text" class="input-medium important" id='supplier_name' name="supplier_name"></td></tr>
                <tr><td>Resource ID</td><td><input type="text" id='resource_id' name="resource_id" class="important" readonly="readonly">
                	<a href="#modal_resource" role="button" data-toggle="modal" id="show_resources"><i class="icon-th"></i></a>
                </td></tr>
                <tr><td>Customers</td><td><input type="text" id='customer_name' name="customer_name" class="important" readonly="readonly">
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
                <tr><td></td><td>
                
                	<span id="alert_msg"></span></td></tr>
                
            </table>
    </div>
    <div class="modal-footer">
    	
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
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
$.extend({
	list : function(){
        $.post('<?=$base_url?>/admin/supplier_list_json',{},
        function(data){
            var data = $.parseJSON(data);  
            
            $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="data">');
            $('#data').dataTable({

                "aoColumns": [
                    { "sTitle": "Supplier Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" },
                    { "sTitle": "Resource ID's&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" },
                    { "sTitle": "Customers&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" },
                    { "sTitle": "Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" },
                    { "sTitle": "Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" },
                    { "sTitle": "Account Officer 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" },
                    { "sTitle": "Contact No.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" },
                    { "sTitle": "TIN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" },
                    { "sTitle": "Status&nbsp;&nbsp;" },
                    { "sTitle": "Last&nbsp;Modified&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" },
                    { "sTitle": "&nbsp;" }
                ]
            });
            
            $.each(data, function(i,val){
                var user_link = '<a href="#" id="'+val.id+'" class="username">'+val.name+'</a>';
                var del_link = '<a href="#" id="'+val.name+'" class="delete_button" name="'+val.id+'"><i class="icon-remove"></i></a>';
                var status = val.status=='active' ? '<span class="label label-success">'+val.status+'</span>' : '<span class="label label-important">'+val.status+'</span>';
                
                $('#data').dataTable().fnAddData([user_link,val.resource_id,val.customers,val.address,val.email,val.ao_1,val.ao_1_cn,val.tin,status,val.modified,del_link]);
            })
            
        })
 },
	save : function(){
        $.post('<?=$base_url?>/admin/update_supplier',{id : $('#supplier_id').val(), name : $('#supplier_name').val(), res : $('#resource_id').val(),cust : $('#customer_name').val(),
    										address : $('#address').val(),email : $('#email').val(),ao_1 : $('#ao_1').val(),ao_2 : $('#ao_2').val(),
    										ao_3 : $('#ao_3').val(),ao_1_cn : $('#ao_1_cn').val(),ao_2_cn : $('#ao_2_cn').val(),ao_2_cn : $('#ao_2_cn').val(),ao_3_cn : $('#ao_3_cn').val(),
    										cp_1 : $('#cp_1').val(),cp_2 : $('#cp_2').val(),cp_1_cn : $('#cp_1_cn').val(),cp_2_cn : $('#cp_2_cn').val(),
    										tel_no : $('#tel_no').val(),tin : $('#tin').val(),remarks : $('#remarks').val(),status : $('#status').val() },
        function(data){
            //$('#user_dialog').dialog('close');
            ret = data.split('|');
            if (ret[0] == 1) {
                $('#error_box').attr('class','alert alert-success');
            } else {
                $('#error_box').attr('class','alert alert-error');
            }
            $('#error_box').html(ret[1]);
            $.list();
        })
        
    },
       
        
})    
</script>
<script>
	$.list();
$('.delete_button').die('click').live('click', function(e){
    e.preventDefault()
    var id = $(this).attr('name');
    var name = $(this).attr('id');
    bootbox.confirm("<p class=bootbox-text>Are you sure you want to delete <span class=bootbox-red>"+name+"?</span></p>", function(result) {
        if (result) {
            $.post('<?=$base_url?>/admin/supplier_delete',{id:id},
            function(data){
                bootbox.alert('<p class=bootbox-text>'+data+' <span class=bootbox-red>'+name+'</span></p>')
                $.list();
            })
        }
    }); 
})
$("a.username").die('click').live('click',function(e){
	 $('#error_box').removeClass('alert');
     $('#error_box').html('');
	 $('#modal_supplier').modal('show')
	 $.post('<?=$base_url?>/admin/supplier_data',{id:$(this).attr('id')},
        function(data){
         
            var data = $.parseJSON(data);
            $('input[id=supplier_id]').val(data.id);
            $('input[id=supplier_name]').val(data.name);
            $('input[id=email]').val(data.email);
            $('input[id=resource_id]').val(data.resource_id);
            $('input[id=customer_name]').val(data.customers);
            $('textarea[id=address]').val(data.address);
            $('input[id=ao_1]').val(data.ao_1);
            $('input[id=ao_2]').val(data.ao_2);
            $('input[id=ao_3]').val(data.ao_3);
            $('input[id=ao_1_cn]').val(data.ao_1_cn);
            $('input[id=ao_2_cn]').val(data.ao_2_cn);
            $('input[id=ao_3_cn]').val(data.ao_3_cn);
            $('input[id=cp_1]').val(data.cp_1);
            $('input[id=cp_2]').val(data.cp_2);
            $('input[id=cp_1_cn]').val(data.cp_1_cn);
            $('input[id=cp_2_cn]').val(data.cp_2_cn);
            $('input[id=tel_no]').val(data.telephone);
            $('input[id=tin]').val(data.tin);
            $('textarea[id=remarks]').val(data.remarks);
            $('select[id=status]').val(data.status);
            $('input[id=supplier_name]').attr('readonly',true);
            $('#btn-holder').html('<button class="btn btn-primary" id="update_supplier">Update Supplier</button>')
            return false;   
        })
})
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
$("#update_supplier").die('click').live('click',function(e){
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
        $.save();    
    }
})
</script>