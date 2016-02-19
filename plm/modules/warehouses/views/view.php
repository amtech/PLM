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
        <?php
            $branch = $this->warehouses_model->getBranchById($warehouses->branch_id);
        ?>
        <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-6">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?> Form
                        <span class="tools pull-right">
                            <a class="custom-button" href="<?php echo base_url(); ?>index.php/warehouses/edit/<?php echo $id; ?>"> Edit Warehouse</a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" action="#">
                            <div class="form-group">
                                <label for="branch" class="col-lg-3  control-label">Branch</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="branch_name" placeholder="Branch Name" name="branch_name" value="<?php echo $branch->branch_name; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="brand_name" class="col-lg-3  control-label">Warehouse Name</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="warehouse_name" placeholder="Warehouse Name" name="warehouse_name" value="<?php echo $warehouses->warehouse_name; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="warehouse_desc" class="col-lg-3  control-label">Warehouse Description</label>
                                <div class="col-lg-9">
                                    <textarea id="warehouse_desc" class="form-control" name="warehouse_desc" disabled ><?php echo $warehouses->warehouse_desc; ?></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>

            </div>
        </div>
		<!-- page end-->
        </section>
        <!--body wrapper end-->