<div class="span3">
    <ul class="nav nav-tabs nav-stacked">
        <?php
        foreach ( $submenu as $sm ) {
            echo '<li><a href="'.$base_url.$sm['link'].'">'.$sm['title'].'</a></li>';
        }
        ?>
    </ul>    
</div>
<div class="span12">
    <legend><h4><?=$title?> <small>&nbsp;</small></h4></legend>
    <form method="post" enctype="multipart/form-data">
    <div class="fileupload fileupload-new span5" data-provides="fileupload">
        <div class="input-append">
            <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
            <span class="btn btn-file"><span class="fileupload-new">Select file</span>
                <span class="fileupload-exists">Change</span><input type="file" name="filebrowser" id="filebrowser" />
            </span>
            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
        </div>
        
    </div>
    <div class="span5">
        <input type="submit" value="Upload" class="btn btn-primary" id="submit_file" />&nbsp;&nbsp;<span id="msg-alert-submit"></span>
    </div>
    </form>
</div>

<script>
$('#submit_file').unbind('click').bind('click',function(e){
    e.preventDefault();
    var path = "../bcq/bcq_uploader_multiple_action";
    var options = {target:'#msg-alert-submit',
        url:path,
        beforeSubmit: function() { 
            $('#msg-alert-submit').html('Loading<img src="../images/ajax-loader.gif">')
        },
        success: function(msg) {
            msg = $.parseJSON(msg);
            $('#msg-alert-submit').html(msg.message)
            if (msg.message == 'Success'){
            	window.location.href = '../bcq/bcq_declaration?date='+msg.date;
            }
        }}; 
    $('form').ajaxSubmit(options);   
}); 

</script>