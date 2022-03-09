<html lang="en" class="no-js" ng-app="myApp"><!--<![endif]--><!-- BEGIN HEAD --><head>
<meta charset="utf-8">
<title><?php echo $title; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta content="" name="description">
<meta content="" name="author">
<meta name="MobileOptimized" content="320">

<?php $url1 = $this->uri->segment(1);
      $url2 = $this->uri->segment(2);
      $url3 = $this->uri->segment(3);
      $url4 = $this->uri->segment(4); ?>
   
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/datepicker.css">
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/plugins/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/plugins/jqvmap/jqvmap.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/select2/select2.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css">
<!-- END PAGE LEVEL PLUGIN STYLES -->
<!-- BEGIN THEME STYLES -->
<?php if($url1 == 'en' || $url1 == ''){ ?>
<link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet" type="text/css">
 <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css">
 <link href="<?php echo base_url(); ?>assets/css/style-responsive.css" rel="stylesheet" type="text/css">
 <link href="<?php echo base_url(); ?>assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color">
<link href="<?php echo base_url(); ?>assets/css/style-conquer.css" rel="stylesheet" type="text/css">
<?php } ?>

<?php if($url1 == 'ur'){ ?>
<link href="<?php echo base_url(); ?>assets/css/ur/custom_ur.css" rel="stylesheet" type="text/css">
 <link href="<?php echo base_url(); ?>assets/css/ur/style_ur.css" rel="stylesheet" type="text/css">
 <link href="<?php echo base_url(); ?>assets/css/ur/style-responsive_ur.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/ur/default_ur.css" rel="stylesheet" type="text/css" id="style_color">
<link href="<?php echo base_url(); ?>assets/css/ur/style-conquer_ar.css" rel="stylesheet" type="text/css">
<?php } ?>
    


<link href="<?php echo base_url(); ?>assets/css/plugins.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/pages/tasks.css" rel="stylesheet" type="text/css">

<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico">
<style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style></head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
   
<?php ($url3 == "C_sales" || $url3=="C_receivings" ? $sidebar=" page-sidebar-fixed page-sidebar-closed" : $sidebar="");
      ($url1 == "ur"? $sidebar.=" page-sidebar-reversed" : $sidebar.="");  
 ?>
<body class="page-header-fixed <?php echo $sidebar; ?>"  style="">

<!-- BEGIN HEADER -->
<div class="header navbar navbar-fixed-top">
	<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
            <a href="">
                <img src="<?php echo base_url(); ?>assets/img/logo.png" alt="logo">
            </a>
        </div>
        
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<img src="<?php echo base_url(); ?>assets/img/menu-toggler.png" alt="">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<ul class="nav navbar-nav pull-right">
			<li class="devider">
				 &nbsp;
			</li>
			<!-- BEGIN USER LOGIN DROPDOWN -->
            <?php if($_SESSION['emp_id'] > 0){ ?>
            <li class="dropdown language">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
				<img alt="" src="<?php echo base_url(); ?>assets/img/flags/us.png">
				<span class="username">EN </span>
				<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?php echo base_url(); ?>ur<?php echo substr($this->uri->uri_string(),2); ?>"  ><img alt="" src="<?php echo base_url(); ?>assets/img/flags/pak.png"> urdu</a>
					</li>
                    <li><a href="<?php echo base_url(); ?>en<?php echo substr($this->uri->uri_string(),2); ?>" ><img alt="" src="<?php echo base_url(); ?>assets/img/flags/us.png"> english</a></li>
				</ul>
			</li>
            <li class="dropdown user">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
				<img alt="" src="<?php echo base_url(); ?>assets/img/avatar3_small.jpg">
				<span class="username username-hide-on-mobile"><?php echo $_SESSION['emp_name']; ?> </span>
				<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?php echo site_url('C_employee/empDetail'); ?>"><i class="fa fa-user"></i> My Profile</a>
					</li>
                    <li class="divider">
					</li>
					<li>
						<a href="<?php echo site_url('c_login/logout') ?>"><i class="fa fa-key"></i> Log Out</a>
					</li>
				</ul>
			</li>
            
            <?php } else { ?>
            <li class="dropdown language">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
				<img alt="" src="<?php echo base_url(); ?>assets/img/flags/us.png">
				<span class="username">EN </span>
				<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?php echo base_url(); ?>ur<?php echo substr($this->uri->uri_string(),2); ?>"  ><img alt="" src="<?php echo base_url(); ?>assets/img/flags/pak.png"> urdu</a>
					</li>
                    <li><a href="<?php echo base_url(); ?>en<?php echo substr($this->uri->uri_string(),2); ?>" ><img alt="" src="<?php echo base_url(); ?>assets/img/flags/us.png"> english</a></li>
				</ul>
			</li>
			<li class="dropdown user">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
				<!--<img alt="" src="<?php echo base_url(); ?>assets/img/avatar3_small.jpg">-->
				<span class="username username-hide-on-mobile"><?php echo $_SESSION['company_name']; ?> </span>
				<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?php echo site_url('companies/c_company'); ?>"><i class="fa fa-user"></i> My Profile</a>
					</li>
                    <li>
						<a href="<?php echo site_url('accounts/C_fyear'); ?>"><i class="fa fa-tasks"></i> Fiscal Year</a>
					</li>
					<li>
						<a href="<?php echo site_url('pos/PostingTypes'); ?>"><i class="fa fa-tasks"></i> Sales Posting Types</a>
					</li>
                    <li>
						<a href="<?php echo site_url('pos/PostingTypes/purchasePostingTypes'); ?>"><i class="fa fa-tasks"></i> Purchase Posting Types</a>
					</li>
                    <li class="divider">
					</li>
                    <li>
						<a href="<?php echo site_url('reports/C_reports/yearReport'); ?>"><i class="fa fa-tasks"></i> yearReprot</a>
					</li>
					<li>
						<a href="<?php echo site_url('C_login/logout') ?>"><i class="fa fa-key"></i> Log Out</a>
					</li>
				</ul>
			</li>
            <?php } ?>
			<!-- END USER LOGIN DROPDOWN -->
		</ul>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<div class="clearfix"></div>

