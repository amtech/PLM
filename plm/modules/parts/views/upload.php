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
        <div class="alert alert-block alert-danger fade in">
            <button type="button" class="close close-sm" data-dismiss="alert">
            </button>Upload Part By CSV Sample File <a href="<?php echo base_url(); ?>assets/uploads/csv/sample_part.csv" download>Download Sample</a>
        </div>
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
                        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>index.php/parts/upload_csv" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="brand_id" class="col-lg-3  control-label">Brand</label>
                                <div class="col-lg-9">
                                <?php
                                    $optionBrand = array('0'=>'Select Brand..');
                                    if(!empty($brand)){
                                        foreach($brand as $rowBrand){
                                            $optionBrand[$rowBrand->id] = $rowBrand->brand_name;
                                        }
                                    }
                                    echo form_dropdown('brand_id',$optionBrand,isset($_POST['brand_id'])?$_POST['brand_id']:'','style="width:40%;" class="form-control" id="brand_id"');
                                ?>
                                </div>
                            </div>
							<div class="form-group">
                                <label for="csv" class="col-lg-3  control-label">Upload CSV</label>
                                <div class="col-lg-9">
                                    <input type="file" class="form-control" id="csv" name="csv">
                                </div>
                            </div>
                            
                            <div class="panel-body">
                                <p>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="<?php echo base_url(); ?>index.php/customers" class="btn btn-default" type="button">Cancel</a>
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