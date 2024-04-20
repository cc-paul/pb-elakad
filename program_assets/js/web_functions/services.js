var tblService;
var isNewService;
var oldServiceName = "";
var serviceID = "";

loadServices();

function loadServices() {
    tblService = 
    $('#tblService').DataTable({
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
            className: "btn btn-default btn-sm hide btn-export-service",
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
        	'url'       : '../program_assets/php/web/services.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_service',
        	}    
        },
        'aoColumns' : [
        	{ mData: 'service'},
            { mData: 'status'},
            { mData: 'dateCreated'},
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
        	{"className": "dt-center", "targets": [0,1,2,3]},
        	{ "width": "1%", "targets": [1,2,3] },
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

$("#btnAddService").click(function(){
    isNewService = 1;
    serviceID = 0;
	$("#txtService").val("");
    $("#chkActiveService").prop("checked", true);
    $("#chkActiveService").prop("disabled", true);
    $("#mdAddService").modal();
});

$('#tblService tbody').on('click', 'td button', function (){
	var data = tblService.row( $(this).parents('tr') ).data();
    
    serviceID = data.id;
    isNewService = 0;
    oldServiceName = data.service;
    $("#txtService").val(data.service);
    $("#chkActiveService").prop('checked',data.isActive == 1 ? true : false); 
    $("#chkActiveService").prop("disabled",false);
    $("#mdAddService").modal();
});

$("#btnSaveService").click(function(){
    var service = $("#txtService").val();
    var isActive;
    
    if ($("#chkActiveService").prop('checked') == true) {
        isActive = 1;
    } else {
        isActive = 0;
    }
    
    if (service == "") {
        JAlert("Please fill in required fields","red");
    } else {
        $.ajax({
            url: "../program_assets/php/web/services",
            data: {
                command   : 'save_service',
                serviceID : serviceID,
                isNewService : isNewService,
                oldServiceName : oldServiceName,
                service  : service,
                isActive  : isActive
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
                
                JAlert(data[0].message,data[0].color);
                    
                if (!data[0].error) {
                    loadServices();
                    $("#mdAddService").modal("hide");
                }
            }
        });
    }
});

$("#btnExportService").click(function(){
	$(".btn-export-service").click();
});

$('#txtSearchService').keyup(function(){
    tblService.search($(this).val()).draw();
});