<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<!-- DOC: for circle icon style menu apply page-sidebar-menu-circle-icons class right after sidebar-toggler-wrapper -->
			<ul class="page-sidebar-menu">
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<div class="clearfix">
					</div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li class="sidebar-search-wrapper">
					<form class="search-form" role="form" action="" method="get">
						<div class="input-icon right">
							<i class="icon-magnifier"></i>
							<input type="text" class="form-control" name="query" placeholder="Search...">
						</div>
					</form>
				</li>
			
                
                <?php $Pmodule = $this->M_modules->get_permittedModules($_SESSION['emp_id']); //parent module 
                    foreach($Pmodule as $Pvalues):
                ?>
                <li <?php echo ($url2 == $Pvalues['name']?"class='active'":'') ?>>
                    <a href="<?php echo site_url($Pvalues['name'].'/'.$Pvalues['path']); ?>">
                    <i class="<?php echo $Pvalues['icon']; ?>"></i>
                    <span class="title"><?php echo ($url1 == 'en' ? $Pvalues['title'] : $Pvalues['title_ur']); ?></span>
                    <span class="arrow"></span>
                    </a>
                    
                    <?php $module = $this->M_modules->get_modulesByParent($Pvalues['id']); 
                        if(count($module) > 0)
                        {
                            echo '<ul class="sub-menu">';
                            foreach($module as $values):
                    ?>
                        <li <?php echo ($url3 == $values['name'] || $url4 == $values['name'] ? "class='active'":'') ?>>
							<a href="<?php echo site_url($Pvalues['name'].'/'.$values['path']); ?>">
							<?php echo ($url1 == 'en' ? $values['title'] : $values['title_ur']); ?></a>
						</li>
                    <?php 
                            endforeach;    
                            echo '</ul>';
                        }
                    ?>
                </li>
                        
               <?php  endforeach; ?>
				
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
    <div class="page-content" style="min-height:540px">
        
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Modal title</h4>
						</div>
						<div class="modal-body">
							 Widget settings form goes here
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-success">Save changes</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN STYLE CUSTOMIZER 
			<div class="theme-panel hidden-xs hidden-sm">
				<div class="toggler">
					<i class="fa fa-gear"></i>
				</div>
				<div class="theme-options">
					<div class="theme-option theme-colors clearfix">
						<span>
						Theme Color </span>
						<ul>
							<li class="color-black current color-default tooltips" data-style="default" data-original-title="Default">
							</li>
							<li class="color-grey tooltips" data-style="grey" data-original-title="Grey">
							</li>
							<li class="color-blue tooltips" data-style="blue" data-original-title="Blue">
							</li>
							<li class="color-red tooltips" data-style="red" data-original-title="Red">
							</li>
							<li class="color-light tooltips" data-style="light" data-original-title="Light">
							</li>
						</ul>
					</div>
					<div class="theme-option">
						<span>
						Layout </span>
						<select class="layout-option form-control input-small">
							<option value="fluid" selected="selected">Fluid</option>
							<option value="boxed">Boxed</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Header </span>
						<select class="header-option form-control input-small">
							<option value="fixed" selected="selected">Fixed</option>
							<option value="default">Default</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Sidebar </span>
						<select class="sidebar-option form-control input-small">
							<option value="fixed">Fixed</option>
							<option value="default" selected="selected">Default</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Sidebar Position </span>
						<select class="sidebar-pos-option form-control input-small">
							<option value="left" selected="selected">Left</option>
							<option value="right">Right</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Footer </span>
						<select class="footer-option form-control input-small">
							<option value="fixed">Fixed</option>
							<option value="default" selected="selected">Default</option>
						</select>
					</div>
				</div>
			</div>
            -->
            
			<!-- END BEGIN STYLE CUSTOMIZER -->
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			<?php echo $main ?> <small><?php echo @$main_small; ?></small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="<?php echo site_url('Dashboard'); ?>"><?php echo lang('home'); ?></a>
						<i class="fa fa-angle-<?php echo ($langs=='en'?'right':'left'); ?>"></i>
					</li>
					<li>
						<a href="#"><?php echo lang('dashboard'); ?></a>
					</li>
				</ul>
                <!--
				<div class="page-toolbar">
					<div id="dashboard-report-range" class="pull-right tooltips btn btn-fit-height btn-primary" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
						<i class="icon-calendar"></i>&nbsp; <span class="thin uppercase visible-lg-inline-block">November 20, 2016 - December 19, 2016</span>&nbsp; <i class="fa fa-angle-down"></i>
					</div>
				</div>
                -->
			</div>
			<!-- END PAGE HEADER-->