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
                        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>index.php/categories/add_sub_category">
                            <div class="form-group">
                                <label for="category_id" class="col-lg-3  control-label">Category Name</label>
                                <div class="col-lg-9">
                                <?php
                                    $optionCategory = array('0'=>'--Select--');
                                    if(!empty($categories)){
                                        foreach($categories as $rowCategory){
                                            $optionCategory[$rowCategory->id] = $rowCategory->category_name;
                                        }
                                    }
                                    echo form_dropdown('category_id',$optionCategory,isset($_POST['category_id'])?$_POST['category_id']:'','style="width:40%;" class="form-control"');
                                ?>                                
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sub_category_name" class="col-lg-3  control-label">Sub Category Name</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="sub_category_name" placeholder="Sub Category Name" name="sub_category_name" value="<?php echo set_value('sub_category_name'); ?>">
                                </div>
                            </div>
							<div class="form-group">
                                <label for="sub_category_desc" class="col-lg-3  control-label">Sub Category Description</label>
                                <div class="col-lg-9">
                                    <!--<input type="textarea" class="form-control" id="brand_desc" placeholder="Brand Description">-->
                                    <textarea id="sub_category_desc" class="form-control" name="sub_category_desc"><?php echo set_value('sub_category_desc'); ?></textarea>
                                </div>
                            </div>
							
							
                            <div class="panel-body">
                                <p>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="<?php echo base_url(); ?>index.php/categories/sub_categories" class="btn btn-default" type="button">Cancel</a>
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