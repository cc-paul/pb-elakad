var tblQuotation;
var tblTaskItem;
var quotationID;
var previousID = 0;
var userID = $("#lblUser").text().trim();
var engineerID;
var createdBy;
var isNewQuotation;
var quotationNumber;
var arrTaskItem = [];
var isNewTask;
var isItem;
var currentProjectNumber;
var currentTaskID;
var currentFilter;
var currentStatus;
var tabStatus = "";

loadQuotation(tabStatus);

function loadQuotation(filter) {
    previousID = 0;
    tabStatus = filter;
    currentFilter = filter;
    
    tblQuotation = 
    $('#tblQuotation').DataTable({
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
        	'url'       : '../program_assets/php/web/quotation.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_quotation',
                filter  : filter
        	}    
        },
        'aoColumns' : [
            { mData: 'id',
                render: function (data,type,row) {
                    return '<input class="quotation-check" id="chk' + row.id  + '" name="chk' + row.id  + '" type="checkbox">';
                }
            },
            { mData: 'quotationNumber'},
            { mData: 'revisionNumber'},
            { mData: 'quotationSubject',
                render: function (data,type,row) {
                    var message;
                    
                    if (row.status == "Cancelled" || row.status == "Revise") {
                        message = '<a href="#" onclick="openRemarksModal()">' + row.quotationSubject + '</a>&nbsp;&nbsp;<i class="fa fa-fw fa-commenting-o"></i>';
                    } else {
                        message = row.quotationSubject;
                    }
                    
                    return message;
                }
            },
            { mData: 'clientsName'},
            { mData: 'quotationDate'},
            { mData: 'inCharge'},
            { mData: 'status'},
            { mData: 'dateCreated'}
        ],
        'aoColumnDefs': [
        	{"className": "custom-center", "targets": [0]},
        	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7,8]},
            { "width": "20%", "targets": [4] },
            { "width": "9%", "targets": [8] },
        	{ "width": "1%", "targets": [0,1,2,5,6] },
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

$("#btnAddQuotation").click(function(){
    isNewQuotation = 1;
    $("#cmbClient").val(null).trigger("change");
    $("#cmbEngineer").val(null).trigger("change");
    $("#txtQuotationSubject").val(null);
    $("#btnSaveQuotation").prop("disabled", false);
    $("#btnNewQuotation").prop("disabled", true);
    $("#mdQuotation").modal("show");
});

$("#btnSaveQuotation").click(function(){
    var clientID = $("#cmbClient").val();
    var engineerID = $("#cmbEngineer").val();
    var quotationSubject = $("#txtQuotationSubject").val();
    
    if (clientID == null || engineerID == null || quotationSubject == "") {
        JAlert("Please fill in required fields","red");
    } else {
        $.ajax({
            url: "../program_assets/php/web/quotation.php",
            data: {
                command : 'add_quotation',
                isNewQuotation : isNewQuotation,
                clientID : clientID,
                engineerID : engineerID,
                quotationSubject : quotationSubject,
                id : previousID
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
            
                JAlert(data[0].message,data[0].color);
                
                if (!data[0].error) {
                    $("#mdQuotation").modal("hide");
                    loadQuotation(tabStatus);
                    previousID = 0;
                }
            }
        });
    }
});

