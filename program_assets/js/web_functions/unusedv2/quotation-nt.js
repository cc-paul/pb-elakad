var tblTaskItem_nt;
var arrTaskNT = [];
var isItem;
var setStatus = "";

$("#btnTaskMaterial-nt").click(function(){
    $("#mdTaskOptions").modal("hide");
	$("#mdTaskMasterial-nt").modal();
    $("#txtTask-nt").val("");
    $("#txtTaskAmount-nt").val("");
    $("#txtTaskDescription-nt").val("");
    isItem = 0;
    currentTaskID = 0;
    arrTaskNT = [];
    loadItemsNT();
    tblTaskItem_nt.clear().draw();
});

function loadItemsNT() {
    tblTaskItem_nt = 
    $('#tblTaskItem_nt').DataTable({
        'destroy'       : true,
        'paging'        : false,
        'lengthChange'  : false,
        'pageLength'    : 1000,
        "order"         : [],
        'info'          : true,
        'autoWidth'     : false,
        'select'        : true,
        'sDom'			: 'tp<"clear">', 
        'fnRowCallback' : function( nRow, aData, iDisplayIndex ) {
            $('td', nRow).attr('nowrap','nowrap');
            return nRow;
        },
        //'ajax'          : {
        //	'url'       : '../program_assets/php/web/delivery_display_delivery.php',
        //	'type'      : 'POST',
        //	'data'      : {
        //		saving_mode : 'all',
        //	}    
        //},
        'aoColumns' : [
        	{ mData: 'description'},
            { mData: 'total'},
            { mData: 'id',
                render: function (data,type,row) {
                    return '<div class="input-group">' + 
                           '	<button id="list_' + row.id + '" name="list_' + row.id + '" type="submit" class="btn btn-default btn-xs dt-button delete_row">' +
                           '		<i class="fa fa-trash"></i>' +
                           '	</button>' +
                           '</div>';
                }
            }
        ],
        'aoColumnDefs': [
        	{"className": "custom-center", "targets": [2]},
        	{"className": "dt-center", "targets": [0,1,2]},
        	{ "width": "1%", "targets": [1,2] },
        	//{"className" : "hide_column", "targets": [9]} 
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
            
            
            if (isNewTask == 0) {
                
                
                $.ajax({
                    url: "../program_assets/php/web/quotation.php",
                    data: {
                        command   : 'get_task_item',
                        projectNumnber : currentProjectNumber
                    },
                    type: 'post',
                    success: function (data) {
                        var data = jQuery.parseJSON(data);
                        var id = 1;
                        tblTaskItem_nt.clear().draw();
                        
                        for (var i = 0; i < data.length; i++) {                            
                            tblTaskItem_nt.row.add({
                                "description" : data[i].itemName,
                                "total" : data[i].total,
                                "id" : id
                            }).draw( false );
                            
                            arrTaskNT.push({
                                "description" : data[i].itemName,
                                "total" : data[i].total.replaceAll(",",""),
                                "id" : id
                            });
                            
                            id++;
                        }
                    }
                });
            }
        }
    }).on('user-select', function (e, dt, type, cell, originalEvent) {
        if ($(cell.node()).parent().hasClass('selected')) {
            e.preventDefault();
        }
    });
}

$("#btnTaskAddItem-nt").click(function(){
    var description = $("#txtTask-nt").val();
    var amount = $("#txtTaskAmount-nt").val();
    var id = Number(tblTaskItem_nt.data().count()) + 1;
    
    if (description == "" || amount == "" || amount < 1) {
        JAlert("Please fill in required fields","red");
    } else {
        
        tblTaskItem_nt.row.add({
            "description" : description,
            "total" : Number(amount).toLocaleString(undefined,{'minimumFractionDigits':2,'maximumFractionDigits':2}).replace(".00",""),
            "id" : id
        }).draw( false );
        
        arrTaskNT.push({
            "description" : description,
            "total" : amount,
            "id" : id
        });
        
        
        console.log(arrTaskNT);
        $("#txtTask-nt").val("");
        $("#txtTaskAmount-nt").val("");
    }
});

