<style>
.table th, .table td {
    vertical-align: middle;
}

table.tbl_power_bill {
    border: 1px solid #F9F9F9;
    border-radius: 4px;
}
table.tbl_power_bill th {
    text-align: left;
    background-color: #F7F4F4;
}

div.formula {
    background-color: #EAF3F7;
    padding:10px;
    font-size:11px;
}

td.subtable table.noformatting td {
    border:none;
    background-color: transparent;
}

table.noformatting td {
    border:none;
    background-color: transparent;
}

#tbl_incidentals td {
    border:none;
    background-color: transparent;
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
            <div id="loader"></div>
            <form id="form_psc_rate" name="form_power_bill" >
                <table class="table table-striped tbl_power_bill">
                <tr>
                    <td style="width:20%;">Power Bill Type</td>
                    <td style="width:30%;"><input type="radio" name="power_bill_type" checked="true" value="default"> Default 
                        &nbsp;&nbsp;&nbsp;<input type="radio" name="power_bill_type" value="incidental"> Incidental</td>
                    <td>&nbsp;</td>
                    <td style="width:15%;"></td>
                    <td style="width:30%;"></td>
                </tr>
                
                
                <tr>
                    <td>Date Prepared</td>
                    <td><input type="text" id="date_prepared" name="date_prepared" value="<? echo date('m/d/Y');?>" class="input-medium"></td>
                    <td>&nbsp;</td>
                    <td>Due Date</td>
                    <td><input type="text" disabled="true" value="" class="input-medium" id="disp_due_date">
                        <input type="hidden" name="due_date" id="due_date" /></td>
                </tr>
                
                <tr>
                    <td>Billing Period</td>
                    <td>
                        <div class="span3 input-append input-prepend">
                            <input type="text" id="sdate" name="date" value="<?=$def_sdate?>" class="input-small"><span class="add-on">to</span>
                            <input type="text" id="edate" name="date" value="<?=$def_edate?>" class="input-small">
                        </div>
                        <div style="margin-top: 5px;">
                            <span class="error-note" id="date_range_error"></span>
                        </div>
                    </td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                </tr>
                
                <tr>
                    <td>Customer Name</td>
                    <td>
                        <select name="customer" id="customer" class="input-xlarge">
                            <?php
                               foreach ($customer_list as $customer) {
                                  echo '<option value="'.$customer['name'].'" customer_type="'.$customer['customer_type'].'" psc_type="'.$customer['psc_type'].'" tax_type="'.$customer['tax_type'].'">'.$customer['customer_full_name'].'</option>';     
                               }
                            ?>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                    <td>Customer Type </td>
                    <td><input type="text" disabled="true" value="" class="input-medium" id="disp_customer_type">
                        <input type="hidden" name="customer_type" id="customer_type" /></td>
                </tr>
                
                <tr>
                    <td>Tax Type</td>
                    <td><input type="hidden" name="tax_type" id="tax_type" />
                        <input disabled="true" type = "radio" name = "disp_tax_type"  value = "vatable"/> Vatable
                        &nbsp;&nbsp;<input disabled="true" type = "radio" name = "disp_tax_type" value = "vatable*"/> Vatable *
                        &nbsp;&nbsp;<input disabled="true" type = "radio" name = "disp_tax_type" value = "zero_rated"/> Zero Rated 
                    </td>
                    <td>&nbsp;</td>
                    <td>PSC Type </td>
                    <td><input type="text" disabled="true" value="" class="input-medium" id="disp_psc_type">
                        <input type="hidden" name="psc_type" id="psc_type" /></td>
                </tr>
                
                <tr name="incident_row" style="display:none;">
                    <td colspan="5" style="padding:0px;" class="subtable">
                        <table width="100%" class="noformatting table-condensed" id="tbl_incidents">
                            <tr><td><h6>Incidentals</h6></td></tr>
                            <tr><td style="border-bottom:1px dotted #2F96B4; border-top:1px dotted #2F96B4;">
                                <table width="100%" class="noformatting table-condensed">
                                     <tr>
                                        <td style="min-width:20%;">Date Covered</td>
                                        <td style="min-width:32%;">
                                             <input type="text" id="sdate_covered1" name="sdate_covered1" value="" class="input-small date_covered"><span class="add-on"> to </span>
                                             <input type="text" id="edate_covered1" name="edate_covered1" value="" class="input-small  date_covered">
                                        </td>
                                        <td>&nbsp;</td>
                                        <td  style="min-width:15%;"></td>
                                        <td></td>
                                    </tr>  
                                    <tr>
                                        <td style="min-width:20%;">HCQ</td>
                                        <td style="min-width:32%;">
                                            <input type="text" value="" class="input-medium numeric incidental_input" id="hcq1">
                                        </td>
                                        <td>&nbsp;</td>
                                        <td  style="min-width:15%;">Price</td>
                                        <td><input type="text" value="" class="input-medium numeric incidental_input" id="kscp_price1"></td>
                                    </tr> 
                                </table>
                            </td>
                            </tr>
                            
                            <tr><td style="border-bottom:1px dotted #2F96B4; border-top:1px dotted #2F96B4;">
                                <table width="100%" class="noformatting table-condensed">
                                     <tr>
                                        <td style="min-width:20%;">Date Covered</td>
                                        <td style="min-width:32%;">
                                             <input type="text" id="sdate_covered2" name="sdate_covered2" value="" class="input-small date_covered"><span class="add-on"> to </span>
                                             <input type="text" id="edate_covered2" name="edate_covered2" value="" class="input-small  date_covered">
                                        </td>
                                        <td>&nbsp;</td>
                                        <td  style="min-width:15%;"></td>
                                        <td></td>
                                    </tr>  
                                    <tr>
                                        <td style="min-width:20%;">HCQ</td>
                                        <td style="min-width:32%;">
                                            <input type="text" value="" class="input-medium numeric incidental_input" id="hcq2">
                                        </td>
                                        <td>&nbsp;</td>
                                        <td  style="min-width:15%;">Price</td>
                                        <td><input type="text" value="" class="input-medium numeric incidental_input" id="kscp_price2"></td>
                                    </tr> 
                                </table>
                            </td>
                            </tr>
                            
                            <tr><td><button type="button" id="btn_add_incident" class="btn btn-info btn-small" ><i class="icon-plus"></i>Add Incident</button></td></tr>
                        </table>
                    </td>
                   
                </tr>
                <tr name="incident_row">
                    <td>Total Final HCQ (A+B)</td>
                    <td><input type="text" disabled="true" value="" class="input-medium" id="disp_incidental_total_final_hcq">
                        <input type="hidden" name="incidental_total_final_hcq" id="incidental_total_final_hcq" />
                        
                    </td>
                    <td>&nbsp;</td>
                    <td>Weighted Average Price </td>
                    <td><input type="text" disabled="true" value="" class="input-medium" id="disp_incidental_kspc_price">
                        <input type="hidden" name="incidental_kspc_price" id="incidental_kspc_price" /></td>
                </tr>
                <tr name="default_row">
                    <td>Total Final HCQ Source</td>
                    <td>
                        <input type = "radio" name = "hcq_source" value = "nomination"/> Nominations
                        &nbsp;&nbsp;<input checked="true" type = "radio" name = "hcq_source" value = "declaration"/> Declaration
                    </td>
                    <td>&nbsp;</td>
                    <td>Total Final HCQ </td>
                    <td><input type="text" disabled="true" value="" class="input-medium" id="disp_total_final_hcq">
                        <input type="hidden" name="total_final_hcq" id="total_final_hcq" /></td>
                </tr>
                
                <tr  name="default_row">
                    <td>PSC Rate</td>
                    <td>
                        <input type="text" disabled="true" value="" class="input-medium" id="disp_psc_rate">
                        <input type="hidden" name="psc_rate" id="psc_rate" /> P/kWh
                    </td>
                    <td name='col_contract_quantity_colspan'>&nbsp;</td>
                    <td name='col_contract_quantity'>Contract Quantity </td>
                    <td name='col_contract_quantity'><input type="text" value="" class="input-medium numeric" id="contract_quantity"></td>
                </tr>
                
                 <tr name='col_load_factor'>
                    <td>Load Factor Price</td>
                    <td><input type="hidden" value="" class="input-medium" id="kspc_load_factor_price" class="numeric">
                        <input type="text" value="" disabled="true"  class="input-medium" id="disp_kspc_load_factor_price" class="numeric">P/kWh
                    </td>
                    <td>&nbsp;</td>
                    <td>Load Factor </td>
                    <td ><input type="hidden" value=""id="load_factor">
                        <input type="text" disabled="true" value="" class="input-medium numeric" id="disp_load_factor">% </td>
                </tr>
                
                
                <tr >
                    <th colspan="5" class="impt">Previous Billing Period</th>
                </tr>
                
                <tr >
                    <td>Total Final HCQ</td>
                    <td><input type="text" value="" disabled="true" class="input-medium" id="disp_prev_total_final_hcq" class="numeric">
                        <input type="hidden" value="" class="input-medium" id="prev_total_final_hcq" class="numeric"> P/kWh
                    </td>
                    <td>&nbsp;</td>
                    <td>Market Fee </td>
                    <td ><input type="text" value="" class="input-medium" id="market_fee"> P/kWh </td>
                </tr>
                
                
                 <tr >
                    <td>Revision</td>
                    <td>
                        <input type="text" class="input-medium" name="revision" id="revision"  />
                    </td>
                    <td>&nbsp;</td>
                    <td>Power Bill Number </td>
                    <td ><input type="text" disabled="true" value="" class="input-medium" id="disp_power_bill_no">
                        <input type="hidden" name="power_bill_no" id="power_bill_no" /></td>
                </tr>
                
                <tr name='col_zero_rate_deduction'>
                    <td>Zero Rate Vat* Deduction </td>
                    <td><input type="text" value="" class="input-medium numeric" id="zero_rate_vat_deduction">
                    </td>
                    <td>&nbsp;</td>
                    <td> </td>
                    <td </td>
                </tr>
            </table>
            <br>    
            <br>
            <table class="table table-condensed noformatting">
                <tr>
                    <td style="width:25%;">Prepared By : </td>
                    <td style="width:25%;">Reviewed By : </td>
                    <td style="width:25%;">Noted By : </td>
                    <td style="width:25%;">Approved By : </td>
                </tr>
                <tr>
                    <td colspan="4"> </td>
                </tr>
                <tr>
                    <td style="width:25%;font-weight:bold;"><? echo $current_user_fullname; ?></td>
                    <td style="width:25%;font-weight:bold;"><? echo $power_bill_settings['reviewer_fullname'];?></td>
                    <td style="width:25%;font-weight:bold;"><? echo $power_bill_settings['noted_by_fullname'];?></td>
                    <td style="width:25%;font-weight:bold;"><? echo $power_bill_settings['approver_fullname'];?></td>
                </tr>
                
                <tr>
                    <td style="width:25%;">B/S Officer</td>
                    <td style="width:25%;">B/C Officer</td>
                    <td style="width:25%;">A/M Marketing</td>
                    <td style="width:25%;">Marketing Manager</td>
                </tr>
                
            </table>
            
            <br>
            <div style="text-align:center;" id="create_power_bill_button"></div>
            <br>
            <div class="alert alert-success" id="create_power_bill_status">
                Successfully created power bill 
                <br>
                <button type="button" class="btn btn-success" ><i class="icon-download"></i>Export to PDF</button>
            </div>
            </form>
            
            
            
            
    </section>
    
    
