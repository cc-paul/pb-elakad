var marker;
var countLocation = 0;
var countUsers = 0;
var currentMarkers = [];

mapboxgl.accessToken = 'pk.eyJ1IjoicGFnZW50ZSIsImEiOiJjbDc2eW52NTIwcDBlM3hrYWh0MWx2dnM2In0.k5b0sazc7NwabRj1SLiNAA';
const map = new mapboxgl.Map({
   container: 'map', // container ID
   // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
   style: 'mapbox://styles/pagente/cl95nikva00d114qkhl7tmim4', // style URL
   center: [121.76438180667367,16.93736564433911], // starting position [lng, lat]
   zoom: 17.5, // starting zoom, 
   projection: 'globe', // display the map as a 3D globe
   pitch: 50, // pitch in degrees
   bearing: -30, // bearing in degrees
   maxZoom: 20
});
 
map.addControl(new mapboxgl.FullscreenControl()); 
 
map.flyTo({
    center: [121.76441588120497,16.937725590377],
    essential: true // this animation is considered essential with respect to prefers-reduced-motion
});
 
 map.on('style.load', function() {
    map.on('click', function(e) {
        var coordinates = e.lngLat;
        latLong = coordinates.lat + "," + coordinates.lng;
        console.log(coordinates);
        //addMarker(coordinates.lat,coordinates.lng);
    });
    
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
 
function loadLabels() {
   $.ajax({
      url: "../program_assets/php/web/places",
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

loadPeople();

setInterval(function() {
    loadPeople();
}, 5000);
 
function loadPeople() {
    $.ajax({
        url: "../program_assets/php/web/mapview",
        data: {
            command   : 'show_people'
        },
        type: 'post',
        success: function (data) {
            var data = jQuery.parseJSON(data);
            
            if (currentMarkers!==null) {
              for (var i = currentMarkers.length - 1; i >= 0; i--) {
                currentMarkers[i].remove();
              }
            }
            
            countUsers = 0;
            
            for (var i = 0; i < data.length; i++) {
                var [lat,lng] = data[i].currentLatLong.split(',');
                
                const el = document.createElement('div');
                el.className = 'marker';
                el.style.backgroundImage = `url(../photos/user.png)`;
                el.style.width = `30px`;
                el.style.height = `30px`;
                el.style.backgroundSize = '100%';
                
                // create the popup
                const popup = new mapboxgl.Popup({ offset: 25}).setHTML(
                   `
                    <b>Name: </b>`+ data[i].fullName +`<br>
                    <b>Destination: </b>`+ data[i].destination +`<br>
                    <b>Mobile: </b>`+ data[i].mobileNumber +`<br>
                    <b>Address: </b>`+ data[i].completeAddress +`<br>
                    <b>Reason: </b>`+ data[i].reason +`
                   `
                );
                    
                // create DOM element for the marker
                const popup_destination = document.createElement('div');
                popup_destination.id = 'marker';
                
                marker = new mapboxgl.Marker(el)
               .setLngLat([lng,lat])
               .setPopup(popup)
               .addTo(map);
               
               currentMarkers.push(marker);
               
               countUsers++;
            }
            
            $("#hUsers").text(countUsers);
        }
    });
}

loadSelection('');

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
             
            countLocation++;
          }
          
          $("#hLocations").text(countLocation);
       }
    });
}