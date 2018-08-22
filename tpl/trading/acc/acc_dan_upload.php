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
    <legend><h1><?=$title?> <small>( Trading )</small></h1></legend>
    <form enctype="multipart/form-data" method="post">
    <div class="fileupload fileupload-new span5" data-provides="fileupload">
        <div class="input-append">
            <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
            <span class="btn btn-file"><span class="fileupload-new">Select file</span>
                <span class="fileupload-exists">Change</span><input type="file" name="filebrowser" id="filebrowser" />
            </span>
            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
        </div>
        
    </div>
    <div class="span3">
        <input type="submit" value="Upload" class="btn btn-primary" id="submit_file" />&nbsp;&nbsp;<span id="msg-alert-submit"></span>
    </div>
    </form>
</div>

<script>
$('#submit_file').unbind('click').bind('click',function(e){
    e.preventDefault();
    var path    = '../trading_acc/acc_dan_upload_action';
    var options = {target: '#msg-alert-submit',
        url: path,
        beforeSubmit: function(){
            $('#msg-alert-submit').html('Loading<img src="../images/ajax-loader.gif">')
        },    
        success: function(data){
            data = $.parseJSON(data);
            //console.log(data)
            $('#msg-alert-submit').html(data.message)
        }
    };
    $('form').ajaxSubmit(options);
})
</script>