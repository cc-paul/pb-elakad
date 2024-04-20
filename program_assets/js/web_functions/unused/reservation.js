var tblReservation,tblServices;
var isHomeService,id;

loadReservation();
function loadReservation() {
    tblReservation = 
    $('#tblReservation').DataTable({
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
            className: "btn btn-default btn-sm",
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
        	'url'       : '../program_assets/php/web/display_reservation.php',
        },
        'aoColumns' : [
        	{ mData: 'ref'},
            { mData: 'branchName'},
            { mData: 'therapistName'},
            { mData: 'customer'},
            { mData: 'dateScheduled'},
            { mData: 'timeScheduled'},
            { mData: 'price'},
            { mData: 'status'},
            { mData: 'mobileNumber'},
            { mData: 'remarks'},
            { mData: 'id',
                render: function (data,type,row) {
                    return '<div class="input-group">' + 
                           '	<button id="list_' + row.id + '" name="list_' + row.id + '" type="submit" class="btn btn-default btn-xs dt-button list">' +
                           '		<i class="fa fa-edit"></i>' +
                           '	</button>' +
                           '</div>';
                }
            }
        ],
        'aoColumnDefs': [
        //	{"className": "custom-center", "targets": [8]},
        	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7,8,9]},
        	{ "width": "1%", "targets": [10] },
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
            //alert('DataTables has finished its initialisation.');
        }
    }).on('user-select', function (e, dt, type, cell, originalEvent) {
        if ($(cell.node()).parent().hasClass('selected')) {
            e.preventDefault();
        }
    });
}

$('#txtSearch').keyup(function(){
    tblReservation.search($(this).val()).draw() ;
});

$('#tblReservation tbody').on('click', 'td button', function (){
	var data = tblReservation.row( $(this).parents('tr') ).data();
    
    $("#mdDetails").modal("show");
    
    var driverID = data.driverID;
    
    if (driverID == 0) {
        driverID = null;
    }
    
    $("#spRef").html(data.ref);
    $("#spBranch").html(data.branchName);
    $("#spTherapist").html(data.therapistName);
    $("#spCustomer").html(data.customer);
    $("#spDate").html(data.dateScheduled);
    $("#spTime").html(data.timeScheduled);
    $("#spPrice").html(data.price);
    $("#spStatus").html(data.status);
    $("#spMobileNumber").html(data.mobileNumber);
    $("#txtRemarks").val(data.remarks);
    $("#cmbStatus").val(data.status).trigger("change.select2");
    $("#cmbDriver").val(driverID).trigger("change.select2");
    $("#txtReason").val(data.rejectReason);
    isHomeService = data.isHomeService;
    id = data.id;
    
    if (data.status != "Pending") {
        $("#cmbStatus").prop("disabled", true);
        $("#cmbDriver").prop("disabled", true);
        $("#txtReason").prop("disabled", true);
        $("#btnSaveReserve").prop("disabled", true);
    } else {
        $("#cmbStatus").prop("disabled", false);
        $("#cmbDriver").prop("disabled", false);
        $("#txtReason").prop("disabled", false);
        $("#btnSaveReserve").prop("disabled", true);
    }
    
    tblServices = 
    $('#tblServices').DataTable({
        'destroy'       : true,
        'paging'        : false,
        'lengthChange'  : false,
        'pageLength'    : 100,
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
        	'url'       : '../program_assets/php/web/display_service_reserve.php',
        	'type'      : 'POST',
        	'data'      : {
        		ref : data.ref,
        	}    
        },
        'aoColumns' : [
        	{ mData: 'category'},
            { mData: 'service'},
            { mData: 'price'}
        ],
        'aoColumnDefs': [
        //	{"className": "custom-center", "targets": [8]},
        //	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7]},
        	{ "width": "33.33%", "targets": [0,1,2] },
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
            //alert('DataTables has finished its initialisation.');
        }
    }).on('user-select', function (e, dt, type, cell, originalEvent) {
        if ($(cell.node()).parent().hasClass('selected')) {
            e.preventDefault();
        }
    });
});

$("#cmbStatus").on("change", function() {
    var value = $(this).val();
    var text  = $("#cmbStatus").find("option:selected").text();
    
    if (value == "Pending") {
        $("#btnSaveReserve").prop("disabled", true);
    } else {
        $("#btnSaveReserve").prop("disabled", false);
    }
    
    $("#cmbDriver").val(null).trigger("change.select2");
    $("#txtReason").val(null);
});

$("#btnSaveReserve").click(function(){
    var status       = $("#cmbStatus").val();
    var driver       = $("#cmbDriver").val();
    var rejectReason = $("#txtReason").val();
    
    if (status == "Accepted" && isHomeService == 1 && driver == null) {
        JAlert("Driver is required because it is a Home Service","orange");
    } else if (status == "Rejected" && rejectReason == "") {
        JAlert("Provide a reason why you rejected this","orange");
    } else {
        $.ajax({
            url: "../program_assets/php/web/reservation",
            data: {
                id           : id,
                status       : status,
                driver       : driver,
                rejectReason : rejectReason,
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
                JAlert(data[0].message,"orange");
                
                if (!data[0].error) {
                    loadReservation();
                    $("#cmbStatus").prop("disabled", true);
                    $("#cmbDriver").prop("disabled", true);
                    $("#txtReason").prop("disabled", true);
                    $("#btnSaveReserve").prop("disabled", true);
                }
            }
        });
    }
});