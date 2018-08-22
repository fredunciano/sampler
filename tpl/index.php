<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title><?=$title_header?></title>

    <link rel="icon" type="image/ico" href="/acacia_energy/images/favicon.ico"/>

    <link rel="stylesheet" href="<?=$base_url?>/css/bootstrap.css" />
    <link rel="stylesheet" href="<?=$base_url?>/css/bootstrap-switch.css" />
    <link rel="stylesheet" href="<?=$base_url?>/css/bootbox.css" />
    <link rel="stylesheet" href="<?=$base_url?>/css/jasny-bootstrap.min.css" />
    <link rel="stylesheet" href="<?=$base_url?>/css/font-awesome.css" />

    <link rel="stylesheet" href="<?=$base_url?>/css/datepicker.css" />
    <link rel="stylesheet" href="<?=$base_url?>/css/datatables.css">
    <link rel="stylesheet" href="<?=$base_url?>/css/styles.css" />


    <script src='<?=$base_url?>/js/jquery.js'></script>
    <!--script src="http://code.jquery.com/jquery-1.10.2.min.js"></script-->
    <script src='<?=$base_url?>/js/bootstrap.min.js'></script>
    <script src='<?=$base_url?>/js/jasny-bootstrap.min.js'></script>
    <script src='<?=$base_url?>/js/bootstrap-datepicker.js'></script>
    <script src='<?=$base_url?>/js/jquery.hotkeys.js'></script>
    <script src='<?=$base_url?>/js/bootstrap-wysiwyg.js'></script>

    <script src="<?=$base_url?>/js/jquery.download.js"></script>
    <script src="<?=$base_url?>/js/jquery.dataTables.js"></script>
    <script src="<?=$base_url?>/js/bootstrap-datatables.js"></script>
    <script src="<?=$base_url?>/js/highcharts.js"></script>
    <script src="<?=$base_url?>/js/date.js"></script>
    <script src="<?=$base_url?>/js/bootbox.min.js"></script>
    <script src="<?=$base_url?>/js/jquery.pad.js"></script>
    <script src="<?=$base_url?>/js/jquery.form.js"></script>
    <script src="<?=$base_url?>/js/common.js"></script>
    <script src="<?=$base_url?>/js/utilities.js"></script>
    <script src="<?=$base_url?>/js/jquery.autoNumeric.js"></script>
    <script src="<?=$base_url?>/js/jquery.numeric.js"></script>
    <script src="<?=$base_url?>/js/formatting.js"></script>
    <script src="<?=$base_url?>/js/modules/exporting.js"></script>

</head>

<body>
    <div style="height:100%">
        <header style="min-width:1250px">
            <div class="container-fluid" style="background-color:#000000;padding:5px;color:#FFF">
            <!--div class="container-fluid" style="background:#F9F9F9;padding:5px;color:#234432"-->
                &nbsp;&nbsp;&nbsp;
                <a href="<?=$base_url?>"><img src="<?=$base_url?>/images/acacia-web-logo-header.png" style="float:left;height:50px;margin-left: 20px;"></a>  
                <span style="font-size: 14px">SMART ENERGY SOFTWARE</span>
                &nbsp;&nbsp;&nbsp;<span class="navbar-text" style="color:#FFF">simple monitoring and reporting tool</span>
                <span class="navbar-text pull-right">Logged in as <b><?=base64_decode($_SESSION['username'])?></b>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id = "help" href="#" style="display:none" > <img src="<?=$base_url?>/images/help.png"></a>  </span>
                <span class="navbar-text pull-right"><input type = "hidden" id = "priv_index" value = "<?=base64_decode($_SESSION['privilege'])?>" /> </span>
                
                <p style="line-height:2px">&nbsp;</p>
                    <span class="pull-right" style="font-family: Courier;">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr><td style="padding:0px; margin: 0px; line-height:auto;"><span class="label label-info">WESM&nbsp;</span> <?=$_SESSION['WESM_IP']?></td></tr>
                            <tr><td style="padding:0px; margin: 0px;"><span class="label label-info">MMS&nbsp;&nbsp;</span> <?=$_SESSION['MMS_IP']?></td></tr>
                        </table>
                    </span>
                </div>
                <div class="navbar header">

                    <div class="navbar-inner">

                        <div class="container-fluid">
                            <!--a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a-->

                        <?php include $site_path.'/tpl/menu.php'?>

                    </div>
                </div>
            </div>
            <!--div class="container-fluid">
            <header class="jumbotron subhead" id="overview">
            <div class="row">
            <div style="padding:10px">
            <a href="<?=$base_url?>"><img src="<?=$base_url?>/images/acacia-web-logo.png"></a>
            <p class="navbar-text pull-right">Logged in as <b>Username</b></p>
        </div>
    </div>
    <div class="subnav subnav-fixed" style="background: #F1F1F1">
    <?//php include $site_path.'/tpl/menu.php'?>
</div>
</header>

</div-->
</header>

<div id="wrap" style="min-width:1250px">
    <div id="main" class="container-fluid clear-top">
        <?php
        if ( isset($page) ) {
            include $page;
        }
        ?>
    </div>
</div>

<footer class="footer">
    <div class="container" style="margin:0 auto;text-align:center;">
        <div class="row">
            ACACIASOFT ENERGY SOFTWARE &nbsp;
            <span class="small">Copyright &COPY; 2012  <a href="http://www.acacia-soft.com" target="_blank" style="color:#ffffff; text-decoration: underline;">AcaciaSoft Corporation</a>
                All Rights Reserved</span>
            </div>
        </div>
    </footer>
</div>

</body>

</html>

<script>
    BASE_URL = '<?=$base_url?>';

    var header = document.querySelector('.header');
    var origOffsetY = header.offsetTop;

    function onScroll(e) {
        window.scrollY >= origOffsetY ? header.classList.add('sticky') :
        header.classList.remove('sticky');
    }

    document.addEventListener('scroll', onScroll);

    $('a.dropdown-toggle, .dropdown-menu a').on('touchstart', function(e) {
        e.stopPropagation();
    });

$(document).ready(function (){
    var priv = $('#priv_index').val();
    if( priv == 'customer'){
        $('a#help').hide();
    }else{
        $('a#help').show()
    }
})

$('a#help').click(function(){
  window.open('<?=$base_url?>/help/index.php', '_blank');
  return false;
});

</script>
