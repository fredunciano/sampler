
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
        <!--div class="row-fluid">
            <div class="span2">Region</div>
            <div class="span10">
                <select id="region" class="input-medium">
                    <option value="SYSTEM">System</option>
                    <?php
                    foreach ( $regions as $r ) {
                        echo '<option value="'.$r->region.'">'.ucwords(strtolower($r->region)).'</option>';
                    }
                    ?>
                </select>
            </div>
        </div-->
        <div class="row-fluid">
            <div class="span2">Date</div>
            <div class="span10 input-append">
                <input type="text" id="datepicker"  readonly="true" style="background-color:#ffffff;" name="date" value="<?=$sdate?>" data-date-autoclose class="input-small">
                <a class="btn btn-primary" href="#">Download</a>
            </div>
        </div>
        <hr>
        <div id="result"></div>
    </section>
</div>

<script>
$('#datepicker').datepicker();
$('.btn').unbind('click').bind('click',function(e){
    e.preventDefault()
    $("#result").attr('class','alert alert-info');
    $("#result").html('Please wait while data is being downloaded &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
    $.post('../market_data/man_dl_dem_lwap_action',{date:$('#datepicker').val()},
        function(data){
            
            $("#result").html(data);
            return false;
        });
});
</script>