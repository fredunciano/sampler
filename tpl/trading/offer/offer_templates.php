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
        <legend><h4><?=$title?> <small>( Bids and Offers )</small></h4></legend>
    </section>
    <table class="table table-striped">
        <tr><td class="span3">Offer_Template</td><td><button class="btn btn-primary" id="btn_offer_template">Download&nbsp;<i class="icon icon-arrow-down"></i></button></td></tr>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#btn_offer_template').unbind('click').bind('click',function(){
            var url = 'http://' + location.host + '<?=$base_url?>' + '/trading/file_offer_templates'
            $.download(url,'x=1');
        });
    });
</script>