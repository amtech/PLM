        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/prism.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/chosen.css">
        <!-- page heading start-->
        <div class="page-heading">
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

        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-6">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?> Form
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post">
                            <div class="form-group">
                                <label for="date" class="col-lg-3  control-label">Date</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="date" placeholder="Comission Date" name="date" value="<?php echo set_value('date',date('d/m/Y',strtotime($commission->commission_date))); ?>" disabled>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="record_id" class="col-lg-3  control-label">Record</label>
                                <div class="col-lg-9">
                                <?php
                                    $optionRC = array('0'=>'--Select--');
                                    if(!empty($records)){
                                        foreach($records as $rowRC){
                                            $optionRC[$rowRC->id] = $rowRC->ro_no;
                                        }
                                    }
                                    echo form_dropdown('record_id',$optionRC,$commission->record_id,'class="form-control chosen-select" id="record_id" disabled');
                                ?>
                                </div>
                            </div>
                            
							<div class="form-group">
                                <label for="technician_id" class="col-lg-3  control-label">Technician</label>
                                <div class="col-lg-9">
                                    <input type="technician_name" value="technician_name" class="form-control" value="<?php echo $commission->technician_name; ?>" disabled />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="report_no" class="col-lg-3  control-label">Report No</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="report_no" placeholder="Report No" name="report_no" value="<?php echo set_value('report_no',$commission->report_no); ?>" disabled>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="commissioning_report" class="col-lg-3  control-label">Commissioning Report</label>
                                <div class="col-lg-9">
                                    <img src="<?php echo base_url(); ?>assets/uploads/commissions/<?php echo $commission->commissioning_report;?>" width="100px" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="delivery_note" class="col-lg-3  control-label">Delivery Note</label>
                                <div class="col-lg-9">
                                    <img src="<?php echo base_url(); ?>assets/uploads/delivery_notes/<?php echo $commission->delivery_note;?>" width="100px" />
                                </div>
                            </div>
                        </form>
                    </div>
                </section>

            </div>
        </div>
		<!-- page end-->
        </section>
        <!--body wrapper end-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/choosen/chosen.jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/choosen/prism.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
            var config = {
              '.chosen-select'           : {},
              '.chosen-select-deselect'  : {allow_single_deselect:true},
              '.chosen-select-no-single' : {disable_search_threshold:10},
              '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
              '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
              $(selector).chosen(config[selector]);
            }
        </script>
        <script src="<?php echo base_url(); ?>assets/js/pickers-init.js"></script>