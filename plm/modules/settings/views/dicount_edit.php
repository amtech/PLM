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
                        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>index.php/settings/edit_discount/<?php echo $id; ?>">
                            <div class="form-group">
                                <label for="type" class="col-lg-3  control-label">Discount Type</label>
                                <div class="col-lg-9">
                                <?php
                                    $option = array(
                                            '0'         =>'--Select--',
                                            'fixed'     =>'Fixed',
                                            'percentage'=>'Percentage'
                                    );
                                    echo form_dropdown('discount',$option,isset($_POST['discount'])?$_POST['discount']:$discount->discount_type,'class="form-control" style="width:40%" id="type"');
                                ?>    
                                </div>
                            </div>
							<div class="form-group">
                                <label for="discount_value" class="col-lg-3  control-label">Discount Value</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="discount_value" placeholder="Discount Value" name="discount_value" value="<?php echo set_value('discount_value',$discount->value); ?>">
                                </div>
                            </div>
							
							
                            <div class="panel-body">
                                <p>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="<?php echo base_url(); ?>index.php/settings/discount" class="btn btn-default" type="button">Cancel</a>
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