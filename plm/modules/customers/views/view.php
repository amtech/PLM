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
            $branch = $this->customers_model->getBranchById($customers->branch_id);
        ?>
        <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-6">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?> Form
                        <span class="tools pull-right">
                            <a class="custom-button" href="<?php echo base_url(); ?>index.php/customers/edit/<?php echo $customers->id; ?>"> Edit Customer </a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="#">
                            <div class="form-group">
                                <label for="branch_id" class="col-lg-3  control-label">Branch</label>
                                <div class="col-lg-9">
                                    <input type="text" name="branch_id" id="branch_id" value="<?php echo $branch->branch_name ?>" class="form-control" disabled>
                                </div>
                            </div>
							<div class="form-group">
                                <label for="customer_name" class="col-lg-3  control-label">Name</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="customer_name" placeholder="Customer Name" name="customer_name" value="<?php echo set_value('customer_name',$customers->name); ?>"disabled >
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="address" class="col-lg-3  control-label">Address</label>
                                <div class="col-lg-9">
                                    <textarea id="area" name="address" class="form-control"><?php echo set_value('address',$customers->address); ?></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="city" class="col-lg-3  control-label">City</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="city" placeholder="City" name="city" value="<?php echo set_value('city',$customers->city); ?>" disabled>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="country" class="col-lg-3  control-label">Country</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="country" placeholder="Country" name="country" value="<?php echo set_value('country',$customers->country); ?>" disabled>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="telephone" class="col-lg-3  control-label">Telephone</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="telephone" placeholder="Telephone" name="telephone" value="<?php echo set_value('telephone',$customers->telephone); ?>" disabled>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="fax" class="col-lg-3  control-label">Fax</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="fax" placeholder="Fax" name="fax" value="<?php echo set_value('fax',$customers->fax); ?>" disabled>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="col-lg-3  control-label">Email</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo set_value('email',$customers->email); ?>" disabled>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact_person" class="col-lg-3  control-label">Contact Person</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="contact_person" placeholder="Contact Person" name="contact_person" value="<?php echo set_value('contact_person',$customers->contact_person); ?>" disabled>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="title" class="col-lg-3  control-label">Title</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="title" placeholder="Title" name="title" value="<?php echo set_value('title',$customers->title); ?>" disabled>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="mobile" class="col-lg-3  control-label">Mobile</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="mobile" placeholder="Mobile" name="mobile" value="<?php echo set_value('mobile',$customers->mobile); ?>" disabled>
                                </div>
                            </div>
							
                            <div class="panel-body">
                                <p>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="#" class="btn btn-default" type="button">Cancel</a>
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