        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/prism.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/chosen.css">
        <script type="text/javascript">
            $(document).ready(function(){
				$.validator.setDefaults({ ignore: ":hidden:not(select)" });
				$('#quotation_form').validate({
					rules: {
						qo_no: {
							required: true,
						},
						customer_id: {
							required: true,
						},
						branch_id: {
							required: true,
						},
						quotation_date: "required",
						validity: "required",
						expected_del_time: "required",
						delivery_place: "required",
						machine_name: "required",
					},
					messages: {
						qo_no: {
							required: "Quotation number is required",
						},
						customer_id: {
							required: "Please select company.",
						},
						branch_id: {
							required: "Please select branch",
						},
						quotation_date: "Quotation date is required",
						validity: "Validity up to is required",
						expected_del_time: "Delivery time is required",
						delivery_place: "Delivery place is required",
						machine_name: "Machine Name is required",
					},
				});
                var row_ids ;
                $(window).load(function(){
                    var seq = $('#seq').val();
                    row_ids = seq.split(',');
                });
                
                $('#submit_form').click(function(){
                    for(var a = 1 ; a <= row_ids.length ; a++){
                        if(($("#parts_product_id-"+a).val()) == 0){
                            alert("Please select part..");
                            return false;
                        }
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
                var count = 2;
                // add new row
                $('#add').click(function(){
                    // alert(row_ids);
                    row_ids.push(count);
                    $('#myTable tr:last').after(
                        '<tr id='+count+'>'+
                            '<td>'+
                                '<select name="parts_product_id'+count+'" id="parts_product_id-'+count+'" class="form-control chosen-select drop" onchange="getParts(this);">'+
                                    '<option value="0">--Select--</option>'+
                                    <?php 
                                        if(!empty($parts)){
                                            foreach($parts as $rowParts){
                                    ?>
                                    '<option value="<?php echo $rowParts->id; ?>"><?php echo $rowParts->id.' '.$rowParts->code; ?></option>'+
                                    <?php            
                                            }
                                        }
                                    ?>
                                '</select>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="Description" id="description-'+count+'" name="description'+count+'" disabled>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="Quantity" id="quantity-'+count+'" name="quantity'+count+'" onkeyup="calculateSubTotal(this);" disabled>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="Price" id="unit_price-'+count+'" name="unit_price'+count+'" onkeyup="calculateSubTotal(this);" disabled>'+
                            '</td>'+
                            '<td>'+
                                '<select class="form-control" id="discount_amount-'+count+'" name="discount_amount'+count+'" onchange="calculateSubTotal(this);">'+
                                    '<option value="0">0</option>'+
                                    <?php
                                        if(!empty($discount)){
                                            foreach($discount as $rowDiscount){
                                    ?>
                                    '<option value="<?php echo $rowDiscount->id; ?>"><?php echo $rowDiscount->value; ?></option>'+
                                    <?php
                                            }
                                        }
                                    ?>
                                '</select>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="Total Price" id="total_price-'+count+'" name="total_price'+count+'" disabled>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control datepicker_recurring_start" placeholder="Delivery Date" id="delivery_date-'+count+'" name="delivery_date'+count+'" value="<?php echo date('d/m/Y'); ?>">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control sub_total" placeholder="Sub Total" id="grand_total-'+count+'" name="grand_total'+count+'" disabled>'+
                            '</td>'+
                            '<td>'+
                                '<button class="btn btn-primary" type="button" id="remove" onclick="deleteRow('+count+')">Remove</button>'+
                            '</td>'+
                            '<input type="hidden" name="sub_total'+count+'" id="sub_total-'+count+'">'+
                            '<input type="hidden" name="disc_value'+count+'" id="disc_value-'+count+'">'+
                            '<input type="hidden" name="total_price'+count+'" id="total_price-'+count+'">'+
                        '</tr>'
                    );
                    $('.drop').chosen(); 
					$('body').on('focus',".datepicker_recurring_start", function(){
                        $(this).datepicker({ dateFormat: 'dd/mm/yy' });
                    });
                    document.getElementById("seq").value = row_ids.toString();
                    count++;
                });
            });
            // delete row of table
            function deleteRow(rowid)  
            {   
                // alert(rowid);
                if(rowid==1){
                    alert("First row not allowed to delete");
                }else{
                    var row = document.getElementById(rowid);
                    row.parentNode.removeChild(row);
                    seq = document.getElementById("seq").value;
                    seqarray = seq.split(",");
                    for(var i=0 ; i<seqarray.length ; i++){
                            //alert(seqarray[i]+"and rowid :"+rowid);
                            if(seqarray[i] == rowid){
                                
                                seqarray.splice(i, 1);
                                //alert(seqarray);
                                break;
                            }
                    }
                    var total = 0;
                    $(".sub_total").each(function(){
                         total += parseFloat($(this).val()||0);
                    });
                    $("#total").val(total);
                    $("#grand_total").val(total);
                    document.getElementById("seq").value = seqarray.toString();
                }
            }
            // get parts details via ajax
            function getParts(object){
                var part_id = object.value;
                var id = object.id;
                var num = id.split('-');
                var count = num[1];
                // alert(count);
                $.ajax({
                        type: "post",
                        url: "<?php echo base_url(); ?>index.php/quotations/getParts",
                        cache: false,               
                        data: {part_id: part_id},
                        async:false,
                        success: function(data){
                        try{
                            var obj = JSON.parse(data);
                            $("#quantity-"+count).removeAttr("disabled");
                            $("#repair_charge-"+count).removeAttr("disabled");
                            $("#unit_price-"+count).removeAttr("disabled");
                            $("#description-"+count).removeAttr("disabled");
                            $("#unit_price-"+count).val(obj[0].price);
                            $("#description-"+count).val(obj[0].name);
                        }catch(e) {      
                        alert(e);
                        alert('Exception while request..');
                        }        
                    },
                    error: function(){                      
                        alert('Error while request..');
                    }
                });
            }
            
            function calculateSubTotal(object){
                // alert(object.id);
                var id = object.id;
                var num = id.split('-');
                var count = num[1];
                var discount = $('#discount_amount-'+count).val();
                var disc_value = $("#discount_amount-"+count+" option:selected").text();
                var qty = $("#quantity-"+count).val();
                var price = $("#unit_price-"+count).val();
                // var repair = $("#repair_charge-"+count).val();
                // code for subtotal (cost*quantity*freight*customs)
                var subtotal;
                var total_price = 0;
                var total = 0;
                var disc_val = 0;
                // if(repair == ""){
                    // repair = 0;
                // }
                if("<?php echo DEFAULT_DISCOUNT; ?>" == "fixed"){
                    total_price = parseFloat(qty*parseFloat(price))-(parseFloat(disc_value));
                    disc_val = parseFloat(disc_value);
                    subtotal = parseFloat(total_price);// + parseFloat(repair);
                }else if("<?php echo DEFAULT_DISCOUNT; ?>" == "percentage"){
                    total_price = parseFloat(qty*parseFloat(price))-(parseFloat(qty*parseFloat(price))*parseFloat(disc_value)/100);
                    disc_val = (parseFloat(qty*parseFloat(price))*parseFloat(disc_value)/100);
                    subtotal = parseFloat(total_price);// + parseFloat(repair);
                }
                
                $("#disc_value-"+count).val(disc_val);
                $("#total_price-"+count).val(total_price);
                $('#sub_total-'+count).val(subtotal);
                $('#grand_total-'+count).val(subtotal);
                var charges = $('#charges').val();
                $(".sub_total").each(function(){
                     total += parseFloat($(this).val()||0);
                });
                var main_total = parseFloat(total) + parseFloat($('#charges').val()) + parseFloat($('#freight_charges').val());
                $("#total").val(main_total);
                $("#grand_total").val(main_total);
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
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?>
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php/quotations/add" method="post" id="quotation_form">
                            <div class="form-group">
                                <label for="qo_no" class="col-sm-2 control-label col-lg-2">Quote No.</label>
                                <div class="col-lg-4">
                                <?php
                                    echo form_input($qo_no);
                                ?>
                                </div>
                                
                                <label for="customer_id" class="col-sm-2 control-label col-lg-2">Company Name</label>
                                <div class="col-lg-4">
                                <?php
                                    $optionCustomer = array(''=>'Select Comapny');
                                    if(!empty($customers)){
                                        foreach($customers as $rowCustomer){
                                            $optionCustomer[$rowCustomer->id] = $rowCustomer->name;
                                        }
                                    }
                                    echo form_dropdown('customer_id',$optionCustomer,isset($_POST['customer_id'])?$_POST['customer_id']:'','class="form-control chosen-select" id="customer_id"');
                                ?>
                                <a href="#myModal" data-toggle="modal" style="text-decoration:none;">Add New Customer</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="branch_id" class="col-sm-2 control-label col-lg-2">Branch</label>
                                <div class="col-lg-4">
                                <?php
                                    $optionBranch = array(''=>'--Select Branch--');
                                    if(!empty($branch)){
                                        foreach($branch as $rowBranch){
                                            $optionBranch[$rowBranch->id] = $rowBranch->branch_name;
                                        }
                                    }
                                    echo form_dropdown('branch_id',$optionBranch,isset($_POST['branch_id'])?$_POST['branch_id']:DEFAULT_BRANCH,'class="form-control" id="branch_id"');
                                ?>  
                                </div>
                                <label for="quotation_date" class="col-sm-2 control-label col-lg-2">Quotation Date</label>
                                <div class="col-lg-4">
                                    <input class="form-control form-control-inline input-medium default-date-picker" type="text" id="quotation_date" placeholder="Select Quotation Date" name="quotation_date" value="<?php echo set_value('quotation_date',date('d/m/Y')); ?>" autocomplete="off" />
                                </div>
                            </div>
							<div class="form-group">
                                <label for="validity" class="col-sm-2 control-label col-lg-2">Validity Upto</label>
                                <div class="col-lg-4">
                                    <textarea class="form-control" cols="50" rows="4" name="validity"><?php echo set_value('validity'); ?></textarea>
                                </div>
                                
                                <label class="col-sm-2 control-label col-lg-2" for="expected_del_time">Delivery Time</label>
                                <div class="col-lg-4">
                                    <input class="form-control" type="text" id="expected_del_time" placeholder="Expected Delivery Time" name="expected_del_time" value="<?php echo set_value('expected_del_time'); ?>" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group">
								<label class="col-sm-2 control-label col-lg-2" for="delivery_place">Delivery Place</label>
								<div class="col-lg-4">
									<input type="text" id="delivery_place" name="delivery_place" class="form-control" value="<?php echo set_value('delivery_place'); ?>" />
								</div>
								
                                <label class="col-sm-2 control-label col-lg-2" for="comment">Comment</label>
                                <div class="col-lg-4">
                                    <input type="text" id="comment" name="comment" class="form-control" value="<?php echo set_value('comment'); ?>" />
                                </div>
                            </div>
							<div class="form-group">
								<label class="col-sm-2 control-label col-lg-2" for="payment_terms">Payment Term</label>
								<div class="col-lg-4">
									<input type="text" name="payment_terms" id="payment_terms" class="form-control" value="<?php echo set_value('payment_terms'); ?>" />
								</div>
								
								<label class="col-sm-2 control-label col-lg-2" for="machine_name">Machine Name</label>
								<div class="col-lg-4">
									<input type="text" name="machine_name" id="machine_name" class="form-control" value="<?php echo set_value('machine_name'); ?>" />
								</div>
							</div>
                            <div class="form-group">
								<label for="charges" class="col-sm-2 control-label col-lg-2">Service Charges</label>
                                <div class="col-lg-4">
                                    <input type="text" id="charges" name="charges" class="form-control" value="<?php echo set_value('charges',0); ?>" onkeyup="calculateSubTotal(this);" />
                                </div>
								
								<label for="charges" class="col-sm-2 control-label col-lg-2">Freight Charges</label>
                                <div class="col-lg-4">
                                    <input type="text" id="freight_charges" name="freight_charges" class="form-control" value="<?php echo set_value('freight_charges',0); ?>" onkeyup="calculateSubTotal(this);" />
                                </div>
                            </div>
							<div class="form-group">
								<label for="total" class="col-sm-2 control-label col-lg-2">Gross Total</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="total" name="total" disabled />
                                </div>
								
								<label for="note" class="col-sm-2 control-label col-lg-2">Internal Note</label>
                                <div class="col-lg-4">
                                    <textarea id="note" name="note" class="form-control"><?php echo set_value('note'); ?></textarea>
                                </div>
							</div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel-body">
                                        <p>
                                            <button class="btn btn-primary" type="button" id="add">Add</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="myTable">
                                    <tbody>
                                        <tr>
                                            <td width="15%"><label>Code</label></td>
                                            <td><label>Description</label></td>
                                            <td><label>Quantity</label></td>
                                            <td><label>Unit Price</label></td>
                                            <td><label>Discount amount</label></td>
                                            <td><label>Total Price</label></td>
                                            <td><label>Delivery Date</label></td>
                                            <td><label>Sub Total</label></td>
                                            <td><label>Remove</label></td>
                                        </tr>
                                        <tr id="1">
                                            <td>
                                            <?php
                                                $optionParts = array('0'=>'--Select--');
                                                if(!empty($parts)){
                                                    foreach($parts as $rowParts){
                                                        $optionParts[$rowParts->id] = $rowParts->code;
                                                    }
                                                }
                                                echo form_dropdown('parts_product_id1',$optionParts,isset($_POST['parts_product_id1'])?$_POST['parts_product_id1']:'','class="form-control chosen-select" id="parts_product_id-1" onchange="getParts(this);"');
                                            ?>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Description" id="description-1" name="description1" value="<?php echo set_value('description1') ?>" disabled>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Quantity" id="quantity-1" name="quantity1" value="<?php echo set_value('quantity1') ?>" onkeyup="calculateSubTotal(this);" disabled>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Price" id="unit_price-1" name="unit_price1" value="<?php echo set_value('unit_price1'); ?>" onkeyup="calculateSubTotal(this);" disabled>
                                            </td>    
                                            <td>
                                                <?php
                                                    $optionDisc = array('0'=>0);
                                                    if(!empty($discount)){
                                                        foreach($discount as $rowDisc){
                                                            $optionDisc[$rowDisc->id] = $rowDisc->value;
                                                        }
                                                        echo form_dropdown('discount_amount1',$optionDisc,(isset($_POST['discount_amount1']))?$_POST['discount_amount1']:'','class="form-control" onchange="calculateSubTotal(this);" id="discount_amount-1"');
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Total Price" id="total_price-1" name="total_price1" value="<?php echo set_value('total_price1'); ?>" onkeyup="calculateSubTotal(this);" disabled>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-inline input-medium default-date-picker" placeholder="Delivery Date" id="delivery_date-1" name="delivery_date1" value="<?php echo set_value('repair_charge1',date('d/m/Y')); ?>" >
                                            </td>
                                            <td>
                                                <input type="text" class="form-control sub_total" placeholder="Sub Total" id="grand_total-1" name="grand_total1" value="<?php echo set_value('grand_total1'); ?>" disabled>
                                            </td>
                                            <td></td>
                                            <input type="hidden" name="sub_total1" id="sub_total-1">
                                            <input type="hidden" name="disc_value1" id="disc_value-1">
                                            <input type="hidden" name="total_price1" id="total_price-1">
                                        </tr>
                                    </tbody>
                                </table>
    						</div>
                            <input type="hidden" name="grand_total" id="grand_total"/>
                            <input type="hidden" name="seq" id="seq" value="1"/>
                            <div class="panel-body">
                                <p>
                                    <button class="btn btn-primary" type="submit" id="submit_form">Submit</button>
                                    <a href="<?php echo base_url(); ?>index.php/quotations" class="btn btn-default" type="button">Cancel</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </section>
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