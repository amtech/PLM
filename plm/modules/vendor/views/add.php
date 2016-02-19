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
                        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>index.php/vendor/add">
                            <div class="form-group">
                                <label for="branch" class="col-lg-3  control-label">Branch</label>
                                <div class="col-lg-9">
                                    <?php
                                        $option = array('0'=>'--Select Branch--');
                                        if(!empty($branch)){
                                            foreach($branch as $row){
                                                $option[$row->id] = $row->branch_name;
                                            }
                                        }
                                        echo form_dropdown('branch_id',$option,isset($_POST['branch_id'])?$_POST['branch_id']:'','class="form-control" id="branch"');
                                    ?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="company_name" class="col-lg-3  control-label">Company Name</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="company_name" placeholder="Company Name" name="company_name" value="<?php echo set_value('company_name'); ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="address" class="col-lg-3  control-label">Address</label>
                                <div class="col-lg-9">
                                    <textarea id="address" name="address" class="form-control"><?php echo set_value('address'); ?></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact_person" class="col-lg-3  control-label">Contact Person</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="contact_person" placeholder="Contact Person" name="contact_person" value="<?php echo set_value('contact_person'); ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="fax" class="col-lg-3  control-label">Fax</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="fax" placeholder="Fax" name="fax" value="<?php echo set_value('fax'); ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="telephone" class="col-lg-3  control-label">Telephone</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="telephone" placeholder="Telephone" name="telephone" value="<?php echo set_value('telephone'); ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="mobile" class="col-lg-3  control-label">Mobile Number</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="mobile" placeholder="Mobile Number" name="mobile" value="<?php echo set_value('mobile'); ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="col-lg-3  control-label">Email</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo set_value('email'); ?>">
                                </div>
                            </div>
                            
                            <div class="panel-body">
                                <p>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="<?php echo base_url(); ?>index.php/vendor" class="btn btn-default" type="button">Cancel</a>
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