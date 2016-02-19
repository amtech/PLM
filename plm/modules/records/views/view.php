        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/prism.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/chosen.css">
        <script type="text/javascript">
            $(document).ready(function(){
               $('#submit').click(function() {
                    var form_data = {
                        branch_id: $('#branch_id1').val(),
                        name: $('#name').val(),
                        address: $('#address').val(),
                        city: $('#city').val(),
                        country: $('#country').val(),
                        telephone: $('#telephone').val(),
                        fax: $('#fax').val(),
                        email: $('#email').val(),
                        contact_person: $('#contact_person').val(),
                        title: $('#title').val(),
                        mobile: $('#mobile').val(),
                    };
                    // console.log(form_data);
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/quotations/add_customer",
                        type: 'POST',
                        data: form_data,
                        success: function(msg) {
                            if (msg == 'YES'){
                                $('#alert-msg').html('<div class="alert alert-success text-center">Customer added successfully!</div>');
                                var url = "<?php echo base_url() ?>index.php/quotations/add";
                                $( location ).attr("href", url);

                            }else{
                                $('#alert-msg').html('<div class="alert alert-danger">' + msg + '</div>');
                            }
                                
                        }
                    });
                    return false;    
                }); 
            });
        </script>
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
            <div class="col-lg-12">
                <form class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php/records/edit/<?php echo $id; ?>" method="post">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?>
                    </header>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="ro_no" class="col-sm-2 control-label col-lg-2">Record Number</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" id="ro_no" name="ro_no" placeholder="Record Number" value="<?php echo set_value('ro_no',$records[0]->ro_no); ?>" disabled />
                            </div>
                            <label for="product_id" class="col-sm-2 control-label col-lg-2">Product</label>
                            <div class="col-lg-4">
                            <?php
                                $optionProduct = array('0'=>'--Select Product--');
                                if(!empty($products)){
                                    foreach($products as $rowProd){
                                        $optionProduct[$rowProd->id] = $rowProd->model_name;
                                    }
                                }
                                echo form_dropdown('product_id',$optionProduct,(isset($_POST['product_id']))?$_POST['product_id']:$records[0]->product_id,'class="form-control chosen-select" id="product_id" disabled');
                            ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="customer_id" class="col-sm-2 control-label col-lg-2">Customer</label>
                            <div class="col-lg-4">
                            <?php
                                $optionCustomer = array('0'=>'--Select--');
                                if(!empty($customers)){
                                    foreach($customers as $rowCust){
                                        $optionCustomer[$rowCust->id] = $rowCust->name;
                                    }
                                }
                                echo form_dropdown('customer_id',$optionCustomer,(isset($_POST['customer_id']))?$_POST['customer_id']:$records[0]->customer_id,'class="form-control chosen-select" id="customer_id" disabled');
                            ?>
                            </div>
                            <label for="delivery_date" class="col-sm-2 control-label col-lg-2">Delivery Date</label>
                            <div class="col-lg-4">
                                <input type="text" name="delivery_date" id="delivery_date" class="form-control form-control-inline input-medium default-date-picker" placeholder="Delivery Date" value="<?php echo set_value('delivery_date',date('d/m/Y',strtotime($records[0]->delivery_date))); ?>" disabled />
                            </div>
                        </div>
                    </div>
                </section>
                <section class="panel">
                    <header class="panel-heading">
                        Warrenty
                    </header>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table" id="myTable">
                                <tbody>
                                    <tr>
                                        <td><label>Warrenty Type</label></td>
                                        <td><label>Starting Date</label></td>
                                        <td><label>Duration Months</label></td>
                                        <td><label>Duration Hours</label></td>
                                        <td><label>Expiry Date</label></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" name="warrenty_type" id="warrenty_type" class="form-control" placeholder="Warrenty Type" value="<?php echo set_value('warrenty_type',$records[0]->warranty_type); ?>" disabled />
                                        </td>
                                        <td>
                                            <input type="text" name="starting_date" id="starting_date" class="form-control form-control-inline input-medium default-date-picker" placeholder="Starting Date" value="<?php echo set_value('starting_date',date('d/m/Y',strtotime($records[0]->starting_date))); ?>" disabled />
                                        </td>
                                        <td>
                                            <input type="text" name="duration_months" id="duration_months" class="form-control" placeholder="Duration Months" value="<?php echo set_value('duration_months',$records[0]->duration_months); ?>" disabled />
                                        </td>
                                        <td>
                                            <input type="text" name="duration_hours" id="duration_hours" class="form-control" placeholder="Duration Hours" value="<?php echo set_value('duration_hours',$records[0]->duration_hours); ?>" disabled />
                                        </td>    
                                        <td>
                                            <input type="text" name="expiry_date" id="expiry_date" class="form-control form-control-inline input-medium default-date-picker" placeholder="Expiry Date" value="<?php echo set_value('expiry_date',date('d/m/Y',strtotime($records[0]->expiry_date))); ?>" disabled />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                <section class="panel">
                    <header class="panel-heading">
                        Technical Data
                    </header>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table" id="myTable">
                                <tbody>
                                    <tr>
                                        <td><label>Feature Description </label></td>
                                        <td><label>Manufacture </label></td>
                                        <td><label>Model/Code </label></td>
                                        <td><label>Serial Number </label></td>
                                        <td><label>Date	of Manufacture	</label></td>
                                    </tr>
                                    <?php
                                        for($i=0;$i<5;$i++){
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $records[$i]->feature_decscription; ?>
                                            <input type="hidden" name="description<?php echo $i+1; ?>" id="description1" class="form-control" value="<?php echo $records[$i]->feature_decscription; ?>"/>
                                        </td>
                                        <td>
                                            <input type="text" name="manufacture<?php echo $i+1; ?>" id="manufacture1" class="form-control" value="<?php echo set_value('manufacture1',$records[$i]->manufacture); ?>" disabled />
                                        </td>
                                        <td>
                                            <input type="text" name="model<?php echo $i+1; ?>" id="model<?php $i+1; ?>" class="form-control" value="<?php echo set_value('model1',$records[$i]->model); ?>" disabled />
                                        </td>
                                        <td>
                                            <input type="text" name="serial_no<?php echo $i+1; ?>" id="serial_no1" class="form-control" value="<?php echo set_value('serial_no1',$records[$i]->serial_number); ?>" disabled />
                                        </td>    
                                        <td>
                                            <input type="text" name="manufacture_date<?php echo $i+1; ?>" id="manufacture_date1" class="form-control form-control-inline input-medium default-date-picker" value="<?php echo set_value('manufacture_date1',date('d/m/Y',strtotime($records[$i]->date_of_manufacture))); ?>" disabled />
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
				<section class="panel">
					<header class="panel-heading">
                        Commissioning Report
                    </header>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table" id="myTable">
								<body>
									<tr>
										<th>Commission Date</th>
										<th>Technician Name</th>
										<th>Report No</th>
										<th>Commissioning Report</th>
										<th>Delivery Note</th>
									</tr>
									<tr>
										<td>
											<input type="text" class="form-control form-control-inline input-medium default-date-picker" name="commission_date" value="<?php echo date('d/m/Y',strtotime($records[0]->commission_date)); ?>" disabled />
										</td>
										<td>
											<input type="text" name="technician_name" class="form-control" value="<?php echo set_value('technician_name',$records[0]->technician_name); ?>" disabled />
										</td>
										<td>
											<input type="text" name="report_no" class="form-control" value="<?php echo set_value('report_no',$records[0]->report_no); ?>" disabled />
										</td>
										<td>
											<a href="<?php echo base_url(); ?>assets/uploads/commissions/<?php echo $records[0]->commission_report; ?>" download><img src="<?php echo base_url(); ?>assets/uploads/commissions/<?php echo $records[0]->commission_report; ?>" alt="" width="100px" /></a>
										</td>
										<td>
											<a href="<?php echo base_url(); ?>assets/uploads/delivery_notes/<?php echo $records[0]->delivery_note; ?>" download><img src="<?php echo base_url(); ?>assets/uploads/delivery_notes/<?php echo $records[0]->delivery_note; ?>" alt="" width="100px" /></a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</section>
                </form>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Add New Customer</h4>
                        </div>

                        <div class="modal-body row">
                            <div id="alert-msg"></div>
                            <form action="<?php echo base_url(); ?>index.php/quotations/add_customer">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Branch</label>
                                    <?php
                                        $optionBranch1 = array('0'=>'--Select--');
                                        if(!empty($branch)){
                                            foreach($branch as $rowBranch1){
                                                $optionBranch1[$rowBranch1->id] = $rowBranch1->branch_name;
                                            }
                                        }
                                        echo form_dropdown('branch_id',$optionBranch1,'','style="width:60%" class="form-control" id="branch_id1"');
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label> Name</label>
                                    <input id="name" value="" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label> Address</label>
                                    <textarea rows="2" class="form-control" name="address" id="address"></textarea>
                                </div>
                                <div class="form-group">
                                    <label> City</label>
                                    <input id="city" value="" name="city" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label> Country</label>
                                    <input id="country" value="" name="country" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Telephone</label>
                                    <input id="telephone" value="" name="telephone" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label> Fax</label>
                                    <input id="fax" value="" name="fax" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label> Email</label>
                                    <input id="email" value="" name="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label> Contact Person</label>
                                    <input id="contact_person" value="" class="form-control" name="contact_person">
                                </div>
                                <div class="form-group">
                                    <label> Title</label>
                                    <input id="title" value="" class="form-control" name="title">
                                </div>
                                <div class="form-group">
                                    <label> Mobile</label>
                                    <input id="mobile" value="" class="form-control" name="mobile">
                                </div>
                                <div class="pull-right">
                                    <button class="btn btn-primary btn-sm" type="button" id="submit">Submit</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal -->
        </div>
		<!-- page end-->
        </section>
        <!--body wrapper end-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
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
        <script src="<?php echo base_url(); ?>assets/js/pickers-init.js"></script>