var tblClients;
var tblEmployee;

$("#cmbClient").on("change", function() {
    var value = $(this).val();
    var text  = $("#cmbClient").find("option:selected").text();
    
    loadClients(value);
    
    $.ajax({
        url: "../program_assets/php/web/client",
        data: {
            command : 'display_client_profile',
            clientID : value
        },
        type: 'post',
        success: function (data) {
            var data = jQuery.parseJSON(data);
            
            for (var i = 0; i < data.length; i++) {
                data = data[i];
                
                
                $("#txtClientsName").val(data.clientsName);
                $("#txtClientsContactPerson").val(data.contactPerson);
                $("#txtClientsAddress").val(data.address);
                $("#txtClientsContactNumber").val(data.contactNumber);
                $("#txtClientsLandLine").val(data.landLine);
                $("#txtClientsEmailAddress").val(data.emailAddress);
            }
        }
    });
});

loadClients(0);
loadEmployees(0);

function loadClients(clientID) {
    tblClients = 
    $('#tblClients').DataTable({
        'destroy'       : true,
        'paging'        : true,
        'lengthChange'  : false,
        'pageLength'    : 15,
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
        	'url'       : '../program_assets/php/web/client.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_area',
                clientID : clientID
        	}    
        },
        'aoColumns' : [
        	{ mData: 'branchName'},
            { mData: 'address'},
            { mData: 'coordinates'},
        ],
        'aoColumnDefs': [
        //	{"className": "custom-center", "targets": [8]},
        //	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7]},
        	{ "width": "1%", "targets": [0,2] },
        //	{"className" : "hide_column", "targets": [9]} 
        ],
        "drawCallback": function() {  
            row_count = this.fnSettings().fnRecordsTotal();
        },
        //"fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        //	console.log(aData["status"]);
        //	
        //	if (aData["status"] == "Pending") {
        //		count_pending++;
        //	} else if (aData["status"] == "Approved") {
        //		count_approved++;
        //	} else {
        //		count_rejected++;
        //	}
        //},
        "fnInitComplete": function (oSettings, json) {
            console.log('DataTables has finished its initialisation.');
        }
    }).on('user-select', function (e, dt, type, cell, originalEvent) {
        if ($(cell.node()).parent().hasClass('selected')) {
            e.preventDefault();
        }
    });
}

$('#tblClients tbody').on('click', 'td', function (){
	var data = tblClients.row( $(this).parents('tr') ).data();
    loadEmployees(data.id);
});

function loadEmployees(areaID) {
    tblEmployee = 
    $('#tblEmployee').DataTable({
        'destroy'       : true,
        'paging'        : true,
        'lengthChange'  : false,
        'pageLength'    : 15,
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
        	'url'       : '../program_assets/php/web/client.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_assigned_employee',
                areaID : areaID
        	}    
        },
        'aoColumns' : [
        	{ mData: 'userID'},
            { mData: 'firstName'},
            { mData: 'middleName'},
            { mData: 'lastName'},
            { mData: 'mobileNumber'},
            { mData: 'emailAddress'},
            { mData: 'position'}
        ],
        //'aoColumnDefs': [
        //	{"className": "custom-center", "targets": [8]},
        //	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7]},
        //	{ "width": "1%", "targets": [8] },
        //	{"className" : "hide_column", "targets": [9]} 
        //],
        "drawCallback": function() {  
            row_count = this.fnSettings().fnRecordsTotal();
        },
        //"fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        //	console.log(aData["status"]);
        //	
        //	if (aData["status"] == "Pending") {
        //		count_pending++;
        //	} else if (aData["status"] == "Approved") {
        //		count_approved++;
        //	} else {
        //		count_rejected++;
        //	}
        //},
        "fnInitComplete": function (oSettings, json) {
            console.log('DataTables has finished its initialisation.');
        }
    }).on('user-select', function (e, dt, type, cell, originalEvent) {
        if ($(cell.node()).parent().hasClass('selected')) {
            e.preventDefault();
        }
    });
}