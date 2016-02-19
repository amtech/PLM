        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/prism.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/chosen.css">
        <script type="text/javascript">
            $(document).ready(function(){
                $('#sale_id').prop('disabled', true).trigger("chosen:updated");
                $('#service').prop('disabled', true).trigger("chosen:updated");
                $('#from_ac').change(function(){
                    if(this.value == '39' || this.value == '42'){
                        $('#sale_id').prop('disabled', false).trigger("chosen:updated");
                    }else{
                        $('#sale_id').prop('disabled', true).trigger("chosen:updated");
                    }
                    if(this.value == '40' || this.value == '43'){
                        $('#service').prop('disabled', false).trigger("chosen:updated");
                    }else{
                        $('#service').prop('disabled', true).trigger("chosen:updated");
                    }
                });
                $('#sale_id').change(function(){
                    var sale = this.value;
                    $.ajax({
                        type: "post",
                        url: "<?php echo base_url(); ?>index.php/reciepts/getAmountPayable",
                        cache: false,               
                        data: {sale_id: sale},
                        async:false,
                        success: function(result){
                            try{
                                var amt = JSON.parse(result);
                                $('#receipt_amount_payable').val(amt.total);
                                $('#amount_payable').val(amt.total);
                            }catch(e) {      
                                alert('Exception while request..');
                            }        
                        },
                        error: function(){                      
                            alert('Error while request..');
                        }
                    });
                });
                $('#service').change(function(){
                    var service = this.value;
                    $.ajax({
                        type: "post",
                        url: "<?php echo base_url(); ?>index.php/reciepts/getServiceAmountPayable",
                        cache: false,               
                        data: {service_id: service},
                        async:false,
                        success: function(result){
                            try{
                                var amt = JSON.parse(result);
                                $('#receipt_amount_payable').val(amt.total);
                                $('#amount_payable').val(amt.total);
                            }catch(e) {      
                                alert('Exception while request..');
                            }        
                        },
                        error: function(){                      
                            alert('Error while request..');
                        }
                    });
                });
            });
        </script>
        <script>
            function getReceiptMode(text)
            {
                // alert(text);
                if(text == 'CHEQUE')
                {
                    document.getElementById('cheque_no_div').style.display = 'block';
                    document.getElementById('cheque_date_div').style.display = 'block';
                    document.getElementById('bank_name_div').style.display = 'block';
                }
                else
                {
                    document.getElementById('cheque_no_div').style.display = 'none';
                    document.getElementById('cheque_date_div').style.display = 'none';
                    document.getElementById('bank_name_div').style.display = 'none';
                }
                // document.getElementById('mode').value = text;
            }
        </script>
        <!-- page heading start-->
        <div class="page-heading">
            <h3>
                <?php echo $page_title; ?>
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Home</a>
                </li>
                <li class="active"><?php echo $page_title; ?> </li>
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
                        <form class="form-horizontal" action="<?php echo base_url(); ?>index.php/reciepts/add" method="post">
							<div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="receipt_voucher_date">Receipt Voucher Date <span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <input class="form-control form-control-inline input-medium default-date-picker" size="16" type="text" id="receipt_voucher_date" placeholder="Select Receipt Voucher Date" name="receipt_voucher_date" value="<?php echo date('d/m/Y'); ?>" autocomplete="off" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="from_ac">From a/c<span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                <?php
                                    $optionFrom = array('0'=>'--Select--');
                                    if(!empty($ledger)){
                                        foreach($ledger as $rowFrom){
                                            $optionFrom[$rowFrom->id] = $rowFrom->title;
                                        }
                                    }
                                    echo form_dropdown('from',$optionFrom,isset($_POST['from'])?$_POST['from']:'','class="form-control chosen-select" id="from_ac"');
                                ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="to_ac">To a/c<span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                <?php
                                    $optionTo = array('0'=>'--Select--');
                                    if(!empty($ledger)){
                                        foreach($ledger as $rowTo){
                                            $optionTo[$rowTo->id] = $rowTo->title;
                                        }
                                    }
                                    echo form_dropdown('to',$optionTo,isset($_POST['to'])?$_POST['to']:'','class="form-control chosen-select" id="to_ac"');
                                ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="sale_id">Sales Id<span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                <?php
                                    $optionSale = array('0'=>'--Select--');
                                    if(!empty($sales)){
                                        foreach($sales as $rowSale){
                                            $optionSale[$rowSale->id] = $rowSale->id;
                                        }
                                    }
                                    echo form_dropdown('sale_id',$optionSale,isset($_POST['sale_id'])?$_POST['sale_id']:'','class="form-control chosen-select" id="sale_id"');
                                ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="service">Service</label>
                                <div class="col-lg-9">
                                <?php
                                    $optionService = array('0'=>'--Select--');
                                    if(!empty($services)){
                                        foreach($services as $rowService){
                                            $optionService[$rowService->id] = $rowService->id;
                                        }
                                    }
                                    echo form_dropdown('service_id',$optionService,isset($_POST['service_id'])?$_POST['service_id']:'','class="form-control chosen-select" id="service"');
                                ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="invoice_no">Invoice No<span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Invoice No" id="invoice_no" name="invoice_no" value="<?php echo $inv_no; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="receipt_amount_payable">Receipt Amount Payable<span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Receipt Amount Payable" id="receipt_amount_payable" name="receipt_amount_payable" value="<?php echo set_value('amount_payable'); ?>" disabled >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="receipt_amount_paid">Receipt Amount Paid<span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Receipt Amount Paid" id="receipt_amount_paid" name="receipt_amount_paid" value="<?php echo set_value('receipt_amount_paid'); ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="description">Description<span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Description" id="description" name="description" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="mode_of_receipt">Mode Of Receipt<span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <select class="form-control" id="mode_of_receipt" name="mode_of_receipt" onchange="getReceiptMode(this.options[this.selectedIndex].text)">
                                        <option value="4">CASH</option>
                                        <option value="5">CHEQUE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" style="display:none;" id="cheque_no_div">
                                <label  class="col-lg-3 col-sm-3 control-label" for="cheque_no">Cheque Number</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Cheque Number" id="cheque_no" name="cheque_no" value="<?php echo set_value('cheque_no'); ?>">
                                </div>
                            </div>
                            <div class="form-group" style="display:none;" id="cheque_date_div">
                                <label  class="col-lg-3 col-sm-3 control-label" for="cheque_date">Cheque Date</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" placeholder="Cheque Date" id="cheque_date" name="cheque_date" value="<?php echo set_value('cheque_date'); ?>" autocomplete="off" >
                                </div>
                            </div>
                            <div class="form-group" style="display:none;" id="bank_name_div">
                                <label  class="col-lg-3 col-sm-3 control-label" for="bank_name">Bank Name</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Bank Name" id="bank_name" name="bank_name" value="<?php echo set_value('bank_name'); ?>">
                                </div>
                            </div>
                            <input type="hidden" name="inv_no" value="<?php echo $inv_no; ?>" />
                            <input type="hidden" name="amount_payable" id="amount_payable" value="<?php echo set_value('amount_payable'); ?>"/>
                            <div class="panel-body">
                                <p>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a class="btn btn-default" type="button" href="<?php echo base_url(); ?>index.php/reciepts">Cancel</a>
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