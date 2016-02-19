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
                        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>index.php/warehouses/edit/<?php echo $id; ?>">
                            <div class="form-group">
                                <label for="branch_id" class="col-lg-3  control-label">Branch</label>
                                <div class="col-lg-9">
                                <?php
                                    $optionBranch = array('0'=>'--Select Branch--');
                                    if(!empty($branch)){
                                        foreach($branch as $rowBranch){
                                            $optionBranch[$rowBranch->id] = $rowBranch->branch_name;
                                        }
                                    }
                                    echo form_dropdown('branch_id',$optionBranch,isset($_POST['branch_id'])?$_POST['branch_id']:$warehouses->branch_id,'style="width:40%;" class="form-control" id="branch_id"');
                                ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="warehouse_name" class="col-lg-3  control-label">Warehouse Name</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="warehouse_name" placeholder="Warehouse Name" name="warehouse_name" value="<?php echo set_value('warehouse_name',$warehouses->warehouse_name); ?>">
                                </div>
                            </div>
							<div class="form-group">
                                <label for="warehouse_desc" class="col-lg-3  control-label">Warehouse Description</label>
                                <div class="col-lg-9">
                                    <textarea id="warehouse_desc" class="form-control" name="warehouse_desc"><?php echo set_value('warehouse_desc',$warehouses->warehouse_desc); ?></textarea>
                                </div>
                            </div>
							
							
                            <div class="panel-body">
                                <p>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="<?php echo base_url(); ?>index.php/warehouses" class="btn btn-default" type="button">Cancel</a>
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