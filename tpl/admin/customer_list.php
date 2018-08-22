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
    <a href="#modal" role="button" class="btn btn-primary" data-toggle="modal" id="add_button"><i class="icon-plus-sign"></i>&nbsp;&nbsp;Add Customer </a>
    <br><br><br>
</div>

<div class="modal fade in" id="modal" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Customer</h4>
    </div>
    <div class="modal-body">
        <div id="error_box"></div>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-condensed">
                <tr><td>Customer Name</td><td><input type="text" class="input-medium" id='name' name="name"></td></tr>
                
                <tr><td>Customer Full Name</td><td><input type="text" class="input-medium" id='customer_full_name' name="customer_full_name"></td></tr>

                <tr>
                    <td>Customer Type</td>
                    <td>
                        <select id="customer_type" name="customer_type">
                            <option value = "distribution_utility">Distribution Utility</option>
                            <option value = "electric_cooperative">Electric Cooperative</option>
                            <option value = "industrial">Industrial</option>
                            <option value = "wholesale_aggregator_res">Wholesale Aggregator / RES</option>
                        </select>
                    </td>
                </tr>

                <tr><td>WBSS Name</td><td><input type="text" class="input-medium" id='wbss_name' name="wbss_name"></td></tr>
                
                <tr>
                    <td>Participant Name</td>
                    <td>
                        <?php
                        foreach ($participants as $i=>$val) {
                            echo '<label class="checkbox"><input type="checkbox" name="participants" id="'.$val->participant.'" value="'.$val->participant.'">'.$val->participant.'</label>';
                        }

                        ?>
                    </td>
                </tr>

                <tr>
                    <td>PSC Type</td>
                    <td>
                        <label class="radio"><input type = "radio" name = "psc_type" id = "base_load" value = "base_load"/>Base Load</label>  
                        <label class="radio"><input type = "radio" name = "psc_type" id = "load_factor" value = "load_factor"/>Load Factor</label>    
                    </td>
                </tr>

                <tr>
                    <td>Tax Type</td>
                    <td>
                        <label class="radio"><input type = "radio" name = "tax_type" id = "vatable" value = "vatable"/>Vatable</label>
                        <label class="radio"><input type = "radio" name = "tax_type" id = "vatable*" value = "vatable*"/>Vatable *</label>    
                        <label class="radio"><input type = "radio" name = "tax_type" id = "zero_rated" value = "zero_rated"/>Zero Rated *</label>    
                    </td>
                </tr>

                <tr>
                    <td>PSC Rate Comp. Type</td>
                    <td>
                        <select id="psc_rate" name="psc_rate">
                            <option value = "new">New</option>
                            <option value = "old">Old</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Hourly Contract Capacity</td>
                    <td><input type="text" id="hourly_contract_capacity" name="hourly_contract_capacity"></td>
                </tr>

                <tr>
                    <td>Contract Start Date</td>
                    <td><input type="text" id="sdate" name="date" value="<?=$def_billing_sdate?>" class="input-small datepicker"></td>
                </tr>

                <tr>
                    <td>Contract Expiry Date</td>
                    <td><input type="text" id="edate" name="date" value="<?=$def_billing_edate?>" class="input-small datepicker"></td>
                </tr>

                <tr><td>Status  </td><td>
                    <select id="status" name="status" class="input-medium">
                        <option value="active">active</option>
                        <option value="inactive">inactive</option>
                    </select>
                </td></tr>
                
                <tr><td>Group  </td><td>
                    <select id="group" name="group" class="input-medium">
                        <?php
                            foreach ($groups as $row) {
                                echo '<option value="'.$row['group'].'">'.$row['group'].'</option>';
                            }
                        ?>
                    </select>
                </td></tr>

                <tr>
                    <td>Remarks for Status</td>
                    <td><input type="text" id="remarks" name="remarks"></td>
                </tr>

                <tr>
                    <td>Modified By</td>
                    <td><input type="text" id="modified_by" name="modified_by" disabled="disabled"></td>
                </tr>

            </table>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>

