<?php
	if(!isset($_SESSION)) { session_start(); } 
	if (!isset($_SESSION['visitorsID'])) {
		header( "Location: home" );
	}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>E-Lakad | Campus Map</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
        <link href="https://api.mapbox.com/mapbox-gl-js/v2.9.2/mapbox-gl.css" rel="stylesheet">
        <link href="../program_assets/css/map_styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css" type="text/css">
        <style>
            * {
                font-size: 13px;
            }
            
            .aSelection {
               color: #636464;
               text-decoration: unset !important;
               text-decoration-line: unset;
               text-decoration-thickness: unset;
               text-decoration-style: unset;
               text-decoration-color: unset;
               cursor: pointer;
            }
            
            .aWrap {
               text-overflow: ellipsis;
               display: inline-block;
               overflow: hidden;
               width: 147px;
               white-space: nowrap;
               vertical-align: middle;
            }
            
            .directions-icon {
               width: 0px !important;
               height: 0px !important;
               visibility: hidden !important;
            }
            
            .aWhite {
               color : #ffffff;
            }
            
            .aWhite:hover {
               color : #ffffff;
            }
				
				.map-container {
					height: 100%;
					width: 100%;
					position: relative;
				}
				
				.button-me {
					background: #fff;
					z-index: 2;
					position: absolute;
					height: 60px;
					width: 60px;
					bottom: 0;
					right: 0;
					margin: 20px;
					border-radius: 50%;
				}
        </style>
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom bg-light">E-Lakad</div>
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3">
                        <div class="row">
                           <div class="col-md-12 col-xs-12">
                              <div class="form-group">
                                 <label for="exampleInputEmail1">Office or Building Name</label>
                                 <input type="text" class="form-control" id="txtSearchMap" aria-describedby="emailHelp" placeholder="Search here..." />
                                 <small id="emailHelp" class="form-text text-muted">List of offices within the campus. Select one for location</small>
                              </div>
                           </div>
                        </div>
                        <br>
                        <div id="dvSelection">
                           
                        </div>
                    </a>
                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper" style="overflow: hidden;">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                    <div class="container-fluid">
                        <button class="btn btn-primary" id="sidebarToggle" name="sidebarToggle">Close Locations</button>
								<label id="lblVisitorID" hidden>
                     
									<?php
										$visitorID = generateRandomString();
									
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
										
										echo $_COOKIE['visitorID'];
									?>
									
								</label>
								<input type="text" class="form-control" id="txtLatLong" name="txtLatLong" aria-describedby="emailHelp" style="visibility: hidden; width: 0px;" placeholder="Search here..." />
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                                <li class="nav-item active">
                                    <a class="nav-link" href="#" onClick="logMeOut();">Log Out</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                
               <div style="width:120%; height:100%; overflow: auto;">
						<div id="map" class="map-container">
							 
						</div>
						<div class="button-me">
							<center>
								<img src="../photos/user.png"/ style="margin-top: 19%; cursor:pointer;">
							</center>
						</div>
					</div>
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="../bower_components/jquery/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
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
        <script src="../program_assets/js/web_functions/mapbox_directions.js?random=<?php echo uniqid(); ?>"></script>
		  <script src='https://unpkg.com/@turf/turf@6/turf.min.js'></script>
		  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmfVB9M_z_Uu7aW-Nm89gY1owbcGMp3-0"></script>
		  <script src="https://richardcornish.github.io/jquery-geolocate/js/jquery-geolocate.min.js"></script>
    </body>
