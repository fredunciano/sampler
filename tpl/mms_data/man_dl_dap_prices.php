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
        <legend><h4><?=$title?> <small>( Manual Downloader )</small></h4></legend>
        <div class="row-fluid">
            <div class="span2">Date</div>
            <div class="span10 input-append">
                <input type="text" name="date" id="datepicker" value="<?=$date?>" class="input-small">
                <a class="btn btn-primary" href="#"><i class="icon-arrow-down icon-white"></i>&nbsp;Download</a>
            </div>
        </div>
        <hr>
        <div id="result"></div>
    </section>
</div>

<script>
$('.btn').unbind('click').bind('click',function(e){
    $("#result").attr('class','alert alert-info');
    $("#result").html('Please wait while data is being downloaded &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
    $.post('../mms_data/man_dl_dap_prices_action',{date:$('#datepicker').val()},
        function(data){
            $("#result").html(data);
            return false;
        });
});
</script>