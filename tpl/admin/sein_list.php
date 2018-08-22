
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
    <a href="#modal" role="button" class="btn btn-primary" data-toggle="modal" id="add_button"><i class="icon-plus-sign"></i>&nbsp;&nbsp;Add SEIN </a>
</div>

<div class="modal fade in" id="modal" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">SEIN</h4>
    </div>
    <div class="modal-body">
        <div id="error_box"></div>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-condensed">
                <tr><td>SEIN</td><td><input type="text" class="input-medium" id='sein' name="sein"></td></tr>
                <tr>
                    <td>Type</td>
                    <td>
                        <select id="type" name="type" class="span2">
                            <option value="GEN">GEN</option>
                            <option value="LD">LOAD</option>
                        </select>
                    </td>
                </tr>
                <tr class="resource_tr">
                    <td>Resource</td>
                    <td>
                        <select id="resource" name="resource">
                            <?php
                            foreach ($resources as $i=>$val) {
                                echo '<option value="'.$val->resource_id.'">'.$val->resource_id.'</option>';
                            }

                            ?>
                        </select>
                    </td>
                </tr>
                <tr class="customer_tr" style="display:none">
                    <td>Customer Name</td>
                    <td>
                        <select id="customer" name="customer">
                            <?php
                            foreach ($customers as $i=>$val) {
                                echo '<option>'.$val->name.'</option>';
                            }

                            ?>
                        </select>
                    </td>
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
        $.post('<?=$base_url?>/admin/sein_update',$('form').serialize(),
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
    },
    add : function(){
        if ($.trim($("#sein").val()) == "") {
            $('#error_box').attr('class','alert alert-error');
            $('#error_box').html("Please enter a valid SEIN");
            return false;
        }

        if ($("#sein").val() !== "") {
            $.post('<?=$base_url?>/admin/sein_add',$('form').serialize(),
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
        } else {
            $('#error_box').attr('class','alert alert-error');
            $('#error_box').html("SEIN cannot be empty");
        }
        
    },
    list : function(order,field){
        $.post('<?=$base_url?>/admin/sein_list_json',{order:order,field:field},
        function(data){
            var data = $.parseJSON(data);
            $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="data">');
            $('#data').dataTable({

                "aoColumns": [
                    { "sTitle": "SEIN" },
                    { "sTitle": "Resource ID" },
                    { "sTitle": "Customer Name" },
                    { "sTitle": "Type" },
                    { "sTitle": "Last Modified" },
                    { "sTitle": "&nbsp;" }
                ]
            });
            
            $.each(data, function(i,val){
                var priv_link = '<a href="#" id="'+val.id+'" class="edit_link">'+val.sein+'</a>';
                var del_link = '<a href="#" id="'+val.sein+'" class="delete_button" name="'+val.id+'"><i class="icon-remove"></i></a>';
                $('#data').dataTable().fnAddData([priv_link,val.resource_id,val.customer,val.type,val.modified,del_link]);
            })
        })    
    }
})
</script>
<script>
$.list();

$("a.edit_link").die('click').live('click',function(e){
    e.preventDefault();
    $('#error_box').removeClass('alert');
    $('#error_box').html('');
    $('#modal').modal('show')
    $.post('<?=$base_url?>/admin/sein_data',{id:$(this).attr('id')},
        function(data){
            var data = $.parseJSON(data);
            $('input[id=id]').val(data.id);
            $('input[id=sein]').attr('readonly',true);
            $('input[id=sein]').val(data.sein)
            $('select[id=resource]').val(data.resource_id);
            $('select[id=customer]').val(data.customer);
            $('select[id=type]').val(data.type);
            $('#btn-holder').html('<button class="btn btn-primary" id="update"><i class="icon-check"></i>&nbsp;&nbsp;Update&nbsp;&nbsp;</button>')
            return false;
    })
})

$("#add_button").unbind('click').bind('click',function(e){
    e.preventDefault()
    $('#error_box').removeClass('alert');
    $('#error_box').html('');
    $('input[id=id]').val('');
    $('input[id=sein]').removeAttr('readonly');
    $('input[id=sein]').val('')
    $('select[id=resource]').val('');
    $('select[id=customer]').val('');
    $('select[id=type]').val('');
    $('#btn-holder').html('<button class="btn btn-primary" id="add"><i class="icon-check"></i>&nbsp;&nbsp;Save&nbsp;&nbsp;</button>')
})

$("#add").die('click').live('click',function(e){
    e.preventDefault()
    $.add();    
})
$("#update").die('click').live('click',function(e){
    e.preventDefault()
    $.save();    
})

$("#type").die('change').live('change',function(){
    
    if ($(this).val() == 'GEN') {
        $('.resource_tr').css('display','');
        $('.customer_tr').css('display','none');    
    } else {
        $('.customer_tr').css('display','');
        //$('.resource_tr').css('display','none');
    }
    
    $.post('<?=$base_url?>/admin/mms_resource_list_json',{type:$(this).val()},
        function(data){
            var data = $.parseJSON(data);
            var option = '';
            $('select[id=resource]').empty()
            
            $.each(data, function(i,val){
                option = '<option>'+val.resource_id+'</option>';
                $('select[id=resource]').append(option)
            })
    })
});
$('.delete_button').die('click').live('click', function(e){
    e.preventDefault()
    var id = $(this).attr('name');
    var name = $(this).attr('id');
    bootbox.confirm("<p class=bootbox-text>Are you sure you want to delete <span class=bootbox-red>"+name+"?</span></p>", function(result) {
        if (result) {
            $.post('<?=$base_url?>/admin/sein_delete',{id:id},
            function(data){
                bootbox.alert('<p class=bootbox-text>'+data+' <span class=bootbox-red>'+name+'</span></p>')
                $.list();
            })
        }
    }); 
})    

</script>