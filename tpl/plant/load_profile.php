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
    <legend><h4><?=$title?> <small>&nbsp;</small></h4></legend>
    <form id="frm1" method='post' name='frm1' enctype="multipart/form-data" onsubmit='return false'>
    <div class="row-fluid">
        <div class="span2">Plant</div>
        <div class="span10">
            <select id="plant">
                <?php

                foreach($plants as $p){
                    echo '<option value='.$p->plant_name.'>'.$p->plant_name.'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Unit</div>
        <div class="span10">
            <select id="resource" class="input-medium">
                <?php
                foreach ($resources as $r) {
                    echo '<option value='.$r['resource_id'].'>'.$r['resource_id'].'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Delivery Date</div>
        <div class="span10 input-append">
            <input type="text" id="datepicker" class="input-small" value="<?=$date?>">
            <button id="retrive_files" type="button" class="btn btn-primary">Retrieve</button>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Submit Load Profile</div>
        <div class="span10">
            <div class="fileupload fileupload-new span6" data-provides="fileupload">
                <div class="input-append">
                    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
                    <span class="btn btn-file"><span class="fileupload-new">Select file</span>
                        <span class="fileupload-exists">Change</span><input type="file" name="filebrowser" id="filebrowser" />
                    </span>
                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                    <!--a href="#" class="btn fileupload-exists btn-primary" data-dismiss="fileupload" id="submit_file">Upload</a-->
                    <input type="submit" class="btn fileupload-exists btn-primary" id="submit_file" value="Upload" />
                </div>
                <span id="status"></span>
            </div>
        </div>
    </div>
    </form>
    <br><br>
    <legend><h5>Submitted Files</h5></legend>
    <div class="row-fluid">
        <div id="file_contents"></div>
    </div>
</div>

<script src="../js/jquery.form.js"></script>
<script type="text/javascript">

$.extend({
    loadUnitDropDown: function(){
        $.post('../plant/resource_dropdown',{plant:$('#plant').val()},
            function(data){
                html = '';
                $.each(data.value, function(i,val){
                    html+='<option value="'+val.resource_id+'">'+val.resource_id+'</option>';
                })
                $('#resource').html(html);
                return false;
            });
    },
    populateSubmittedFilesList : function(){
        $("#result_loader").html('Loading submitted files &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif" />');
        $('#file_contents').html('');
        var parameters = { 'action' : 'list-files', 'date' : $("#datepicker").val() , 'resource_id': $('#resource').val() };
        $.ajax({
            type: "POST"
            ,url : '../plant/load_profile_action'
            ,data: parameters
            ,dataType:'json'
            ,async: false
            ,success: function(data){
                //var list =  typeof returnData.value != 'undefined' ? returnData.value : [];
                if (!data.length) {
                    $('#file_contents').html('<div class="alert alert-error"><p class="text-error">No Records Found</p></div>');
                    return false;
                }
                var contents = '';
                var html = '';

                html+='<table class="table table-bordered">';
                html+='<tr><th>Delivery&nbsp;Date</th><th>Resource&nbsp;ID</th><th>Filename</th><th>Submitted&nbsp;By</th><th>Date&nbsp;Created</th></tr>';
                
                $.each(data, function(i,val){
                    html+='<tr><td>'+val.delivery_date+'</td><td>'+val.resource_id+'</td>'
                    html+='<td><a href="../plant/load_profile_action?action=download-file&transaction_id='+val.transaction_id+'">'+val.filename+'</a></td>'
                    html+='<td>'+val.submitted_by+'</td><td>'+val.date_created+'</td></tr>';
                })

                html+='</table>';

                contents+= '';

                $("#result_loader").html('');
                $('#file_contents').html(html);
            }
            ,error: function(jqXHR, textStatus, errorThrown){
                alert("Error on accessing webservice data " + jqXHR.responseText );
                $("#result_loader").html('With errors');
            }
        });

    }
});       
</script>
<script>
    $.populateSubmittedFilesList();
    $('#retrive_files').unbind().bind('click',function(){
         $.populateSubmittedFilesList();
    })
    
    $('#plant').change(function(){
        $.loadUnitDropDown();
    })
    
    $('#frm1').submit(function(e){
    e.preventDefault();
    if($('#filebrowser').val() == "") return false;
    var url = 'http://' + location.host + '<?=$base_url?>' + '/plant/load_profile_action';

    var options = {
        target:'',
        url:url,
        data:{'action': 'submit',date:$("#datepicker").val() , 'resource_id': $('#resource').val() },
        beforeSubmit:	function() {
            $('#status').html('Loading...');
        },
        success:	function(data) {
            $('#status').html(data)
        }
    };

    $("#frm1").ajaxSubmit(options);
});
</script>
