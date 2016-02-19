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
                            <a class="custom-button" href="<?php echo base_url(); ?>index.php/settings/edit_discount/<?php echo $id; ?>"> Edit Discount</a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" action="#">
                            <div class="form-group">
                                <label for="discount_type" class="col-lg-3  control-label">Discount Type</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="discount_type" placeholder="Discount Type Name" name="discount_type" value="<?php echo $discount->discount_type; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="value" class="col-lg-3  control-label">Discount Value</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="value" placeholder="Discount Value" value="<?php echo $discount->value; ?>" disabled >
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