$('#tblQuotation tbody').on('click', 'td', function (){
	var data = tblQuotation.row( $(this).parents('tr') ).data();
    engineerID = data.engineerID;
    
    console.log(userID + " " + engineerID);
    
    $('#chk' + previousID).prop('checked', false);
    $('#chk' + data.id).prop('checked', true);
    previousID = data.id;
    createdBy = data.createdBy;
    isNewQuotation = 0;
    quotationNumber = data.quotationNumber;
    currentStatus = data.status;
    
    $("#spClientName").text(data.clientsName);
    $("#spClientAddress").text(data.address);
    $("#spClientContactPerson").text(data.contactPerson);
    $("#spClientEmailAddress").text(data.emailAddress);
    $("#spClientMobileNumber").text(data.contactNumber);
    $("#spClientLandline").text(data.landLine);
    $("#spQuotationSubject").text(data.quotationSubject);
    $("#spQuotationNumber").text(data.quotationNumber);
    $("#txtQuotationDate").val(data.unfquotationDate);
    
    $("#cmbClient").val(data.clientID).trigger("change");
    $("#cmbEngineer").val(data.engineerID).trigger("change");
    $("#txtQuotationSubject").val(data.quotationSubject);
    
    /* Quotation Details with Items */
    $("#spQuotationRef").text(data.quotationNumber);
    $("#spClientName-item").text(data.clientsName);
    $("#spClientAddress-item").text(data.address);
    $("#spClientContactPerson-item").text(data.contactPerson);
    $("#spClientEmailAddress-item").text(data.emailAddress);
    $("#spClientMobileNumber-item").text(data.contactNumber);
    $("#spClientLandline-item").text(data.landLine);
    $("#spQuotationSubject-item").text(data.quotationSubject);
    $("#spQuotationDate-item").text(data.quotationDate);
    $("#txtQuotationRemarks").val(data.remarks);
    $("#spRevisionNumber-item").text(data.revisionNumber);
    
    var isEnableUpdateQuotation,isEnableCreateTask,isEnableSaveQuotation,isSendForApproval,isEnableApproval;
    
    /* Disable once the status != '' (eg. Other staus)*/
    isEnableUpdateQuotation = data.status == '' || data.status == 'For Quotation' ? false : true;
    isEnableSaveQuotation = isEnableUpdateQuotation;
    isSendForApproval = (data.status == '' || data.status == 'Revise' || data.status == 'For Quotation') && userID == engineerID  && data.totalItems != 0  && data.quotationDate != null ? false : true;
    isEnableApproval = (data.status == 'Requires Approval') && data.createdBy == userID ? false : true;
    
    /* Disable create task once the userID != engineerID  AND status == '' OR 'Revise' */
    if (userID == engineerID) {
        if (data.status == "" || data.status == "Revise" || data.status == "For Quotation") {
            isEnableCreateTask = false;
        } else {
            isEnableCreateTask = true;
        }
    } else {
        isEnableCreateTask = true;
    }
    
    $("#btnUpdateQuotation").prop("disabled", isEnableUpdateQuotation);
    $("#btnCreateTask").prop("disabled", isEnableCreateTask);
    $("#btnSaveQuotation").prop("disabled", isEnableSaveQuotation);
    $("#btnSubmitApproval").prop("disabled", isSendForApproval);
    $("#dvApprovalContainer").prop("hidden", isEnableApproval);
    $("#btnNewQuotation").prop("disabled", false);
});

$("#btnNewQuotation").click(function(){
    if (previousID == 0) {
        JAlert("Please select a quotation details","red");
    } else {
        if (userID != createdBy) {
            $("#mdQuotationDetails").modal("show");
        } else {
            $("#mdQuotation").modal("show");
        }
    }
});

$("#btnUpdateQuotation").click(function(){
	var quotationDate = $("#txtQuotationDate").val();
    
    if (quotationDate == "" || quotationDate == null) {
        JAlert("Please provide quotation date","red");
    } else {
        $.ajax({
            url: "../program_assets/php/web/quotation.php",
            data: {
                command : 'update_quotation_date',
                id : previousID,
                quotationDate : quotationDate
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
            
                JAlert(data[0].message,data[0].color);
                
                if (!data[0].error) {
                    $("#mdQuotationDetails").modal("hide");
                    loadQuotation(tabStatus);
                    previousID = 0;
                }
            }
        });
    }
});

$("#btnViewEdit").click(function(){
    if (previousID == 0) {
        JAlert("Please select a quotation details","red");
    } else {
        $("#mdQuotationDetailsItem").modal("show");
        loadProjectDetails()
    }
});

