<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="ThemeBucket">
        <link rel="shortcut icon" href="#" type="<?php echo base_url(); ?>image/png">

        <title>Login | PLM System</title>

        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/style-responsive.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body style="background-color:#0000B0;">
        <div class="container">
            <?php $attributes = array('class' => 'form-signin'); ?>
            <?php echo form_open("auth/login",$attributes);?>
                <div class="form-signin-heading text-center">
                    <!--<h1 class="sign-title">Sign In</h1>-->
                    <img src="<?php echo base_url(); ?>assets/uploads/logo/PLM_System.png" width="200px" alt=""/>
                </div>
                <p style="color:#000; font-weight:bold;text-align:center;"><?php echo strtoupper('PLM System'); ?></p>
                <!--<p style="color:red; font-weight:bold;text-align:center;"><?php echo strtoupper('Rent A Car'); ?></p>-->
                <div class="login-wrap">
                    <p><?php echo lang('login_subheading');?></p>
					<div><?php echo $message;?></div>
                    <input type="text" name="identity" class="form-control" placeholder="User ID" autofocus id="identity">
                    <input type="password" name="password" class="form-control" placeholder="Password" id="pass">

                    <input class="btn btn-lg btn-login btn-block custom_login" type="submit" value="Login">
                        <!--<i class="fa fa-check"></i>
                    </button>-->

                    <!--<div class="registration">
                        Not a member yet?
                        <a class="" href="registration.html">
                            Signup
                        </a>
                    </div>-->
                    <label class="checkbox">
                        <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?> Remember me
                        <span class="pull-right">
                            <!--<a data-toggle="modal" href="#myModal"> Forgot Password?</a>-->

                        </span>
                    </label>

                </div>
            <?php echo form_close();?>
        </div>
    <!-- Placed js at the end of the document so the pages load faster -->

    <!-- Placed js at the end of the document so the pages load faster -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>      
    <script>
        $(function() {
            if (localStorage.chkbx && localStorage.chkbx != '') {
                $('#remember').attr('checked', 'checked');
                $('#identity').val(localStorage.usrname);
                $('#pass').val(localStorage.pass);
            } else {
                $('#remember').removeAttr('checked');
                $('#username').val('');
                $('#pass').val('');
            }

            $('#remember').click(function() {
                
                if ($('#remember').is(':checked')) {
                    // save username and password
                    localStorage.usrname = $('#identity').val();
                    localStorage.pass = $('#pass').val();
                    localStorage.chkbx = $('#remember').val();
                } else {
                    localStorage.usrname = '';
                    localStorage.pass = '';
                    localStorage.chkbx = '';
                }
            });
        });
    </script>
    </body>
</html>