<script>
$.extend({
    save : function(){

        var parameters = "name=" + $('#name').val();
            parameters+= "&customer_full_name=" + $('#customer_full_name').val();
            parameters+= "&customer_type=" + $('#customer_type').val();
            parameters+= "&wbss_name=" + $('#wbss_name').val();
            parameters+= "&participants=" + $('input[name=participants]:checked').map(function() { return $(this).val().toString(); } ).get().join(",");;
            parameters+= "&psc_type=" + $('input[name=psc_type]:checked').val();
            parameters+= "&tax_type=" + $('input[name=tax_type]:checked').val();
            parameters+= "&psc_rate=" + $('#psc_rate').val();
            parameters+= "&hourly_contract_capacity=" + $('#hourly_contract_capacity').val();
            parameters+= "&contract_start_date=" + $('#sdate').val();
            parameters+= "&contract_end_date=" + $('#edate').val();
            parameters+= "&status=" + $('#status').val();
            parameters+= "&group=" + $('#group').val();
            parameters+= "&remarks=" + $('#remarks').val()
            parameters+= "&id=" + $('#id').val()

        $.post('<?=$base_url?>/admin/customer_update',parameters,
        function(data){
            ret = data.split('|');
            if (ret[0] == 1) {
                $('#error_box').attr('class','alert alert-success');
            } else {
                $('#error_box').attr('class','alert alert-error');
            }
            $('#error_box').html(ret[1]);
            $("div").scrollTop(0)
            $.list();
        })  
    },
    add : function(){

        var name                        = $('#name').val();
        var customer_full_name          = $('#customer_full_name').val();
        var customer_type               = $('#customer_type').val();
        var wbss_name                   = $('#wbss_name').val();    
        var participants                = $('input[name=participants]:checked').map(function() { return $(this).val().toString(); } ).get().join(",");;
        var psc_type                    = $('input[name=psc_type]:checked').val();
        var tax_type                    = $('input[name=tax_type]:checked').val();
        var hourly_contract_capacity    = $('#hourly_contract_capacity').val();
        var status                      = $('#status').val();     
            
        var errors = [];

        $('#error_box').html('').removeAttr('class');

        if (name.length <= 0 ) {
            errors.push("<li>Customer name can't be empty</li>");     
        }else if ($.trim(name).length <= 0 ) {
            errors.push("<li>Please enter a valid Customer name</li>");     
        }

        if (customer_full_name.length <= 0 ) {
            errors.push("<li>Customer full name can't be empty</li>");     
        }else if ($.trim(customer_full_name).length <= 0 ) {
            errors.push("<li>Please enter a valid Customer full name</li>");     
        }


        if (customer_type.length <= 0 ) {
                errors.push('<li>Please enter a Customer Type</li>');     
        }

        if (wbss_name.length <= 0 ) {
                errors.push("<li>WBSS name can't be empty</li>");       
        }else if ($.trim(wbss_name).length <= 0 ) {
            errors.push("<li>Please enter a valid WBSS name</li>");     
        }    

        if (!participants) {
                errors.push('<li>Please select Participant</li>');     
        }    

        if (!psc_type) {
                errors.push('<li>Please select PSC Type</li>');     
        }

        if (!tax_type) {
                errors.push('<li>Please select Tax Type</li>');     
        }

        if (hourly_contract_capacity.length <= 0 ) {
                errors.push('<li>Please enter Hourly Contract Capacity</li>');     
        }

        if (status.length <= 0 ) {
                errors.push('<li>Please enter select Status</li>');     
        }

        if (errors.length > 0) { // If error display
            $('#result').removeAttr('class').html('');
            $('#error_box').html('Cannot proceed because of the following :'+'<ul>'+ errors.join('') + '</ul>').addClass('alert').addClass('alert-error');   
            $("div").scrollTop(0)
        }else{ // if else

            var parameters = "name=" + $('#name').val();
            parameters+= "&customer_full_name=" + $('#customer_full_name').val();
            parameters+= "&customer_type=" + $('#customer_type').val();
            parameters+= "&wbss_name=" + $('#wbss_name').val();
            parameters+= "&participants=" + $('input[name=participants]:checked').val();
            parameters+= "&psc_type=" + $('input[name=psc_type]:checked').val();
            parameters+= "&tax_type=" + $('input[name=tax_type]:checked').val();
            parameters+= "&psc_rate=" + $('#psc_rate').val();
            parameters+= "&hourly_contract_capacity=" + $('#hourly_contract_capacity').val();
            parameters+= "&contract_start_date=" + $('#sdate').val();
            parameters+= "&contract_end_date=" + $('#edate').val();
            parameters+= "&status=" + $('#status').val();
            parameters+= "&group=" + $('#group').val();
            parameters+= "&remarks=" + $('#remarks').val()

            $.post('<?=$base_url?>/admin/customer_add',parameters,
                function(data){
                    ret = data.split('|');
                    if (ret[0] == 1) {
                        $('#error_box').attr('class','alert alert-success');
                    } else {
                        $('#error_box').attr('class','alert alert-error');
                    }
                    $('#error_box').html(ret[1]);
                    $("div").scrollTop(0)
                    $.list();
            })  
        } // eof if else

    },
    list : function(order,field){
        $.post('<?=$base_url?>/admin/customer_list_json',{order:order,field:field},
        function(data){
            var data = $.parseJSON(data);
            $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="data">');
            $('#data').dataTable({

                "aoColumns": [
                    { "sTitle": "Customer Name" },
                    { "sTitle": "Customer Full Name" },
                    { "sTitle": "Customer Type" },
                    { "sTitle": "WBSS Name" },
                    { "sTitle": "Participant Name" },
                    { "sTitle": "PSC Type" },
                    { "sTitle": "Tax Type" },
                    { "sTitle": "PSC Rate Comp. Type" },
                    { "sTitle": "Hourly Contract Capacity (MW)" },
                    { "sTitle": "Contract Start Date" },
                    { "sTitle": "Contract Expiry Date" },
                    { "sTitle": "Status" },
                    { "sTitle": "Modified By" },
                    { "sTitle": "&nbsp;" }
                ]
            });
            
            $.each(data, function(i,val){
                var priv_link = '<a href="#" id="'+val.id+'" class="edit_link">'+val.name+'</a>';
                var del_link = '<a href="#" id="'+val.name+'" class="delete_button" name="'+val.id+'"><i class="icon-remove"></i></a>';
                var status = val.status=='active' ? '<span class="label label-success">'+val.status+'</span>' : '<span class="label label-important">'+val.status+'</span>';
                $('#data').dataTable().fnAddData([priv_link,val.customer_full_name,$.toTitleCase(val.customer_type.replace('_',' ')),val.wbss_name,val.participants,$.toTitleCase(val.psc_type.replace('_',' ')),$.toTitleCase(val.tax_type.replace('_',' ')),$.toTitleCase(val.psc_rate),$.precise_round(val.hourly_contract_capacity,2),val.contract_start_date,val.contract_end_date,status,val.modified_by,del_link]);
            })
        })    
    }
})
</script>
<script>
/* To restrict space */
$(function() {
    $('input[name="wbss_name"]').keydown(function(e) {
        if (e.keyCode == 32) // 32 is the ASCII value for a space
            e.preventDefault();
    });
}); // eof space

