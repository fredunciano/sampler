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
    <a href="#modal" role="button" class="btn btn-primary" data-toggle="modal" id="add_button"><i class="icon-plus-sign"></i>&nbsp;&nbsp;Add Resource </a>
    <br><br><br>
</div>

<div class="modal fade in" id="modal" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Resource</h4>
    </div>
    <div class="modal-body">
        <div id="error_box"></div>
        <form method="post">
            <input type="hidden" id="id" name="id">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-condensed">
                <tr><td>Resource ID</td><td><input type="text" class="input-medium" id='resource_id' name="resource_id"></td></tr>
                <tr><td>Resource Name</td><td><input type="text" class="input-medium" id='resource_name' name="resource_name"></td></tr>
                <tr>
                    <td>Participant Name</td>
                    <td>
                        <select id="participant" name="participant">
                            <?php
                            foreach ($participants as $i=>$val) {
                                echo '<option>'.$val->participant.'</option>';
                            }

                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Plant</td>
                    <td>
                        <select id="plant" name="plant">
                            <?php
                            foreach ($plants as $i=>$val) {
                                echo '<option>'.$val->plant_name.'</option>';
                            }

                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Region</td>
                    <td>
                        <select id="region" name="region">
                            <?php
                            foreach ($regions as $i=>$val) {
                                echo '<option>'.$val->region.'</option>';
                            }

                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Fuel Type</td>
                    <td>
                        <select id="fuel_type" name="fuel_type">
                            <?php
                            foreach ($fuel_types as $i=>$val) {
                                echo '<option>'.$val->type.'</option>';
                            }

                            ?>
                        </select>
                    </td>
                </tr>
                <tr><td>Pmin</td><td><input type="text" class="input-mini" id='pmin' name="pmin"></td></tr>
                <tr><td>Pmax</td><td><input type="text" class="input-mini" id='pmax' name="pmax"></td></tr>
                <tr><td>Breakpoint</td><td><input type="text" class="input-mini" id='ramp_rate' name="ramp_rate"></td></tr>
                <tr><td>Ramp Up</td><td><input type="text" class="input-mini" id='ramp_up' name="ramp_up"></td></tr>
                <tr><td>Ramp Down</td><td><input type="text" class="input-mini" id='ramp_down' name="ramp_down"></td></tr>
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
        $.post('<?=$base_url?>/admin/resource_update',$('form').serialize(),
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

        var is_error = 0;
        var error = [];
        var resource_id = $('#resource_id').val();
        if (resource_id.length === 0) {
            is_error = 1;
            error.push("Resource ID can't be empty");
        }else {
            if ($.trim(resource_id).length <= 0) {
                is_error = 1;
                error.push("Please enter a valid Resource ID");
            }
        }


        var resource_name = $('#resource_name').val();
        if (resource_name.length === 0) {
            is_error = 1;
            error.push("Resource Name can't be empty");
        }else {
            if ($.trim(resource_name).length <= 0) {
                is_error = 1;
                error.push("Please enter a valid Resource Name");
            }
        }

        if (is_error == 0){
            $.post('<?=$base_url?>/admin/resource_add',$('form').serialize(),
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
            $('#error_box').attr('class','alert alert-error').html(error.join('<br>'));
        }
    },
    list : function(order,field){
        $.post('<?=$base_url?>/admin/resource_list_json',{order:order,field:field},
        function(data){
            var data = $.parseJSON(data);
            $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="data">');
            $('#data').dataTable({

                "aoColumns": [
                    { "sTitle": "Resource ID" },
                    { "sTitle": "Resource Name" },
                    { "sTitle": "Participant Name" },
                    { "sTitle": "Plant Name" },
                    { "sTitle": "Region" },
                    { "sTitle": "Fuel Type" },
                    { "sTitle": "Pmin" },
                    { "sTitle": "Pmax" },
                    { "sTitle": "Ramp Rate" },
                    { "sTitle": "Last Modified" },
                    { "sTitle": "&nbsp;" }
                ]
            });

            $.each(data, function(i,val){
                var priv_link = '<a href="#" id="'+val.id+'" class="edit_link">'+val.resource_id+'</a>';
                var del_link  = '<a href="#" id="'+val.resource_id+'" class="delete_button" name="'+val.id+'"><i class="icon-remove"></i></a>';
                var ramp_rate = val.ramp_rate+'|'+val.ramp_up+'|'+val.ramp_down
                $('#data').dataTable().fnAddData([priv_link,val.resource_name,val.participant,val.plant,val.region,val.fuel_type,val.pmin,val.pmax,ramp_rate,val.modified,del_link]);
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
    $.post('<?=$base_url?>/admin/resource_data',{id:$(this).attr('id')},
        function(data){
            var data = $.parseJSON(data);

            $('input[id=id]').val(data.id);
            $('input[id=resource_id]').attr('readonly',true);
            $('input[id=resource_id]').val(data.resource_id);
            $('input[id=resource_name]').val(data.resource_name);
            $('select[id=participant]').val(data.participant);
            $('select[id=plant]').val(data.plant);
            $('select[id=region]').val(data.region);
            $('select[id=fuel_type]').val(data.fuel_type);
            $('input[id=pmin]').val(data.pmin);
            $('input[id=pmax]').val(data.pmax);
            $('input[id=ramp_rate]').val(data.ramp_rate);
            $('input[id=ramp_up]').val(data.ramp_up);
            $('input[id=ramp_down]').val(data.ramp_down);
            $('#btn-holder').html('<button class="btn btn-primary" id="update"><i class="icon-check"></i>&nbsp;&nbsp;Update&nbsp;&nbsp;</button>')
            return false;
    })
})

$("#add_button").unbind('click').bind('click',function(e){
    e.preventDefault()
    $('#error_box').removeClass('alert');
    $('#error_box').html('');
    $('input[id=id]').val('');
    $('input[id=resource_id]').removeAttr('readonly');
    $('input[id=resource_id]').val('');
    $('input[id=resource_name]').val('');
    $('select[id=participant]').val('');
    $('select[id=plant_name]').val('');
    $('select[id=region]').val('');
    $('select[id=fuel_type]').val('');
    $('input[id=pmin]').val('');
    $('input[id=pmax]').val('');
    $('input[id=ramp_rate]').val('');
    $('input[id=ramp_up]').val('');
    $('input[id=ramp_down]').val('');
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
$('.delete_button').die('click').live('click', function(e){
    e.preventDefault()
    var id = $(this).attr('name');
    var name = $(this).attr('id');
    bootbox.confirm("<p class=bootbox-text>Are you sure you want to delete <span class=bootbox-red>"+name+"?</span></p>", function(result) {
        if (result) {
            $.post('<?=$base_url?>/admin/resource_delete',{id:id},
            function(data){
                bootbox.alert('<p class=bootbox-text>'+data+' <span class=bootbox-red>'+name+'</span></p>')
                $.list();
            })
        }
    });
})
</script>
