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
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?> Form
                        <span class="tools pull-right">
                            <a class="custom-button" href="<?php echo base_url(); ?>index.php/products/edit/<?php echo $id; ?>"> Edit Equipment</a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>index.php/products/edit/<?php echo $id; ?>">
                            <div class="form-group">
                                <label for="brand_id" class="col-lg-3  control-label">Brand</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="brand_name" placeholder="Brand Name" name="brand_name" value="<?php echo set_value('brand_name',$products->brand_name); ?>" disabled>
                                </div>
                            </div>
							<div class="form-group">
                                <label for="category_name" class="col-lg-3  control-label">Category Name</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="category_name" placeholder="Category Name" name="category_name" value="<?php echo set_value('category_name',$products->category_name); ?>" disabled>
                                </div>
                            </div>
							<div class="form-group">
                                <label for="model_name" class="col-lg-3  control-label">Customer Name</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="customer_name" placeholder="Customer Name" name="customer_name" value="<?php echo set_value('customer_name',$products->customer_name); ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="model_name" class="col-lg-3  control-label">Model Name</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="model_name" placeholder="Model Name" name="model_name" value="<?php echo set_value('model_name',$products->model_name); ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="serial_no" class="col-lg-3  control-label">Serial No</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="serial_no" placeholder="Serial No" name="serial_no" value="<?php echo set_value('serial_no',$products->serial_no); ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cost" class="col-lg-3  control-label">Cost</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="cost" placeholder="Cost" name="cost" value="<?php echo set_value('cost',$products->cost); ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price" class="col-lg-3  control-label">Price</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="price" placeholder="Price" name="price" value="<?php echo set_value('price',$products->price); ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alert_qty" class="col-lg-3  control-label">Alert Quantity</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="alert_qty" placeholder="Alert Quantity" name="alert_qty" value="<?php echo set_value('alert_qty',$products->alert_quantity); ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="image" class="col-lg-3  control-label">Image</label>
                                <div class="col-lg-9">
                                    <img src="<?php echo base_url(); ?>assets/uploads/products/<?php echo $products->image; ?>" width="20%" />
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