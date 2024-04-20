<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <title>HRMDS | Hiring Portal</title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
      <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css" />
      <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css" />
      <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css" />
      <link rel="stylesheet" href="../dist/css/AdminLTE.min.css" />
      <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css" />
      <link href="../program_assets/css/style.css" rel="stylesheet" type="text/css" />
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" />
      <script nonce="815b3fdf-173b-4e62-a1f2-effa3143ee38">
         (function (w, d) {
             !(function (a, e, t, r) {
                 a.zarazData = a.zarazData || {};
                 a.zarazData.executed = [];
                 a.zaraz = { deferred: [] };
                 a.zaraz.q = [];
                 a.zaraz._f = function (e) {
                     return function () {
                         var t = Array.prototype.slice.call(arguments);
                         a.zaraz.q.push({ m: e, a: t });
                     };
                 };
                 for (const e of ["track", "set", "ecommerce", "debug"]) a.zaraz[e] = a.zaraz._f(e);
                 a.zaraz.init = () => {
                     var t = e.getElementsByTagName(r)[0],
                         z = e.createElement(r),
                         n = e.getElementsByTagName("title")[0];
                     n && (a.zarazData.t = e.getElementsByTagName("title")[0].text);
                     a.zarazData.x = Math.random();
                     a.zarazData.w = a.screen.width;
                     a.zarazData.h = a.screen.height;
                     a.zarazData.j = a.innerHeight;
                     a.zarazData.e = a.innerWidth;
                     a.zarazData.l = a.location.href;
                     a.zarazData.r = e.referrer;
                     a.zarazData.k = a.screen.colorDepth;
                     a.zarazData.n = e.characterSet;
                     a.zarazData.o = new Date().getTimezoneOffset();
                     a.zarazData.q = [];
                     for (; a.zaraz.q.length; ) {
                         const e = a.zaraz.q.shift();
                         a.zarazData.q.push(e);
                     }
                     z.defer = !0;
                     for (const e of [localStorage, sessionStorage])
                         Object.keys(e || {})
                             .filter((a) => a.startsWith("_zaraz_"))
                             .forEach((t) => {
                                 try {
                                     a.zarazData["z_" + t.slice(7)] = JSON.parse(e.getItem(t));
                                 } catch {
                                     a.zarazData["z_" + t.slice(7)] = e.getItem(t);
                                 }
                             });
                     z.referrerPolicy = "origin";
                     z.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(a.zarazData)));
                     t.parentNode.insertBefore(z, t);
                 };
                 ["complete", "interactive"].includes(e.readyState) ? zaraz.init() : a.addEventListener("DOMContentLoaded", zaraz.init);
             })(w, d, 0, "script");
         })(window, document);
      </script>
   </head>
   <body class="hold-transition layout-top-nav skin-black">
      <div class="wrapper">
         <header class="main-header">
            <nav class="navbar navbar-static-top" style="height: 70px;">
               <div class="container" style="margin-top: 10px;">
                  <?php
                     include 'header.php';
                     ?>
                  <div class="navbar-custom-menu" style="visibility: collapse;">
                     <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                           <img src="../dist/img/user2-160x160.jpg" class="user-image" alt="User Image" />
                           <span class="hidden-xs">Alexander Pierce</span>
                           </a>
                           <ul class="dropdown-menu">
                              <li class="user-header">
                                 <img src="../banner.PNG" class="img-circle" alt="User Image" />
                                 <p>
                                    Alexander Pierce - Web Developer
                                    <small>Member since Nov. 2012</small>
                                 </p>
                              </li>
                              <li class="user-body">
                                 <div class="row">
                                    <div class="col-xs-4 text-center">
                                       <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                       <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                       <a href="#">Friends</a>
                                    </div>
                                 </div>
                              </li>
                              <li class="user-footer">
                                 <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                 </div>
                                 <div class="pull-right">
                                    <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                 </div>
                              </li>
                           </ul>
                        </li>
                     </ul>
                  </div>
               </div>
            </nav>
         </header>
         <div class="content-wrapper">
            <div class="container">
               <section class="content">
                  <?php
                     include 'banner.php';
                     include '../program_assets/php/connection/conn.php';
                     
                     $positionName = !isset($_GET["search"]) ? '' : $_GET["search"];
                     
                     $sql = "
                        SELECT
                           func_proper(b.department) AS department,
                           func_proper(a.position) AS position,
                           REPLACE(FORMAT(a.salaryGrade,2),'.00','') AS salaryGrade,
                           CONCAT('Posted on ',DATE_FORMAT(a.dateCreated,'%M %d, %Y')) AS dateCreated
                        FROM
                           hrms_job_vacancy a
                        INNER JOIN
                           hrms_user_department b
                        ON
                           a.departmentID = b.id
                        WHERE
                           a.isActive = 1
                        AND
                           a.position LIKE '%$positionName%'
                        ORDER BY
                           a.dateCreated DESC
                     ";
                  ?>
                  <div class="nav-tabs-custom">
                     <ul class="nav nav-tabs">
                        <li><a href="#timeline" data-toggle="tab" aria-expanded="true" class="cust-label">Our Latest and Available Jobs</a></li>
                     </ul>
                     <div class="tab-content">
                        <div class="row">
                           <div class="col-md-10">
                              <div class="direct-chat-msg">
                                 <div class="direct-chat-info clearfix">
                                    <span class="direct-chat-name pull-left">Sophia</span>
                                    <span class="direct-chat-timestamp pull-right"><?php echo date('h:i A', time()); ?></span>
                                 </div>
                                 
                                 <img class="direct-chat-img" src="../photos/chatbot.jpg" alt="Message User Image">
                                 <div class="direct-chat-text cust-label direct-blue">
                                    <?php
                                       if (!isset($_GET["search"])) {
                                          echo "Hi! My name is Sophia. Your friendly HR Bot, as You can see we have a lot of job openings. Wanna know the details and if your qualified? Lets talk on the chatbox on your lower right. See you there.";
                                       } else {
                                          $find_query = mysqli_query($con,$sql);
                                          if (mysqli_num_rows($find_query) == 0) {
                                              mysqli_next_result($con);
                                              
                                              echo "Sorry!. We couldn't find any job related to '$positionName'. Can you improve the word that your searching? So I can match more";
                                          } else {
                                              echo "Here are the list of jobs related to '$positionName'. If you want to know the details or if your qualified lets talk on the chatbox on your lower right. See you there.";
                                          }  
                                       }
                                    ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <?php
                              $result = mysqli_query($con,$sql);
                              
                              while ($row  = mysqli_fetch_row($result)) {
                                 $colorSet = array(/*"bg-blue", "bg-aqua", "bg-yellow", "bg-purple", "bg-red", "bg-green",*/"bg-gray");
                                 $randomColor = $colorSet[array_rand($colorSet)];
                                 
                                 ?>
                                    <div class="col-md-4">
                                       <div class="info-box <?php echo $randomColor; ?>">
                                          <div class="info-box-content" style="margin-left: 0px;">
                                             <span class="info-box-text info-box-text-remove" title="<?php echo $row[0]; ?>"><b>Department : </b><?php echo $row[0]; ?></span>
                                             <span class="info-box-text info-box-text-remove"><b>Position : </b><?php echo $row[1]; ?></span>
                                             <span class="info-box-text info-box-text-remove"><b>Salary : </b><?php echo $row[2]; ?></span>
                                             <div class="progress">
                                                <div class="progress-bar" style="width: 100%"></div>
                                             </div>
                                             <span class="progress-description custom-label">
                                                <i class="fa fa-map-pin"></i>
                                                &nbsp;
                                                <?php echo $row[3]; ?>
                                             </span>
                                          </div>
                                       </div>
                                    </div>
                                 <?php
                              }
                              
                           ?>
                        </div>
                     </div>
                  </div>
               </section>
            </div>
         </div>
         <footer class="main-footer">
            <div class="container">
               <div class="pull-right hidden-xs"><b>Version</b> 1.0.0</div>
               <strong>Copyright &copy; 2022<a href="#"> HRMDS</a>.</strong> All rights reserved.
            </div>
         </footer>
      </div>
      <script src="../bower_components/jquery/dist/jquery.min.js"></script>
      <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
      <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
      <script src="../bower_components/fastclick/lib/fastclick.js"></script>
      <script src="../dist/js/adminlte.min.js"></script>
      <script src="../dist/js/demo.js"></script>
   </body>
</html>