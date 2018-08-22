<style>
.align-right{
    text-align:right;
}
</style>

<div class="span3">
    <ul class="nav nav-tabs nav-stacked">
        <?php
        foreach ( $submenu as $sm ) {
            echo '<li><a href="'.$base_url.$sm['link'].'">'.$sm['title'].'</a></li>';
        }
        ?>
    </ul>
</div>
<div class="span6">
    <legend><h4><?=$title?> <small>&nbsp;</small></h4></legend>
    <div class="row-fluid align-right">
    Daily MQ Gen Template &nbsp;&nbsp;<button class="btn btn-success" id="mq_gen_button" type="gen">Download Daily MQ Gen Template &nbsp;&nbsp;<i class="icon-arrow-down"></i></button>
    </div>
    <hr>
    <!--div class="row-fluid align-right">
    Daily MQ Load Template &nbsp;&nbsp;<button class="btn btn-success" id="mq_load_button" type="load">Download Daily MQ Load Template &nbsp;<i class="icon-arrow-down"></i></button>
</div-->
</div>

<script>

$('.btn').unbind('click').bind('click', function(e){
    e.preventDefault();

    var type = $(this).attr('type')
    var parameters = 'type='+type;

    var url = 'http://' + location.host + '<?=$base_url?>' + '/trading/download_mq_templates'
    $.download(url,parameters);
})


</script>
