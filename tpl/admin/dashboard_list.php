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
        <div class="span2">Privilege</div>
        <div class="span10">
            <select id="privilege" name="privilege" class="input-medium">
            <?php
            foreach ($privileges as $p) {
                echo '<option>'.$p['privilege'].'</option>';
            }
            ?>
            </select>
        </div>
    </div>
    <br>
    <legend>Widgets</legend>
    <table class="table table-striped">
        <?php
        foreach ($widgets as $w) {
            if ($w->id !== 7 && $w->id !== 8) {
                echo '
                        <tr>
                            <td></td>
                            <td><label class=checkbox><input name="widgets[]" type=checkbox value='.$w->id.'>'.$w->title.'</label></td>
                            <td>'.$w->desc.'</td>
                        </tr>
                     ';
            }
        }
        ?>
    </table>
    <button class="btn btn-primary" id="save">Save Widgets</button>&nbsp;<span id="alert-msg"></span>
    </form>
    <br><br><br><br><br>
</div>

<script>
$.extend({
    updateWidgets : function(){
        $.post('<?=$base_url?>/admin/dashboard_update',$('form').serialize(),
            function(data){
                ret = data.split('|');
                $('#alert-msg').html(ret[1]);
            });
    },
    getWidgets : function(){
        $('input[type=checkbox]').removeAttr('checked');
        $.post('<?=$base_url?>/admin/dashboard_list_json',{privilege:$('#privilege').val()},
            function(data){
               var arr_widgets = data.split('|')
               $.each(arr_widgets, function(i,val){
                   $('input[value='+val+']').attr('checked','checked');
               })
            });
    }
})
</script>
<script>
$.getWidgets();    
$('#save').unbind('click').bind('click', function(e){
    e.preventDefault();
    $.updateWidgets();
})
$('#privilege').change(function(){
    $.getWidgets();
})
</script>