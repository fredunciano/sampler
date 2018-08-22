<style>
    .table th, .table td {
  
    vertical-align: middle;
}
</style>
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
    
    <section id="global" >
        
       
            <legend><h4><?=$title?><small>&nbsp;</small></h4></legend>
            <div class="row-fluid">
                <div class="span1">Year </div>
                    <div class="span7">
                        <select name="year" class="input-medium" id="year">
                            <?php
                                $current_year = intval(date('Y'));
                                $s_year = $current_year - 5;
                                $e_year = $current_year + 5;
                                for($yr=$s_year;$yr<=$e_year;$yr++){
                                    $selected = $yr=== $current_year ? ' selected="true" ': '';
                                    echo '<option value="'.$yr.'" '.$selected.'>'.$yr.'</option>';
                                }
                            ?>
                        </select>
                        &nbsp;&nbsp;&nbsp;
                        Quarter&nbsp;&nbsp;&nbsp;
                        <select name="quarter" class="input-medium" id="quarter">
                            <?php
                                $n = date('n');
                                if($n < 4){
                                  $current_quarter = 1;
                                } elseif($n > 3 && $n <7){
                                  $current_quarter = 2;
                                } elseif($n >6 && $n < 10){
                                  $current_quarter = 3;
                                } elseif($n >9){
                                   $current_quarter = 4;
                                }
                                $quarters = array('1st','2nd','3rd','4th');
                                $quarter_indx = 1;
                                foreach ($quarters as $quarter) {
                                   $selected = $quarter_indx=== $current_quarter ? ' selected="true" ': '';
                                   echo '<option value="'.$quarter_indx.'" '.$selected.'>'.$quarter.'</option>';
                                   $quarter_indx++;
                                }
                            ?>
                        </select>
                    </div>
            </div>
            <br>
            <div id="loader"></div>
            <table class="table table-striped table-condensed">
                <tr>
                    <td colspan="5" style="font-weight: bold; font-size:13px;"><center>Coal</center></td>
                </tr>
                <tr>
                    <td>Coal Base Price</td>
                    <td><input type="text" name="coal_base_price" id="coal_base_price" class="input-medium numeric" value=""> USD/MT</td>
                    <td>&nbsp;</td>
                    <td>Coal Base Index</td>
                    <td><input type="text" name="coal_base_index" id="coal_base_index" class="input-medium numeric" value=""> USD/MT</td>
                </tr>
                <tr>
                    <td colspan="5" style="font-weight: bold; font-size:13px;"><center>Transpo</center></td>
                </tr>
                <tr>
                    <td>Transpo Base Price</td>
                    <td ><input type="text" name="transpo_base_price" id="transpo_base_price" class="input-medium numeric" value=""> USD/MT</td>
                    <td>&nbsp;</td>
                    <td>Transpo Base Index</td>
                    <td><input type="text" name="transpo_base_index" id="transpo_base_index" class="input-medium numeric" value=""> USD/MT</td>
                </tr>
            </table>
            <div class="row-fluid">
                <div class="span7"><button type="button" id="btn_save" class="btn btn-primary"><i class="icon-file"></i>&nbsp;Update</button>&nbsp</div>
            </div>
            <br>
            <div id="result"></div>
    </section>
    
    
</div>

<script type="text/javascript">
    $.extend({
       getData : function(){
           var parameters = {};
           parameters['year'] = $('#year').val();
           parameters['quarter'] = $('#quarter').val();
            $('#loader').html('Please wait <img src="../images/ajax-loader.gif" />').removeAttr('class');
            $.post('<?=$base_url?>/power_bill/input_base_prices_get',parameters,
            function(ret){
                var data = ret.value;
                $('#coal_base_price').val($.formatNumberToSpecificDecimalPlaces(data.coal_base_price,5));
                $('#coal_base_index').val($.formatNumberToSpecificDecimalPlaces(data.coal_base_index,5));
                $('#transpo_base_price').val($.formatNumberToSpecificDecimalPlaces(data.transpo_base_price,5));
                $('#transpo_base_index').val($.formatNumberToSpecificDecimalPlaces(data.transpo_base_index,5));
            });    
            $('#loader').html('').removeAttr('class');
       } //
       ,saveData : function(){
           var parameters = {};
           parameters['year'] = $('#year').val();
           parameters['quarter'] = $('#quarter').val();
           
           var coal_base_price = $.trim($('#coal_base_price').val());
           var coal_base_index = $.trim($('#coal_base_index').val());
           var transpo_base_price = $.trim($('#transpo_base_price').val());
           var transpo_base_index = $.trim($('#transpo_base_index').val());
           parameters['coal_base_price'] = coal_base_price;
           parameters['coal_base_index'] = coal_base_index;
           parameters['transpo_base_price'] = transpo_base_price;
           parameters['transpo_base_index'] = transpo_base_index;
           var error_messages = [];
           
           if (coal_base_price.length <= 0) {
               error_messages.push('Coal Base Price');
           }
           
           if (coal_base_index.length <= 0) {
               error_messages.push('Coal Base Index');
           }
           
           if (transpo_base_index.length <=0) {
               error_messages.push('Transpo Base Index');
           }
           
           if (transpo_base_price.length <=0) {
               error_messages.push('Transpo Base Price');
           }
           
           if (error_messages.length > 0) {
               $('#loader').html('The following field(s) are required<br>' + error_messages.join('<br>')).addClass('alert').addClass('alert-error');
           }else {
               $('#loader').html('Please wait <img src="../images/ajax-loader.gif" />').removeAttr('class');
               $.post('<?=$base_url?>/power_bill/input_base_prices_save',parameters,
                function(data){
                   $('#loader').html(data.message).addClass('alert').addClass('alert-info');
                }); 
           }
           
              
       }
    });
</script>

<script type="text/javascript">
$(document).ready(function(){
     $('.numeric').autoNumeric('init',{
        mDec: '5'
      ,vMin : -9999999999      
    });
    
    
    $('#year').unbind().bind('change',function(){
        $.getData();
    });
    
    $('#quarter').unbind().bind('change',function(){
        $.getData();
    });
    
    $('#btn_save').unbind().bind('click',function(){
        $.saveData();
    })
    $.getData();
});
 

</script>
    

     



