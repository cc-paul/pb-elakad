/* Province */
var tblProvince;
var isNewProvince;
var oldProvinceName = "";
var provinceID = "";

loadProvince();

function loadProvince() {
    tblProvince = 
    $('#tblProvince').DataTable({
        'destroy'       : true,
        'paging'        : true,
        'lengthChange'  : false,
        'pageLength'    : 5,
        "order"         : [],
        'info'          : true,
        'autoWidth'     : false,
        'select'        : true,
        'sDom'			: 'Btp<"clear">',
        //dom: 'Bfrtip',
        buttons: [{
            extend: "excel",
            className: "btn btn-default btn-sm hide btn-export-province",
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
        	'url'       : '../program_assets/php/web/address.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_province',
        	}    
        },
        'aoColumns' : [
        	{ mData: 'province'},
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

$("#btnAddProvince").click(function(){
    isNewProvince = 1;
    provinceID = 0;
	$("#txtProvince").val("");
    $("#chkActiveProvince").prop("checked", true);
    $("#chkActiveProvince").prop("disabled", true);
    $("#mdAddProvince").modal();
});

$('#tblProvince tbody').on('click', 'td button', function (){
	var data = tblProvince.row( $(this).parents('tr') ).data();
    
    provinceID = data.id;
    isNewProvince = 0;
    oldProvinceName = data.province;
    $("#txtProvince").val(data.province);
    $("#chkActiveProvince").prop('checked',data.isActive == 1 ? true : false); 
    $("#chkActiveProvince").prop("disabled",false);
    $("#mdAddProvince").modal();
});

$("#btnSaveProvince").click(function(){
    var province = $("#txtProvince").val();
    var isActive;
    
    if ($("#chkActiveProvince").prop('checked') == true) {
        isActive = 1;
    } else {
        isActive = 0;
    }
    
    if (province == "") {
        JAlert("Please fill in required fields","red");
    } else {
        $.ajax({
            url: "../program_assets/php/web/address",
            data: {
                command   : 'save_province',
                provinceID : provinceID,
                isNewProvince : isNewProvince,
                oldProvinceName : oldProvinceName,
                province  : province,
                isActive  : isActive
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
                
                JAlert(data[0].message,data[0].color);
                    
                if (!data[0].error) {
                    loadProvince();
                    $("#mdAddProvince").modal("hide");
                }
            }
        });
    }
});

$("#btnExportProvince").click(function(){
	$(".btn-export-province").click();
});

$('#txtSearchProvince').keyup(function(){
    tblProvince.search($(this).val()).draw();
});

/* Municipality */
var tblMunicipality;
var isNewMunicipality;
var oldMunicipalityName = "";
var oldZipCode = "";
var municipalityID = "";

loadMunicipality();

function loadMunicipality() {
    tblMunicipality = 
    $('#tblMunicipality').DataTable({
        'destroy'       : true,
        'paging'        : true,
        'lengthChange'  : false,
        'pageLength'    : 5,
        "order"         : [],
        'info'          : true,
        'autoWidth'     : false,
        'select'        : true,
        'sDom'			: 'Btp<"clear">',
        //dom: 'Bfrtip',
        buttons: [{
            extend: "excel",
            className: "btn btn-default btn-sm hide btn-export-municipality",
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
        	'url'       : '../program_assets/php/web/address.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_municipality',
        	}    
        },
        'aoColumns' : [
            { mData: 'province'},
        	{ mData: 'municipalityName'},
            { mData: 'zipCode'},
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
        	{"className": "custom-center", "targets": [5]},
        	{"className": "dt-center", "targets": [0,1,2,3,4,5]},
        	{ "width": "1%", "targets": [3,4,5] },
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

$("#btnAddMunicipality").click(function(){
    isNewMunicipality = 1;
    municipalityID = 0;
	$("#cmbProvince").val(null).trigger("change");
    $("#txtMunicipality").val("");
    $("#txtZipCode").val("");
    $("#chkActiveMunicipality").prop("checked", true);
    $("#chkActiveMunicipality").prop("disabled", true);
    $("#mdMunicipality").modal();
});

$('#tblMunicipality tbody').on('click', 'td button', function (){
	var data = tblMunicipality.row( $(this).parents('tr') ).data();
    
    isNewMunicipality = 0;
	$("#cmbProvince").val(data.provinceID).trigger("change");
    $("#txtMunicipality").val(data.municipalityName);
    $("#txtZipCode").val(data.zipCode);
    oldMunicipalityName = data.municipalityName;
    oldZipCode = data.zipCode;
    municipalityID = data.id;
    
    $("#chkActiveMunicipality").prop('checked',data.isActive == 1 ? true : false); 
    $("#chkActiveMunicipality").prop("disabled",false);
    
    $("#mdMunicipality").modal();
});

$("#btnSaveMunicipality").click(function(){
	var provinceID   = $("#cmbProvince").val();
    var municipality = $("#txtMunicipality").val();
    var zipCode      = $("#txtZipCode").val();
    var isActive;
    
    if ($("#chkActiveMunicipality").prop('checked') == true) {
        isActive = 1;
    } else {
        isActive = 0;
    }
    
    if (provinceID == null || municipality == "" || zipCode == "") {
        JAlert("Please fill in required fields","red");
    } else {
        $.ajax({
            url: "../program_assets/php/web/address",
            data: {
                command   : 'save_municipality',
                isNewMunicipality : isNewMunicipality,
                provinceID : provinceID,
                municipality : municipality,
                zipCode : zipCode,
                isActive : isActive,
                oldMunicipalityName : oldMunicipalityName,
                oldZipCode : oldZipCode,
                municipalityID : municipalityID
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
                
                JAlert(data[0].message,data[0].color);
                    
                if (!data[0].error) {
                    loadMunicipality();
                    $("#mdMunicipality").modal("hide");
                }
            }
        });
    }
});

$("#btnExportMunicipality").click(function(){
	$(".btn-export-municipality").click();
});

$('#txtSearchMunicipality').keyup(function(){
    tblMunicipality.search($(this).val()).draw();
});

/* Barangay */
var tblBarangay;
var isNewBarangay;
var oldBrgyProvince = "";
var oldBrgyMunicipality = "";
var oldBrgy = "";
var brgyID = "";
var isNewBarangay = "";

loadBarangay();

function loadBarangay() {
    tblBarangay = 
    $('#tblBarangay').DataTable({
        'destroy'       : true,
        'paging'        : true,
        'lengthChange'  : false,
        'pageLength'    : 5,
        "order"         : [],
        'info'          : true,
        'autoWidth'     : false,
        'select'        : true,
        'sDom'			: 'Btp<"clear">',
        //dom: 'Bfrtip',
        buttons: [{
            extend: "excel",
            className: "btn btn-default btn-sm hide btn-export-barangay",
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
        	'url'       : '../program_assets/php/web/address.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_brgy',
        	}    
        },
        'aoColumns' : [
            { mData: 'province'},
        	{ mData: 'municipalityName'},
            { mData: 'zipCode'},
            { mData: 'barangayName'},
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
        	{"className": "custom-center", "targets": [6]},
        	{"className": "dt-center", "targets": [0,1,2,3,4,5,6]},
        	{ "width": "1%", "targets": [4,5,6] },
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

$("#btnExportBarangay").click(function(){
	$(".btn-export-barangay").click();
});

$('#txtSearchBarangay').keyup(function(){
    tblBarangay.search($(this).val()).draw();
});

$("#cmbProvinceBrgy").on("change", function() {
    var provinceID = $(this).val();
    var provinceName  = $("#cmbProvinceBrgy").find("option:selected").text();
    
    if (provinceID == null) {
        provinceID = 0;
    }
    
    $.ajax({
        url: "../program_assets/php/web/address",
        data: {
            command   : 'select_municipality',
            provinceID : provinceID
        },
        type: 'post',
        success: function (data) {
            var data = jQuery.parseJSON(data);
            
            $('#cmbMunicipality').html("");
            $('#cmbMunicipality').append("<option value='' selected disabled>Select Municipality</option>");
            for (i = 0; i < data.length; i++) { 
                $('#cmbMunicipality').append( '<option value="'+ data[i].id +'">'+ data[i].municipalityName  +'</option>' );
            }
        }
    });
});

$("#btnAddBarangay").click(function(){
    isNewBarangay = 1;
	$('#cmbProvinceBrgy').val(null).trigger("change");
    $('#cmbMunicipality').html("");
    $('#cmbMunicipality').append("<option value='' selected disabled>Select Municipality</option>");
    $("#chkActiveBarangay").prop("checked", true);
    $("#chkActiveBarangay").prop("disabled", true);
    $('#txtBarangay').val(null);
    $("#mdBarangay").modal();
});

$('#tblBarangay tbody').on('click', 'td button', function (){
	var data = tblBarangay.row( $(this).parents('tr') ).data();
    
    $('#cmbProvinceBrgy').val(data.provinceID).trigger("change");
    
    setTimeout(function() {
        $('#cmbMunicipality').val(data.municipalityID).trigger("change");
    }, 500);
    
    $('#txtBarangay').val(data.barangayName);
    $("#chkActiveBarangay").prop('checked',data.isActive == 1 ? true : false); 
    $("#chkActiveBarangay").prop("disabled",false);
    
    oldBrgyProvince = data.provinceID;
    oldBrgyMunicipality = data.municipalityID;
    oldBrgy = data.barangayName;
    brgyID = data.id;
    isNewBarangay = 0;
    
    $("#mdBarangay").modal();
});

$("#btnSaveBarangay").click(function(){
    var provinceID = $('#cmbProvinceBrgy').val();
    var municipalityID = $('#cmbMunicipality').val();
    var barangay = $('#txtBarangay').val();
    var isActive;
    
    if ($("#chkActiveBarangay").prop('checked') == true) {
        isActive = 1;
    } else {
        isActive = 0;
    }
    
    if (provinceID == null || municipalityID == null || barangay == "") {
        JAlert("Please fill in required fields","red");
    } else {
        $.ajax({
            url: "../program_assets/php/web/address",
            data: {
                command   : 'save_barangay',
                provinceID : provinceID,
                municipalityID : municipalityID,
                barangay : barangay,
                isActive : isActive,
                oldBrgyProvince : oldBrgyProvince,
                oldBrgyMunicipality : oldBrgyMunicipality,
                oldBrgy : oldBrgy,
                brgyID : brgyID,
                isNewBarangay : isNewBarangay
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
                
                JAlert(data[0].message,data[0].color);
                
                if (!data[0].error) {
                    loadBarangay();
                    $("#mdBarangay").modal("hide");
                }
            }
        });
    }
});