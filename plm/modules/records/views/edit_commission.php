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
                    <header class="panel-heading">
                        <?php echo $page_title; ?> Form
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>index.php/records/edit_commission/<?php echo $id; ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="date" class="col-lg-3  control-label">Date</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="date" placeholder="Comission Date" name="date" value="<?php echo set_value('date',date('d/m/Y',strtotime($commission->commission_date))); ?>" autocomplete="off" >
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="record_id" class="col-lg-3  control-label">Record</label>
                                <div class="col-lg-9">
                                <?php
                                    $optionRC = array('0'=>'--Select--');
                                    if(!empty($records)){
                                        foreach($records as $rowRC){
                                            $optionRC[$rowRC->id] = $rowRC->ro_no.' - '.$rowRC->serial_no;
                                        }
                                    }
                                    echo form_dropdown('record_id',$optionRC,isset($_POST['record_id'])?$_POST['record_id']:$commission->record_id,'class="form-control chosen-select" id="record_id"');
                                ?>
                                </div>
                            </div>
                            
							<div class="form-group">
                                <label for="technician_id" class="col-lg-3  control-label">Technician</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="technician_id" placeholder="Technician Name" name="technician_name" value="<?php echo set_value('technician_id',$commission->technician_name); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="report_no" class="col-lg-3  control-label">Report No</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="report_no" placeholder="Report No" name="report_no" value="<?php echo set_value('report_no',$commission->report_no); ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="commissioning_report" class="col-lg-3  control-label">Commissioning Report</label>
                                <div class="col-lg-9">
                                    <input type="file" name="commission_report" id="commissioning_report" accept=".jpg,.jped,.pdf" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="delivery_note" class="col-lg-3  control-label">Delivery Note</label>
                                <div class="col-lg-9">
                                    <input type="file" name="delivery_note" id="delivery_note" accept=".jpg,.jped,.pdf" />
                                </div>
                            </div>
							<input type="hidden" name="c_report" value="<?php echo $commission->commissioning_report;?>" />
							<input type="hidden" name="c_delivery" value="<?php echo $commission->delivery_note;?>" />
                            <div class="panel-body">
                                <p>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="<?php echo base_url(); ?>index.php/records/commissions" class="btn btn-default" type="button">Cancel</a>
                                </p>
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