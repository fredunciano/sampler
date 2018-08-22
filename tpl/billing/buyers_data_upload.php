<div class="span-4 colborder">
    <div id="submenu_container">
        <div class="submenu_title_box">Billing and Settlements</div>
        <div>
            <ul class="submenu">
                <?php
                foreach ( $submenu as $sm ) {
                    echo '<li><a href="'.$base_url.$sm['link'].'">'.$sm['title'].'</a></li>';
                }
                ?>
            </ul> 
        </div>
    </div>
</div>
<div class="span-19 last">
    <br>
    <fieldset class="fs-blue">
        <legend><?=$title?></legend>
        <form method="post" enctype="multipart/form-data" id="frm1">
        <table>
            <tr>
                <th>Buyers Data Template</th>
                <td><button id="download">Download Template</button></td>
            </tr>
            <tr>
                <th width="150px">Billing Period</th>
                <td >
                	
                    <select name="billing_period_month" id="billing_period_month">
                        <?php
                            $billing_start = $def_date_man_start;
                            $billing_start = date_parse($billing_start);
                            for($x=1;$x<=12;$x++){
                                $time_tmp = mktime (0, 0, 0, $x+1 , 0, 0);
                                $month = date('F',$time_tmp);
                                $sel = (($billing_start['month']) == $x) ? 'selected=selected' : '';
                                echo '<option value="'.$x.'" '.$sel.' >'.$month .'</option>';
                            }
                            ?>
                    </select>
                    <select name="billing_period_year" id="billing_period_year">
                        <?php
                            for($x=2006;$x<=date('Y')+5;$x++){
                                $sel = ($billing_start['year'] == $x) ? 'selected=selected' : '';
                                echo '<option value="'.$x.'" '.$sel.' >'.$x.'</option>';
                            }
                            ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;
                    <button id="retrieve_cap_fac">Retrieve</button>&nbsp;&nbsp;<span id="msg-alert-retrieve"></span><button id="x_xls">Export to XLS</button>
                </td> 
            </tr>
            <tr>
                <th>Upload Buyers Data</th>
                <td><input type="file" name="file"><button id="submit_file">Populate</button><span id="msg-alert"></span></td>
            </tr>
        </table>
        </form>
    </fieldset><br>
    <fieldset class="fs-blue" id="fs-result" style="width:100%">
        <legend>Buyers Data&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</legend>
        <div id="grid_result" class="grid-scroll">
        <form id="frm2" method="post">
        <table>
            <tr>
                <th width="150px" rowspan="2"><b>Buyer</b></th>
                <th>PPD&nbsp;Factor</th>
                <th>Capacity&nbsp;Fee&nbsp;at 100%&nbsp;Capacity&nbsp;Factor</th>
                <th>PPD&nbsp;Option</th>
                <th>VAT</th>
                <th>Settlement Adjustment</th>
                <th>WESM Charges</th>
                <th>Delivery Charges</th>
                <th>Governmental Charges</th>
                <th>Foreign&nbsp;Exchange Rate&nbsp;Adjustment</th>
                <th>Buyer's&nbsp;Quantity&nbsp;of the&nbsp;Previous&nbsp;Billing</th>
                <th>PPD&nbsp;of&nbsp;the Previous&nbsp;Billing</th>
                <th>Total&nbsp;Other Charges</th>
                <th>Redelivered&nbsp;Quantity&nbsp;due&nbsp;to Localized&nbsp;Transmission&nbsp;Failure</th>
                <th>Energy&nbsp;Fee&nbsp;Adjustment&nbsp;on the&nbsp;Redelivered&nbsp;Quantity</th>
                <th>Redelivered&nbsp;Quantity due&nbsp;to&nbsp;Deficiency</th>
                <th>Energy&nbsp;Fee&nbsp;Payment due&nbsp;to&nbsp;deficiency</th>
                <th>Other Charges </th>
                <th>Contract Price</th>
                <th>FX Adjustments</th>
                <th>Market Fees</th>
                <th>Market Fees Adjustments</th>
                <th>Total Payments</th>
                
            </tr>
            <tr>
                <th>%</th>
                <th>%</th>
                <th>Type</th>
                <th>USD</th>
                <th>USD</th>
                <th>Php</th>
                <th>Php</th>
                <th>Php</th>
                <th>Php</th>
                <th>kWh</th>
                <th>USD</th>
                <th>Php</th>
                <th>kWh</th>
                <th>USD</th>
                <th>kWh</th>
                <th>USD</th>
                <th>USD</th>
                <th>USD</th>
                <th>PhP/kWh</th>
                <th>USD</th>
                <th>USD</th>
                <th>USD</th>
            </tr>
            <?php
                foreach ($customers as $c) {
                    echo '
                            <tr>
                                <td>'.$c->name.'</td>
                                <td><input type="text" style="width:40px" name="ppd_factor_'.$c->id.'" id="ppd_factor_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="cap_fee_'.$c->id.'" id="cap_fee_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="ppd_option_'.$c->id.'" id="ppd_option_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="vat_'.$c->id.'" id="vat_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="settlement_adj_'.$c->id.'" id="settlement_adj_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="wesm_charges_'.$c->id.'" id="wesm_charges_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="delivery_charges_'.$c->id.'" id="delivery_charges_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="governmental_charges_'.$c->id.'" id="governmental_charges_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="forex_rate_adj_'.$c->id.'" id="forex_rate_adj_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="buyers_qty_prev_billing_'.$c->id.'" id="buyers_qty_prev_billing_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="ppd_prev_billing_'.$c->id.'" id="ppd_prev_billing_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="total_other_charges_'.$c->id.'" id="total_other_charges_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="redelivered_qty_localized_trans_failure_'.$c->id.'" id="redelivered_qty_localized_trans_failure_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="energy_fee_adj_redelivered_qty_'.$c->id.'" id="energy_fee_adj_redelivered_qty_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="redelivered_qty_deficiency_'.$c->id.'" id="redelivered_qty_deficiency_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="energy_fee_payment_deficiency_'.$c->id.'" id="energy_fee_payment_deficiency_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="other_charges_'.$c->id.'" id="other_charges_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="contract_price_'.$c->id.'" id="contract_price_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="fx_adjustments_'.$c->id.'" id="fx_adjustments_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="market_fees_'.$c->id.'" id="market_fees_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="market_fees_adjustments_'.$c->id.'" id="market_fees_adjustments_'.$c->id.'"></td>
                                <td><input type="text" style="width:40px" name="total_payments_'.$c->id.'" id="total_payments_'.$c->id.'"></td>
                                
                                
                            </tr>
                         ';
                }
            ?>
        </table>
        </form> 
        </div>
        <div id="result"></div>
    </fieldset>
    <button id="submit_cap_fac">Submit Capacity Factor</button>&nbsp;&nbsp;<span id="msg-alert-submit"></span>
    <br><br><br><br><br>
