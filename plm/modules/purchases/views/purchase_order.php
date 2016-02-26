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
	</style>
</head>
<body>
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
			<th>Delivery Time</th>
		</tr>
		<?php 
			if(!empty($parts)){
				$i = 0;
				foreach($parts as $row){
		?>
		<tr>
			<td><?php echo $i+= 1; ?></td>
			<td>code</td>
			<td><?php echo $row->description; ?></td>
			<td></td>
			<td><?php echo $row->part_quantity; ?></td>
			<td><?php echo $row->cost; ?></td>
			<td><?php echo $row->sub_total; ?></td>
			<td><?php echo date('d-m-Y',strtotime($purchase->expected_date)); ?></td>
		</tr>
		<?php
				}
			}
		?>
		<tr>
			<td colspan="6">Total Amount is SR</td>
			<td><?php echo $purchase->total; ?></td>
			<td>SR</td>
		</tr>
		<tr>
			<td colspan="9">Amount in word:</td>
		</tr>
		<tr>
			<td colspan="9"><?php echo ucwords($amount_words); ?> saudi riyal</td>
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
			<!--<tr>
				<td style="padding:10px;">
					Dear Sir,<br/>
					We would like to confirm our purchase order for the following spare parts item.					
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="1">
						<tr>
							<th>
								It
							</th>
							<th>
								Code
							</th>
							<th>
								Description
							</th>
							<th>
								U/M
							</th>
							<th>
								QTY
							</th>
							<th>
								Unit Price (EUR)
							</th>
							<th>
								Total Price (EUR)
							</th>
							<th>
								Delivery Time
							</th>
						</tr>
						<?php 
							if(!empty($parts)){
								$i = 0;
								foreach($parts as $row){
						?>
						<tr>
							<td>
								<?php echo $i+= 1; ?>
							</td>
							<td>
								code
							</td>
							<td>
								<?php echo $row->description; ?>
							</td>
							<td>
								
							</td>
							<td>
								<?php echo $row->part_quantity; ?>
							</td>
							<td>
								<?php echo $row->cost; ?>
							</td>
							<td>
								<?php echo $row->sub_total; ?>
							</td>
							<td>
								<?php echo date('d-m-Y',strtotime($purchase->expected_date)); ?>
							</td>
						</tr>
						<?php
								}
							}
						?>
						<tr>
							<td colspan="6">
								Total Amount is SR
							</td>
							<td>
								<?php echo $purchase->total; ?>
							</td>
							<td>
								SR
							</td>
						</tr>						
						<tr>
							<td colspan="9">
								
							</td>
						</tr>
						
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="1">
						<tr>
							<td>
								Amount in word:
							</td>
						</tr>
						<tr>
							<td>
								<?php echo ucwords($amount_words); ?> saudi riyal
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<strong>Terms & Condition:</strong>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="1"> 
						<tr>
							<td width="30%">
								PAYMENT: 
							</td>
							<td>
								
							</td>
						</tr>
						<tr>
							<td>
								SHIPPING METHOD: 
							</td>
							<td>
								<?php echo $purchase->ship_via; ?>
							</td>
						</tr>
						<tr>
							<td>
								Delivery Terms 
							</td>
							<td>
								 
							</td>
						</tr>
						<tr>
							<td>
								Shipping Instruction:	
							</td>
							<td>
								<?php echo $purchase->ship_instruction; ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>-->
</body>
</html>