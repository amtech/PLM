        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/prism.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/chosen.css">
        <script type="text/javascript">
        $(document).ready(function() {
            var oTable = $('#customer_equipment').dataTable( {
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                dom: 'T<"clear">lfrtip',
                tableTools: {
                    "sSwfPath": "<?php echo base_url(); ?>assets/swf/copy_csv_xls_pdf.swf",
                    "aButtons": [
                        "copy",
                        "csv",
                        "xls",
                        {
                            "sExtends": "pdf",
                            "sPdfOrientation": "landscape",
                        },
                        "print"
                    ]
                }
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
                <li>
                    <a href="#"><?php echo $page_title; ?></a>
                </li>
            </ul>
        </div>
        <!-- page heading end-->

        <!--body wrapper start-->
        <div class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <section class="panel">
                        <header class="panel-heading custom-tab ">
                            <?php echo $page_title; ?>
                        </header>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="purchase_order">
                                    <div class="adv-table">
                                        <table  class="display table table-bordered table-striped" id="customer_equipment">
                                            <thead>
                                                <tr>
                                                    <th>Brand Name</th>
                                                    <th>Category</th>
                                                    <th>Customer Name</th>
                                                    <th>Model Name</th>
                                                    <th>Serial No</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data goes here -->
                                                <?php
                                                    if(!empty($equip)){
                                                        foreach($equip as $row){
                                                ?>
                                                <tr>
                                                    <td><?php echo $row->brand_name; ?></td>
                                                    <td><?php echo $row->category_name; ?></td>
                                                    <td><?php echo $row->name; ?></td>
                                                    <td><?php echo $row->model_name; ?></td>
                                                    <td><?php echo $row->serial_no; ?></td>
                                                </tr>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="pending_po">
                                    <div class="adv-table">
                                        <table  class="display table table-bordered table-striped" id="inventory_by_item">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                    <th>Warehouse</th>
                                                    <th>Vendor</th>
                                                    <th>PO Number</th>
                                                    <th>Order Date</th>
                                                    <th>Delivery Date</th>
                                                    <th>Quantity</th>
                                                    <th>Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data goes here -->
                                                <?php
                                                    if(!empty($records1)){
                                                        foreach($records1 as $row){
                                                ?>
                                                <tr>
                                                    <td><?php echo $row->code; ?></td>
                                                    <td><?php echo $row->name; ?></td>
                                                    <td><?php echo $row->warehouse_name; ?></td>
                                                    <td><?php echo $row->vendor_reference; ?></td>
                                                    <td><?php echo $row->po_no; ?></td>
                                                    <td><?php echo $row->order_date; ?></td>
                                                    <td><?php echo $row->expected_date; ?></td>
                                                    <td><?php echo $row->quantity; ?></td>
                                                    <td><?php echo $row->cost; ?></td>
                                                </tr>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!--body wrapper end-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/pickers-init.js"></script>