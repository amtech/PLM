        <script type="text/javascript">
        $(document).ready(function() {
            var oTable = $('#inventory_valuation').dataTable( {
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                dom: 'T<"clear">lfrtip',
                fnFooterCallback: function(nRow, aaData, iStart, iEnd, aiDisplay){
                    /*
                     * Calculate the total market share for all browsers in this table (ie inc. outside
                     * the pagination)
                     */
                     var iTotalCost = 0;
                     var iTotalPrice = 0;
                        for ( var i=0 ; i<aaData.length ; i++ )
                        {
                            iTotalCost += aaData[i][4]*1;
                            iTotalPrice += aaData[i][5]*1;
                        }
                        /* Calculate the market share for browsers on this page */
                        var iPageCost = 0;
                        var iPagePrice = 0;
                        for ( var i=iStart ; i<iEnd ; i++ )
                        {
                            iPageCost += aaData[ aiDisplay[i] ][4]*1;
                            iPagePrice += aaData[ aiDisplay[i] ][5]*1;
                        }

                        /* Modify the footer row to match what we want */
                        var nCells = nRow.getElementsByTagName('th');
                        nCells[1].innerHTML = (parseInt(iPageCost * 100)/100).toFixed(2);
                        nCells[2].innerHTML = (parseInt(iPagePrice * 100)/100).toFixed(2);
                },
				
				
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
            var oTable = $('#inventory_by_item').dataTable( {
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
                        <header class="panel-heading custom-tab ">
                            <span>Inventory Reports</span>
                            <!--<ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#inventory_summary" data-toggle="tab">Inventory Valuation</a>
                                </li>
                                <li class="">
                                    <a href="#inventory_stock" data-toggle="tab">Inventory Stock Status by Item</a>
                                </li>
                            </ul>-->
                        </header>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="inventory_summary">
                                    <form class="form-horizontal" action="<?php echo base_url(); ?>index.php/reports/inventory" method="post">
                                        <div class="form-group">
                                            <label for="inventory" class="col-sm-2 control-label col-lg-2">Inventory</label>
                                            <div class="col-lg-4">
                                                <?php
                                                    $option = array(
                                                        '0'=>'--Select--',
                                                        '1'=>'Valuation',
                                                        '2'=>'Valuation By Item',
                                                    );
                                                    echo form_dropdown('inventory',$option,isset($_POST['inventory'])?$_POST['inventory']:'','class="form-control" id="inventory"');
                                                ?>
                                            </div>
                                            <p>
                                                <button class="btn btn-primary" type="submit" id="submit">Submit</button>
                                            </p>
                                        </div>
                                    </form>
                                    <?php
                                        // echo '<pre>';
                                        // print_r($this->input->post('inventory'));
                                        // echo '</pre>';
                                    ?>
                                    <?php
                                        if($this->input->post('inventory') == 1){
                                    ?>
                                    <div class="adv-table">
                                        <table  class="display table table-bordered table-striped" id="inventory_valuation">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                    <th>Warehouse</th>
                                                    <th>Quantity</th>
                                                    <th>Cost</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data goes here -->
                                                <?php
                                                    if(!empty($records)){
                                                        foreach($records as $row){
                                                ?>
                                                <tr>
                                                    <td><?php echo $row->code; ?></td>
                                                    <td><?php echo $row->name; ?></td>
                                                    <td><?php echo $row->warehouse_name; ?></td>
                                                    <td><?php echo $row->quantity; ?></td>
                                                    <td><?php echo $row->cost; ?></td>
                                                    <td><?php echo $row->price; ?></td>
                                                </tr>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="4" style="text-align:right;">Total:</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                    <?php
                                        if($this->input->post('inventory') == 2){
                                    ?>
                                    <div class="adv-table">
                                        <table  class="display table table-bordered table-striped" id="inventory_by_item">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                    <th>Warehouse</th>
                                                    <th>Quantity</th>
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
                                                    <td><?php echo $row->quantity; ?></td>
                                                </tr>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php
                                        }
                                    ?>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!--body wrapper end-->