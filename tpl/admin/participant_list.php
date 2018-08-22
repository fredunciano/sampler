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
    <a href="#modal" role="button" class="btn btn-primary" data-toggle="modal" id="add_button"><i class="icon-plus-sign"></i>&nbsp;&nbsp;Add Participant </a>
</div>

<div class="modal fade in" id="modal" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Participant</h4>
    </div>
    <div class="modal-body">
        <div id="error_box"></div>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id">
            <div class="row-fluid">
                <div class="span3">Participant</div>
                <div class="span9">
                    <input type="text" class="input-medium" id='participant' name="participant">
                </div>
            </div>
            <div class="row-fluid">
                <div class="span3">Description</div>
                <div class="span9">
                    <textarea id="description" name="description" rows="4" class="input-xlarge"></textarea>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12"><h5>Market Participant User Access Information (for Web Login)</h5></div>
            </div>
            <div class="row-fluid">
                <div class="span3">Cert Username</div>
                <div class="span9">
                    <input type="text" class="input-medium" id='cert_user' name="cert_user">
                </div>
            </div>
            <div class="row-fluid">
                <div class="span3">Cert Password</div>
                <div class="span9">
                    <input type="password" class="input-medium" id='cert_pass' name="cert_pass"> (example : XXxXXXxX)
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12"><h5>Digital Certificate (DC) Information</h5></div>
            </div>
            <div class="row-fluid">
                <div class="span3">DC Password</div>
                <div class="span9">
                    <input type="password" class="input-medium" id='cert_pass' name="dc_pass"> (example : xxx_01)
                </div>
            </div>
            <div class="row-fluid">
                <div class="span3">Upload&nbsp;Certificate</div>
                <div class="span9">
                    <div class="fileupload fileupload-new span5" data-provides="fileupload">
                        <div class="input-append">
                            <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
                            <span class="btn btn-file"><span class="fileupload-new">Select file</span>
                                <span class="fileupload-exists">Change</span><input type="file" name="filebrowser" id="filebrowser" />
                            </span>
                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="alert"></div>
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
        var path = "../admin/participant_update";
        var options = {target:'#alert',
            url:path,
            beforeSubmit: function() { 
                $('#alert').html('Loading<img src="../images/ajax-loader.gif">')
            },
            success: function(data) {
                
                ret = data.split('|');
                $('#alert').html(ret[1])
                if (ret[0] == 1) {
                    $('#alert').attr('class','alert alert-success');
                } else {
                    $('#alert').attr('class','alert alert-error');
                }
                $.list();
            }};
        $('form').ajaxSubmit(options);
    },
    add : function(){

        var is_error = 0;
        var error = '';
        var participant = $('#participant').val();
        if (participant.length === 0) {
            is_error = 1;
            error = "Participant can't be empty";
        }else {
            if ($.trim(participant).length <= 0) {
                is_error = 1;
                error = "Please enter a valid Participant";
            }
        }

        if (is_error == 0) {
            var path = "../admin/participant_add";
            var options = {target:'#alert',
                url:path,
                beforeSubmit: function() { 
                    $('#alert').html('Loading<img src="../images/ajax-loader.gif">')
                },
                success: function(data) {
                    ret = data.split('|');
                    $('#alert').html(ret[1])
                    if (ret[0] == 1) {
                        $('#alert').attr('class','alert alert-success');
                    } else {
                        $('#alert').attr('class','alert alert-error');
                    }
                    $.list();
                }};
            
            $('form').ajaxSubmit(options);
        }else {
            $('#alert').attr('class','alert alert-error').html(error)
        }

        
    },
    list : function(){
        $.post('<?=$base_url?>/admin/participant_list_json',{},
        function(data){
            var data = $.parseJSON(data);  
            $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="data">');
            $('#data').dataTable({

                "aoColumns": [
                    { "sTitle": "Participant" },
                    { "sTitle": "Description" },
                    { "sTitle": "Certificate" },
                    { "sTitle": "Cert Username" },
                    { "sTitle": "Last Modified" },
                    { "sTitle": "&nbsp;" }
                ]
            });
            
            $.each(data, function(i,val){
                var participant_link = '<a href="#" id="'+val.id+'" class="edit_link">'+val.participant+'</a>';
                var del_link = '<a href="#" id="'+val.participant+'" class="delete_button" name="'+val.id+'"><i class="icon-remove"></i></a>';
                $('#data').dataTable().fnAddData([participant_link,val.description,val.cert_file,val.cert_user,val.modified,del_link]);
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
    $.post('<?=$base_url?>/admin/participant_data',{id:$(this).attr('id')},
        function(data){
            $('input').val('');
            var data = $.parseJSON(data);
            $('input[id=id]').val(data.id);
            $('input[id=participant]').val(data.participant);
            $('textarea[id=description]').val(data.description);
            $('input[id=cert_user]').val(data.cert_user);
            $('input[id=participant]').attr('readonly',true);
            $('#btn-holder').html('<button class="btn btn-primary" id="update"><i class="icon-check"></i>&nbsp;&nbsp;Update&nbsp;&nbsp;</button>')
            return false;
    })
    $.list();
})

$("#filebrowser").change(function(){
    $("#fileinput").val($(this).val())
});

$("#add_button").unbind('click').bind('click',function(e){
    e.preventDefault()
    $('#error_box').removeClass('alert');
    $('#error_box').html('');
    $('input').val('');
    $('input[id=id]').val('');
    $('input[id=participant]').removeAttr('readonly');
    $('input[id=participant]').val('');
    $('textarea[id=description]').val('');
    $('select[id=user]').val('');
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
            $.post('<?=$base_url?>/admin/participant_delete',{id:id},
            function(data){
                bootbox.alert('<p class=bootbox-text>'+data+' <span class=bootbox-red>'+name+'</span></p>')
                $.list();
            })
        }
    }); 
})
</script>