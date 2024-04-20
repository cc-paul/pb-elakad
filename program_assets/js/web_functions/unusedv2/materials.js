var tblProjects,tblInventory;
var tabStatus = "";
var currentItemID;
var currentQuotationNumber;

loadProjects(tabStatus);


function loadProjects(filter) {
    tabStatus = filter;

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
        	'url'       : '../program_assets/php/web/materials.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_projects',
                filter  : tabStatus
        	}    
        },
        'aoColumns' : [
            { mData: 'projectNumber'},
            { mData: 'quotationNumber'},
            { mData: 'quotationSubject'},
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
        	{"className": "custom-center", "targets": [8]},
        	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7,8]},
            //{ "width": "20%", "targets": [4] },
            //{ "width": "9%", "targets": [8] },
        	{ "width": "1%", "targets": [0,8] },
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



$('#tblProjects tbody').on( 'click', 'td button', function () {
	var data = tblProjects.row( $(this).parents('tr') ).data();
    
    $("#spProjectNumber").text(data.projectNumber);
    
    loadItems(data.quotationNumber);
    
    if (data.status == "WIP") {
        $("#btnEdit1").show();
        $("#btnEdit2").show();
        $("#btnEdit3").show();
    } else {
        $("#btnEdit1").hide();
        $("#btnEdit2").hide();
        $("#btnEdit3").hide();
    }
    
    if (data.items == 0) {
        JAlert("Selected project has no items.","orange");
    } else {
        $("#mdInventory").modal("show");
    }
});

function loadItems(quotationNumber) {
    $("#btnEdit1").prop("disabled", true);
    $("#btnEdit2").prop("disabled", true);
    $("#btnEdit3").prop("disabled", true);
    
    currentQuotationNumber = quotationNumber;
    
    tblInventory = 
    $('#tblInventory').DataTable({
        'destroy'       : true,
        'paging'        : true,
        'lengthChange'  : false,
        'pageLength'    : 20,
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
        	'url'       : '../program_assets/php/web/materials.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_item',
                quotationNumber  : quotationNumber
        	}    
        },
        'aoColumns' : [
            { mData: 'itemCode'},
            { mData: 'description'},
            { mData: 'uom'},
            { mData: 'qty'},
            { mData: 'delivered'},
            { mData: 'descrepancies'},
            { mData: 'installedOnSite'},
            { mData: 'updatedStock'},
            { mData: 'dateCreated'},
            { mData: 'inventoryRemarks'},
        ],
        'aoColumnDefs': [
        	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7,8,9]},
        //    //{ "width": "20%", "targets": [4] },
            { "width": "12%", "targets": [1] },
        	{ "width": "1%", "targets": [0,2,3,4,5,6,7,8] }
        ],
        "drawCallback": function() {  
            row_count = this.fnSettings().fnRecordsTotal();
        },
        "fnInitComplete": function (oSettings, json) {
            //alert('DataTables has finished its initialisation.');
            var totalQty = 0;
            var totalInstalled = 0;
        
            
            tblInventory.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                var data = this.data();
                
                totalQty += Number(data.qty.toString().replaceAll(",",""));
                totalInstalled += Number(data.installedOnSite.toString().replaceAll(",",""));
            });
            
            $("#spTotalQty").text(totalQty.toLocaleString().replaceAll(".00",""));
            $("#spTotalInstalled").text(totalInstalled.toLocaleString().replaceAll(".00",""));
        }
    }).on('user-select', function (e, dt, type, cell, originalEvent) {
        if ($(cell.node()).parent().hasClass('selected')) {
            e.preventDefault();
        }
    });
}

$('#tblInventory tbody').on('click', 'td', function (){
	var data = tblInventory.row( $(this).parents('tr') ).data();
    
    $("#btnEdit1").prop("disabled", false);
    $("#btnEdit2").prop("disabled", false);
    $("#btnEdit3").prop("disabled", false);
    
    currentItemID = data.id;
    $("#txtDelivered").val(data.delivered.toString().replaceAll(",",""));
    $("#txtInstalled").val(data.installedOnSite.toString().replaceAll(",",""));
    $("#txtRemarks").val(data.inventoryRemarks);
});


$("#btnEdit1").click(function(){
	$("#mdEditInventory").modal("show");
    
    $("#txtDelivered").prop("disabled", false);
    $("#txtInstalled").prop("disabled", true);
    $("#txtRemarks").prop("disabled", true);
});

$("#btnEdit2").click(function(){
	$("#mdEditInventory").modal("show");
    
    $("#txtDelivered").prop("disabled", true);
    $("#txtInstalled").prop("disabled", false);
    $("#txtRemarks").prop("disabled", true);
});


$("#btnEdit3").click(function(){
	$("#mdEditInventory").modal("show");
    
    $("#txtDelivered").prop("disabled", true);
    $("#txtInstalled").prop("disabled", true);
    $("#txtRemarks").prop("disabled", false);
});

$("#btnSaveChanges").click(function(){
    var delivered = $("#txtDelivered").val() == "" ? 0 : $("#txtDelivered").val();
    var installed = $("#txtInstalled").val() == "" ? 0 : $("#txtInstalled").val();
    var remarks = $("#txtRemarks").val();
    
    $.ajax({
        url: "../program_assets/php/web/materials.php",
        data: {
            command : "update_inventory",
            id   : currentItemID,
            delivered   : delivered,
            installed   : installed,
            remarks   : remarks,
        },
        type: 'post',
        success: function (data) {
            var data = jQuery.parseJSON(data);
            
            JAlert(data[0].message,data[0].color);
            
            if (!data[0].error) {
                $("#mdEditInventory").modal("hide");
                loadItems(currentQuotationNumber);
            }
        }
    });
});