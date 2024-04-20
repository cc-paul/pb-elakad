<?php
	if(!isset($_SESSION)) { session_start(); } 
	if (!isset($_SESSION['visitorsID'])) {
		header( "Location: home" );
	}
?>

<html>
    <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>E-Lakad | Campus Map</title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.7 -->
		<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
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
      <link href="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css" rel="stylesheet"> 
      <script src="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js"></script>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      
		<style>
            .all-100 {
                height : 100%;
                width : 100%;
                background : #ECF0F5;
                margin: 0px;
            }
            
            #map { width: 100%; height: 100%; position: relative;}
            
            .inner {
               position: absolute;
            }
            
            .marker {
               background-image: url('../photos/man.png');
               background-size: cover;
               width: 50px;
               height: 50px;
               border-radius: 50%;
               cursor: pointer;
            }
            
            .panel-pc {
               top:80px;
               right:80px;
               width:400px;  
            }
            
            #dvSelection {
               height: 300px !important;
               overflow-y: scroll;
               overflow-x: hidden;
            }
		</style>
	</head>
   <body class="layout-top-nav skin-black-light all-100" style="overflow: hidden">
      <header class="main-header">
         <nav class="navbar navbar-static-top">
            <div class="row">
               <div class="col-md-12 col-xs-12" style="height: 3px; background: #005a00;"></div>
            </div>
            <div class="row">
               <div class="col-md-1 col-xs-12"></div>
               <div class="col-md-4 col-xs-12">
                  <a href="#" class="navbar-brand cust-label"><b>E-</b>Lakad</a>
                  <a href="#" class="navbar-brand cust-label" style="border-right: 1px solid #ffffff;"><b>Isabela State University</b> Cauayan Campus</a>
                  <button id="btnOpenSearchModal" type="button" class="btn btn-default btn-sm" style="margin: 13px;">
                     <i class="fa fa-search"></i>
                  </button>
               </div>
               <div class="col-md-7 col-xs-12">
                  
               </div>
            </div>
         </nav>
      </header>
      <div class="row all-100">
         <div id="map" class="inner"></div>
         <div id="dvPanelLocations" class="inner">
            <div class="box box-default" style="border-top: 3px solid #005a00;">
               <div class="box-header with-border">
                  <i class="fa fa-fw fa-building"></i>
                  <label class="cust-label">Building Locations</label>
                  <button id="btnClosePanel" type="submit" class="btn btn-default btn-sm pull-right" data-dismiss="modal"><i class="fa fa-close"></i>
                  </button>
               </div>
               <div class="box-body">
                  <div class="row">
                     <div class="col-md-12">
                         <div class="input-group">
                             <input id="txtSearchMap" type="text" placeholder="Search locations inside the campus" class="form-control cust-label">
                             <span class="input-group-addon"><i class="fa fa-search"></i></span>
                         </div>
                     </div>
                  </div>
                  <br>
                  <div id="dvSelection">
                     
                  </div>
               </div>
               <div class="box-footer"></div>
            </div>
         </div>
      </div>
   </body>
