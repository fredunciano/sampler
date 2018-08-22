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
           
            
        <tr><td class="span3">Billing Reviewer :</td>
                    <td><select id="reviewed_by" name="reviewed_by">
                        <?php
                                foreach ($users_list as $user) {
                                    $name = $user['first_name']. ' ' . $user['last_name'];
                                    $name = trim($name) ;
                                    if ( strlen($name) <= 1) {
                                        $name = $user['user'];
                                    }
                                    if ( intval($power_bill_settings['reviewed_by']) === intval($user['id'])) {
                                        echo '<option value="'.$user['id'].'" selected=true>'.$name.'</option>';
                                    }else {
                                        echo '<option value="'.$user['id'].'">'.$name.'</option>';
                                    }    
                                }
                        ?>
                    </select>
            </tr>
            
            <tr><td>Billing Noted By :</td>
                    <td><select id="noted_by" name="noted_by">
                        <?php
                                foreach ($users_list as $user) {
                                    $name = $user['first_name']. ' ' . $user['last_name'];
                                    $name = trim($name) ;
                                    if ( strlen($name) <= 1) {
                                        $name = $user['user'];
                                    }
                                    if ( intval($power_bill_settings['noted_by']) === intval($user['id'])) {
                                        echo '<option value="'.$user['id'].'" selected=true>'.$name.'</option>';
                                    }else {
                                        echo '<option value="'.$user['id'].'">'.$name.'</option>';
                                    }    
                                }
                        ?>
                    </select>
            </tr>
            
            <tr><td>Billing Approved By :</td>
                    <td><select id="approved_by" name="approved_by">
                        <?php
                                foreach ($users_list as $user) {
                                    $name = $user['first_name']. ' ' . $user['last_name'];
                                    $name = trim($name) ;
                                    if ( strlen($name) <= 1) {
                                        $name = $user['user'];
                                    }
                                    if ( intval($power_bill_settings['approved_by']) === intval($user['id'])) {
                                        echo '<option value="'.$user['id'].'" selected=true>'.$name.'</option>';
                                    }else {
                                        echo '<option value="'.$user['id'].'">'.$name.'</option>';
                                    }    
                                }
                        ?>
                    </select>
            </tr>
            <!---
             <tr><td>Note #1 :</td>
                 <td>
                     <textarea style="width:98%;height:40px;"  id="note1" name="note1"><?=$power_bill_settings['note1'];?></textarea>
                 </td>
            </tr>
            --->
            
            <tr><td>Notes :</td>
                 <td>
                     <textarea name="notes" id="notes" style="width:100%; height: 300px;"><?=$power_bill_settings['notes'];?></textarea>
                     <input id="hid_notes" name="hid_notes" value="" type="hidden" />
                 </td>
            </tr>
            
            <!---
            <tr><td>Note #2 :</td>
                 <td>
                     <textarea style="width:98%;height:40px;" id="note2" name="note2">Commercial Power Rate for {billing_period_full} Billing is  <b>Php {commercial_power_rate}/kWh.</textarea>
                 </td>
            </tr>--->
    </table>
        <button class="btn btn-primary" id="btn_submit" type="button">Save</button>&nbsp;<span id="alert-msg"></span>
    </form>
    <br><br><br><br><br>
</div>

<script type="text/javascript" src="<?=$base_url?>/js/tinymce/tinymce.min.js"></script>

<script>
$.extend({
    save : function(){
        $('#hid_notes').val( tinyMCE.get('notes').getContent() );
        $.post('<?=$base_url?>/admin/billing_settings_update',$('form').serialize(),
        function(data){
            window.parent.location.reload();
        })
    }
    
}); 

$('#btn_submit').unbind().bind('click',function(){
    $.save();
});

$(document).ready( function() {
    tinymce.init({
        selector: "textarea",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    });               
});

</script>