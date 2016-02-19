        <script type="text/javascript">
        $(document).ready(function() {
            var oTable = $('#parts_view').dataTable( {
                "dom": 'T<"clear">lfrtip',
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
                            <?php
                                if($this->ion_auth->in_group(array('admin','manager'))){
                            ?>
                            <span class="tools pull-right">
                                <a class="custom-button" href="<?php echo base_url(); ?>index.php/parts/add"> Add Spare Part </a>
                            </span>
                            <?php
                                }
                            ?>
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
								<table  class="display table table-bordered table-striped" id="parts_view">
									<thead>
										<tr>
											<th>Parts Code</th>
											<th>Parts Description</th>
											<th>Manufacture Information</th>
											<th>Alert Qty</th>
											<th>On Hand Qty</th>
											<th>PO Qty</th>
											<th>SO Qty</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
                                        <!-- Data goes here -->
                                        <?php
                                            if(!empty($parts)){
                                                foreach($parts as $row){
                                        ?>
                                        <tr>
                                            <td><?php echo $row->code; ?></td>
                                            <td><?php echo $row->name; ?></td>
                                            <td><?php echo $row->desc; ?></td>
                                            <td><?php echo $row->alert_quantity; ?></td>
                                            <td><?php echo $this->parts_model->getOnHandQTY($row->id); ?></td>
                                            <td><?php echo $this->parts_model->getPurchaseOrderQTY($row->id); ?></td>
                                            <td><?php echo $this->parts_model->getSalesOrderQTY($row->id); ?></td>
                                            <td><a href="<?php echo base_url(); ?>index.php/parts/view/<?php echo $row->id; ?>"><i class='fa fa-eye'></i></a>&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/parts/edit/<?php echo $row->id; ?>"><i class='fa fa-pencil-square-o'></i></a>&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/parts/delete/<?php echo $row->id; ?>" onclick="return confirm('Are you sure you want to delete?');"><i class='fa fa-trash-o'></i></a></td>
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