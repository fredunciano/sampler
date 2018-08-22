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

    <fieldset class="fs-blue">
        <legend><?=$title?></legend>
        <table>
        	<tr>
        		<th width="150px">Customer</th>
        		<td>
        			<select id="cmb_customers">
        			<?php
        				foreach ($customers as $c) {
        					echo '<option value="'.$c->id.'">'.$c->name.'</option>';
        				}
        			
        			?>
        			</select>
        		</td>
        	</tr>
        	<tr>
        		<th>Billing Period</th>
        		<td>
        			<select id="month" name="month">
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
        			<select id="year" name="year">
                        <?php
                        for($x=2006;$x<=date('Y')+5;$x++){
                            $sel = ($billing_start['year'] == $x) ? 'selected=selected' : '';
                            echo '<option value="'.$x.'" '.$sel.' >'.$x.'</option>';
                        }
                        ?>
        			</select>
        			&nbsp;<button id="btn_retrieve" type="button">Retrieve</button>
        		</td>
        	</tr>
        </table>
    </fieldset>
    <br>
    <fieldset class="fs-blue" id="fs-upload-manual" style="width:100%; display:none;">
        <legend>Upload Manual Invoice</legend>
        <form id="frm1" class="frm" enctype="multipart/form-data" onsubmit="return false;" method="post">
        <table>
            <tr>
                <td>
                    <input type="file"  name="filebrowser" id="filebrowser">
                    <button type="submit" value="Submit" id="upload_btn" >Submit</button><span id="msg-alert"></span>
                </td>
            </tr>
        </table>
        </form>
    </fieldset>

    <br>
    <fieldset class="fs-blue" id="fs-result" style="width:100%">
        <legend>Result&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</legend>
        <div id="result_loader"></div>
        <div id="result">
        </div>
    </fieldset>
    
    <br><br><br><br><br>
</div>

