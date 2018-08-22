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
    <div class="row-fluid">
        <div class="span2">Region</div>
        <div class="span10">
            <select id="region" class="span2">
            <?php
                foreach($regions as $r){
                    echo '<option value="'.$r->region.'">'.ucwords(strtolower($r->region)).'</option>';
                }
            ?>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Fuel Type</div>
        <div class="span10">
            <select id="fuel_type" class="span2">
                <option value="">All</option>
                <?php
                foreach ($fuel_types as $ft){
                    echo '<option value="'.$ft->type.'">'.ucwords(strtolower($ft->type)).'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div id="grid_data"></div>
    <a href="#modal" role="button" class="btn btn-primary" data-toggle="modal" id="add_button" style="margin-bottom:20px"><i class="icon-plus-sign"></i>&nbsp;&nbsp;Add Resource ID </a>
</div>

<div class="modal fade in" id="modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Resource ID</h4>
    </div>
    <div class="modal-body">
        <div id="error_box"></div>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-condensed">
                <tr><td>Resource ID</td><td><input type="text" class="input-medium important" id='resource_id' label="Resource ID" name="resource_id"></td></tr>
                <tr><td>Participant ID</td><td><input type="text" class="input-medium important" id='participant_id' label="Participant ID" name="participant_id"></td></tr>
                <tr>
                    <td>Region</td>
                    <td>
                        <select class="span2 important" id="region_d" name="region_d" label="Region">
                            <?php
                                foreach($regions as $r){
                                    echo '<option value="'.$r->region.'">'.ucwords(strtolower($r->region)).'</option>';
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Fuel Type</td>
                    <td>
                        <select class="span2 important" id="fuel_type_d" name="fuel_type_d" label="Fuel Type">
                            <?php
                                foreach ($fuel_types as $ft){
                                    echo '<option value="'.$ft->type.'">'.ucwords(strtolower($ft->type)).'</option>';
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr><td>Plant</td><td><input type="text" class="input-medium" id='plant' name="plant"></td></tr>
                <tr><td>Location</td><td><textarea rows="5" class="input-xlarge" id='location' name="location"></textarea></td></tr>
                <tr><td>Owner</td><td><textarea rows="5" class="input-xlarge" id='owner' name="owner"></textarea></td></tr>
                <tr><td>Pmin</td><td><input type="text" class="input-medium important" label="Pmin" id='pmin' name="pmin"></td></tr>
                <tr><td>Pmax</td><td><input type="text" class="input-medium important" label="Pmax" id='pmax' name="pmax"></td></tr>
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
        $.post('<?=$base_url?>/admin/fuel_type_map_update',$('form').serialize(),
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
        $.post('<?=$base_url?>/admin/fuel_type_map_add',$('form').serialize(),
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
    list : function(order,field){
        $.post('<?=$base_url?>/admin/fuel_type_map_json',{order:order,field:field,
            region:$('#region').val(),fuel_type:$('#fuel_type').val()},
        function(data){
            var data = $.parseJSON(data);
            $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="data">');
            $('#data').dataTable({
                "aoColumns": [
                    { "sTitle": "Resource ID" },
                    { "sTitle": "Participant ID" },
                    { "sTitle": "Fuel Type" },
                    { "sTitle": "Plant" },
                    { "sTitle": "Pmin" },
                    { "sTitle": "Pmax" },
                    { "sTitle": "Region" },
                    { "sTitle": "Last Modified" },
                    { "sTitle": "&nbsp;" }
                ]
            });
            
            $.each(data, function(i,val){
                var priv_link = '<a href="#" id="'+val.id+'" class="edit_link">'+val.resource_id+'</a>';
                var del_link = '<a href="#" id="'+val.resource_id+'" class="delete_button" name="'+val.id+'"><i class="icon-remove"></i></a>';
                $('#data').dataTable().fnAddData([priv_link,val.participant_id,val.fuel_type,val.plant,val.pmin,val.pmax,val.region,val.modified,del_link]);
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
    $.post('<?=$base_url?>/admin/fuel_type_map_data',{id:$(this).attr('id')},
        function(data){
            var data = $.parseJSON(data);
            $('input[id=id]').val(data.id);
            $('input[id=resource_id]').val(data.resource_id);
            $('input[id=participant_id]').val(data.participant_id);
            $('select[id=fuel_type_d]').val(data.fuel_type);
            $('select[id=region_d]').val(data.region);
            $('input[id=plant]').val(data.plant);
            $('textarea[id=location]').val(data.location);
            $('textarea[id=owner]').val(data.owner);
            $('input[id=pmin]').val(data.pmin);
            $('input[id=pmax]').val(data.pmax);
            $('#btn-holder').html('<button class="btn btn-primary" id="update"><i class="icon-check"></i>&nbsp;&nbsp;Update&nbsp;&nbsp;</button>')
            return false;
    })
})

$("#add_button").unbind('click').bind('click',function(e){
    e.preventDefault()
    $('#error_box').removeClass('alert');
    $('#error_box').html('');
    $('input[id=id]').val('');
    $('input[id=resource_id]').val('');
    $('input[id=participant_id]').val('');
    $('select[id=fuel_type_d]').val('');
    $('select[id=region_d]').val('');
    $('input[id=plant]').val('');
    $('textarea[id=location]').val('');
    $('textarea[id=owner]').val('');
    $('input[id=pmin]').val('');
    $('input[id=pmax]').val('');
    $('#btn-holder').html('<button class="btn btn-primary" id="add"><i class="icon-check"></i>&nbsp;&nbsp;Save&nbsp;&nbsp;</button>')
})

$("#add").die('click').live('click',function(e){
    e.preventDefault()
    // validation
    var errors = [];

    $('input.important').each(function(){
        if(!$.trim($(this).val())){ 
            errors.push("Please enter a valid " + $(this).attr('label'));
        }
    });

    $('select.important').each(function(){
        if(!$(this).val()){ 
            errors.push('No '+$(this).attr('label')+' selected');
        }
    });
    $pmin = $('#pmin').val();
    $pmax = $('#pmax').val();

    if(isNaN($pmin)){
        errors.push('Pmin textbox accepts only numeric values');
    }
    if(isNaN($pmax)){
        errors.push('Pmax textbox accepts only numeric values');
    }
    if (errors.length > 0) {
        $("#error_box").attr('class','alert alert-info').html(errors.join('<br>'));
    } else {
        $.add();    
    }    
})
$("#update").die('click').live('click',function(e){
    e.preventDefault();

    // validation
    var errors = [];

    $('input.important').each(function(){
        if(!$(this).val()){ 
            errors.push($(this).attr('label')+' required');
        }
    });

    $('select.important').each(function(){
        if(!$(this).val()){ 
            errors.push('No '+$(this).attr('label')+' selected');
        }
    });
    $pmin = $('#pmin').val();
    $pmax = $('#pmax').val();
    if(isNaN($pmin)){
        errors.push('Pmin should be numeric');
    }
    if(isNaN($pmax)){
        errors.push('Pmax should be numeric');
    }
    if (errors.length > 0) {
        $("#error_box").attr('class','alert alert-info').html(errors.join('<br>'));
    } else {
        $.save();    
    }    
})

$('#fuel_type,#region').change(function(){
    $.list();
})

$('.delete_button').die('click').live('click', function(e){
    e.preventDefault()
    var id = $(this).attr('name');
    var name = $(this).attr('id');
    bootbox.confirm("<p class=bootbox-text>Are you sure you want to delete <span class=bootbox-red>"+name+"?</span></p>", function(result) {
        if (result) {
            $.post('<?=$base_url?>/admin/fuel_type_map_delete',{id:id},
            function(data){
                bootbox.alert('<p class=bootbox-text>'+data+' <span class=bootbox-red>'+name+'</span></p>')
                $.list();
            })
        }
    }); 
})
</script>