        <script type="text/javascript">
        $(document).ready(function() {
            var oTable = $('#stock_vendor').dataTable( {
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
            } );
        } );
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
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#purchase_order" data-toggle="tab"><?php echo $page_title; ?></a>
                                </li>
                            </ul>
                        </header>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="purchase_order">
                                    <form class="form-horizontal" action="<?php echo base_url(); ?>index.php/reports/stock_vendor" method="post">
                                        <div class="form-group">
                                            <label for="vendor" class="col-sm-2 control-label col-lg-2">Vendor</label>
                                            <div class="col-lg-4">
                                                <?php
                                                    $option = array('0'=>'--Select--');
                                                    if(!empty($vendor)){
                                                        foreach($vendor as $row1){
                                                            $option[$row1->id] = $row1->contact_person;
                                                        }
                                                    }
                                                    echo form_dropdown('vendor',$option,isset($_POST['vendor'])?$_POST['vendor']:'','class="form-control" id="vendor"');
                                                ?>
                                            </div>
                                            <p>
                                                <button class="btn btn-primary" type="submit" id="submit">Submit</button>
                                            </p>
                                        </div>
                                    </form>
                                    <div class="adv-table">
                                        <table  class="display table table-bordered table-striped" id="stock_vendor">
                                            <thead>
                                                <tr>
                                                    <th>Vendor</th>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                    <th>Warehouse</th>
                                                    <th>Quantity</th>
                                                    <th>Order Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data goes here -->
                                                <?php
                                                    if(!empty($inv_vendor)){
                                                        foreach($inv_vendor as $row){
                                                ?>
                                                <tr>
                                                    <td><?php echo $row->contact_person; ?></td>
                                                    <td><?php echo $row->code; ?></td>
                                                    <td><?php echo $row->name; ?></td>
                                                    <td><?php echo $row->warehouse_name; ?></td>
                                                    <td><?php echo $row->part_quantity; ?></td>
                                                    <td><?php echo $row->order_date; ?></td>
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