function loadProjectDetails() {
    $.ajax({
        url: "../program_assets/php/web/quotation_projects.php",
        data: {
            quotationNumber   : quotationNumber,
        },
        type: 'post',
        success: function (data) {
            var data = jQuery.parseJSON(data);
            var body = "";
            var total = 0;
            var isEnabled = "disabled";
            
            $("#dvProjects").html("");
            
            var header = data["result"];
            
            if (userID == engineerID) {
                if (currentStatus == "" || currentStatus == "Revise" || currentStatus == "For Quotation") {
                    isEnabled = "";
                }
            }
            
            //if (header.length == 0) {
            //    $("#btnSubmitApproval").prop("disabled", true);
            //} else {
            //    $("#btnSubmitApproval").prop("disabled", false); 
            //}
            
            for (var i = 0; i < header.length; i++) {
                
                total = total +  Number(header[i].total.replaceAll(",",""));
                
                body = body + '' +
                '<div class="row">' +
                '    <div class="col-md-12">' +
                '        <div class="box">' +
                '            <div class="box-header">' +
                '                <label class="cust-label">Project Description: &nbsp;</label>' +
                '                <span class="cust-label">' + header[i].projectDescription + '</span>' +
                '            </div>' +
                '            <div class="box-body no-padding">' +
                '                <table class="table table-bordered cust-label" style="width: 100%">' +
                '                    <tr style="background-color: #f9f9f9;">' +
                '                        <th style="width: 150px;">Brand</th>' +
                '                        <th style="width: 87px;">Item Code</th>' +
                '                        <th style="width: 363px;">Description</th>' +
                '                        <th style="width: 52px;">Qty</th>' +
                '                        <th style="width: 52px;">UOM</th>' +
                '                        <th style="width: 80px;">Unit Price</th>' +
                '                        <th style="width: 90px;">Total Price</th>' +
                '                    </tr>';
                
                
                var items = header[i].items;
                
                for (var a = 0; a < items.length; a++) {
                    body = body + '' +
                    '<tr>' +
                    '    <td>' + items[a].suppliersName + '</td>' +
                    '    <td>' + items[a].itemCode + '</td>' +
                    '    <td>' + items[a].description + '</td>' +
                    '    <td>' + items[a].qty + '</td>' +
                    '    <td>' + items[a].uom + '</td>' +
                    '    <td>' + items[a].price + '</td>' +
                    '    <td>' + items[a].total + '</td>' +
                    '</tr>';
                }
                
                
                body = body + '' +
                '                    <tr>' +
                '                        <td colspan=7>' +
                '                            <button type="button" class="btn btn-default btn-xs cust-textbox" onclick="editCurrentTask('+ header[i].id +','+ header[i].isItem + ',' + "'" + header[i].projectDescription  + "'" + ',' + "'" + header[i].projectNumber  + "'" + ')" '+ isEnabled +'>' +
                '                                &nbsp;' +
                '                               &nbsp;' +
                '                                &nbsp;' +
                '                                <i class="fa fa-edit"></i>' +
                '                                &nbsp;' +
                '                                Edit Current Task' +
                '                                &nbsp;' +
                '                                &nbsp;' +
                '                                &nbsp;' +
                '                            </button>' +
                 '                            <button type="button" class="btn btn-default btn-xs cust-textbox" onclick="deleteCurrentTask('+ header[i].id +')" '+ isEnabled +'>' +
                '                                &nbsp;' +
                '                               &nbsp;' +
                '                                &nbsp;' +
                '                                <i class="fa fa-trash"></i>' +
                '                                &nbsp;' +
                '                                Delete Current Task' +
                '                                &nbsp;' +
                '                                &nbsp;' +
                '                                &nbsp;' +
                '                            </button>' +
                '                            <div class="pull-right" style="margin-top: 8px;">' +
                '                                <label class="cust-label">Sub Total:&nbsp;</label>' +
                '                                <span class="cust-label">' + header[i].total + '</span>' +
                '                            </div>' +
                '                        </td>' +
                '                    </tr>' +
                '                </table>' +
                '            </div>' +
                '        </div>' +
                '    </div>' +
                '</div>';
            
            }
            
            console.log(total);
            
            $("#dvProjects").append(body);
           
            var tax = total * 0.12;
            var grandTotal = total + tax;
           
            $("#spQutationTotal").text(total.toLocaleString(undefined,{'minimumFractionDigits':2,'maximumFractionDigits':2}).replace(".00",""));
            $("#spQutation12").text(tax.toLocaleString(undefined,{'minimumFractionDigits':2,'maximumFractionDigits':2}).replace(".00",""));
            $("#spQutationGTotal").text(grandTotal.toLocaleString(undefined,{'minimumFractionDigits':2,'maximumFractionDigits':2}).replace(".00",""));
        }
    });
}

