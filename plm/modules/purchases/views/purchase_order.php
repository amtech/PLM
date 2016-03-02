<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $page_title; ?></title>
	<style>
		p{
			line-height:7px;
		}
		.clear{
			clear:both;
		}
		table {
			border-collapse: collapse;
		}
		.regards{
			padding-top:10px;
		}
	</style>
</head>
<body>
	<div style="height:100px;width:100%;"></div>
	<table border="1" cellspacing="0" cellpadding="0" width="100%" id="po">
		<tr>
			<td align="center" colspan="4">
				<b><?php echo $page_title; ?></b>
			</td>
		</tr>
		<tr>
			<td>To</td>
			<td><?php echo $purchase->company_name; ?></td>
			<td>Date:</td>
			<td><?php echo date('d-m-Y',strtotime($purchase->order_date)); ?></td>
		</tr>
		<tr>
			<td>Attn.:</td>
			<td><?php echo $purchase->contact_person; ?></td>
			<td>Our Ref.:</td>
			<td><?php echo $purchase->po_no; ?></td>
		</tr>
		<tr>
			<td>Email:</td>
			<td><?php echo $purchase->email; ?></td>
			<td>Responsible:</td>
			<td></td>
		</tr>
		<tr>
			<td>CC:</td>
			<td></td>
			<td>Dept.:</td>
			<td></td>
		</tr>
		<tr>
			<td>Your Ref:</td>
			<td></td>
			<td>P.O. #</td>
			<td><?php echo $purchase->po_no; ?></td>
		</tr>
	</table>
	<div>
		<p>Dear Sir,</p>
		<p>We would like to confirm our purchase order for the following spare parts item.</p>
	</div>
	
	<table width="100%" cellspacing="0" cellpadding="0" border="1">
		<tr>
			<th>ID</th>
			<th>Code</th>
			<th>Description</th>
			<th>U/M</th>
			<th>QTY</th>
			<th>Unit Price (EUR)</th>
			<th>Total Price (EUR)</th>
			<!--<th>Delivery Time</th>-->
		</tr>
		<?php 
			if(!empty($parts)){
				$i = 0;
				foreach($parts as $row){
		?>
		<tr>
			<td><?php echo $i+= 1; ?></td>
			<td><?php echo $row->code; ?></td>
			<td><?php echo $row->description; ?></td>
			<td></td>
			<td><?php echo $row->part_quantity; ?></td>
			<td style="text-align:center;"><?php echo $row->cost; ?></td>
			<td style="text-align:center;"><?php echo $row->sub_total; ?></td>
			<!--<td><?php echo date('d-m-Y',strtotime($purchase->expected_date)); ?></td>-->
		</tr>
		<?php
				}
			}
		?>
		<tr>
			<td colspan="6" style="text-align:right;"><b>Total Amount is EURO&nbsp;&nbsp;&nbsp;</b></td>
			<td style="text-align:center;"><?php echo $purchase->total; ?></td>
			<!--<td>SR</td>-->
		</tr>
		<tr>
			<td colspan="9"><b>Amount in word:</b></td>
		</tr>
		<tr>
			<td colspan="9"><b><?php echo ucwords($amount_words); ?> EURO</b></td>
		</tr>
	</table>
	<br/>
	<table width="100%" border="1" cellspacing="0" cellpadding="0"> 
		<tr>
			<td width="30%">PAYMENT: </td>
			<td></td>
		</tr>
		<tr>
			<td>SHIPPING METHOD: </td>
			<td>&nbsp;&nbsp;&nbsp;<?php echo $purchase->ship_via; ?></td>
		</tr>
		<tr>
			<td>Delivery Terms </td>
			<td> </td>
		</tr>
		<tr>
			<td>Shipping Instruction:	</td>
			<td> &nbsp;&nbsp;&nbsp;<?php echo $purchase->ship_instruction; ?></td>
		</tr>
	</table>
	<div class="regards">
		<p>Waiting for your prompt order confirmation by return.</p>
		<div style="margin-left:50px;">
			<p>Sincerely,</p>
		</div>
		<br/>
		<p>___________________________</p>
	</div>
</body>
</html>