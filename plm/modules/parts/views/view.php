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
                            <a class="custom-button" href="<?php echo base_url(); ?>index.php/parts/edit/<?php echo $id; ?>"> Edit Part</a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" action="#">
                            <div class="form-group">
                                <label for="code" class="col-lg-3  control-label">Part Code</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="code" placeholder="Part Code" name="code" value="<?php echo $parts->code; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-lg-3  control-label">Part Description</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="name" placeholder="Part Description" name="name" value="<?php echo $parts->name; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="part_desc" class="col-lg-3  control-label">Manufacture Information</label>
                                <div class="col-lg-9">
                                    <textarea id="part_desc" class="form-control" name="part_desc" disabled><?php echo $parts->desc; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="serial_no" class="col-lg-3  control-label">Serial No</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="serial_no" placeholder="Serial No" name="serial_no" value="<?php echo set_value('serial_no',$parts->serial_no); ?>" disabled >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cost" class="col-lg-3  control-label">Cost</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="cost" placeholder="Cost" name="cost" value="<?php echo set_value('cost',$parts->cost); ?>" disabled >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price" class="col-lg-3  control-label">Price</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="price" placeholder="Price" name="price" value="<?php echo set_value('price',$parts->price); ?>" disabled >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alert_qty" class="col-lg-3  control-label">Alert Quantity</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="alert_qty" placeholder="Alert Quantity" name="alert_qty" value="<?php echo set_value('alert_qty',$parts->alert_quantity); ?>" disabled >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="image" class="col-lg-3  control-label">Image</label>
                                <div class="col-lg-9">
                                    <img src="<?php echo base_url(); ?>assets/uploads/parts/<?php echo $parts->image; ?>" width="100"/>
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