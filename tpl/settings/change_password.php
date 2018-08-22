<div class="span3">
    <ul class="nav nav-tabs nav-stacked" >
        <?php
        foreach ( $submenu as $sm ) {
            echo '<li><a href="'.$base_url.$sm['link'].'">'.$sm['title'].'</a></li>';
        }
        ?>
    </ul>    
</div>
<div class="span12">
    <legend><h4><?=$title?><small>&nbsp;</small></h4></legend>
    <form method="post">
    <div class="row-fluid">
        <div class="span2">Enter old password</div>
        <div class="span10 control-group" id="msg1">
            <input type="password" name="old_password">
            <span></span>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Enter new password</div>
        <div class="span10 control-group" id="msg2">
            <input type="password" name="new_password1">
            <span></span>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Confirm new password</div>
        <div class="span10 control-group" id="msg3">
            <input type="password" name="new_password2">
            <span></span>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">&nbsp;</div>
        <div class="span10">
            <button class="btn btn-primary">Change Password</button>
        </div>
    </div>
    <br>
    <div class="row-fluid" id="success"></div>        
    </form>
</div>
<script>
    $('button').unbind('click').bind('click', function(e){
        e.preventDefault();
        $.post('<?=$base_url?>/settings/change_password_action',$('form').serialize(),
        function(data){
            $('#msg1,#msg2,#msg3').find('span').html('')
            $('#msg1,#msg2,#msg3').removeClass('error')
            var arr = data.split('|')
            if (arr[0] == 0) {
                if (arr[1]) {
                    $('#msg1').addClass('error')
                    $('#msg1').find('span').html(arr[1])
                    $('#msg1').find('span').addClass('text-error')
                }
                if (arr[2]) {
                    $('#msg2').addClass('error')
                    $('#msg2').find('span').html(arr[2])
                    $('#msg2').find('span').addClass('text-error')
                    $('#msg3').addClass('error')
                    $('#msg3').find('span').html(arr[2])
                    $('#msg3').find('span').addClass('text-error')
                }
            } else if (arr[0] == 1){
                $('#success').addClass('alert alert-success')
                $('#success').html(arr[1])
            } else if (arr[0] == 2){
                $('#success').addClass('alert alert-error')
                $('#success').html(arr[1])
            }
        })
    })
</script>    