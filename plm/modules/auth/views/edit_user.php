        <div class="page-heading">
            <h3>
                <?php echo lang('edit_user_heading');?>
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>">Home</a>
                </li>
                <li class="active"> <?php echo lang('edit_user_heading');?> </li>
            </ul>
        </div><!-- Page heading end -->
		<div id="infoMessage"><?php echo $message;?></div>
        
        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo lang('edit_user_heading');?>
                    </header>
                    <?php echo form_open_multipart(uri_string(),array('class'=>'form-horizontal'));?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="col-lg-4 col-sm-3 control-label"><?php echo lang('edit_user_fname_label', 'first_name');?> <span style="color:red;">*</span></div>
                                        <div class="col-lg-8">
                                            <?php echo form_input($first_name);?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-4 col-sm-3 control-label"><?php echo lang('edit_user_lname_label', 'last_name');?> <span style="color:red;">*</span></div>
                                        <div class="col-lg-8">
                                            <?php echo form_input($last_name);?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-4 col-sm-3 control-label"><?php echo form_label('Email','email');?> <span style="color:red;">*</span></div>
                                        <div class="col-lg-8">
                                            <?php echo form_input($email);?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2 control-label col-lg-4"><?php echo lang('edit_user_company_label', 'company');?> <span style="color:red;">*</span></div>
                                        <div class="col-lg-8">
                                            <?php echo form_input($company);?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div  class="col-lg-4 col-sm-3 control-label"><?php echo lang('edit_user_phone_label', 'phone');?> <span style="color:red;">*</span></div>
                                        <div class="col-lg-8">
                                            <?php echo form_input($phone);?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2 control-label col-lg-4"><?php echo lang('edit_user_password_label', 'password');?></div>
                                        <div class="col-lg-8">
                                            <?php echo form_input($password);?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2 control-label col-lg-4"><?php echo lang('edit_user_password_confirm_label', 'password_confirm');?></div>
                                        <div class="col-lg-8">
                                            <?php echo form_input($password_confirm);?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4">Branch</label>
                                        <div class="col-lg-8">
                                        <?php
                                            $optionBR = array(''=>'--Select--');
                                            if(!empty($branch)){
                                                foreach($branch as $rowBR){
                                                    $optionBR[$rowBR->id] = $rowBR->branch_name;
                                                }
                                            }
                                            echo form_dropdown('branch_id',$optionBR,isset($_POST['branch_id'])?$_POST['branch_id']:$user->branch_id,'class="form-control"');
                                        ?>
                                        </div>
                                    </div>
                                    <!--<div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="user_image">User Image:</label>
                                        <div class="col-lg-8">
                                            <input type="file" id="user_image" name="user_image"/>
                                        </div>
                                    </div>-->
                                    <div class="form-group">
                                    <?php if ($this->ion_auth->is_admin()): ?>
                                      <div class="col-sm-2 control-label col-lg-4"><strong><?php echo lang('edit_user_groups_heading');?></strong></div>
                                        <div class="col-lg-8">
                                            <?php foreach ($groups as $group):?>
                                                <label class="checkbox">
                                                <?php
                                                    $gID=$group['id'];
                                                    $checked = null;
                                                    $item = null;
                                                    foreach($currentGroups as $grp) {
                                                        if ($gID == $grp->id) {
                                                            $checked= ' checked="checked"';
                                                        break;
                                                        }
                                                    }
                                                ?>
                                                <input type="radio" name="groups" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
                                                <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
                                                </label>
                                            <?php endforeach?>
                                        </div>
                                    <?php endif ?>
                                    </div>
                                    <?php echo form_hidden('id', $user->id);?>
                                    <?php echo form_hidden('edit_user_image', $user->user_image);?>
                                    <?php echo form_hidden($csrf); ?>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <p>
                                <?php echo form_submit('submit', lang('edit_user_submit_btn'),"class='btn btn-primary'");?>
                            </p>
                        </div>
                    <?php echo form_close();?>
                    
                </section>
            </div>
        </div>
        <!-- page end-->
        </section>
        <!--body wrapper end-->