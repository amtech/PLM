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
        <!-- page start-->
        <div class="row">
            <div class="col-lg-6">
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
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?> Form
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>index.php/settings" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="system_name" class="col-lg-3  control-label">System Name</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="system_name" placeholder="System Name" name="system_name" value="<?php echo set_value('system_name',$settings->system_name); ?>">
                                </div>
                            </div>
							<div class="form-group">
                                <label for="logo" class="col-lg-3  control-label">Logo</label>
                                <div class="col-lg-9">
                                    <input type="file" class="form-control" id="logo" name="logo">
                                </div>
                            </div>

                            <!--<div class="form-group">
                                <label for="currency_code" class="col-lg-3  control-label">Currency Code</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="currency_code" name="currency_code" placeholder="Currency Code" value="<?php echo set_value('currency_code',$settings->currency_code); ?>">
                                </div>
                            </div>-->
							
							<div class="form-group">
								<label for="quotation_prefix" class="col-lg-3 control-label">Quotation Prefix</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" id="quotation_prefix" name="quotation_prefix" placeholder="Quotation Prefix" value="<?php echo set_value('quotation_prefix',$settings->quotation_prefix); ?>" />
								</div>
							</div>

                            <div class="form-group">
                                <label for="default_discount" class="col-lg-3  control-label">Default Discount</label>
                                <div class="col-lg-9">
                                <?php
                                    $option = array('0'=> '--Select--',
                                        'fixed'     => 'Fixed',
                                        'percentage'=> 'Percentage'
                                    );
                                    echo form_dropdown('default_discount',$option,isset($_POST['default_discount'])?$_POST['default_discount']:$settings->default_discount,'class="form-control" style="width:40%;"');
                                ?>    
                                </div>
                            </div>
							
                            <div class="panel-body">
                                <p>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="<?php echo base_url(); ?>index.php" class="btn btn-default" type="button">Cancel</a>
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