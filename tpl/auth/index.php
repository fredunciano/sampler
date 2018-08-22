<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="description" content="Acacia Energy">

        <title><?=$title?></title>

        <link rel="icon" type="image/ico" href="/acacia_energy/images/favicon.ico"/>

        <link rel="apple-touch-icon" href="/acacia_energy/images/ios-icon-energy.png" />
		<link rel="apple-touch-startup-image" href="/acacia_energy/images/ios-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)" />

        <link rel="stylesheet" href="<?=$base_url?>/css/bootstrap.css" />
        <link rel="stylesheet" href="<?=$base_url?>/css/jasny-bootstrap.min.css" />
        <link rel="stylesheet" href="<?=$base_url?>/css/font-awesome.css" />
        <link rel="stylesheet" href="<?=$base_url?>/css/styles.css" />
        <script src='<?=$base_url?>/js/jquery.js'></script>
        <script src='<?=$base_url?>/js/bootstrap.min.js'></script>
    </head>
    <style>
        .login-box{
            width:285px;
            margin-top:100px;
            background: #FFF;
            border:1px solid #DDD;
            border-radius: 7px;
            padding:15px;
        }
    </style>
    <body style="background:#F1F1F1">
        <div class="container login-box">
            <form class="form-horizontal" method="post">
                <div>
                    <div style="text-align: center;">
                    <img src="<?=$base_url?>/images/acacia-web-logo.png">
                    </div>
                    <br>
                    <h4>Log in </h4>
                    <a href="http://www.acacia-soft.com/" target="_blank">http://www.acacia-soft.com/</a>&nbsp;<i class="icon-info-sign"></i>
                    <hr>
                    <div id="result"></div>
                    <h5>Username</h5>
                    <input type="text" id="username" class="input-xlarge" placeholder="username">
                    <h5>Password</h5>
                    <input type="password" id="password" class="input-xlarge" placeholder="password">
                    <br><br>
                    <button type="submit" class="btn btn-primary" id="login_button">Log in</button>
                    <br>
                    <label class="checkbox"><input type="checkbox" id="save">&nbsp;&nbsp;<b>keep me logged in</b></label>

                </div>
                <div>
                    To request an account, please contact your System Administrator.
                </div>


            </form>
        </div>
    </body>


<script type="text/javascript">
$('#login_button').unbind('click').bind('click',function(e){
    e.preventDefault();
    $('#result').attr('class','alert alert-success');
    $('#result').html('Logging in...');
    $.post('<?=$base_url?>/auth/login',{'user':$('#username').val(),'pass':$('#password').val(),'save':$('#save').attr('checked')},
        function(data){
            //console.log(data)
            var arr = data.split('|');
            var allow = arr[0];
            var msg = arr[1];

            if (arr[0] == 1) {
                $('#result').attr('class','alert alert-success');
                $('#result').html('<i class="icon-ok-sign"></i>&nbsp;&nbsp;'+msg);
                setTimeout("window.location = '<?=$base_url?>/dashboard'",1000);
            } else {
                $('#result').attr('class','alert alert-error');
                $('#result').html('<i class="icon-exclamation-sign"></i>&nbsp;&nbsp;'+msg);
            }

            return false;
    });
})
</script>
