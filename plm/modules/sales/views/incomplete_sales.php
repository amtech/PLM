        <script type="text/javascript">
        $(document).ready(function() {
            var oTable = $('#sale_parts_view').dataTable( {
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url(); ?>index.php/sales/inCompleteSalesDetails',
                        "bJQueryUI": true,
                        "sPaginationType": "full_numbers",
                        "iDisplayStart ":20,
                        "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url(); ?>assets/img/ajax-loader.gif'>"
                },  
                "fnInitComplete": function() {
                        //oTable.fnAdjustColumnSizing();
                 },
                        'fnServerData': function(sSource, aoData, fnCallback)
                    {
                      $.ajax
                      ({
                        'dataType': 'json',
                        'type'    : 'POST',
                        'url'     : sSource,
                        'data'    : aoData,
                        'success' : fnCallback
                      });
                    }
            } );
        } );
        </script>
        <script>
            function goBack() {
                window.history.back();
            }
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
            <?php if($this->session->flashdata('error')) { ?>
            <div class="alert alert-block alert-danger fade in">
                <button type="button" class="close close-sm" data-dismiss="alert">
                    <i class="fa fa-times"></i>
                </button>
                <strong>Oh snap!</strong> <?php echo $this->session->flashdata('error'); ?>
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
                                <a class="custom-button" href="<?php echo base_url(); ?>index.php/sales/add_part"> Add Sale Part</a>
                            </span>
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
								<table  class="display table table-bordered table-striped" id="sale_parts_view">
									<thead>
										<tr>
											<th>Date</th>
											<th>Sales Ref No</th>
											<th>Ship Date</th>
                                            <th>Ship Via</th>
											<th>Ship To</th>
											<th>Customer</th>
                                            <th>Discount</th>
											<th>Total</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
                                        <!-- Data goes here -->
									</tbody>
									
								</table>
							</div>
                            <button class="custom-button" onClick="goBack();">Back</button>
                        </div>
                    </section>
                </div>
            </div>
        </div>