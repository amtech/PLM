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
                        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>index.php/parts/add" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="brand_id" class="col-lg-3  control-label">Brand</label>
                                <div class="col-lg-9">
                                <?php
                                    $option = array('0'=>'--Select Brand--');
                                    if(!empty($brand)){
                                        foreach($brand as $row){
                                            $option[$row->id] = $row->brand_name;
                                        }
                                    }
                                    echo form_dropdown('brand_id',$option,isset($_POST['brand_id'])?$_POST['brand_id']:'','class="form-control" id="brand_id"');
                                ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="code" class="col-lg-3  control-label">Code</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="code" placeholder="Code" name="code" value="<?php echo set_value('code'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-lg-3  control-label">Part Description</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="name" placeholder="Description" name="name" value="<?php echo set_value('name'); ?>">
                                </div>
                            </div>
							<div class="form-group">
                                <label for="part_desc" class="col-lg-3  control-label">Manufacture Information</label>
                                <div class="col-lg-9">
                                    <textarea id="part_desc" class="form-control" name="part_desc"><?php echo set_value('part_desc'); ?></textarea>
                                </div>
                            </div>
							<div class="form-group">
                                <label for="serial_no" class="col-lg-3  control-label">Serial No</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="serial_no" placeholder="Serial No" name="serial_no" value="<?php echo set_value('serial_no'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cost" class="col-lg-3  control-label">Cost</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="cost" placeholder="Cost" name="cost" value="<?php echo set_value('cost'); ?>">
                                </div>
                            </div>
                            <!--<div class="form-group">
                                <label for="price" class="col-lg-3  control-label">Price</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="price" placeholder="Price" name="price" value="<?php echo set_value('price'); ?>">
                                </div>
                            </div>-->
                            <div class="form-group">
                                <label for="alert_qty" class="col-lg-3  control-label">Alert Quantity</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="alert_qty" placeholder="Alert Quantity" name="alert_qty" value="<?php echo set_value('alert_qty'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="image" class="col-lg-3  control-label">Image</label>
                                <div class="col-lg-9">
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>
                            </div>
							
                            <div class="panel-body">
                                <p>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="<?php echo base_url(); ?>index.php/parts" class="btn btn-default" type="button">Cancel</a>
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