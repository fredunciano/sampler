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
        		<th>Billing Period</th>
        		<td>
        			<select id="month">
        				<?php
        					for ($x=1;$x<=24;$x++) {
        						echo '<option>'.date('F',mktime(0,0,0,$x,1,date('Y'))).'</option>';
        					}
        				?>
        			</select>
        			<select id="year">
        				<?php
        					for ($x=date('Y');$x>=date('Y')-2;$x--) {
        						echo '<option>'.$x.'</option>';
        					}
        				?>
        			</select>
        			&nbsp;<button>Retrieve</button>
        		</td>
        	</tr>
        </table>
    </fieldset><br>
    <fieldset class="fs-blue" id="fs-result" style="width:100%">
        <legend>Result&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</legend>
        
        <div id="result">
        	<table>
        		<tr>
        			<td style="text-align: center;width:30%;cursor: pointer;" id="invoice_for_wesm">
        				<span class="ui-icon ui-icon-document" style="margin:0 auto"></span>
        				Invoice for WESM
        			</td>
        		</tr>
        	</table>
        	
        </div>
    </fieldset>
    
    <br><br><br><br><br>
</div>
<div id="dialog_invoice_for_wesm">
	<table style="border:5px green solid">
		<tr>
			<th style="text-align: center" colspan="4"><h2>GMCP</h2></th>
		</tr>
		<tr>
			<th style="text-align: center" colspan="4"><h3>GNPower Mariveles Coal Plant Ltd. Co</h3> <br> <h4>Power Bill</h4></th>
		</tr>
		<tr>
			<th style="text-align: center;background: #333333;color: #FFF" colspan="4"><b>CUSTOMER DETAILS</b></th>
		</tr>
		<tr>
			<td>Customer Name</td><td></td><td>Invoice No.</td><td></td>
		</tr>
		<tr>
			<td>Address</td><td></td><td>Billing Period</td><td></td>
		</tr>
		<tr>	
			<td>Classification</td><td></td><td>Billing Date</td><td></td>
		</tr>
		<tr>	
			<td>Buyer's TIN</td><td></td><td>Due Date</td><td></td>
		</tr>
		<tr>	
			<td>Seller's TIN</td><td></td><td></td><td></td>
		</tr>
		<tr>
			<th style="text-align: center;background: #333333;color: #FFF" colspan="4"><b>BILLING PARTICULARS</b></th>
		</tr>
		<tr>
			<td>Contracted Capacity (kW)</td><td></td><td>Buyer's Quantity for the Billing Period (kWh)</td><td></td>
		</tr>
		<tr>
			<th style="text-align: center;background: #333333;color: #FFF" colspan="4"><b>BILLING DETAILS</b></th>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td colspan="4">
				<table cellspacing="1" style="width:100%">
					<tr>
						<td style="text-align: center;background: #333333;color: #FFF">ITEM</td>
						<td style="text-align: center;background: #333333;color: #FFF">BILLING DETERMINANTS</td>
						<td style="text-align: center;background: #333333;color: #FFF">RATES</td>
						<td style="text-align: center;background: #333333;color: #FFF">AMOUNT</td>
					</tr>
					<tr>
						<td style="border: 1px #000 solid;text-align: center"><u>GENERATION CHARGES</u><br>WESM Charges</td>
						<td style="border: 1px #000 solid;text-align: center"><u>Spot Quantity (kWh)</u></td>
						<td style="border: 1px #000 solid;text-align: center"><u>WESM Rate (Php/kWh)</u></td>
						<td style="border: 1px #000 solid;text-align: center"><u>Trading Amount (Php)</u></td>
					</tr>
					<tr>
						<td style="border: 1px #000 solid;text-align: center"><u>ADJUSTMENT</u><br>
							NSS <br> Service Charge <br> VAT
						</td>
						<td style="border: 1px #000 solid;text-align: center"><u>Spot Quantity (kWh)</u></td>
						<td style="border: 1px #000 solid;text-align: center"></td>
						<td style="border: 1px #000 solid;text-align: center"></td>
					</tr>
					<tr>
						<td style="border: 1px #000 solid;text-align: center">
							<ul>TOTAL AMOUNT DUE</ul>
						</td>
						<td></td>
						<td></td>
						<td style="border: 1px #000 solid;text-align: center"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
		<td colspan="4" style="text-align: center;background: #333333;color: #FFF">IMPORTANT NOTES</td>
		</tr>
		<tr>
			<td colspan="4">
			<textarea style="width:600px;height:100px"></textarea><br>
			<button>Confirm</button>	
			</td>
		</tr>
		<tr>
			<td colspan="4" style="text-align: center" class="small">
				GNPower Mariveles Coal Plant Ltd. Co. (GMCP)- 1908 The Orient Square, Ortigas Jr. Road, Ortigas, Pasig													
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>
	</table>
</div>

<script src="../js/nicEdit.js"></script>
<script>
new nicEditors.allTextAreas({buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript']})
$('#dialog_invoice_for_wesm').dialog({
	autoOpen: false,
	show: "drop",
	hide: "drop",
	width: 650
});
$('#invoice_for_wesm').unbind('click').bind('click', function(e){
	e.preventDefault();
	$('#dialog_invoice_for_wesm').dialog('open');
})
</script>