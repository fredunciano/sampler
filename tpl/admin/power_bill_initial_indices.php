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
    <form>
    <table class="table table-striped">
           <tr><td>CFo ( for old computation) :</td>
                <td><input type="text" name="cfo_old" id="cfo_old" value="<?=$initial_indices['cfo_old'];?>" class="input-medium numeric" /></td>
            </tr>
            
            <tr><td>CFo ( for new computation) :</td>
                <td><input type="text" name="cfo_new" id="cfo_new" value="<?=$initial_indices['cfo_new'];?>" class="input-medium numeric" /></td>
            </tr>
            
            <tr><td>FBPn / FBPo :</td>
                <td><input type="text" name="fuel_factor" id="fuel_factor" value="<?=$initial_indices['fuel_factor'];?>" class="input-medium numeric" /></td>
            </tr>
            
            <tr><td>US CPIo :</td>
                <td><input type="text" name="us_cpio" id="us_cpio" value="<?=$initial_indices['us_cpio'];?>" class="input-medium numeric" /></td>
            </tr>
            
            <tr><td>US PPIo :</td>
                <td><input type="text" name="us_ppio" id="us_ppio" value="<?=$initial_indices['us_ppio'];?>" class="input-medium numeric" /></td>
            </tr>
            
            <tr><td>PH CPIo :</td>
                <td><input type="text" name="ph_cpio" id="ph_cpio" value="<?=$initial_indices['ph_cpio'];?>" class="input-medium numeric" /></td>
            </tr>
            
            <tr><td>PH GWPIo :</td>
                <td><input type="text" name="ph_gwpio" id="ph_gwpio" value="<?=$initial_indices['ph_gwpio'];?>" class="input-medium numeric" /></td>
            </tr>
            
            <tr><td>FXo :</td>
                <td><input type="text" name="fxo" id="fxo" value="<?=$initial_indices['fxo'];?>" class="input-medium numeric" /></td>
            </tr>
            
            <tr><td>Effectivity Date :</td>
                <td><input type="text" name="effectivity_date" id="effectivity_date" value="<?=date('m/d/Y',strtotime($initial_indices['effectivity_date']));?>" class="input-medium numeric" /></td>
            </tr>
    </table>
        <button class="btn btn-primary" id="btn_submit" type="button">Save</button>&nbsp;<span id="alert-msg"></span>
    </form>
    <br><br><br><br><br>
</div>

<script>
$.extend({
    save : function(){
        $.post('<?=$base_url?>/admin/initial_indices_update',$('form').serialize(),
        function(data){
            window.parent.location.reload();
        })
    }
    
});
$('.numeric').autoNumeric('init',{
        mDec: '10'
      ,vMin : -9999999999      
    });
    
    
    $('#effectivity_date').datepicker();
$('#btn_submit').unbind().bind('click',function(){
    $.save();
});</script>