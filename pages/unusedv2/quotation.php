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
							<p class="box-title">Creation Panel</p>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-md-1 col-xs-12">
									<div class="form-group">
										<button id="btnAddQuotation" type="button" class="btn btn-block btn-default btn-sm cust-textbox" <?php echo $_SESSION["positionID"] != 1 ? 'disabled' : '' ?>>
											<i class="fa fa-plus"></i>
											&nbsp;
											Add
										</button>
									</div>
								</div>
								<div class="col-md-1 col-xs-12">
									<div class="form-group">
										<button id="btnNewQuotation" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
											<i class="fa fa-file-o"></i>
											&nbsp;
											New
										</button>
									</div>
								</div>
								<div class="col-md-1 col-xs-12">
									<div class="form-group">
										<button id="btnViewEdit" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
											<i class="fa fa-edit "></i>
											&nbsp;
											View/Edit
										</button>
									</div>
								</div>
								<!--<div class="col-md-1 col-xs-12">
									<div class="form-group">
										<button type="button" class="btn btn-block btn-default btn-sm cust-textbox">
											<i class="fa fa-times "></i>
											&nbsp;
											Cancel
										</button>
									</div>
								</div>-->
								<!--<div class="col-md-1 col-xs-12">
									<div class="form-group">
										<button type="button" class="btn btn-block btn-default btn-sm cust-textbox">
											<i class="fa fa-copy "></i>
											&nbsp;
											Copy
										</button>
									</div>
								</div>-->
								<div class="col-md-1 col-xs-12">
									<div class="form-group">
										<button id="btnSubmitApproval" type="button" class="btn btn-block btn-default btn-sm cust-textbox" disabled>
											<i class="fa fa-paper-plane"></i>
											&nbsp;
											Approval
										</button>
									</div>
								</div>
								<div class="col-md-4 col-xs-12">
								</div>
								<div id="dvApprovalContainer" hidden>
									<div class="col-md-1 col-xs-12">
										<div class="form-group">
											<button id="btnApprove" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
												<i class="fa fa-thumbs-up"></i>
												&nbsp;
												Approve
											</button>
										</div>
									</div>
									<div class="col-md-1 col-xs-12">
										<div class="form-group">
											<button id="btnRevise" type="button" class="btn btn-block btn-default btn-sm cust-textbox" >
												<i class="fa fa-refresh"></i>
												&nbsp;
												Revise
											</button>
										</div>
									</div>
									<div class="col-md-1 col-xs-12">
										<div class="form-group">
											<button id="btnCancel" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
												<i class="fa fa-times"></i>
												&nbsp;
												Cancel
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
								<li onclick="loadQuotation('');" class="active"><a data-toggle="tab" aria-expanded="true" class="cust-label">All</a></li>
								<li onclick="loadQuotation('Approved');" class=""><a data-toggle="tab" aria-expanded="false" class="cust-label">Approved</a></li>
								<li onclick="loadQuotation('Revise');" class=""><a data-toggle="tab" aria-expanded="false" class="cust-label">Revisions</a></li>
								<!--<li onclick="loadQuotation('Draft');" class=""><a data-toggle="tab" aria-expanded="false" class="cust-label" hidden>Draft</a></li>-->
								<li onclick="loadQuotation('Requires Approval');" class=""><a data-toggle="tab" aria-expanded="false" class="cust-label">Requires Approval</a></li>
								<li onclick="loadQuotation('For Quotation');" class=""><a data-toggle="tab" aria-expanded="false" class="cust-label">For Quotation</a></li>
								<li onclick="loadQuotation('Cancelled');" class=""><a data-toggle="tab" aria-expanded="false" class="cust-label">Cancelled</a></li>
							</ul>
							<div class="tab-content">
								<div class="row">
									<div class="col-md-12 col-sm-12">
										<div class="table-container">
											<table id="tblQuotation" name="tblQuotation" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
												<thead>
													<tr>
														<th></th>
														<th>Quotation Number</th>
														<th>Revision Number</th>
														<th>Quotation Subject</th>
														<th>Client</th>
														<th>Quotation Date</th>
														<th>Project in Charge</th>
														<th>Status</th>
														<th>Date Created</th>
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
		<div class="modal fade" id="mdQuotation" name="mdQuotation">
			<div class="modal-dialog modal-md">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">For Quotation</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Client Name</label>
									<label class="cust-label text-danger">*</label>
									<select id="cmbClient" name="cmbClient" class="form-control select2 cust-label cust-textbox" style="width: 100%;">
										<option value="" selected disabled>-- Select Client --</option>
										<?php
											include dirname(__FILE__,2) . '/program_assets/php/dropdown/clients.php';
										?>
									</select>
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Assign To</label>
									<label class="cust-label text-danger">*</label>
									<select id="cmbEngineer" name="cmbEngineer" class="form-control select2 cust-label cust-textbox" style="width: 100%;">
										<option value="" selected disabled>-- Select Engineer --</option>
										<?php
											include dirname(__FILE__,2) . '/program_assets/php/dropdown/engineer.php';
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Quotation Subject</label>
									<label class="cust-label text-danger">*</label>
									<textarea id="txtQuotationSubject" class="form-control cust-label cust-textbox" style="overflow:auto;resize:none" rows="3" cols="20" placeholder="Enter Quotation Subject Details"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-md-4 col-xs-6 pull-right">
								<button id="btnSaveQuotation" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
									<i class="fa fa-save"></i>
									&nbsp;
									Assign
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
		<div class="modal fade" id="mdQuotationDetails" name="mdQuotationDetails">
			<div class="modal-dialog modal-md">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Quotation Form</label>
						<label id="lblUser" hidden><?php echo $_SESSION["id"];  ?></label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<!--<div class="row">
							<div class="col-md-12">
								<div class="callout">
									<p class="cust-label">
										<i class="fa fa-industry"></i>
										&nbsp;&nbsp;
										Client Details and Information
									</p>
								</div>
							</div>
						</div>-->
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<label class="cust-label">Client: &nbsp;</label>
								<span id="spClientName" class="cust-label">{{ value }}</span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<label class="cust-label">Address: &nbsp;</label>
								<span id="spClientAddress" class="cust-label">{{ value }}</span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-xs-12">
								<label class="cust-label">Contact Person: &nbsp;</label>
								<span id="spClientContactPerson" class="cust-label">{{ value }}</span>
							</div>
							<div class="col-md-6 col-xs-12">
								<label class="cust-label">Email Address: &nbsp;</label>
								<span id="spClientEmailAddress" class="cust-label">{{ value }}</span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-xs-12">
								<label class="cust-label">Mobile Number: &nbsp;</label>
								<span id="spClientMobileNumber" class="cust-label">{{ value }}</span>
							</div>
							<div class="col-md-6 col-xs-12">
								<label class="cust-label">Landline: &nbsp;</label>
								<span id="spClientLandline" class="cust-label">{{ value }}</span>
							</div>
						</div>
						<br>
						<!--<div class="row">
							<div class="col-md-12">
								<div class="callout">
									<p class="cust-label">
										<i class="fa fa-list"></i>
										&nbsp;&nbsp;
										Quotation Details
									</p>
								</div>
							</div>
						</div>-->
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<label class="cust-label">Quotation Subject: &nbsp;</label>
								<span id="spQuotationSubject" class="cust-label">{{ value }}</span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<label class="cust-label">Quotation Number: &nbsp;</label>
								<span id="spQuotationNumber" class="cust-label">{{ value }}</span>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-md-4 col-xs-12">
							</div>
							<div class="col-md-4 col-xs-12">
								<input id="txtQuotationDate" class="form-control input-sm cust-label" type="date">
							</div>
							<div class="col-md-4 col-xs-12">
								<div class="form-group-x">
									<button id="btnUpdateQuotation" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
										<i class="fa fa-save"></i>
										&nbsp;
										Save Changes
									</button>
								</div>
							</div>
						</div>
					</div>
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
		
		<!-- Modal Name  -->
		<div class="modal fade" id="mdQuotationDetailsItem" name="mdQuotationDetailsItem">
			<div class="modal-dialog modal-custom">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Quotation Reference: &nbsp;</label><span id="spQuotationRef" class="cust-label"></span>
						<button onClick="enableSubmit();" type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body" style="background-color: #f9f9f9;">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="row">
									<div class="col-md-12 col-xs-12">
										<label class="cust-label">Client: &nbsp;</label>
										<span id="spClientName-item" class="cust-label">{{ value }}</span>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 col-xs-12">
										<label class="cust-label">Address: &nbsp;</label>
										<span id="spClientAddress-item" class="cust-label">{{ value }}</span>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 col-xs-12">
										<label class="cust-label">Contact Person: &nbsp;</label>
										<span id="spClientContactPerson-item" class="cust-label">{{ value }}</span>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 col-xs-12">
										<label class="cust-label">Email Address: &nbsp;</label>
										<span id="spClientEmailAddress-item" class="cust-label">{{ value }}</span>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-xs-12">
										<label class="cust-label">Mobile Number: &nbsp;</label>
										<span id="spClientMobileNumber-item" class="cust-label">{{ value }}</span>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 col-xs-12">
										<label class="cust-label">Landline: &nbsp;</label>
										<span id="spClientLandline-item" class="cust-label">{{ value }}</span>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="row">
									<div class="col-md-12 col-xs-12">
										<label class="cust-label">Quotation Subject: &nbsp;</label>
										<span id="spQuotationSubject-item" class="cust-label">{{ value }}</span>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 col-xs-12">
										<label class="cust-label">Quotation Date: &nbsp;</label>
										<span id="spQuotationDate-item" class="cust-label">{{ value }}</span>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 col-xs-12">
										<label class="cust-label">Revision Number: &nbsp;</label>
										<span id="spRevisionNumber-item" class="cust-label">{{ no-value-yet }}</span>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-6 col-xs-12">
										<button id="btnCreateTask" type="button" class="btn btn-block btn-default btn-sm cust-textbox">
											<i class="fa fa-trello"></i>
											&nbsp;
											Create Task
										</button>
									</div>
									<div class="col-md-6 col-xs-12">
										<button type="button" class="btn btn-block btn-default btn-sm cust-textbox">
											<i class="fa fa-print"></i>
											&nbsp;
											Print
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-body" style="max-height: 580px; overflow-y: scroll; overflow-x: hidden;">
						<div id="dvProjects">
							<div class="row">
								<div class="col-md-12">
									<div class="box">
										<div class="box-header">
											<label class="cust-label">Project Description: &nbsp;</label>
											<span class="cust-label">Receiving of Materials</span>
										</div>
										<div class="box-body no-padding">
											<table class="table table-bordered cust-label" style="width: 100%">
												<tr style="background-color: #f9f9f9;">
													<th style="width: 150px;">Supplier</th>
													<th style="width: 87px;">Item Code</th>
													<th style="width: 363px;">Description</th>
													<th style="width: 52px;">Qty</th>
													<th style="width: 52px;">UOM</th>
													<th style="width: 80px;">Unit Price</th>
													<th style="width: 90px;">Total Price</th>
												</tr>
												<tr>
													<td>XYZ Trading Company</td>
													<td>ITEM-001</td>
													<td>2X2 Flywood</td>
													<td>3</td>
													<td>PCS</td>
													<td>100</td>
													<td>300</td>
												</tr>
												<tr>
													<td colspan=7>
														<button type="button" class="btn btn-default btn-xs cust-textbox">
															&nbsp;
															&nbsp;
															&nbsp;
															<i class="fa fa-edit"></i>
															&nbsp;
															Edit Current Task
															&nbsp;
															&nbsp;
															&nbsp;
														</button>
														<div class="pull-right" style="margin-top: 8px;">
															<label class="cust-label">Sub Total:&nbsp;</label>
															<span class="cust-label">300</span>
														</div>
													</td>
												</tr>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-md-3 col-xs-12">
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="pull-right">
									<label class="cust-label">Total: &nbsp;</label>
									<span id="spQutationTotal" class="cust-label">0</span>
								</div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="pull-right">
									<label class="cust-label">Tax (12%): &nbsp;</label>
									<span id="spQutation12" class="cust-label">0</span>
								</div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="pull-right">
									<label class="cust-label">Grand Total: &nbsp;</label>
									<span id="spQutationGTotal" class="cust-label">0</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			<!-- /.modal-content -->
			</div>
		<!-- /.modal-dialog -->
		</div>

		<!-- Modal Name  -->
		<div class="modal fade" id="mdTaskOptions" name="mdTaskOptions">
			<div class="modal-dialog modal-md">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Task Options</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-6">
								<button id="btnTaskMaterial" type="button" class="btn btn-block btn-default btn-xs cust-textbox">
									<i class="fa fa-cubes"></i>
									&nbsp;
									Materials and Equipment
								</button>
							</div>
							<div class="col-md-6">
								<button id="btnTaskMaterial-nt" type="button" class="btn btn-block btn-default btn-xs cust-textbox">
									<i class="fa fa-hand-grab-o"></i>
									&nbsp;
									Labor Cost and other Requirements
								</button>
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
		<div class="modal fade" id="mdTaskMasterial" name="mdTaskMasterial">
			<div class="modal-dialog modal-md">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Materials and Equipment</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Project Description</label>
									<label class="cust-label text-danger">*</label>
									<textarea id="txtTaskDescription" class="form-control cust-label cust-textbox" style="overflow:auto;resize:none" rows="2" cols="20" placeholder="Enter Project Details"></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<label class="cust-label">Product</label>
								<label class="cust-label text-danger">*</label>
								<select id="cmbTaskProduct" name="cmbTaskProduct" class="form-control select2 cust-label cust-textbox" style="width: 100%;">
									<option value="" disabled selected>-- Select an Item --</option>
									<?php include dirname(__FILE__,2) . '/program_assets/php/dropdown/items.php'; ?>
								</select>
							</div>
							<div class="col-md-6 col-sm-12">
								<label class="cust-label">Supplier</label>
								<label class="cust-label text-danger">*</label>
								<select id="cmbTaskProductSupplier" name="cmbTaskProductSupplier" class="form-control select2 cust-label cust-textbox" style="width: 100%;">
									<option value="" disabled selected>-- Select a Supplier --</option>
								</select>
							</div>
						</div>
						<div style="height: 5px;"></div>
						<div class="row">
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Quantity</label>
									<label class="cust-label text-danger">*</label>
									<input type="number" min="1" onKeyPress="if(this.value > 4999) return false;"onkeydown="if(event.key==='.'){event.preventDefault();}" class="form-control cust-label cust-textbox" id="txtTaskQty" name="txtTaskQty" placeholder="Enter Quantity" autocomplete="off">
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Total Amount</label>
									<input class="form-control cust-label cust-textbox" id="txtTaskTotal" type="text" placeholder="0" disabled>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="table-container">
									<table id="tblTaskItem" name="tblTaskItem" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
										<thead>
											<tr>
												<th>Brand</th>
												<th>Item</th>
												<th>Qty</th>
												<th>Price</th>
												<th>Total</th>
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
						<div class="row">
							<div class="col-md-4 col-sm-12">
								<button id="btnTaskAddItem" type="button" class="btn btn-block btn-default btn-xs cust-textbox">
									<i class="fa fa-shopping-cart"></i>
									&nbsp;
									Add Item
								</button>
							</div>
							<div class="col-md-4 col-sm-12">
							</div>
							<div class="col-md-4 col-sm-12">
								<button id="btnSaveProject" type="button" class="btn btn-block btn-default btn-xs cust-textbox">
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
		<div class="modal fade" id="mdTaskMasterial-nt" name="mdTaskMasterial-nt">
			<div class="modal-dialog modal-md">
				<div class="box box-default">
					<div class="box-header with-border">
						<label class="cust-label">Labor Cost and other Requirements</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<div class="form-group">
									<label class="cust-label">Project Description</label>
									<label class="cust-label text-danger">*</label>
									<textarea id="txtTaskDescription-nt" class="form-control cust-label cust-textbox" style="overflow:auto;resize:none" rows="2" cols="20" placeholder="Enter Project Details"></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-9 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Description</label>
									<label class="cust-label text-danger">*</label>
									<input type="text" class="form-control cust-label cust-textbox" id="txtTask-nt" name="txtTask-nt" placeholder="Enter Other Details of the task" autocomplete="off">
								</div>
							</div>
							<div class="col-md-3 col-sm-12">
								<div class="form-group">
									<label class="cust-label">Amount</label>
									<label class="cust-label text-danger">*</label>
									<input type="number" min="1" class="form-control cust-label cust-textbox" id="txtTaskAmount-nt" name="txtTaskAmount-nt" placeholder="0.00" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="table-container">
									<table id="tblTaskItem_nt" name="tblTaskItem-nt" class="table table-bordered table-hover cust-label" style="width: 100% !important;">
										<thead>
											<tr>
												<th>Description</th>
												<th>Total</th>
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
						<div class="row">
							<div class="col-md-4 col-sm-12">
								<button id="btnTaskAddItem-nt" type="button" class="btn btn-block btn-default btn-xs cust-textbox">
									<i class="fa fa-hand-grab-o"></i>
									&nbsp;
									Add Task
								</button>
							</div>
							<div class="col-md-4 col-sm-12">
							</div>
							<div class="col-md-4 col-sm-12">
								<button id="btnSaveProject-nt" type="button" class="btn btn-block btn-default btn-xs cust-textbox">
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
		<div class="modal fade" id="mdQuotationRemarks" name="mdQuotationRemarks">
			<div class="modal-dialog modal-md">
				<div class="box box-default">
					<div class="box-header with-border">
						<label id="lblQuotationTitle" class="cust-label">Quotation Remarks</label>
						<button type="submit" class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
						</button>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<div class="form-group">
									<textarea id="txtQuotationRemarks" class="form-control cust-label cust-textbox" style="overflow:auto;resize:none" rows="3" cols="20" placeholder="Please provide the reason why you want this quotation to revise or cancel"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-md-3 pull-right">
								<button id="btnSaveQuotationRemarks" type="button" class="btn btn-block btn-default btn-xs cust-textbox">
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
		<script src="../program_assets/js/web_functions/quotation.js?random=<?php echo uniqid(); ?>"></script>
		<script src="../program_assets/js/web_functions/quotation-nt.js?random=<?php echo uniqid(); ?>"></script>
		
	</body>
</html>