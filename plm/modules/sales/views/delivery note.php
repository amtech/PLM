<html>
<head>
	<title>Delivery Note</title>
	<style>
		table {
			border-collapse: collapse;
		}
		#parts tr td{
			text-align: center;
		}
	</style>
</head>
<body>
	<?php 
		// echo '<pre>';
		// print_r($sales);
		// echo '</pre>';
	?>
	<table width="100%" border="1" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th colspan="2">DELIVERY NOTE NO. 290/15</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					&nbsp;&nbsp;Customer: <br/>
					&nbsp;&nbsp;<?php echo $sales->name; ?>
				</td>
				<td>
					&nbsp;&nbsp;Delivery Address: <br/>
					&nbsp;&nbsp;<?php echo $sales->address; ?>
				</td>
			</tr>
		</tbody>
	</table>
	<div style="height:10px;"></div>
	<table width="100%" cellspacing="0" cellpadding="0" border="1">
		<thead>
			<tr>
				<td colspan="3">&nbsp; Date: <?php echo date('d-m-Y',strtotime($sales->date)); ?></td>
				<td colspan="2">&nbsp; Our Ref.No: </td>
			</tr>
			<tr>
				<td colspan="3">&nbsp; SO#: Invoice No: </td>
				<td colspan="2">&nbsp; Customer PO No: </td>
			</tr>
			<tr>
				<th>Item No.</th>
				<th>Code No</th>
				<th>Description</th>
				<th>Qty</th>
				<th>Remarks</th>
			</tr>
		<thead>
		<tbody>
			<?php 
				if(!empty($sale_items)){
					foreach($sale_items as $row){
						$i = 0;
			?>
			<tr>
				<td><?php echo $i+1; ?></td>
				<td><?php echo $row->code; ?></td>
				<td><?php echo $row->description; ?></td>
				<td><?php echo $row->quantity; ?></td>
				<td></td>
			</tr>
			<?php
					}
				}
			?>
			<tr style="height:20px;"><td colspan="5"></td></tr>
			<tr>
				<td colspan="5">&nbsp;Remarks as per Eng.</td>
			</tr>
		</tbody>
	</table>
	<div style="height:10px;"></div>
	<table width="100%" cellspacing="0" cellpadding="0" border="1">
		<thead>
			<td>&nbsp; Approved for delivery by</td>
			<td>Customer Receiver</td>
		</thead>
		<tbody>
			<tr>
				<td>&nbsp; Name:</td>
				<td>&nbsp; <b>We confirm reciept of goods in good condition.</b></td>
			</tr>
			<tr>
				<td>&nbsp; Signature: <br/>&nbsp; Date: </td>
				<td>&nbsp; Recieved By: </td>
			</tr>
			<tr>
				<td>&nbsp; Delivered By: </td>
				<td>&nbsp; Signature: </td>
			</tr>
			<tr>
				<td>&nbsp; Signature: <br/>&nbsp; Date: </td>
				<td>&nbsp; Date: </td>
			</tr>
		</tbody>
	</table>
</body>
</html>