<div id="transmittal_1_contents" style="display: none;">

    <div style="border:5px rgb(0,128,0) solid">
        <table width="100%">
            <tr>
                <th style="text-align: center"><h2>GMCP</h2></th>
            </tr>
            <tr>
                <th style="text-align: center"><h3>GNPower Mariveles Coal Plant Ltd. Co</h3> <p>ATTACHMENT 1</p></th>
            </tr>
        </table>

        <table width="100%" border="0" cellpadding="1" cellspacing="1">
            <tr><th align="center" colspan="4" style="background-color: rgb(51,51,51); color: rgb(255,255,255); text-align: center;">BUYER INFORMATION</th></tr>
            <tr><td>Buyer Name</td><td name="buyer_name_content" class="hdr_content" style="min-width: 100px;">Test Buyer Name</td>
                <td>Reference No.</td><td name="invoice_reference_no_content" class="hdr_content"></td></tr>
            <tr><td>Address</td><td name="address_content" class="hdr_content">000000 Street Name Street City Name</td>
                <td>Billing Period</td><td  name="billing_period_content" class="hdr_content"></td></tr>
            <tr><td>&nbsp;</td><td style="font-weight: bold;">&nbsp;</td>
                <td>Billing Date</td><td name="billing_date_content" class="hdr_content"></td></tr>
            <tr><td>&nbsp;</td>
                <td style="font-weight: bold;">&nbsp;</td><td>Due Date</td><tdclass="hdr_content" name="due_date_content"></td></tr>
            <tr><td colspan="4">&nbsp;</td></tr>
        </table>
        <br/>
        <table width="100%" border="0">
            <tr><td colspan="3" align="center" style="background-color: rgb(51,51,51); color: rgb(255,255,255); text-align: center;">BUYER STATEMENT DETAILS</td> </tr>
            <tr><td align="center" width="50%"  style="background-color: rgb(137,137,137); color: rgb(255,255,255); text-align: center;">ITEM</td>
                <td align="center" width="25%" style="background-color: rgb(137,137,137); color: rgb(255,255,255); text-align: center;">QUANTITY</td>
                <td align="center" width="25%" style="background-color: rgb(137,137,137); color: rgb(255,255,255); text-align: center;">AMOUNT</td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td>Contracted Capacity (kW)</td><td name="contracted_capacity_content" class="data_content"></td><td>&nbsp;</td>
            </tr>
            <tr>
                <td>Total Buyer's Quantity (kWh)</td><td name="total_qty_content"  class="data_content"></td><td></td>
            </tr>
            <tr>
                <td>Capacity Factor (Percent)</td><td name="resulting_capacity_factor_content"  class="data_content"></td><td></td>
            </tr>
            <tr>
                <td>Capacity Fee (USD/kWh) [a]</td><td name="capacity_fee_content"  class="data_content"></td><td></td>
            </tr>
            <tr>
                <td>Energy Fee (USD/kWh) [b]</td><td name="energy_fee_content" class="data_content"></td><td></td>
            </tr>
            <tr>
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Initial Energy Fee (USD/kWh)
                </td><td name="initial_energy_fee_content" class="data_content"></td><td></td>
            </tr>
            <tr>
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    CIF Cost of Fuel for Billing Period (USD/MkCal)
                </td><td name="actual_cif" class="data_content"></td><td></td>
            </tr>
            <tr>
                <td >
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Base CIF Cost of Fuel (USD/MkCal)
                </td><td name="base_cif_content" class="data_content"></td><td></td>
            </tr>
            <tr>
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Adjustment due to Import Duties, USD/kWh
                </td><td name="adj_due_to_import_duties_content" class="data_content"></td><td></td>
            </tr>
            <tr>
                <td>
                    Generation Rate (USD/kWh) [a+b
                </td><td name="contract_fee_content" class="data_content"></td><td></td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3">Buyers Credit:</td>
            </tr>
            <tr>
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Prompt Payment Discount(USD)
                </td><td></td><td name="ppd_content" class="data_content"></td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td>Foreign Exchange Rate Adjustment (USD)</td><td></td><td name="fx_adjustments_content" class="data_content"></td>
            </tr>
            <tr>
                <td>Redelivery Payment:</td><td></td><td name="redelivery_payment" class="data_content"></td>
            </tr>
            <tr>
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Redelivered Quantity due to Localized Transmission Failure (kWh)
                </td><td name="redelivered_quantity_ltf_content" class="data_content"></td><td></td>
            </tr>
            <tr>
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Energy Fee Adjustment on the Redelivered Quantity (USD)
                </td><td></td><td name="energy_fee_adj_redelivered_qty"  class="data_content"></td>
            </tr>
            <tr>
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Redelivered Quantity due to Deficiency (kWh)
                </td><td name="redelivered_quantity_deficiency_content" class="data_content"></td><td></td>
            </tr>
            <tr>
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Energy Fee Payment due to deficiency (USD)
                </td><td></td><td name="energy_fee_payment_due_to_deficiency_content" class="data_content"></td>
            </tr>
            <tr>
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Other Charges (USD)
                </td><td></td><td name="other_charges_content"  class="data_content"></td>
            </tr>
            <tr>
                <td>
                    Total Amount Payable (USD)
                </td><td></td><td name="total_amount_payable_content" class="data_content"></td>
            </tr>
        </table>
        <br/>

        <table>
            <tr>
                <td style="text-align: center" class="small">
                    1905 Orient Square Building, Don Francisco Ortigas Jr. Road, Ortigas Center, Pasig City 1605
                </td>
            </tr>
        </table>
    </div>


</div>

<div id="dialog_transmittal_1">
	&nbsp;
</div>


<div id="transmittal_2_contents" style="display: none;">

    <div style="border:5px rgb(0,128,0) solid">
        <table width="100%">
            <tr>
                <th style="text-align: center"><h2>GMCP</h2></th>
            </tr>
            <tr>
                <th style="text-align: center"><h3>GNPower Mariveles Coal Plant Ltd. Co</h3> <p>ATTACHMENT 2</p></th>
            </tr>
        </table>

        <table width="100%" border="0" cellpadding="1" cellspacing="1">
            <tr><th align="center" colspan="4" style="background-color: rgb(51,51,51); color: rgb(255,255,255); text-align: center;">BUYER INFORMATION</th></tr>
            <tr><td>Buyer Name</td><td name="buyer_name_content" class="hdr_content" style="min-width: 100px;">Test Buyer Name</td>
                <td>Reference No.</td><td name="invoice_reference_no_content" class="hdr_content"></td></tr>
            <tr><td>Address</td><td name="address_content" class="hdr_content">000000 Street Name Street City Name</td>
                <td>Billing Period</td><td  name="billing_period_content" class="hdr_content"></td></tr>
            <tr><td>&nbsp;</td><td style="font-weight: bold;">&nbsp;</td>
                <td>Billing Date</td><td name="billing_date_content" class="hdr_content"></td></tr>
            <tr><td>&nbsp;</td>
                <td style="font-weight: bold;">&nbsp;</td><td>Due Date</td><tdclass="hdr_content" name="due_date_content"></td></tr>
            <tr><td colspan="4">&nbsp;</td></tr>
        </table>
        <br/>
        <table width="100%" border="0">
            <tr><td colspan="3" align="center" style="background-color: rgb(51,51,51); color: rgb(255,255,255); text-align: center;">BUYER STATEMENT DETAILS</td> </tr>
            <tr><td align="center" width="50%"  style="background-color: rgb(137,137,137); color: rgb(255,255,255); text-align: center;">ITEM</td>
                <td align="center" width="25%" style="background-color: rgb(137,137,137); color: rgb(255,255,255); text-align: center;">QUANTITY</td>
                <td align="center" width="25%" style="background-color: rgb(137,137,137); color: rgb(255,255,255); text-align: center;">AMOUNT</td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td>Contracted Capacity (kW)</td><td name="contracted_capacity_content" class="data_content"></td><td></td>
            </tr>
            <tr>
                <td>Total Buyer's Quantity (kWh)</td><td name="total_qty_content"  class="data_content"></td><td></td>
            </tr>
            <tr>
                <td>Capacity Factor (Percent)</td><td name="resulting_capacity_factor_content"  class="data_content"></td><td></td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3">Other Charges:</td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WESM Charges (PHP) [a] *</td><td></td><td name="wesm_charges" class="data_content"></td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delivery Charges (PHP) [b]</td><td></td><td name="delivery_charges_php" class="data_content"></td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Governmental Charges (PHP)**</td><td></td><td name="govt_charges_php" class="data_content"></td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Other Charges (PHP) [c]</td><td></td><td name="total_other_charges_php" class="data_content"></td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td>Total Payment (PHP)[a+b+c]</td><td></td><td name="total_payment_attachment2_php" class="data_content"></td>
            </tr>
        </table>
        <br/>

        <table>
            <tr>
                <td style="text-align: center" class="small">
                    1905 Orient Square Building, Don Francisco Ortigas Jr. Road, Ortigas Center, Pasig City 1605
                </td>
            </tr>
        </table>
    </div>


</div>
<div id="dialog_transmittal_2">
    &nbsp;
</div>


<div id="invoice_contents" style="display: none;">
<div style="border:5px rgb(0,128,0) solid">
    <table width="100%">
        <tr>
            <th style="text-align: left" colspan="4"><h2>GNPower Mariveles Coal Plant Ltd. Co.</h2></th>
        </tr>
        <tr>
            <th style="text-align: left" colspan="4"><h6>1905 Orient Square Bldg., Don Francisco Ortigas Jr. Road, Ortigas Center, Pasig City 1605 </h6></th>
        </tr>
        <tr>
            <th style="text-align: left" colspan="4"><h6>TIN: 006-659-706-000-VAT</h6></th>
        </tr>
        <tr>
            <th style="text-align: left" colspan="4"><h6>Phone: (632) 638-4542</h6></th>
        </tr>
        <tr>
            <th style="text-align: left" colspan="4"><h6>Fax: (632) 638-4575</h6></th>
        </tr>
    </table>
    <br/>
    <table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr><th align="center" colspan="4" style="background-color: rgb(51,51,51); color: rgb(255,255,255);text-align: center;">POWER BILL</th></tr>
        <tr><td colspan="4" style="height: 2px;"></td> </tr>
        <tr><th align="center" colspan="4" style="background-color: rgb(51,51,51); color: rgb(255,255,255);text-align: center;">BUYER INFORMATION</th></tr>
        <tr>
            <td style="width:70px;">Buyer Name</td>
            <td name="buyer_name_content" class="hdr_content" style="min-width: 100px;">Test Buyer Name</td>
            <td style="width:70px;">Reference No.</td>
            <td name="invoice_reference_no_content" class="hdr_content"></td>
        </tr>
        <tr>
            <td style="width:70px;">Address</td ><td name="address_content" class="hdr_content">000000 Street Name Street City Name</td>
            <td>Billing Period</td><td name="billing_period_content" class="hdr_content"></td>
        </tr>
        <tr>
            <td>Classification</td><td class="hdr_content" name="buyer_classification"></td>
            <td>Billing Date</td><td name="billing_date_content" class="hdr_content"></td>
        </tr>
        <tr>
            <td>Buyer's TIN</td><td class="hdr_content"  name="buyer_tin"></td>
            <td >Due Date</td><td class="hdr_content" name="due_date_content"></td>
        </tr>
    </table>
    <br/>

    <table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr><th align="center" colspan="4" style="background-color: rgb(51,51,51); color: rgb(255,255,255);text-align: center;">BILLING PARTICULARS</th></tr>
        <tr><td>Contracted Capacity (kW)</td><td style="font-weight: bold;"  name="contracted_capacity_content">&nbsp;</td>
            <td>Buyer's Quantity for the Billing Period (kWh)</td><td style="font-weight: bold;" name="total_qty_content">&nbsp;</td></tr>
        <tr><td colspan="4">&nbsp;</td></tr>
    </table>

    <br/>

    <table width="100%" border="0" cellspacing="4" cellpadding="2">
        <tr><td colspan="4" align="center" style="background-color: rgb(51,51,51); color: rgb(255,255,255); text-align: center;">BILLING DETAILS</td> </tr>
        <tr><td align="center" width="25%"  style="background-color: rgb(137,137,137); color: rgb(255,255,255);text-align: center;">ITEM</td>
            <td align="center" width="25%" style="background-color: rgb(137,137,137); color: rgb(255,255,255);text-align: center;">BILLING DETERMINANTS</td>
            <td align="center" width="25%" style="background-color: rgb(137,137,137); color: rgb(255,255,255);text-align: center;">RATES</td>
            <td align="center" width="25%" style="background-color: rgb(137,137,137); color: rgb(255,255,255);text-align: center;">AMOUNT</td></tr>

        <tr>
            <td align="center" width="25%" valign="top" style="border: 1px #000 solid;">
                <table width="100%">
                    <tbody><tr><td style="text-align: center"><u>Generation Charges</u></td></tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr><td style="text-align: center">Generation Rate (USD)</td></tr>
                    <tr><td style="text-align: center">Generation Rate (PHP)</td></tr>
                    </tbody></table>
            </td>
            <td align="center" valign="top" style="border: 1px #000 solid;">
                <table width="100%">
                    <tbody><tr><td style="text-align: center"><u>Total Buyers Quantity (kWh)</u></td></tr>
                    <tr><td name="total_qty_content" style="text-align: center">'.number_format($invoice_summary_data['total_quantity'],2,'.',',').'</td></tr>
                    <tr><td>&nbsp;</td></tr>
                    </tbody></table>
            </td>
            <td align="center" valign="top" style="border: 1px #000 solid;">
                <table width="100%">
                    <tbody><tr><td style="text-align: center"><u>Energy and Capacity Fee (USD/kWh)/(PHP/kWH)</u></td></tr>
                    <tr><td name="generation_rate_usd_content" style="text-align: center">'.number_format($invoice_summary_data['contract_fee_usd'],2,'.',',').'</td></tr>
                    <tr><td name="generation_rate_php_content" style="text-align: center">'.number_format($invoice_summary_data['contract_fee_php'],2,'.',',').'</td></tr>
                    </tbody></table>
            </td>
            <td align="center" valign="top" style="border: 1px #000 solid;">
                <table width="100%">
                    <tbody><tr><td style="text-align: center"><u>Contract Price (USD)</u></td></tr>
                    <tr><td name="contract_price_usd_content" style="text-align: center">'.number_format($invoice_summary_data['contract_price_usd'],2,'.',',').'</td></tr>
                    <tr><td>&nbsp;</td></tr>
                    </tbody></table>
            </td></tr>

        <tr>
            <td align="center" width="25%" valign="top" style="border: 1px #000 solid;">
                <table width="100%">
                    <tbody><tr><td style="text-align: center"><u>Adjustment</u></td></tr>
                    <tr><td style="TEXT-ALIGN: center;">PPD of Previous Billing (USD)</td></tr>
                    <tr><td style="text-align: center">Other Charges (USD)</td></tr>
                    <tr><td style="text-align: center">Other Charges (PHP)</td></tr>
                    </tbody></table>
            </td>
            <td align="center" valign="top" >&nbsp;</td>
            <td align="center" valign="top">&nbsp;</td>

            <td align="center" valign="top" style="border: 1px #000 solid;">
                <table width="100%">
                    <tbody><tr><td style="text-align: center">&nbsp;</td></tr>
                    <tr><td name="ppd_content" style="text-align: center"></td></tr>
                    <tr><td name="other_charges_usd_content" style="text-align: center">'.number_format($invoice_summary_data['other_charges_usd'],2,'.',',').'</td></tr>
                    <tr><td name="other_charges_php_content" style="text-align: center">'.number_format($invoice_summary_data['other_charges_php'],2,'.',',').'</td></tr>
                    </tbody></table>
            </td></tr>

        <tr>
            <td align="center" width="25%" valign="top">&nbsp;</td>
            <td align="center" valign="top" style="border: 1px #000 solid;" colspan="2">
                <table width="100%">
                    <tbody><tr><td style="text-align: center"><u>TOTAL VATABLE CHARGES (USD)</u></td></tr>
                    <tr><td style="text-align: center"><u>TOTAL  VATABLE CHARGES (PHP)</u></td></tr>
                    </tbody></table>
            </td>
            <td align="center" valign="top" style="border: 1px #000 solid;">
                <table width="100%">
                    <tbody><tr><td name="total_vatable_charges_usd_content" style="text-align: center">'.number_format($invoice_summary_data['total_vatable_charges_usd'],2,'.',',').'</td></tr>
                    <tr><td name="total_vatable_charges_php_content" style="text-align: center">'.number_format($invoice_summary_data['total_vatable_charges_php'],2,'.',',').'</td></tr>
                    </tbody></table>
            </td></tr>

        <tr>
            <td align="center" width="25%" valign="top">&nbsp;</td>
            <td align="center" valign="top" style="border: 1px #000 solid;" colspan="2">
                <table width="100%">
                    <tbody><tr><td style="text-align: center"><u>TOTAL NON VATABLE CHARGES (USD)</u></td></tr>
                    <tr><td style="text-align: center"><u>TOTAL NON VATABLE CHARGES (PHP)</u></td></tr>
                    </tbody></table>
            </td>
            <td align="center" valign="top" style="border: 1px #000 solid;">
                <table width="100%">
                    <tbody><tr><td name="total_nonvatable_charges_usd_content" style="text-align: center">'.number_format($invoice_summary_data['benefit_host_communities_usd'],2,'.',',').'</td></tr>
                    <tr><td name="total_nonvatable_charges_php_content" style="text-align: center">'.number_format($invoice_summary_data['benefit_host_communities_php'],2,'.',',').'</td></tr>
                    </tbody></table>
            </td></tr>

        <tr>
            <td align="center" width="25%" valign="top">&nbsp;</td>
            <td align="center" valign="top" style="border: 1px #000 solid;" colspan="2">
                <table width="100%">
                    <tbody><tr><td style="text-align: center"><u>TOTAL NET CHARGES (USD)</u></td></tr>
                    <tr><td style="text-align: center"><u>TOTAL NET CHARGES (PHP)</u></td></tr>
                    </tbody></table>
            </td>
            <td align="center" valign="top" style="border: 1px #000 solid;">
                <table width="100%">
                    <tbody><tr><td name="total_net_charges_usd_content" style="text-align: center">'.number_format($invoice_summary_data['total_net_charges_usd'],2,'.',',').'</td></tr>
                    <tr><td name="total_net_charges_php_content" style="text-align: center">'.number_format($invoice_summary_data['total_net_charges_php'],2,'.',',').'</td></tr>
                    </tbody></table>
            </td></tr>

        <tr>
            <td align="center" width="25%" valign="top">&nbsp;</td>
            <td align="center" valign="top" style="border: 1px #000 solid;" colspan="2">
                <table width="100%">
                    <tbody><tr><td style="text-align: center"><u>Value Added Tax (USD)</u></td></tr>
                    <tr><td style="text-align: center"><u>Value Added Tax (PHP)</u></td></tr>
                    </tbody></table>
            </td>
            <td align="center" valign="top" style="border: 1px #000 solid;">
                <table width="100%">
                    <tbody><tr><td name="vat_usd_content" style="text-align: center">'.number_format($invoice_summary_data['vat_usd'],2,'.',',').'</td></tr>
                    <tr><td name="vat_php_content" style="text-align: center">'.number_format($invoice_summary_data['vat_php'],2,'.',',').'</td></tr>
                    </tbody></table>
            </td></tr>

        <tr>
            <td align="center" width="25%" valign="top">&nbsp;</td>
            <td align="center" valign="top" style="border: 1px #000 solid;" colspan="2">
                <table width="100%">
                    <tbody><tr><td style="text-align: center"><u>AMOUNT PAYABLE (USD)</u></td></tr>
                    <tr><td style="text-align: center"><u>INDICATIVE AMOUNT PAYABLE (PHP)</u></td></tr>
                    </tbody></table>
            </td>
            <td align="center" valign="top" style="border: 1px #000 solid;">
                <table width="100%">
                    <tbody><tr><td name="amount_payable_usd_content" style="text-align: center">'.number_format($amount_payable_usd,2,'.',',').'</td></tr>
                    <tr><td name="amount_payable_php_content" style="text-align: center">'.number_format($amount_payable_php,2,'.',',').'</td></tr>
                    </tbody></table>
            </td></tr>
    </table>
    <table width="100%">
        <tr><td>&nbsp;</td> </tr>
        <tr>
            <td align="center" style="background-color: rgb(51,51,51); color: rgb(255,255,255); text-align: center;">IMPORTANT NOTES</td>
        </tr>
        <tr>
            <td>
                <textarea style="width:600px;height:100px"></textarea><br>
            </td>
        </tr>
        <tr>
            <td style="text-align: right" class="small">Not valid for input VAT claim</td>
        </tr>
    </table>
    </div>
    <br/><br/><br/><br/><br/><br/>

</div>

<div id="dialog_invoice">

</div>


<div id="dialog_manual_invoice_viewer">
    <span id="dialog_manual_invoice_viewer_loader"></span>
    <input type="hidden" name="hid_manual_invoice_filepath" id="hid_manual_invoice_filepath" value="">
    <div id="container_manual_invoice">
    </div>
</div>

<div id="dialog_email" style="display:none">
    <div id="dialog_email_loader"></div>
    <table>
        <tr>
            <td>Send to: </td>
            <td><input id="send_to"></td>
        </tr>
        <tr>
            <td>Subject: </td>
            <td><input id="subject" style="width:200px"></td>
        </tr>
        <tr>
            <td style="vertical-align:top">Content </td>
            <td><textarea id="content"></textarea></td>
        </tr>
    </table>
</div>

<style type="text/css">
    .hdr_content {
        font-weight: bold;
    }

    .data_content{
        text-align: right;
    }

    #msg-alert {
        color: red;
    }
