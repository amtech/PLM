        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/prism.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/chosen.css">
        <script type="text/javascript">
        $(document).ready(function() {
            var oTable = $('#brand_wise_equipments').dataTable( {
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
                            "sPdfMessage": "Your custom message would go here."
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
                            <!--<form class="form-horizontal" action="<?php echo base_url(); ?>index.php/reports/purchase_order" method="post">
                                <div class="form-group">
                                    <label for="from" class="col-sm-2 control-label col-lg-2">Date Range</label>
                                    <div class="col-lg-2">
                                        <input type="text" name="from" id="from" value="<?php echo set_value('from',date('d/m/Y')); ?>" class="form-control form-control-inline input-medium default-date-picker" autocomplete="off" required />
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" name="to" id="to" value="<?php echo set_value('to',date('d/m/Y')); ?>" class="form-control form-control-inline input-medium default-date-picker" autocomplete="off" required />
                                    </div>
                                    <p>
                                        <button class="btn btn-primary" type="submit" id="submit">Submit</button>
                                    </p>
                                </div>
                            </form>-->
                            <div class="tab-content">
                                <div class="tab-pane active" id="purchase_order">
                                    <div class="adv-table">
                                        <?php
                                            if($this->input->post()){
                                        ?>
                                        <table  class="display table table-bordered table-striped" id="brand_wise_equipments">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Order Date</th>
                                                    <th>Name</th>
                                                    <th>Warehouse</th>
                                                    <th>Quantity</th>
                                                    <th>Recieved Status</th>
                                                    <th>Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data goes here -->
                                                <?php
                                                    if(!empty($date_wise_purchase)){
                                                        foreach($date_wise_purchase as $row){
                                                ?>
                                                <tr>
                                                    <td><?php echo $row->code; ?></td>
                                                    <td><?php echo $row->order_date; ?></td>
                                                    <td><?php echo $row->name; ?></td>
                                                    <td><?php echo $row->warehouse_name; ?></td>
                                                    <td><?php echo $row->quantity; ?></td>
                                                    <td><?php echo $row->part_recieved; ?></td>
                                                    <td><?php echo $row->cost; ?></td>
                                                </tr>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                            }else{
                                        ?>
                                        <table  class="display table table-bordered table-striped" id="brand_wise_equipments">
                                            <thead>
                                                <tr>
                                                    <th>Brand Name</th>
                                                    <th>Total Equipment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data goes here -->
                                                <?php
                                                    if(!empty($data)){
                                                        foreach($data as $row){
                                                ?>
                                                <tr>
                                                    <td><?php echo $row->brand_name; ?></td>
                                                    <td><?php echo $row->total; ?></td>
                                                </tr>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                            }
                                        ?>
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