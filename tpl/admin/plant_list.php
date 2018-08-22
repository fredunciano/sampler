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
    <a href="#modal" role="button" class="btn btn-primary" data-toggle="modal" id="add_button"><i class="icon-plus-sign"></i>&nbsp;&nbsp;Add Plant </a>
</div>

<div class="modal fade in" id="modal" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Plant</h4>
    </div>
    <div class="modal-body">
        <div id="error_box"></div>
        <form method="post">
            <input type="hidden" id="id" name="id">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-condensed">
                <tr><td>Plant</td><td><input type="text" class="input-medium" id='plant_name' name="plant_name"></td></tr>
                <tr><td>Long Name</td><td><input type="text" class="input-medium" id='long_name' name="long_name"></td></tr>
                <tr><td>Participant</td><td>
                    <select id="participant" name="participant">
                        <?php
                        foreach ($participants as $i=>$val) {
                            echo '<option>'.$val->participant.'</option>';
                        }
                        
                        ?>
                    </select>
                </td></tr>
                <tr><td>Type</td><td><input type="text" class="input-medium" id='type' name="type"></td></tr>
                <tr><td>Fuel</td><td><input type="text" class="input-medium" id='fuel' name="fuel"></td></tr>
                <tr><td>Installed Capacity</td><td><input type="text" class="input-medium" id='installed_capacity' name="installed_capacity"></td></tr>
               <tr><td>Location</td><td>
                    <textarea id="location" name="location" rows="4" class="input-xlarge"></textarea>
                </td></tr>
                <tr><td>Description</td><td>
                    <textarea id="description" name="description" rows="4" class="input-xlarge"></textarea>
                </td></tr>
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
        $.post('<?=$base_url?>/admin/plant_update',$('form').serialize(),
        function(data){
            ret = data.split('|');
            if (ret[0] == 1) {
                $('#error_box').attr('class','alert alert-success');
            } else {
                $('#error_box').attr('class','alert alert-error');
            }
            $('#error_box').html(ret[1]);
        })
        $.list();
    },
    add : function(){
        if ($.trim($("#plant_name").val()) == "") {
            $('#error_box').attr('class','alert alert-error');
            $('#error_box').html("Please enter a valid plant name");
        } else {
               $.post('<?=$base_url?>/admin/plant_add',$('form').serialize(),
                function(data){
                    ret = data.split('|');
                    if (ret[0] == 1) {
                        $('#error_box').attr('class','alert alert-success');
                    } else {
                        $('#error_box').attr('class','alert alert-error');
                    }
                    $('#error_box').html(ret[1]);
                })
                $.list();
        }
     
    },
    list : function(order,field){
        $.post('<?=$base_url?>/admin/plant_list_json',{order:order,field:field},
        function(data){
            var data = $.parseJSON(data);  
            $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="data">');
            $('#data').dataTable({

                "aoColumns": [
                    { "sTitle": "Plant" },
                    { "sTitle": "Participant" },
                    { "sTitle": "Description" },
                    { "sTitle": "Last Modified" },
                    { "sTitle": "&nbsp;" }
                ]
            });
            
            $.each(data, function(i,val){
                var link = '<a href="#" id="'+val.id+'" class="edit_link">'+val.plant_name+'</a>';
                var del_link = '<a href="#" id="'+val.plant_name+'" class="delete_button" name="'+val.id+'"><i class="icon-remove"></i></a>';
                $('#data').dataTable().fnAddData([link,val.participant,val.description,val.modified,del_link]);
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
    $.post('<?=$base_url?>/admin/plant_data',{id:$(this).attr('id')},
        function(data){
            var data = $.parseJSON(data);
            $('input[id=id]').val(data.id);
            $('input[id=plant_name]').val(data.plant_name);
            $('select[id=participant]').val(data.participant_name);
            $('textarea[id=description]').val(data.description);
            $('textarea[id=location]').val(data.location);
            $('input[id=long_name]').val(data.long_name);
   	 		$('input[id=type]').val(data.type);
    		$('input[id=fuel]').val(data.fuel);
    		$('input[id=installed_capacity]').val(data.installed_capacity);
            $('input[id=plant_name]').attr('readonly',true);
            $('#btn-holder').html('<button class="btn btn-primary" id="update"><i class="icon-check"></i>&nbsp;&nbsp;Update&nbsp;&nbsp;</button>')
            return false;
    })
    $.list();
})

$("#add_button").unbind('click').bind('click',function(e){
    e.preventDefault()
    $('#error_box').removeClass('alert');
    $('#error_box').html('');
    $('input[id=id]').val('');
    $('input[id=plant_name]').val('');
    $('input[id=long_name]').val('');
    $('input[id=type]').val('');
    $('input[id=fuel]').val('');
    $('input[id=installed_capacity]').val('');
    $('input[id=plant_name]').removeAttr('readonly');
    $('select[id=participant]').val('');
    $('textarea[id=description]').val('');
    $('textarea[id=location]').val('');
    $('#btn-holder').html('<button class="btn btn-primary" id="add"><i class="icon-check"></i>&nbsp;&nbsp;Save&nbsp;&nbsp;</button>')
})

$("#add").die('click').live('click',function(e){
    e.preventDefault();
    // validation
    var errors = [];

    if ( $('#plant_name').val() === '' || $('#plant_name').val() === null ) {
        errors.push('Plant name can\'t be empty.');
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

    if ( $('#plant_name').val() === '' || $('#plant_name').val() === null ) {
        errors.push('Plant name can\'t be empty.');
    }
    if (errors.length > 0) {
        $("#error_box").attr('class','alert alert-info').html(errors.join('<br>'));
    } else {
        $.save(); 
    }  
})
$('.delete_button').die('click').live('click', function(e){
    e.preventDefault()
    var id = $(this).attr('name');
    var name = $(this).attr('id');
    bootbox.confirm("<p class=bootbox-text>Are you sure you want to delete <span class=bootbox-red>"+name+"?</span></p>", function(result) {
        if (result) {
            $.post('<?=$base_url?>/admin/plant_delete',{id:id},
            function(data){
                bootbox.alert('<p class=bootbox-text>'+data+' <span class=bootbox-red>'+name+'</span></p>')
                $.list();
            })
        }
    }); 
})
</script>