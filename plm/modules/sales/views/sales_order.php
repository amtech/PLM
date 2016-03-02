<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $page_title; ?></title>
	<style>
		.heading{
			text-align:right;
			width:100%;
		}
		.main{
			width:100%;
		}
		.sub-heading{
			float:right;
			width:70%;
			margin-bottom:10px;
		}
		.sub-heading table{
			float:right;
			width:100%;
		}
		.sales_order_desc{
			width:100%;
			margin-bottom:10px;
		}
		.sales_order_desc table{
			width:100%;
		}
		.payment_term{
			width:100%;
			margin-bottom:10px;
		}
		.payment_term table{
			width:100%;
		}
		.address_ship{
			width:100%;
			margin-bottom:10px;
		}
		.address_ship table{
			width:100%;
		}
		.address_ship table td{
			height:50px;
		}
		.ship_via{
			width:100%;
			margin-bottom:10px;
		}
		.ship_via table{
			width:100%;
		}
		.parts_description{
			width:100%;
			margin-bottom:2px;
		}
		.parts_description table{
			width:100%;
		}
		.footer{
			width:100%;
		}
		.sign{
			margin-top:50px; 
			width:50%;
			float:left;
		}
		.sign table{
			float:left;
		}
		.sign th{
			float:left;
			text-align:left;
		}
		.sign table tr{
			margin-bottom:10px;
		}
		.total{
			width:50%;
			float:right;
		}
		.total table{
			width:100%;
			float:right;
			margin-top:-30px;
		}
		table {
			border-collapse: collapse;
		}
	</style>
</head>
<body>
	<div style="height:100px;width:100%;"></div>
	<div class="heading">
		<h2><?php echo $page_title; ?></h2>
	</div>
	<div class="main">
		<div class="sub-heading">
			<table border="1" cellpadding="4" cellspacing="0">
				<tr>
					<th>SALES ORDER NO.</th>
					<td>&nbsp;&nbsp;&nbsp;<?php echo $sales->po_no; ?></td>
					<th>DATE</th>
					<td>&nbsp;&nbsp;&nbsp;<?php echo date('d-m-Y',strtotime($sales->date)); ?></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="sales_order_desc">
		<table cellpadding="4" cellspacing="0" border="1">
			<tr>
				<th>CLIENT P.O.NO.</th>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<th>Soilmec Quotation NO.#</th>
				<td>&nbsp;&nbsp;&nbsp;<?php echo $sales->quotation_no; ?></td>
			<tr>
		</table>
	</div>
	<div class="payment_term">
		<table cellpadding="4" cellspacing="0" border="1">
			<tr>
				<th>Payment Term</th>
				<td>&nbsp;&nbsp;&nbsp;<?php echo $sales->payment_terms; ?></td>
				<th>Ship Date</th>
				<td>&nbsp;&nbsp;&nbsp;<?php echo date('d-m-Y',strtotime($sales->ship_date)); ?></td>
			</tr>
		</table>
	</div>
	<div class="address_ship">
		<table cellspacing="0" cellpadding="4" border="1">
			<tr>
				<th>NAME/ADDRESS</th>
				<th>Ship To</th>
			</tr>
			<tr>
				<td><?php echo $sales->name; echo '<br/>'; echo $sales->address; ?></td>
				<td><?php echo $sales->ship_to; ?></td>
			</tr>
		</table>
	</div>
	<div class="ship_via">
		<table cellspacing="0" cellpadding="4" border="1">
			<tr>
				<th>Ship Via</th>
				<td>&nbsp;&nbsp;&nbsp;<?php echo $sales->ship_via; ?></td>
				<th>Delivery Instruction</th>
				<td>&nbsp;&nbsp;&nbsp;<?php echo $sales->delivery; ?></td>
			</tr>
		</table>
	</div>
	<div class="parts_description">
		<table cellspacing="0" cellpadding="4" border="1">
			<tr>
				<th>SR No.</th>
				<th>Code</th>
				<th>Description</th>
				<th>QTY</th>
				<th>Rate</th>
				<th>Availability</th>
				<th>To Pick</th>
				<th>Amount</th>
			</tr>
			<?php 
				if(!empty($sale_items)){
					$i = 0;
					foreach($sale_items as $row){
			?>
			<tr>
				<td><?php echo $i+= 1; ?></td>
				<td><?php echo $row->code; ?></td>
				<td><?php echo $row->description; ?></td>
				<td><?php echo $row->quantity; ?></td>
				<td><?php echo $row->price; ?></td>
				<td><?php echo ucfirst($row->item_received); ?></td>
				<td></td>
				<td><?php echo $row->sub_total; ?></td>
			</tr>
			<?php
					}
				}
			?>
		</table>
	</div>
	<div class="footer">
		<div class="sign">
			<table border="0" cellpadding="4" cellspacing="0" width="100%">
				<tr><th>Signature</th></tr>
				<tr><td>_______________________</td></tr>
			</table>
		</div>
		<div class="total">
			<table cellpadding="4" cellspacing="0" border="1">
				<tr>
					<th>Total</th>
					<td style="text-align:right;">EUR <?php echo $sales->total; ?></td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>