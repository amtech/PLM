<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
	<meta name="description" content="">
	<meta name="author" content="ThemeBucket">
    <!--<link rel="shortcut icon" href="#" type="image/png">-->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/ipxe41b08i.gif" type="image/gif" /> 
    <!-- end of iconj.com favicon code -->


	<title><?php echo $page_title;?> | <?php echo SITE_NAME; ?></title>
    <style>
      .custom-nav .menu-list .sub-sub-menu-list {
	  color: #fff;
	  font-size: 13px;
	  display: block;
	  padding: 10px 5px 10px 50px;
	  -moz-transition: all 0.2s ease-out 0s;
	  -webkit-transition: all 0.2s ease-out 0s;
	  transition: all 0.2s ease-out 0s;
	}
	.custom-nav .menu-list .sub-sub-menu-list li{
		list-style:none;
	}
    </style>
	<!--icheck-->
	<link href="<?php echo base_url(); ?>assets/js/iCheck/skins/minimal/minimal.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/js/iCheck/skins/square/square.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/js/iCheck/skins/square/red.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/js/iCheck/skins/square/blue.css" rel="stylesheet">
	<script src="<?php echo base_url(); ?>assets/js/jquery-latest.min.js" type="text/javascript"></script>
	<!--dynamic table-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/data-tables/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/data-tables/dataTables.tableTools.css">
  
	<!--common-->
	<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/custom_css.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/style-responsive.css" rel="stylesheet">


	<script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<body class="sticky-header">

