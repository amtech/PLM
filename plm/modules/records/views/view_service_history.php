        <script type="text/javascript">
        $(document).ready(function() {
            var oTable = $('#service_history_view').dataTable( {
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
								<table  class="display table table-bordered table-striped" id="service_history_view">
									<thead>
										<tr>
											<th>Service Date</th>
                                            <th>Warranty</th>
                                            <th>Working Hour</th>
											<th>Technician Name</th>
											<th>Service Report No</th>
                                            <th>Job Completed</th>
											<th>Remarks Note</th>
											<th>Parts Needed</th>
											<th>Service Report</th>
										</tr>
									</thead>
									<tbody>
                                        <?php
                                            if(!empty($service_history)){
                                                foreach($service_history as $row){
                                        ?>
                                        <tr>
                                            <td><?php echo $row->service_date; ?></td>
                                            <td><?php echo $row->warranty; ?></td>
                                            <td><?php echo $row->working_hour; ?></td>
                                            <td><?php echo $row->technician_name; ?></td>
                                            <td><?php echo $row->service_report_no; ?></td>
                                            <td><?php echo $row->job_status; ?></td>
                                            <td><?php echo $row->remark_note; ?></td>
                                            <td><?php echo $row->part_needed; ?></td>
                                            <td><a href="<?php echo base_url(); ?>assets/uploads/services/<?php echo $row->service_report; ?>" download >Download<a></td>
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