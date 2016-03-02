        <script type="text/javascript">
        $(document).ready(function() {
            var oTable = $('#record_view').dataTable( {
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                dom: 'T<"clear">lfrtip',
				"aoColumnDefs" : [
                    {"aTargets": [6],"mRender": format_ddmmyyyy},
                ],
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
                                <a class="custom-button" href="<?php echo base_url(); ?>index.php/records/add"> Add Record</a>
                            </span>
                            <?php
                                }
                            ?>
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
								<table  class="display table table-bordered table-striped" id="record_view">
									<thead>
										<tr>
											<th>Record No</th>
											<th>Brand</th>
                                            <th>Category</th>
                                            <th>Model Name</th>
											<th>Serial No</th>
											<th>Customer</th>
                                            <th>Delivery Date</th>
											<th>Status</th>
											<th>Action</th>
											<th>Service History</th>
											<th>Parts History</th>
										</tr>
									</thead>
									<tbody>
                                        <!-- Data goes here -->
                                        <?php
                                            if(!empty($records)){
                                                foreach($records as $row){
                                        ?>
                                        <tr>
                                            <td><?php echo $row->RO_NO; ?></td>
                                            <td><?php echo $row->brand_name; ?></td>
                                            <td><?php echo $row->category_name; ?></td>
                                            <td><?php echo $row->model_name; ?></td>
                                            <td><?php echo $row->serial_no; ?></td>
                                            <td><?php echo $row->name; ?></td>
                                            <td><?php echo $row->delivery_date; ?></td>
                                            <td><?php if($row->status == 'pending'){ echo '<span style="color:red">'.($row->status).'</span>';}else{ echo '<span style="color:green">'.($row->status).'</span>'; } ?></td>
                                            <td><a href="<?php echo base_url(); ?>index.php/records/view/<?php echo $row->id; ?>"><i class='fa fa-eye'></i></a>&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/records/edit/<?php echo $row->id; ?>"><i class='fa fa-pencil-square-o'></i></a>&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/records/delete/<?php echo $row->id; ?>" onclick="return confirm('Are you sure you want to delete?');"><i class='fa fa-trash-o'></i></a></td>
                                            <td>
                                                <a href="<?php echo base_url(); ?>index.php/records/service_history/<?php echo $row->id; ?>">View</a>
                                            </td>
                                            <td>
                                                <a href="<?php echo base_url(); ?>index.php/records/parts_history/<?php echo $row->id; ?>">View</a>
                                            </td>
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