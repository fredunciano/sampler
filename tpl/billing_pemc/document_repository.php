<style>
.progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
.bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
.percent { position:absolute; display:inline-block; top:3px; left:48%; }
</style>
<div class="span3">
	<ul class="nav nav-tabs nav-stacked">
		<?php
		foreach ($submenu as $sm) {
		      echo '<li><a href="'.$base_url.$sm['link'].'">'.$sm['title'].'</a></li>';
		}
		?>
	</ul>
</div>

<div class="span12">
 <legend><h4><?=$title?><small>&nbsp;</small></h4></legend>   
	
    <br><br>

    <div id="grid_data"></div>

    <!-- Div for Modal -->
    <div class="modal fade in" id="modal" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 id="ModalLabel">Edit Document Info:</h4>
        </div>
        <div class="modal-body">
            <div id="error_box"></div>
            <form enctype="multipart/form-data">
                <input type = "hidden" id = "priv_index" value = "<?=base64_decode($_SESSION['privilege'])?>" />
                <input type="hidden" id="id" name="id">
                <div class="row-fluid">
                    <div class="span3">Document Type:</div>
                    <div class="span7">
                        <select id="docu_type" name="docu_type" class="input-medium">
                            <?php
                            foreach ( $documents as $d ) {
                                echo '<option value="'.$d->document_type.'">'.$d->document_type.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span3">Description</div>
                        <div class="span3">
                         <textarea rows="5" class="input-xlarge" id='description1' name="description1"></textarea>
                        </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <span id="btn-holder"></span>
        </div>
    </div>
    <!-- End - Div for Modal -->
</div>

<script> 
$.extend({
    // list datatables
    list : function(){
        $.post('<?=$base_url?>/billing_pemc/list_document_json',
            function(data){
            console.log(data)
            if (data.count == 0){
                $('#grid_data').attr('class','alert alert-info');
                $('#grid_data').html('<span style="padding:10px">No Data to Display</span>')
            }else{
                $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="data">');
                
                if ($('#priv_index').val() == 'admin'){
                     $('#data').dataTable({
                    
                     "aoColumns": [
                            { "sTitle": "Document&nbsp;Type"},
                            { "sTitle": "Document&nbsp;No."},
                            { "sTitle": "Filename"},
                            { "sTitle": "Description"},
                            { "sTitle": "Uploaded&nbsp;by"},
                            { "sTitle": "Date Created"},
                            { "sTitle": "Edit"},
                            { "sTitle": "Delete"}
                        ]
                    });
                    
                    $.each(data.value, function(i,val){
                        var priv_link = '<a href="#" id="'+val.filename+'" class="dl_link" >'+val.filename+'</a>'; 
                        var edit_link = '<a href="#" id="'+val.id+'" class="edit_link" >Edit</a>';
                        var del_link = '<a href="#" id="'+val.id+'" class="delete_button"><i class="icon-remove"></i></a>';
                        $('#data').dataTable().fnAddData([val.document_type,val.document_no,priv_link,val.desc,val.uploaded_by,val.date_created,edit_link,del_link]);

                    })    
                }else{
                     $('#data').dataTable({
                    
                     "aoColumns": [
                            { "sTitle": "Document&nbsp;Type"},
                            { "sTitle": "Document&nbsp;No."},
                            { "sTitle": "Filename"},
                            { "sTitle": "Description"},
                            { "sTitle": "Uploaded&nbsp;by"},
                            { "sTitle": "Edit"}
                        ]
                    });
                    
                    $.each(data.value, function(i,val){
                        var priv_link = '<a href="#" id="'+val.filename+'" class="dl_link" >'+val.filename+'</a>'; 
                        var edit_link = '<a href="#" id="'+val.id+'" class="edit_link" >Edit</a>';

                        $('#data').dataTable().fnAddData([val.document_type,val.document_no,priv_link,val.desc,val.uploaded_by,edit_link]);

                    })
                }
               
            }       
        })    
    },
    generateFile : function(filename){
        $.download('../billing_pemc/generate_file',"file=" + filename);
    },
    update : function(){
        $('#error_box').attr('class','alert alert-success');
        $('#error_box').html('Saving &nbsp;<img src="../images/ajax-loader.gif">');

        $.post('<?=$base_url?>/billing_pemc/document_update',$('form').serialize(),
        function(data){
            ret = data.split('|');
            if (ret[0] == 1) {
                $('#error_box').attr('class','alert alert-success');
                $('#error_box').html('Successfully Updated');
            } else {
                $('#error_box').attr('class','alert alert-error');
                $('#error_box').html('Error');
            }
            $('#error_box').html(ret[1]);
            $.list();
        }) 
    },
    delete_docu : function(id){
        $.post('<?=$base_url?>/billing_pemc/document_delete',{id : id},
            function(data){
                $.list();
        }) 
    },

  
})

</script>
<script>
$.list();

$("a.dl_link").die('click').live('click',function(e){
    e.preventDefault();
      $.generateFile($(this).attr('id'))
})

$("a.edit_link").die('click').live('click',function(e){ // For modal to edit the type & description
    e.preventDefault();
    $('#error_box').removeClass('alert');
    $('#error_box').html('');
    $('#modal').modal('show')
    $.post('<?=$base_url?>/billing_pemc/document_data',{id:$(this).attr('id')},
        function(data){
            console.log(data)
            var data = $.parseJSON(data);
                $('input[id=id]').val(data.id);
                $('select[id=docu_type]').val(data.document_type);
                $('input[id=filename]').val(data.resource_id);
                $('textarea[id=description1]').val(data.desc);
                $('#btn-holder').html('<button class="btn btn-primary" id="update"><i class="icon-check"></i>&nbsp;&nbsp;Update&nbsp;&nbsp;</button>')
            return false;
    })
})

$("#update").die('click').live('click',function(e){
    e.preventDefault()
        $('#modal').modal('hide')
        bootbox.confirm('Are you sure you want to update the information?', function (update){
            if (update){
                $('#modal').modal('show')
                $.update(); 
            }
        })
           
})

$('a.delete_button').die('click').live('click',function(e){
    e.preventDefault()
        $.delete_docu($(this).attr('id')); 
        bootbox.confirm('Are you sure you want to delete the selected item?', function (delete1){
            if (delete1){
                $.delete_docu($(this).attr('id')); 
            }
        })       
})

/*
$('#submit_file').unbind('click').bind('click',function(e){
    e.preventDefault();
    $('#grid_data').removeClass('alert');
    $('#grid_data').html('');

    if ($('#file').val() == ''){
        $('#msg-alert-submit').attr('class','alert alert-error');
        $('#msg-alert-submit').html('Please upload atleast 1 item')
        $.list();
    }else{
        $('.bar').show();
        $('.percent').show();
        $('.progress').show();

        var bar = $('.bar');
        var percent = $('.percent');
        var status = $('#status');

        $('form').ajaxSubmit({
            url: '../billing/upload_document',
            data: {type: $('#type').val(), description: $('#description').val()},
            beforeSend: function() {
                status.empty();
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal)
                percent.html(percentVal);
                //console.log(percentVal, position, total);
            },
            success: function() {
                var percentVal = '100%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            complete: function(xhr) {
                status.html(xhr.responseText);
                window.location = 'document_repository'
                $('#msg-alert-submit').html('Upload Complete')
            }
        });   
    }
   
});
*/

</script>