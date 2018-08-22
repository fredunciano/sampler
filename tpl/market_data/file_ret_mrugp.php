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
            <div class="span2">Year</div>
            <div class="span10">
                <select id="year" class="input-small">
                    <?php
                    for ($x=date('Y');$x>=2012;$x--) {
                        echo '<option>'.$x.'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2"></div>
            <div class="span10">
                <a class="btn btn-primary" href="#"><i class="icon-file icon-white"></i>&nbsp;Show Files</a>
            </div>
        </div>
        <hr>
        <div id="result"></div>
    </section>
</div>

<script src="../js/jquery.download.js"></script>
<script>
    $.extend({
        generateFile : function(filename){
            $.download('../market_data/generate_file','file='+filename+'&dir=must_run_unit_generation_price&type=xls');
        }
    })
</script>
<script>
$('.btn').unbind('click').bind('click',function(e){
    e.preventDefault();
    $("#result").attr('class','alert alert-info');
    $("#result").html('Retrieving Data &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
    $.post('../market_data/file_ret_mrugp_action',{year:$('#year').val()},
        function(data){
            if (data.total < 1) {
                $("#result").html('<span style="padding:10px">No Data to Display</span>');
            } else {
                $("#result").removeClass('alert alert-info');
                html = '<table class="table table-striped table-condensed">';
                html+= '<tr><th>Date Published</th><th>Filename</th><th>Size</th><th>Date Created</th><th></th></tr>';
                $.each(data.value, function(i,val){
                    html+='<tr><td>'+val.date_published+'</td>'+
                          '<td>'+val.filename+'</td><td>'+val.size+'</td><td>'+val.date_created+'</td><td><button class="btn btn-primary" id="'+val.filename+'"><i class="icon-arrow-down"></i>&nbsp;Download</button></td></tr>';
                })
                html+= '</table>';
                $('#result').html(html);
            }
        });
});
$('button.btn').die('click').live('click', function(e){
    e.preventDefault();
    //var filename = $(this).attr('id').toLowerCase().trim()+'.xls'
   // $.generateFile(filename)
       $.generateFile($(this).attr('id'))
})
</script>