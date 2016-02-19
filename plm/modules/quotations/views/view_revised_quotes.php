        <script>
        function goBack() {
            window.history.back();
        }
        </script>
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
						</header>
						<div class="panel-body">
							<form class="form-horizontal" role="form">
								<div class="row">
									<div class="col-sm-12">
					   					<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2" for="quotation_id">Quotation No</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" id="quotation_id" name="quotation_id" value="<?php echo $quotation[0]->qo_no; ?>" disabled>
											</div>
                                            <label class="col-sm-2 control-label col-lg-2" for="branch">Branch</label>
											<div class="col-lg-4">
												<input type="text" class="form-control" id="branch" name="branch" value="<?php echo $quotation[0]->branch_name; ?>" disabled>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2" for="quotation_date">Quotation Date</label>
											<div class="col-lg-4">
											    <input type="text" class="form-control" id="quotation_date" name="quotation_date" value="<?php echo date('d/m/Y',strtotime($quotation[0]->quotation_date)); ?>" disabled>
											</div>
                                            <label class="col-sm-2 control-label col-lg-2" for="validity">Validity</label>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" id="validity" name="validity" value="<?php echo $quotation[0]->validity; ?>" disabled>
                                            </div>
										</div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label col-lg-2" for="expected_del_time">Expected Time</label>
                                            <div class="col-lg-4">
                                                <input class="form-control form-control-inline input-medium default-date-picker" type="text" id="expected_del_time" placeholder="Expected Delivery Time" name="expected_del_time" value="<?php echo set_value('expected_del_time',date('d/m/Y',strtotime($quotation[0]->expected_time))); ?>" disabled />
                                            </div>
                                            
                                            <label class="col-sm-2 control-label col-lg-2" for="comment">Comment</label>
                                            <div class="col-lg-4">
                                                <input type="text" id="comment" name="comment" class="form-control" value="<?php echo set_value('comment',$quotation[0]->comment); ?>" disabled />
                                            </div>
                                        </div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label col-lg-2" for="customer">Customer</label>
											<div class="col-lg-4">
											    <input type="text" class="form-control" id="customer" name="customer" value="<?php echo $quotation[0]->name; ?>" disabled>
											</div>
                                            <label class="col-sm-2 control-label col-lg-2" for="total">Total</label>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" id="total" name="total" value="<?php echo $quotation[0]->total; ?>" disabled>
                                            </div>
										</div>
                                        <div class="form-group">
                                            <label for="charges" class="col-sm-2 control-label col-lg-2">Other Charges</label>
                                            <div class="col-lg-4">
                                                <input type="text" id="charges" name="charges" class="form-control" value="<?php echo set_value('charges',$quotation[0]->charges); ?>" disabled />
                                            </div>
                                            
                                            <label for="note" class="col-sm-2 control-label col-lg-2">Internal Note</label>
                                            <div class="col-lg-4">
                                                <textarea id="note" name="note" class="form-control" disabled><?php echo set_value('note',$quotation[0]->internal_note); ?></textarea>
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
                                                <td><label>ID </label></td>
                                                <td><label>Part</label></td>
                                                <td><label>Quantity</label></td>
                                                <td><label>Unit Price</label></td>
                                                <td><label>Discount</label></td>
												<td><label>Total Price</label></td>
												<td><label>Repairing Charge</label></td>
                                                <td><label>Subtotal</label></td>
											</tr>
											<?php
                                                if(!empty($quotation)){
                                                    foreach($quotation as $row){
                                            ?>
                                            <tr id="1">
												<td>
                                                    <input type="text" class="form-control" placeholder="quotations_id" id="part_id" name="part_id" value="<?php echo $row->quotation_id; ?>" disabled="">
                                                </td>
												
												<td>
                                                    <input type="text" class="form-control" placeholder="Purchase Parts Product Id" id="purchase-parts-product-id" name="purchase-parts-product-id" value="<?php echo $row->part_name; ?>" disabled="">
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
                                                    <input type="text" class="form-control" placeholder="Repair Charge" id="repair_charge" name="purchase-parts-product-cost" value="<?php echo $row->repair_charge; ?>" disabled="">
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
                                <button class="btn btn-danger" onclick="goBack();">Back</button>
                            </form>
	                    </div>
                    </section>
	            </div>
	        </div>
		</section>