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
		<link href="https://api.mapbox.com/mapbox-gl-js/v2.9.2/mapbox-gl.css" rel="stylesheet">
		
		<!-- StartUp Custom CSS (do not remove)  -->
		<link href="../plugins/bootoast/bootoast.css" rel="stylesheet" type="text/css">
		<link href="../program_assets/css/style.css" rel="stylesheet" type="text/css">
		<link
			rel="stylesheet"
			href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css"
			type="text/css"
		/>
		
		<style>
			#map { height: 290px; width: 100%; }
		</style>
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
				<section class="content col-md-10 col-xs-12">
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#user" data-toggle="tab" aria-expanded="true" class="cust-label">Account Registration</a></li>
							<!--<li class=""><a href="#position" data-toggle="tab" aria-expanded="false" class="cust-label">Positions</a></li>
							<li class=""><a href="#supplier" data-toggle="tab" aria-expanded="false" class="cust-label">Suppliers</a></li>
							<li class=""><a href="#uom" data-toggle="tab" aria-expanded="false" class="cust-label">UOM</a></li>
							<li class=""><a href="#products" data-toggle="tab" aria-expanded="false" class="cust-label">Products</a></li>-->
							<li class=""><a href="#client" data-toggle="tab" aria-expanded="false" class="cust-label">Client</a></li>
							<li class=""><a href="#areaAssignment" data-toggle="tab" aria-expanded="false" class="cust-label">Area Assignment</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="user">
								<div class="row">
									<div class="col-md-8 col-xs-12">
										<div class="form-group">
											<input id="txtSearchUser" class="form-control input-sm cust-label" type="text" placeholder="Search account here...">
										</div>
									</div>
									<div class="col-md-2 col-xs-6">
										<div class="form-group">
											<button id="btnAddUser" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
												<i class="fa fa-user-plus"></i>
												&nbsp;
												New User
											</button>
										</div>
									</div>
									<div class="col-md-2 col-xs-6">
										<div class="form-group">
											<button id="btnExportUser" type="button" class="btn btn-block btn-success btn-sm cust-textbox">
												<i class="fa fa-file-excel-o"></i>
												&nbsp;
												Export to Excel
											</button>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 col-sm-12">
										<div class="table-container">
											<table id="tblUser" name="tblUser" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
												<thead>
													<tr>
														<th>Employee ID</th>
														<th>Username</th>
														<th>First Name</th>
														<th>Middle Name</th>
														<th>Last Name</th>
														<th>Mobile Number</th>
														<th>Email Address</th>
														<th>Position</th>
														<th>Status</th>
														<th>Date Registered</th>
														<th></th>
													</tr>
												</thead>
												<tbody></tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!--<div class="tab-pane" id="position">
								<div class="row">
									<div class="col-md-6 col-xs-12">
										<div class="row">
											<div class="col-md-6 col-xs-12">
												<div class="form-group">
													<input id="txtSearchPosition" class="form-control input-sm cust-label" type="text" placeholder="Search position here...">
												</div>
											</div>
											<div class="col-md-3 col-xs-6">
												<div class="form-group">
													<button id="btnAddPosition" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
														<i class="fa fa-arrow-up"></i>
														&nbsp;
														New Postion
													</button>
												</div>
											</div>
											<div class="col-md-3 col-xs-6">
												<div class="form-group">
													<button id="btnExportPosition" type="button" class="btn btn-block btn-success btn-sm cust-textbox">
														<i class="fa fa-file-excel-o"></i>
														&nbsp;
														Export to Excel
													</button>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 col-sm-12">
												<div class="table-container">
													<table id="tblPosition" name="tblPosition" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
														<thead>
															<tr>
																<th>Position Name</th>
																<th>Date Created</th>
																<th>Status</th>
																<th></th>
															</tr>
														</thead>
														<tbody></tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>-->
							<!--<div class="tab-pane" id="supplier">
								<div class="row">
									<div class="col-md-12 col-xs-12">
										<div class="row">
											<div class="col-md-8 col-xs-12">
												<div class="form-group">
													<input id="txtSearchSupplier" class="form-control input-sm cust-label" type="text" placeholder="Search brand here...">
												</div>
											</div>
											<div class="col-md-2 col-xs-6">
												<div class="form-group">
													<button id="btnAddSupplier" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
														<i class="fa fa-industry"></i>
														&nbsp;
														New Supplier
													</button>
												</div>
											</div>
											<div class="col-md-2 col-xs-6">
												<div class="form-group">
													<button id="btnExportSupplier" type="button" class="btn btn-block btn-success btn-sm cust-textbox">
														<i class="fa fa-file-excel-o"></i>
														&nbsp;
														Export to Excel
													</button>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 col-sm-12">
												<div class="table-container">
													<table id="tblSupplier" name="tblSupplier" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
														<thead>
															<tr>
																<th>Suppliers Name</th>
																<th>Address</th>
																<th>Mobile Number</th>
																<th>Landline</th>
																<th>Contact Person</th>
																<th>Email Address</th>
																<th>Date Created</th>
																<th>Status</th>
																<th></th>
															</tr>
														</thead>
														<tbody></tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>-->
							<!--<div class="tab-pane" id="uom">
								<div class="row">
									<div class="col-md-6 col-xs-12">
										<div class="row">
											<div class="col-md-6 col-xs-12">
												<div class="form-group">
													<input id="txtSearchUOM" class="form-control input-sm cust-label" type="text" placeholder="Search UOM here...">
												</div>
											</div>
											<div class="col-md-3 col-xs-6">
												<div class="form-group">
													<button id="btnAddUOM" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
														<i class="fa fa-balance-scale"></i>
														&nbsp;
														New UOM
													</button>
												</div>
											</div>
											<div class="col-md-3 col-xs-6">
												<div class="form-group">
													<button id="btnExportUOM" type="button" class="btn btn-block btn-success btn-sm cust-textbox">
														<i class="fa fa-file-excel-o"></i>
														&nbsp;
														Export to Excel
													</button>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 col-sm-12">
												<div class="table-container">
													<table id="tblUOM" name="tblUOM" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
														<thead>
															<tr>
																<th>UOM Name</th>
																<th>Date Created</th>
																<th>Status</th>
																<th></th>
															</tr>
														</thead>
														<tbody></tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>-->
							<!--<div class="tab-pane" id="products">
								<div class="row">
									<div class="col-md-12 col-xs-12">
										<div class="row">
											<div class="col-md-6 col-xs-12">
												<div class="form-group">
													<input id="txtSearchProduct" class="form-control input-sm cust-label" type="text" placeholder="Search products here...">
												</div>
											</div>
											<div class="col-md-2 col-xs-6">
												<div class="form-group">
													<button id="btnAddProduct" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
														<i class="fa fa-cart-arrow-down"></i>
														&nbsp;
														New Product
													</button>
												</div>
											</div>
											<div class="col-md-2 col-xs-6">
												<div class="form-group">
													<button id="btnExportProduct" type="button" class="btn btn-block btn-success btn-sm cust-textbox">
														<i class="fa fa-file-excel-o"></i>
														&nbsp;
														Export to Excel
													</button>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-10 col-sm-12">
												<div class="table-container">
													<table id="tblProduct" name="tblProduct" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
														<thead>
															<tr>
																<th>Item Code</th>
																<th>Brand</th>
																<th>Description</th>
																<th>UOM</th>
																<th>Date Created</th>
																<th>Status</th>
																<th></th>
															</tr>
														</thead>
														<tbody></tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>-->
							<div class="tab-pane" id="client">
								<div class="row">
									<div class="col-md-12 col-xs-12">
										<div class="row">
											<div class="col-md-8 col-xs-12">
												<div class="form-group">
													<input id="txtSearchClient" class="form-control input-sm cust-label" type="text" placeholder="Search client here...">
												</div>
											</div>
											<div class="col-md-2 col-xs-6">
												<div class="form-group">
													<button id="btnAddClient" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
														<i class="fa fa-users"></i>
														&nbsp;
														New Client
													</button>
												</div>
											</div>
											<div class="col-md-2 col-xs-6">
												<div class="form-group">
													<button id="btnExportClient" type="button" class="btn btn-block btn-success btn-sm cust-textbox">
														<i class="fa fa-file-excel-o"></i>
														&nbsp;
														Export to Excel
													</button>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 col-sm-12">
												<div class="table-container">
													<table id="tblClient" name="tblClient" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
														<thead>
															<tr>
																<th>Clients Name</th>
																<th>Address</th>
																<th>Mobile Number</th>
																<th>Landline</th>
																<th>Contact Person</th>
																<th>Email Address</th>
																<th>Date Created</th>
																<th>Status</th>
																<th></th>
															</tr>
														</thead>
														<tbody></tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="areaAssignment">
								<div class="row">
									<div class="col-md-10 col-xs-12">
										<div class="form-group">
											<input id="txtSearchUserAssignment" class="form-control input-sm cust-label" type="text" placeholder="Search account here...">
										</div>
									</div>
									<div class="col-md-2 col-xs-6">
										<div class="form-group">
											<button id="btnExportUserAssigment" type="button" class="btn btn-block btn-success btn-sm cust-textbox">
												<i class="fa fa-file-excel-o"></i>
												&nbsp;
												Export to Excel
											</button>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 col-sm-12">
										<div class="table-container">
											<table id="tblUserAssignment" name="tblUserAssignment" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
												<thead>
													<tr>
														<th>Employee ID</th>
														<th>Username</th>
														<th>First Name</th>
														<th>Middle Name</th>
														<th>Last Name</th>
														<th>Mobile Number</th>
														<th>Email Address</th>
														<th>Position</th>
														<th>Status</th>
														<th>Date Registered</th>
														<th></th>
													</tr>
												</thead>
												<tbody></tbody>
											</table>
										</div>
									</div>
								</div>
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
		<div class="modal fade" id="mdAddUser" name="mdAddUser">
			<div class="modal-dialog modal-md">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Account Registration Form</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="callout">
									<p class="cust-label">
										<i class="fa fa-lightbulb-o"></i>
										&nbsp;&nbsp;
										For newly created accounts password will be the same as username
									</p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<span class="pull-right-container">
									<small class="label pull-right bg-green">Basic Information</small>
								</span>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Employee ID</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtEmployeeID" name="txtEmployeeID" placeholder="Enter Employee ID" oninput="this.value = this.value.toUpperCase()">
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Position</label>
									<label class="cust-label text-danger">*</label>
									<select id="cmbPosition" name="cmbPosition" class="form-control select2 cust-label cust-textbox" style="width: 100%;">
										
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label class="cust-label">First Name</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtFirstName" name="txtFirstName" placeholder="Enter First Name">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Middle Name</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtMiddleName" name="txtMiddleName" placeholder="Enter Middle Name">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Last Name</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtLastName" name="txtLastName" placeholder="Enter Last Name">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Email Address</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtEmailAdress" name="txtEmailAdress" placeholder="Enter Email Address">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Username</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtUsername" name="txtUsername" placeholder="Enter Username">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Mobile Number</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtMobileNumber" name="txtMobileNumber" placeholder="Enter Mobile Number" maxlength="11" onkeyup="numOnly(this)">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Assign to Client</label>
									<label class="cust-label text-danger">*</label>
									<select id="cmbAssgnToClient" name="cmbAssgnToClient" class="form-control select2 cust-label cust-textbox" style="width: 100%;">
										<option value="1">Assigned</option>
										<option value="0">Unassigned</option>
									</select>
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Birthday</label>
									<input type="date" class="form-control cust-label cust-textbox" id="txtBirthday" name="txtBirthday" placeholder="Enter Birthday" style="height: 29px !important;" onchange="submitBday()">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Gender</label>
									<label class="cust-label text-danger">*</label>
									<select id="cmbGender" name="cmbGender" class="form-control select2 cust-label cust-textbox" style="width: 100%;">
										<option value="Male">Male</option>
										<option value="Female">Female</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<span class="pull-right-container">
									<small class="label pull-right bg-green">Work Information</small>
								</span>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-3 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Date of Joining</label>
									<label class="cust-label text-danger">*</label>
									<input type="date" class="form-control cust-label cust-textbox" id="txtJoinDate" name="txtJoinDate" placeholder="Enter Date of Join" style="height: 29px !important;" onchange="submitBday()">
								</div>
							</div>
							<div class="col-md-3 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Source of Hire</label>
									<select id="cmbSourceOfHire" name="cmbSourceOfHire" class="form-control select2 cust-label cust-textbox" style="width: 100%;">
										<option value="" selected disabled>Select source of hire</option>
										<option value="Direct">Direct</option>
										<option value="Referral">Referral</option>
										<option value="Web">Web</option>
										<option value="Advertisement">Advertisement</option>
									</select>
								</div>
							</div>
							<div class="col-md-3 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Total Years</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtWorkYear" name="txtWorkYear" placeholder="Enter Total Years" onkeyup="numOnly(this)">
								</div>
							</div>
							<div class="col-md-3 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Total Months</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtWorkMonth" name="txtWorkMonth" placeholder="Enter Total Months" onkeyup="numOnly(this)">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Employment Type</label>
									<label class="cust-label text-danger">*</label>
									<select id="cmbEmpType" name="cmbEmpType" class="form-control select2 cust-label cust-textbox" style="width: 100%;">
										<option value="" selected disabled>Select Employment Type</option>
										<option value="Regular">Regular</option>
										<option value="Contractual">Contractual</option>
										<option value="Project Based">Project Based</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<span class="pull-right-container">
									<small class="label pull-right bg-green">Emergency Contact</small>
								</span>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Emergency Contact Name</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtContactName" name="txtContactName" placeholder="Enter Contact Name">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Relationship</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtRelationship" name="txtRelationship" placeholder="Enter Relationship">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Mobile (CP)</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtRelationMobileNumber" name="txtRelationMobileNumber" placeholder="Enter Mobile Number" onkeyup="numOnly(this)">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<span class="pull-right-container">
									<small class="label pull-right bg-green">Tax Information</small>
								</span>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-3 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Tax ID Number (TIN)</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtTIN" name="txtTIN" placeholder="Enter Tax ID Number (TIN)">
								</div>
							</div>
							<div class="col-md-3 col-sm-12">
								<div class="form-group">
									<label class="cust-label">SSS ID</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtSSID" name="txtSSID" placeholder="Enter SSS ID">
								</div>
							</div>
							<div class="col-md-3 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Philhealth ID</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtPID" name="txtPID" placeholder="Enter Philhealth ID">
								</div>
							</div>
							<div class="col-md-3 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Pag-IBIG ID</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtPagIbigID" name="txtPagIbigID" placeholder="Enter Pag-IBIG ID">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 col-sm-12">
								<label style="display: inline-block">
									<input id="chkActive" style="vertical-align: middle; margin-top: -4px;" type="checkbox"/>
									<label for="chkActive" style="vertical-align: middle" class="cust-label">&nbsp;&nbsp;Set as Active</label>
								</label>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-md-4 col-xs-6">
								<button id="btnClientAssignment" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
									<i class="fa fa-users"></i>
									&nbsp;
									Assign Client
								</button>
							</div>
							<div class="col-md-4 col-xs-6">
								<button id="btnReset" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
									<i class="fa fa-refresh"></i>
									&nbsp;
									Reset Password
								</button>
							</div>
							<div class="col-md-4 col-xs-6">
								<button id="btnSaveUser" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
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
		
		<!-- Modal Name  -->
		<div class="modal fade" id="mdAreaAssignment" name="mdAreaAssignment">
			<div class="modal-dialog modal-md">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Area Assignment Form</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-5 col-xs-12">
								<select id="cmbClientAssignment" name="cmbClientAssignment" class="form-control select2 cust-label cust-textbox" style="width: 100%;">
									<option value="" selected disabled>Please select a client</option>
									<?php
										include dirname(__FILE__,2) . '/program_assets/php/dropdown/clients.php';
									?>
								</select>
							</div>
							<div class="col-md-5 col-xs-12">
								<select id="cmbAreaAssignment" name="cmbAreaAssignment" class="form-control select2 cust-label cust-textbox" style="width: 100%;">
									<option value="" selected disabled>Please select an area</option>
									
								</select>
							</div>
							<div class="col-md-2 col-xs-12">
								<button id="btnAddAreaAssignment" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
									<i class="fa fa-plus"></i>
									&nbsp;
									Add
								</button>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="table-container">
									<table id="tblClientAreaAssignment" name="tblClientAreaAssignment" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
										<thead>
											<tr>
												<th>Clients Name</th>
												<th>Area Name</th>
												<th>Address</th>
												<th></th>
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
		<!--<div class="modal fade" id="mdPosition" name="mdPosition">
			<div class="modal-dialog modal-sm">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Positions Form</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Position Name</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtPositionName" name="txtPositionName" placeholder="Enter Position Name">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<label style="display: inline-block">
									<input id="chkPositionActive" style="vertical-align: middle; margin-top: -4px;" type="checkbox"/>
									<label for="chkPositionActive" style="vertical-align: middle" class="cust-label">&nbsp;&nbsp;Set as Active</label>
								</label>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-md-12">
								<button id="btnSavePosition" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
									<i class="fa fa-save"></i>
									&nbsp;
									Save Changes
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>-->
	
		
		<!-- Modal Name  -->
		<!--<div class="modal fade" id="mdSupplier" name="mdSupplier">
			<div class="modal-dialog modal-md">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Suppliers Form</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Suppliers Name</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtSuppliersName" name="txtSuppliersName" placeholder="Enter Suppliers Name">
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Contact Person</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtContactPerson" name="txtContactPerson" placeholder="Enter Contact Person's Name">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Address</label>
									<label class="cust-label text-danger">*</label>
									<textarea id="txtSupplierAddress" class="form-control cust-label cust-textbox" style="overflow:auto;resize:none" rows="3" cols="20" placeholder="Enter brands address"></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Mobile Number</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtContactNumber" name="txtContactNumber" placeholder="Enter Contact Number (09XXXXXXXXX)" maxlength="11" onkeyup="numOnly(this)">
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Landline</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtLandLine" name="txtLandLine" placeholder="Enter Landline Number (XXXXXXXXXX)" maxlength="10" onkeyup="numOnly(this)">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Email Address</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtEmailAddress" name="txtEmailAddress" placeholder="Enter Email Address">
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
								<label style="display: inline-block; margin-top: 29px;">
									<input id="chkSupplierActive" style="vertical-align: middle; margin-top: -4px;" type="checkbox"/>
									<label for="chkSupplierActive" style="vertical-align: middle" class="cust-label">&nbsp;&nbsp;Set as Active</label>
								</label>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-md-4 col-xs-6 pull-right">
								<button id="btnSaveSupplier" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
									<i class="fa fa-save"></i>
									&nbsp;
									Save Changes
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>-->
	
		<!-- Modal Name  -->
		<!--<div class="modal fade" id="mdUOM" name="mdUOM">
			<div class="modal-dialog modal-sm">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">UOM Form</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label class="cust-label">UOM Name</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtUOMName" name="txtUOMName" placeholder="Enter UOM Name">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<label style="display: inline-block">
									<input id="chkUOMActive" style="vertical-align: middle; margin-top: -4px;" type="checkbox"/>
									<label for="chkUOMActive" style="vertical-align: middle" class="cust-label">&nbsp;&nbsp;Set as Active</label>
								</label>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-md-12">
								<button id="btnSaveUOM" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
									<i class="fa fa-save"></i>
									&nbsp;
									Save Changes
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
-->
		<!-- Modal Name  -->
		<!--<div class="modal fade" id="mdProduct" name="mdProduct">
			<div class="modal-dialog modal-md">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Products Form</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Product Code</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtItemCode" name="txtItemCode" placeholder="Enter Product Code" oninput="this.value = this.value.toUpperCase()">
								</div>
							</div>
							<div class="col-md-8 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Brand</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtItemName" name="txtItemName" placeholder="Enter Brand Name">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Product Description</label>
									<textarea id="txtProductDescription" class="form-control cust-label cust-textbox" style="overflow:auto;resize:none" rows="3" cols="20" placeholder="Enter Product Description"></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 col-xs-12">
								<div class="form-group">
									<label class="cust-label">UOM</label>
									<label class="cust-label text-danger">*</label>
									<select id="cmbProductUOM" name="cmbProductUOM" class="form-control select2 cust-label cust-textbox" style="width: 100%;">
										
									</select>
								</div>
							</div>
							<div class="col-md-8 col-sm-12">
								<label style="display: inline-block; margin-top: 29px;">
									<input id="chkProductActive" style="vertical-align: middle; margin-top: -4px;" type="checkbox"/>
									<label for="chkProductActive" style="vertical-align: middle" class="cust-label">&nbsp;&nbsp;Set as Active</label>
								</label>
							</div>
						</div>
						<div id="dvSupplier">
							<div class="row">
								<div class="col-md-12">
									<div class="callout">
										<p class="cust-label">
											<i class="fa fa-truck"></i>
											&nbsp;&nbsp;
											List of Supplier
										</p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<input id="txtSearchItemSupplier" class="form-control input-sm cust-label" type="text" placeholder="Search brand here...">
									</div>
								</div>
								<div class="col-md-3 col-xs-6">
									<div class="form-group">
										<button id="btnAddItemSupplier" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
											<i class="fa fa-industry"></i>
											&nbsp;
											New Supplier
										</button>
									</div>
								</div>
								<div class="col-md-3 col-xs-6">
									<div class="form-group">
										<button id="btnExportItemSupplier" type="button" class="btn btn-block btn-success btn-sm cust-textbox">
											<i class="fa fa-file-excel-o"></i>
											&nbsp;
											Export to Excel
										</button>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="table-container">
										<table id="tblItemSupplier" name="tblItemSupplier" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
											<thead>
												<tr>
													<th>Brand</th>
													<th>Price</th>
													<th></th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-md-4 col-xs-6 pull-right">
								<button id="btnSaveProduct" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
									<i class="fa fa-save"></i>
									&nbsp;
									Save Changes
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>-->
		
		<!-- Modal Name  -->
		<!--<div class="modal fade" id="mdItemSupplier" name="mdItemSupplier">
			<div class="modal-dialog modal-sm">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Suppliers Form</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<label class="cust-label">Suppliers Name</label>
								<label class="cust-label text-danger">*</label>
								<select id="cmbItemSupplier" name="cmbItemSupplier" class="form-control select2 cust-label cust-textbox" style="width: 100%;">
							
								</select>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Price</label>
									<label class="cust-label text-danger">*</label>
									<input type="number" class="form-control cust-label cust-textbox" id="txtSupplierPrice" name="txtSupplierPrice" placeholder="Enter Suppliers Price">
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-md-12">
								<button id="btnSaveItemSupplier" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
									<i class="fa fa-save"></i>
									&nbsp;
									Save Supplier and Pricing
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>-->
		
		
		<!-- Modal Name  -->
		<div class="modal fade" id="mdClient" name="mdClient">
			<div class="modal-dialog modal-md">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Clients Form</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Clients Name</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtClientsName" name="txtClientsName" placeholder="Enter Clients Name">
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Contact Person</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtClientsContactPerson" name="txtClientsContactPerson" placeholder="Enter Contact Person's Name">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Address</label>
									<label class="cust-label text-danger">*</label>
									<textarea id="txtClientsAddress" class="form-control cust-label cust-textbox" style="overflow:auto;resize:none" rows="3" cols="20" placeholder="Enter suppliers address"></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Mobile Number</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtClientsContactNumber" name="txtClientsContactNumber" placeholder="Enter Contact Number (09XXXXXXXXX)" maxlength="11" onkeyup="numOnly(this)">
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Landline</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtClientsLandLine" name="txtClientsLandLine" placeholder="Enter Landline Number (XXXXXXXXXX)" maxlength="10" onkeyup="numOnly(this)">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Email Address</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtClientsEmailAddress" name="txtClientsEmailAddress" placeholder="Enter Email Address">
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
								<label style="display: inline-block; margin-top: 29px;">
									<input id="chkClientsActive" style="vertical-align: middle; margin-top: -4px;" type="checkbox"/>
									<label for="chkClientsActive" style="vertical-align: middle" class="cust-label">&nbsp;&nbsp;Set as Active</label>
								</label>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-md-4 col-xs-6">
							</div>
							<div class="col-md-4 col-xs-6">
								<button id="btnBranchAssignment" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
									<i class="fa fa-map"></i>
									&nbsp;
									Area Assignment
								</button>
							</div>
							<div class="col-md-4 col-xs-6">
								<button id="btnSaveClients" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
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
		
		<!-- Modal Name  -->
		<div class="modal fade" id="mdBranch" name="mdBranch">
			<div class="modal-dialog modal-custom">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Area Assigment</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-6">
								<div class="box box-default color-palette-box">
									<div class="box-header with-border">
										<label class="cust-label"><i class="fa fa-building"></i>&nbsp; Area Details</label>
									</div>
									<div class="box-body">
										<div class="row">
											<div class="col-md-12 col-xs-12">
												<div class="form-group">
													<label class="cust-label">Area Name</label>
													<label class="cust-label text-danger">*</label>
													<input type="text" class="form-control cust-label cust-textbox" id="txtBranchName" name="txtBranchName" placeholder="Enter Branch Name" autocomplete="off">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 col-xs-12">
												<div class="form-group">
													<label class="cust-label">Address</label>
													<label class="cust-label text-danger">*</label>
													<textarea id="txtBranchAddress" class="form-control cust-label cust-textbox" style="overflow:auto;resize:none" rows="3" cols="20" placeholder="Typee in your branch address and hit enter to search...."></textarea>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 col-xs-12">
												<div class="form-group">
													<label class="cust-label">Coordinates</label>
													<label class="cust-label text-danger">*</label>
													<span class="cust-label">(Click anywhere in the map to add coordinates)</span>
													<input type="text" class="form-control cust-label cust-textbox" id="txtCoordinates" name="txtCoordinates" placeholder="0,0" autocomplete="off" disabled>
												</div>
											</div>
										</div>
									</div>
									<div class="box-footer">
										<div class="row">
											<div class="col-md-6 pull-right">
												<button id="btnSaveMap" type="button" class="btn btn-block btn-default btn-xs cust-textbox">
													<i class="fa fa-save"></i>
													&nbsp;
													Save Changes
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="box box-default color-palette-box">
									<div class="box-header with-border">
										<label class="cust-label"><i class="fa fa-map"></i>&nbsp; Map Indicator</label>
									</div>
									<div class="box-body">
										<div id="map"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="box box-default color-palette-box">
									<div class="box-header with-border">
										<label class="cust-label"><i class="fa fa-list"></i>&nbsp; List of Area Projects</label>
									</div>
									<div class="box-body">
										<div class="row">
											<div class="col-md-12 col-sm-12">
												<div class="table-container">
													<table id="tblBranchList" name="tblBranchList" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
														<thead>
															<tr>
																<th>Area Name</th>
																<th>Address</th>
																<th>Coordinates</th>
																<th>Date Created</th>
																<th></th>
															</tr>
														</thead>
														<tbody></tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
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
		<div class="modal fade" id="mdClientPOC" name="mdClientPOC">
			<div class="modal-dialog modal-md">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Client Assignment</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-8 col-sm-12">
								<select id="cmbClients" name="cmbClients" class="form-control select2 cust-label cust-textbox" style="width: 100%;">
									<option value="" selected disabled>Please select a client</option>
									<?php
										include dirname(__FILE__,2) . '/program_assets/php/dropdown/clients.php';
									?>
								</select>
							</div>
							<div class="col-md-4">
								<button id="btnAddClientPIC" type="button" class="btn btn-block btn-default btn-xs cust-textbox">
									<i class="fa fa-plus"></i>
									&nbsp;
									Add Client
								</button>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="table-container">
									<table id="tblClientAssignment" name="tblClientAssignment" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
										<thead>
											<tr>
												<th>Client Name</th>
												<th>Address</th>
												<th></th>
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


		<!-- NO INTERNET MODAL -->
		<div class="modal fade" id="modal-default" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-sm">
				<div class="box box-danger">
					<div class="box-body">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<label>System Message</label>
								<br>
									<center>
										<img class="img-res" src="../dist/img/404-error.png" alt="No Internet Connection">
									</center>
								<br>
								<p class="cust-label">There is no Internet connection. Kindly use the local program to continue your transaction and sync later.</p>
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
		<script src="https://api.mapbox.com/mapbox-gl-js/v2.9.2/mapbox-gl.js"></script>
		<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js"></script>
		
		<!-- StartUp Custom JS (do not remove)  -->
		<script src="../program_assets/js/site_essentials/sidebar.js?random=<?php echo uniqid(); ?>"></script>
		<script src="../program_assets/js/site_essentials/others.js?random=<?php echo uniqid(); ?>"></script>
		<script src="../program_assets/js/web_functions/masterfile.js?random=<?php echo uniqid(); ?>"></script>
		
	</body>
</html>