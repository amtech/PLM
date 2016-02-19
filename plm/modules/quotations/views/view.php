        <!-- page heading start-->
        <div class="page-heading">
            <h3>
                <?php echo $page_title; ?>
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>">Home</a>
                </li>
                <li class="active"> <?php echo $page_title; ?> </li>
            </ul>
        </div>
        <!-- page heading end-->

	
	   <section class="wrapper">
			<div class="row">
				<div class="col-sm-12">
					<section class="panel">

						<header class="panel-heading">
							<?php echo $page_title; ?>
                            <!--<span class="tools pull-right">
                                <?php
                                    // $getRevQuotes = $this->quotations_model->getRevQuotes($quotation->id);
                                    // // echo '<pre>';
                                    // // print_r($getRevQuotes);
                                    // // echo '</pre>';
                                    // if(!empty($getRevQuotes)){
                                        // $count = 1;
                                        // foreach($getRevQuotes as $rowRevQuotes){
                                            // $revID = $rowRevQuotes->id;
                                ?>
                                <a class="custom-button" href="<?php echo base_url(); ?>index.php/quotations/view_revised_quotation/<?php echo $revID; ?>">v <?php echo $count++; ?></a>
                                <?php
                                        // }
                                    // }
                                ?>
                            </span>-->
						</header>
						
						<div class="panel-body">
							<form class="form-horizontal" role="form">
								<div class="row">
									<div class="col-sm-12">
					   					<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2" for="quotation_id">Quotation No</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" id="quotation_id" name="quotation_id" value="<?php echo $quotation->qo_no; ?>" disabled>
											</div>
											
											<label for="customer_id" class="col-sm-2 control-label col-lg-2">Company Name</label>
											<div class="col-lg-4">
												<input type="text" name="company" value="<?php echo $quotation->name; ?>" class="form-control" disabled />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2" for="branch">Branch</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" id="branch" name="branch" value="<?php echo $quotation->branch_name; ?>" disabled>
											</div>
											
											<label class="col-sm-2 control-label col-lg-2" for="quotation_date">Quotation Date</label>
											<div class="col-lg-4">
											    <input type="text" class="form-control" id="quotation_date" name="quotation_date" value="<?php echo date('d/m/Y',strtotime($quotation->quotation_date)); ?>" disabled>
											</div>
										</div>
										<div class="form-group">
											<label for="validity" class="col-sm-2 control-label col-lg-2">Validity Upto</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" id="validity" placeholder="Validity Upto" name="validity" value="<?php echo set_value('validity',$quotation->validity); ?>" disabled>
											</div>
											
											<label class="col-sm-2 control-label col-lg-2" for="expected_del_time">Delivery Time</label>
											<div class="col-lg-4">
												<input class="form-control form-control-inline input-medium default-date-picker" type="text" id="expected_del_time" placeholder="Expected Delivery Time" name="expected_del_time" value="<?php echo set_value('expected_del_time',date('d/m/Y',strtotime($quotation->expected_time))); ?>" autocomplete="off" disabled />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2" for="delivery_place">Delivery Place</label>
											<div class="col-lg-4">
												<input type="text" id="delivery_place" name="delivery_place" class="form-control" value="<?php echo set_value('delivery_place',$quotation->delivery_place); ?>" disabled />
											</div>
											
											<label class="col-sm-2 control-label col-lg-2" for="payment_terms">Payment Term</label>
											<div class="col-lg-4">
												<input type="text" name="payment_terms" id="payment_terms" class="form-control" value="<?php echo set_value('payment_terms',$quotation->payment_terms); ?>" disabled />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2" for="machine_name">Machine Name</label>
											<div class="col-lg-4">
												<input type="text" name="machine_name" id="machine_name" class="form-control" value="<?php echo set_value('machine_name',$quotation->machine_name); ?>" disabled />
											</div>
											
											<label class="col-sm-2 control-label col-lg-2" for="comment">Comment</label>
											<div class="col-lg-4">
												<input type="text" id="comment" name="comment" class="form-control" value="<?php echo set_value('comment',$quotation->comment); ?>" disabled />
											</div>
										</div>
										<div class="form-group">
											<label for="total" class="col-sm-2 control-label col-lg-2">Total</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" id="total" name="total" value="<?php echo $quotation->total; ?>" disabled />
											</div>
											
											<label for="charges" class="col-sm-2 control-label col-lg-2">Other Charges</label>
											<div class="col-lg-4">
												<input type="text" id="charges" name="charges" class="form-control" value="<?php echo set_value('charges',$quotation->charges); ?>" onkeyup="calculateSubTotal(this);" disabled />
											</div>
										</div>
										<div class="form-group">
											<label for="note" class="col-sm-2 control-label col-lg-2">Internal Note</label>
											<div class="col-lg-4">
												<textarea id="note" name="note" class="form-control" disabled ><?php echo set_value('note',$quotation->internal_note); ?></textarea>
											</div>
											
											<label for="status" class="col-sm-2 control-label col-lg-2">Status</label>
											<div class="col-lg-4">
												<select class="form-control" name="status" id="status" disabled >
													<option value="pending" <?php if($quotation->status == 'pending'){ ?>selected <?php } ?>>Pending</option>
													<option value="approved" <?php if($quotation->status == 'approved'){ ?>selected <?php } ?>>Approved</option>
												</select>
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
                                                <td><label>Quantity</label></td>
                                                <td><label>Unit Price</label></td>
                                                <td><label>Discount</label></td>
												<td><label>Total Price</label></td>
												<td><label>Delivery Date</label></td>
                                                <td><label>Subtotal</label></td>
											</tr>
											<?php
                                                if(!empty($quotation_items)){
                                                    foreach($quotation_items as $row){
                                            ?>
                                            <tr id="1">
												<td>
                                                    <input type="text" class="form-control" placeholder="quotations_id" id="part_id" name="part_id" value="<?php echo $row->code; ?>" disabled="">
                                                </td>
												
												<td>
                                                    <input type="text" class="form-control" placeholder="Purchase Parts Product Id" id="purchase-parts-product-id" name="purchase-parts-product-id" value="<?php echo $row->description; ?>" disabled="">
                                                </td>
                                                
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Purchase Parts Product Qty" id="purchase-parts-product-qty" name="purchase-parts-product-qty" value="<?php echo $row->quantity; ?>" disabled="">
                                                </td>    
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Purchase Parts Product Customs" id="purchase-parts-product-customs" name="purchase-parts-product-customs" value="<?php echo $row->price; ?>" disabled="">
                                                </td>
												<td>
                                                    <input type="text" class="form-control" placeholder="Purchase Parts Product Freight" id="purchase-parts-product-freight" name="purchase-parts-product-freight" value="<?php echo $row->discount_value; ?>" disabled="">
                                                </td>
												<td>
                                                    <input type="text" class="form-control" placeholder="Purchase Parts Product Cost" id="purchase-parts-product-cost" name="purchase-parts-product-cost" value="<?php echo $row->total_price; ?>" disabled="">
                                                </td>
												<td>
                                                    <input type="text" class="form-control" placeholder="Delivery Date" id="delivery_date" name="delivery_date" value="<?php echo date('d/m/Y',strtotime($row->delivery_date)); ?>" disabled="">
                                                </td>
												<td>
                                                    <input type="text" class="form-control" placeholder="Subtotal" id="subtotal" name="subtotal" value="<?php echo $row->sub_total; ?>" disabled="">
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