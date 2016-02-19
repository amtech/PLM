        <!-- page heading start-->
        <div class="page-heading">
            <h3>
                View Purchase Parts
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>">Home</a>
                </li>
                <li class="active"> view Purchase Parts </li>
            </ul>
        </div>
        <!-- page heading end-->

	
	   <section class="wrapper">
			<div class="row">
				<div class="col-sm-12">
					<section class="panel">

						<header class="panel-heading">
							View Purchase_Product Details
						</header>
						<div class="panel-body">
							<form class="form-horizontal" role="form">
								<div class="row">
									<div class="col-sm-12">
					   					<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2" for="purchase-product-id">Purchase Product Id</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" id="purchase-product-id" name="purchase-product-id" value="<?php echo $purchase_parts[0]->id; ?>" disabled>
											</div>
											<label class="col-sm-2 control-label col-lg-2" for="product-vendor-ref">Vendor name</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" id="product-vendor-ref" name="product-vendor-ref" value="<?php echo $purchase_parts[0]->vendor_reference; ?>" disabled>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2" for="product-shipping-instruction">Product Shipping Instruction</label>
											<div class="col-lg-4">
											    <input type="text" class="form-control" id="product-shipping-instruction" name="product-shipping-instruction" value="<?php echo $purchase_parts[0]->ship_instruction; ?>" disabled>
											</div>
                                            <label class="col-sm-2 control-label col-lg-2" for="product-purchase-order-date">Product Purchase Order Date</label>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" id="product-purchase-order-date" name="product-purchase-order-date" value="<?php echo $purchase_parts[0]->order_date; ?>" disabled>
                                            </div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2" for="product-expected-date">Product Expected Date</label>
											<div class="col-lg-4">
											    <input type="text" class="form-control" id="product-expected-date" name="product-expected-date" value="<?php echo date('d/m/Y',strtotime($purchase_parts[0]->expected_date)); ?>" disabled>
											</div>
                                            <label class="col-sm-2 control-label col-lg-2" for="product-ship-via">Product Ship Via</label>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" id="product-ship-via" name="product-ship-via" value="<?php echo $purchase_parts[0]->ship_via; ?>" disabled>
                                            </div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2" for="product-ship-to">Product Ship To</label>
											<div class="col-lg-4">
											    <input type="text" class="form-control" id="product-ship-to" name="product-ship-to" value="<?php echo $purchase_parts[0]->ship_to; ?>" disabled>
											</div>
											    <label class="col-sm-2 control-label col-lg-2" for="product-total-amount">Product Total Amount</label>
											<div class="col-lg-4">
											    <input type="text" class="form-control" id="product-total-amount" name="product-total-amount" value="<?php echo $purchase_parts[0]->total; ?>" disabled>
											</div>
										</div>
										
										
									</div>
                                </div>
									
								<div class="row">
									<div class="col-sm-12">

										<header class="panel-heading">
										</header>
														
									</div>
								</div>
									
								<div class="table-responsive">
									
									<table class="table" id="mytable">
							
										<tbody>
											
											<tr>
                                                <td><label>Code</label></td>
                                                <td><label>Description</label></td>
                                                <td><label>Product Qty</label></td>
                                                <td><label>Product Freight</label></td>
                                                <td><label>Product Customs</label></td>
												<td><label>Product Cost</label></td>
												<td><label>Service Tax</label></td>
												<td><label>Parts Received</label></td>
                                                <td><label>Product Subtotal</label></td>

											</tr>
											<?php
                                                if(!empty($purchase_parts)){
                                                    foreach($purchase_parts as $row){
                                            ?>
                                            <tr id="1">
                                                <?php 
                                                    $code = $this->purchases_model->getCode($row->part_id);
                                                ?>
												<td>
                                                    <input type="text" class="form-control" placeholder="purchase-parts-item-id" id="purchase-parts-item-id" name="purchase-parts-item-id" value="<?php echo $code; ?>" disabled="">
                                                </td>
												
												<td>
                                                    <input type="text" class="form-control" placeholder="Purchase Parts Product Id" id="purchase-parts-product-id" name="purchase-parts-product-id" value="<?php echo $row->part_name; ?>" disabled="">
                                                </td>
                                                
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Purchase Parts Product Qty" id="purchase-parts-product-qty" name="purchase-parts-product-qty" value="<?php echo $row->part_quantity; ?>" disabled="">
                                                </td>    
												
												<td>
                                                    <input type="text" class="form-control" placeholder="Purchase Parts Product Freight" id="purchase-parts-product-freight" name="purchase-parts-product-freight" value="<?php echo $row->freight; ?>" disabled="">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Purchase Parts Product Customs" id="purchase-parts-product-customs" name="purchase-parts-product-customs" value="<?php echo $row->customs; ?>" disabled="">
                                                </td>  
												
												<td>
                                                    <input type="text" class="form-control" placeholder="Purchase Parts Product Cost" id="purchase-parts-product-cost" name="purchase-parts-product-cost" value="<?php echo $row->cost; ?>" disabled="">
                                                </td>
                                                
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Service Tax" id="service_tax" name="service_tax" value="<?php echo $row->service_tax; ?>" disabled="">
                                                </td>
												
												 <td>
                                                    <select class="form-control" id="purchase-parts-received" name="purchase-parts-received" disabled>
                                                        <option value="0">-- Select --</option>
                                                        <option value="yes" <?php if($row->part_recieved == 'yes') { ?>selected <?php } ?>>Yes</option>
                                                        <option value="no" <?php if($row->part_recieved == 'no') { ?>selected <?php } ?>>No</option>
                                                    </select>
                                                </td>
												
												<td>
                                                    <input type="text" class="form-control" placeholder="Purchase Parts Product Subtotal" id="purchase-parts-product-subtotal" name="purchase-parts-product-subtotal" value="<?php echo $row->sub_total; ?>" disabled="">
                                                </td>
                                            </tr>
                                            <?php
                                                    }
                                                }
                                            ?>
						                </tbody><!--tbody-closed-->
										
									</table> <!--table-responsive closed-->
									
								</div> <!--table-responsive closed-->
                            </form>
	                    </div>
                    </section>
	            </div>
	        </div>
		</section>