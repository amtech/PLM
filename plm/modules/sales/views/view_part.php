        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/prism.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/chosen.css">
        <script>
            var row_ids ;
            $(document).ready(function(){

                var row_ids ;
                $(window).load(function(){
                    var seq = $('#seq').val();
                    row_ids = seq.split(',');
                });

                var count = <?php echo $seq_row; ?>;
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
                                    '<option value="<?php echo $rowParts->id; ?>"><?php echo $rowParts->name; ?></option>'+
                                    <?php            
                                            }
                                        }
                                    ?>
                                '</select>'+
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
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?> Form
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php/sales/edit_part/<?php echo $id; ?>" method="post">
                            <div class="form-group">
                                <label for="date" class="col-sm-2 control-label col-lg-2">Date</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="date" placeholder="Sale Part Date" name="date" value="<?php echo set_value('date',date('d/m/Y',strtotime($sale_part[0]->date))); ?>" disabled>
                                </div>
                                
                                <label for="po_no" class="col-sm-2 control-label col-lg-2">Client PO NO</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="po_no" placeholder="Client PO NO" value="<?php echo set_value('po_no',$sale_part[0]->po_no); ?>" name="po_no" disabled>
                                </div>
                            </div>
							<div class="form-group">
                                <label for="quotation_no" class="col-sm-2 control-label col-lg-2">Quotation NO</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="quotation_no" placeholder="Quotation NO" name="quotation_no" disabled>
                                </div>
                                
                                <label for="payment_terms" class="col-sm-2 control-label col-lg-2">Payment Terms</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="payment_terms" placeholder="Payment Terms" name="payment_terms" value="<?php echo set_value('payment_terms',$sale_part[0]->payment_terms); ?>" disabled>
                                </div>
                            </div>
							<div class="form-group">
                                <label for="ship_date" class="col-sm-2 control-label col-lg-2">Ship Date</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="ship_date" placeholder="Ship Date" value="<?php echo set_value('ship_date',date('d/m/Y',strtotime($sale_part[0]->ship_date))); ?>" name="ship_date" disabled>
                                </div>
                                
                                <label for="customer_id" class="col-sm-2 control-label col-lg-2">Customer</label>
                                <div class="col-lg-4">
                                <?php
                                    $optionCust = array('0'=>'--Select Customer--');
                                    if(!empty($customers)){
                                        foreach($customers as $rowCust){
                                            $optionCust[$rowCust->id] = $rowCust->name;
                                        }
                                    }
                                    echo form_dropdown('customer_id',$optionCust,isset($_POST['customer_id'])?$_POST['customer_id']:$sale_part[0]->customer_id,'class="form-control chosen-select" id="customer_id" disabled');
                                ?>
                                </div>
                            </div>
							<div class="form-group">
                                <label for="ship_to" class="col-sm-2 control-label col-lg-2">Ship To</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="ship_to" placeholder="Ship To" name="ship_to" value="<?php echo set_value('ship_to',$sale_part[0]->ship_to); ?>" disabled>
                                </div>
                                
                                <label for="ship_via" class="col-sm-2 control-label col-lg-2">Ship Via</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="ship_via" placeholder="Ship Via" name="ship_via" value="<?php echo set_value('ship_via',$sale_part[0]->ship_via); ?>" disabled>
                                </div>
                            </div>
							<div class="form-group">
                                <label for="delivery" class="col-sm-2 control-label col-lg-2">Delivery Instruction</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="delivery" placeholder="Delivery Instruction" name="delivery" value="<?php echo set_value('delivery',$sale_part[0]->delivery); ?>" disabled>
                                </div>
                                
                                <label for="discount" class="col-sm-2 control-label col-lg-2">Discount</label>
                                <div class="col-lg-4">
                                <?php
                                    $optionDisc = array('0'=>'0');
                                    if(!empty($discount)){
                                        foreach($discount as $rowDis){
                                            $optionDisc[$rowDis->id] = $rowDis->value;
                                        }
                                    }
                                    echo form_dropdown('discount',$optionDisc,isset($_POST['discount'])?$_POST['discount']:$sale_part[0]->discount,'class="form-control" id="discount" onchange="calculateSubTotal(this);" disabled');
                                ?>
                                </div>
                            </div>
							<div class="form-group">
                                <label for="total_amt" class="col-sm-2 control-label col-lg-2">Total Amount</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="total_amt" placeholder="Total Amount" value="<?php echo $sale_part[0]->total; ?>" disabled>
                                </div>
                                <label for="status" class="col-sm-2 control-label col-lg-2">Status</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="status" placeholder="Status" value="<?php echo $sale_part[0]->status; ?>" disabled>
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
                                        <?php
                                            if(!empty($sale_part)){
                                                $count = 1;
                                                foreach($sale_part as $row){
                                                    $s[] = $count;
                                        ?>
                                        <tr id="<?php echo $count++; ?>">
                                            <td>
                                            <?php
                                                $optionPart1 = array('0'=>'--Select--');
                                                if(!empty($parts)){
                                                    foreach($parts as $rowPart){
                                                        $optionPart1[$rowPart->id] = $rowPart->code;
                                                    }
                                                }
                                                $part_count = $count-1;
                                                echo form_dropdown("parts_id$part_count",$optionPart1,$row->part_id,'class="form-control chosen-select" id="parts_id-'.$part_count.'" onchange="getParts(this);" disabled');
                                            ?>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="description" id="description-<?php echo ($count-1); ?>" name="description<?php echo ($count-1); ?>" value="<?php echo $row->description; ?>" disabled>
                                            </td>                                            
                                            <td>
                                                <input type="text" class="form-control" placeholder="Quantity" id="quantity-<?php echo ($count-1); ?>" name="quantity<?php echo ($count-1); ?>" onkeyup="calculateSubTotal(this);" value="<?php echo $row->quantity; ?>" disabled>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Price" id="price-<?php echo ($count-1); ?>" name="price<?php echo ($count-1); ?>" onkeyup="calculateSubTotal(this);" value="<?php echo $row->price; ?>" disabled>
                                            </td>
                                            <td>
                                                <select class="form-control" id="item_received-<?php echo ($count-1); ?>" name="item_received<?php echo ($count-1); ?>" disabled>
                                                    <option value="0">-- Select --</option>
                                                    <option value="yes" <?php if($row->item_received == 'yes'){ ?>selected <?php } ?>>Yes</option>
                                                    <option value="no" <?php if($row->item_received == 'no'){ ?>selected <?php } ?>>No</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control sub_total" placeholder="Subtotal" id="subtotal-<?php echo ($count-1); ?>" name="subtotal<?php echo ($count-1); ?>" value="<?php echo $row->sub_total; ?>" disabled >
                                            </td>
                                            <td>
                                                <button class="btn btn-primary" type="button" id="remove" onclick="deleteRow(<?php echo $count-1; ?>)">Remove</button>
                                            </td>
                                            <input type="hidden" name="sub_total<?php echo ($count-1); ?>" id="sub_total-<?php echo ($count-1); ?>" value="<?php echo $row->sub_total; ?>" />
                                        </tr>
                                        <?php
                                                }
                                            }
                                            $seq = implode(',',$s);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <input type="hidden" name="disc_val" id="disc_val" value="<?php echo $sale_part[0]->discount_value; ?>"/>
                            <input type="hidden" name="grand_total" id="grand_total" value="<?php echo $sale_part[0]->total; ?>"/>
                            <input type="hidden" name="seq" id="seq" value="<?php echo $seq; ?>"/>
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