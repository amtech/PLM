        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/prism.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/chosen.css">
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
                        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>index.php/products/edit/<?php echo $id; ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="brand_id" class="col-lg-3  control-label">Brand</label>
                                <div class="col-lg-9">
                                <?php
                                    $optionBrand = array('0'=>'--Select--');
                                    if(!empty($brands)){
                                        foreach($brands as $rowBrand){
                                            $optionBrand[$rowBrand->id] = $rowBrand->brand_name;
                                        }
                                    }
                                    echo form_dropdown('brand_id',$optionBrand,isset($_POST['brand_id'])?$_POST['brand_id']:$products->brand_id,'style="width:40%" class="form-control chosen-select"');
                                ?>                                
                                </div>
                            </div>
							<div class="form-group">
                                <label for="category" class="col-lg-3  control-label">Category</label>
                                <div class="col-lg-9">
                                <?php
                                    $optionCat = array('0'=>'--Select--');
                                    if(!empty($categories)){
                                        foreach($categories as $rowCat){
                                            $optionCat[$rowCat->id] = $rowCat->category_name;
                                        }
                                    }
                                    echo form_dropdown('category_id',$optionCat,isset($_POST['category_id'])?$_POST['category_id']:$products->category_id,'style="width:40%;" class="form-control chosen-select" id="category"');
                                ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sub_category" class="col-lg-3  control-label">Sub Category</label>
                                <div class="col-lg-9">
                                <?php
                                    $optionSubCat = array('0'=>'--Select--');
                                    if(!empty($sub_categories)){
                                        foreach($sub_categories as $rowSubCat){
                                            $optionSubCat[$rowSubCat->id] = $rowSubCat->sub_category_name;
                                        }
                                    }
                                    echo form_dropdown('sub_category_id',$optionSubCat,isset($_POST['sub_category_id'])?$_POST['sub_category_id']:$products->sub_category_id,'style="width:40%;" class="form-control chosen-select" id="sub_category"');
                                ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="model_name" class="col-lg-3  control-label">Customer Name</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="customer_name" placeholder="Customer Name" name="customer_name" value="<?php echo set_value('customer_name',$products->customer_name); ?>">
                                </div>
                            </div>
							<div class="form-group">
                                <label for="model_name" class="col-lg-3  control-label">Model Name</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="model_name" placeholder="Model Name" name="model_name" value="<?php echo set_value('model_name',$products->model_name); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="serial_no" class="col-lg-3  control-label">Serial No</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="serial_no" placeholder="Serial No" name="serial_no" value="<?php echo set_value('serial_no',$products->serial_no); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cost" class="col-lg-3  control-label">Cost</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="cost" placeholder="Cost" name="cost" value="<?php echo set_value('cost',$products->cost); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price" class="col-lg-3  control-label">Price</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="price" placeholder="Price" name="price" value="<?php echo set_value('price',$products->price); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alert_qty" class="col-lg-3  control-label">Alert Quantity</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="alert_qty" placeholder="Alert Quantity" name="alert_qty" value="<?php echo set_value('alert_qty',$products->alert_quantity); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="image" class="col-lg-3  control-label">Image</label>
                                <div class="col-lg-9">
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>
                            </div>
                            <input type="hidden" name="image_edit" value="<?php echo $products->image; ?>"/>
                            <div class="panel-body">
                                <p>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="<?php echo base_url(); ?>index.php/products" class="btn btn-default" type="button">Cancel</a>
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
        <script src="<?php echo base_url(); ?>assets/js/choosen/chosen.jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/choosen/prism.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
            var config = {
              '.chosen-select'           : {},
              '.chosen-select-deselect'  : {allow_single_deselect:true},
              '.chosen-select-no-single' : {disable_search_threshold:10},
              '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
              '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
              $(selector).chosen(config[selector]);
            }
        </script>