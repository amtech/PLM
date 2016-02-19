        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/prism.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/chosen.css">
        <script type="text/javascript">
            $(document).ready(function(){
                $('#service_form').submit(function(){
                    if($('#record_id').val() == ''){
                        $('#error_record').html('<p>Please select recrd.</p>');
                        return false;
                    }else{
                        $('#error_record').html('');
                    }
                    
                    if($('#service_date').val() == ''){
                        $('#error_service_date').html('<p>Service date is required.</p>');
                        return false;
                    }else{
                        $('#error_service_date').html('');
                    }
                    
                    if($('#warranty').val() == 0){
                        $('#error_warranty').html('<p>Please select warranty.</p>');
                        return false;
                    }else{
                        $('#error_warranty').html('');
                    }
                    
                    if($('#working_hour').val() == ''){
                        $('#error_working_hour').html('<p>Working Hour is required field.</p>');
                        return false;
                    }else{
                        $('#error_working_hour').html('');
                    }
                    
                    if($('#technician_id').val() == ''){
                        $('#error_technician').html('<p>Technician is required field.</p>');
                        return false;
                    }else{
                        $('#error_technician').html('');
                    }
                    
                    if($('#service_report_no').val() == ''){
                        $('#error_service_report_no').html('<p>Service Report number is required field.</p>');
                        return false;
                    }else{
                        $('#error_service_report_no').html('');
                    }
                    
                    if(!$('#service_report').val()){
                        $('#error_service_report').html('<p>Please select file.</p>');
                        return false;
                    }else{
                        $('#error_service_report').html('');
                    }
                });
                $('#remark_note').change(function(){
                    var remark_note = $('#remark_note').val();
                    if(remark_note == 'yes'){
                        $('#remark_div').css('display','block');
                        
                    }else{
                        $('#remark_div').css('display','none');
                    }
                });
                $('#part_needed').change(function(){
                    var part_needed = $('#part_needed').val();
                    if(part_needed == 'yes'){
                        $('#part_detail').css('display','block');
                        $( "#stock_status-1" ).addClass( "chosen-select" );
                        $( "#supply_condition-1" ).addClass( "chosen-select" );
                        $("#parts_id-1").addClass("chosen-select");
                        $("#stock_status-1").chosen();
                        $("#supply_condition-1").chosen();
                        $("#parts_id-1").chosen();
                    }else{
                        $('#part_detail').css('display','none');
                    }
                });
                var row_ids ;
                $(window).load(function(){
                    var seq = $('#seq').val();
                    row_ids = seq.split(',');
                });

                var count = <?php echo $seq_row; ?>;
                // add new row
                $('#add').click(function(){
                    // alert(row_ids);
                    row_ids.push(count);
                    $('#myTable tr:last').after(
                        '<tr id='+count+'>'+
                            '<td>'+
                                '<select name="parts_id'+count+'" id="parts_id-'+count+'" class="form-control chosen-select drop" onchange="getParts(this);">'+
                                    '<option value="0">--Select--</option>'+
                                    <?php 
                                        if(!empty($parts)){
                                            foreach($parts as $rowParts){
                                    ?>
                                    '<option value="<?php echo $rowParts->id; ?>"><?php echo $rowParts->name; ?></option>'+
                                    <?php            
                                            }
                                        }
                                    ?>
                                '</select>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="0" id="quantity-'+count+'" name="quantity'+count+'" onkeyup="calculateSubTotal(this);" disabled>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="0.00" id="price-'+count+'" name="price'+count+'" onkeyup="calculateSubTotal(this);" disabled>'+
                            '</td>'+
                            '<td>'+
                                '<select class="form-control chosen-select drop" name="supply_condition'+count+'" id="supply_condition-'+count+'">'+
                                    '<option value="free" selected>Free</option>'+
                                    '<option value="paid">Paid</option>'+
                                '</select>'+
                            '</td>'+
                            '<td>'+
                                '<select class="form-control chosen-select drop" name="stock_status'+count+'" id="stock_status-'+count+'">'+
                                    '<option value="yes">Yes</option>'+
                                    '<option value="no" selected>No</option>'+
                                '</select>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control datepicker_recurring_start" id="order_date-'+count+'" name="order_date'+count+'" autocomplete="off" >'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control datepicker_recurring_start" id="arrival_date-'+count+'" name="arrival_date'+count+'" autocomplete="off">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control datepicker_recurring_start" id="delivery_date-'+count+'" name="delivery_date'+count+'" autocomplete="off">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" id="description-'+count+'" name="description'+count+'" disabled>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control sub_total" placeholder="0.00" id="grand_total-'+count+'" name="grand_total'+count+'" disabled>'+
                            '</td>'+
                            '<td>'+
                                '<button class="btn btn-primary" type="button" id="remove" onclick="deleteRow('+count+')">Remove</button>'+
                            '</td>'+
                            '<input type="hidden" name="sub_total'+count+'" id="sub_total-'+count+'">'+
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
                    $("#parts_charge").val(total);
                    $("#parts_total").val(total);
                    var service = $('#service_charge').val();
                    var total_charge = parseFloat(total) + parseFloat(service);
                    $('#total_charge').val(total_charge);
                    $('#total').val(total_charge);
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
                            $("#price-"+count).removeAttr("disabled");
                            $("#description-"+count).removeAttr("disabled");
                            $("#price-"+count).val(obj[0].price);
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
                var qty = $("#quantity-"+count).val();
                var price = $("#price-"+count).val();
                // code for subtotal (cost*quantity*freight*customs)
                var subtotal;
                var total = 0;
                var condition = $('#supply_condition-'+count).val();
                
                if(condition == 'paid'){
                    subtotal = parseFloat(qty*parseFloat(price));
                    // alert(subtotal);
                    
                    $('#sub_total-'+count).val(subtotal);
                    $('#grand_total-'+count).val(subtotal);
                    $(".sub_total").each(function(){
                         total += parseFloat($(this).val()||0);
                    });
                    $("#parts_charge").val(total);
                    $("#parts_total").val(total);
                    var service = $('#service_charge').val();
                    var total_charge = parseFloat(total) + parseFloat(service);
                    $('#total_charge').val(total_charge);
                    $('#total').val(total_charge);
                }else{
                    $('#sub_total-'+count).val(0.00);
                    $('#grand_total-'+count).val(0.00);
                    $(".sub_total").each(function(){
                         total += parseFloat($(this).val()||0);
                    });
                    $("#parts_charge").val(total);
                    $("#parts_total").val(total);
                    var service = $('#service_charge').val();
                    var total_charge = parseFloat(total) + parseFloat(service);
                    $('#total_charge').val(total_charge);
                    $('#total').val(total_charge);
                }
            }
            function calculateTotal(service_charge){
                var parts_charge = $('#parts_charge').val();
                var total = parseFloat(parts_charge) + parseFloat(service_charge);
                $('#total_charge').val(total);
                $('#total').val(total);
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
                <form class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php/services/edit/<?php echo $id; ?>" method="post" enctype="multipart/form-data" id="service_form">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?>
                    </header>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="record_id" class="col-sm-2 control-label col-lg-2">Record</label>
                            <div class="col-lg-4">
                            <?php
                                $optionRecord = array('0'=>'--Select--');
                                if(!empty($records)){
                                    foreach($records as $rowRecord){
                                        $optionRecord[$rowRecord->id] = $rowRecord->ro_no;
                                    }
                                }
                                echo form_dropdown('record_id',$optionRecord,isset($_POST['record_id'])?$_POST['record_id']:$services[0]->record_id,'class="form-control chosen-select" id="record_id"');
                            ?>  
                            <span id="error_record"></span>
                            </div>
                            <label for="service_date" class="col-sm-2 control-label col-lg-2">Service Date</label>
                            <div class="col-lg-4">
                                <input class="form-control form-control-inline input-medium default-date-picker" type="text" id="service_date" placeholder="Select Quotation Date" name="service_date" value="<?php echo set_value('service_date',date('d/m/Y',strtotime($services[0]->service_date))); ?>" autocomplete="off" />
                                <span id="error_service_date"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="warranty" class="col-sm-2 control-label col-lg-2">Warranty</label>
                            <div class="col-lg-4">
                                <select name="warranty" id="warranty" class="form-control">
                                    <option value="0">--Select Warranty--</option>
                                    <option value="yes" <?php if($services[0]->warranty == 'yes'){?>selected <?php } ?>>Yes</option>
                                    <option value="no" <?php if($services[0]->warranty == 'no'){?>selected <?php } ?>>No</option>
                                </select>
                                <span id="error_warranty"></span>
                            </div>
                            <label for="working_hour" class="col-sm-2 control-label col-lg-2">Working Hour</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="working_hour" id="working_hour" value="<?php echo set_value('working_hour',$services[0]->working_hour) ?>"/>
                                <span id="error_working_hour"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="technician_id" class="col-sm-2 control-label col-lg-2">Technician</label>
                            <div class="col-lg-4">
                                <input type="text" name="technician_name" id="technician_id" value="<?php echo set_value('technician_name',$services[0]->technician_name) ?>" class="form-control" />
                                <span id="error_technician"></span>
                            </div>
                            
                            <label for="service_report_no" class="col-sm-2 control-label col-lg-2">Service Report No</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" id="service_report_no" name="service_report_no" value="<?php echo set_value('service_report_no',$services[0]->service_report_no) ?>"/>
                                <span id="error_service_report_no"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="job_status" class="col-sm-2 control-label col-lg-2">Job Status</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="job_status" id="job_status">
                                    <option value="yes" <?php if($services[0]->job_status == 'yes'){ ?>selected <?php } ?>>Completed</option>
                                    <option value="no" <?php if($services[0]->job_status == 'no'){ ?>selected <?php } ?>>Pending</option>
                                </select>
                            </div>
                            
                            <label for="remark_note" class="col-sm-2 control-label col-lg-2">Remark Note</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="remark_note" id="remark_note">
                                    <option value="no" <?php if($services[0]->remark_note == 'no'){ ?>selected <?php } ?>>No</option>
                                    <option value="yes" <?php if($services[0]->remark_note == 'yes'){ ?>selected <?php } ?>>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="part_needed" class="col-sm-2 control-label col-lg-2">Part Needed</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="part_needed" id="part_needed">
                                    <option value="no" <?php if($services[0]->part_needed == 'no'){ ?>selected <?php } ?>>No</option>
                                    <option value="yes" <?php if($services[0]->part_needed == 'yes'){ ?>selected <?php } ?>>Yes</option>
                                </select>
                            </div>
                            
                            <label for="service_report" class="col-sm-2 control-label col-lg-2">Service Report</label>
                            <div class="col-lg-4">
                                <input type="file" name="service_report" id="service_report" />
                                <span id="error_service_report"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="parts_charge" class="col-sm-2 control-label col-lg-2">Parts Charge</label>
                            <div class="col-lg-4">
                                <input type="text" name="parts_charge" id="parts_charge" class="form-control" value="<?php echo $services[0]->parts_total; ?>" disabled />
                            </div>
                            
                            <label for="service_charge" class="col-sm-2 control-label col-lg-2">Service Charge</label>
                            <div class="col-lg-4">
                                <input type="text" name="service_charge" id="service_charge" class="form-control" value="<?php echo $services[0]->service_charge; ?>" onkeyup="(calculateTotal(this.value))"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="total_charge" class="col-sm-2 control-label col-lg-2">Total Charge</label>
                            <div class="col-lg-4">
                                <input type="text" name="total_charge" id="total_charge" class="form-control" value="<?php echo $services[0]->total; ?>" disabled />
                            </div>
                        </div>
                    </div>
                </section>
                <section class="panel" id="part_detail" <?php if($services[0]->part_needed == 'no'){ ?>style="display:none;"<?php } ?>>
                    <header class="panel-heading">
                        Part Details
                    </header>
                    <div class="panel-body">
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
                                        <td width="12%"><label>Parts</label></td>
                                        <td width="6%"><label>Quantity</label></td>
                                        <td width="7%"><label>Price</label></td>
                                        <td width="6%"><label>Supply Condition</label></td>
                                        <td width="10%"><label>Stock Available</label></td>
                                        <td width="12%"><label>Order Date</label></td>
                                        <td width="12%"><label>Estimate Arrival Date</label></td>
                                        <td width="12%"><label>Delivery Date</label></td>
                                        <td width="11%"><label>Description</label></td>
                                        <td width="9%"><label>Sub Total</label></td>
                                        <td width="2%"><label>Remove</label></td>
                                    </tr>
                                    <?php
                                        if(!empty($service_part)){
                                            $count = 1;
                                            foreach($service_part as $row){
                                                $s[] = $count;
                                    ?>
                                    <tr id="<?php echo $count++; ?>">
                                        <td>
                                        <?php
                                            $optionParts = array('0'=>'--Select--');
                                            if(!empty($parts)){
                                                foreach($parts as $rowParts){
                                                    $optionParts[$rowParts->id] = $rowParts->name.' - '.$rowParts->serial_no;
                                                }
                                            }
                                            $part_id = $count-1;
                                            echo form_dropdown("parts_id$part_id",$optionParts,$row->part_id,'class="form-control chosen-select" id="parts_id-'.$part_id.'" onchange="getParts(this);"');
                                        ?>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" placeholder="0" id="quantity-<?php echo ($count-1); ?>" name="quantity<?php echo ($count-1); ?>" value="<?php echo $row->quantity; ?>" onkeyup="calculateSubTotal(this);" >
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" placeholder="0.00" id="price-<?php echo ($count-1); ?>" name="price<?php echo ($count-1); ?>" onkeyup="calculateSubTotal(this);" value="<?php echo $row->price; ?>">
                                        </td>
                                        <td>
                                            <select class="form-control" name="supply_condition<?php echo ($count-1); ?>" id="supply_condition-<?php echo ($count-1); ?>">
                                                <option value="free" <?php if($row->supplied_condition == 'free'){?>selected <?php } ?>>Free</option>
                                                <option value="paid" <?php if($row->supplied_condition == 'paid'){?>selected <?php } ?>>Paid</option>
                                            </select>
                                        </td>    
                                        <td>
                                            <select class="form-control" name="stock_status<?php echo ($count-1); ?>" id="stock_status-<?php echo ($count-1); ?>">
                                                <option value="yes" <?php if($row->available_stock == 'paid'){?>selected <?php } ?>>Yes</option>
                                                <option value="no" <?php if($row->available_stock == 'paid'){?>selected <?php } ?>>No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="order_date-<?php echo ($count-1); ?>" name="order_date<?php echo ($count-1); ?>" value="<?php echo date('d/m/Y',strtotime($row->order_date)); ?>" autocomplete="off" >
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="arrival_date-<?php echo ($count-1); ?>" name="arrival_date<?php echo ($count-1); ?>" value="<?php echo date('d/m/Y',strtotime($row->estimate_arrival_date)); ?>" autocomplete="off" >
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="delivery_date-<?php echo ($count-1); ?>" name="delivery_date<?php echo ($count-1); ?>" value="<?php echo date('d/m/Y',strtotime($row->delivery_date)); ?>" autocomplete="off" >
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="description-<?php echo ($count-1); ?>" name="description<?php echo ($count-1); ?>" value="<?php echo $row->description;?>">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control sub_total" id="grand_total-<?php echo ($count-1); ?>" name="grand_total<?php echo ($count-1); ?>" value="<?php echo $row->sub_total; ?>" disabled>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary" type="button" id="remove" onclick="deleteRow(<?php echo $count-1; ?>)">Remove</button>
                                        </td>
                                        <input type="hidden" name="sub_total<?php echo ($count-1); ?>" id="sub_total-<?php echo ($count-1); ?>" value="<?php echo $row->sub_total; ?>"/>
                                    </tr>
                                    <?php
                                            }
                                        }
                                        $seq = implode(',',$s);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" name="seq" id="seq" value="<?php echo $seq; ?>"/>
                        <input type="hidden" name="parts_total" id="parts_total" value="<?php echo $services[0]->parts_total; ?>"/>
                        <input type="hidden" name="total" id="total" value="<?php echo $services[0]->total; ?>"/>
                        <input type="hidden" name="service_report_edit" value="<?php echo $services[0]->service_report; ?>"/>
                    </div>
                </section>
                <section class="panel" id="remark_div" <?php if($services[0]->remark_note == 'no'){ ?>style="display:none;"<?php } ?>>
                    <header class="panel-heading">
                        Remarks
                    </header>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div style="padding:10px;">
                                <textarea class="form-control" name="editor1" rows="6" id="remarks"><?php echo $services[0]->remarks; ?></textarea>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="panel-body">
                    <p>
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a href="<?php echo base_url(); ?>index.php/services" class="btn btn-default" type="button">Cancel</a>
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