<style>
.table th, .table td {
    vertical-align: middle;
}

table.tbl_pscx {
    border: 1px solid #F9F9F9;
    border-radius: 4px;
}
table.tbl_psc th {
    text-align: center;
    background-color: #F7F4F4;
}

div.formula {
    background-color: #EAF3F7;
    padding:10px;
    font-size:11px;
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
                <div class="span2">Billing Period </div>
                <div class="span3 input-append input-prepend">
                    <input type="text" id="sdate" name="date" value="<?=$def_sdate?>" class="input-small"><span class="add-on">to</span>
                    <input type="text" id="edate" name="date" value="<?=$def_edate?>" class="input-small">
                </div>
                <div class='span4' style="margin-top: 5px;">
                    <span class="error-note" id="date_range_error"></span>
                </div>
            </div>
            
            <div class="row-fluid">
                <div class="span2">Computation Type </div>
                    <div class="span7">
                       
                        <select name="type" class="input-medium" id="type">
                            <option value="old">Old</option>
                            <option value="new">New</option>
                        </select>
            </div></div>
            <br>
            <div id="loader"></div>
            <div id="result" style="display:none;">
                <form id="form_psc_rate" name="form_psc_rate" >
            <table class="table table-condensed tbl_psc">
                
                <input type="hidden" name="fuel_fee_fbpo" id="fuel_fee_fbpo" value="">
                <input type="hidden" name="cfr_fxo" id="cfr_fxo" value="">
                <input type="hidden" name="fuel_fee_cfo" id="fuel_fee_cfo" value="">
                <input type="hidden" name="us_om_cpio" id="us_om_cpio" value="">
                <input type="hidden" name="us_om_ppio" id="us_om_ppio" value="">
                <input type="hidden" name="php_om_phcpio" id="php_om_phcpio" value="">
                <input type="hidden" name="php_om_gwpio" id="php_om_gwpio" value="">
                <input type="hidden" name="fuel_fee_fbpo" id="fuel_fee_fbpo" value="">
                <input type="hidden" name="coal_base_index" id="coal_base_index" value="">
                <input type="hidden" name="coal_base_price" id="coal_base_price" value="">
                <input type="hidden" name="transpo_base_index" id="transpo_base_index" value="">
                <input type="hidden" name="transpo_base_price" id="transpo_base_price" value="">
                <input type="hidden" name="coal_price" id="coal_price" value="">
                <input type="hidden" name="prev_coal_price" id="prev_coal_price" value="">
                <input type="hidden" name="prev_transpo_price" id="prev_transpo_price" value="">
                <input type="hidden" name="is_computed_coal_price" id="is_computed_coal_price" value="">
                <input type="hidden" name="computed_coal_price" id="computed_coal_price" value="">
                <input type="hidden" name="computed_transpo_price" id="computed_transpo_price" value="">
                
                <tr>
                    <th colspan="5" style="font-weight: bold; font-size:13px;"><center>Capacity Recovery Fee (CRF)</center></th>
                </tr>
                <tr>
                    <td style="width:15%;">FXn</td>
                    <td style="width:30%;"><input type="text" name="cfr_fxn" id="cfr_fxn" class="input-medium numeric" value=""> Php/USD</td>
                    <td>&nbsp;</td>
                    <td style="width:15%;">CRF</td>
                    <td style="width:30%;"><input type="text" disabled="true" name="disp_cfr" id="disp_cfr" class="input-medium numeric" value="">
                    <input type="hidden" name="cfr" id="cfr" class="input-medium numeric" value="">Php/kWh</td>
                </tr>
                <tr ><td colspan="5">
                        <div class="formula">Where : CRF = 4.2511 * (0.54 * ( FXn / FXo ))</div>
                </td></tr>
                
                <!--- Fuel Fee --->
                <tr><td colspan="5"></td></tr>
                 <tr>
                    <th colspan="5" style="font-weight: bold; font-size:13px;"><center>Fuel Fee</center></th>
                </tr>
                <tr>
                    <td style="width:15%;">CRP</td>
                    <td style="width:30%;"><input type="text" name="fuel_fee_crp" id="fuel_fee_crp" class="input-medium numeric" value=""> USD/MT</td>
                    <td>&nbsp;</td>
                    <td style="width:15%;"  name="new_psc_rate">Fuel Factor</td>
                    <td style="width:30%;" name="new_psc_rate"><input type="text" name="fuel_fee_fbpn" id="fuel_fee_fbpn" class="input-medium" value=""> USD/MT</td>
                </tr>
                
                <tr>
                    <td style="width:15%;">Coal Price</td>
                    <td style="width:30%;"><input type="text" disabled="true" name="disp_fuel_fee_coal_price" id="disp_fuel_fee_coal_price" class="input-medium numeric" value="">
                        <input type="hidden" name="fuel_fee_coal_price" id="fuel_fee_coal_price" class="input-medium numeric" value=""> USD/MT</td>
                    <td>&nbsp;</td>
                    <td style="width:15%;">Transpo</td>
                    <td style="width:30%;"><input type="text" disabled="true" name="disp_fuel_fee_transpo" id="disp_fuel_fee_transpo" class="input-medium numeric" value=""> USD/MT
                        <input type="hidden" name="fuel_fee_transpo" id="fuel_fee_transpo" class="input-medium numeric" value=""></td>
                </tr>
                
                <tr>
                    <td style="width:15%;">CFn</td>
                    <td style="width:30%;"><input type="text" disabled="true" name="disp_fuel_fee_cfn" id="disp_fuel_fee_cfn" class="input-medium numeric" value="">
                        <input type="hidden" name="fuel_fee_cfn" id="fuel_fee_cfn" class="input-medium numeric" value=""> USD/MT</td>
                    <td>&nbsp;</td>
                    <td style="width:15%;">Fuel Fee</td>
                    <td style="width:30%;"><input type="text" disabled="true" name="disp_fuel_fee" id="disp_fuel_fee" class="input-medium numeric" value="">
                        <input type="hidden" name="fuel_fee" id="fuel_fee" class="input-medium numeric" value=""> Php/kWh</td>
                </tr>
                
                <tr ><td colspan="5">
                        <div class="formula">Where<br>
                            <span name="old_psc_rate">Fuel Fee = 4.2511 * (0.305 * ( CFn / CFo ) * (FXn / FXo) )<br></span>
                            <span name="new_psc_rate">Fuel Fee = 4.2511 * (0.305 * ( CFn / CFo ) * (FBPn / FBPo) * (FXn / FXo) )<br></span>
                            CFO = Previous Billing computed CFn<br>
                            <span name="old_psc_rate">CFn = Coal Price + Transpo<br></span>
                            <span name="new_psc_rate">CFn = If Coal Price >= CRP, Coal Price + Transpo, Otherwise , CRP + Transpo<br></span>
                            
                            Coal Price = Coal Base Price x (Previous Quarter Coal Index / Coal Base Index ) <br>
                            Transpo = (Transpo Base Price * 0.75 ) + (Transpo Base Price * 0.25 * ( Transpo Previous Quarter Index / Transpo Base Index )) <br>
                        </div>
                </td></tr>
                
                <!--- US O & M --->
                <tr><td colspan="5"></td></tr>
                 <tr>
                    <th colspan="5" style="font-weight: bold; font-size:13px;"><center>US O & M</center></th>
                </tr>
                <tr>
                    <td style="width:15%;">CPin</td>
                    <td style="width:30%;"><input type="text" name="us_om_cpin" id="us_om_cpin" class="input-medium numeric" value=""></td>
                    <td>&nbsp;</td>
                    <td style="width:15%;">PPin</td>
                    <td style="width:30%;"><input type="text" name="us_om_ppin" id="us_om_ppin" class="input-medium numeric" value=""></td>
                </tr>
                
                <tr>
                    <td style="width:15%;">FCPn/FCPo</td>
                    <td style="width:30%;"><input type="text" disabled="true" name="disp_us_om_fcpn_fcpo" id="disp_us_om_fcpn_fcpo" class="input-medium numeric" value="">
                        <input type="hidden" name="us_om_fcpn_fcpo" id="us_om_fcpn_fcpo" class="input-medium numeric" value=""></td>
                    <td>&nbsp;</td>
                    <td style="width:15%;">US O/M</td>
                    <td style="width:30%;"><input type="text" disabled="true" name="disp_us_om" id="disp_us_om" class="input-medium numeric" value=""> Php/kWh
                        <input type="hidden" name="us_om" id="us_om" class="input-medium numeric" value=""></td>
                </tr>
                
                <tr ><td colspan="5">
                        <div class="formula">Where<br>
                            US O/M = 4.2511 * ( 0.065 * ( FCPn/FCPo ) * ( Fxn / Fxo))<br>
                            FCPn / FCPo = ((CPIn / CPIo) + (PPIn / PPIo)) / 2<br>
                        </div>
                </td></tr>
                
                
                <!--- PHP O & M --->
                <tr><td colspan="5"></td></tr>
                 <tr>
                    <th colspan="5" style="font-weight: bold; font-size:13px;"><center>PHP O & M</center></th>
                </tr>
                <tr>
                    <td style="width:15%;">PhpCPin</td>
                    <td style="width:30%;"><input type="text" name="php_om_phcpin" id="php_om_phcpin" class="input-medium numeric" value=""></td>
                    <td>&nbsp;</td>
                    <td style="width:15%;">FCPn/FCPo</td>
                    <td style="width:30%;"><input type="text" disabled="true" name="disp_php_om_fcpn_fcpo" id="disp_php_om_fcpn_fcpo" class="input-medium numeric" value="">
                        <input type="hidden" name="php_om_fcpn_fcpo" id="php_om_fcpn_fcpo" class="input-medium numeric" value=""></td>
                </tr>
                
                <tr>
                    <td style="width:15%;">GWPin</td>
                    <td style="width:30%;"><input type="text" name="php_om_gwpin" id="php_om_gwpin" class="input-medium numeric" value=""> </td>
                    <td>&nbsp;</td>
                    <td style="width:15%;">PHP O/M</td>
                    <td style="width:30%;"><input type="text" disabled="true" name="disp_php_om" id="disp_php_om" class="input-medium numeric" value=""> Php/kWh
                        <input type="hidden" name="php_om" id="php_om" class="input-medium numeric" value=""></td>
                </tr>
                
                <tr ><td colspan="5">
                        <div class="formula">Where<br>
                            PHP O/M = 4.2511 * ( 0.090 * ( FCPn/FCPo ) * ( Fxn / Fxo))<br>
                            FCPn / FCPo = ((PhCPIn / PhCPIo) + (GWPIn / GWPIo)) / 2<br>
                        </div>
                </td></tr>
                
                
                <!--- PSC RAte ---->
                <tr><td colspan="5"></td></tr>
                 
                <tr>
                    <td style="width:15%;">PSC Rate</td>
                    <td style="width:30%;"><input type="text" disabled="true" name="disp_psc_rate" id="disp_psc_rate" class="input-medium numeric" value="">
                        <input type="hidden" name="psc_rate" id="psc_rate" class="input-medium numeric" value=""> Php/kWh</td>
                    <td>&nbsp;</td>
                    <td style="width:15%;"></td>
                    <td style="width:30%;"></td>
                </tr>
                
                
                
                <tr ><td colspan="5">
                        <div class="formula">Where PSR Rate = CFR + Fuel Fee + US O/M + PHP O/M
                        </div>
                </td></tr>
            </table>
            </form>
            
            
            <div class="row-fluid">
                <div class="span7" id="btns"></div>
            </div>
                </div>
            <br>
            
    </section>
    
    
</div>

<script type="text/javascript">
    $.extend({
       getData : function(){
           
           // display appropriate type 
           var type = $('#type').val();
           $('[name=old_psc_rate]').hide();
           $('[name=new_psc_rate]').hide();
           if (type === 'old') {
               $('[name=old_psc_rate]').show();
           }else {
               $('[name=new_psc_rate]').show();
           }
           
           // hide form elements first while getting data from the backend
           $('#result').hide();
           $('#loader').html('Please wait, we are getting information for the selected billing period <img src="../images/ajax-loader.gif" />').removeAttr('class');
           $('#btns').html(''); 
            
           var parameters = {};
           parameters['sdate'] = $('#sdate').val();
           parameters['edate'] = $('#edate').val();
           parameters['type'] = $('#type').val();
           
            $.post('<?=$base_url?>/power_bill/psc_rate_computation_get',parameters,
            function(ret){
                var data = ret.value;
                var messages = ret.message;
                
                $("form#form_psc_rate :input").each(function(){
                    var input = $(this); 
                    var id = input.attr('id');
                    var val = '';
                    if ( typeof data[id] != 'undefined'  ) {
                        val = data[id];
                    }
                    $('#'+id).val(val);
                });
                if (messages.length > 0) {
                    $('#loader').html(ret.message.join('<br>')).addClass('alert').addClass('warning');
                }else {
                    $('#loader').html('').removeAttr('class');
                    $('#btns').html('<button type="button" id="btn_save" class="btn btn-primary"><i class="icon-file"></i>&nbsp;Save</button>&nbsp');
                }
                
                $.computeandPopulate();
                $('#result').show();
               
            });  
            
            
       } //
       ,computeandPopulate : function(){
           var cfr_fxn = $.trim($('#cfr_fxn').val());
           cfr_fxn = cfr_fxn.length > 0 ? parseFloat(cfr_fxn) : 0;
           
           var cfr_fxo = $.trim($('#cfr_fxo').val());
           cfr_fxo = cfr_fxo.length > 0 ? parseFloat(cfr_fxo) : 0;
           
           var cfr =  4.2511 * (0.54 * ( cfr_fxn / cfr_fxo ));
           $('#disp_cfr').val($.formatNumberToSpecificDecimalPlaces(cfr,4));
           $('#cfr').val(cfr);
           
           
           //  Coal Price = Coal Base Price x (Coal Base Index / Previous Quarter Coal Index ) 
           var coal_base_price =$.trim($('#coal_base_price').val());
           coal_base_price = coal_base_price.length > 0 ? parseFloat(coal_base_price) : 0;
           
           var coal_base_index =$.trim($('#coal_base_index').val());
           coal_base_index = coal_base_index.length > 0 ? parseFloat(coal_base_index) : 0;
           
           var prev_coal_price =$.trim($('#prev_coal_price').val());
           prev_coal_price = prev_coal_price.length > 0 ? parseFloat(prev_coal_price) : 0;
           
           if (prev_coal_price === 0 ) {
               var coal_price = '';
           }else {
               var coal_price = coal_base_price* ( coal_base_index/prev_coal_price  );
           }
           var is_computed_coal_price = parseInt($('#is_computed_coal_price').val(),10);
           var computed_coal_price = $('#computed_coal_price').val();
           var computed_transpo_price = $('#computed_transpo_price').val();
           
           if (is_computed_coal_price === 1) {
               coal_price = parseFloat(computed_coal_price);
           }
           $('#disp_fuel_fee_coal_price').val($.formatNumberToSpecificDecimalPlaces(coal_price,4));
           $('#fuel_fee_coal_price').val(coal_price);
           
           
           //  Transpo = (Transpo Base Price * 0.75 ) + (Transpo Base Price * 0.25 * ( Transpo Previous Quarter Index / Transpo Base Index )) 
           var transpo_base_price =$.trim($('#transpo_base_price').val());
           transpo_base_price = transpo_base_price.length > 0 ? parseFloat(transpo_base_price) : 0;
           
           var prev_transpo_price =$.trim($('#prev_transpo_price').val());
           prev_transpo_price = prev_transpo_price.length > 0 ? parseFloat(prev_transpo_price) : 0;
           
           var transpo_base_index =$.trim($('#transpo_base_index').val());
           transpo_base_index = transpo_base_index.length > 0 ? parseFloat(transpo_base_index) : 0;
           
           var transpo_price = (transpo_base_price * 0.75 ) + (transpo_base_price * 0.25 * ( prev_transpo_price / transpo_base_index ));
           
           if (is_computed_coal_price === 1) {
               transpo_price = parseFloat(computed_transpo_price);
           }
           $('#disp_fuel_fee_transpo').val($.formatNumberToSpecificDecimalPlaces(transpo_price,2));
           $('#fuel_fee_transpo').val(transpo_price);
           
           
           
           // compute fuel fee cfn
           // CFn = If Coal Price >= CRP, Coal Price + Transpo, Otherwise , CRP + Transpo
           var fuel_fee_crp =$.trim($('#fuel_fee_crp').val());
           fuel_fee_crp = fuel_fee_crp.length > 0 ? parseFloat(fuel_fee_crp) : 0;
           
           var fuel_fee_cfn = 0;
           var type = $.trim($('#type').val()).toLowerCase();
           if (type === 'new') {
               if (coal_price >= fuel_fee_crp) {
                    fuel_fee_cfn = coal_price + transpo_price;
                }else {
                    fuel_fee_cfn = fuel_fee_crp + transpo_price;
                }
           }else if (type === 'old') {
               fuel_fee_cfn = coal_price + transpo_price;
           }
           
           
           $('#disp_fuel_fee_cfn').val($.formatNumberToSpecificDecimalPlaces(fuel_fee_cfn,2));
           $('#fuel_fee_cfn').val(fuel_fee_cfn);
           
           // (NEW) --- Fuel Fee = 4.2511 * (0.305 * ( CFn / CFo ) * (FXn / FXo) )
           // (OLD) --- Fuel Fee = 4.2511 * (0.305 * ( CFn / CFo ) * (FBPn / FBPo) * (FXn / FXo) )
           var fuel_fee_cfo =$.trim($('#fuel_fee_cfo').val());
           fuel_fee_cfo = fuel_fee_cfo.length > 0 ? parseFloat(fuel_fee_cfo) : 0;
           
           var cfr_fxn =$.trim($('#cfr_fxn').val());
           cfr_fxn = cfr_fxn.length > 0 ? parseFloat(cfr_fxn) : 0;
           
           var cfr_fxo =$.trim($('#cfr_fxo').val());
           cfr_fxo = cfr_fxo.length > 0 ? parseFloat(cfr_fxo) : 0;
           
           var fuel_fee_fbpn =$.trim($('#fuel_fee_fbpn').val());
           fuel_fee_fbpn = fuel_fee_fbpn.length > 0 ? parseFloat(fuel_fee_fbpn) : 0;
           
           var fuel_fee_fbpo =$.trim($('#fuel_fee_fbpo').val());
           fuel_fee_fbpo = fuel_fee_fbpo.length > 0 ? parseFloat(fuel_fee_fbpo) : 0;
           
           
           
           var fuel_fee = 0;
           if ( type === 'old' ) {
               fuel_fee = 4.2511 * (0.305 * ( fuel_fee_cfn / fuel_fee_cfo ) * (cfr_fxn / cfr_fxo) );
           }else {
               fuel_fee = 4.2511 * (0.305 * ( fuel_fee_cfn / fuel_fee_cfo ) * (fuel_fee_fbpn) * (cfr_fxn / cfr_fxo) );
               
           }
           $('#disp_fuel_fee').val($.formatNumberToSpecificDecimalPlaces(fuel_fee,4));
           $('#fuel_fee').val(fuel_fee);
           
           
           // US O & M
           // FCPn / FCPo = ((CPIn / CPIo) + (PPIn / PPIo)) / 2
           var us_om_cpin =$.trim($('#us_om_cpin').val());
           us_om_cpin = us_om_cpin.length > 0 ? parseFloat(us_om_cpin) : 0;
           
           var us_om_cpio =$.trim($('#us_om_cpio').val());
           us_om_cpio = us_om_cpio.length > 0 ? parseFloat(us_om_cpio) : 0;
           
           var us_om_ppin =$.trim($('#us_om_ppin').val());
           us_om_ppin = us_om_ppin.length > 0 ? parseFloat(us_om_ppin) : 0;
           
           var us_om_ppio =$.trim($('#us_om_ppio').val());
           us_om_ppio = us_om_ppio.length > 0 ? parseFloat(us_om_ppio) : 0;
           
           var us_om_fcpn_fcpo = ((us_om_cpin / us_om_cpio) + (us_om_ppin / us_om_ppio)) / 2;
           $('#disp_us_om_fcpn_fcpo').val($.formatNumberToSpecificDecimalPlaces(us_om_fcpn_fcpo,2));
           $('#us_om_fcpn_fcpo').val(us_om_fcpn_fcpo);
           
           // US O/M = 4.2511 * ( 0.0605 * ( FCPn/FCPo ) * ( Fxn / Fxo))
           var us_om = 4.2511 * ( 0.065 * ( us_om_fcpn_fcpo ) * ( cfr_fxn / cfr_fxo));
           $('#disp_us_om').val($.formatNumberToSpecificDecimalPlaces(us_om,4));
           $('#us_om').val(us_om);
           
           
           // PHP O & M
           //FCPn / FCPo = ((PhCPIn / PhCPIo) + (GWPIn / GWPIo)) / 2
           var php_om_phcpin =$.trim($('#php_om_phcpin').val());
           php_om_phcpin = php_om_phcpin.length > 0 ? parseFloat(php_om_phcpin) : 0;
           
           var php_om_phcpio =$.trim($('#php_om_phcpio').val());
           php_om_phcpio = php_om_phcpio.length > 0 ? parseFloat(php_om_phcpio) : 0;
           
           var php_om_gwpin =$.trim($('#php_om_gwpin').val());
           php_om_gwpin = php_om_gwpin.length > 0 ? parseFloat(php_om_gwpin) : 0;
           
           var php_om_gwpio =$.trim($('#php_om_gwpio').val());
           php_om_gwpio = php_om_gwpio.length > 0 ? parseFloat(php_om_gwpio) : 0;
           
           var php_om_fcpn_fcpo = ((php_om_phcpin / php_om_phcpio) + (php_om_gwpin / php_om_gwpio)) / 2;
           $('#disp_php_om_fcpn_fcpo').val($.formatNumberToSpecificDecimalPlaces(php_om_fcpn_fcpo,2));
           $('#php_om_fcpn_fcpo').val(php_om_fcpn_fcpo);
           
           //PHP O/M = 4.2511 * ( 0.090 * ( FCPn/FCPo ) * ( Fxn / Fxo))
           var php_om = 4.2511 * ( 0.090 * ( php_om_fcpn_fcpo ));
           $('#disp_php_om').val($.formatNumberToSpecificDecimalPlaces(php_om,4));
           $('#php_om').val(php_om);
           
           // PSR Rate = CFR + Fuel Fee + US O/M + PHP O/M 
           var psc_rate = cfr + fuel_fee + us_om + php_om;
           $('#disp_psc_rate').val($.formatNumberToSpecificDecimalPlaces(psc_rate,4));
           $('#psc_rate').val(psc_rate);
           
       }
       ,saveData : function(){
           var parameters = $('form').serialize();
           parameters+= '&sdate=' + $('#sdate').val();
           parameters+= '&edate=' + $('#edate').val();
           parameters+= '&type=' + $('#type').val();
           $('#loader').html('Please wait <img src="../images/ajax-loader.gif" />').removeAttr('class');
            $.post('<?=$base_url?>/power_bill/psc_rate_computation_save',parameters,
             function(data){
                $('#loader').html(data.message).addClass('alert').addClass('alert-info');
                bootbox.alert('<p class=bootbox-text> '+data.message+'</p>')
             }); 
           
              
       } //
       ,validateDateRange : function(sdate_obj,edate_obj){
            var f_date = $.trim(sdate_obj.val());
            var e_date = $.trim(edate_obj.val());
            var is_valid = true;
            if ( f_date.length <= 0 || e_date.length <= 0 ) {
                is_valid = false;
            } else if (f_date.length > 0 || e_date.length > 0){
                var f_date_dte_obj = new Date(f_date);
                var e_date_dte_obj = new Date(e_date);
                if (e_date_dte_obj < f_date_dte_obj ) {
                     is_valid = false;
                }else {
                     is_valid = true;
                }
            }else {
                is_valid = false;
            }
            
            if (is_valid) {
                $('#date_range_error').html('');
            }else {
                $('#date_range_error').html('Invalid date range');
            }
            return is_valid;
        }
    });
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('#sdate,#edate').datepicker();
    
    $('#sdate').on('changeDate', function(ev) {
        var msg = '';
        var sdate = Date.parse($('#sdate').val());
        var sday = parseInt(Date.parse($('#sdate').val()).toString('dd'),10);
        if (sday < 26) {
            var n_year = sdate.toString('yyyy');
            var n_month = sdate.toString('MM');
             msg = 'Billing period should start every 26th of the month';
        }else {
            var n_date = sdate.addMonths(1);
            var n_year = n_date.toString('yyyy');
            var n_month = n_date.toString('MM');
        }
        var suggested_endate = Date.parse(n_year +'-'+n_month+'-25').toString('MM/dd/yyyy');
        $('#edate').val(suggested_endate);
        $('#date_range_error').html(msg);
        $.getData();
     });
    
    $('#edate').on('changeDate', function(ev) {
           $.validateDateRange( $('#sdate'),$('#edate') );
           $.getData();
    });  
    $('#type').unbind().bind('change',function(){
        $.getData();
    });
    
   
    $('#btn_save').unbind().live('click',function(){
        $.saveData();
    });
    
    $("form#form_psc_rate input[type=text]").addClass('numeric').live('blur',function(){
        $.computeandPopulate();
    });
    
    $('#fuel_fee_fbpn').autoNumeric('init',{
        mDec: '16'
      ,vMin : -9999999999      
    });
     $('.numeric').autoNumeric('init',{
        mDec: '5'
      ,vMin : -9999999999      
    });
    
    $.getData();
});
 

</script>
    

     



