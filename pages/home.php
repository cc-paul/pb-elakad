<html>
   <head>
      <title>E-Lakad | Home</title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- Bootstrap 3.3.7 -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <link rel="stylesheet" href="../bower_components/custom-confirm/jquery-confirm.min.css">
      <style>
         * {
            font-size: 13px;
         }
         
         .masthead {
            height: 75vh;
            min-height: 500px;
            background-image: url('../photos/school.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
         }
         
         select{
            -webkit-appearance: listbox !important
         }
      </style>
   </head>
   <body>
      <!-- Navigation -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light shadow fixed-top">
         <div class="container">
            <a class="navbar-brand" href="#">E-Lakad</a>
            <!--<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>-->
            <!--<div class="collapse navbar-collapse" id="navbarResponsive">
               <ul class="navbar-nav ms-auto">
                  <li class="nav-item active">
                     <a class="nav-link" href="#">Start Mapping</a>
                     
                  </li>
               </ul>-->
            </div>
         </div>
      </nav>
      <!-- Full Page Image Header with Vertically Centered Content -->
      <header class="masthead">
         <div class="container h-100">
            <div class="row h-100 align-items-center">
               <div class="col-12 text-center">
                  <!--<h1 class="fw-light">Vertically Centered Masthead Content</h1>
                  <p class="lead">A great starter layout for a landing page</p>-->
                  <button id="btnStartMapping" type="button" class="btn btn-lg btn-primary" data-toggle="modal" style="height: 53px;width: 228px;font-size: 25px; margin-top: 274px;">Start Mapping</button>
               </div>
            </div>
         </div>
      </header>
      <!-- Page Content -->
      <section class="py-5">
         <div class="container">
            <h2 class="fw-light">Background</h2>
            <p>E-Lakad is one of the systems of Isabela State University that aims is to guide all the visitors and students by guiding them to their destinations. It provides geographical interface of the campus, it can show you the directions for each offices
            </p>
         </div>
      </section>
   </body>
   
   <!-- The Modal -->
   <div class="modal" id="myModal">
     <div class="modal-dialog">
       <div class="modal-content">
   
         <!-- Modal Header -->
         <div class="modal-header">
           <h5 class="modal-title">Purpose Form</h5>
           <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
         </div>
   
         <!-- Modal body -->
         <div class="modal-body">
            <div class="row">
               <div class="col-md-12 col-xs-12">
                  <div class="alert alert-info" role="alert">
                     Please fill in all required fields and accept the GPS confirmation to proceed.
                  </div>
               </div>
            </div>
            <div class="row" style="height: 0px; visibility:hidden;">
               <div class="col-md-12 col-xs-12">
                  <label class="form-label">Visitor ID : </label>
                  <label id="lblVisitorID">
                     
                     <?php
                        include '../program_assets/php/connection/conn.php';
                     
                        $visitorID = generateRandomString();
                        $fullName = "";
                        $mobileNumber = "";
                        $completeAddress = "";
                        $reason = "";
                     
                        if(!isset($_COOKIE['visitorID'])) {
                           setcookie('visitorID',$visitorID,mktime (0, 0, 0, 12, 31, 2030));
                           $_COOKIE['visitorID'] = $visitorID;
                        }
                        
                        function generateRandomString($length = 25) {
                           $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                           $charactersLength = strlen($characters);
                           $randomString = '';
                           for ($i = 0; $i < $length; $i++) {
                               $randomString .= $characters[rand(0, $charactersLength - 1)];
                           }
                           return $randomString;
                        }
                        
                        $sql    = "
                           SELECT
                              a.fullName,
                              a.mobileNumber,
                              a.completeAddress,
                              a.reason
                           FROM
                              el_map_activity a
                           WHERE
                              a.visitorsID = '".$_COOKIE['visitorID']."'
                           ORDER BY
                              a.id DESC 
                           LIMIT 1;
                        ";
                        $result = mysqli_query($con,$sql);
                        
                        $json = array();
                        while ($row  = mysqli_fetch_row($result)) {
                           $fullName = $row[0];
                           $mobileNumber = $row[1];
                           $completeAddress = $row[2];
                           $reason = $row[3];
                        }
                        
                        mysqli_free_result($result);
                        mysqli_close($con);
                        
                        echo $_COOKIE['visitorID'];
                     ?>
                     
                  </label>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6 col-xs-12">
                  <label for="txtFullName" class="form-label">Full Name *</label>
                  <input type="text" class="form-control" id="txtFullName" placeholder="Enter Full Name" value="<?php echo $fullName; ?>">
               </div>
               <div class="col-md-6 col-xs-12">
                  <label for="txtMobileNumber" class="form-label">Mobile Number *</label>
                  <input type="text" class="form-control" id="txtMobileNumber" placeholder="Enter Mobile Number (09XXXXXXXXX)" maxlength="11" onkeyup="numOnly(this)" value="<?php echo $mobileNumber; ?>">
               </div>
            </div>
            <div style="height:5px;"></div>
            <div class="row">
               <div class="col-md-12 col-xs-12">
                  <label for="txtCompleteAddress" class="form-label">Complete Address *</label>
                  <input type="text" class="form-control" id="txtCompleteAddress" placeholder="Enter Complete Address" value="<?php echo $completeAddress; ?>">
               </div>
            </div>
            <div style="height:5px;"></div>
            <div class="row">
               <div class="col-md-12 col-xs-12">
                  <label for="cmbReason" class="form-label">Reason *</label>
                  <label id="lblReason" name="lblReason" style="visibility: hidden;"><?php echo $reason; ?></label>
                  <select id="cmbReason" name="cmbReason" class="form-control select2 cust-label cust-textbox" style="width: 100%;">
                     <option value="" selected disabled>Please Select Reason</option>
                     <option value="Get Certificate of Grades">Get Certificate of Grades</option>
                     <option value="Get Certificate Of Enrollment">Get Certificate Of Enrollment</option>
                     <option value="Get Assessment">Get Assessment</option>
                     <option value="Get Transcript of Record">Get Transcript of Record</option>
                     <option value="Applying scholar">Applying scholar</option>
                     <option value="To Enroll">To Enroll</option>
                     <option value="Others">Others</option>
                  </select>
               </div>
            </div>
            <div style="height:5px;"></div>
            <div class="row">
               <div class="col-md-12 col-xs-12">
                  <textarea class="form-control" id="txtReason" rows="3" style="resize: none;" placeholder="Please provide the reason of your visit"><?php echo $reason; ?></textarea>
               </div>
            </div>
            <div style="height:5px;"></div>
            <div class="row">
               <div class="col-md-12 col-xs-12">
                  <a id="aEnableGPS" href="#" class="link-primary">Enable GPS Location</a>
               </div>
            </div>
         </div>
   
         <!-- Modal footer -->
         <div class="modal-footer">
            <button id="btnProceed" type="button" class="btn btn-success">Proceed to Mapping</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
         </div>
   
       </div>
     </div>
   </div>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../bower_components/custom-confirm/jquery-confirm.min.js"></script>
<script>
   var latLong = "0,0";
   var isGPSactivated = false;
   $("#txtReason").hide();
   
   $("#cmbReason").val($("#txtReason").text().trim()).trigger('change.select2');
   
   if ($("#lblReason").text() != "Others") {
      if ($("#lblReason").text() != "") {
         var isMatch = 0;
         
         $("#cmbReason option").each(function() {
            if($(this).text() == $("#lblReason").text()) {
               isMatch = 1;
            }                        
         });
         
         if (isMatch == 1) {
            $("#cmbReason").val($("#txtReason").text().trim()).trigger('change.select2');
            $("#txtReason").hide();
         } else {
            $("#cmbReason").val("Others").trigger('change.select2');
            $("#txtReason").show();
         }
      }
   } else if ($("#lblReason").text() == "") {
      $("#cmbReason").val(null).trigger('change.select2');
      $("#txtReason").hide();
   }
   
   $("#btnStartMapping").click(function(){
      //$("#txtFullName").val("");
      //$("#txtMobileNumber").val("");
      //$("#txtCompleteAddress").val("");
      //$("#txtReason").val("");
      
      $("#myModal").modal("show");
   });
   
   $("#cmbReason").on("change", function() {
      var value = $(this).val();
      var text  = $("#cmbReason").find("option:selected").text();
      
      if (value != "Others") {
         $("#txtReason").val(value);
         $("#txtReason").hide();
      } else {
         $("#txtReason").val("");
         $("#txtReason").show();
      }
   });
   
   $("#btnProceed").click(function(){
      var fullName = $("#txtFullName").val();
      var mobileNumber = $("#txtMobileNumber").val();
      var completeAddress = $("#txtCompleteAddress").val();
      var reason = $("#txtReason").val();
      var visitorID = $("#lblVisitorID").text().trim();
      
      if (fullName == "" || mobileNumber == "" || completeAddress == "" || reason == "") {
         JAlert("Please fill in all required fields.","red");
      } else if (mobileNumber.length != 11) {
         JAlert("Mobile number must be 11 digit.","red");
      } else if (latLong == "0,0") {
        JAlert("Please enable your GPS.","red");
      } else {
         $.ajax({
            url: "../program_assets/php/web/home.php",
            data: {
               command  : 'save_reason',
               visitorsID : visitorID,
               fullName : fullName,
               mobileNumber : mobileNumber,
               completeAddress : completeAddress,
               reason : reason
            },
            type: 'post',
            success: function (data) {
               var data = jQuery.parseJSON(data);
                
               if (data[0].error) {
                  JAlert(data[0].message,data[0].color);
               } else {
                  window.location.href = "map.php";
               }
            }
         });
      }
   });
   
   $("#aEnableGPS").click(function(){
      if (navigator.geolocation) {
         navigator.geolocation.getCurrentPosition(showPosition, showError);
      } else { 
         JAlert("Geolocation is not supported by this browser.","red");
      }
      
      setTimeout(function() {
         if (latLong != "0,0") {
            JAlert("Your GPS is already activated","blue");
         }
      }, 1000);
   });
   
   function numOnly(selector){
      selector.value = selector.value.replace(/[^0-9]/g,'');
   }
   
   function showError(error) {
      latLong = "0,0";
      
      switch(error.code) {
        case error.PERMISSION_DENIED:
         JAlert("User denied the request for Geolocation.","red");
         break;
        case error.POSITION_UNAVAILABLE:
         JAlert("Location information is unavailable.","red");
         break;
        case error.TIMEOUT:
         JAlert("The request to get user location timed out.","red");
         break;
        case error.UNKNOWN_ERROR:
         JAlert("An unknown error occurred.","red");
         break;
      }
   }
   
   function showPosition(position) {
      latLong = position.coords.latitude + "," + position.coords.longitude;
      console.log(latLong);
      
      if (latLong != "0,0" && !isGPSactivated) {
         isGPSactivated = true;
      }
   }
   
   function JAlert (message,type,confirmCallback) {
      $.alert({
         title    : 'System Message',
         content  : message,
         type     : type,
         icon     : 'fa fa-warning',
         backgroundDismiss : false,
         backgroundDismissAnimation : 'glow'
      });
   }
   
</script>