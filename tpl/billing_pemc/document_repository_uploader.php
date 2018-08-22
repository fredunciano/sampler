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
    <div class="row-fluid">
        <div class="span2">Document Type:</div>
            <div class="span7">
                <select id="type" name="type" class="input-medium">
                <?php
                foreach ( $documents as $d ) {
                    echo '<option value="'.$d->document_type.'">'.$d->document_type.'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    

    <div class="row-fluid">
        <div class="span2">Description</div>
      		<div class="span7">
                <input type="text" name = "description" id="description" class = "input-large" style = "width:765px;" placeholder="Description here...">
        	</div>
	</div>

	<h5> Upload Document<small></small></h5>

    <form enctype="multipart/form-data" method="post">
        <input type="hidden" id="tbl_name" value="<?=$title?>" />
    <div class="fileupload fileupload-new span" data-provides="fileupload"> 
        <div class = "row-fluid">
            <div class="input-append">
                <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i><span id = "preview_files"></span></div>
                <span class="btn btn-file"><span class="fileupload-new">Select file</span>
                    <span class="fileupload-exists">Change</span><input type="file" name="file[]" id="file" multiple="multiple"/>
                </span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>  
            </div>
            <div>
                <span id = "containerdocs"></span>    
            </div>  
        </div>
    </div>
    <div class="span7">
        <input type="submit" value="Upload" class="btn btn-primary" id="submit_file" />&nbsp;&nbsp;
     </div> 
     
     <div class="span12">
        <div class="progress" style="display:none;">
            <div class="bar" style="display:none;"></div >
            <div class="percent" style="display:none;">0%</div >
        </div>
     </div>

     <br>

     <div class="span12">
        <span id="msg-alert-submit"></span>
     </div>
    
    </form>
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
                <input type="hidden" id="id" name="id">
                <div class="row-fluid">
                    <div class="span3">Document Type:</div>
                        <div class="span3">
                            <select id="type1" name ="type1" class="input-medium">
                                <option>PEMC Bills</option>
                                <option>NGCP Bills</option>
                            </select>
                        </div>
                </div>

                <div class="row-fluid">
                    <div class="span3">Description</div>
                        <div class="span3">
                         <input type="text" class = "input-large" id="description1" name="description1" />
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

$("#file").change(function() {
    var files = $('#file')[0].files;
    var html = ''
    for (var i = 0; i < files.length; i++) {
        html+= i+1+')'+files[i].name+'<br>'
        
    }
    $("#containerdocs").html(html);
    if (files.length == 0){
        var filelength = ""
    }else{
        var filelength = files.length+" files"
    }
    $("#preview_files").html(filelength)
});

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
            url: '<?=$base_url?>/billing_pemc/upload_document',
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
                $('#msg-alert-submit').html(xhr.responseText);
                setTimeout(function(){ window.location = 'document_repository_uploader' }, 3000);
            }
        });   
    }
   
});

</script>