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
    <div class="row-fluid">
        <h5>Plant Capability</h5><br>
        <table class="table table-striped">
            <tr>
                <td>Day Ahead Projected Plant Capability</td>
                <td>
                    <sup>D +</sup>
                    <select class="span1" id="dap_d">
                        <?php
                        for ($d=0;$d<=5;$d++) {
                            if ($dap_day == $d) {
                                echo '<option selected>'.$d.'</option>';
                            } else {
                                echo '<option>'.$d.'</option>';
                            }
                        }
                        ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;
                    <sup>Time : </sup>
                    <select class="input-mini" id="dap_h">
                        <?php
                        for ($h=1;$h<=12;$h++) {
                            if (date('h',strtotime($dap_time)) == $h) {
                                echo '<option selected>'.str_pad($h,2,'0',STR_PAD_LEFT).'</option>';
                            } else {
                                echo '<option>'.str_pad($h,2,'0',STR_PAD_LEFT).'</option>';
                            }
                        }
                        ?>
                    </select>
                    <sup>:</sup> 
                    <select class="input-mini" id="dap_m">
                        <?php
                        for ($m=0;$m<=59;$m++) {
                            if (date('i',strtotime($dap_time)) == $m) {
                                echo '<option selected>'.str_pad($m,2,'0',STR_PAD_LEFT).'</option>';
                            } else {
                                echo '<option>'.str_pad($m,2,'0',STR_PAD_LEFT).'</option>';
                            }
                            
                        }
                        ?>
                    </select>
                    <?php
                        if (date('A',strtotime($dap_time))=='AM') {
                            $am_selected = 'selected';
                        } else {
                            $pm_selected = 'selected';
                        }
                    ?>
                    <select class="input-mini" id="dap_dt">
                        <option <?=$am_selected?>>AM</option>
                        <option <?=$pm_selected?>>PM</option>
                    </select>
                </td>
                <td>
                    <sup><button class="btn btn-primary" id="update_dap">Update</button>&nbsp;<span id="dap_msg"></span></sup>
                </td>
            </tr>
            <tr>
                <td>Week Ahead Projected Plant Capability</td>
                <td>
                    <sup>Day : </sup>
                    <select class="input-mini" id="wap_d">
                        <?php
                        foreach($day_of_week_arr as $d=>$day) {
                            if ($d == $wap_day) {
                                echo '<option value="'.$d.'" selected>'.$day.'</option>';
                            } else {
                                echo '<option value="'.$d.'">'.$day.'</option>';
                            }
                        }
                        ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;
                    <sup>Time : </sup>
                    <select class="input-mini" id="wap_h">
                        <?php
                        for ($h=1;$h<=12;$h++) {
                            if (date('h',strtotime($wap_time)) == $h) {
                                echo '<option selected>'.str_pad($h,2,'0',STR_PAD_LEFT).'</option>';
                            } else {
                                echo '<option>'.str_pad($h,2,'0',STR_PAD_LEFT).'</option>';
                            }
                        }
                        ?>
                    </select>
                    <sup>:</sup> 
                    <select class="input-mini" id="wap_m">
                        <?php
                        for ($m=0;$m<=59;$m++) {
                            if (date('i',strtotime($wap_time)) == $m) {
                                echo '<option selected>'.str_pad($m,2,'0',STR_PAD_LEFT).'</option>';
                            } else {
                                echo '<option>'.str_pad($m,2,'0',STR_PAD_LEFT).'</option>';
                            }
                            
                        }
                        ?>
                    </select>
                    <?php
                        if (date('A',strtotime($wap_time))=='AM') {
                            $am_selected = 'selected';
                        } else {
                            $pm_selected = 'selected';
                        }
                    ?>
                    <select class="input-mini" id="wap_dt">
                        <option <?=$am_selected?>>AM</option>
                        <option <?=$pm_selected?>>PM</option>
                    </select>
                </td>
                <td>
                    <sup><button class="btn btn-primary" id="update_wap">Update</button>&nbsp;<span id="dap_msg"></span></sup>
                </td>
            </tr>
        </table>
        <br>
        <!--h5>Buyer Nomination</h5><br>
        <table>
            <tr>
                <td></td>
            </tr>
        </table-->
    </div>
</div>

<script>
$.extend({
    saveDAP : function(){
        $.post('<?=$base_url?>/admin/gate_closure_action',{type:'DAP',dap_d:$('#dap_d').val(),dap_h:$('#dap_h').val(),dap_m:$('#dap_m').val(),dap_dt:$('#dap_dt').val()},
        function(data){
            bootbox.alert('<h5>'+data+'</h5>');
        })
    },
    saveWAP : function(){
        $.post('<?=$base_url?>/admin/gate_closure_action',{type:'WAP',wap_d:$('#wap_d').val(),wap_h:$('#wap_h').val(),wap_m:$('#wap_m').val(),wap_dt:$('#wap_dt').val()},
        function(data){
            bootbox.alert('<h5>'+data+'</h5>');
        })
    }
})
</script>
<script>
$('#update_dap').unbind('click').bind('click', function(e){
    e.preventDefault();
    $.saveDAP();
})
$('#update_wap').unbind('click').bind('click', function(e){
    e.preventDefault();
    $.saveWAP();
})

</script>