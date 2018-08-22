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
    <section id="global">
        <legend><h4><?=$title?> <small>( File Retriever )</small></h4></legend>
        <div class="row-fluid">
            <div class="span2">Date</div>
            <div class="span10 input-append input-prepend">
                <input id="date" name="date" value="<?=$date?>" type="text" class="input-small">
                <a class="btn btn-primary" href="#"><i class="icon-file icon-white"></i>&nbsp;Show Files</a>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2"></div>
            <div class="span10">
                
            </div>
        </div>
        <hr>
        <div id="result"></div>
    </section>
    <br><br><br>
</div>

<script src="../js/jquery.download.js"></script>
<script>
    $.extend({
        generateFile : function(filename){
            $.download('../market_data/contingency_generate_file','file='+filename+'&dir=contingency_list&type=csv');
        }
    })
</script>
<script>
$('#date').datepicker()
$('.btn').unbind('click').bind('click',function(e){
    e.preventDefault()
    $("#result").attr('class','alert alert-info');
    $("#result").html('Please wait while data is being downloaded &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
    $.post('../market_data/file_ret_cl_action',{date:$('#date').val()},
        function(data){

            if (data.total < 1) {
                $("#result").html(data.message);
            } else {
                $("#result").removeClass('alert alert-info');
                html = '<table class="table table-striped table-condensed">';
                html+= '<tr><th>Date</th><th>Filename</th><th></th></tr>';
                $.each(data.value, function(i,val){
                    html+='<tr><td>'+val.date+
                          '<td>'+val.filename+'</td><td><button class="btn btn-primary" id="'+val.filename+
                          '"><i class="icon-arrow-down"></i>&nbsp;Download</button></td></tr>';
                })
                html+= '</table>';
                $('#result').html(html);
            }
        });
});
$('button.btn').die('click').live('click', function(e){
    e.preventDefault();
    $.generateFile($(this).attr('id'))
})
</script>