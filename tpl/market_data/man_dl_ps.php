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
            <div class="span2">Report Type</div>
            <div class="span10">
                <select id="report_type">
                    <option value="RTD">Real Time Ex-Ante (RTD)</option>
                    <option value="RTX">Real Time Ex-Post (RTX)</option>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Date</div>
            <div class="span10 input-append input-prepend">
                <input type="text"  readonly="true" style="background-color:#ffffff;" id="sdate" name="sdate" value="<?=$sdate?>" class="input-small"><span class="add-on">to</span> 
                <input type="text"  readonly="true" style="background-color:#ffffff;" id="edate" name="edate" value="<?=$edate?>" class="input-small">
                <a class="btn btn-primary" href="#">Download</a>
            </div>
        </div>
        <hr>
        <div id="result"></div>
    </section>
</div>

<script>
$('#sdate, #edate').datepicker();
$('.btn').unbind('click').bind('click',function(e){
    e.preventDefault()
    $("#result").attr('class','alert alert-info');
    $("#result").html('Please wait while data is being downloaded &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
    $.post('../market_data/man_dl_ps_action',{sdate:$('#sdate').val(),edate:$('#edate').val(),
            report_type:$('#report_type').val()},
            function(data){
                    $("#result").html(data);
                    return false;
            });
});
</script>
