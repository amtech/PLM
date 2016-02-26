<!DOCTYPE html>
<html lang="en">
<head>
	<title>Sales Order</title>
	<style>
		.heading{
			text-align:right;
			width:100%;
		}
		.sub-heading{
			width:100%;
			margin-bottom:55px;
		}
		.sub-heading table{
			float:right;
			width:70%;
		}
		.sales_order_desc{
			width:100%;
			margin-bottom:2px;
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
			margin-bottom:2px;
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
		.sign{
			margin-top:50px; 
			width:50%;
			float:left;
		}
		.sign th{
			float:left;
		}
		.sign table tr{
			margin-bottom:10px;
		}
		.total{
			width:50%;
			float:right;
		}
		.total table{
			float:right;
		}
	</style>
</head>
<body>
	<div class="heading">
		<h2>Sales Order</h2>
	</div>
	<div class="sub-heading">
		<table border="1" cellpadding="4" cellspacing="0">
			<tr>
				<th>SALES ORDER NO.</th>
				<td>&nbsp;&nbsp;&nbsp;SM15-681</td>
				<th>DATE</th>
				<td>&nbsp;&nbsp;&nbsp;26-02-2016</td>
			</tr>
		</table>
	</div>
	<div class="sales_order_desc">
		<table cellpadding="4" cellspacing="0" border="1">
			<tr>
				<th>CLIENT P.O.NO.</th>
				<td>&nbsp;&nbsp;&nbsp;</td>
				<th>Soilmec Quotation NO.#</th>
				<td>&nbsp;&nbsp;&nbsp;</td>
			<tr>
		</table>
	</div>
	<div class="payment_term">
		<table cellpadding="4" cellspacing="0" border="1">
			<tr>
				<th>Payment Term</th>
				<td>&nbsp;&nbsp;&nbsp;Test</td>
				<th>Ship Date</th>
				<td>&nbsp;&nbsp;&nbsp;26-02-2016</td>
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
				<td></td>
				<td></td>
			</tr>
		</table>
	</div>
	<div class="ship_via">
		<table cellspacing="0" cellpadding="4" border="1">
			<tr>
				<th>Ship Via</th>
				<td>&nbsp;&nbsp;&nbsp;</td>
				<th>Delivery Instruction</th>
				</td>&nbsp;&nbsp;&nbsp;</td>
			</tr>
		</table>
	</div>
	<div class="parts_description">
		<table cellspacing="0" cellpadding="4" border="1">
			<tr>
				<th>Code</th>
				<th>Description</th>
				<th>QTY</th>
				<th>Rate</th>
				<th>Availability</th>
				<th>To Pick</th>
				<th>Amount</th>
			</tr>
			<tr>
				<td>1</td>
				<td>test</td>
				<td>10</td>
				<td>10</td>
				<td>Yes</td>
				<td>Damman</td>
				<td>100</td>
			</tr>
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
			<table cellpadding="4" cellspacing="0" border="1" width="50%">
				<tr>
					<th>Total</th>
					<td style="text-align:right;">SAR 100.000</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>