$("#btnCreateTask").click(function(){
    isNewTask = 1;
	$("#mdTaskOptions").modal();
});

$("#btnTaskMaterial").click(function(){
    $("#mdTaskOptions").modal("hide");
	$("#mdTaskMasterial").modal();
    
    $("#txtTaskDescription").val(null);
    $("#cmbTaskProduct").val(null);
    $("#cmbTaskProductSupplier").val(null);
    $("#txtTaskQty").val(null);
    $("#txtTaskTotal").val(null);
    $("#txtTaskQty").prop("disabled", true);
    
    currentTaskID = 0;
    isItem = 1;
    arrTaskItem = [];
    initTableTaskItem();
    tblTaskItem.clear().draw();
});

function initTableTaskItem() {
    tblTaskItem = 
    $('#tblTaskItem').DataTable({
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
        	{ mData: 'supplier'},
            { mData: 'item'},
            { mData: 'qty'},
            { mData: 'price'},
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
        	{"className": "custom-center", "targets": [5]},
        	{"className": "dt-center", "targets": [0,1,2,3,4,5]},
        	{ "width": "1%", "targets": [0,2,3,4,5] },
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
                        
                        for (var i = 0; i < data.length; i++) {
                            tblTaskItem.row.add({
                                "supplier" : data[i].supplier,
                                "item" : data[i].itemName,
                                "qty" : data[i].qty,
                                "price" : data[i].price,
                                "total" : data[i].total,
                                "itemID" : data[i].itemID
                            }).draw( false );
                            
                            arrTaskItem.push({
                                "supplierID" : data[i].supplierID,
                                "itemID" : data[i].itemID,
                                "qty" : data[i].qty,
                                "price" : data[i].price.replaceAll(",",""),
                                "total" : data[i].total.replaceAll(",",""),
                                "isNew" : 1
                            });
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

function editCurrentTask(id,isItem,projectDescription,projectNumber) {
    isNewTask = 0;
    currentProjectNumber = projectNumber;
    
    if (isItem == 1) {
        $("#btnTaskMaterial").click();
        $("#txtTaskDescription").val(projectDescription);
    } else {
        $("#btnTaskMaterial-nt").click();
        $("#txtTaskDescription-nt").val(projectDescription);
    }
    
    currentTaskID = id;
}

function deleteCurrentTask(id) {
    JConfirm("Are you sure you want to remove this task?-orange", () => {
        $.ajax({
            url: "../program_assets/php/web/quotation.php",
            data: {
                command : 'delete_task',
                id : id
            },
            type: 'post',
            success: function (data) {
                loadProjectDetails();
            }
        });
    }, () => {
        
    });
}


//$("#mdTaskMasterial").modal();

$("#cmbTaskProduct").on("change", function() {
    var selected_value = $(this).val();
    var selected_text  = $("#cmbTaskProduct").find("option:selected").text();
    
    $("#txtTaskQty").val("");
    $("#txtTaskTotal").val("");
    loadItemSupplierSelect(selected_value);
});

$("#cmbTaskProductSupplier").on("change", function() {
    $("#txtTaskQty").val("");
    $("#txtTaskTotal").val("");
    $("#txtTaskQty").prop("disabled", false); 
});

$('#txtTaskQty').on('input',function(e){
    var currentValue = $("#cmbTaskProductSupplier").find("option:selected").text();
    var currentQty   = $("#txtTaskQty").val();
    
    var [supplier,currentPrice] = currentValue.split(' : ');
    currentPrice = currentPrice.replaceAll(",","");
    
    var total = currentPrice * currentQty;
    
    $("#txtTaskTotal").val(total.toLocaleString());
});

$("#btnTaskAddItem").click(function(){
    var rowSupplierAndPrice = $("#cmbTaskProductSupplier").find("option:selected").text();
    var [currentSupplier,currentPrice] = rowSupplierAndPrice.split(' : ');
    
    var currentValue = $("#cmbTaskProductSupplier").find("option:selected").text();
    var supplierID = $("#cmbTaskProductSupplier").val();
    var itemID = $("#cmbTaskProduct").val();
    var itemName = $("#cmbTaskProduct").find("option:selected").text();
    var [currentItemCode,currentItemName] = itemName.split(' - ');
    var qty = $("#txtTaskQty").val();
    var price = currentPrice;
    var total = $("#txtTaskTotal").val();
    var brandName = $("#cmbTaskProduct").find(':selected').attr('data-brand');
    
    console.log(brandName);
    
    if (total == "" || total == null || total == 0) {
        JAlert("Please provide proper item and computation","red");
    } else {
        
        
        if (in_array(arrTaskItem,itemID)) {
            JAlert("Item already exist","red");
        } else {
            tblTaskItem.row.add({
                "supplier" : brandName ,
                "item" : currentItemName,
                "qty" : qty,
                "price" : price,
                "total" : total,
                "itemID" : itemID
            }).draw( false );
            
            arrTaskItem.push({
                "supplierID" : supplierID,
                "itemID" : itemID,
                "qty" : qty,
                "price" : price.replaceAll(",",""),
                "total" : total.replaceAll(",",""),
                "isNew" : 1
            });
            
            console.log(arrTaskItem);
            
            $("#cmbTaskProduct").val("").trigger("change");
            $("#cmbTaskProductSupplier").val("").trigger("change");
        }
    }
});

$("#btnSaveProject").click(function(){
    var taskDescription = $("#txtTaskDescription").val();
    var randomNumber = Math.round(Math.random() * 400);
    var projectNumber = isNewTask == 1 ? `${quotationNumber}-${randomNumber}` : currentProjectNumber;
    
    if (arrTaskItem.length == 0 || taskDescription == "") {
        JAlert("Provide project description and/or items","red");
    } else {
        var arrQueryItem = [];
        for (var i = 0; i < arrTaskItem.length; i++) {
            arrQueryItem.push(`('${projectNumber}','${quotationNumber}','${arrTaskItem[i].supplierID}','${arrTaskItem[i].itemID}','${arrTaskItem[i].qty}','${arrTaskItem[i].price}','${arrTaskItem[i].total}','createdBy','dateCreated','')`);
        }
        
        console.log(arrQueryItem.join(","));
        
        $.ajax({
            url: "../program_assets/php/web/quotation.php",
            data: {
                command : "add_project",
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
                    $("#mdTaskMasterial").modal("hide");
                }
            }
        });
    }
});


$('#tblTaskItem tbody').on( 'click', '.delete_row', function () {
	var data = tblTaskItem.row( $(this).parents('tr') ).data();
	tblTaskItem.row($(this).parents('tr')).remove().draw();

    
    arrTaskItem = arrTaskItem.filter(function(item) { 
		return item.itemID !== data.itemID; 
	});
});

function in_array(array, id) {
    for(var i=0;i<array.length;i++) {
        
        console.log(array[i].itemID + " -- " + id);
        
        if (array[i].itemID == id) {
            return true;
        }
    }
    return false;
}

function loadItemSupplierSelect(itemID) {
    
    $.ajax({
        url: "../program_assets/php/web/quotation.php",
        data: {
            itemID : itemID == null ? 0 : itemID,
            command : 'select_supplier',
        },
        type: 'post',
        success: function (data) {
            var data = jQuery.parseJSON(data);
            
            document.getElementById("cmbTaskProductSupplier").options.length = 0;
            
            $('#cmbTaskProductSupplier').append($('<option>', {
                value: "",
                text: "-- Please select a Supplier --",
                selected: true,
                disabled: true
            }));
            
            if (data.length != 0) {
                for (var i = 0; i < data.length; i++) {
                    $('#cmbTaskProductSupplier').append($('<option>', {
                        value: data[i].id,
                        text: data[i].suppliersName
                    }));
                }
            } else {
                $("#txtTaskQty").val(null);
                $("#txtTaskTotal").val(null);
                $("#txtTaskQty").prop("disabled", true); 
            }
        }
    });
}

$("#txtTaskQty").on("input", function() {
  if (/^0/.test(this.value)) {
    this.value = this.value.replace(/^0/, "")
  }
})