</div>
<script src="../js/jquery.form.js"></script>
<script>
$.extend({
	exportExcel : function() {
       var url = 'http://' + location.host + '<?=$base_url?>' + '/billing/buyers_data_export_xls'
       	var parameters = "billing_period_month="+$('#billing_period_month').val()+"&billing_period_year="+$('#billing_period_year').val();
       	 $.download(url,parameters);
    },
    exportData : function(){
        
        var url = '../billing/excel_buyers_data'
        var parameters = "billing_period_month=" + $('#billing_period_month').val();

        $.download(url,parameters);
    },
    parseData : function(){
        var path = '../billing/parse_buyers_data';
    
        var options = {target:'#msg-alert',
            url:path,
            data: {month:$("#billing_period_month").val(),year:$("#billing_period_year").val()},
            beforeSubmit: function() { 
                $('#msg-alert').html('Loading...')
            },
            success: function(data) {
                //console.log(data)
                data = $.parseJSON(data);
                
                var obj = data.value;
                
                $.each(obj, function(i,val){
//console.log(i)
                    $('#ppd_factor_'+i).val(val.ppd_factor)
                    $('#cap_fee_'+i).val(val.cap_fee)
                    $('#ppd_option_'+i).val(val.ppd_option)
                    $('#vat_'+i).val(val.vat)
                    $('#settlement_adj_'+i).val(val.settlement_adj)
                    $('#wesm_charges_'+i).val(val.wesm_charges)
                    $('#delivery_charges_'+i).val(val.delivery_charges)
                    $('#governmental_charges_'+i).val(val.governmental_charges)
                    $('#forex_rate_adj_'+i).val(val.forex_rate_adj)
                    $('#buyers_qty_prev_billing_'+i).val(val.buyers_qty_prev_billing)
                    $('#ppd_prev_billing_'+i).val(val.ppd_prev_billing)
                    $('#total_other_charges_'+i).val(val.total_other_charges)
                    $('#redelivered_qty_localized_trans_failure_'+i).val(val.redelivered_qty_localized_trans_failure)
                    $('#energy_fee_adj_redelivered_qty_'+i).val(val.energy_fee_adj_redelivered_qty)
                    $('#redelivered_qty_deficiency_'+i).val(val.redelivered_qty_deficiency)
                    $('#energy_fee_payment_deficiency_'+i).val(val.energy_fee_payment_deficiency)
                    $('#other_charges_'+i).val(val.other_charges)
                    $('#contract_price_'+i).val(val.contract_price)
                    $('#fx_adjustments_'+i).val(val.fx_adjustments)
                    $('#market_fees_'+i).val(val.market_fees)
                    $('#market_fees_adjustments_'+i).val(val.market_fees_adjustments)
                    $('#total_payments_'+i).val(val.total_payments)
                    
                    
                })
                
                $('#msg-alert').html('')
                $('#result').html('')
                

            }};	
        $('#frm1').ajaxSubmit(options);	
    },
    insertBuyersData : function(){
        $('#msg-alert-submit').html('Loading...');
        $.post('../billing/buyers_data_action',$('#frm1, #frm2').serialize(),
        function(data){
            $('#msg-alert-submit').html(data);
        });	
        return false;
    },
    getBuyersData : function()
    {
        
        $('#msg-alert-retrieve').html('Loading...');
        $.post('../billing/buyers_data_load',$('#frm1').serialize(),
        function(data){

            data = $.parseJSON(data);
            if (data.length !== 0) {
                $.each(data, function(i,val){
                    $('input:text[name=ppd_factor_'+i+']').val(val.ppd_factor)
                    $('input:text[name=cap_fee_'+i+']').val(val.cap_fee)
                    $('input:text[name=ppd_option_'+i+']').val(val.ppd_option)
                    $('input:text[name=vat_'+i+']').val(val.vat)
                    $('input:text[name=settlement_adj_'+i+']').val(val.settlement_adj)
                    $('input:text[name=wesm_charges_'+i+']').val(val.wesm_charges)
                    $('input:text[name=delivery_charges_'+i+']').val(val.delivery_charges)
                    $('input:text[name=governmental_charges_'+i+']').val(val.governmental_charges)
                    $('input:text[name=forex_rate_adj_'+i+']').val(val.forex_rate_adj)
                    $('input:text[name=buyers_qty_prev_billing_'+i+']').val(val.buyers_qty_prev_billing)
                    $('input:text[name=ppd_prev_billing_'+i+']').val(val.ppd_prev_billing)
                    $('input:text[name=total_other_charges_'+i+']').val(val.total_other_charges)
                    $('input:text[name=redelivered_qty_localized_trans_failure_'+i+']').val(val.redelivered_qty_localized_trans_failure)
                    $('input:text[name=energy_fee_adj_redelivered_qty_'+i+']').val(val.energy_fee_adj_redelivered_qty)
                    $('input:text[name=redelivered_qty_deficiency_'+i+']').val(val.redelivered_qty_deficiency)
                    $('input:text[name=energy_fee_payment_deficiency_'+i+']').val(val.energy_fee_payment_deficiency)
                    $('input:text[name=other_charges_'+i+']').val(val.other_charges)
                    $('input:text[name=contract_price_'+i+']').val(val.contract_price)
                    $('input:text[name=fx_adjustments_'+i+']').val(val.fx_adjustments)
                    $('input:text[name=market_fees_'+i+']').val(val.market_fees)
                    $('input:text[name=market_fees_adjustments_'+i+']').val(val.market_fees_adjustments)
                    $('input:text[name=total_payments_'+i+']').val(val.total_payments)
                    
                })
                $('#msg-alert-retrieve').html('');
            } else {
                $('#msg-alert-retrieve').html('Data not available');
            }
            
        });	
        return false;
    }
});
</script>
<script>

$('#download').unbind('click').bind('click', function(e){
    e.preventDefault();
    $.exportData();
})
$('#submit_file').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.parseData();
}) 
$('#submit_cap_fac').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.insertBuyersData();
})
$('#retrieve_cap_fac').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.getBuyersData();
})
$('#x_xls').unbind('click').bind('click',function(e){
	e.preventDefault();
	$.exportExcel();
})
</script>