</html>
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
<!-- Import Turf and Polyline -->
<script src="https://npmcdn.com/@turf/turf/turf.min.js"></script>
<script src=https://cdnjs.cloudflare.com/ajax/libs/mapbox-polyline/1.1.1/polyline.js></script>
<script src=https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.js></script>
<link rel="stylesheet" href=https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.css type="text/css" />
<script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"
integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg="
crossorigin=""></script>
<script>
   var currentLat = 0,currentLong = 0;
   var destinationLat = 0,destinationLong = 0;
   var marker;
   var meMarker;
   
   var mobile = (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));  
   if (mobile) { 
      $("#dvPanelLocations").addClass("modal fade");
      $("#btnOpenSearchModal").show();
      $("#btnClosePanel").show();
   } else { 
      console.log("NOT A MOBILE DEVICE!!");
      $("#dvPanelLocations").addClass("panel-pc");
      $("#btnOpenSearchModal").hide();
      $("#btnClosePanel").hide();
   }
   
 
   function loadLabels() {
      $.ajax({
         url: "../program_assets/php/web/places.php",
         success: function (data) {
            //var data = jQuery.parseJSON(data); 
            
            map.addSource('places', {
               'type': 'geojson',
               'data': data
            });
            
            map.addLayer({
               'id': 'poi-labels',
               'type': 'symbol',
               'source': 'places',
               'layout': {
                   'text-field': ['get', 'description'],
                   'text-variable-anchor': ['top', 'bottom', 'left', 'right'],
                   'text-radial-offset': 0.5,
                   'text-justify': 'auto',
                   'icon-image': ['concat', ['get', 'icon'], '-15'],
                   "text-size": 12
               }
            });
         }
      });
   }
   
   loadSelection('');
   
   $('#txtSearchMap').keyup(function(){
      loadSelection($('#txtSearchMap').val());
   });
   
   function loadSelection(search) {
      $.ajax({
         url: "../program_assets/php/web/mapview.php",
         data: {
             command   : 'display_menu',
             search    : search
         },
         type: 'post',
         success: function (data) {
            var data = jQuery.parseJSON(data);
            var menu = "";
            
            $("#dvSelection").html("");
            console.log(data);
            
            for (var i = 0; i < data.length; i++) {
               curData = data[i];
               
               menu = menu + '' +
               '<div class="row" style="margin-top:2px;" onclick="getDestination(' + curData.id + ',' + "'" + curData.latLong + "'" +')">' +
               '   <div class="col-md-12">' +
               '       <a id="a' + curData.id + '" class="btn btn-primary btn-xs dvbuildings">' + curData.buildingName + '</a>' +
               '   </div>' +
               '</div>';
            }
            
            $("#dvSelection").html(menu);
         }
      });
   }
   
   mapboxgl.accessToken = 'pk.eyJ1IjoicGFnZW50ZSIsImEiOiJjbDc2eW52NTIwcDBlM3hrYWh0MWx2dnM2In0.k5b0sazc7NwabRj1SLiNAA';
   const map = new mapboxgl.Map({
      container: 'map', // container ID
      // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
      style: 'mapbox://styles/pagente/cl95nikva00d114qkhl7tmim4', // style URL
      center: [121.76420468812415,16.936876001648045], // starting position [lng, lat]
      zoom: 18, // starting zoom, 
      maxZoom: 20,
      bearing:12
   });
   
   map.on('style.load', () => {
      map.setFog({}); // Set the default atmosphere style
      loadLabels();
   });
   
   map.on('style.load', function() {
      map.on('click', function(e) {
         var coordinates = e.lngLat;
         console.log(coordinates);
      });
   });
   
   //map.scrollZoom.disable();

   
   $("#btnOpenSearchModal").click(function(){
      $("#txtSearchMap").val('');
      loadSelection('');
      $("#dvPanelLocations").modal();
   });
   
   
   function getDestination(id,location) {
      var [lat,lng] = location.split(',');
      destinationLat = lat;
      destinationLong = lng;
      
      if (mobile) {
         $("#dvPanelLocations").modal("hide");
      }
      
      $(".dvbuildings").removeClass("btn-primary");
      $(".dvbuildings").removeClass("btn-danger");
      $(".dvbuildings").addClass("btn-primary");
      $("#a" + id).removeClass("btn-primary");
      $("#a" + id).addClass("btn-danger");
      
      addMarker(destinationLat,destinationLong);
      getLocation();
   }
   
   function addMarker(lat,lng) {
      if (marker) {
          marker.remove();
      }
      
      const el = document.createElement('div');
      el.className = 'marker';
      el.style.backgroundImage = `url(../photos/finish.png)`;
      el.style.width = `40px`;
      el.style.height = `40px`;
      el.style.backgroundSize = '100%';
      
      
      marker = new mapboxgl.Marker(el)
     .setLngLat([lng,lat])
     .addTo(map);
   }
   
   function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition,showError);
      } else {
        JAlert("Geolocation is not supported by this browser.","red");
      }
   }
    
   function showPosition(position) {
      currentLat = position.coords.latitude;
      currentLong = position.coords.longitude;
      
      //currentLat = 16.93581385427524;
      //currentLong = 121.76395733946919;
      showLocationRealtime();
      
      if (currentLat != 0) {
        calculateRoute();
      } else {
         JAlert("Unable to create route. Please check your GPS connection","red");
      }
   }
   
   
   
   setInterval(function(){
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPositionMe,showError);
      }
   }, 2000);
   
   function showPositionMe(position) {
      currentLat = position.coords.latitude;
      currentLong = position.coords.longitude;
      
      //currentLat = 16.93581385427524;
      //currentLong = 121.76395733946919;
      console.log(currentLat + "," + currentLong);
      showLocationRealtime();
   }
   
   function showLocationRealtime() {
      if (meMarker) {
          meMarker.remove();
      }
      
      const el = document.createElement('div');
      el.className = 'marker';
      el.style.backgroundImage = `url(../photos/user.png)`;
      el.style.width = `40px`;
      el.style.height = `40px`;
      el.style.backgroundSize = '100%';
      
      
      meMarker = new mapboxgl.Marker(el)
     .setLngLat([currentLong,currentLat])
     .addTo(map);
   }
   
   function calculateRoute() {   
      $.get('https://api.mapbox.com/directions/v5/mapbox/driving-traffic/' + currentLong + ',' + currentLat + ';' + destinationLong + ',' + destinationLat + '?access_token=pk.eyJ1IjoicGFnZW50ZSIsImEiOiJjbDc2eW52NTIwcDBlM3hrYWh0MWx2dnM2In0.k5b0sazc7NwabRj1SLiNAA', 
        function( data ) {
            var coords = polyline.decode(data.routes[0].geometry);
            var arrLatLongs = [];
            
            try {
               map.removeLayer('route');
               map.removeSource('route'); 
            } catch(e) {
               //alert(e);
            }
            
            for (var i = 0; i < coords.length; i++) {
               console.log(coords[i][0]);
               
               var currentLatLong = [coords[i][1],coords[i][0]];
               arrLatLongs.push(currentLatLong);
            }
            
            map.addSource('route', {
                  'type': 'geojson',
                  'data': {
                  'type': 'Feature',
                  'properties': {},
                  'geometry': {
                     'type': 'LineString',
                     'coordinates': arrLatLongs
                  }
               }
            });
       
            map.addLayer({
               'id': 'route',
               'type': 'line',
               'source': 'route',
               'layout': {
                  'line-join': 'round',
                  'line-cap': 'round'
               },
               'paint': {
                  'line-color': '#888',
                  'line-width': 3
               }
            });

      });  
   };
    
   function showError(error) {
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
</script>