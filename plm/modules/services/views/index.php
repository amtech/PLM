        <script type="text/javascript">
        $(document).ready(function() {
            var oTable = $('#service_view').dataTable( {
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
                            <span class="tools pull-right">
                                <a class="custom-button" href="<?php echo base_url(); ?>index.php/services/add"> Add Service</a>
                            </span>
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
								<table  class="display table table-bordered table-striped" id="service_view">
									<thead>
										<tr>
											<th>Record</th>
											<th>Service Date</th>
											<th>Warranty</th>
											<th>Working Hour</th>
											<th>Technician</th>
											<th>Report No</th>
											<th>Service Charge</th>
											<th>Parts Charge</th>
											<th>Total</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
                                        <!-- Data goes here -->
                                        <?php
                                            if(!empty($services)){
                                                foreach($services as $row){
                                        ?>
                                        <tr>
                                            <td><?php echo $row->ro_no; ?></td>
                                            <td><?php echo $row->service_date; ?></td>
                                            <td><?php echo $row->warranty; ?></td>
                                            <td><?php echo $row->working_hour; ?></td>
                                            <td><?php echo $row->technician_name; ?></td>
                                            <td><?php echo $row->service_report_no; ?></td>
                                            <td><?php echo $row->service_charge; ?></td>
                                            <td><?php echo $row->parts_total; ?></td>
                                            <td><?php echo $row->total; ?></td>
                                            <td><a href="<?php echo base_url(); ?>index.php/services/view/<?php echo $row->id; ?>"><i class='fa fa-eye'></i></a>&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/services/edit/<?php echo $row->id; ?>"><i class='fa fa-pencil-square-o'></i></a>&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/services/delete/<?php echo $row->id; ?>" onclick="return confirm('Are you sure you want to delete?');"><i class='fa fa-trash-o'></i></a></td>
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