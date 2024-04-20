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
									<img src="./../profile/<?php  echo $_SESSION['id'] ?>.png" class="user-image" alt="User Image" onerror="this.onerror=null; this.src='./../profile/Default.png'">
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
										<img src="./../profile/<?php  echo $_SESSION['id'] ?>.png" class="img-circle" alt="User Image" onerror="this.onerror=null; this.src='./../profile/Default.png'">
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
							<img src="./../profile/<?php  echo $_SESSION['id'] ?>.png" class="img-circle" alt="User Image" onerror="this.onerror=null; this.src='./../profile/Default.png'" style="height:auto; max-height:45px;">
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
				<section class="content col-md-12 col-sm-12">
					<div class="box box-default">
						<div class="box-header with-border">
							<p class="box-title">List of Masterfile</p>
						</div>
						<div class="cust-div-height">
						</div>
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab_1" data-toggle="tab" class="cust-label">Admin Registration</a></li>
								<li><a href="#tab_2" data-toggle="tab" class="cust-label">Categories</a></li>
								<li><a href="#tab_3" data-toggle="tab" class="cust-label">Services</a></li>
								<li><a href="#tab_4" data-toggle="tab" class="cust-label">Employee</a></li>
								<li><a href="#tab_5" data-toggle="tab" class="cust-label">Branch</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_1">
									<div class="row">
										<div class="col-md-10">
											<input id="txtAdmin_search" name="txtAdmin_search" type="text" class="form-control cust-label cust-textbox" placeholder="Seach data here....">
										</div>
										<div class="col-md-2">
											<button id="btnAdd" name="btnAdd" type="button" class="btn btn-default btn-sm" style="width: 100%"><i class="fa fa-user"></i>
												&nbsp; Register an Account
											</button>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-12 col-sm-12">
											<div class="table-container">
												<table id="tblAdmin" name="tblAdmin" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
													<thead>
														<tr>
															<th>First Name</th>
															<th>Last Name</th>
															<th>Email</th>
															<th>Username</th>
															<th>Date Created</th>
															<th>Created By</th>
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
								<div class="tab-pane" id="tab_2">
									<div class="row">
										<div class="col-md-10">
											<input id="txtCategory_search" name="txtCategory_search" type="text" class="form-control cust-label cust-textbox" placeholder="Seach data here....">
										</div>
										<div class="col-md-2">
											<button id="btnAddCategory" name="btnAddCategory" type="button" class="btn btn-default btn-sm" style="width: 100%"><i class="fa fa-cubes"></i>
												&nbsp; Register a Category
											</button>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-12 col-sm-12">
											<div class="table-container">
												<table id="tblCategory" name="tblCategory" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
													<thead>
														<tr>
															<th>Category</th>
															<th>Description</th>
															<th>Created By</th>
															<th>Date Created</th>
															<th>Updated By</th>
															<th>Date Updated</th>
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
								<div class="tab-pane" id="tab_3">
									<div class="row">
										<div class="col-md-10">
											<input id="txtServices_search" name="txtServices_search" type="text" class="form-control cust-label cust-textbox" placeholder="Seach data here....">
										</div>
										<div class="col-md-2">
											<button id="btnAddServices" name="btnAddServices" type="button" class="btn btn-default btn-sm" style="width: 100%"><i class="fa fa-plus-square"></i>
												&nbsp; Add New
											</button>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-12 col-sm-12">
											<div class="table-container">
												<table id="tblServices" name="tblServices" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
													<thead>
														<tr>
															<th>Service</th>
															<th>Description</th>
															<th>Category</th>
															<th>Price</th>
															<th>Created By</th>
															<th>Date Created</th>
															<th>Updated By</th>
															<th>Date Updated</th>
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
								<div class="tab-pane" id="tab_4">
									<div class="row">
										<div class="col-md-10">
											<input id="txtTherapist_search" name="txtTherapist_search" type="text" class="form-control cust-label cust-textbox" placeholder="Seach data here....">
										</div>
										<div class="col-md-2">
											<button id="btnAddTherapist" name="btnAddTherapist" type="button" class="btn btn-default btn-sm" style="width: 100%"><i class="fa fa-user"></i>
												&nbsp; Register an Employee
											</button>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-12 col-sm-12">
											<div class="table-container">
												<table id="tblTherapist" name="tblTherapist" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
													<thead>
														<tr>
															<th>First Name</th>
															<th>Last Name</th>
															<th>Email</th>
															<th>Username</th>
															<th>Mobile Number</th>
															<th>Position</th>
															<th>Date Created</th>
															<th>Created By</th>
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
								<div class="tab-pane" id="tab_5">
									<div class="row">
										<div class="col-md-10">
											<input id="txtBranch_search" name="txtBranch_search" type="text" class="form-control cust-label cust-textbox" placeholder="Seach data here....">
										</div>
										<div class="col-md-2">
											<button id="btnAddBranch" name="btnAddBranch" type="button" class="btn btn-default btn-sm" style="width: 100%"><i class="fa fa-cubes"></i>
												&nbsp; Register a Branch
											</button>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-12 col-sm-12">
											<div class="table-container">
												<table id="tblBranch" name="tblBranch" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
													<thead>
														<tr>
															<th>Branch</th>
															<th>Address</th>
															<th>Created By</th>
															<th>Date Created</th>
															<th>Updated By</th>
															<th>Date Updated</th>
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
		
		<div class="modal fade" id="mdAccountForm" name="mdAccountForm">
			<div class="modal-dialog modal-custom3">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Account Form</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="bg-gray btn-sm" style="width: 100%;" readonly=""><i class="fa fa-exclamation"></i>
									&nbsp; 
									New and Reset accounts password will be same as username
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label for="txtAdmin_fname" class="cust-label">First Name</label>
									<label for="txtAdmin_fname" class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtAdmin_fname" name="txtAdmin_fname" placeholder="Enter First Name" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label for="txtAdmin_lname" class="cust-label">Last Name</label>
									<label for="txtAdmin_lname" class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtAdmin_lname" name="txtAdmin_lname" placeholder="Enter Last Name" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label for="txtAdmin_email" class="cust-label">Email Address</label>
									<label for="txtAdmin_email" class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtAdmin_email" name="txtAdmin_email" placeholder="Enter Email (sample@gmail.com)" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label for="txtAdmin_username" class="cust-label">Username</label>
									<label for="txtAdmin_username" class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtAdmin_username" name="txtAdmin_username" placeholder="Enter Username" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<div class="form-check">
										<input class="form-check-input cust-label" type="checkbox" id="chkAdmin_active" name="chkAdmin_active">
										<label class="form-check-label cust-label" for="chkAdmin_active">&nbsp; &nbsp;Active</label>
									</div> 
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-md-6">
								<button id="btnAdmin_reset" name="btnAdmin_reset" type="button" class="btn btn-default btn-sm" style="width: 100%"><i class="fa fa-refresh"></i>
									&nbsp; Reset Password
								</button>
							</div>
							<div class="col-md-6">
								<button id="btnAdmin_save" name="btnAdmin_save" type="button" class="btn btn-default btn-sm" style="width: 100%">
									<i class="fa fa-save"></i>
									&nbsp; Save Account
								</button>
							</div>
						</div>
					</div>
				</div>
			<!-- /.modal-content -->
			</div>
		<!-- /.modal-dialog -->
		</div>
		
		<div class="modal fade" id="mdCategoryForm" name="mdCategoryForm">
			<div class="modal-dialog modal-custom3">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Category Form</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label for="txtCategory_cname" class="cust-label">Category</label>
									<label for="txtCategory_cname" class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtCategory_cname" name="txtCategory_cname" placeholder="Enter Category Name" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label for="txtCategory_cdesc" class="cust-label">Remarks (Optional)</label>
									<textarea id="txtCategory_cdesc" name="txtCategory_cdesc" class="form-control cust-label cust-textbox" rows="10" placeholder="Enter some remarks regarding this category" style="resize: none;"></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<div class="form-check">
										<input class="form-check-input cust-label" type="checkbox" id="chkCategory_active" name="chkCategory_active">
										<label class="form-check-label cust-label" for="chkCategory_active">&nbsp; &nbsp;Active</label>
									</div> 
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-md-12">
								<button id="btnCategory_save" name="btnCategory_save" type="button" class="btn btn-default btn-sm" style="width: 100%"><i class="fa fa-save"></i>
									&nbsp; Save Category
								</button>
							</div>
						</div>
					</div>
				</div>
			<!-- /.modal-content -->
			</div>
		<!-- /.modal-dialog -->
		</div>
		
		<!-- Modal Services  -->
		<div class="modal fade" id="mdService" name="mdService">
			<div class="modal-dialog modal-custom3">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Services Form</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label for="txtService_name" class="cust-label">Services</label>
									<label for="txtService_name" class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtService_name" name="txtService_name" placeholder="Enter Service Name" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label for="txtService_remarks" class="cust-label">Remarks (Optional)</label>
									<textarea maxlength="200" id="txtService_remarks" name="txtService_remarks" class="form-control cust-label cust-textbox" rows="10" placeholder="Enter some remarks regarding this service" style="resize: none;"></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label for="cmbService_category" class="cust-label">Category</label>
									<label for="cmbService_category" class="cust-label text-danger">*</label>
									<select id="cmbService_category" name="cmbService_category" class="form-control cust-label cust-textbox">
										<option value="" disabled selected>Please select a category</option>
										<?php
											include dirname(__FILE__,2) . '/program_assets/php/dropdown/services.php';
										?>
									</select>
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<div class="form-group">
										<label for="txtService_price" class="cust-label">Price</label>
										<label for="txtService_price" class="cust-label text-danger">*</label>
										<input type="number" class="form-control cust-label cust-textbox" id="txtService_price" name="txtService_price" placeholder="Enter price" autocomplete="off">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<div class="form-check">
										<input class="form-check-input cust-label" type="checkbox" id="chkService_active" name="chkService_active">
										<label class="form-check-label cust-label" for="chkService_active">&nbsp; &nbsp;Active</label>
									</div> 
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-md-12">
								<button id="btnService_save" name="btnService_save" type="button" class="btn btn-default btn-sm" style="width: 100%"><i class="fa fa-save"></i>
									&nbsp; Save Service
								</button>
							</div>
						</div>
					</div>
				</div>
			<!-- /.modal-content -->
			</div>
		<!-- /.modal-dialog -->
		</div>

		<!-- Therapist Form -->
		<div class="modal fade" id="mdTherapistForm" name="mdTherapistForm">
			<div class="modal-dialog modal-md">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Employee Form</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="bg-gray btn-sm" style="width: 100%;" readonly=""><i class="fa fa-exclamation"></i>
									&nbsp; 
									New and Reset accounts password will be same as username
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label for="txtThera_fname" class="cust-label">First Name</label>
									<label for="txtThera_fname" class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtThera_fname" name="txtAdmin_fname" placeholder="Enter First Name" autocomplete="off">
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label for="txtThera_lname" class="cust-label">Last Name</label>
									<label for="txtThera_lname" class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtThera_lname" name="txtThera_lname" placeholder="Enter Last Name" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label for="txtThera_email" class="cust-label">Email Address</label>
									<label for="txtThera_email" class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtThera_email" name="txtThera_email" placeholder="Enter Email (sample@gmail.com)" autocomplete="off">
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label for="txtThera_username" class="cust-label">Username</label>
									<label for="txtThera_username" class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtThera_username" name="txtThera_username" placeholder="Enter Username" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label for="txtThera_mobile" class="cust-label">Mobile Number</label>
									<label for="txtThera_mobile" class="cust-label text-danger">*</label>
									<input type="number" class="form-control cust-label cust-textbox" id="txtThera_mobile" name="txtThera_mobile" placeholder="Enter Mobile Number" autocomplete="off" oninput="numberOnly(this.id);" maxlength = "11">
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label for="cmbThera_position" class="cust-label">Position</label>
									<label for="cmbThera_position" class="cust-label text-danger">*</label>
									<select id="cmbThera_position" name="cmbService_category" class="form-control cust-label cust-textbox">
										<option value="" disabled selected>Please select a position</option>
										<?php
											include dirname(__FILE__,2) . '/program_assets/php/dropdown/position.php';
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<div class="form-check">
										<input class="form-check-input cust-label" type="checkbox" id="chkThera_active" name="chkThera_active">
										<label class="form-check-label cust-label" for="chkThera_active">&nbsp; &nbsp;Active</label>
									</div> 
								</div>
							</div>
						</div>
					</div>
					<div id="divSchedHolder" name="divSchedHolder">
						<div class="box-header with-border">
							<label class="cust-label">Schedules</label>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-md-12">
									<div class="bg-gray btn-sm" style="width: 100%;" readonly=""><i class="fa fa-exclamation"></i>
										&nbsp; 
										Therapist wont be seen by the customer if it has no schedule and no need to click save changes when adding schedule
									</div>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="cmbThera_day" class="cust-label">Day</label>
										<label for="cmbThera_day" class="cust-label text-danger">*</label>
										<select id="cmbThera_day" name="cmbService_category" class="form-control cust-label cust-textbox">
											<option value="" disabled selected>Please select a day</option>
											<?php
												include dirname(__FILE__,2) . '/program_assets/php/dropdown/days.php';
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="txtThera_timeFrom" class="cust-label">Time From</label>
										<label for="txtThera_timeFrom" class="cust-label text-danger">*</label>
										<input type="time" class="form-control cust-label cust-textbox" id="txtThera_timeFrom" name="txtThera_timeFrom" style="height: 29px !important;">
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="txtThera_timeTo" class="cust-label">Time To</label>
										<label for="txtThera_timeTo" class="cust-label text-danger">*</label>
										<input type="time" class="form-control cust-label cust-textbox" id="txtThera_timeTo" name="txtThera_timeTo" style="height: 29px !important;">
									</div>
								</div>
								<div class="col-md-3">
									<label class="cust-label" style="visibility: hidden;">..</label>
									<button id="btnSched_add" name="btnSched_add" type="button" class="btn btn-default btn-sm" style="width: 100%">
										<i class="fa fa-calendar-plus-o"></i>
										&nbsp; Add Schedule
									</button>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="table-container">
										<table id="tblTheraSched" name="tblTheraSched" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
											<thead>
												<tr>
													<th>Day</th>
													<th>Time From</th>
													<th>Time To</th>
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
							<div class="col-md-6">
								<button id="btnThera_reset" name="btnThera_reset" type="button" class="btn btn-default btn-sm" style="width: 100%"><i class="fa fa-refresh"></i>
									&nbsp; Reset Password
								</button>
							</div>
							<div class="col-md-6">
								<button id="btnThera_save" name="btnThera_save" type="button" class="btn btn-default btn-sm" style="width: 100%">
									<i class="fa fa-save"></i>
									&nbsp; Save Account
								</button>
							</div>
						</div>
					</div>
				</div>
			<!-- /.modal-content -->
			</div>
		<!-- /.modal-dialog -->
		</div>

		<!-- Branch Form -->
		<div class="modal fade" id="mdBranchForm" name="mdBranchForm">
			<div class="modal-dialog modal-custom3">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Branch Form</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label for="txtBranchName" class="cust-label">Branch</label>
									<label for="txtBranchName" class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtBranchName" name="txtBranchName" placeholder="Enter Branch Name" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label for="txtBranchAddress" class="cust-label">Address</label>
									<label for="txtBranchAddress" class="cust-label text-danger">*</label>
									<textarea id="txtBranchAddress" name="txtBranchAddress" class="form-control cust-label cust-textbox" rows="5" placeholder="Enter some address for this branch" style="resize: none;"></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<div class="form-check">
										<input class="form-check-input cust-label" type="checkbox" id="chkBranch_active" name="chkBranch_active">
										<label class="form-check-label cust-label" for="chkBranch_active">&nbsp; &nbsp;Active</label>
									</div> 
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-md-12">
								<button id="btnBranch_save" name="btnBranch_save" type="button" class="btn btn-default btn-sm" style="width: 100%"><i class="fa fa-save"></i>
									&nbsp; Save Branch
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
		<script src="../program_assets/js/web_functions/masterfile.js?random=<?php echo uniqid(); ?>"></script>
		
	</body>
</html>