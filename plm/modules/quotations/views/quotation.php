<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Quotation</title>
	<style type="text/css">
	td{
	    /*height: 50px; */
	    /*width:50px;*/
	}
	#cssTable td 
	{
	    text-align:center; 
	    vertical-align:middle;
	}
	#spare_parts td{
		text-align:center; 
	    vertical-align:middle;
	}
	table {
		border-collapse: collapse;
	}
	th, td {
		padding: 0;
	}
	.noBorder{ border-bottom:none; }
	.noBorderTop{ border-top:none; }
	</style>
</head>
<body>
	<div style="height:100px; width:100%;">
	</div>
	<table width="100%" border="1" cellspacing="0" id="cssTable">
		<thead>
			<tr>
				<th width="30%">Company</th>
				<th colspan="2" class="noBorder" style="border-bottom: hidden; width:40%"><?php echo $quotation->name; ?></th>
				<th class="noBorder" width="15%">Machine</th>
				<th class="noBorder" width="15%"><?php echo $quotation->machine_name; ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td rowspan="3">Attn:&nbsp;&nbsp;<?php echo $quotation->contact_person; ?></td>
				<td>
					<tr>
						<td style="text-align:left;">cc:</td>
						<td>Date</td>
						<td><?php echo date('d/m/Y',strtotime($quotation->quotation_date)); ?></td>
						<td rowspan="2"><?php echo $quotation->qo_no; ?></td>
					</tr>
				</tr>
				<tr>
					<td style="text-align:left;width:20%;">cc:</td>
					<td style="text-align:center;">PAGES</td>
					<td style="text-align:center;">1/1</td>
				</tr>
			</tr>
		</tbody>
	</table>
	<div style="line-height: 4px;padding-bottom: 2px;">
		<p>Dear sir,</p>
		<p>With reference to your inquiry, we are pleased to submit our best offer for the following spare parts.</p>
	</div>
	<?php
		// echo '<pre>';
		// print_r($quotation_items);
		// echo '</pre>';
	?>
	<table width="100%" border="1" cellspacing="0" cellpadding="0" id="spare_parts">
		<thead>
			<tr>
				<th width="5%">S#</th>
				<th width="15%">Part No.</th>
				<th width="20%">Description</th>
				<th width="10%">QTY</th>
				<th width="10%">Unit Price</th>
				<th width="10%">Discount</th>
				<th width="10%">Discount Price</th>
				<th width="10%">Total Price</th>
				<th width="10%">Delivery Time</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				if(!empty($quotation_items)){
					$sum = 0;
					$i = 0;
					foreach($quotation_items as $row){
						$sum += $row->sub_total;
			?>
			<tr>
				<td><?php echo $i+=1; ?></td>
				<td><?php echo $row->code; ?></td>
				<td><?php echo $row->description; ?></td>
				<td><?php echo $row->quantity; ?></td>
				<td><?php echo $row->price; ?></td>
				<?php
					if($row->discount_type == 0){
				?>
				<td>0%</td>
				<?php
					}else{
				?>
				<td><?php echo $disc = $this->quotations_model->getDiscountValType($row->discount_type); ?>%</td>
				<?php
					}
				?>
				<td><?php echo $row->discount_value; ?></td>
				<td><?php echo $row->sub_total;//echo number_format((float)(($row->quantity)*($row->price)), 2, '.', ''); ?></td>
				<td><?php echo date('d/m/Y',strtotime($row->delivery_date)); ?></td>
			</tr>
			<?php
					}
				}
			?>
			<tr>
				<td></td>
				<td colspan="6" style="text-align:right;">Total Saudi Riyal &nbsp;&nbsp;</td>
				<td><?php echo number_format((float)($sum), 2, '.', ''); ?></td>
				<td></td>
			</tr>
			<!--<tr>
				<td></td>
				<td colspan="6" style="text-align:right;">Discount &nbsp;&nbsp;</td>
				<td><?php echo $row->discount_value; ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="6" style="text-align:right;">Total Discounted Price &nbsp;&nbsp;</td>
				<td><?php echo number_format((float)($sum), 2, '.', ''); ?></td>
				<td></td>
			</tr>-->
			<tr>
				<td></td>
				<td colspan="6" style="text-align:right;">Gross Total &nbsp;&nbsp;</td>
				<td><?php echo $quotation->total; ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="6" style="text-align:right;">Service Charge&nbsp;&nbsp;</td>
				<td><?php echo $quotation->charges; ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="6" style="text-align:right;">Freight Charge&nbsp;&nbsp;</td>
				<td><?php echo $quotation->freight; ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="6" style="text-align:right;">Net Total&nbsp;&nbsp;</td>
				<td><?php echo number_format((float)(($quotation->total)+($quotation->charges)+($quotation->freight)),2,'.',''); ?></td>
				<td></td>
			</tr>
		</tbody>
	</table>
	<div style="line-height: 4px;padding-bottom: 2px;">
		<p><b><u>Terms & Conditions</u></b></p>
		<p><strong>Validity : </strong> <?php echo $quotation->validity; ?></p>
		<p><strong>Delivery Place : </strong><?php echo $quotation->delivery_place; ?> </p>
		<p><strong>Payment term : </strong> <?php echo $quotation->payment_terms; ?></p>
	</div>

	<div style="line-height: 4px;padding-bottom: 2px;">
		<p><b><u>Account Details</u></b></p>
		<p><b>Account Name : </b> <?php echo $quotation->account_name; ?></p>
		<p><b>Account No : </b> <?php echo $quotation->account_no; ?></p>
		<p><b>IBAN : </b> <?php echo $quotation->iban; ?></p>
		<p><b>Bank Name : </b> <?php echo $quotation->bank_name; ?></p>
		<p><b>Swift Code : </b> <?php echo $quotation->swift_code; ?></p>
	</div>
	<div style="line-height:4px;">
		<p>Best regards,</p>
		<br/>
		<p>________________________</p>
		<p style="">Sales Manager</p>
	<div>
</body>
</html>