</html>
<script>
   var startLat,startLong;
   var destinationLat = 0,destinationLong = 0;
   var marker,Roadmarker;
   var meMarker;
   var currentLat = 0,currentLong = 0;
   var directions;
   var oldID = 0;
	var isSideBarOpen = true;
	var currentBuildingName = "",finalBuildingName = "";
	
	localStorage.setItem("currentLat", currentLat);
	localStorage.setItem("currentLong", currentLong);
	
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		isSideBarOpen = false;
	}
	
	if (isSideBarOpen) {
		$("#sidebarToggle").html("Open Locations");
	} else {
		$("#sidebarToggle").html("Close Locations");
	}
	
	window.addEventListener("DOMContentLoaded", (event) => {
        // Toggle the side navigation
        const sidebarToggle = document.body.querySelector("#sidebarToggle");
        if (sidebarToggle) {
            // Uncomment Below to persist sidebar toggle between refreshes
            // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
            //     document.body.classList.toggle('sb-sidenav-toggled');
            // }
				
            sidebarToggle.addEventListener("click", (event) => {
                event.preventDefault();
                document.body.classList.toggle("sb-sidenav-toggled");
                localStorage.setItem("sb|sidebar-toggle", document.body.classList.contains("sb-sidenav-toggled"));
            });
        }
   });
   
   mapboxgl.accessToken = 'pk.eyJ1IjoicGFnZW50ZSIsImEiOiJjbDc2eW52NTIwcDBlM3hrYWh0MWx2dnM2In0.k5b0sazc7NwabRj1SLiNAA';
   const map = new mapboxgl.Map({
      container: 'map', // container ID
      // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
      style: 'mapbox://styles/pagente/cl95nikva00d114qkhl7tmim4',// style URL
      //style: 'mapbox://styles/mapbox/streets-v9',
      center: [121.76441588120497,16.937725590377], // starting position [lng, lat]
      zoom: 17, // starting zoom, 
      maxZoom: 20,
      bearing:12,
		pitch: 45
   });
	
	map.flyTo({
		center: [121.76441588120497,16.937725590377],
		essential: true // this animation is considered essential with respect to prefers-reduced-motion
	});
   
   map.addControl(
      directions = new MapboxDirections({
         accessToken: mapboxgl.accessToken,
         unit: "metric",
         profile: "mapbox/walking",
         alternatives: true,
         geometries: true,
         voice_instructions: true,
         controls: {
            inputs: false,
            instructions: false,
            profileSwitcher: false
         },
         flyTo: false,
         interactive: false,
         attributionControl: false
      }),
      'top-left'
   );
   
   map.on('style.load', function() {
      map.on('click', function(e) {
         var coordinates = e.lngLat;
			$("#txtLatLong").val(coordinates.lat + "," + coordinates.lng);
			console.log(coordinates.lat + "," + coordinates.lng);
      });
		
      map.setFog({}); // Set the default atmosphere style
      loadLabels();
		
		const layers = map.getStyle().layers;
		const labelLayerId = layers.find(
			 (layer) => layer.type === 'symbol' && layer.layout['text-field']
		).id;
		
		// The 'building' layer in the Mapbox Streets
		// vector tileset contains building height data
		// from OpenStreetMap.
		map.addLayer({
				  'id': 'add-3d-buildings',
				  'source': 'composite',
				  'source-layer': 'building',
				  'filter': ['==', 'extrude', 'true'],
				  'type': 'fill-extrusion',
				  'minzoom': 15,
				  'paint': {
						'fill-extrusion-color': '#aaa',
		
						// Use an 'interpolate' expression to
						// add a smooth transition effect to
						// the buildings as the user zooms in.
						'fill-extrusion-height': [
							 'interpolate',
							 ['linear'],
							 ['zoom'],
							 15,
							 0,
							 15.05,
							 ['get', 'height']
						],
						'fill-extrusion-base': [
							 'interpolate',
							 ['linear'],
							 ['zoom'],
							 15,
							 0,
							 15.05,
							 ['get', 'min_height']
						],
						'fill-extrusion-opacity': 0.6
				  }
			 },
			 labelLayerId
		);
   });
	
	
   $(".mapboxgl-ctrl-top-left").hide();
   
	if (isSideBarOpen) {
		$("#sidebarToggle").html("Close Locations");
	} else {
		$("#sidebarToggle").html("Open Locations");
	}
	
	$("#sidebarToggle").click(function(){
		isSideBarOpen = !isSideBarOpen;
		
		if (isSideBarOpen) {
         $("#sidebarToggle").html("Close Locations");
      } else {
			$("#sidebarToggle").html("Open Locations");
		}
	});
	
	function logMeOut() {
		$.ajax({
			url: "../program_assets/php/web/mapview.php",
			data: {
				command   : 'log_me_out',
				visitorsID : $("#lblVisitorID").text().trim()
			},
			type: 'post',
			success: function (data) {
				var data = jQuery.parseJSON(data);
				
				if (!data[0].error) {
					window.location.href = "../pages/signout2.php";
            }
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
               '<div id="dv' + curData.id + '" class="row" style="margin-top:2px;" onclick="getDestination(' + curData.id + ',' + "'" + curData.latLong + "'" + ',' + "'" + curData.buildingName.replace("'", "") + "'" +')">' +
               '   <div class="col-md-12"><img src="   https://cdn-icons-png.flaticon.com/512/854/854901.png " width="18" height="18" alt="" title="" class="img-small">' +
               '       <a id="a' + curData.id + '" class="btn-xs aSelection dvbuildings aWrap" title="' + curData.buildingName + '">' + curData.buildingName + '</a>' +
               '   </div>' +
               '</div>';
            }
            
            $("#dvSelection").html(menu);
         }
      });
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
   
   function getDestination(id,location,buildingName) {
      var [lat,lng] = location.split(',');
      destinationLat = lat;
      destinationLong = lng;
		currentBuildingName = buildingName;
      
      $("#dv" + oldID).removeClass("btn btn-primary");
      $("#dv" + id).addClass("btn btn-primary");
      $("#a" + oldID).removeClass("aWhite");
      $("#a" + id).addClass("aWhite");
      oldID = id;
      
      addMarker(destinationLat,destinationLong);
		
		map.flyTo({
			center: [destinationLong,destinationLat],
			essential: true // this animation is considered essential with respect to prefers-reduced-motion
		});
   }
   
   function getDirections() {
		directions.setOrigin([currentLong,currentLat]); 
		directions.setDestination([destinationLong,destinationLat]);
		
		setTimeout(function() {
			currentLat = localStorage.getItem('currentLat');
			currentLong = localStorage.getItem('currentLong');
			finalBuildingName = currentBuildingName; 
			
			createMeMarker(currentLat,currentLong);
		}, 500);
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
      
      // create the popup
      const popup = new mapboxgl.Popup({ offset: 25}).setHTML(
         '<a tabindex="-1"  href="#" onclick="getDirections()">Get my Direction</a>'
      );
          
      // create DOM element for the marker
      const popup_destination = document.createElement('div');
      popup_destination.id = 'marker';
      
      marker = new mapboxgl.Marker(el)
     .setLngLat([lng,lat])
     .setPopup(popup)
     .addTo(map);
     
      $(".marker").click();
   }

	navigator.geolocation.getCurrentPosition(position => {
		const { latitude, longitude } = position.coords;
		currentLat = latitude;
		currentLong = longitude;
	});
	
	$(".button-me").click(function(){
		map.flyTo({
			center: [currentLong,currentLat],
			essential: true
		});
		
		$("#txtLatLong").val(currentLat+ "," + currentLong);
		
		createMeMarker(currentLat,currentLong);
	});
	
	setInterval(function(){ 
		navigator.geolocation.getCurrentPosition(successCallback,errorCallback,options);
	}, 3000);
	
	function successCallback(position) {
		const { latitude, longitude } = position.coords;
		currentLat = latitude;
		currentLong = longitude;
		
		console.log(currentLat);
		
		if (localStorage.getItem("currentLat") != 0) {
			getDirections();
      }
		
		if (finalBuildingName != "") {
			$.ajax({
				url: "../program_assets/php/web/mapview.php",
				data: {
					command   : 'update_location_admin',
					visitorsID : $("#lblVisitorID").text().trim(),
					latLong   : currentLat + "," + currentLong,
					buildingName : finalBuildingName
				},
				type: 'post',
				success: function (data) {
					//var data = jQuery.parseJSON(data);
					
					
				}
			});
      }
   }
	
	function errorCallback(error) {
		
   }
	
	var options = {
		enableHighAccuracy: true,
		timeOut: 5000,
		maximumAge: 0
	}
	
	function createMeMarker(lat,long) {
		var finalDistance = null;
		
		if (meMarker) {
			meMarker.remove();
		}
		
		currentLat = lat;
		currentLong = long;
		
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
</script>