</div>


<div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <h7>Please wait, calculating HCQ data</h7>
    </div>
    <div class="modal-body">
        <div class="progress progress-striped active">
            <div class="bar" style="width: 100%;"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var powerBill;
    TOTAL_INCIDENTS = 0;
    powerBill = powerBill || (function () {
        var pleaseWaitDiv = $('<div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false"><div class="modal-header"><h4>Please wait...</h4></div><div class="modal-body"><div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div></div></div>');
        return {
            showPleaseWait: function() {
                pleaseWaitDiv.modal();
            },
            hidePleaseWait: function () {
                pleaseWaitDiv.modal('hide');
            },

        };
    })();

    $.extend({
        validateDateRange : function(sdate_obj,edate_obj){
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
        } // eof 
        ,computeDueDate : function(){
            var sdate = $('#sdate').val();
            var billing_period = $.getBillingPeriodByDate(sdate);
            var mn = billing_period['billing_month'];
            var yr = billing_period['billing_year'];
            var tmp = Date.parse(yr+'-'+mn+'-05');
            var due_date = tmp.add(1).months().toString('MM/25/yyyy');
            $('#disp_due_date').val(due_date);
            $('#due_date').val(due_date);
        }
        ,getBillingPeriodByDate : function(d){
            var dte = Date.parse(d);
            var mn = dte.toString('M');
            var yr = dte.toString('yyyy')
            var dy = parseInt(dte.toString('dd'),10);
            
            if (dy >= 26) {
                var nxt_month = dte.add(1).months();
                yr = nxt_month.toString('yyyy')
                dy = parseInt(nxt_month.toString('dd'),10);
                mn = nxt_month.toString('M');
                
            }
            return {
                'billing_month' : mn
               ,'billing_year'  : yr     
           };
        } // 
        ,getPowerBillDetails : function(){
            
            $('#disp_total_final_hcq').val('');
            $('#total_final_hcq').val('');
            $('#disp_psc_rate').val('');
            $('#psc_rate').val('');        
            $('#revision').val('');        
            $('#disp_power_bill_no').val('');
            $('#power_bill_no').val('');  
            $('#disp_power_bill_no').val('');
            $('#power_bill_no').val('');  
            
            $('#disp_prev_total_final_hcq').val('');
            $('#prev_total_final_hcq').val('');  
            
            $('#contract_quantity').val('');  
            $('#market_fee').val('');  
            $('#zero_rate_vat_deduction').val('');  
            $('#kspc_load_factor_price').val('');  
            $('#disp_kspc_load_factor_price').val('');  
            $('#load_factor').val('');  
            $('tr[name=incidental_detail_row]').remove();
            $('#create_power_bill_button').html('');
            $('#create_power_bill_status').html('').removeAttr('class');
            $('#loader').html('').removeAttr('class');
            powerBill.showPleaseWait();
            var parameters = {};
            parameters['hcq_source'] = $("input:radio[name=hcq_source]:checked").val();
            parameters['customer'] = $('#customer').val();
            parameters['sdate'] = $('#sdate').val();
            parameters['edate'] = $('#edate').val();
            parameters['revision'] = $("#revision").val();
            parameters['type'] = $("input:radio[name=power_bill_type]:checked").val();
            
            
            $.ajax({
             type: "POST"
             ,url : '<?=$base_url?>/power_bill/power_bill_get_details'
             ,dataType:'json'
             ,data:parameters
             ,async: true
             ,cache: false
             ,timeout: 30000
             ,success: function(ret){
                 var success = parseInt(ret.success,10);
                var message = ret.message;
                var data = ret.value;
                var is_with_export_pdf = parseInt(ret.is_with_export_pdf,10);
                
                // load data 
                $('#disp_psc_rate').val($.formatNumberToSpecificDecimalPlaces(data.psc_rate,4));
                // --- akel $('#psc_rate').val($.formatNumberToSpecificDecimalPlaces(data.psc_rate,4)); 
                $('#psc_rate').val(data.psc_rate); 
                var total_delivered = parseFloat(data.total_delivered);
                if (total_delivered < 0) {
                    $('#disp_total_final_hcq').val('');
                }else {
                    $('#disp_total_final_hcq').val($.formatNumberToSpecificDecimalPlaces(data.total_delivered,5));
                }
                
                $('#total_final_hcq').val($.formatNumberToSpecificDecimalPlaces(data.total_delivered,5));
                
                var prev_billing_total_final_hcq = parseFloat(data.prev_billing_total_final_hcq);
                console.log(prev_billing_total_final_hcq)
                if (prev_billing_total_final_hcq < 0) {
                    $('#disp_prev_total_final_hcq').val('');
                }else {
                    $('#disp_prev_total_final_hcq').val($.formatNumberToSpecificDecimalPlaces(data.prev_billing_total_final_hcq,5));
                }
                
                
                $('#prev_total_final_hcq').val($.formatNumberToSpecificDecimalPlaces(data.prev_billing_total_final_hcq,5));  
                $('#revision').val(data.revision);       
                $('#date_prepared').val(data.date_prepared)
                $('#market_fee').val($.formatNumberToSpecificDecimalPlaces(data.market_fee,16));  
                $('#contract_quantity').val($.formatNumberToSpecificDecimalPlaces(data.contract_quantity,5));  
                $('#zero_rate_vat_deduction').val($.formatNumberToSpecificDecimalPlaces(data.zero_rate_vat_deduction,5));  
                $('#kspc_load_factor_price').val(data.kspc_load_factor_price);  
                $('#disp_kspc_load_factor_price').val($.formatNumberToSpecificDecimalPlaces(data.kspc_load_factor_price,5));  
                $('#load_factor').val($.formatNumberToSpecificDecimalPlaces(data.load_factor,5));  

                if (success === 1) {
                                
                    $('#disp_power_bill_no').val(data.power_bill_no);
                    $('#power_bill_no').val(data.power_bill_no);  
                    $('#revision').val(data.revision);  
                    $('#create_power_bill_button').html('<button type="button" id="btn_create_power_bill" class="btn btn-primary" ><i class="icon-file"></i>Create Power Bill</button>');
                    
                    var total_incident = parseInt(data.total_incident,10);
                    
                    $('#sdate_covered1').val('');
                    $('#edate_covered1').val('');
                    $('#hcq1').val('');
                    $('#kscp_price1').val('');

                    $('#disp_incidental_total_final_hcq').val('');
                    $('#incidental_total_final_hcq').val('');
                    $('#disp_incidental_kspc_price').val('');
                    $('#incidental_kspc_price').val('');
                    if (total_incident > 0){
                        $('tr[name=incidental_detail_row]').remove();
                        var incidents = $.parseJSON(data.incidents);
                        var total_incidents = incidents.length;
                        var row_ctr = 1;
                        for ( var i=0;i<total_incident;i++) {
                            if (row_ctr > 2) {
                                $('#btn_add_incident').trigger('click');
                            }
                            
                            $('#sdate_covered'+row_ctr).val(incidents['sdate_'+row_ctr]);
                            $('#edate_covered'+row_ctr).val(incidents['edate_'+row_ctr]);
                            var hcq = incidents['hcq_'+row_ctr];
                            var kscp_price = incidents['price_'+row_ctr];
                            
                            $('#hcq'+row_ctr).val($.formatNumberToSpecificDecimalPlaces(hcq,5));
                            $('#kscp_price'+row_ctr).val($.formatNumberToSpecificDecimalPlaces(kscp_price,5));
                                
                            row_ctr++;
                        }
                        $.calculateIndicidentalTotalHCQandKSPCPRice();
                    }
                    $('#btn_create_power_bill').unbind().bind('click',function(){
                        $.generatePowerBill();
                    });
                    
                    if (is_with_export_pdf === 1) {
                        var html = '<button type="button" id="btn_export_pdf" class="btn btn-success" ><i class="icon-download"></i>Export to PDF</button>';
                        $('#create_power_bill_status').html(html).attr('class','alert alert-success');
                    }else {
                        $('#create_power_bill_status').html('').removeAttr('class');
                    }
                    
                            
                }else {
                    $('#loader').html(message).addClass('alert').addClass('alert-error');
                    $('#btn_create_power_bill').unbind();
                }
                powerBill.hidePleaseWait();
                 $('#contract_quantity').trigger('change');
                 //$("input:radio[name=power_bill_type]").trigger('change');
                 powerBill.hidePleaseWait();
             }
             ,error: function(x, t, m) {
                if(t==="timeout") {
                    bootbox.alert('Timeout error due to slow response.<br>Please check your internet connection or click Refresh to try again');
                } else {
                    bootbox.alert('An error encountered while getting data. ');
                }
            }
             /*,error: function(jqXHR, textStatus, errorThrown){
                
                 console.log("Error on accessing webservice data " + jqXHR.responseText );
                 powerBill.hidePleaseWait();
             }*/
         });
            /*
            $.post('../power_bill/power_bill_get_details', parameters,
            function(ret) {
                var success = parseInt(ret.success,10);
                var message = ret.message;
                var data = ret.value;
                var is_with_export_pdf = parseInt(ret.is_with_export_pdf,10);
                
                // load data 
                $('#disp_psc_rate').val($.formatNumberToSpecificDecimalPlaces(data.psc_rate,4));
                $('#psc_rate').val($.formatNumberToSpecificDecimalPlaces(data.psc_rate,4)); 
                $('#disp_total_final_hcq').val($.formatNumberToSpecificDecimalPlaces(data.total_delivered,5));
                $('#total_final_hcq').val($.formatNumberToSpecificDecimalPlaces(data.total_delivered,5));
                $('#disp_prev_total_final_hcq').val($.formatNumberToSpecificDecimalPlaces(data.prev_billing_total_final_hcq,5));
                $('#prev_total_final_hcq').val($.formatNumberToSpecificDecimalPlaces(data.prev_billing_total_final_hcq,5));  
                $('#revision').val(data.revision);       

                $('#market_fee').val($.formatNumberToSpecificDecimalPlaces(data.market_fee,16));  
                $('#contract_quantity').val($.formatNumberToSpecificDecimalPlaces(data.contract_quantity,5));  
                $('#zero_rate_vat_deduction').val($.formatNumberToSpecificDecimalPlaces(data.zero_rate_vat_deduction,5));  
                $('#kspc_load_factor_price').val($.formatNumberToSpecificDecimalPlaces(data.kspc_load_factor_price,5));  
                $('#disp_kspc_load_factor_price').val($.formatNumberToSpecificDecimalPlaces(data.kspc_load_factor_price,5));  
                $('#load_factor').val($.formatNumberToSpecificDecimalPlaces(data.load_factor,5));  

                if (success === 1) {
                                
                    $('#disp_power_bill_no').val(data.power_bill_no);
                    $('#power_bill_no').val(data.power_bill_no);  
                    $('#revision').val(data.revision);  
                    $('#create_power_bill_button').html('<button type="button" id="btn_create_power_bill" class="btn btn-primary" ><i class="icon-file"></i>Create Power Bill</button>');
                    
                    var total_incident = parseInt(data.total_incident,10);
                    
                    $('#sdate_covered1').val('');
                    $('#edate_covered1').val('');
                    $('#hcq1').val('');
                    $('#kscp_price1').val('');

                    $('#disp_incidental_total_final_hcq').val('');
                    $('#incidental_total_final_hcq').val('');
                    $('#disp_incidental_kspc_price').val('');
                    $('#incidental_kspc_price').val('');
                    if (total_incident > 0){
                        $('tr[name=incidental_detail_row]').remove();
                        var incidents = $.parseJSON(data.incidents);
                        var total_incidents = incidents.length;
                        var row_ctr = 1;
                        for ( var i=0;i<total_incident;i++) {
                            if (row_ctr > 2) {
                                $('#btn_add_incident').trigger('click');
                            }
                            
                            $('#sdate_covered'+row_ctr).val(incidents['sdate_'+row_ctr]);
                            $('#edate_covered'+row_ctr).val(incidents['edate_'+row_ctr]);
                            var hcq = incidents['hcq_'+row_ctr];
                            var kscp_price = incidents['price_'+row_ctr];
                            
                            $('#hcq'+row_ctr).val($.formatNumberToSpecificDecimalPlaces(hcq,5));
                            $('#kscp_price'+row_ctr).val($.formatNumberToSpecificDecimalPlaces(kscp_price,5));
                                
                            row_ctr++;
                        }
                        $.calculateIndicidentalTotalHCQandKSPCPRice();
                    }
                    $('#btn_create_power_bill').unbind().bind('click',function(){
                        $.generatePowerBill();
                    });
                    
                    if (is_with_export_pdf === 1) {
                        var html = '<button type="button" id="btn_export_pdf" class="btn btn-success" ><i class="icon-download"></i>Export to PDF</button>';
                        $('#create_power_bill_status').html(html).attr('class','alert alert-success');
                    }else {
                        $('#create_power_bill_status').html('').removeAttr('class');
                    }
                    
                            
                }else {
                    $('#loader').html(message).addClass('alert').addClass('alert-error');
                    $('#btn_create_power_bill').unbind();
                }
                powerBill.hidePleaseWait();
                 $('#contract_quantity').trigger('change');
                 //$("input:radio[name=power_bill_type]").trigger('change');
            });
            */
        }
        ,generatePowerBill : function(){
            $('#create_power_bill_status').html('').removeAttr('class');
            var parameters = {};
            parameters['hcq_source'] = $("input:radio[name=hcq_source]:checked").val();
            parameters['customer'] = $('#customer').val();
            parameters['sdate'] = $('#sdate').val();
            parameters['edate'] = $('#edate').val();
            parameters['date_prepared'] = $('#date_prepared').val();
            parameters['type'] = $("input:radio[name=power_bill_type]:checked").val();
            parameters['due_date'] = $("#due_date").val();
            parameters['revision'] = $("#revision").val();
            parameters['market_fee'] = $("#market_fee").val();
            parameters['zero_rate_vat_deduction'] = $("#zero_rate_vat_deduction").val();
            parameters['contract_quantity'] = $("#contract_quantity").val();
            parameters['kspc_load_factor_price'] = $("#kspc_load_factor_price").val();
            parameters['load_factor'] = $("#load_factor").val();
            
            
            
            var error_msgs = [];
            var revision = $.trim($("#revision").val());
            if (revision.length <= 0) {
                error_msgs.push('Revision');
            }
            
            var market_fee = $.trim($("#market_fee").val());
            if (market_fee.length <= 0) {
                error_msgs.push('Market Fee');
            }
            var tax_type = $.trim($("#tax_type").val());
            
            if (tax_type === 'vatable*') {
                var zero_rate_vat_deduction = $.trim($("#zero_rate_vat_deduction").val());
                if (zero_rate_vat_deduction.length <= 0) {
                    error_msgs.push('Zero Rate Vat* Deduction ');
                }
            }
            
            var psc_type = $.trim($("#psc_type").val());
            if (psc_type == 'load_factor') {
                var contract_quantity = $.trim($("#contract_quantity").val());
                if (contract_quantity.length <= 0) {
                    error_msgs.push('Contract Quantity ');
                }
                
                var kspc_load_factor_price = $.trim($("#kspc_load_factor_price").val());
                if (kspc_load_factor_price.length <= 0) {
                    error_msgs.push('Load Factor Price');
                }
                
                var load_factor = $.trim($("#load_factor").val());
                if (load_factor.length <= 0) {
                    error_msgs.push('Load Factor');
                }
            }
            
            
            var power_bill_type = $("input:radio[name=power_bill_type]:checked").val();
            if (power_bill_type === 'incidental') {
                var incidental_total_final_hcq = $.trim($("#incidental_total_final_hcq").val());
                if (incidental_total_final_hcq.length <= 0) {
                    error_msgs.push('Total Final HCQ (A+B)');
                }
                parameters['incidental_total_final_hcq'] = incidental_total_final_hcq;
                
                var incidental_kspc_price = $.trim($("#incidental_kspc_price").val());
                if (incidental_kspc_price.length <= 0) {
                    error_msgs.push('Weighted Average Price');
                }
                parameters['incidental_kspc_price'] = incidental_kspc_price;
                
                
                // populate incidental details
                var total_incidents = $('#tbl_incidents>tbody>tr').length-2;
                parameters['total_incidents'] = total_incidents;
                for (var cntr=1;cntr<=total_incidents;cntr++){
                    parameters['incident_sdate_'+cntr] = $('#sdate_covered'+cntr).val();
                    parameters['incident_hcq_'+cntr] = $('#hcq'+cntr).val();
                    parameters['incident_kspc_rate_'+cntr] = $('#kscp_price'+cntr).val();
                    /*
                    parameters['incident_sdate_b_'+cntr] = $('#sdate_covered_b'+cntr).val();
                    parameters['incident_hcq_b_'+cntr] = $('#hcq_b'+cntr).val();
                    parameters['incident_kspc_rate_b_'+cntr] = $('#new_kscp_price'+cntr).val();
                */
                }
            }
            console.log(parameters)
            if (error_msgs.length >= 1) {
                $('#create_power_bill_status').html('The following fields are mandatory :<br>'+ error_msgs.join('<br>') ).attr('class','alert alert-error');
            }else {
                $('#create_power_bill_status').html('Please wait while we submit your data <img src="../images/ajax-loader.gif" />').attr('class','alert alert-info');
                
                $.post('../power_bill/power_bill_generate', parameters,
                    function(ret) {
                        var success = parseInt(ret.success,10);
                        var message = ret.message;
                        if (success === 1) {
                            var html = 'Successfully created power bill ';
                            html+='<br>';
                            html+='<button type="button" class="btn btn-success" id="btn_export_pdf" ><i class="icon-download"></i>Export to PDF</button>';
                            $('#create_power_bill_status').html(html).attr('class','alert alert-success');
                        }else {
                            $('#create_power_bill_status').html(message).addClass('alert').addClass('alert-error');
                        }
                        
                 });
            }
            
        } //
        
        ,calculateIndicidentalTotalHCQandKSPCPRice : function(){
            var total_incidents = $('#tbl_incidents>tbody>tr').length-2;
            var incidental_total_final_hcq = '', incidental_total_final_hcq_num = 0;
            var incidental_kspc_price = '', incidental_kspc_price_num = 0;
            var with_valid_hcq = 0, with_valid_kspc = 0;
            var tmp = '';
            for (var cntr=1;cntr<=total_incidents;cntr++){
                var tmp_hcq_a = $.trim($('#hcq'+cntr).val());
                var tmp_hcq_a_num = 0;
                if (tmp_hcq_a.length > 0 ) {
                    with_valid_hcq = 1;
                    tmp_hcq_a = parseFloat(tmp_hcq_a.replace(/,/g, ''));
                    tmp_hcq_a_num = tmp_hcq_a;
                }
                
                incidental_total_final_hcq_num= incidental_total_final_hcq_num + tmp_hcq_a_num ;
                
                
                // kspc 
                var tmp_old_kspc = $.trim($('#kscp_price'+cntr).val());
                var tmp_old_kspc_num = 0;
                if (tmp_old_kspc.length > 0 ) {
                    with_valid_kspc = 1;
                    tmp_old_kspc = parseFloat(tmp_old_kspc.replace(/,/g, ''));
                    tmp_old_kspc_num = tmp_old_kspc;
                }
                
                incidental_kspc_price_num= incidental_kspc_price_num + tmp_old_kspc_num;
            }
            
            incidental_kspc_price_num = incidental_kspc_price_num / total_incidents;
            $('#disp_incidental_total_final_hcq').val($.formatNumberToSpecificDecimalPlaces(incidental_total_final_hcq_num,5));
            $('#incidental_total_final_hcq').val(incidental_total_final_hcq_num);
            
            
            $('#disp_incidental_kspc_price').val($.formatNumberToSpecificDecimalPlaces(incidental_kspc_price_num,5));
            $('#incidental_kspc_price').val(incidental_kspc_price_num);
            
        }
    });
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('#customer').unbind().bind('change',function(){
        var customer_obj = $( "#customer option:selected" );
        var customer_type = customer_obj.attr('customer_type');
        var customer_type_desc = customer_type;
        if (customer_type === 'distribution_utility'){
            customer_type_desc = 'Distribution Utility';
        }else if (customer_type === 'electric_cooperative'){
            customer_type_desc = 'Electric Cooperative';
        }else if (customer_type === 'industrial'){
            customer_type_desc = 'Industrial';
        }else if (customer_type === 'wholesale_aggregator_res'){
            customer_type_desc = 'Wholesale Aggregator / RES';
       }else if (customer_type === 'Electric Cooperative'){
            customer_type === 'electric_cooperative';
            customer_type_desc = 'Electric Cooperative';
        }
        var psc_type = customer_obj.attr('psc_type');
        var tax_type = customer_obj.attr('tax_type');
        
        $('#disp_customer_type').val(customer_type_desc);
        $('#customer_type').val(customer_type);
        
        if (psc_type === 'base_load') {
            $('#disp_psc_type').val('Base Load');
        }else {
            $('#disp_psc_type').val('Load Factor');
        }
        $('#psc_type').val(psc_type);
        
        
        $('#tax_type').val(tax_type);
        var disp_tax_type = tax_type;
        if (disp_tax_type === 'vatable*') {
            $('input[name=disp_tax_type]:nth-child(3)').attr('checked', 'checked');
        }else {
            $("input[name=disp_tax_type][value=" + disp_tax_type + "]").attr('checked', 'checked');
        }
        
        
        // hide all non related form inputs depending on customer setup
        $('[name=col_contract_quantity_colspan]').attr('colspan',3);
        $('[name=col_contract_quantity]').hide();
        $('[name=col_load_factor]').hide();
        $('[name=col_zero_rate_deduction]').hide();
        
        if (tax_type === 'vatable' && psc_type === 'load_factor') {
            $('[name=col_contract_quantity_colspan]').attr('colspan',1);
            $('[name=col_contract_quantity]').show();
            $('[name=col_load_factor]').show();
        }else if (tax_type === 'vatable' && psc_type === 'base_load'){
            // no specialcase for showing other fields
        }else if (tax_type === 'vatable*' && psc_type === 'base_load'){
            $('[name=col_zero_rate_deduction]').show();
        }else if (tax_type === 'zero_rated' && psc_type === 'base_load'){
            // no specialcase for showing other fields
        }else if (tax_type === 'vatable*' && psc_type === 'load_factor'){
            $('[name=col_zero_rate_deduction]').show();
            $('[name=col_contract_quantity_colspan]').attr('colspan',1);
            $('[name=col_contract_quantity]').show();
            $('[name=col_load_factor]').show();
        }    
        
        $.getPowerBillDetails();
    });
    
    $('#contract_quantity').unbind().bind('change',function(){
        var psc_type = $.trim($('#psc_type').val());
        
        // reset values
        $('#disp_kspc_load_factor_price').val('');
        $('#kspc_load_factor_price').val('');
        $('#disp_load_factor').val('');
        $('#load_factor').val('');
        
        if (psc_type === 'load_factor') {
            var contract_quantity_formatted = $.trim($('#contract_quantity').val());
            contract_quantity_formatted = contract_quantity_formatted.replace(/,/g, '');
            
            var total_final_hcq_formatted = $.trim($('#total_final_hcq').val());
            total_final_hcq_formatted = total_final_hcq_formatted.replace(/,/g, '');
            
            var psc_rate_formatted = $.trim($('#psc_rate').val());
            psc_rate_formatted = psc_rate_formatted.replace(/,/g, '');
            
            var total_final_hcq = total_final_hcq_formatted.length > 0 ? parseFloat(total_final_hcq_formatted) : 0 ;
            var contract_quantity = contract_quantity_formatted.length > 0 ? parseFloat(contract_quantity_formatted) : 0 ;
            var psc_rate = psc_rate_formatted.length > 0 ? parseFloat(psc_rate_formatted) : 0 ;
            if (contract_quantity > 0 && total_final_hcq != 0) {
                var load_factor = (total_final_hcq / contract_quantity) * 100;
                $('#disp_load_factor').val($.formatNumberToSpecificDecimalPlaces(load_factor,2));
                $('#load_factor').val($.formatNumberToSpecificDecimalPlaces(load_factor,2));
                var kspc_load_factor_price = ((total_final_hcq * psc_rate)   + ( (contract_quantity-total_final_hcq) * 0.75 * psc_rate ))/ total_final_hcq;
                $('#disp_kspc_load_factor_price').val($.formatNumberToSpecificDecimalPlaces(kspc_load_factor_price,4));
                $('#kspc_load_factor_price').val(kspc_load_factor_price);
            }
            
            
            
        }
    });
    $('#sdate,#edate,.date_covered').datepicker();
    
    $('#sdate').on('changeDate', function() {
        var msg = '';
        var sdate_s = $.trim($('#sdate').val());
        var sdate = Date.parse($('#sdate').val());
        if (sdate != null && sdate_s.length === 10) {
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
            $(this).datepicker('hide');
            $.computeDueDate();
            $.getPowerBillDetails();
        }
        
     });
    
    $('#edate').on('changeDate', function(ev) {
        var edate_s = $.trim($('#edate').val());
        var edate = Date.parse($('#edate').val());
        if (edate != null && edate_s.length === 10) {
           $.validateDateRange( $('#sdate'),$('#edate') );
           $.computeDueDate();
           $.getPowerBillDetails();
        }
           
    });  
    
    
    $("input:radio[name=hcq_source]").unbind().bind('click',function(){
        $.getPowerBillDetails();
    });
    
    $('.numeric').autoNumeric('init',{
        mDec: '5'
      ,vMin : -9999999999      
    });
    
    
    $('#market_fee').autoNumeric('init',{
        mDec: '16'
      ,vMin : -9999999999      
    });
    
    $('#revision').autoNumeric('init',{
        mDec: '0'
      ,vMin : 0      
    });
    
    $('#btn_export_pdf').unbind().live('click',function(){
        var parameters = 'hcq_source='+$("input:radio[name=hcq_source]:checked").val();
        parameters+= '&customer='+$('#customer').val();
        parameters+= '&sdate='+$('#sdate').val();
        parameters+= '&edate='+$('#edate').val();
        parameters+= '&revision='+$('#revision').val();
        parameters+= '&type='+$("input:radio[name=power_bill_type]:checked").val();
        $.download('../power_bill/download_power_bill',parameters);
    });
    
    $("input:radio[name=power_bill_type]").unbind().bind('change',function(){
       var power_bill_type = $("input:radio[name=power_bill_type]:checked").val();
       $('tr[name=incidental_detail_row]').remove();
       $('#sdate_covered_a1').val('');
       $('#edate_covered_a1').val('');
       $('#hcq_a1').val('');
       $('#old_kscp_price1').val('');
       
       $('#sdate_covered_b1').val('');
       $('#edate_covered_b1').val('');
       $('#hcq_b1').val('');
       $('#new_kscp_price1').val('');
       
       $('#disp_incidental_total_final_hcq').val('');
       $('#incidental_total_final_hcq').val('');
       $('#disp_incidental_kspc_price').val('');
       $('#incidental_kspc_price').val('');
       power_bill_type = $.trim(power_bill_type.toLowerCase());
       if (power_bill_type === 'default') {
           $('tr[name=default_row]').show();
           $('tr[name=incident_row]').hide();
       }else {
           $("input:radio[name=hcq_source][value=declaration]").first().attr('checked','checked');
           $('tr[name=default_row]').hide();
           $('tr[name=incident_row]').show();
           
       }
       $.getPowerBillDetails();
    });
    
    // add incident
     $('#btn_add_incident').unbind().live('click',function(){
        var cntr = $('#tbl_incidents>tbody>tr').length-2;
        cntr++;
        var html = '<tr name="incidental_detail_row"><td style="border-bottom:1px dotted #2F96B4; border-top:1px dotted #2F96B4;">';
        html+= '<table width="100%" class="noformatting table-condensed">';
        html+= '<tr>';
        html+= '<td style="min-width:20%;">Date Covered</td>';
        html+= '<td style="min-width:32%;">';
        html+= '<input type="text" id="sdate_covered'+cntr+'" name="sdate_covered'+cntr+'" value="" class="input-small date_covered"><span class="add-on"> to </span>';
        html+= '<input type="text" id="edate_covered'+cntr+'" name="edate_covered'+cntr+'" value="" class="input-small  date_covered">';
        html+= '</td>';
        html+= '<td>&nbsp;</td>';
        html+= '<td  style="min-width:15%;"></td>';
        html+= '<td style="text-align:right;"><button type="button" name="btn_delete_incident" class="btn btn-mini" ><i class="icon-minus"></i></button></td>';
        html+= '</tr>';  
        html+= '<tr>';
        html+= '<td style="min-width:20%;">HCQ</td>';
        html+= '<td style="min-width:32%;">';
        html+= '<input type="text" value="" class="incidental_input input-medium numeric" id="hcq'+cntr+'">';
        html+= '</td>';
        html+= '<td>&nbsp;</td>';
        html+= '<td  style="min-width:15%;">Price</td>';
        html+= '<td><input type="text" value="" class="incidental_input input-medium numeric" id="kscp_price'+cntr+'"></td>';
        html+= '</tr> ';
        /*
        html+= '<tr>';
        html+= '<td style="min-width:20%;">Date Covered (B)</td>';
        html+= '<td style="min-width:32%;">';
        html+= '<input type="text" id="sdate_covered_b1" name="sdate_covered_b'+cntr+'" value="" class="input-small  date_covered"><span class="add-on"> to </span>';
        html+= '<input type="text" id="edate_covered_b1" name="edate_covered_b'+cntr+'" value="" class="input-small  date_covered">';
        html+= '</td>';
        html+= '<td>&nbsp;</td>';
        html+= '<td  style="min-width:15%;"></td>';
        html+= '<td></td>';
        html+= '</tr>';
        html+= '<tr>';
        html+= '<td style="min-width:20%;">HCQ (B)</td>';
        html+= '<td style="min-width:32%;">';
        html+= '<input type="text" value="" class="incidental_input input-medium numeric" id="hcq_b'+cntr+'">';
        html+= '</td>';
        html+= '<td>&nbsp;</td>';
        html+= '<td  style="min-width:15%;">New Price (N)</td>';
        html+= '<td><input type="text" value="" class="incidental_input input-medium numeric" id="new_kscp_price'+cntr+'"></td>';
        html+= '</tr>';
            */
        html+= '</table>';
        html+= '</td></tr>';
                    
        $('#tbl_incidents tr:last').before(html);
        $('.date_covered').datepicker();
        
        $('.numeric').autoNumeric('init',{
            mDec: '5'
          ,vMin : -9999999999      
        });

    });
    
    $('[name=btn_delete_incident]').unbind().live('click',function(){
        $(this).parent().parent().parent().parent().parent().parent().remove();
    });
    
    
    $('.date_covered').on('changeDate',function(){
        var field_ref = $(this).attr('id');
        /*powerBill.showPleaseWait();
        var parameters = {};
        parameters['customer'] = $('#customer').val();
        parameters['sdate'] = $('#'+field_ref).val();
        parameters['field_ref'] = field_ref;
        
        $.post('../power_bill/power_bill_get_hsc_psc', parameters,
        function(ret) {
            var success = parseInt(ret.success,10);
            var message = ret.message;
            var data = ret.value;
            var field_ref = ret.field_ref;
            var tmp = field_ref.split('_'); //sdate_covered_a1
            var last = tmp[ tmp.length -1 ];
            var letter_indx = last.substr(0,1);
            var num_index = last.substr(1);

            $('#edate_covered_'+letter_indx+num_index).val(ret.billing_edate);
            $('#hcq_'+letter_indx+num_index).val('');
            if (letter_indx === 'a') {
                $('#old_kscp_price'+num_index).val('');
            }else {
                $('#new_kscp_price'+num_index).val('');
            }
            
            if (success === 1) {
                $('#hcq_'+letter_indx+num_index).val($.formatNumberToSpecificDecimalPlaces(data.total_delivered,5));
                if (letter_indx === 'a') {
                    $('#old_kscp_price'+num_index).val($.formatNumberToSpecificDecimalPlaces(data.psc_rate,5));
                }else {
                    $('#new_kscp_price'+num_index).val($.formatNumberToSpecificDecimalPlaces(data.psc_rate,5));
                }

            }else {
                $('#loader').html(message).addClass('alert').addClass('alert-error');
                $('#btn_create_power_bill').unbind();
            }
            powerBill.hidePleaseWait();
            */
            $.calculateIndicidentalTotalHCQandKSPCPRice();
        
        
    });
    
    $('.incidental_input').live('blur',function(){
        $.calculateIndicidentalTotalHCQandKSPCPRice();
    });
    $('tr[name=incident_row]').hide();
    $.computeDueDate();
    $('#customer').trigger('change');
    
    $('#date_prepared').datepicker();
});
 

</script>
    

     



