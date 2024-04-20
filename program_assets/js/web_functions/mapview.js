var latLong = "0,0";
var marker;
var oldBuildingName = ""
var oldBuildingId = 0;
var isNewBuilding = 1;

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

map.on('style.load', function() {
    map.on('click', function(e) {
        var coordinates = e.lngLat;
        latLong = coordinates.lat + "," + coordinates.lng;
        console.log(coordinates);
        addMarker(coordinates.lat,coordinates.lng);
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

function addMarker(lat,lng) {
    if (marker) {
        marker.remove();
    }
    
    marker = new mapboxgl.Marker()
   .setLngLat([lng,lat])
   .addTo(map);
}


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

$("#btnAddBuilding").click(function(){
    $("#txtBuildingName").val("");
    $("#txtLatLong").val("");
    $("#txtNdki").val("");
    oldBuildingName = ""
    oldBuildingId = 0;
    isNewBuilding = 1;
    
    $("#chkActive").prop("checked", true);
    $("#chkActive").prop("disabled", true);
    $("#mdMap").modal();
});

$('#tblBuilding tbody').on('click', 'td button', function (){
	var data = tblBuilding.row( $(this).parents('tr') ).data();
    
    $("#txtBuildingName").val(data.buildingName);
    $("#txtLatLong").val(data.latLong);
    $("#txtNdki").val(data.ndki);
    oldBuildingName = data.buildingName;
    oldBuildingId = data.id;
    isNewBuilding = 0;
    
    $("#chkActive").prop("checked", true);
    $("#chkActive").prop("disabled", false);
    $("#mdMap").modal();
});

$('#tblBuilding tbody').on('click', 'td', function (){
	var data = tblBuilding.row( $(this).parents('tr') ).data();
	addMarker(data.latLong.split(",")[0],data.latLong.split(",")[1]);
});

$("#btnMapShow").click(function(){
	$("#mdMap").modal("hide");
});

$("#btnPasteLatLong").click(function(){
    $("#txtLatLong").val(latLong);
});

$("#btnExportBuilding").click(function(){
	$(".btn-export-building").click();
});

$('#txtSearchBuilding').keyup(function(){
    tblBuilding.search($(this).val()).draw();
});

$("#btnSaveMap").click(function(){
    var buildingName = $("#txtBuildingName").val();
    var latLong      = $("#txtLatLong").val();
    var ndki         = 1;
    var isActive;
    
    if ($("#chkActive").prop('checked') == true) {
        isActive = 1;
    } else {
        isActive = 0;
    }
    
    if (buildingName == "" || latLong == "" || ndki == "") {
        JAlert("Please fill in required fields","red");
    } else {
        $.ajax({
            url: "../program_assets/php/web/mapview",
            data: {
                command   : 'save_building',
                isNewBuilding : isNewBuilding,
                oldBuildingId : oldBuildingId,
                oldBuildingName : oldBuildingName,
                buildingName : buildingName,
                latLong : latLong,
                ndki : ndki,
                isActive : isActive
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
                
                JAlert(data[0].message,data[0].color);
                
                if (!data[0].error) {
                    loadBuilding();
                    
                    map.removeLayer('poi-labels');
                    map.removeSource('places');
                    loadLabels();
                    $("#mdMap").modal("hide");
                    
                    if (marker) {
                        marker.remove();
                    }
                }
            }
        });
    }
});

loadBuilding();

function loadBuilding() {
    tblBuilding = 
    $('#tblBuilding').DataTable({
        'destroy'       : true,
        'paging'        : true,
        'lengthChange'  : false,
        'pageLength'    : 15,
        "order"         : [],
        'info'          : true,
        'autoWidth'     : false,
        'select'        : true,
        'sDom'			: 'Btp<"clear">',
        //dom: 'Bfrtip',
        buttons: [{
            extend: "excel",
            className: "btn btn-default btn-sm hide btn-export-building",
            titleAttr: 'Export in Excel',
            text: 'Export in Excel',
            init: function(api, node, config) {
               $(node).removeClass('dt-button buttons-excel buttons-html5')
            }
        }],
        'fnRowCallback' : function( nRow, aData, iDisplayIndex ) {
            $('td', nRow).attr('nowrap','nowrap');
            return nRow;
        },
        'ajax'          : {
        	'url'       : '../program_assets/php/web/mapview.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_building',
        	}    
        },
        'aoColumns' : [
        	{ mData: 'buildingName'},
            { mData: 'latLong'},
            { mData: 'status'},
            { mData: 'id',
                render: function (data,type,row) {
                    return '' + 
                           '<button type="submit" class="btn btn-default btn-xs dt-button list">' +
                           '	<i class="fa fa-edit"></i>' +
                           '</button>' +
                           '';
                }
            }
        ],
        'aoColumnDefs': [
        	{"className": "custom-center", "targets": [3]},
        	{"className": "dt-center", "targets": [0,1,2]},
        	{ "width": "1%", "targets": [1,2,3] },
        ],
        "drawCallback": function() {  
            row_count = this.fnSettings().fnRecordsTotal();
        },
        "fnInitComplete": function (oSettings, json) {
            //alert('DataTables has finished its initialisation.');
            
            //tblBuilding.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
            //   var data = this.data();
            //   var [lat,lng] = data.latLong.split(',');
            //   
            //   
            //   const popup = new mapboxgl.Popup({ closeOnClick: false,closeButton: false })
            //      .setLngLat([lng, lat])
            //      .setHTML('<label class="cust-label">' + data.buildingName + '</label>')
            //      .addTo(map);
            //});
        }
    }).on('user-select', function (e, dt, type, cell, originalEvent) {
        if ($(cell.node()).parent().hasClass('selected')) {
            e.preventDefault();
        }
    });
}