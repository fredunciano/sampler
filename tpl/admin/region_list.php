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
    <a href="#modal" role="button" class="btn btn-primary" data-toggle="modal" id="add_button"><i class="icon-plus-sign"></i>&nbsp;&nbsp;Add Region </a>
</div>

<div class="modal fade in" id="modal" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Region</h4>
    </div>
    <div class="modal-body">
        <div id="error_box"></div>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-condensed">
                <tr><td>Region</td><td><input type="text" class="input-medium" id='region' name="region"></td></tr>
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
        $.post('<?=$base_url?>/admin/region_update',$('form').serialize(),
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
        if ($.trim($("#region").val()) == "") {
            $('#error_box').attr('class','alert alert-error');
            $('#error_box').html("Please enter a valid Region");
            return false;
        }

        $.post('<?=$base_url?>/admin/region_add',$('form').serialize(),
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
        $.post('<?=$base_url?>/admin/region_list_json',{order:order,field:field},
        function(data){
            var data = $.parseJSON(data);
            $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="data">');
            $('#data').dataTable({

                "aoColumns": [
                    { "sTitle": "Region" },
                    { "sTitle": "Last Modified" },
                    { "sTitle": "&nbsp;" }
                ]
            });
            
            $.each(data, function(i,val){
                var priv_link = '<a href="#" id="'+val.id+'" class="edit_link">'+val.region+'</a>';
                var del_link = '<a href="#" id="'+val.region+'" class="delete_button" name="'+val.id+'"><i class="icon-remove"></i></a>';
                $('#data').dataTable().fnAddData([priv_link,val.modified,del_link]);
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
    $.post('<?=$base_url?>/admin/region_data',{id:$(this).attr('id')},
        function(data){
            var data = $.parseJSON(data);
            $('input[id=id]').val(data.id);
            $('input[id=region]').val(data.region)
            $('#btn-holder').html('<button class="btn btn-primary" id="update"><i class="icon-check"></i>&nbsp;&nbsp;Update&nbsp;&nbsp;</button>')
            return false;
    })
})

$("#add_button").unbind('click').bind('click',function(e){
    e.preventDefault()
    $('#error_box').removeClass('alert');
    $('#error_box').html('');
    $('input[id=id]').val('');
    $('input[id=region]').val('');
    $('#btn-holder').html('<button class="btn btn-primary" id="add"><i class="icon-check"></i>&nbsp;&nbsp;Save&nbsp;&nbsp;</button>')
})

$("#add").die('click').live('click',function(e){
    e.preventDefault();
    // validation
    var errors = [];

    if ( $('#region').val() === '' || $('#region').val() === null ) {
        errors.push('Region can\'t be empty.');
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

    if ( $('#region').val() === '' || $('#region').val() === null ) {
        errors.push('Region can\'t be empty.');
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
            $.post('<?=$base_url?>/admin/region_delete',{id:id},
            function(data){
                bootbox.alert('<p class=bootbox-text>'+data+' <span class=bootbox-red>'+name+'</span></p>')
                $.list();
            })
        }
    }); 
})
</script>