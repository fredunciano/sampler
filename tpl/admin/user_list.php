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
    <a href="#modal_user" role="button" class="btn btn-primary" data-toggle="modal" id="add_button"><i class="icon-plus-sign"></i>&nbsp;&nbsp;Add User </a>
    <br><br><br><br>
</div>
<div class="modal fade in" id="modal_user" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Add User</h4>
    </div>
    <div class="modal-body">
        <div id="error_box"></div>
        <form method="post">
            <input type="hidden" id="id" name="id">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-condensed">
                <tr><td>Username</td><td><input type="text" class="input-medium" id='username' name="username"></td></tr>
                <tr><td>Email Address</td><td><input type="text" id='email' name="email"></td></tr>
                <tr><td>Password</td><td><input type="password" id='pass1' name="pass1"></td></tr>
                <tr><td>Retype Password </td><td><input type="password" id='pass2' name="pass2"></td></tr>
                <tr><td>First Name</td><td><input type="text" id='first_name' name="first_name"></td></tr>
                <tr><td>Last Name</td><td><input type="text" id='last_name' name="last_name"></td></tr>
                <tr><td>Title</td><td><input type="text" id='title' name="title"></td></tr>
                <tr><td>Position</td><td><input type="text" id='position' name="position"></td></tr>
                <tr><td>Mobile No.</td><td><input type="text" id='mobile_no' name="mobile_no"></td></tr>
                <tr><td>Privilege</td><td>
                    <select id="privilege" name="privilege" class="input-medium">
                        <?php
                        foreach ($privs as $i=>$obj_priv) {
                            echo '<option value="'.$obj_priv->priv.'">'.$obj_priv->priv.'</option>';
                        }
                        ?>
                    </select>
                </td></tr>
                <tr id="customer_container" style="display:none">
                    <td>Customer</td>
                    <td><select id="customer_dropdown" name="customer" class="input-medium"></select></td>
                </tr>
                <tr id="plant_container" style="display:none">
                    <td>Plant</td>
                    <td id="plant_checkbox_container"></td>
                </tr>
                <tr><td>Status  </td><td>
                    <select id="status" name="status" class="input-medium">
                        <option value="active">active</option>
                        <option value="inactive">inactive</option>
                    </select>
                </td></tr>
            </table>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>
<div class="modal fade in" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Delete User</h4>
    </div>
    <div class="modal-body">
        <div id="error_box"></div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>
