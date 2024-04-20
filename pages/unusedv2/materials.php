<?php
	if(!isset($_SESSION)) { session_start(); } 
	if (!isset($_SESSION['id'])) {
		header( "Location: login" );
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title></title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.7 -->
		<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
		<!-- DataTables -->
  		<link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  		<link rel="stylesheet" href="../bower_components/datatables.select/select.dataTables.min.css">
		<!-- Select2 -->
  		<link rel="stylesheet" href="../bower_components/select2/dist/css/select2.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
		<!-- AdminLTE Skins. Choose a skin from the css/skins
		folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!--link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"-->
		<link rel="stylesheet" href="../fonts/fonts.css">
		<!-- Custom Confirm -->
		<link rel="stylesheet" href="../bower_components/custom-confirm/jquery-confirm.min.css">
		
		<!-- StartUp Custom CSS (do not remove)  -->
		<link href="../plugins/bootoast/bootoast.css" rel="stylesheet" type="text/css">
		<link href="../program_assets/css/style.css" rel="stylesheet" type="text/css">
		
	</head>
	
	<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
	<!-- the fixed layout is not compatible with sidebar-mini -->
	<body class="hold-transition skin-black-light fixed sidebar-mini">
		<!-- Site wrapper -->
		<div class="wrapper">
			<header class="main-header">
				<!-- Logo -->
				<a href="#" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini"></span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg"></span>
				</a>
				<!-- Header Navbar: style can be found in header.less -->
				<nav class="navbar navbar-static-top">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<!--<li class="dropdown notifications-menu">
	    						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-bell-o"></i>
									<span id="sp-notif-counter" name= "sp-notif-counter" class="label label-warning"></span>
					            </a>
					            <ul class="dropdown-menu">
					            	<li id="li-noti" name="li-noti" class="header">You have 0 notification(s)</li>
					            	<li>
					            		<ul class="menu">
					            		</ul>
					            	</li>
					            	<li class="footer"><a href="javascript:void(0);" id="read_all" name="read_all">Mark all as read</a></li>
					            </ul>
	    					</li>-->
							
							<!-- User Account: style can be found in dropdown.less -->
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="./../profile/<?php  echo $_SESSION['id'] ?>.png?random=<?php echo rand(10,100);?>" class="user-image" alt="User Image" onerror="this.onerror=null; this.src='./../profile/Default.png'">
									<span class="hidden-xs">
										<?php
											$to_display = "name";
											require dirname(__FILE__,2) . '/program_assets/php/naming/naming.php';
										?>
									</span>
								</a>
								<ul class="dropdown-menu">
									<!-- User image -->
									<li class="user-header">
										<img src="./../profile/<?php  echo $_SESSION['id'] ?>.png?random=<?php echo rand(10,100);?>" class="img-circle" alt="User Image" onerror="this.onerror=null; this.src='./../profile/Default.png'">
										<p>
											<?php
												$to_display = "name";
												require dirname(__FILE__,2) . '/program_assets/php/naming/naming.php';
											?>
											&nbsp;-&nbsp;
											<?php
												$to_display = "branch";
												require dirname(__FILE__,2) . '/program_assets/php/naming/naming.php';
											?>

											<small>
												Member since : 
												<?php
													$to_display = "date_created";
													require dirname(__FILE__,2) . '/program_assets/php/naming/naming.php';
												?>
											</small>
										</p>
									</li>
									<!-- Menu Footer-->
									<li class="user-footer">
										<div class="pull-left">
											<a href="profile" class="btn btn-default btn-flat">Profile</a>
										</div>
										<div class="pull-right">
											<a href="logout" class="btn btn-default btn-flat">Sign out</a>
										</div>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</nav>
			</header>
			<!-- =============================================== -->
			<!-- Left side column. contains the sidebar -->
			<aside class="main-sidebar">
				<!-- sidebar: style can be found in sidebar.less -->
				<section class="sidebar">
					<!-- Sidebar user panel -->
					<div class="user-panel">
						<div class="pull-left image">
							<img src="./../profile/<?php  echo $_SESSION['id'] ?>.png?random=<?php echo rand(10,100);?>" class="img-circle" alt="User Image" onerror="this.onerror=null; this.src='./../profile/Default.png'" style="height:auto; max-height:45px;">
						</div>
						<div class="pull-left info">
							<p>
								<?php
									$to_display = "name";
									require dirname(__FILE__,2) . '/program_assets/php/naming/naming.php';
								?>
							</p>
							<a href="#"><i id="c_status" name="c_status" class="fa fa-circle text-success"></i> Online</a>
						</div>
					</div>
					<!-- search form -->
					<div class="sidebar-form">
						<div class="input-group">
							<input type="text" name="q" class="form-control" placeholder="Search...">
							<span class="input-group-btn">
								<button type="submit" name="search" id="search-btn" class="btn btn-flat">
									<i class="fa fa-search"></i>
								</button>
							</span>
						</div>
					</div>
					<!-- /.search form -->
					<!-- sidebar menu: : style can be found in sidebar.less -->
					<ul class="sidebar-menu" data-widget="tree">
						<li class="header">MAIN NAVIGATION</li>
						<?php
							include dirname(__FILE__,2) . '/program_assets/php/sidebar/sidebar.php';
						?>
					</ul>
				</section>
				<!-- /.sidebar -->
			</aside>
			<!-- =============================================== -->
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						@side_header
						<small>@side_desc</small>
					</h1>
					<ol class="breadcrumb page-order"></ol>
				</section>
				<!-- Main content -->
				<section class="content col-md-12 col-xs-12">
					<div class="box box-default">
						<div class="box-header with-border">
							<p class="box-title">List of Stocks per Projects</p>
						</div>
						<!--<div class="box-body">
							<div class="row">
								<div class="col-md-1 col-xs-12">
									<div class="form-group">
										<button id="btnStartJob" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
											<i class="fa fa-hourglass-start"></i>
											&nbsp;
											Start Job
										</button>
									</div>
								</div>
								<div class="col-md-1 col-xs-12">
									<div class="form-group">
										<button id="btnCancelJob" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
											<i class="fa fa-stop"></i>
											&nbsp;
											Cancel Job
										</button>
									</div>
								</div>
								<div class="col-md-1 col-xs-12">
									<div class="form-group">
										<button id="btnCompleteJob" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
											<i class="fa fa-check "></i>
											&nbsp;
											Job Complete
										</button>
									</div>
								</div>
								<div class="col-md-1 col-xs-12">
									<div class="form-group">
										<button id="btnHoldJob" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
											<i class="fa fa-hand-paper-o"></i>
											&nbsp;
											On Hold
										</button>
									</div>
								</div>
								<div class="col-md-1 col-xs-12">
									<div class="form-group">
										<button type="button" class="btn btn-block btn-default btn-sm cust-textbox">
											<i class="fa fa-copy"></i>
											&nbsp;
											Summary
										</button>
									</div>
								</div>
							</div>
						</div>-->
						<br>
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
								<li onclick="loadProjects('');" class="active"><a data-toggle="tab" aria-expanded="true" class="cust-label">All</a></li>
								<li onclick="loadProjects('WIP');" class=""><a data-toggle="tab" aria-expanded="false" class="cust-label">WIP</a></li>
								<li onclick="loadProjects('On Hold');" class=""><a data-toggle="tab" aria-expanded="false" class="cust-label">On Hold</a></li>
								<li onclick="loadProjects('Completed');" class=""><a data-toggle="tab" aria-expanded="false" class="cust-label">Completed</a></li>
							</ul>
							<div class="tab-content">
								<div class="row">
									<div class="col-md-12 col-sm-12">
										<div class="table-container">
											<table id="tblProjects" name="tblProjects" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
												<thead>
													<tr>
														<th>Project Number</th>
														<th>Quotation Number</th>
														<th>Project Name</th>
														<th>Client</th>
														<th>Start Date</th>
														<th>End Date</th>
														<th>Status</th>
														<th>Project in Charge</th>
														<th></th>
													</tr>
												</thead>
												<tbody></tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="box-footer">
							</div>
						</div>
					</div>
				</section>
				<!-- /.content -->
			</div>
			<!-- /.content-wrapper -->
			<footer class="main-footer">
				<div class="pull-right hidden-xs">
					<!-- Version or anything -->
				</div>
				<strong class="cust-label">Program created by: <a id="footer-cname" name="footer-cname" href="#">CompanyName</a> </strong> 
				<span class="cust-label">IT Department.</span>
			</footer>
			<!-- Add the sidebar's background. This div must be placed
			immediately after the control sidebar -->
			<div class="control-sidebar-bg"></div>
		</div>
		<!-- ./wrapper -->
		
		<!-- Modal Name  -->
		<div class="modal fade" id="mdInventory" name="mdInventory">
			<div class="modal-dialog modal-xl">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Project Inventory: &nbsp;</label>
						<span class="cust-label" id="spProjectNumber">{{ value }}</span>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-8 col-xs-12">
								<div class="row">
									<div class="col-md-3 col-xs-12">
										<div class="form-group">
											<button id="btnEdit1" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
												<i class="fa fa-truck"></i>
												&nbsp;
												Edit Delivery
											</button>
										</div>
									</div>
									<div class="col-md-3 col-xs-12">
										<div class="form-group">
											<button id="btnEdit2" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
												<i class="fa fa-building"></i>
												&nbsp;
												Edit Installed
											</button>
										</div>
									</div>
									<div class="col-md-3 col-xs-12">
										<div class="form-group">
											<button id="btnEdit3" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
												<i class="fa fa-edit"></i>
												&nbsp;
												Edit Remarks
											</button>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-2 col-xs-12">
								<div class="bg-gray btn-sm" style="width: 100%;" readonly=""><i class="fa fa-industry"></i>
									<span class="cust-label"><b>Total Qty &nbsp;:&nbsp;</b></span>
									<br>
									<sp id="spTotalQty" name="spTotalQty" class="cust-label">0</sp>
								</div>
							</div>
							<div class="col-md-2 col-xs-12">
								<div class="bg-gray btn-sm" style="width: 100%;" readonly=""><i class="fa fa-building"></i>
									<span class="cust-label"><b>Total Installed &nbsp;:&nbsp;</b></span>
									<br>
									<sp id="spTotalInstalled" name="spTotalInstalled" class="cust-label">0</sp>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="table-container">
									<table id="tblInventory" name="tblInventory" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
										<thead>
											<tr>
												<th>Item Code</th>
												<th>Description</th>
												<th>UOM</th>
												<th>Quantity</th>
												<th>Delivered</th>
												<th>Descrepancies</th>
												<th>Installed On-Site</th>
												<th>Updated Stock</th>
												<th>Date Created</th>
												<th>Remarks</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer"></div>
				</div>
			<!-- /.modal-content -->
			</div>
		<!-- /.modal-dialog -->
		</div>
		
		<!-- Modal Name  -->
		<div class="modal fade" id="mdEditInventory" name="mdEditInventory">
			<div class="modal-dialog modal-md">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Inventory Form</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Delivered</label>
									<label class="cust-label text-danger">*</label>
									<input type="number" class="form-control cust-label cust-textbox" id="txtDelivered" name="txtDelivered" autocomplete="off" onkeydown="if(event.key==='.'){event.preventDefault();}">
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Installed</label>
									<label class="cust-label text-danger">*</label>
									<input type="number" class="form-control cust-label cust-textbox" id="txtInstalled" name="txtInstalled" autocomplete="off" onkeydown="if(event.key==='.'){event.preventDefault();}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Remarks</label>
									<textarea id="txtRemarks" class="form-control cust-label cust-textbox" style="overflow:auto;resize:none" rows="3" cols="20" placeholder="Enter Remarks"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-md-4 col-xs-6 pull-right">
								<button id="btnSaveChanges" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
									<i class="fa fa-save"></i>
									&nbsp;
									Save Changes
								</button>
							</div>
						</div>
					</div>
				</div>
			<!-- /.modal-content -->
			</div>
		<!-- /.modal-dialog -->
		</div>

		<!-- jQuery 3 -->
		<script src="../bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- Select2 -->
		<script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
		<!-- DataTables -->
		<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
		<script src="../bower_components/datatables.select/dataTables.select.min.js"></script>
		<script src="../bower_components/datatables.button/dataTables.buttons.min.js"></script>
		<script src="../bower_components/datatables.button/jszip.min.js"></script>
		<script src="../bower_components/datatables.button/buttons.html5.min.js"></script>
		<!-- SlimScroll -->
		<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
		<!-- FastClick -->
		<script src="../bower_components/fastclick/lib/fastclick.js"></script>
		<!-- AdminLTE App -->
		<script src="../dist/js/adminlte.min.js"></script>
		<script src="../plugins/bootoast/bootoast.js"></script>
		<!-- Custom Confirm -->
		<script src="../bower_components/custom-confirm/jquery-confirm.min.js"></script>
		
		<!-- StartUp Custom JS (do not remove)  -->
		<script src="../program_assets/js/site_essentials/sidebar.js?random=<?php echo uniqid(); ?>"></script>
		<script src="../program_assets/js/site_essentials/others.js?random=<?php echo uniqid(); ?>"></script>
		<script src="../program_assets/js/web_functions/materials.js?random=<?php echo uniqid(); ?>"></script>
		
	</body>
</html>