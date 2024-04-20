var tblReports;
var rowId;

loadReports();
loadMap();
function loadReports() {
    tblReports = 
    $('#tblReports').DataTable({
        'destroy'       : true,
        'paging'        : true,
        'lengthChange'  : false,
        'pageLength'    : 20,
        "order"         : [],
        'info'          : true,
        'autoWidth'     : false,
        'select'        : true,
        'sDom'			: 'tp<"clear">', 
        'fnRowCallback' : function( nRow, aData, iDisplayIndex ) {
            $('td', nRow).attr('nowrap','nowrap');
            return nRow;
        },
        'ajax'          : {
        	'url'       : '../program_assets/php/web/incident_display.php',
        	'type'      : 'POST',
        	'data'      : {
        		saving_mode : 'all',
        	}    
        },
        'aoColumns' : [
        	{ mData: 'rid'},
            { mData: 'address'},
            { mData: 'status'},
            { mData: 'id',
                render: function (data,type,row) {
                    return '<div class="input-group">' + 
                           '	<button type="submit" class="btn btn-default btn-xs dt-button">' +
                           '		<i class="fa fa-gear"></i>' +
                           '	</button>' +
                           '</div>';
                }
            }
        ],
        'aoColumnDefs': [
        	{"className": "custom-center", "targets": [3]},
        	{"className": "dt-center", "targets": [0,1,2]},
        	{ "width": "1%", "targets": [0,2] },
        	//{"className" : "hide_column", "targets": [9]} 
        ],
        "drawCallback": function() {  
            row_count = this.fnSettings().fnRecordsTotal();
            $("#spCount").html('<b>' + row_count + '</b>');
        },
        "fnInitComplete": function (oSettings, json) {
            //alert('DataTables has finished its initialisation.');
        }
    }).on('user-select', function (e, dt, type, cell, originalEvent) {
        if ($(cell.node()).parent().hasClass('selected')) {
            e.preventDefault();
        }
    });
}

function loadMap() {
    mapboxgl.accessToken = 'pk.eyJ1IjoicGFnZW50ZSIsImEiOiJja3p6OHF3NjkwN3JuM2lwa21pZmdxcW14In0.C07RU8giyLyFNTjxbLUS5A';
        const map = new mapboxgl.Map({
        center: [121.0502957013811,14.516858847735127],
        zoom: 10,
        pitch: 45,
        bearing: -17.6,
        container: 'map',
        style: 'mapbox://styles/mapbox/satellite-streets-v11',
        antialias: true
    });
}

$('#tblReports tbody').on('click', 'td', function (){
	var data = tblReports.row( $(this).parents('tr') ).data();

    $("#spDateReported").text(data.dateCreated);
    $("#spPhotoTaken").text(data.photoDate);
    $("#spReportedBy").text(data.reportedBy);
    $("#spContacts").text(data.mobileNumber + " / " + data.email);
    $("#pRemarks").html(data.description);
    $('#imgPulubi').attr('src',data.link);
    rowId = data.id;
    
    mapboxgl.accessToken = 'pk.eyJ1IjoicGFnZW50ZSIsImEiOiJja3p6OHF3NjkwN3JuM2lwa21pZmdxcW14In0.C07RU8giyLyFNTjxbLUS5A';
        const map = new mapboxgl.Map({
        center: [121.0502957013811,14.516858847735127],
        zoom: 10,
        pitch: 45,
        bearing: -17.6,
        container: 'map',
        style: 'mapbox://styles/mapbox/satellite-streets-v11',
        antialias: true
    });
    
    setTimeout(function() {
        const el = document.createElement('div');
        el.id = 'marker';   
     
        //const popup = new mapboxgl.Popup({ offset: 25,closeButton: true, closeOnMove: false,closeOnClick: false })
        //.setLngLat([data.long, data.lat])
        //.setHTML(''+ 
        //   '<div style="width : 100%;">' +
        //   '<b>Report # :</b>' + data.id + '<br>' +
        //   '<img style="margin-top:10px;" id="imgProfile" src="' + data.link  + '">' +
        //   '<b>Address</b>' +
        //   '<br>' +
        //   '<label style"width="100%">' + data.address + '</label>' +
        //   '<br>' +
        //   '<div id="line"></div>' +
        //   '<b>Situation</b>' +
        //   '<br>' +
        //   '<label style"width="100%">' + data.description + '</label>' +
        //   '</div>' +
        //   '')
        //.addTo(map);
     
        const marker1 = new mapboxgl.Marker()
        .setLngLat([data.long, data.lat])
        .addTo(map);
        
        map.flyTo({
            center: [
                data.long,
                data.lat
            ],
            essential: true
        });
    }, 1500);
});

$('#tblReports tbody').on('click', 'td button', function (){
	var data = tblReports.row( $(this).parents('tr') ).data();
    
    rowId = data.id;
    $("#modalStatus").modal("show");
});

$("#btnApprove").click(function(){
	setStatus("Approved");
});

$("#btnReject").click(function(){
	setStatus("Rejected");
});

function setStatus(Status) {
    $.ajax({
        url: "../program_assets/php/web/incident_update.php",
        data: {
            rowid  : rowId,
            status : Status,
        },
        type: 'post',
        success: function (data) {
            var data = data.trim();
            
            if (data == 1) {
                tblReports.rows({
                    selected: true
                }).every(function(rowIdx, tableLoop, rowLoop) {
                    tblReports.row(this).cell(rowIdx, 2).data(Status);
                });
                
                $("#modalStatus").modal("hide");
            }
        }
    });
}

$('#txtSearch').keyup(function(){
    if ($("#cmbStatus").val() != null || $("#cmbStatus").val() != "") {
        $("#cmbStatus").val("").trigger('change.select2');
    }
    
    tblReports.search($(this).val()).draw();
});

$("#cmbStatus").on("change", function() {
    if ($("#txtSearch").val() != null || $("#txtSearch").val() != "") {
        $("#txtSearch").val("");
    }
    
    tblReports.search($(this).val()).draw();
});