<script>
$.extend({
    save : function(){
        $.post('<?=$base_url?>/admin/user_update',$('form').serialize(),
        function(data){
            //console.log(data)
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
    add : function(){
        var is_error = 0;
        var error = '';
        var username = $('#username').val();
        if (username.length === 0) {
            is_error = 1;
            error = "Username can't be empty";
        }else {
            if ($.trim(username).length <= 0) {
                is_error = 1;
                error = "Please enter a valid Username";
            }
        }

        if (is_error === 0) {
            $.post('<?=$base_url?>/admin/user_add',$('form').serialize(),
            function(data){
                ret = data.split('|');
                if (ret[0] == 1) {
                    $('#error_box').attr('class','alert alert-success');
                } else {
                    $('#error_box').attr('class','alert alert-error');
                }
                $('#error_box').html(ret[1]);
                $.list();
            })
        }else {
             $('#error_box').attr('class','alert alert-error').html(error)
        }

        
        
    },
    list : function(){
        $.post('<?=$base_url?>/admin/user_list_json',{},
        function(data){
            var data = $.parseJSON(data);  
            
            $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="data">');
            $('#data').dataTable({

                "aoColumns": [
                    { "sTitle": "Username&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" },
                    { "sTitle": "Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" },
                    { "sTitle": "First&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;" },
                    { "sTitle": "Last&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;" },
                    { "sTitle": "Title&nbsp;&nbsp;&nbsp;&nbsp;" },
                    { "sTitle": "Position&nbsp;&nbsp;&nbsp;&nbsp;" },
                    { "sTitle": "Mobile&nbsp;No.&nbsp;&nbsp;&nbsp;&nbsp;" },
                    { "sTitle": "Privilege&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" },
                    { "sTitle": "Status&nbsp;&nbsp;" },
                    { "sTitle": "Last&nbsp;Login&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" },
                    { "sTitle": "&nbsp;" }
                ]
            });
            
            $.each(data, function(i,val){
                var user_link = '<a href="#" id="'+val.id+'" class="username">'+val.user+'</a>';
                var del_link = '<a href="#" id="'+val.user+'" class="delete_button" name="'+val.id+'"><i class="icon-remove"></i></a>';
                var status = val.status=='active' ? '<span class="label label-success">'+val.status+'</span>' : '<span class="label label-important">'+val.status+'</span>';
                
                $('#data').dataTable().fnAddData([user_link,val.email,val.first_name,val.last_name,val.title,val.position,val.mobile_no,val.priv,status,val.last_login,del_link]);
            })
            
        })    
    },
    listCustomers : function(customer){
        $.post('<?=$base_url?>/admin/customer_list_json',{},
        function(data){
            
            var data = $.parseJSON(data);  
            
            $('#customer_container').css('display','');
            $('#customer_dropdown').val('');
            
            $.each(data, function(i,val){    
                
                if (customer == val.name) {
                    $('#customer_dropdown').append('<option value="'+val.name+'" selected>'+val.name+'</option>');
                } else {
                    $('#customer_dropdown').append('<option value="'+val.name+'">'+val.name+'</option>');
                }
                
            
            })
        })
    },
    listPlants : function(plant) {
        $.post('<?=$base_url?>/admin/plant_list_json',{},
        function(data){
            var data = $.parseJSON(data);  
            
            $('#plant_container').css('display','');
            $('#plant_checkbox_container').html('');
            
            if (plant !== undefined) {
                var arr_plant = plant.split('|');
            } else {
                var arr_plant = '';
            }
            
            $.each(data, function(i,val){
                if ($.inArray(val.plant_name,arr_plant) >= 0) {
                    $('#plant_checkbox_container').append('<label class="checkbox"><input type="checkbox" name="plant_checkbox[]" checked="checked" value="'+val.plant_name+'">'+val.plant_name+'</label>');
                } else {
                    $('#plant_checkbox_container').append('<label class="checkbox"><input type="checkbox" name="plant_checkbox[]" value="'+val.plant_name+'">'+val.plant_name+'</label>');
                }
            })
        })
    }
})
</script>
<script>

$.list();
    
$("a.username").die('click').live('click',function(e){
    e.preventDefault();
    $('#customer_container').css('display','none');
    $('#plant_container').css('display','none');
    $('#error_box').removeClass('alert');
    $('#error_box').html('');
    $('#modal_user').modal('show')
    $.post('<?=$base_url?>/admin/user_data',{id:$(this).attr('id')},
        function(data){
            var data = $.parseJSON(data);
            
            if (data.priv == 'customer') {
                $.listCustomers(data.customer);
            } else if (data.priv == 'plant_operator') {
                $.listPlants(data.plant);
            }
            
            $('input[id=id]').val(data.id);
            $('input[id=username]').val(data.user);
            $('input[id=email]').val(data.email);
            $('input[id=first_name]').val(data.first_name);
            $('input[id=last_name]').val(data.last_name);
            $('input[id=title]').val(data.title);
            $('input[id=position]').val(data.position);
            $('input[id=mobile_no]').val(data.mobile_no);
            $('select[id=privilege]').val(data.priv);
            $('select[id=status]').val(data.status);
            $('input[id=username]').attr('readonly',true);
            $('#btn-holder').html('<button class="btn btn-primary" id="update_user">Update User</button>')
            return false;   
    })
})

$("#add_button").unbind('click').bind('click',function(e){
    e.preventDefault()
    $('#customer_container').css('display','none');
    $('#plant_container').css('display','none');
    $('#error_box').removeClass('alert');
    $('#error_box').html('');
    $('input[id=id]').val('');
    $('input[id=username]').val('');
    $('input[id=username]').attr('readonly',false);
    $('input[id=email]').val('');
    $('input[id=first_name]').val('');
    $('input[id=last_name]').val('');
    $('input[id=title]').val('');
    $('input[id=position]').val('');
    $('input[id=mobile_no]').val('');
    $('select[id=privilege]').val('');
    $('select[id=status]').val('');
    $('#btn-holder').html('<button class="btn btn-primary" id="add_user">Add User</button>')
})
$("#add_user").die('click').live('click',function(e){
    e.preventDefault()
    $.add();   
})
$("#update_user").die('click').live('click',function(e){
    e.preventDefault()
    $.save();    
})

$('#privilege').change(function(){
    $('#customer_container').css('display','none');
    $('#plant_container').css('display','none');
    if ($(this).val() == 'customer') {
        $.listCustomers();
    } else if ($(this).val() == 'plant_operator') {
        $.listPlants();
    }
})
$('.delete_button').die('click').live('click', function(e){
    e.preventDefault()
    var id = $(this).attr('name');
    var name = $(this).attr('id');
    bootbox.confirm("<p class=bootbox-text>Are you sure you want to delete <span class=bootbox-red>"+name+"?</span></p>", function(result) {
        if (result) {
            $.post('<?=$base_url?>/admin/user_delete',{id:id},
            function(data){
                bootbox.alert('<p class=bootbox-text>'+data+' <span class=bootbox-red>'+name+'</span></p>')
                $.list();
            })
        }
    }); 
})
</script>
