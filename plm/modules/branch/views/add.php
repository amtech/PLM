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

        <!--body wrapper start-->
        <section class="wrapper">
        <?php
            if($errors){
                foreach($errors as $error){
        ?>
                <div class="alert alert-block alert-danger fade in">
                    <button type="button" class="close close-sm" data-dismiss="alert">
                        <i class="fa fa-times"></i>
                    </button>
                    <?php echo $error; ?>
                </div>
        <?php
                }
            }
        ?>
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?> Form
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" action="add" method="post">
                            <div class="form-group">
                                <label  class="col-lg-2 col-sm-2 control-label" for="branch_name">Branch Name <span style="color:red;">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" placeholder="Branch Name" id="branch_name" name="branch_name" value="<?php echo set_value('branch_name'); ?>">
                                </div>
								
								<label  class="col-lg-2 col-sm-2 control-label" for="branch_code">Branch Code <span style="color:red;">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" placeholder="Branch Code" id="branch_code" name="branch_code" value="<?php echo set_value('branch_code'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-2 col-sm-2 control-label" for="po_box">PO Box</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" placeholder="Po Box" id="po_box" name="po_box" value="<?php echo set_value('po_box'); ?>">
                                </div>
								
								<label  class="col-lg-2 col-sm-2 control-label" for="postal_code">Postal Code</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" placeholder="Postal Code" id="postal_code" name="postal_code" value="<?php echo set_value('postal_code'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-2 col-sm-2 control-label" for="city">City</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" placeholder="City" id="city" name="city" value="<?php echo set_value('city'); ?>">
                                </div>
								
								<label class="col-lg-2 col-sm-2 control-label" for="telephone">Telephone</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" placeholder="Telephone" id="telephone" name="telephone" value="<?php echo set_value('telephone'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-2 col-sm-2 control-label" for="mobile">Mobile No.</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" placeholder="Mobile No." id="mobile" name="mobile" value="<?php echo set_value('mobile'); ?>">
                                </div>
								
								<label  class="col-lg-2 col-sm-2 control-label" for="email">Email <span style="color:red;">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" placeholder="Email" id="email" name="email" value="<?php echo set_value('email'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-2 col-sm-2 control-label" for="incharge_name">Incharge Name</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" placeholder="Incharge Name" id="incharge_name" name="incharge" value="<?php echo set_value('incharge'); ?>">
                                </div>
								
								<label  class="col-lg-2 col-sm-2 control-label" for="currency_code">Currency Code</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" placeholder="Currency Code" id="currency_code" name="currency_code" value="<?php echo set_value('currency_code'); ?>">
                                </div>
                            </div>
							<header class="panel-heading">
								Account Details
							</header>
							<div class="panel-body">
								<div class="form-group">
									<label for="account_name" class="control-label col-lg-2 col-sm-2">Account Name <span style="color:red;">*</span></label>
									<div class="col-lg-4">
										<input type="text" class="form-control" placeholder="Account Name" id="account_name" name="account_name" value="<?php echo set_value('account_name'); ?>">
									</div>
									
									<label for="account_no" class="control-label col-lg-2 col-sm-2">Account No <span style="color:red;">*</span></label>
									<div class="col-lg-4">
										<input type="text" class="form-control" placeholder="Account No" id="account_no" name="account_no" value="<?php echo set_value('account_no'); ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-2 col-sm-2">IBAN <span style="color:red;">*</span></label>
									<div class="col-lg-4">
										<input type="text" class="form-control" placeholder="IBAN" id="iban" name="iban" value="<?php echo set_value('iban'); ?>">
									</div>
									
									<label class="col-lg-2 col-sm-2 control-label"> Bank Name <span style="color:red;">*</span></label>
									<div class="col-lg-4">
										<input type="text" class="form-control" placeholder="Bank Name" id="bank_name" name="bank_name" value="<?php echo set_value('bank_name'); ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-2 col-sm-2"> Swift Code <span style="color:red;">*</span></label>
									<div class="col-lg-4">
										<input type="text" class="form-control" placeholder="Swift Code" id="swift_code" name="swift_code" value="<?php echo set_value('swift_code'); ?>">
									</div>
								</div>
							</div>
                            <div class="panel-body">
                                <p>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="<?php echo base_url(); ?>index.php/branch" class="btn btn-default" type="button">Cancel</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
        </section>
        <!--body wrapper end-->