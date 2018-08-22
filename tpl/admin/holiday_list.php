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
    <div id="upload_msg"></div>
    <form id="frm1" method='post' name='frm1' class="form-horizontal" enctype="multipart/form-data" onsubmit='return false'>
    <div class="row-fluid">
        <div class="span2">File Upload </div>
        <div class="span10">
        <div class="fileupload fileupload-new span6" data-provides="fileupload">
        <div class="input-append">
        <div class="uneditable-input span4"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
        <span class="btn btn-file"><span class="fileupload-new">Select file</span>
        <span class="fileupload-exists">Change</span><input type="file" name="filebrowser" id="filebrowser" />
        </span>
        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
        <input type="button" value="Upload" id="upload_btn" class="btn fileupload-exists btn-primary" />
         <span id="upload-msg"></span>
        </div>
        </div>
        </div>
        <br/>
    </div>
     
    <div class="row-fluid">
            <div style="margin-left: 160px;"><a style="cursor: pointer;" id="download_template">Download Template </a></div>
    </div>
        </form>
    <hr>
    
    <div id="grid_data"></div>
    <a href="#modal" role="button" class="btn btn-primary" data-toggle="modal" id="add_button"><i class="icon-plus-sign"></i>&nbsp;&nbsp;Add Holiday </a>
    

</div>

<div class="modal fade in" id="modal" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Holiday</h4>
    </div>
    <div class="modal-body">
        <div id="error_box"></div>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-condensed">
                <tr><td>Holiday</td><td><input type="text" class="input-medium" id='holiday' name="holiday"></td></tr>
                <tr><td>Date</td><td><input type="text" class="input-medium" id='hdate' name="hdate"></td></tr>
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
        if(!$('#holiday').val()){
            $('#error_box').html('Holiday is empty').attr('class','alert alert-error');
            return false;
        }
        if(!$('#hdate').val()){
            $('#error_box').html('Date is empty').attr('class','alert alert-error');
            return false;
        }
        $.post('<?=$base_url?>/admin/holiday_update',$('form').serialize(),
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
        if(!$('#holiday').val()){
            $('#error_box').html('Holiday is empty').attr('class','alert alert-error');
            return false;
        }
        if(!$('#hdate').val()){
            $('#error_box').html('Date is empty').attr('class','alert alert-error');
            return false;
        }
        $.post('<?=$base_url?>/admin/holiday_add',$('form').serialize(),
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
        $.post('<?=$base_url?>/admin/holiday_list_json',{order:order,field:field},
        function(data){
            var data = $.parseJSON(data);
            $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="data">');
            $('#data').dataTable({
                "aoColumns": [
                    { "sTitle": "Holiday Name" },
                    { "sTitle": "Date" },
                    { "sTitle": "Last Modified" },
                    { "sTitle": "&nbsp;" }
                ]
            });
            
            $.each(data, function(i,val){
                var priv_link = '<a href="#" id="'+val.id+'" class="edit_link">'+val.holiday+'</a>';
                var del_link = '<a href="#" id="'+val.holiday+'" class="delete_button" name="'+val.id+'"><i class="icon-remove"></i></a>';
                $('#data').dataTable().fnAddData([priv_link,val.date,val.modified,del_link]);
            })
        })    
    }
})
</script>
<script>
$('#hdate').datepicker();
$.list();

$("a.edit_link").die('click').live('click',function(e){
    e.preventDefault();
    $('#error_box').removeClass('alert');
    $('#error_box').html('');
    $('#modal').modal('show')
    $.post('<?=$base_url?>/admin/holiday_data',{id:$(this).attr('id')},
        function(data){
            var data = $.parseJSON(data);
            $('input[id=id]').val(data.id);
            $('input[id=holiday]').val(data.holiday);
            $('input[id=hdate]').val(data.date);
            $('#btn-holder').html('<button class="btn btn-primary" id="update"><i class="icon-check"></i>&nbsp;&nbsp;Update&nbsp;&nbsp;</button>')
            return false;
    })
})

$("#add_button").unbind('click').bind('click',function(e){
    e.preventDefault()
    $('#error_box').removeClass('alert');
    $('#error_box').html('');
    $('input[id=id]').val('');
    $('input[id=holiday]').val('');
    $('input[id=date]').val('');

    $('#btn-holder').html('<button class="btn btn-primary" id="add"><i class="icon-check"></i>&nbsp;&nbsp;Save&nbsp;&nbsp;</button>')
})

$("#add").die('click').live('click',function(e){
    e.preventDefault()
    // validation
    var errors = [];

    if ( $.trim($('#holiday').val()) === '' || $.trim($('#holiday').val()) === null ) {
        errors.push('Holiday is empty.');
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

    if ( $.trim($('#holiday').val()) === '' || $.trim($('#holiday').val()) === null ) {
        errors.push('Holiday is empty.');
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
            $.post('<?=$base_url?>/admin/holiday_delete',{id:id},
            function(data){
                bootbox.alert('<p class=bootbox-text>'+data+' <span class=bootbox-red>'+name+'</span></p>')
                $.list();
            })
        }
    }); 
});


$('#download_template').unbind('click').bind('click',function(){
    var url = 'http://' + location.host + '<?=$base_url?>' + '/admin/holiday_download_template'
    $.download(url,'x=1');
 });
 
 
 $('#upload_btn').unbind('click').bind('click',function(e){
    e.preventDefault();
    var path = '../admin/holiday_upload';
    $('#upload_msg').html('');
    var options = {target:'',
        url:path,
        data: {},
        beforeSubmit: function() {
           var msg_contents = '<div class="alert alert-info">';
            msg_contents+= ' <button type="button" class="close" data-dismiss="alert">&times;</button>';
            msg_contents+= ' <div>Please wait, uploading file ...  </div>';
            msg_contents+= ' </div>';
            $('#upload_msg').html(msg_contents);
        },
        success: function(dataRet) {
            var data = $.parseJSON(dataRet);
            var msg_contents = '<div class="alert alert-success">';
            msg_contents+= ' <button type="button" class="close" data-dismiss="alert">&times;</button>';
            msg_contents+= ' <div>'+data.message+'</div>';
            msg_contents+= ' </div>';
            $('#upload_msg').html(msg_contents);
            $('#uploader-loader').html('&nbsp;');
            if (parseInt(data.success,10) > 0) {
                $.list();
            }
            //

        }};
    $('#frm1').ajaxSubmit(options);
   
});
</script>