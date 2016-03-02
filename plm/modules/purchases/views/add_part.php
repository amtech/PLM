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
                        if(($("#parts_product_id-"+a).val()) == 0){
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
                                '<select name="parts_product_id'+count+'" id="parts_product_id-'+count+'" class="form-control chosen-select drop" onchange="getParts(this);">'+
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
                                '<input type="text" class="form-control" placeholder="Qty" id="parts_product_qty-'+count+'" name="parts_product_qty'+count+'" onkeyup="calculateSubTotal(this);" value="1" disabled>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="Freight" id="parts_product_freight-'+count+'" name="parts_product_freight'+count+'" onkeyup="calculateSubTotal(this);" value="0.00" disabled>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="Customs" id="parts_product_customs-'+count+'" name="parts_product_customs'+count+'" onkeyup="calculateSubTotal(this);" value="0.00" disabled>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="Cost" id="parts_product_cost-'+count+'" name="parts_product_cost'+count+'" disabled>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control" placeholder="Service Tax" id="service_tax-'+count+'" name="service_tax'+count+'" value="0" onkeyup="calculateSubTotal(this);">'+
                            '</td>'+
                            '<td>'+
                                '<select class="form-control" id="parts_received-'+count+'" name="parts_received'+count+'">'+
                                    '<option value="yes">Yes</option>'+
                                    '<option selected value="no">No</option>'+
                                '</select>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control sub_total" placeholder="Subtotal" id="parts_product_subtotal-'+count+'" name="parts_product_subtotal'+count+'" disabled>'+
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
                        url: "<?php echo base_url(); ?>index.php/purchases/getParts",
                        cache: false,               
                        data: {part_id: part_id},
                        async:false,
                        success: function(data){
                        try{
                            var obj = JSON.parse(data);
                            $("#parts_product_qty-"+count).removeAttr("disabled");
                            $("#parts_product_customs-"+count).removeAttr("disabled");
                            $("#parts_product_freight-"+count).removeAttr("disabled");
                            $("#parts_product_cost-"+count).removeAttr("disabled");
                            $("#parts_product_cost-"+count).val(obj[0].cost);
                            $("#description-"+count).removeAttr("disabled");
                            $("#description-"+count).val(obj[0].name);
							var qty = $("#parts_product_qty-"+count).val();
							$("#parts_product_subtotal-"+count).val(parseFloat(obj[0].cost)*qty);
							var total = 0;
							$(".sub_total").each(function(){
								 total += parseFloat($(this).val()||0);
							});
							$("#total_amt").val(total);
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
                var qty = $('#parts_product_qty-'+count).val();
                var cost = parseFloat($('#parts_product_cost-'+count).val());
                // var freight = $('#parts_product_freight-'+count).val();
                var customs;
                var service_tax = parseFloat($('#service_tax-'+count).val());
                var freight = parseFloat($('#parts_product_freight-'+count).val());
                customs = $('#parts_product_customs-'+count).val();//parseFloat((((cost * qty)+freight)*5)/100);
                //service_tax = parseFloat(((cost * qty) + customs)*10/100);
                // $('#parts_product_customs-'+count).val(customs);
                //$('#service_tax-'+count).val(service_tax);
                var part_id = $('parts_product_id-'+count).val();
                if(part_id == "0"){
                    alert('Please select part.');
                    // $('#parts_product_qty'+count).val() = "";
                    // $('#parts_product_customs'+count).val() = 0.00;
                    // $('#parts_product_freight'+count).val() = 0.00;
                    // $('#parts_product_cost'+count).val() = "";
                    // $('#parts_received'+count).val("no");
                    return false;
                }else{
                    // code for subtotal (cost*quantity*freight*customs)
                    var subtotal;
                    var total = 0;
                    subtotal = parseFloat(qty*(parseFloat(cost))+parseFloat(freight)+parseFloat(customs))+parseFloat(service_tax);
                    // alert(subtotal);
                    $('#parts_product_subtotal-'+count).val(subtotal);
                    $('#sub_total-'+count).val(subtotal);
                    $(".sub_total").each(function(){
                         total += parseFloat($(this).val()||0);
                    });
                    $("#total_amt").val(total);
                    $("#grand_total").val(total);
                }
            }
        </script>
        <!-- page heading start-->
        <div class="page-heading">
            <h3>
                Add Purchase Part
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
                        <?php echo $page_title; ?> Form
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>index.php/purchases/add_part">
                            <div class="form-group">
                                <label for="po_no" class="col-sm-2 control-label col-lg-2">PO No</label>
                                <div class="col-lg-4">
                                    <?php
                                        echo form_input($po_no);
                                    ?>
                                    <!--<input type="text" class="form-control" id="po_no" placeholder="Purchase Order No" name="po_no" value="<?php echo set_value('po_no'); ?>">-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="part_shipping" class="col-sm-2 control-label col-lg-2">Parts Shipping Instruction</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="part_shipping" placeholder="Parts Shipping Instruction" name="part_shipping" value="<?php echo set_value('part_shipping'); ?>">
                                </div>
                                <label for="warehouse_id" class="col-sm-2 control-label col-lg-2">Warehouse</label>
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
                                <label for="vendor_ref" class="col-sm-2 control-label col-lg-2">Vendor name</label>
                                <div class="col-lg-4">
                                    <?php
                                        $optionVendor = array('0'=>'--Select Vendor--');
                                        if(!empty($vendor)){
                                            foreach($vendor as $rowVendor){
                                                $optionVendor[$rowVendor->id] = $rowVendor->company_name;
                                            }
                                        }
                                        echo form_dropdown('vendor_ref',$optionVendor,isset($_POST['vendor_id'])?$_POST['vendor_id']:'','class="form-control chosen-select" id="vendor_ref"');
                                    ?>
                                </div>
                                
                                <label for="expected_date" class="col-sm-2 control-label col-lg-2">Parts Expected Date</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="expected_date" placeholder="Parts Expected Date" name="expected_date" value="<?php echo set_value('expected_date'); ?>" autocomplete="off">
                                </div>
                            </div>
							<div class="form-group">
                                <label for="order_date" class="col-sm-2 control-label col-lg-2">Parts Purchase Order Date</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="order_date" placeholder="Parts Purchase Order Date" name="order_date" value="<?php echo set_value('order_date'); ?>" autocomplete="off">
                                </div>
                                
                                <label for="ship_via" class="col-sm-2 control-label col-lg-2">Parts Ship Via</label>
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
                            </div>
							<div class="form-group">
                                <label for="ship_to" class="col-sm-2 control-label col-lg-2">Parts Ship To</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="ship_to" placeholder="Parts Ship To" name="ship_to" value="<?php echo set_value('ship_to'); ?>">
                                </div>
                                
                                <label for="total_amt" class="col-sm-2 control-label col-lg-2">Parts Total Amount</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="total_amt" placeholder="Parts Total Amount" disabled name="total_amt">
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
                                        <td width="20%"><label>Description</label></td>
                                        <td width="5%"><label>Product Qty</label></td>
                                        <td width="10%"><label>Product Freight</label></td>
                                        <td width="5%"><label>Product Customs</label></td>
            							<td width="5%"><label>Product Cost</label></td>
            							<td width="10%"><label>Service Tax</label></td>
            							<td width="10%"><label>Parts Received</label></td>
                                        <td width="10%"><label>Product Subtotal</label></td>
                                        <td width="10%"><label>Action</label></td>
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
                                            <input type="text" class="form-control" placeholder="Description" id="description-1" name="description1" disabled >
                                        </td>
                                        
                                        <td>
                                            <input type="text" class="form-control" placeholder="Qty" id="parts_product_qty-1" name="parts_product_qty1" onkeyup="calculateSubTotal(this);" value="1" disabled >
                                        </td>    
            							
            							<td>
                                            <input type="text" class="form-control" placeholder="Freight" id="parts_product_freight-1" name="parts_product_freight1" value="0.00" onkeyup="calculateSubTotal(this);" disabled >
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" placeholder="Customs" id="parts_product_customs-1" name="parts_product_customs1" value="0.00" onkeyup="calculateSubTotal(this);" disabled >
                                        </td>  
            							
            							<td>
                                            <input type="text" class="form-control" placeholder="Cost" id="parts_product_cost-1" name="parts_product_cost1" onkeyup="calculateSubTotal(this);" disabled>
                                        </td>
                                        
                                        <td>
                                            <input type="text" class="form-control" placeholder="Service Tax" id="service_tax-1" name="service_tax1" onkeyup="calculateSubTotal(this);" value="0">
                                        </td>
            							
            							 <td>
                                            <select class="form-control" id="parts_received-1" name="parts_received1">
                                                <option value="yes">Yes</option>
                                                <option selected value="no">No</option>
                                            </select>
                                        </td>
            							
            							<td>
                                            <input type="text" class="form-control sub_total" placeholder="Subtotal" id="parts_product_subtotal-1" name="parts_product_subtotal1" disabled >
                                        </td>
                                        <td></td>
                                        <input type="hidden" name="sub_total1" id="sub_total-1">
                                    </tr>
        					   </table>
					        </div>
                            
                            <input type="hidden" name="grand_total" id="grand_total"/>
                            <input type="hidden" name="seq" id="seq" value="1"/>
        					<div class="panel-body">
        						<p>
        							<button class="btn btn-primary" type="submit" id="submit">Submit</button>
        							<a href="<?php echo base_url(); ?>index.php/purchases/parts" class="btn btn-default" type="button">Cancel</a>
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