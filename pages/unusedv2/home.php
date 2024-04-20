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
                     ?>
                  <div class="nav-tabs-custom">
                     <ul class="nav nav-tabs">
                        <li><a href="#timeline" data-toggle="tab" aria-expanded="true" class="cust-label">News Feed and Latest Trends</a></li>
                     </ul>
                     <div class="tab-content">
                        <div class="tab-pane active" id="timeline">
                           <ul class="timeline timeline-inverse">
                              <?php
                                 include '../program_assets/php/connection/conn.php';
                                 
                                 $sql = "
                                    SELECT
                                       a.title,
                                       a.story,
                                       DATE_FORMAT(a.dateCreated, '%d %b. %Y') AS dateCreated,
                                       DATE_FORMAT(a.dateCreated, '%h:%i %p') AS timeCreated,
                                       a.id
                                    FROM
                                       hrms_newsfeed a
                                    WHERE
                                       a.isActive = 1
                                    ORDER BY
                                       a.dateCreated DESC;
                                 ";
                                 $result = mysqli_query($con,$sql);
                                 $oldDate = "";
                                 
                                 while ($row  = mysqli_fetch_row($result)) {
                                    $dateTitle = "";
                                    $colorSet = array("bg-blue", "bg-aqua", "bg-yellow", "bg-purple", "bg-red", "bg-green");
                                    $randomColor = $colorSet[array_rand($colorSet)];
                                    
                                    if ($row[2] != $oldDate) {
                                       $dateTitle = '
                                          <li class="time-label">
                                          <span class="'.$randomColor.' cust-label">
                                          '.$row[2].'
                                          </span>
                                       ';
                                       
                                       $oldDate = $row[2];
                                    }
                                    
                                    
                                    mysqli_next_result($con);
                                    
                                    $sql_image = "
                                       SELECT
                                          a.*
                                       FROM
                                          hrms_newsfeed_image a
                                       WHERE
                                          a.isActive = 1
                                       AND
                                          a.newsFeedID = 
                                    " . $row[4];
                                    
                                    $result_image = mysqli_query($con,$sql_image);
                                    $str_image = "";
                                    
                                    while ($row_image  = mysqli_fetch_row($result_image)) {
                                       $str_image .= '
                                          <div class="col-md-2 col-sm-3 col-xs-12">
                                             <img class="img-responsive image-style" src="../photos/'. $row_image[1] .'.png" alt="Photo" style="border-radius: 4%;">
                                          </div>
                                       ';
                                    }
                                    
                                    
                                    echo '
                                       '.$dateTitle.'
                                       <li>
                                          <i class="fa fa-newspaper-o '.$randomColor.'"></i>
                                          <div class="timeline-item">
                                             <span class="time"><i class="fa fa-clock-o"></i> '.$row[3].'</span>
                                             <h6 class="timeline-header" style="font-size: 14px !important;"><b>'.$row[0].'</b></h6>
                                             <div class="timeline-body cust-label">
                                                '.$row[1].'
                                             </div>
                                             <div class="row image-border">
                                                '.$str_image.'
                                             </div>
                                          </div>
                                       </li>
                                    ';
                                 }
                                 
                                 mysqli_free_result($result);
                                 mysqli_close($con);
                              ?>
                           
                              <li>
                                 <i class="fa fa-clock-o bg-gray"></i>
                              </li>
                           </ul>
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