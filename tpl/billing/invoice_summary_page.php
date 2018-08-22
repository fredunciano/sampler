<div class="span-4 colborder">
    <div id="submenu_container">
        <div class="submenu_title_box">Invoice</div>
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
    <fieldset class="fs-blue" id="fldst_preinvoice_summary">
        <legend><?=$title?></legend>
        <div id="fldst_preinvoice_summary_loader"></div>
        <table>
            <tr>
                <th colspan="2">Pre-Invoice Summary Entries</th>
            </tr>
            <tr>
                <td style="width: 25%;">Billing Period</td>
                <td>

                    <select id="month">
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
                    <select id="year">
                        <?php
                        for($x=2006;$x<=date('Y')+5;$x++){
                            $sel = ($billing_start['year'] == $x) ? 'selected=selected' : '';
                            echo '<option value="'.$x.'" '.$sel.' >'.$x.'</option>';
                        }
                        ?>
                    </select>

                </td>
            </tr>
            <tr>
                <td>Availability : </td>
                <td><input type="text" name="txt_availability" id="txt_availability" value="720" style="width:200px;" validate="required:true"></td>
            </tr>

            <tr>
                <td>Market Fees :</td>
                <td><input type="text" name="txt_market_fees" id="txt_market_fees" value="0.01314215300939	" style="width:200px;" validate="required:true">&nbsp;PhP/kWh</td>
            </tr>
            <tr>
                <td>RA 7638</td>
                <td><input type="text" name="txt_ra_7638" id="txt_ra_7638" value="0.01" style="width:200px;" validate="required:true">&nbsp;PhP/kWh</td>
            </tr>
            <tr>
                <td>Adjusted Initial Energy Fee </td>
                <td><input type="text" name="txt_initial_energy_fee" id="txt_initial_energy_fee" value="0.0235" style="width:200px;" validate="required:true">&nbsp;</td>
            </tr>

            <tr>
                <td>Base CIF </td>
                <td><input type="text" name="txt_base_cif" id="txt_base_cif" value="7.1073" style="width:200px;" validate="required:true">&nbsp;</td>
            </tr>

            <tr>
                <td>Actual CIF</td>
                <td><input type="text" name="txt_actual_cif" id="txt_actual_cif" value="15.08668" style="width:200px;" validate="required:true">&nbsp;</td>
            </tr>

            <tr>
                <td>Energy Fee</td>
                <td><input type="text" name="txt_energy_fee" id="txt_energy_fee" value="0.05306755" style="width:200px;" validate="required:true">&nbsp;</td>
            </tr>

            <tr>
                <td>Adjustment due to Import Duties</td>
                <td><input type="text" name="txt_adj_dues_import" id="txt_adj_dues_import" value="-0.00318" style="width:200px;" validate="required:true">&nbsp;</td>
            </tr>
            <tr>
                <td>Forex Rates</td>
                <td><input type="text" name="txt_forex_rates" id="txt_forex_rates" value="41.1400" style="width:200px;" validate="required:true">&nbsp;</td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <td><button id="btn_compute" type="button">Save and Compute Invoice</button><button id="btn_view_invoice" type="button" style="display: none;">View Invoice Summary</button></td>
            </tr>
        </table>
    </fieldset><br>
    <fieldset class="fs-blue" style="width:100%;display:none;" id="fldst_invoice_summary_results">
        <legend>Result&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</legend>
        <div id="result_loader"></div>
        <div><b>Currency View  :</b> <select id="cmb_currency">
                <option value="usd" selected="true">Dollar</option>
                <option value="php">Pesos</option>
            </select> </div>
        <br/>
        <div id="result">

            <table class="table_buyer_names" id="tbl_buyer_names">
                <tr>
                    <th> &nbsp;</th>
                </tr>
                <tr>
                    <th> Buyer</th>
                </tr>
                <tr>
                    <th> &nbsp;</th>
                </tr>
            </table>

            <div class="table_details_container">
                <table id="tbl_data_details">
                    <tr>
                        <th colspan="5" class="header-buyer-details">Buyer's Details</th>
                        <th colspan="9" class="header-total-generation">Total Generation Charges</th>
                        <th colspan="9" class="header-adjustments">Adjustments</th>
                        <th colspan="7" class="header-others">&nbsp;</th>
                    </tr>

                    <tr>
                        <th>Contracted Capacity</th>
                        <th>Total Quantity</th>
                        <th>Computed Capacity Factor</th>
                        <th>Minimum Capacity Factor</th>
                        <th>Resulting Capacity Factor</th>
                        <th>Capacity Fee</th>
                        <th>Initial Energy Fee</th>
                        <th>Base CIF</th>
                        <th>Actual CIF</th>
                        <th>Energy Fee</th>
                        <th style="min-width: 200px;">Adjustment due to Import Duties</th>
                        <th>Net Energy Fee</th>
                        <th>Contract Fee</th>
                        <th>Contract Price</th>
                        <th>PPD</th>
                        <th>FX Adjustments</th>
                        <th>Market Fees</th>
                        <th>Market Fees Adjustment</th>
                        <th>Redelivered Quantity (LTF)</th>
                        <th style="min-width: 200px;">Redelivered Quantity (Deficiency)</th>
                        <th style="min-width: 200px;">Energy Fee Adjustment on the RQ</th>
                        <th style="min-width: 200px;">Energy Fee Payment due to deficiency</th>
                        <th>Delivery Charges</th>
                        <th>Other Charges</th>
                        <th>Total Vatable Charges</th>
                        <th style="min-width: 200px;">Benefit to Host Communities</th>
                        <th style="min-width: 200px;">Total Non Vatable Charges</th>
                        <th>Total Net Charges</th>
                        <th>VAT</th>
                        <th>Total Charges</th>
                    </tr>

                    <tr>
                        <th>kW</th>
                        <th>(kWh)</th>
                        <th>%</th>
                        <th>%</th>
                        <th>%</th>
                        <th><span name="currency">USD</span>/kWh</th>
                        <th><span name="currency">USD</span>/kWh</th>
                        <th><span name="currency">USD</span>/Mkcal</th>
                        <th><span name="currency">USD</span>/Mkcal</th>
                        <th><span name="currency">USD</span>/kWh</th>
                        <th>&nbsp;</th>
                        <th><span name="currency">USD</span>/kWh</th>
                        <th><span name="currency">USD</span>/kWh</th>
                        <th><span name="currency">USD</span></th>
                        <th><span name="currency">USD</span></th>
                        <th><span name="currency">USD</span></th>
                        <th><span name="currency">USD</span></th>
                        <th><span name="currency">USD</span></th>
                        <th>kWh</th>
                        <th>kWh</th>
                        <th><span name="currency">USD</span></th>
                        <th><span name="currency">USD</span></th>
                        <th><span name="currency">USD</span></th>
                        <th><span name="currency">USD</span></th>
                        <th><span name="currency">USD</span></th>
                        <th><span name="currency">USD</span></th>
                        <th><span name="currency">USD</span></th>
                        <th><span name="currency">USD</span></th>
                        <th><span name="currency">USD</span></th>
                        <th><span name="currency">USD</span></th>
                    </tr>
                </table>
            </div>
        </div>
        <div>
            <button type="button" id="btn_confirm">Confirm</button>
            <button type="button" id="btn_export_xls">Export to Excel</button>
            <button type="button" id="btn_go_back"><< Go Back</button>
        </div>
    </fieldset>

    <br><br><br><br><br>
