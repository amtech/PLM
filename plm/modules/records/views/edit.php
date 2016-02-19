        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/prism.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/chosen.css">
        <script type="text/javascript">
            $(document).ready(function(){
				$.validator.setDefaults({ ignore: ":hidden:not(select)" })
				$("#record_form").validate({
					rules: {
						ro_no: "required",
						customer_id: "required",
						delivery_date: "required",
						brand_id: "required",
						product_id: "required",
						warrenty_type: "required",
						starting_date: "required",
						duration_months: {
							required: true,
							number: true,
						},
						duration_hours: {
							required: true,
							number: true,
						},
						// commission_date: "required",
						// technician_name: "required",
						// report_no: "required",
					},
					messages: {
						ro_no: "Record number is required",
						customer_id: "Please select customer",
						delivery_date: "Delivery date is required",
						brand_id: "Please select brand",
						product_id: "Please select product",
						warrenty_type: "Warrenty Type is required",
						starting_date: "Starting Date is required",
						duration_months: {
							required: "Duration in Month is required",
							number: "Duration in Month in numbers only",
						},
						duration_hours: {
							required: "Duration in hours is required",
							number: "Duration in hours in numbers only",
						},
						// commission_date: "Commission Date is required",
						// technician_name: "Technician name is required",
						// report_no: "Report number is required",
					}
				});
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
				$('#brand_id').change(function(){
                    var id = $(this).val();
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/records/getProducts",
                        type: 'POST',
                        data: {id: id},
                        success: function(data) {
                            var obj = $.parseJSON(data);
                            var select = '<label for="product_id" class="col-sm-2 control-label col-lg-2">Product</label><div class="col-lg-4"><select name="product_id" id="product_id" class="form-control chosen-select"><option value="0">--Select Product--</option>';
                            $.each(obj, function(key, value){
                                select += '<option value="'+value.id+'">'+value.model_name+' - '+value.serial_no+'</option>';
                            });
                            select += '</select></div>';
                            console.log(select);
                            $("#myID").html(select);
                            $("#product_id").chosen();
                        }
                    });
                    return false;
                });
            });
        </script>
        <script>
            function getExpiryDate(){
                var durationMonth = parseInt($('#duration_months').val()); //or whatever offset
                // alert(durationMonth);
                var start_date = String($('#starting_date').val());
                var a = start_date.split("/");
                var year = a[2];
                var month = a[1];
                var day = a[0];
                var datestring = month+'-'+day+'-'+year;
                var date = new Date(datestring);
                var d = new Date(date.setMonth(date.getMonth() + durationMonth));
                var expiry = d.getDate() + '/' + (d.getMonth()+1) + '/' + d.getFullYear();
                $('#expiry_date').val(expiry);
            }
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
                <form class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php/records/edit/<?php echo $id; ?>" method="post" id="record_form" enctype="multipart/form-data">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?>
                    </header>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="customer_id" class="col-sm-2 control-label col-lg-2">Customer</label>
                            <div class="col-lg-4">
                            <?php
                                $optionCustomer = array(''=>'--Select--');
                                if(!empty($customers)){
                                    foreach($customers as $rowCust){
                                        $optionCustomer[$rowCust->id] = $rowCust->name;
                                    }
                                }
                                echo form_dropdown('customer_id',$optionCustomer,(isset($_POST['customer_id']))?$_POST['customer_id']:$records[0]->customer_id,'class="form-control chosen-select" id="customer_id"');
                            ?>
                            </div>
                            
                            <label for="ro_no" class="col-sm-2 control-label col-lg-2">Record Number</label>
                            <div class="col-lg-4">
                            <?php
                                echo form_input($ro_no);
                            ?>
                            </div>
                        </div>
                        <div class="form-group">
							<label for="brand_id" class="col-sm-2 control-label col-lg-2">Brand</label>
							<div class="col-lg-4">
								<?php
									$optionBrand = array(''=>'--Select Brand--');
									if(!empty($brand)){
										foreach($brand as $rowBrand){
											$optionBrand[$rowBrand->id] = $rowBrand->brand_name;
										}
									}
									echo form_dropdown('brand_id',$optionBrand,(isset($_POST['brand_id']))?$_POST['brand_id']:$records[0]->brand_id,'class="form-control chosen-select" id="brand_id"');
								?>
							</div>
							
                            <label for="delivery_date" class="col-sm-2 control-label col-lg-2">Delivery Date</label>
                            <div class="col-lg-4">
                                <input type="text" name="delivery_date" id="delivery_date" class="form-control form-control-inline input-medium default-date-picker" placeholder="Delivery Date" value="<?php echo set_value('delivery_date',date('d/m/Y',strtotime($records[0]->delivery_date))); ?>" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group">
							<div id="myID">
							<label for="product_id" class="col-sm-2 control-label col-lg-2">Product</label>
                            <div class="col-lg-4">
                            <?php
                                $optionProduct = array(''=>'--Select Product--');
                                if(!empty($products)){
                                    foreach($products as $rowProd){
                                        $optionProduct[$rowProd->id] = $rowProd->model_name.' - '.$rowProd->serial_no;
                                    }
                                }
                                echo form_dropdown('product_id',$optionProduct,(isset($_POST['product_id']))?$_POST['product_id']:$records[0]->product_id,'class="form-control chosen-select" id="product_id"');
                            ?>
                            </div>
							</div>
							<label class="control-label col-sm-2 col-lg-2" for="report">Commission Report</label>
                            <div class="col-lg-4">
                                <input type="checkbox" name="report" id="report" value="0" <?php if($records[0]->report == '1'){?>checked <?php }?>/>
                            </div>
                        </div>
						<div class="form-group">
							<label for="status" class="control-label col-sm-2 col-lg-2">Status</label>
                            <div class="col-lg-4">
                                <select name="status" id="status" class="form-control">
                                    <option value="pending" <?php if($records[0]->status == 'pending'){?>selected <?php }?>>Pending</option>
                                    <option value="completed" <?php if($records[0]->status == 'completed'){?>selected <?php }?>>Completed</option>
                                </select>
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
                                            <input type="text" name="warrenty_type" id="warrenty_type" class="form-control" placeholder="Warrenty Type" value="<?php echo set_value('warrenty_type',$records[0]->warranty_type); ?>"/>
                                        </td>
                                        <td>
                                            <input type="text" name="starting_date" id="starting_date" class="form-control form-control-inline input-medium default-date-picker" placeholder="Starting Date" value="<?php echo set_value('starting_date',date('d/m/Y',strtotime($records[0]->starting_date))); ?>" autocomplete="off"/>
                                        </td>
                                        <td>
                                            <input type="text" name="duration_months" id="duration_months" class="form-control" placeholder="Duration Months" value="<?php echo set_value('duration_months',$records[0]->duration_months); ?>" onkeyUp="(getExpiryDate());" />
                                        </td>
                                        <td>
                                            <input type="text" name="duration_hours" id="duration_hours" class="form-control" placeholder="Duration Hours" value="<?php echo set_value('duration_hours',$records[0]->duration_hours); ?>"/>
                                        </td>    
                                        <td>
                                            <input type="text" name="expiry_date" id="expiry_date" class="form-control form-control-inline input-medium default-date-picker" placeholder="Expiry Date" value="<?php echo set_value('expiry_date',date('d/m/Y',strtotime($records[0]->expiry_date))); ?>" autocomplete="off" />
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
                                            <input type="text" name="manufacture<?php echo $i+1; ?>" id="manufacture1" class="form-control" value="<?php echo set_value('manufacture1',$records[$i]->manufacture); ?>"/>
                                        </td>
                                        <td>
                                            <input type="text" name="model<?php echo $i+1; ?>" id="model<?php $i+1; ?>" class="form-control" value="<?php echo set_value('model1',$records[$i]->model); ?>"/>
                                        </td>
                                        <td>
                                            <input type="text" name="serial_no<?php echo $i+1; ?>" id="serial_no1" class="form-control" value="<?php echo set_value('serial_no1',$records[$i]->serial_number); ?>"/>
                                        </td>    
                                        <td>
                                            <input type="text" name="manufacture_date<?php echo $i+1; ?>" id="manufacture_date<?php echo $i+1; ?>" class="form-control form-control-inline input-medium default-date-picker" value="<?php echo set_value('manufacture_date'.($i+1),date('d/m/Y',strtotime($records[$i]->date_of_manufacture))); ?>" autocomplete="off" />
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
											<input type="text" class="form-control form-control-inline input-medium default-date-picker" name="commission_date" value="<?php echo set_value('commission_date',date('d/m/Y',strtotime($records[0]->commission_date))); ?>" />
										</td>
										<td>
											<input type="text" name="technician_name" class="form-control" value="<?php echo set_value('technician_name',$records[0]->technician_name); ?>"/>
										</td>
										<td>
											<input type="text" name="report_no" class="form-control" value="<?php echo set_value('report_no',$records[0]->report_no); ?>" />
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
				<input type="hidden" name="c_report" value="<?php echo $records[0]->commission_report;?>" />
				<input type="hidden" name="c_delivery" value="<?php echo $records[0]->delivery_note;?>" />
                <div class="panel-body">
                    <p>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a href="<?php echo base_url(); ?>index.php/records" class="btn btn-default" type="button">Cancel</a>
                    </p>
                </div>
                </form>
            </div>
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