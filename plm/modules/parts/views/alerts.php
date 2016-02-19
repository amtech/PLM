        <script type="text/javascript">
        $(document).ready(function() {
            var oTable = $('#parts_alert').dataTable( {
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                dom: 'T<"clear">lfrtip',
                tableTools: {
                    "sSwfPath": "http://cdnjs.cloudflare.com/ajax/libs/datatables-tabletools/2.1.5/swf/copy_csv_xls_pdf.swf",
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
            <?php if($this->session->flashdata('success')) { ?>
            <div class="alert alert-success fade in">
                <button type="button" class="close close-sm" data-dismiss="alert">
                    <i class="fa fa-times"></i>
                </button>
                <?php echo $this->session->flashdata('success');?>
            </div>
            <?php 
            }
            ?>
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

        <div class="wrapper">
            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo $page_title; ?>
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
								<table  class="display table table-bordered table-striped" id="parts_alert">
									<thead>
										<tr>
											<th>Parts Code</th>
											<th>Parts Name</th>
											<th>Description</th>
											<th>Quantity</th>
											<th>Alert Qty</th>
										</tr>
									</thead>
									<tbody>
                                        <!-- Data goes here -->
                                        <?php
                                            if(!empty($alerts)){
                                                foreach($alerts as $row){
                                        ?>
                                        <tr>
                                            <td><?php echo $row->code; ?></td>
                                            <td><?php echo $row->name; ?></td>
                                            <td><?php echo $row->desc; ?></td>
                                            <td><?php echo $row->quantity; ?></td>
                                            <td><?php echo $row->alert_quantity; ?></td>
                                        </tr>
                                        <?php
                                                }
                                            }
                                        ?>
									</tbody>
									
								</table>
							</div>
                        </div>
                    </section>
                </div>
            </div>
        </div>