</div>


<style type="text/css">
    .hdr_content {
        font-weight: bold;
    }

    .data_content{
        text-align: right;
    }

    #result {
        overflow: auto;
    }

    #result .header-buyer-details {
        text-align: center;
        font-weight: bold;
        background-color: #0033CC;
        color: white;
    }

    #result .header-total-generation {
        text-align: center;
        font-weight: bold;
        background-color: #66CCFF;
    }

    #result .header-adjustments {
        text-align: center;
        font-weight: bold;
        background-color: #66FF66;
    }

    #result .header-others {
        text-align: center;
        font-weight: bold;
        background-color: #999966;
    }

    #tbl_buyer_names th, #tbl_data_details th {
        font-weight: bold;
        text-align: center;
        min-width:150px;
    }

    .table_buyer_names {
        float: left;
        width: 200px;
    }
    .table_details_container {
        width: 600px;
        overflow: auto;
    }
</style>

<script src="../js/date.js"></script>
<script type="text/javascript">
    var INVOICE_SUMMARY = {
         data : null
        ,confirmed : false
        ,mapping : {
            'usd' :
              [
                   { 'key' : 'contracted_capacity', 'decimal_places' : 2 , 'suffix' : '' }
                  ,{ 'key' : 'total_quantity', 'decimal_places' : 2 , 'suffix' : '' }
                  ,{ 'key' : 'computed_capacity_factor', 'decimal_places' : 2 , 'suffix' : '' }
                  ,{ 'key' : 'min_capacity_factor', 'decimal_places' : 2, 'suffix' : '%' }
                  ,{ 'key' : 'resulting_capacity_factor', 'decimal_places' : 2, 'suffix' : '%' }
                  ,{ 'key' : 'capacity_fee', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'initial_energy_fee_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'base_cif_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'actual_cif_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'energy_fee_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'adjustment_due_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'net_energy_fee_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'contract_fee_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'contract_price_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'ppd_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'fx_adjustments_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'market_fees_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'market_fees_adjustment_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'redelivered_quantity', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'redelivered_quantity_deficiency', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'energy_fee_adjustment_rq_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'energy_fee_payment_due_deficiency_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'delivery_charges_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'other_charges_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'total_vatable_charges_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'benefit_host_communities_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'benefit_host_communities_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'total_net_charges_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'vat_usd', 'decimal_places' : 2, 'suffix' : '' }
                  ,{ 'key' : 'total_charges_usd', 'decimal_places' : 2, 'suffix' : '' }
              ]
            ,'php' : [
                { 'key' : 'contracted_capacity', 'decimal_places' : 2 , 'suffix' : '' }
                ,{ 'key' : 'total_quantity', 'decimal_places' : 2 , 'suffix' : '' }
                ,{ 'key' : 'computed_capacity_factor', 'decimal_places' : 2 , 'suffix' : '' }
                ,{ 'key' : 'min_capacity_factor', 'decimal_places' : 2, 'suffix' : '%' }
                ,{ 'key' : 'resulting_capacity_factor', 'decimal_places' : 2, 'suffix' : '%' }
                ,{ 'key' : 'capacity_fee_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'initial_energy_fee_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'base_cif_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'actual_cif_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'energy_fee_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'adjustment_due_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'net_energy_fee_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'contract_fee_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'contract_price_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'ppd_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'fx_adjustments_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'market_fees_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'market_fees_adjustment_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'redelivered_quantity', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'redelivered_quantity_deficiency', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'energy_fee_adjustment_rq_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'energy_fee_payment_due_deficiency_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'delivery_charges_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'other_charges_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'total_vatable_charges_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'benefit_host_communities_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'benefit_host_communities_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'total_net_charges_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'vat_php', 'decimal_places' : 2, 'suffix' : '' }
                ,{ 'key' : 'total_charges_php', 'decimal_places' : 2, 'suffix' : '' }
                ]
        }
    };
    $.extend({
         validateAndGenerateParameters : function(){
             var billing_month = $.trim($('#month').val())
                 ,billing_year =$.trim($('#year').val())
                 ,availability = $.trim($('#txt_availability').val())
                 ,market_fees = $.trim($('#txt_market_fees').val())
                 ,ra_7638 = $.trim($('#txt_ra_7638').val())
                 ,initial_energy_fee = $.trim($('#txt_initial_energy_fee').val())
                 ,base_cif = $.trim($('#txt_base_cif').val())
                 ,actual_cif = $.trim($('#txt_actual_cif').val())
                 ,energy_fee = $.trim($('#txt_energy_fee').val())
                 ,adjustment_due = $.trim($('#txt_adj_dues_import').val())
                 ,forex_rates = $.trim($('#txt_forex_rates').val());
             var error_messages = [];
             var is_valid = true;
             var message = '';


             // validate entries first
             if ( billing_month.length <= 0 ) {
                 error_messages.push('Billing Month should not be empty.');
             }

             if ( billing_year.length <= 0 ) {
                 error_messages.push('Billing Year should not be empty.');
             }

             if ( availability.length <= 0 ) {
                 error_messages.push('Availability should not be empty.');
             }

             if ( market_fees.length <= 0 ) {
                 error_messages.push('Market Fees should not be empty.');
             }

             if ( ra_7638.length <= 0 ) {
                 error_messages.push('RA 7638 should not be empty.');
             }

             if ( initial_energy_fee.length <= 0 ) {
                 error_messages.push('Initial Energy Fee should not be empty.');
             }

             if ( base_cif.length <= 0 ) {
                 error_messages.push('Base CIF should not be empty.');
             }

             if ( actual_cif.length <= 0 ) {
                 error_messages.push('Actual CIF should not be empty.');
             }

             if ( energy_fee.length <= 0 ) {
                 error_messages.push('Energy Fee should not be empty.');
             }

             if ( adjustment_due.length <= 0 ) {
                 error_messages.push('Adjustment Due should not be empty.');
             }

             if ( forex_rates.length <= 0 ) {
                 error_messages.push('Forex_Rates should not be empty.');
             }
             // end of validation

             if ( error_messages.length > 0  ) {
                 message = 'Please check the following entry issue/s\n- ' + error_messages.join('\n - ');
                 is_valid = 0;
             }else {
                 message = '';
                 is_valid = 1;
             }

             var parameters = {};
             parameters['action'] = 'submit-precalc-entries';
             parameters['billing_month'] = billing_month;
             parameters['billing_year'] = billing_year;
             parameters['availability'] = availability;
             parameters['market_fees'] = market_fees;
             parameters['ra_7638'] = ra_7638;
             parameters['initial_energy_fee'] = initial_energy_fee;
             parameters['base_cif'] = base_cif;
             parameters['actual_cif'] = actual_cif;
             parameters['energy_fee'] = energy_fee;
             parameters['adjustment_due'] = adjustment_due;
             parameters['forex_rates'] = forex_rates;

             return {
                 'parameters' : parameters
                 ,'is_valid'  : is_valid
                 ,'message' : message
             };

         }
        ,populateCustomersInvoices : function(customer_data_list){
            /*$('#fldst_preinvoice_summary_loader').html('');
            $('#tbl_results tr:gt(1)').remove();
            var customer_obj = null;
            var contents = '';
            var key = $('#cmb_currency').val();
            var mapping = INVOICE_SUMMARY.mapping[key];
            var map_obj = null;
            var data_key = null;
            var data_value = null;
            var display_value = '';
            var decimal_places = 0;
            var suffix_char = '';

            for (var i=0;i<customer_data_list.length;i++){
                customer_obj = customer_data_list[i];
                contents+='<tr><td style="min-width: 250px;">'+ customer_obj.customer_name +'</td>';

                for (var m=0;m<mapping.length;m++){
                    map_obj = mapping[m];
                    data_key = map_obj['key'];
                    decimal_places = typeof map_obj['decimal_places'] != 'undefined' ? parseInt(map_obj['decimal_places'],10) : 0;
                    suffix_char = typeof map_obj['suffix'] != 'undefined' ? map_obj['suffix'] : '';
                    data_value = typeof customer_obj[data_key] != 'undefined' ? customer_obj[data_key] : null;
                    if ( data_value != null ) {
                        data_value = parseFloat(data_value);
                        display_value = $.formatNumberToSpecificDecimalPlaces(data_value,decimal_places) + ' ' + suffix_char;
                    }else {
                        display_value = '';
                    }
                    contents += '<td class="data_content" >'+ display_value +'</td>';

                }
                contents += '</tr>';
            }
            $('#tbl_results').hide().append(contents).show('slow');*/

            $('#fldst_preinvoice_summary_loader').html('');
            $('#tbl_buyer_names tr:gt(2)').remove();
            $('#tbl_data_details tr:gt(2)').remove();
            var customer_obj = null;
            var contents_buyers = '';
            var contents = '';
            var key = $('#cmb_currency').val();
            var mapping = INVOICE_SUMMARY.mapping[key];
            var map_obj = null;
            var data_key = null;
            var data_value = null;
            var display_value = '';
            var decimal_places = 0;
            var suffix_char = '';

            for (var i=0;i<customer_data_list.length;i++){
                customer_obj = customer_data_list[i];
                contents_buyers+='<tr><td style="min-width: 200px;">'+ customer_obj.customer_name +'</td></tr>';
                contents+='<tr>';
                for (var m=0;m<mapping.length;m++){
                    map_obj = mapping[m];
                    data_key = map_obj['key'];
                    decimal_places = typeof map_obj['decimal_places'] != 'undefined' ? parseInt(map_obj['decimal_places'],10) : 0;
                    suffix_char = typeof map_obj['suffix'] != 'undefined' ? map_obj['suffix'] : '';
                    data_value = typeof customer_obj[data_key] != 'undefined' ? customer_obj[data_key] : null;
                    if ( data_value != null ) {
                        data_value = parseFloat(data_value);
                        display_value = $.formatNumberToSpecificDecimalPlaces(data_value,decimal_places) + ' ' + suffix_char;
                    }else {
                        display_value = '';
                    }
                    contents += '<td class="data_content" >'+ display_value +'</td>';

                }
                contents += '</tr>';
            }


            var result_w = $('#result').width();
            //var result_dtl_container_w = result_w - 230;
            $('.table_details_container').css('width','77%');
            $('span[name="currency"]').html(key.toUpperCase());
            $('#tbl_buyer_names').hide().append(contents_buyers).show();
            $('#tbl_data_details').hide().append(contents).show('slow');
        }
        ,submitPreCalcEntriesAndCompute : function(){
             var validate_obj = $.validateAndGenerateParameters();
             var parameters = validate_obj.parameters;

            if ( validate_obj.message.length > 0  ) {
                alert('Please check the following entry issue/s\n- ' + validate_obj.message.join('\n - '));
            }else {
                $('#fldst_preinvoice_summary_loader').html('Please wait while we submit pre-computation entries on invoice summary <img src="../images/ajax-loader.gif"/>');
                $('#btn_compute').attr('disabled',true);
                $('#cmb_currency option:first-child').attr("selected", "selected");

                $.ajax({
                    type: "POST"
                    ,url: '../billing/invoice_summary_action'
                    ,async : true
                    ,data: parameters
                    ,success: function(data){
                        if ( data.success === 1 ) {
                            var validate_obj = $.validateAndGenerateParameters();
                            var parameters = validate_obj.parameters;
                            parameters['action'] = 'compute';

                            $('#fldst_preinvoice_summary_loader').html('Please wait while we compute invoice summary <img src="../images/ajax-loader.gif"/>');
                            $('#btn_compute').attr('disabled',true);

                            $.ajax({
                                type: "POST"
                                ,url: '../billing/invoice_summary_action'
                                ,async : true
                                ,data: parameters
                                ,success: function(data){
                                    INVOICE_SUMMARY.data = data.value;
                                    $.populateCustomersInvoices(data.value);
                                    $('#btn_compute').removeAttr('disabled');
                                    $('#fldst_preinvoice_summary').hide();
                                    $('#fldst_invoice_summary_results').show('slow');
                                    $('#result_loader').html('');
                                }
                            });


                        }else {
                            alert(data.message);
                            $('#btn_compute').removeAttr('disabled');
                            $('#fldst_preinvoice_summary_loader').html('');
                        }

                    }
                });
            }
        }

        ,submitInvoiceSummaryData : function(){
            var validate_obj = $.validateAndGenerateParameters();
            var parameters = validate_obj.parameters;
            parameters['action'] = 'submit-invoice';

            $('#result_loader').html('Please wait while we save invoice summary <img src="../images/ajax-loader.gif"/>');
            $('#btn_confirm').attr('disabled',true);
            $('#btn_confirm').attr('disabled',true);
            $.ajax({
                type: "POST"
                ,url: '../billing/invoice_summary_action'
                ,async : true
                ,data: parameters
                ,success: function(data){
                    alert(data.message);
                    $('#result_loader').html('');
                    $('#btn_confirm').removeAttr('disabled');
                }
            });
        }
        ,getInvoiceSummaryData : function(){
            var billing_month = $.trim($('#month').val())
                ,billing_year =$.trim($('#year').val());

            var parameters = {};
            parameters['action'] = 'get-data';
            parameters['billing_month'] = billing_month;
            parameters['billing_year'] = billing_year;
            $('#fldst_preinvoice_summary_loader').html('Please wait while checking if with saved data <img src="../images/ajax-loader.gif"/>');
            $.ajax({
                type: "POST"
                ,url: '../billing/invoice_summary_action'
                ,async : true
                ,data: parameters
                ,success: function(data){

                    var availability = ''
                        ,market_fees = ''
                        ,ra_7638 = ''
                        ,initial_energy_fee = ''
                        ,base_cif = ''
                        ,actual_cif = ''
                        ,energy_fee = ''
                        ,adjustment_due = ''
                        ,forex_rates = '';

                    if ( data.value.with_data > 0 ) {
                        availability = $.formatNumberToSpecificDecimalPlaces(parseFloat(data.value.data.availability),5);
                        market_fees = $.formatNumberToSpecificDecimalPlaces(parseFloat(data.value.data.market_fees),13);
                        ra_7638 = $.formatNumberToSpecificDecimalPlaces(parseFloat(data.value.data.ra_7638),5);
                        initial_energy_fee = $.formatNumberToSpecificDecimalPlaces(parseFloat(data.value.data.initial_energy_fee),5);
                        base_cif = $.formatNumberToSpecificDecimalPlaces(parseFloat(data.value.data.base_cif),5);
                        actual_cif = $.formatNumberToSpecificDecimalPlaces(parseFloat(data.value.data.actual_cif),5);
                        energy_fee = $.formatNumberToSpecificDecimalPlaces(parseFloat(data.value.data.energy_fee),5);
                        adjustment_due = $.formatNumberToSpecificDecimalPlaces(parseFloat(data.value.data.adjustment_due),5);
                        forex_rates = $.formatNumberToSpecificDecimalPlaces(parseFloat(data.value.data.forex_rates),5);
                    }

                    if ( parseInt(data.value.confirmed,10) > 0 ) {
                        $('#btn_compute').hide();
                        $('#btn_view_invoice').show();
                        $('#btn_confirm').hide();
                        INVOICE_SUMMARY.confirmed = 1;
                    } else {
                        $('#btn_compute').show();
                        $('#btn_view_invoice').hide();
                        $('#btn_confirm').show();
                        INVOICE_SUMMARY.confirmed = 0;
                    }

                    $('#txt_availability').attr('value',availability);
                    $('#txt_market_fees').attr('value',market_fees);
                    $('#txt_ra_7638').attr('value',ra_7638);
                    $('#txt_initial_energy_fee').attr('value',initial_energy_fee);
                    $('#txt_base_cif').attr('value',base_cif);
                    $('#txt_actual_cif').attr('value',actual_cif);
                    $('#txt_energy_fee').attr('value',energy_fee);
                    $('#txt_adj_dues_import').attr('value',adjustment_due);
                    $('#txt_forex_rates').attr('value',forex_rates);
                    $('#fldst_preinvoice_summary_loader').html('');
                }
            });
        }
        ,viewConfirmInvoices : function(){
            var validate_obj = $.validateAndGenerateParameters();
            var parameters = validate_obj.parameters;
            parameters['action'] = 'get-list-confirmed-customer-invoice-summary';
            $('#result_loader').html('Please wait while we save invoice summary <img src="../images/ajax-loader.gif"/>');
            $.ajax({
                type: "POST"
                ,url: '../billing/invoice_summary_action'
                ,async : true
                ,data: parameters
                ,success: function(data){
                    INVOICE_SUMMARY.data = data.value;
                    $.populateCustomersInvoices(data.value);
                    $('#fldst_preinvoice_summary').hide();
                    $('#fldst_invoice_summary_results').show('slow');
                    $('#result_loader').html('');
                }
            });
        }

        ,exportToExcel : function(){
            var validate_obj = $.validateAndGenerateParameters();
            var parameters = validate_obj.parameters;

            if ( validate_obj.message.length > 0  ) {
                alert('Please check the following entry issue/s\n- ' + validate_obj.message.join('\n - '));
            }else {
                $('#fldst_preinvoice_summary_loader').html('Please wait while we submit pre-computation entries on invoice summary <img src="../images/ajax-loader.gif"/>');
                $('#btn_compute').attr('disabled',true);
                var str_parameters = '';

                for(var key in parameters){
                    var attrName = key;
                    var attrValue = parameters[key];

                    if (str_parameters.length >0) {
                        str_parameters+='&';
                    }
                    str_parameters+= attrName +'=' + attrValue;
                }
                $.download('../billing/file_invoice_summary',parameters);


            }
        }
    });
    $(document).ready(function(){

        $("#txt_availability").numeric();
        $('#txt_market_fees').numeric();
        $('#txt_ra_7638').numeric();
        $('#txt_initial_energy_fee').numeric();
        $('#txt_base_cif').numeric();
        $('#txt_actual_cif').numeric();
        $('#txt_energy_fee').numeric();
        $('#txt_adj_dues_import').numeric();
        $('#txt_forex_rates').numeric();

        $('#fldst_preinvoice_summary_loader').html('');
        $('#btn_compute').unbind().bind('click',function(){
            if ( INVOICE_SUMMARY.confirmed === 0 ) {
                $.submitPreCalcEntriesAndCompute();
            }
        });

        $('#month').unbind().bind('change',function(){
            $.getInvoiceSummaryData();
        });

        $('#year').unbind().bind('change',function(){
            $.getInvoiceSummaryData();
        });

        $('#cmb_currency').unbind().bind('change',function(){
            $.populateCustomersInvoices(INVOICE_SUMMARY.data);
        });


        $('#btn_go_back').unbind().bind('click',function(){
            $('#fldst_invoice_summary_results').hide();
            $('#fldst_preinvoice_summary').show('slow');
        });

        $('#btn_confirm').unbind().bind('click',function(){

            if ( INVOICE_SUMMARY.confirmed === 0 ) {
                var r=confirm("Are you sure you want to confirm this Billing Period Invoice Summary?");
                if (r==true){
                    $.submitInvoiceSummaryData();
                }
            }
        });

        $('#btn_export_xls').unbind().bind('click',function(){

            if ( INVOICE_SUMMARY.confirmed === 0 ) {
                $.exportToExcel();
            }
        });



        $('#btn_view_invoice').unbind().bind('click',function(){
            $.viewConfirmInvoices();

        });



        $('#month').trigger('change');

        var container_width = $(document).width() - 300;
        $('#result').css('width',container_width+'px');
    });
</script>