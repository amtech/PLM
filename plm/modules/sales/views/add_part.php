        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/prism.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/chosen.css">
        <script>
            var row_ids ;
            $(document).ready(function(){

                $(window).load(function(){
                    var seq = $('#seq').val();
                    row_ids = seq.split(',');
                });
                $('#submit').click(function(){
                    for(var a = 1 ; a <= row_ids.length ; a++){
                        if(($("#parts_id-"+a).val()) == 0){
                            alert("Please select part..");
                            return false;
                        }
                    }
                });
                var count = 2;
                $('#add').click(function(){
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
                                    '<option value="<?php echo $rowParts->id; ?>"><?php echo $rowParts->code; ?></option>'+
                                    <?php            
                                            }
                                        }
                                    ?>
                                '</select>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="Description" id="description-'+count+'" name="description'+count+'" disabled >'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="Quantity" id="quantity-'+count+'" name="quantity'+count+'" onkeyup="calculateSubTotal(this);" disabled>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="Price" id="price-'+count+'" name="price'+count+'" disabled>'+
                            '</td>'+
                            '<td>'+
                                '<select class="form-control" id="item_received-'+count+'" name="item_received'+count+'">'+
                                    '<option value="yes">Yes</option>'+
                                    '<option selected value="no">No</option>'+
                                '</select>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control sub_total" placeholder="Subtotal" id="subtotal-'+count+'" name="subtotal'+count+'" disabled>'+
                            '</td>'+
                            '<td>'+
                                '<button class="btn btn-primary" type="button" id="remove" onclick="deleteRow('+count+')">Remove</button>'+
                            '</td>'+
                            '<input type="hidden" name="sub_total'+count+'" id="sub_total-'+count+'">'+
                        '</tr>'
                    );
                    $('.drop').chosen(); 
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
                    $("#total_amt").val(total);
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
                        url: "<?php echo base_url(); ?>index.php/sales/getParts",
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
                var qty = $('#quantity-'+count).val();
                var cost = $('#price-'+count).val();
                var part_id = $('parts_id-'+count).val();
                var dis = $('#discount').val();
                var disc_value = $("#discount option:selected").text();
                var subtotal;
                var total = 0;
                var disc_val;
                subtotal = parseFloat(qty*(parseFloat(cost)));
                // alert(subtotal);
                $('#subtotal-'+count).val(subtotal);
                $('#sub_total-'+count).val(subtotal);
                $(".sub_total").each(function(){
                     total += parseFloat($(this).val()||0);
                });
                var s_total;
                if("<?php echo DEFAULT_DISCOUNT; ?>" == "fixed"){
                    disc_val = disc_value;
                    s_total = parseFloat(total) - disc_value;
                }else{
                    disc_val = (parseFloat(total)*parseFloat(disc_value)/100);
                    s_total = parseFloat(total) - (parseFloat(total)*parseFloat(disc_value)/100);
                }
                $('#disc_val').val(disc_val);
                $("#total_amt").val(s_total);
                $("#grand_total").val(s_total);
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
                <li class="active"><?php echo $page_title; ?> </li>
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
                        <?php echo $page_title; ?> Form
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php/sales/add_part" method="post">
                            <div class="form-group">
                                <label for="date" class="col-sm-2 control-label col-lg-2">Date</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="date" placeholder="Sale Part Date" name="date" value="<?php echo set_value('date',date('d/m/Y')); ?>" autocomplete="off">
                                </div>
                                
                                <label class="col-sm-2 control-label col-lg-2">Warehouse</label>
                                <div class="col-lg-4">
                                <?php
                                    $optionWr = array('0'=>'--Select Warehouse--');
                                    if(!empty($warehouses)){
                                        foreach($warehouses as $rowWr){
                                            $optionWr[$rowWr->id] = $rowWr->warehouse_name;
                                        }
                                    }
                                    echo form_dropdown('warehouse_id',$optionWr,isset($_POST['warehouse_id'])?$_POST['warehouse_id']:'','class="form-control chosen-select" id="warehouse_id"');
                                ?>
                                </div>
                                
                            </div>
							<div class="form-group">
                                <label for="po_no" class="col-sm-2 control-label col-lg-2">Client PO NO</label>
                                <div class="col-lg-4">
                                    <?php echo form_input($po_no); ?>
                                </div>
                                
                                <label for="quotation_no" class="col-sm-2 control-label col-lg-2">Quotation NO</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="quotation_no" placeholder="Quotation NO" name="quotation_no">
                                </div>
                                
                            </div>
							<div class="form-group">
                                <label for="payment_terms" class="col-sm-2 control-label col-lg-2">Payment Terms</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="payment_terms" placeholder="Payment Terms" name="payment_terms" value="<?php echo set_value('payment_terms'); ?>">
                                </div>
                                
                                <label for="ship_date" class="col-sm-2 control-label col-lg-2">Ship Date</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="ship_date" placeholder="Ship Date" value="<?php echo set_value('ship_date'); ?>" name="ship_date">
                                </div>
                                
                            </div>
							<div class="form-group">
                                <label for="customer_id" class="col-sm-2 control-label col-lg-2">Company Name</label>
                                <div class="col-lg-4">
                                <?php
                                    $optionCust = array('0'=>'--Select Company--');
                                    if(!empty($customers)){
                                        foreach($customers as $rowCust){
                                            $optionCust[$rowCust->id] = $rowCust->name;
                                        }
                                    }
                                    echo form_dropdown('customer_id',$optionCust,isset($_POST['customer_id'])?$_POST['customer_id']:'','class="form-control chosen-select" id="customer_id"');
                                ?>
                                </div>
                                
                                <label for="ship_to" class="col-sm-2 control-label col-lg-2">Ship To</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="ship_to" placeholder="Ship To" name="ship_to" value="<?php echo set_value('ship_to'); ?>">
                                </div>
                                
                            </div>
							<div class="form-group">
                                <label for="ship_via" class="col-sm-2 control-label col-lg-2">Ship Via</label>
                                <div class="col-lg-4">
                                    <!--<input type="text" class="form-control" id="ship_via" placeholder="Parts Ship Via" name="ship_via" value="<?php echo set_value('ship_via'); ?>">-->
                                <?php
                                    $optionShip = array(
                                        '0'         => '--Select--',
                                        'Air'       => 'Air',
                                        'Land'      => 'Land',    
                                        'DHL-TNT'   => 'DHL or TNT',
                                        'Sea'       => 'Sea'
                                    );
                                    echo form_dropdown('ship_via',$optionShip,isset($_POST['ship_via'])?$_POST['ship_via']:'','class="form-control" id="ship_via"');
                                ?>
                                </div>
                                
                                <label for="delivery" class="col-sm-2 control-label col-lg-2">Delivery Instruction</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="delivery" placeholder="Delivery Instruction" name="delivery" value="<?php echo set_value('delivery'); ?>">
                                </div>
                                
                            </div>
							<div class="form-group">
                                <label for="discount" class="col-sm-2 control-label col-lg-2">Discount</label>
                                <div class="col-lg-4">
                                <?php
                                    $optionDisc = array('0'=>'0');
                                    if(!empty($discount)){
                                        foreach($discount as $rowDis){
                                            $optionDisc[$rowDis->id] = $rowDis->value;
                                        }
                                    }
                                    echo form_dropdown('discount',$optionDisc,isset($_POST['discount'])?$_POST['discount']:'','class="form-control" id="discount" onchange="calculateSubTotal(this);"');
                                ?>
                                </div>
                                
                                <label for="total_amt" class="col-sm-2 control-label col-lg-2">Total Amount</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="total_amt" placeholder="Total Amount" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status" class="col-sm-2 control-label col-lg-2">Status</label>
                                <div class="col-lg-4">
                                <?php
                                    $optionStat = array(
                                        'complete'=>'Complete',
                                        'incomplete'=>'Incomplete'
                                    );
                                    echo form_dropdown('status',$optionStat,isset($_POST['status'])?$_POST['status']:'','class="form-control" id="status"');
                                ?>
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
                                            <td><label>Code</label></td>
                                            <td><label>Description</label></td>
                                            <td><label>Qauntity</label></td>
                                            <td><label>Price</label></td>
                                            <td><label>Item Received</label></td>
                                            <td><label>Subtotal</label></td>
                                            <td><label>Remove</label></td>
                                        </tr>
                                        <tr id="1">
                                            <td>
                                            <?php
                                                $optionPart1 = array('0'=>'--Select--');
                                                if(!empty($parts)){
                                                    foreach($parts as $rowPart){
                                                        $optionPart1[$rowPart->id] = $rowPart->code;
                                                    }
                                                }
                                                echo form_dropdown('parts_id1',$optionPart1,'','class="form-control chosen-select" id="parts_id-1" onchange="getParts(this);"');
                                            ?>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Description" id="description-1" name="description1" disabled >
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Quantity" id="quantity-1" name="quantity1" onkeyup="calculateSubTotal(this);" disabled >
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Price" id="price-1" name="price1" onkeyup="calculateSubTotal(this);">
                                            </td>
                                            <td>
                                                <select class="form-control" id="item_received-1" name="item_received1">
                                                    <option value="0">-- Select --</option>
                                                    <option value="yes">Yes</option>
                                                    <option selected value="no">No</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control sub_total" placeholder="Subtotal" id="subtotal-1" name="subtotal1" disabled >
                                            </td>
                                            <td></td>
                                            <input type="hidden" name="sub_total1" id="sub_total-1">
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <input type="hidden" name="disc_val" id="disc_val"/>
                            <input type="hidden" name="grand_total" id="grand_total"/>
                            <input type="hidden" name="seq" id="seq" value="1"/>
                            <div class="panel-body">
                                <p>
                                    <button class="btn btn-primary" type="submit" id="submit">Submit</button>
                                    <a href="<?php echo base_url(); ?>index.php/sales/parts" class="btn btn-default" type="button">Cancel</a>
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