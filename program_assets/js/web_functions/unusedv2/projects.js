var tblProjects;
var tabStatus = "";
var previousID = 0;
var userID = $("#lblUser").text().trim();

loadProjects(tabStatus);

function loadProjects(filter) {
    tabStatus = filter;
    

    $("#btnStartJob").prop("disabled", true);
    $("#btnCancelJob").prop("disabled", true);
    $("#btnCompleteJob").prop("disabled", true);
    $("#btnHoldJob").prop("disabled", true); 

    tblProjects = 
    $('#tblProjects').DataTable({
        'destroy'       : true,
        'paging'        : true,
        'lengthChange'  : false,
        'pageLength'    : 1000,
        "order"         : [],
        'info'          : true,
        'autoWidth'     : false,
        'select'        : true,
        'sDom'			: 'Btp<"clear">',
        //dom: 'Bfrtip',
        buttons: [{
            extend: "excel",
            className: "btn btn-default btn-sm hide btn-export-quotation",
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
        	'url'       : '../program_assets/php/web/projects.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_projects',
                filter  : tabStatus
        	}    
        },
        'aoColumns' : [
            { mData: 'id',
                render: function (data,type,row) {
                    return '<input class="quotation-check" id="chk' + row.id  + '" name="chk' + row.id  + '" type="checkbox">';
                }
            },
            { mData: 'projectNumber'},
            { mData: 'quotationNumber'},
            { mData: 'poNumber'},
            { mData: 'quotationSubject',
                render: function (data,type,row) {
                    var message;
                    
                    if (row.status == "Cancelled") {
                        message = '<a href="#" onclick="openRemarksModal()">' + row.quotationSubject + '</a>&nbsp;&nbsp;<i class="fa fa-fw fa-commenting-o"></i>';
                    } else {
                        message = row.quotationSubject;
                    }
                    
                    return message;
                }
            },
            { mData: 'clientsName'},
            { mData: 'startDate'},
            { mData: 'endDate'},
            { mData: 'status'},
            { mData: 'fullName'},
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
        	{"className": "custom-center", "targets": [0,10]},
        	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7,8,9,10]},
            //{ "width": "20%", "targets": [4] },
            //{ "width": "9%", "targets": [8] },
        	{ "width": "1%", "targets": [0,1,2,9,10] },
        ],
        "drawCallback": function() {  
            row_count = this.fnSettings().fnRecordsTotal();
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

$('#tblProjects tbody').on('click', 'td button', function (){
	var data = tblProjects.row( $(this).parents('tr') ).data();
    
    $("#spProjectNumber").text(data.projectNumber);
    $("#spQuotationFor").text(data.clientsName);
    $("#spSubject").text(data.quotationSubject);
    $("#spAddress").text(data.address);
    $("#spContactPerson").text(data.contactPerson);
    $("#spContactNumber").text(data.contactNumber);
    $("#spEmailAddress").text(data.emailAddress);
    $("#txtStartDate").val(data.unfStartDate);
    $("#txtEndDate").val(data.unfEndDate);
    $("#txtPONumber").val(data.poNumber);
    
    $("#mdEditProj").modal("show");
});

$('#tblProjects tbody').on('click', 'td', function (){
	var data = tblProjects.row( $(this).parents('tr') ).data();
    
    $('#chk' + previousID).prop('checked', false);
    $('#chk' + data.id).prop('checked', true);
    
    $("#spQuotationFor").text(data.spQuotationFor);
    
    
    var isDisabled = data.unfStartDate == null ? true : false;
    console.log(isDisabled);
    
    $("#btnStartJob").prop("disabled", isDisabled);
    $("#btnCancelJob").prop("disabled", isDisabled);
    $("#btnCompleteJob").prop("disabled", isDisabled);
    $("#btnHoldJob").prop("disabled", isDisabled);
    
    if (userID == data.createdBy && data.status == "Completed") {
        $("#dvCloseProject").show();
    } else {
        $("#dvCloseProject").hide();
    }
    
    previousID = data.id;
    
    setTimeout(function() {
        $("#txtReason").text(data.reason);
    }, 1000);
});

$("#btnSaveProjectDetails").click(function(){
	var startDate = $("#txtStartDate").val();
    var endDate   = $("#txtEndDate").val();
    var poNumber  = $("#txtPONumber").val();
    
    if (startDate == "" || endDate == "" || poNumber == "") {
        JAlert("Provide fill in required fields","red");
    } else {
        $.ajax({
            url: "../program_assets/php/web/projects.php",
            data: {
                command  : 'update_dates',
                startDate : startDate,
                endDate :endDate,
                poNumber : poNumber,
                id : previousID
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
                
                JAlert(data[0].message,data[0].color);
                
                if (!data[0].error) {
                    $("#mdEditProj").modal("hide");
                    loadProjects(tabStatus);
                    previousID = 0;
                }
            }
        });
    }
});
    
$("#btnStartJob").click(function(){
    updateStatus("WIP","");
});

$("#btnCompleteJob").click(function(){
    updateStatus("Completed","");
});

$("#btnHoldJob").click(function(){
    updateStatus("On Hold","");
});

$("#btnCloseJob").click(function(){
	updateStatus("Closed Project","");
});

$("#btnCancelJob").click(function(){
    $("#btnCancel").show();
    $("#txtReason").val("");
    $("#mdRemarks").modal();
});

$("#btnCancel").click(function(){
    var reason = $("#txtReason").val();
    
    if (reason == "") {
        JAlert("Provide a remarks","red");
    } else {
        updateStatus("Cancelled",reason);
    }
});

function updateStatus(status,remarks) {
    $.ajax({
        url: "../program_assets/php/web/projects.php",
        data: {
            command  : 'update_remarks',
            id : previousID,
            status : status,
            reason : remarks
        },
        type: 'post',
        success: function (data) {
            var data = jQuery.parseJSON(data);
            
            JAlert(data[0].message,data[0].color);
            
            if (!data[0].error) {
                $("#mdRemarks").modal("hide");
                loadProjects(tabStatus);
                previousID = 0;
            }
        }
    });
}

function openRemarksModal() {
    $("#btnCancel").hide(); 
	$("#mdRemarks").modal();
}