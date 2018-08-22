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
            <div class="span2"></div>
            <div class="span10">Week: 
                <select id="week" class="input-small">
                    <?php
                    for ($x=1;$x<=53;$x++) {
                        echo '<option>'.$x.'</option>';
                    }
                    ?>
                </select>
                Year: 
                <select id="year" class="input-small">
                    <?php
                    for ($x=date('Y');$x>=(date('Y')-4);$x--) {
                        echo '<option>'.$x.'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2"></div>
            <div class="span10">
                <a class="btn btn-primary" href="#">Download</a>
            </div>
        </div>
        <hr>
        <div id="result"></div>
    </section>
</div>

<script>
$('.btn').unbind('click').bind('click',function(e){
    e.preventDefault()
    $("#result").attr('class','alert alert-info');
    $("#result").html('Please wait while data is being downloaded &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
    $.post('../market_data/man_dl_wsr_action',{year:$('#year').val(),week:$('#week').val()},
        function(data){
            $("#result").html(data);
            return false;
        });
});
</script>