</style>

<script src="../js/nicEdit.js"></script>
<script src="../js/date.js"></script>
<script type="text/javascript">
    $.extend({
        getCustomerInvoiceHtmlValues : function(type,dialog_elm, contents_elm_non_existing){
            var billing_month =$('#month').val()
                ,billing_year =$('#year').val()
                ,customer_id = $('#cmb_customers').val();

            $.ajax({
                type: "POST",
                url: '../billing_assistant/invoice_generate_contract_action',
                data: {'action' : 'get-invoice-data','type': type,'billing_month':billing_month,'billing_year':billing_year,'customer_id':customer_id},
                async : false,
                success: function(data){
                    if ( data.total === 0 ) {
                        $('#'+dialog_elm).html($('#'+contents_elm_non_existing).html());
                    }else {
                        $('#'+dialog_elm).html(data.value['type_'+type].html);

                        var due_date = data.value['type_'+type].due_date
                            ,due_date_str = '';
                        if (due_date != null) {
                            due_date_str = Date.parse(due_date).toString('MMM dd, yyyy');
                        }
                        var tableRow = $("td").filter(function() {
                            return $(this).text() == "Due Date";
                        }).next().html(due_date_str).addClass('hdr_content');
                        //$('td[name="due_date_content"]').html();
                    }

                    $('#'+dialog_elm).dialog('open');
                }
            });
        }

        ,generateInvoicesPDF : function(){
            var billing_month =$('#month').val()
                ,billing_year =$('#year').val()
                ,customer_id = $('#cmb_customers').val();


            var parameters = '';
            parameters += 'billing_month=' + billing_month;
            parameters += '&billing_year=' + billing_year;
            parameters += '&customer_id=' + customer_id;
            parameters += '&email=0';
            $.download('../billing_assistant/file_and_email_invoice_generate_contract',parameters);
        }
        ,populateInvoiceSummaryData : function(){
            $('#result').html('');
            $('input[name="filebrowser"]').attr('value','');
            $('#result_loader').html('Please wait while getting data ...');
            $('#fs-upload-manual').hide();
            var billing_month =$('#month').val()
                ,billing_year =$('#year').val()
                ,customer_id = $('#cmb_customers').val();


            $.ajax({
                type: "POST",
                url: '../billing_assistant/invoice_generate_contract_action',
                data: {'action' : 'get-invoice-summary-data','billing_month':billing_month,'billing_year':billing_year,'customer_id':customer_id},
                async : true,
                success: function(data){
                    if (typeof data.value.date_created != 'undefined' ){
                        var invoice_data = data.value;
                        // update data on dialog boxes
                        $('td[name="buyer_name_content"]').html(invoice_data.customer_name);
                        $('td[name="address_content"]').html(invoice_data.address);
                        $('td[name="invoice_reference_no_content"]').html(invoice_data.reference_no);
                        $('td[name="buyer_tin"]').html(invoice_data.tin);
                        $('td[name="buyer_classification"]').html(invoice_data.classification);

                        var billing_sdate = Date.parse(invoice_data.billing_sdate).toString('MMM dd, yyyy');
                        var billing_edate = Date.parse(invoice_data.billing_edate).toString('MMM dd, yyyy');

                        $('td[name="billing_period_content"]').html(billing_sdate + ' to ' + billing_edate);
                        var billing_date = Date.parse(invoice_data.date_created).toString('MMM dd, yyyy');
                        $('td[name="billing_date_content"]').html(billing_date);

                        var contracted_capacity = $.formatNumberToSpecificDecimalPlaces(parseFloat(invoice_data.contracted_capacity),2);
                        $('td[name="contracted_capacity_content"]').html(contracted_capacity);

                        var total_qty = $.formatNumberToSpecificDecimalPlaces(parseFloat(invoice_data.total_quantity),2);
                        $('td[name="total_qty_content"]').html(total_qty);

                        var resulting_capacity_factor = $.formatNumberToSpecificDecimalPlaces(parseFloat(invoice_data.resulting_capacity_factor),0);
                        $('td[name="resulting_capacity_factor_content"]').html(resulting_capacity_factor + ' %');

                        var capacity_fee = $.formatNumberToSpecificDecimalPlaces(parseFloat(invoice_data.capacity_fee),5);
                        $('td[name="capacity_fee_content"]').html(capacity_fee);

                        var energy_fee = $.formatNumberToSpecificDecimalPlaces(parseFloat(invoice_data.energy_fee_usd),5);
                        $('td[name="energy_fee_content"]').html(energy_fee);

                        var initial_energy_fee = $.formatNumberToSpecificDecimalPlaces(parseFloat(invoice_data.initial_energy_fee_usd),5);
                        $('td[name="initial_energy_fee_content"]').html(initial_energy_fee);

                        var actual_cif = $.formatNumberToSpecificDecimalPlaces(parseFloat(invoice_data.actual_cif_usd),5);
                        $('td[name="actual_cif"]').html(actual_cif);

                        var base_cif = $.formatNumberToSpecificDecimalPlaces(parseFloat(invoice_data.base_cif_usd),5);
                        $('td[name="base_cif_content"]').html(base_cif);

                        var adj_due_to_import_duties = $.formatNumberToSpecificDecimalPlaces(parseFloat(invoice_data.adjustment_due_usd),5);
                        $('td[name="adj_due_to_import_duties_content"]').html(adj_due_to_import_duties);

                        var contract_fee = $.formatNumberToSpecificDecimalPlaces(parseFloat(invoice_data.contract_fee_usd),5);
                        $('td[name="contract_fee_content"]').html(contract_fee);

                        var ppd = $.formatNumberToSpecificDecimalPlaces(parseFloat(invoice_data.ppd_usd),2);
                        $('td[name="ppd_content"]').html(ppd);

                        var fx_adjustments = $.formatNumberToSpecificDecimalPlaces(parseFloat(invoice_data.fx_adjustments_usd),2);
                        $('td[name="fx_adjustments_content"]').html(fx_adjustments);

                        var redelivered_quantity_ltf = $.formatNumberToSpecificDecimalPlaces(parseFloat(invoice_data.redelivered_quantity),2);
                        $('td[name="redelivered_quantity_ltf_content"]').html(redelivered_quantity_ltf);

                        var redelivered_quantity_deficiency = $.formatNumberToSpecificDecimalPlaces(parseFloat(invoice_data.redelivered_quantity_deficiency),2);
                        $('td[name="redelivered_quantity_deficiency_content"]').html(redelivered_quantity_deficiency);

                        var energy_fee_payment_due_to_deficiency = $.formatNumberToSpecificDecimalPlaces(parseFloat(invoice_data.energy_fee_payment_due_deficiency_usd),2);
                        $('td[name="energy_fee_payment_due_to_deficiency_content"]').html(energy_fee_payment_due_to_deficiency);

                        var energy_fee_adj_redelivered_qty = $.formatNumberToSpecificDecimalPlaces(parseFloat(invoice_data.energy_fee_adjustment_rq_usd),2);
                        $('td[name="energy_fee_adj_redelivered_qty"]').html(energy_fee_adj_redelivered_qty);


                        var other_charges = $.formatNumberToSpecificDecimalPlaces(parseFloat(invoice_data.other_charges_usd),2);
                        $('td[name="other_charges_content"]').html(other_charges);

                        var fx_adjustments = parseFloat(invoice_data.fx_adjustments_usd);
                        var energy_fee_payment_due_to_deficiency = parseFloat(invoice_data.energy_fee_payment_due_deficiency_usd);
                        var other_charges = parseFloat(invoice_data.other_charges_usd);

                        var total_amount_payable = fx_adjustments + energy_fee_payment_due_to_deficiency + other_charges;

                        $('td[name="total_amount_payable_content"]').html($.formatNumberToSpecificDecimalPlaces(total_amount_payable,2));

                        var market_fees_adjustment_php = parseFloat(invoice_data.market_fees_adjustment_php);
                        var market_fees_php = parseFloat(invoice_data.market_fees_php);
                        var delivery_charges_php = parseFloat(invoice_data.delivery_charges_php);
                        var benefit_host_communities_php = parseFloat(invoice_data.benefit_host_communities_php);
                        var other_charges_php = parseFloat(invoice_data.other_charges_php);
                        var wesm_charges = market_fees_adjustment_php+market_fees_php;
                        $('td[name="wesm_charges"]').html($.formatNumberToSpecificDecimalPlaces(wesm_charges,2));
                        $('td[name="delivery_charges_php"]').html($.formatNumberToSpecificDecimalPlaces(delivery_charges_php ,2));
                        $('td[name="govt_charges_php"]').html($.formatNumberToSpecificDecimalPlaces(benefit_host_communities_php ,2));
                        $('td[name="total_other_charges_php"]').html($.formatNumberToSpecificDecimalPlaces(other_charges_php ,2));

                        var total_payment = wesm_charges +delivery_charges_php +other_charges_php;
                        $('td[name="total_payment_attachment2_php"]').html($.formatNumberToSpecificDecimalPlaces(total_payment ,2));

                        var contract_fee_usd = parseFloat(invoice_data.contract_fee_usd);
                        $('td[name="generation_rate_usd_content"]').html($.formatNumberToSpecificDecimalPlaces(contract_fee_usd ,2));

                        var contract_fee_php = parseFloat(invoice_data.contract_fee_php);
                        $('td[name="generation_rate_php_content"]').html($.formatNumberToSpecificDecimalPlaces(contract_fee_php ,2));

                        var contract_price_usd = parseFloat(invoice_data.contract_price_usd);
                        $('td[name="contract_price_usd_content"]').html($.formatNumberToSpecificDecimalPlaces(contract_price_usd ,2));

                        var other_charges_usd = parseFloat(invoice_data.other_charges_usd);
                        $('td[name="other_charges_usd_content"]').html($.formatNumberToSpecificDecimalPlaces(other_charges_usd ,2));

                        var other_charges_php = parseFloat(invoice_data.other_charges_php);
                        $('td[name="other_charges_php_content"]').html($.formatNumberToSpecificDecimalPlaces(other_charges_php ,2));

                        var total_vatable_charges_usd = parseFloat(invoice_data.total_vatable_charges_usd);
                        $('td[name="total_vatable_charges_usd_content"]').html($.formatNumberToSpecificDecimalPlaces(total_vatable_charges_usd ,2));

                        var total_vatable_charges_php = parseFloat(invoice_data.total_vatable_charges_php);
                        $('td[name="total_vatable_charges_php_content"]').html($.formatNumberToSpecificDecimalPlaces(total_vatable_charges_php ,2));

                        var total_nonvatable_charges_usd = parseFloat(invoice_data.benefit_host_communities_usd);
                        $('td[name="total_nonvatable_charges_usd_content"]').html($.formatNumberToSpecificDecimalPlaces(total_nonvatable_charges_usd ,2));

                        var total_nonvatable_charges_php = parseFloat(invoice_data.benefit_host_communities_php);
                        $('td[name="total_nonvatable_charges_php_content"]').html($.formatNumberToSpecificDecimalPlaces(total_nonvatable_charges_php ,2));

                        var total_net_charges_usd = parseFloat(invoice_data.total_net_charges_usd);
                        $('td[name="total_net_charges_usd_content"]').html($.formatNumberToSpecificDecimalPlaces(total_net_charges_usd ,2));

                        var total_net_charges_php = parseFloat(invoice_data.total_net_charges_php);
                        $('td[name="total_net_charges_php_content"]').html($.formatNumberToSpecificDecimalPlaces(total_net_charges_php ,2));

                        var vat_usd = parseFloat(invoice_data.vat_usd);
                        $('td[name="vat_usd_content"]').html($.formatNumberToSpecificDecimalPlaces(vat_usd ,2));

                        var vat_php = parseFloat(invoice_data.vat_php);
                        $('td[name="vat_php_content"]').html($.formatNumberToSpecificDecimalPlaces(vat_php ,2));

                        var amount_payable_usd = vat_usd + total_net_charges_usd;
                        var amount_payable_php = vat_php + total_net_charges_php;
                        $('td[name="amount_payable_usd_content"]').html($.formatNumberToSpecificDecimalPlaces(amount_payable_usd ,2));
                        $('td[name="amount_payable_php_content"]').html($.formatNumberToSpecificDecimalPlaces(amount_payable_php ,2));

                        var manual_invoice_link_html = '';
                        if ( parseInt(invoice_data.is_with_uploaded_manual_invoice,10) === 1 ) {
                            manual_invoice_link_html = '<td style="text-align: center;cursor: pointer" id="manual_invoice">' +
                                '<span class="ui-icon ui-icon-document" style="margin:0 auto"></span>' +
                                'Manual Invoice</td>';
                        }
                        var contents ='<button id="btn_send_email" type="button">Sent to Email</button>' +
                            '<button id="btn_generate_pdf" type="button">Generate PDF</button>' +
                            '<table><tr>' +
                            '<td style="text-align: center;cursor: pointer;" id="transmittal_1">' +
                            '<span class="ui-icon ui-icon-document" style="margin:0 auto"></span>' +
                            'Transmittal 1' +
                            '</td>' +
                            '<td style="text-align: center;cursor: pointer" id="transmittal_2">' +
                            '<span class="ui-icon ui-icon-document" style="margin:0 auto"></span>' +
                            'Transmittal 2' +
                            '</td><td style="text-align: center;cursor: pointer" id="invoice">' +
                            '<span class="ui-icon ui-icon-document" style="margin:0 auto"></span>' +
                            'Power Bill' +
                            '</td>' + manual_invoice_link_html + '</tr></table>';

                        $('#result').html(contents);

                        $('#dialog_transmittal_1').html($('#transmittal_1_contents').html());
                        $('#dialog_transmittal_2').html($('#transmittal_2_contents').html());
                        $('#dialog_invoice').html($('#invoice_contents').html());
                        $('#result_loader').html('');
                        $('#fs-upload-manual').show();
                    }else {
                        $('#result').html('No records found.');
                        $('#result_loader').html('');
                        $('#fs-upload-manual').hide();
                    }
                }
            });

        }
        ,sendToEmail : function() {
            $('#dialog_email_loader').html('&nbsp;&nbsp;&nbsp;Sending Email &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">')
            var billing_month =$('#month').val()
                ,billing_year =$('#year').val()
                ,customer_id = $('#cmb_customers').val();

            var parameters = {};
            parameters['billing_month'] = billing_month;
            parameters['billing_year'] = billing_year;
            parameters['customer_id'] = customer_id;
            parameters['email'] = 1;
            parameters['send_to'] = $('#send_to').val();
            parameters['subject'] = $('#subject').val();
            parameters['content'] = $('#content').val();
            $.ajax({
                type: "POST",
                url: '../billing_assistant/file_and_email_invoice_generate_contract',
                data: parameters,
                success: function(msg){
                    $('#dialog_email_loader').html('');
                    console.log(msg)
                }
            });

        }

        ,submitManualInvoiceFile : function(){
            var path = '../billing_assistant/invoice_generate_contract_submit_manual_invoice';

            if($('#filebrowser').val() == "") {
                return false;
            }else {
                var parameters = {};
                var billing_month =$('#month').val()
                    ,billing_year =$('#year').val()
                    ,customer_id = $('#cmb_customers').val();

                parameters['billing_month'] = billing_month;
                parameters['billing_year'] = billing_year;
                parameters['customer_id'] = customer_id;
                var options = {target:'#msg-alert',
                    url:path,
                    data: parameters,
                    beforeSubmit: function() {
                        $('#msg-alert').html('Loading...')
                    },
                    success: function(data) {
                        var ret = $.parseJSON(data);
                        if ( ret === null || parseInt(ret.success,10)  === 1 ) {
                            $('#msg-alert').html('')
                            $.populateInvoiceSummaryData();
                        }else {
                            $('#msg-alert').html(ret.message)
                        }



                    }};
                $('#frm1').ajaxSubmit(options);
            }
        }
        ,getManualInvoiceFilePath : function(){
            var billing_month =$('#month').val()
                ,billing_year =$('#year').val()
                ,customer_id = $('#cmb_customers').val();

            $('#container_manual_invoice').html('');
            $('#dialog_manual_invoice_viewer_loader').html('Please wait, getting pdf file...');
            $.ajax({
                 type: "POST"
                ,url: '../billing_assistant/invoice_generate_contract_action'
                ,data: {'action' : 'get-filepath','billing_month':billing_month,'billing_year':billing_year,'customer_id':customer_id},
                success: function(data){
                    var confimed = typeof data.value.confirmed != 'undefined' ? parseInt(data.value.confirmed,10) : 0;
                    var filepath = typeof data.value.filepath != 'undefined' ? data.value.filepath : '';
                    var baseurl = '<?php echo $base_url;?>';
                    var siteurl = document.location.protocol+'//'+document.location.hostname+baseurl+'/billing_assistant/invoice_generate_contract_get_manual_invoice_file?filepath=';
                    $('#hid_manual_invoice_filepath').attr('value',filepath);
                    if ( confimed === 1 ) {
                        $('#btn_confirmed_manual_invoice').attr('disabled',true);
                    }else {
                        $('#btn_confirmed_manual_invoice').removeAttr('disabled');
                    }

                    if ( filepath.length > 0 ) {
                        var contents = ' <object data="'+siteurl+filepath+'" type="application/pdf" width="96%" height="90%">' +
                            'alt : <a href="'+siteurl+filepath+'">'+filepath+'</a>' +
                            '</object>';
                        $('#container_manual_invoice').html(contents);
                    }
                    $('#dialog_manual_invoice_viewer_loader').html('');
                    $('#dialog_manual_invoice_viewer').dialog('open');
                }
            });
        }
    });
    $(document).ready(function(){
        new nicEditors.allTextAreas({buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript']})
        $('#dialog_transmittal_1').dialog({
            autoOpen: false,
            show: "drop",
            hide: "drop",
            width: 650,
            modal: true
        });
        $('#transmittal_1').unbind('click').live('click', function(e){
            e.preventDefault();
            $.getCustomerInvoiceHtmlValues(1,'dialog_transmittal_1','transmittal_1_contents');
        })
        $('#dialog_transmittal_2').dialog({
            autoOpen: false,
            show: "drop",
            hide: "drop",
            width: 650,
            modal: true
        });
        $('#transmittal_2').unbind('click').live('click', function(e){
            e.preventDefault();
            $.getCustomerInvoiceHtmlValues(2,'dialog_transmittal_2','transmittal_2_contents');
        })
        $('#dialog_invoice').dialog({
            autoOpen: false,
            show: "drop",
            hide: "drop",
            width: 650,
            modal: true
        });

        $('#invoice').unbind('click').live('click', function(e){
            e.preventDefault();
            $.getCustomerInvoiceHtmlValues(3,'dialog_invoice','invoice_contents');
        });

        $('#dialog_manual_invoice_viewer').dialog({
            autoOpen: false,
            show: "drop",
            hide: "drop",
            width: 650,
            modal: true
        });

        $('#manual_invoice').unbind('click').live('click', function(e){
            e.preventDefault();
            $.getManualInvoiceFilePath();
        });

        $('#btn_generate_pdf').unbind().live('click',function(){
            $.generateInvoicesPDF();
        });


        $('#btn_send_email').unbind('click').live('click', function(e){
            e.preventDefault();
            $('#send_to').attr('value','');
            $('#subject').attr('value','');
            $('#content').attr('value','');
            
            $('#dialog_email').dialog({
                width: 500
                ,height: 400
                ,modal: true
                ,show: {
                    effect: "slide",
                    duration: 600
                }
                ,hide: {
                    effect: "slide",
                    duration: 600
                }
                ,buttons : {
                    'Submit' : function(){
                        if (!$('#send_to').val()) {
                            alert('No Recipient')
                        } else {
                            $.sendToEmail();
                            $( this ).dialog( "close" );
                        }
                    }
                    ,'Cancel' : function(){
                        $( this ).dialog( "close" );
                    }
                }
            });
        })

        $('#btn_retrieve').unbind().live('click',function() {
            $.populateInvoiceSummaryData();
        });

        $('#upload_btn').unbind().live('click',function(e){
                e.preventDefault();
                $.submitManualInvoiceFile();

        });


        $('#btn_retrieve').trigger('click');

    });


</script>