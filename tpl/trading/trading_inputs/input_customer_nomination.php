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
    <form id="frm1" type="post" enctype="multipart/form-data">
    <div class="row-fluid">
        <div class="span2">File</div>
        <div class="span10">
            <div class="fileupload fileupload-new span6" data-provides="fileupload">
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
    <div class="row-fluid">
        <div class="span2">Description</div>
        <div class="span10">
            <input type="text" id="description" name="description" class="input-xlarge">
        </div>
    </div>
    <br>
    <div class="row-fluid">
        <div class="span2"></div>
        <div class="span10">
            <button type="submit" class="btn-primary btn" id="upload_file"><span class="icon-arrow-up"></span>&nbsp;&nbsp;Upload</button>
        </div>
    </div>
    </form>
    <hr>
    <span id="loader"></span>   

    <div id="resultbox"></div>
</div>

<script type="text/javascript">
       $('#frm1').submit(function(e){
             e.preventDefault();
            var path = "<?=$base_url?>/trading/customer_nomination_parser";
            var options = {target:'#resultbox',
                url:path,
                beforeSubmit: function() { 
                    $('#loader').html('Uploading File <img src="../images/ajax-loader.gif">');
                    $('#resultbox').html('').removeClass();
                },
                success: function(msg) {
                    msg = $.parseJSON(msg)
                    $('#resultbox').html(msg['message']).addClass('alert alert-info')
                    $('#loader').html('');
                }}; 
            $('#frm1').ajaxSubmit(options);  
        })
</script>