$(document).ready(function(){

    $('#sdate').datepicker();
    $('#edate').datepicker();

    $.list();
    $("#hourly_contract_capacity").numeric(); 

}) // eof document ready

$("a.edit_link").die('click').live('click',function(e){
    e.preventDefault();
    $('#error_box').removeClass('alert');
    $('#error_box').html('');
    $('#modal').modal('show')
    $.post('<?=$base_url?>/admin/customer_data',{id:$(this).attr('id')},
        function(data){
            var data = $.parseJSON(data);
            var participants_list = data.participants.split(',');
            if (data.tax_type == 'vatable*'){
                $('input:radio[name=tax_type]')[1].checked = true;
            }else{
                $('input[id='+data.tax_type+']').attr('checked',true)
            }
            $('input[id=id]').val(data.id);
            $('input[name=name]').attr('readonly',true);
            $('input[name=name]').val(data.name)
            $('input[id=customer_full_name]').val(data.customer_full_name)
            $('select[id=customer_type]').val(data.customer_type)
            $('input[id=wbss_name]').val(data.wbss_name);
            
            $('input[id='+data.psc_type+']').attr('checked',true)
            $('select[id=psc_rate]').val(data.psc_rate);
            $('input[id=hourly_contract_capacity]').val($.precise_round(data.hourly_contract_capacity,2));
            $('input[id=sdate]').val(data.contract_start_date);
            $('input[id=edate]').val(data.contract_end_date);
            $('select[id=status]').val(data.status);
            $('select[id=group]').val(data.group);
            $('input[id=remarks]').val(data.remarks);
            $('input[id=modified_by]').val(data.modified_by);


            // participants 

            $('input[name=participants]').removeAttr('checked');
            for (i = 0; i < participants_list.length; i++) { 
                var cur = participants_list[i];
                $('input[name=participants][value='+cur+']').attr('checked',true);
            }



            $('#btn-holder').html('<button class="btn btn-primary" id="update"><i class="icon-check"></i>&nbsp;&nbsp;Update&nbsp;&nbsp;</button>')
            return false;
    })
}) // eof edit 

$("#add_button").unbind('click').bind('click',function(e){
    e.preventDefault()
    $('#error_box').removeClass('alert');
    $('#error_box').html('');

    $('input[id=id]').val('')
    $('input[name=name]').attr('readonly',false);
    $('input[name=name]').val('')
    $('input[id=customer_full_name]').val('')
    $('select[id=customer_type]').val('')
    $('input[id=wbss_name]').val('')
    $('input[name=participants]').attr('checked',false)
    $('input[name=psc_type]').attr('checked',false)
    $('input[name=tax_type]').attr('checked',false)
    $('select[id=psc_rate]').val('');
    $('input[id=hourly_contract_capacity]').val('');
    $('select[id=status]').val('');
    $('select[id=group]').val('');
    $('input[id=remarks]').val('');
    $('input[id=modified_by]').val('<?=base64_decode($_SESSION['username'])?>');
    $('#btn-holder').html('<button class="btn btn-primary" id="add"><i class="icon-check"></i>&nbsp;&nbsp;Save&nbsp;&nbsp;</button>')

}) // eof add customer

$("#add").die('click').live('click',function(e){
    e.preventDefault()
        $.add();    
}) // eof add (Save)

$("#update").die('click').live('click',function(e){
    e.preventDefault()
        $.save();    
}) // eof update

$('.delete_button').die('click').live('click', function(e){
    e.preventDefault()
    var id = $(this).attr('name');
    var name = $(this).attr('id');
    bootbox.confirm("<p class=bootbox-text>Are you sure you want to delete <span class=bootbox-red>"+name+"?</span></p>", function(result) {
        if (result) {
            $.post('<?=$base_url?>/admin/customer_delete',{id:id},
            function(data){
                bootbox.alert('<p class=bootbox-text>'+data+' <span class=bootbox-red>'+name+'</span></p>')
                $.list();
            })
        }
    }); 
}) // eof delete

</script>