<section>
    <!-- left side start-->
    <div class="left-side sticky-left-side">

        <!--logo and iconic logo start-->
        <div class="logo" style="background-color:#fff">
            <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/uploads/logo/<?php echo LOGO; ?>" width="200px" alt=""><span style="font-size:23px; font-weight:bold;padding-left:18px;padding-top:5px;"><?php //echo SITE_NAME; ?><span></a>
        </div>

        <!--<div class="logo-icon text-center">
            <a href="index.html"><img src="<?php echo base_url(); ?>assets/images/MSRC Logo.png" width="100px" alt=""></a>
        </div>-->
        <!--logo and iconic logo end-->

        <div class="left-side-inner">

            <!-- visible to small devices only -->
            <div class="visible-xs hidden-sm hidden-md hidden-lg">
                <div class="media logged-user">
                    <!--<img alt="" src="<?php echo base_url(); ?>assets/uploads/users/<?php echo USER_IMAGE; ?>" class="media-object">-->
                    <div class="media-body">
                        <h4><a href="#"><?php echo FIRST_NAME; ?></a></h4>
                    </div>
                </div>

                <!--<h5 class="left-nav-title">Account Information</h5>-->
                <ul class="nav nav-pills nav-stacked custom-nav">
                  <li><a href="<?php echo base_url(); ?>index.php/auth/logout"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
                </ul>
            </div>
            <!--sidebar nav start-->
            <ul class="nav nav-pills nav-stacked custom-nav">
                <li class="active"><a href="<?php echo base_url(); ?>index.php/home"><i class="fa fa-home"></i> Dashboard</a></li>
                <?php
                    $groups = array('admin','manager','salesman','purchaser','account');
                    if($this->ion_auth->in_group($groups)){
                ?>
                <li class="menu-list"><a href="#"><i class="fa fa-cogs"></i> <span>Settings</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/branch"> Branch</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/brand"> Brand</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/accountgroup"> Account Group</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/ledger"> Ledger</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/pdc"> PDC</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/categories"> Category</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/categories/sub_categories"> Sub Category</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/warehouses"> Warehouses</a></li>
                        <?php
                            if($this->ion_auth->in_group(array('admin','manager'))){
                        ?>
                        <li><a href="<?php echo base_url(); ?>index.php/auth/users"> Users</a></li>
                        <?php
                            }
                        ?>
                    </ul>
                </li>
                <li class="menu-list"><a href="#"><i class="fa fa-heart"></i> <span>Inventory</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/parts"> Spare Parts</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/parts/upload_csv"> Upload Parts CSV</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href="#"><i class="fa fa-star-o"></i> <span>Reference Equipments</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/products"> Equipment</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/products/upload_csv"> Upload Equipment CSV</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href="#"><i class="fa fa-star"></i> <span>Purchases</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/purchases/parts"> Spare Parts</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href="#"><i class="fa fa-shopping-cart"></i> <span>Sales Orders</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/sales/parts"> Spare Parts</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href="#"><i class="fa fa-exclamation-circle"></i> <span>Quotations</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/quotations"> Quotations</a></li>
                        <?php
                            if($this->ion_auth->in_group(array('admin','manager'))){
                        ?>
                        <li><a href="<?php echo base_url(); ?>index.php/quotations/add"> Add Quotation</a></li>
                        <?php
                            }
                        ?>
                    </ul>
                </li>
                <li class="menu-list"><a href="#"><i class="fa fa-bars"></i> <span>Records</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/records"> Records</a></li>
                        <?php
                            if($this->ion_auth->in_group(array('admin','manager'))){
                        ?>
                        <li><a href="<?php echo base_url(); ?>index.php/records/add"> Add Record</a></li>
                        <?php
                            }
                        ?>
                    </ul>
                </li>
                <li class="menu-list"><a href="#"><i class="fa fa-heart-o"></i> <span>Services</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/services"> Services</a></li>
                        <?php
                            if($this->ion_auth->in_group(array('admin','manager'))){
                        ?>
                        <li><a href="<?php echo base_url(); ?>index.php/services/add"> Add Service</a></li>
                        <?php
                            }
                        ?>
                    </ul>
                </li>
                <!--<li class="menu-list"><a href="#"><i class="fa fa-file-text-o"></i> <span>Commissioning Report</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/records/commissions"> Commissioning Report</a></li>
                        <?php
                            if($this->ion_auth->in_group(array('admin','manager'))){
                        ?>
                        <li><a href="<?php echo base_url(); ?>index.php/records/add_commission"> Add Commission</a></li>
                        <?php
                            }
                        ?>
                    </ul>
                </li>-->
                <li class="menu-list"><a href="#"><i class="fa fa-star-half-o"></i> <span>Transactions</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/reciepts"> Reciepts</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/payments"> Payments</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href="#"><i class="fa fa-user"></i> <span>Customer/Vendor</span></a>
                    <ul class="sub-menu-list">
                        <?php
                            if($this->ion_auth->in_group(array('admin','manager'))){
                        ?>
                        <li><a href="<?php echo base_url(); ?>index.php/vendor"> Vendors</a></li>
                        <?php
                            }
                        ?>
                        <li><a href="<?php echo base_url(); ?>index.php/customers"> Customers</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/customers/upload_csv"> Upload Customer CSV</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href="#"><i class="fa fa-flag-checkered"></i> <span>Reports</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/reports/equipment_brand"> Total Equipments Brand</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/reports/inventory"> Inventory</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/reports/purchase_order">Sales Order</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/reports/stock_vendor"> Purchase From Vendor</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/reports/customer_equipment"> Customer Equipment</a></li>
                    </ul>
                </li>
                <?php
                    if($this->ion_auth->in_group(array('admin','manager'))){
                ?>
                <li class="menu-list"><a href="#"><i class="fa fa-flag-o"></i> <span>System Settings</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/settings"> System Setting</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/settings/discount"> Discounts</a></li>
                    </ul>
                </li>
                <?php
                    }
                ?>
                <?php
                    }
                ?>
            </ul>
            <!--sidebar nav end-->

        </div>
    </div>
    <!-- left side end-->
    
    <!-- main content start-->
    <div class="main-content" >

        <!-- header section start-->
        <div class="header-section">

            <!--toggle button start-->
            <a class="toggle-btn"><i class="fa fa-bars"></i></a>
            <!--toggle button end-->

            <!--search start-->
            <!--<form class="searchform" action="index.html" method="post">-->
                <!--<input type="text" class="form-control" name="keyword" placeholder="Search here..." />-->
            <!--</form>-->
            <!--search end-->
            <script>
                $(document).ready(function(){
                    $('#branch').change(function(){
                        var branch = this.value;
                        $.ajax({
                            type: "post",
                            url: "<?php echo base_url(); ?>index.php/home/updateAdminBranch",
                            cache: false,               
                            data: {branch_id: branch},
                            async:false,
                            success: function(result){
                                try{
                                    location.reload(true);
                                }catch(e) {      
                                    alert('Exception while request..');
                                }        
                            },
                            error: function(){                      
                                alert('Error while request..');
                            }
                        });
                    });
                });
            </script>
            <!--notification menu start -->
            <div class="menu-right">
                <ul class="notification-menu">
                    <?php
                        if($this->ion_auth->in_group('admin')){
                    ?>
                    <li>
                        <?php
                            $branches = $this->branchname->getBranches();
                            // echo '<pre>';
                            // print_r($branches);
                            // echo '</pre>';
                        ?>
                        <select  class="form-control" name="branch" style="margin:10px 10px 10px 0px;" id="branch">
                            <?php
                                foreach($branches as $branch){
                            ?>
                            <option value="<?php echo $branch->id ?>" <?php if(DEFAULT_BRANCH == $branch->id){?> selected <?php } ?>><?php echo $branch->branch_name; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </li>
                    <?php
                        }else{
                    ?>
                    <li>
                        <?php
                            $branch_name = $this->branchname->getBranchName(DEFAULT_BRANCH);
                        ?>
                        <select  class="form-control" name="branch" style="margin:10px 10px 10px 0px;">
                            <option value="<?php echo DEFAULT_BRANCH; ?>"><?php echo $branch_name; ?></option>
                        </select>
                    </li>
                    <?php
                        }
                    ?>
                    <!--<li>
                        <a href="<?php echo base_url(); ?>index.php/records/completed" class="btn" style="margin: 10px; background:green;color:#fff"><b><?php echo REPORT_COMPLETED; ?> Record</b></a>
                    </li>-->
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/records" class="btn" style="margin: 10px;background:red;color:#fff"><b><?php echo REPORT_PENDING; ?> Record</b></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/parts/alert" class="btn btn-danger" style="margin: 10px;"><b><?php echo ALERT_NO; ?> Spare Part Alert</b></a>
                    </li>
                    <li>
                        <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <!--<img src="<?php echo base_url(); ?>assets/uploads/users/<?php echo USER_IMAGE; ?>" alt="" />-->
                            <?php echo FIRST_NAME; ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                            <!--<li><a href="<?php echo base_url(); ?>index.php/auth/edit_user/<?php echo USER_ID; ?>"><i class="fa fa-user"></i>  Profile</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i>  Settings</a></li>-->
                            <li><a href="<?php echo base_url(); ?>index.php/auth/logout"><i class="fa fa-sign-out"></i> Log Out</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!--notification menu end -->

        </div>
        <!-- header section end-->