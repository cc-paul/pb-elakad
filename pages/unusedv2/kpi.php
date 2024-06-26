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
							<p class="box-title">Project Key Performance Indicator (KPI)</p>
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
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-4">
											<div class="box box-default">
												<div class="box-header with-border">
													<label class="cust-label">Project Progress</label>
												</div>
												<div class="box-body">
													<div class="row">
														<div class="col-md-12">
															<center>
																<div id="dvTitleHolder" class="col-md-12 col-sm-4" style="font-size: 15px;"></div>
															</center>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-md-3 col-xs-12">
															
														</div>
														<div class="col-md-9 col-xs-12">
															<span id="spStartDate" class="cust-label">Start Date</span>
															<span id="spEndDate" class="pull-right cust-label">End Date</span>
														</div>
													</div>
													<div class="row">
														<div class="col-md-3 col-xs-12">
															<span class="progress-text cust-label">
															   <b>Total Project Value</b>
															   <br>
															   100%
															</span>
														</div>
														<div class="col-md-9 col-xs-12" style="top: 6px;">
															<div class="progress progress-sm active">
																<div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-3 col-xs-12" >
															<span class="progress-text cust-label">
															   <b>Project Progress</b>
															   <br>
															   0% - 100%
															</span>
														</div>
														<div class="col-md-9 col-xs-12" style="top: 6px;">
															<div class="progress progress-sm active">
																<div id="dvProgress1" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-3 col-xs-12">
															<span class="progress-text cust-label">
															   <b>Uninstalled</b>
															   <br>
															   100% - 0%
															</span>
														</div>
														<div class="col-md-9 col-xs-12" style="top: 6px;">
															<div class="progress progress-sm active">
																<div id="dvProgress2" class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
                                        </div>
										<div class="col-md-2">
											<div class="box box-default">
												<div class="box-header with-border">
													<label class="cust-label">Materials Progress</label>
												</div>
												<div class="box-body">
													<center>
														<canvas id="myCanvas" width="200" height="200"></canvas>
													</center>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="box box-default">
												<div class="box-header with-border">
													<label class="cust-label">Client Details and Information</label>
												</div>
												<div class="box-body">
													<label class="cust-label">Client Name : </label>
													<span id="spd1" class="cust-label"></span>
													<br>
													<label class="cust-label">Address : </label>
													<span id="spd2" class="cust-label"></span>
													<br>
													<label class="cust-label">Contact Person : </label>
													<span id="spd3" class="cust-label"></span>
													<br>
													<label class="cust-label">Landline : </label>
													<span id="spd4" class="cust-label"></span>
													<br>
													<label class="cust-label">Mobile Number : </label>
													<span id="spd5" class="cust-label"></span>
													<br>
													<label class="cust-label">Email Address : </label>
													<span id="spd6" class="cust-label"></span>
												</div>
											</div>
                                        </div>
										<div class="col-md-3">
											<div class="box box-default">
												<div class="box-header with-border">
													<label class="cust-label">Project Status and Information</label>
												</div>
												<div class="box-body">
													<label class="cust-label">Project Name : </label>
													<span id="spde1" class="cust-label"></span>
													<br>
													<label class="cust-label">Project Value : </label>
													<span id="spde2" class="cust-label"></span>
													<br>
													<label class="cust-label">Start Date : </label>
													<span id="spde3" class="cust-label"></span>
													<br>
													<label class="cust-label">End Date : </label>
													<span id="spde4" class="cust-label"></span>
													<br>
													<label class="cust-label">Status : </label>
													<span id="spde5" class="cust-label"></span>
													<br>
													<label class="cust-label">Project In Charge : </label>
													<span id="spde6" class="cust-label"></span>
													<br>
													<label class="cust-label">Remarks : </label>
													<span id="spde7" class="cust-label"></span>
												</div>
											</div>
										</div>
										
									</div>
                                </div>
                                <div class="box-footer">
                                     <div class="row">
                                        <div class="col-sm-3 col-xs-6">
                                           <div class="description-block border-right">
                                              <!--<span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i></span>-->
                                              <h5  id="sp1" class="description-header">0</h5>
                                              <span class="description-text">TOTAL QUANTITY</span>
                                           </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                           <div class="description-block border-right">
                                              <!--<span class="description-percentage text-green"><i class="fa fa-caret-up"></i></span>-->
                                              <h5  id="sp2" class="description-header">0</h5>
                                              <span class="description-text">TOTAL DELIVERED</span>
                                           </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                           <div class="description-block border-right">
                                              <!--<span class="description-percentage text-green"><i class="fa fa-caret-up"></i></span>-->
                                              <h5 id="sp3" class="description-header">0</h5>
                                              <span class="description-text text-green">
												<b>TOTAL INSTALLED</b>
											  </span>
											  <!--<small class="cust-lalabel bg-green">TOTAL INSTALLED</small>-->
                                           </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                           <div class="description-block">
                                              <!--<span class="description-percentage text-red"><i class="fa fa-caret-down"></i></span>-->
                                              <h5  id="sp4" class="description-header">0</h5>
                                              <span class="description-text text-yellow">
												<b>UPDATED STOCKS</b>
											  </span>
                                           </div>
                                        </div>
                                     </div>
                                  </div>
								</div>
                            </div>
                        </div>
                        
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
								<li onclick="loadProjects('');" class="active"><a data-toggle="tab" aria-expanded="true" class="cust-label">All</a></li>
								<li onclick="loadProjects('Approved');" class=""><a data-toggle="tab" aria-expanded="false" class="cust-label">Approved</a></li>
								<li onclick="loadProjects('New');" class=""><a data-toggle="tab" aria-expanded="false" class="cust-label">New</a></li>
								<li onclick="loadProjects('WIP');" class=""><a data-toggle="tab" aria-expanded="false" class="cust-label">WIP</a></li>
								<!--<li onclick="loadQuotation('Draft');" class=""><a data-toggle="tab" aria-expanded="false" class="cust-label" hidden>Draft</a></li>-->
								<li onclick="loadProjects('On Hold');" class=""><a data-toggle="tab" aria-expanded="false" class="cust-label">On Hold</a></li>
								<li onclick="loadProjects('Completed');" class=""><a data-toggle="tab" aria-expanded="false" class="cust-label">Completed</a></li>
								<li onclick="loadProjects('Cancelled');" class=""><a data-toggle="tab" aria-expanded="false" class="cust-label">Cancelled</a></li>
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
														<th>PO Number</th>
														<th>Project Name</th>
														<th>Client</th>
                                                        <th>Total Project Value</th>
														<th>Start Date</th>
														<th>End Date</th>
														<th>Status</th>
														<th>Project in Charge</th>
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
		<script src="../bower_components/rpie/rpie.js"></script>
		
		<!-- StartUp Custom JS (do not remove)  -->
		<script src="../program_assets/js/site_essentials/sidebar.js?random=<?php echo uniqid(); ?>"></script>
		<script src="../program_assets/js/site_essentials/others.js?random=<?php echo uniqid(); ?>"></script>
		<script src="../program_assets/js/web_functions/kpi.js?random=<?php echo uniqid(); ?>"></script>
		
	</body>
</html>