$('#tblTaskItem_nt tbody').on( 'click', '.delete_row', function () {
	var data = tblTaskItem_nt.row( $(this).parents('tr') ).data();
	tblTaskItem_nt.row($(this).parents('tr')).remove().draw();
    
    console.log(data);
    
    arrTaskNT = arrTaskNT.filter(function(item) { 
		return item.id !== data.id; 
	});
    
    
    console.log(arrTaskNT);
});

$("#btnSaveProject-nt").click(function(){
	var taskDescription = $("#txtTaskDescription-nt").val();
    var randomNumber = Math.round(Math.random() * 400);
    var projectNumber = isNewTask == 1 ? `${quotationNumber}-${randomNumber}` : currentProjectNumber;
    
    if (arrTaskNT.length == 0 || taskDescription == "") {
        JAlert("Provide project description and/or items","red");
    } else {
        var arrQueryItem = [];
        for (var i = 0; i < arrTaskNT.length; i++) {
            arrQueryItem.push(`('${projectNumber}','${quotationNumber}','0','0','1','${arrTaskNT[i].total}','${arrTaskNT[i].total}','createdBy','dateCreated','${arrTaskNT[i].description}')`);
        }
        
        console.log(arrQueryItem.join(","));
        
        $.ajax({
            url: "../program_assets/php/web/quotation.php",
            data: {
                command : "add_project_nt",
                isNewTask : isNewTask,
                projectNumber : projectNumber,
                queryItems : arrQueryItem.join(","),
                taskDescription : taskDescription,
                quotationNumber : quotationNumber,
                isItem : isItem,
                taskID : currentTaskID
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
                
                JAlert(data[0].message,data[0].color);
                
                if (!data[0].error) {
                    loadProjectDetails();
                    $("#mdTaskMasterial-nt").modal("hide");
                }
            }
        });
    }
});

$("#btnSubmitApproval").click(function(){
	changeQuotationStatus("Are you sure you want to send this quotation for approval?","Requires Approval","");
});

$("#btnApprove").click(function(){
	changeQuotationStatus("Are you sure you want to approve this quotation?","Approved","");
});

$("#btnRevise").click(function(){
    setStatus = "Revise";
    $("#btnSaveQuotationRemarks").show(); 
    $("#lblQuotationTitle").text("Quotation Remarks [For Revision]");
	$("#mdQuotationRemarks").modal();
});

$("#btnCancel").click(function(){
    setStatus = "Cancelled";
    $("#btnSaveQuotationRemarks").show(); 
    $("#lblQuotationTitle").text("Quotation Remarks [For Cancellation]");
	$("#mdQuotationRemarks").modal();
});

$("#btnSaveQuotationRemarks").click(function(){
    var remarks = $("#txtQuotationRemarks").val();
    
    if (remarks.toString().trim().length == 0) {
        JAlert("Please provide a remarks before saving","red");
    } else {
        $.ajax({
            url: "../program_assets/php/web/quotation.php",
            data: {
                command : 'send_for_approval',
                quotationNumber : quotationNumber,
                filter : setStatus,
                remarks : remarks
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
                
                JAlert(data[0].message,data[0].color);
                
                if (!data[0].error) {
                    loadQuotation(tabStatus);
                    $("#mdQuotationRemarks").modal("hide");
                    $("#dvApprovalContainer").prop("hidden", true);
                }
            }
        });
    }
});

function changeQuotationStatus(message,filter,remarks) {
    JConfirm(message + "-blue", () => {
        $.ajax({
            url: "../program_assets/php/web/quotation.php",
            data: {
                command : 'send_for_approval',
                quotationNumber : quotationNumber,
                filter : filter,
                remarks : remarks
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
                
                JAlert(data[0].message,data[0].color);
                
                if (!data[0].error) {
                    loadQuotation(tabStatus);
                    $("#dvApprovalContainer").prop("hidden", true);
                }
            }
        });
    }, () => {
        
    });
}

function openRemarksModal() {
    $("#btnSaveQuotationRemarks").hide(); 
    $("#lblQuotationTitle").text("Quotation Remarks");
	$("#mdQuotationRemarks").modal();
}