var tblAdmin;
var isNewAccount;
var oldUsername;
var oldEmail;
var userId;

loadAdmin();
function loadAdmin() {
    tblAdmin = 
    $('#tblAdmin').DataTable({
        'destroy'       : true,
        'paging'        : true,
        'lengthChange'  : false,
        'pageLength'    : 12,
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
        	'url'       : '../program_assets/php/web/masterfile.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_admin',
        	}    
        },
        'aoColumns' : [
        	{ mData: 'fName'},
            { mData: 'lName'},
            { mData: 'email'},
            { mData: 'username'},
            { mData: 'dateCreated'},
            { mData: 'fullName'},
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
        	{"className": "custom-center", "targets": [7]},
        	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7]},
        	{ "width": "1%", "targets": [7] },
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

$("#btnAdd").click(function(){
    isNewAccount = 1;
    oldUsername  = "";
    oldEmail = "";
    userId = 0;
    
    $("#txtAdmin_fname").val("");
    $("#txtAdmin_lname").val("");
    $("#txtAdmin_email").val("");
    $("#txtAdmin_username").val("");
    
    $("#btnAdmin_reset").prop("disabled",true);
    $("#chkAdmin_active").prop("checked",true);
    $("#chkAdmin_active").prop("disabled",true);
    $("#btnAdmin_save").html('<i class="fa fa-save"></i>&nbsp; Save Account');
	$("#mdAccountForm").modal("show");
});

$('#tblAdmin tbody').on('click', 'td button', function (){
	var data = tblAdmin.row( $(this).parents('tr') ).data();
    var isChecked = true;
    
    userId       = data.id;
    oldUsername  = data.username;
    oldEmail     = data.email;
    isNewAccount = 0;
    
    if (data.status == "Inactive") {
        isChecked = false;
    }
    
    $("#txtAdmin_fname").val(data.fName);
    $("#txtAdmin_lname").val(data.lName);
    $("#txtAdmin_email").val(data.email);
    $("#txtAdmin_username").val(data.username);
    $("#chkAdmin_active").prop("checked",isChecked);
    
    $("#btnAdmin_reset").prop("disabled",false);
    $("#chkAdmin_active").prop("disabled",false);
    $("#btnAdmin_save").html('<i class="fa fa-save"></i>&nbsp; Save Changes');
    $("#mdAccountForm").modal("show");
});

$("#btnAdmin_save").click(function(){
	var fname     = $("#txtAdmin_fname").val();
    var lname     = $("#txtAdmin_lname").val();
    var email     = $("#txtAdmin_email").val();
    var username  = $("#txtAdmin_username").val();
    var isactive;
    
    if ($("#chkAdmin_active").is(":checked")) {
        isactive = 1;
    } else {
        isactive = 0;
    }
    
    if (fname == "" || lname == "" || email == "" || username == "") {
        JAlert("Please fill in all required fields","orange");
    } else if (!validateEmail(email)) {
        JAlert("Please provide a proper email","orange");
    } else {        
        $.ajax({
            url: "../program_assets/php/web/masterfile.php",
            data: {
                command      : 'admin_save',
                isNewAccount : isNewAccount,
                fname        : fname,
                lname        : lname,
                email        : email,
                username     : username,
                isactive     : isactive,
                old_email    : oldEmail,
                old_username : oldUsername,
                userid       : userId
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
                JAlert(data[0].message,"orange");
                
                if (!data[0].error) {
                    $("#mdAccountForm").modal("hide");
                    loadAdmin();
                }
            }
        });
    }
});

$("#btnAdmin_reset").click(function(){
    $.ajax({
        url: "../program_assets/php/web/masterfile.php",
        data: {
            command : "account_reset",
            userid  : userId
        },
        type: 'post',
    }).done(function (data) {
        var data = jQuery.parseJSON(data);
        
        JAlert(data[0].message,"orange");
                
        if (!data[0].error) {
            $("#mdAccountForm").modal("hide");
        }
    });
});

$('#txtAdmin_search').keyup(function(){
    tblAdmin.search($(this).val()).draw() ;
});

/* ================================== Category =========================================  */
var tblCategory;
var isNewCategory;
var oldCategory;
var catid;

loadCategory();
function loadCategory() {
    tblCategory = 
    $('#tblCategory').DataTable({
        'destroy'       : true,
        'paging'        : true,
        'lengthChange'  : false,
        'pageLength'    : 12,
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
        	'url'       : '../program_assets/php/web/masterfile.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_category',
        	}    
        },
        'aoColumns' : [
        	{ mData: 'category'},
            { mData: 'description'},
            { mData: 'createdBy'},
            { mData: 'dateCreated'},
            { mData: 'UpdatedBy'},
            { mData: 'dateUpdated'},
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
        	{"className": "custom-center", "targets": [7]},
        	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7]},
        	{ "width": "1%", "targets": [6,7] },
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

$("#btnAddCategory").click(function(){
    isNewCategory = 1;
    oldCategory = "";
    catid = 0;
    
    $("#txtCategory_cname").val("");
    $("#txtCategory_cdesc").val("");
    $("#chkCategory_active").prop("checked",true);
    $("#chkCategory_active").prop("disabled",true);
	$("#mdCategoryForm").modal("show");
});

$('#tblCategory tbody').on('click', 'td button', function (){
	var data = tblCategory.row( $(this).parents('tr') ).data();
    
    var isActive = true;
    catid = data.id;
    isNewCategory = 0;

    if (data.status == "Inactive") {
        isActive = false;
    }
    
    oldCategory = data.category;
    $("#txtCategory_cname").val(data.category);
    $("#txtCategory_cdesc").val(data.description);
    $("#chkCategory_active").prop("checked",isActive);
    $("#chkCategory_active").prop("disabled",false);
	$("#mdCategoryForm").modal("show");
});

$("#btnCategory_save").click(function(){
    var cname = $("#txtCategory_cname").val();
    var cdesc = $("#txtCategory_cdesc").val();
    var isActive;
    
    if ($("#chkCategory_active").is(":checked")) {
        isActive = 1;
    } else {
        isActive = 0;
    }
    
    if (cname == "") {
        JAlert("Please provide a category name","red");
    } else {
        $.ajax({
            url: "../program_assets/php/web/masterfile.php",
            data: {
                command       : "category_save",
                cname         : cname,
                cdesc         : cdesc,
                isactive      : isActive,
                isnewcategory : isNewCategory,
                oldcname      : oldCategory,
                catid         : catid
            },
            type: 'post',
        }).done(function (data) {
            var data = jQuery.parseJSON(data);
            
            if (!data[0].error) {
                loadCategory();
                $("#mdCategoryForm").modal("hide");
            }
            
            JAlert(data[0].message,"orange");
        });
    }
});

$('#txtCategory_search').keyup(function(){
    tblCategory.search($(this).val()).draw() ;
});

/* ================================== Services =========================================  */
var tblServices;
var isNewService;
var oldService;
var serviceid;

loadServices();
function loadServices() {
    tblServices = 
    $('#tblServices').DataTable({
        'destroy'       : true,
        'paging'        : true,
        'lengthChange'  : false,
        'pageLength'    : 12,
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
        	'url'       : '../program_assets/php/web/masterfile.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_services',
        	}    
        },
        'aoColumns' : [
        	{ mData: 'service'},
            { mData: 'description'},
            { mData: 'category'},
            { mData: 'price'},
            { mData: 'createdBy'},
            { mData: 'dateCreated'},
            { mData: 'UpdatedBy'},
            { mData: 'dateUpdated'},
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
        	{"className": "custom-center", "targets": [9]},
        	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7,8]},
        	{ "width": "1%", "targets": [8,9] },
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

$("#btnAddServices").click(function(){
    isNewService = 1;
    oldService = "";
    serviceid = 0;
    
    $("#txtService_name").val("");
    $("#txtService_remarks").val("");
    $("#cmbService_category").val("").trigger("change");
    $("#txtService_price").val("");
    $("#chkService_active").prop("checked",true);
    $("#chkService_active").prop("disabled",true);
    
	$("#mdService").modal("show");
});

$('#tblServices tbody').on('click', 'td button', function (){
	var data = tblServices.row( $(this).parents('tr') ).data();
    
    var isActive = true;
    serviceid = data.id;
    isNewService = 0;

    if (data.status == "Inactive") {
        isActive = false;
    }
    
    oldService = data.service;
    $("#txtService_name").val(data.service);
    $("#txtService_remarks").val(data.description);
    $("#cmbService_category").val(data.category_id).trigger("change");
    $("#txtService_price").val(data.price);
    $("#chkService_active").prop("checked",isActive);
    $("#chkService_active").prop("disabled",false);
    
	$("#mdService").modal("show");
});

$("#btnService_save").click(function(){
    var service     = $("#txtService_name").val();
    var description = $("#txtService_remarks").val();
    var category    = $("#cmbService_category").val();
    var price       = $("#txtService_price").val();
    var isActive; 
    
    if ($("#chkService_active").is(":checked")) {
        isActive = 1;
    } else {
        isActive = 0;
    }
    
    if (service == "" || description == "" || category == null || price == "") {
        JAlert("Please fill in required fields","orange");
    } else {
        $.ajax({
            url: "../program_assets/php/web/masterfile.php",
            data: {
                command      : 'save_service',
                sid          : serviceid,
                sname        : service,
                oldsname     : oldService,
                description  : description,
                catid        : category,
                price        : price,
                isactive     : isActive,
                isnewservice : isNewService 
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
                
                if (!data[0].error) {
                    loadServices();
                    $("#mdService").modal("hide");
                }
                
                JAlert(data[0].message,"orange");
            }
        });
    }
});

$('#txtServices_search').keyup(function(){
    tblServices.search($(this).val()).draw() ;
});


/* ================================== Therapist =========================================  */
var tblTherapist;
var tblTheraSched;
var isNewTherapist;
var oldTUsername;
var oldTEmail;
var userTId;

loadTherapist();
function loadTherapist() {
    tblTherapist = 
    $('#tblTherapist').DataTable({
        'destroy'       : true,
        'paging'        : true,
        'lengthChange'  : false,
        'pageLength'    : 12,
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
        	'url'       : '../program_assets/php/web/masterfile.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_therapist',
        	}    
        },
        'aoColumns' : [
        	{ mData: 'fName'},
            { mData: 'lName'},
            { mData: 'email'},
            { mData: 'username'},
            { mData: 'mobileNumber'},
            { mData: 'position'},
            { mData: 'dateCreated'},
            { mData: 'fullName'},
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
        	{"className": "custom-center", "targets": [9]},
        	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7,8]},
        	{ "width": "1%", "targets": [9] },
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

$("#btnAddTherapist").click(function(){
    isNewTherapist = 1;
    oldTUsername  = "";
    oldTEmail = "";
    userTId = 0;
    
    $("#txtThera_fname").val("");
    $("#txtThera_lname").val("");
    $("#txtThera_email").val("");
    $("#txtThera_username").val("");
    $("#txtThera_mobile").val("");
    $("#cmbThera_position").val(null);
    
    $("#btnThera_reset").prop("disabled",true);
    $("#chkThera_active").prop("checked",true);
    $("#chkThera_active").prop("disabled",true);
    $("#divSchedHolder").hide();
    $("#btnThera_save").html('<i class="fa fa-save"></i>&nbsp; Save Account');
	$("#mdTherapistForm").modal("show");
});

$('#tblTherapist tbody').on('click', 'td button', function (){
	var data = tblTherapist.row( $(this).parents('tr') ).data();
    var isChecked = true;
    
    userTId       = data.id;
    oldTUsername  = data.username;
    oldTEmail     = data.email;
    isNewTherapist = 0;
    
    if (data.status == "Inactive") {
        isChecked = false;
    }
    
    
    $("#cmbThera_day").val("");
    $("#txtThera_timeFrom").val("");
    $("#txtThera_timeTo").val("");
    $("#txtThera_fname").val(data.fName);
    $("#txtThera_lname").val(data.lName);
    $("#txtThera_email").val(data.email);
    $("#cmbThera_position").val(data.positionID);
    $("#txtThera_username").val(data.username);
    $("#txtThera_mobile").val(data.mobileNumber);
    $("#chkThera_active").prop("checked",isChecked);
    
    $("#divSchedHolder").show();
    $("#btnThera_reset").prop("disabled",false);
    $("#chkThera_active").prop("disabled",false);
    $("#btnThera_save").html('<i class="fa fa-save"></i>&nbsp; Save Changes');
    $("#mdTherapistForm").modal("show");
    
    loadSched(); 
});

function loadSched() {
    tblTheraSched = 
    $('#tblTheraSched').DataTable({
        'destroy'       : true,
        'paging'        : true,
        'lengthChange'  : false,
        'pageLength'    : 12,
        "order"         : [],
        'info'          : true,
        'autoWidth'     : false,
        'select'        : true,
        //'sDom'			: 'Btp<"clear">',
        'sDom'			: 'tp<"clear">', 
        //buttons: [{
        //    extend: "excel",
        //    className: "btn btn-default btn-sm",
        //    titleAttr: 'Export in Excel',
        //    text: 'Export in Excel',
        //    init: function(api, node, config) {
        //       $(node).removeClass('dt-button buttons-excel buttons-html5')
        //    }
        //}],
        'fnRowCallback' : function( nRow, aData, iDisplayIndex ) {
            $('td', nRow).attr('nowrap','nowrap');
            return nRow;
        },
        'ajax'          : {
        	'url'       : '../program_assets/php/web/masterfile.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_sched',
                userid  : userTId
        	}    
        },
        'aoColumns' : [
        	{ mData: 'day'},
            { mData: 'timeFrom'},
            { mData: 'timeTo'},
            { mData: 'id',
                render: function (data,type,row) {
                    return '' + 
                           '<button type="submit" class="btn btn-default btn-xs dt-button list">' +
                           '	<i class="fa fa-trash"></i>' +
                           '</button>' +
                           '';
                }
            }
        ],
        'aoColumnDefs': [
        	{"className": "custom-center", "targets": [3]},
        	{"className": "dt-center", "targets": [0,1,2,3]},
        	{ "width": "1%", "targets": [3] }
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

$("#btnSched_add").click(function(){
    var dayID    = $("#cmbThera_day").val();
    var timeFrom = $("#txtThera_timeFrom").val();
    var timeTo   = $("#txtThera_timeTo").val();
    
    if (dayID == null || timeFrom == "" || timeTo == "") {
        JAlert("Please fill in all required fields","orange");
    } else {
        if (compareTime(timeFrom,timeTo) == 1) {
            JAlert("Provide a correct schedule","orange");
        } else {
            $.ajax({
                url: "../program_assets/php/web/masterfile.php",
                data: {
                    command      : 'thera_sched_add',
                    userid       : userTId,
                    dayID        : dayID,
                    timeFrom     : timeFrom,
                    timeTo       : timeTo
                },
                type: 'post',
                success: function (data) {
                    var data = jQuery.parseJSON(data);
                    JAlert(data[0].message,"orange");
                    
                    if (!data[0].error) {
                        loadSched();
                    }
                }
            });
        }
    }
});

$('#tblTheraSched tbody').on('click', 'td button', function (){
	var data = tblTheraSched.row( $(this).parents('tr') ).data();
    var id = data.id;
    
    $.ajax({
        url: "../program_assets/php/web/masterfile.php",
        data: {
            command  : 'thera_sched_delete',
            id       : id
        },
        type: 'post',
        success: function (data) {
            var data = jQuery.parseJSON(data);
            
            if (!data[0].error) {
                loadSched();
            }
        }
    });
});

function compareTime(str1, str2){
    if(str1 === str2){
        return 0;
    }
    var time1 = str1.split(':');
    var time2 = str2.split(':');
    if(eval(time1[0]) > eval(time2[0])){
        return 1;
    } else if(eval(time1[0]) == eval(time2[0]) && eval(time1[1]) > eval(time2[1])) {
        return 1;
    } else {
        return -1;
    }
}

$("#btnThera_save").click(function(){
	var fname         = $("#txtThera_fname").val();
    var lname         = $("#txtThera_lname").val();
    var email         = $("#txtThera_email").val();
    var username      = $("#txtThera_username").val();
    var mobileNumber  = $("#txtThera_mobile").val();
    var positionID    = $("#cmbThera_position").val();
    var isactive;
    
    if ($("#chkThera_active").is(":checked")) {
        isactive = 1;
    } else {
        isactive = 0;
    }
    
    if (fname == "" || lname == "" || email == "" || username == "" || mobileNumber == "" || positionID == null) {
        JAlert("Please fill in all required fields","orange");
    } else if (mobileNumber.length < 11) {
        JAlert("Mobile number must be 11 digits","orange");
    } else if (!validateEmail(email)) {
        JAlert("Please provide a proper email","orange");
    } else {        
        $.ajax({
            url: "../program_assets/php/web/masterfile.php",
            data: {
                command      : 'thera_save',
                isNewAccount : isNewTherapist,
                fname        : fname,
                lname        : lname,
                email        : email,
                username     : username,
                isactive     : isactive,
                old_email    : oldTEmail,
                old_username : oldTUsername,
                userid       : userTId,
                mobileNumber : mobileNumber,
                positionID   : positionID
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
                JAlert(data[0].message,"orange");
                
                if (!data[0].error) {
                    $("#mdTherapistForm").modal("hide");
                    loadTherapist();
                }
            }
        });
    }
});

$("#btnThera_reset").click(function(){
    $.ajax({
        url: "../program_assets/php/web/masterfile.php",
        data: {
            command : "thera_reset",
            userid  : userTId
        },
        type: 'post',
    }).done(function (data) {
        var data = jQuery.parseJSON(data);
        
        JAlert(data[0].message,"orange");
                
        if (!data[0].error) {
            $("#mdTherapistForm").modal("hide");
        }
    });
});

$('#txtTherapist_search').keyup(function(){
    tblTherapist.search($(this).val()).draw() ;
});

/* ================================== Branch =========================================  */
var tblBranch;
var isNewBranch;
var oldBranch;
var branchid;

loadBranch();
function loadBranch() {
    tblBranch = 
    $('#tblBranch').DataTable({
        'destroy'       : true,
        'paging'        : true,
        'lengthChange'  : false,
        'pageLength'    : 12,
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
        	'url'       : '../program_assets/php/web/masterfile.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_branch',
        	}    
        },
        'aoColumns' : [
        	{ mData: 'branchName'},
            { mData: 'address'},
            { mData: 'createdBy'},
            { mData: 'dateCreated'},
            { mData: 'UpdatedBy'},
            { mData: 'dateUpdated'},
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
        	{"className": "custom-center", "targets": [7]},
        	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7]},
        	{ "width": "1%", "targets": [6,7] },
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

$("#btnAddBranch").click(function(){
    isNewBranch = 1;
    oldBranch = "";
    branchid = 0;
    
    $("#txtBranchName").val("");
    $("#txtBranchAddress").val("");
    $("#chkBranch_active").prop("checked",true);
    $("#chkBranch_active").prop("disabled",true);
	$("#mdBranchForm").modal("show");
});

$('#tblBranch tbody').on('click', 'td button', function (){
	var data = tblBranch.row( $(this).parents('tr') ).data();
    
    var isActive = true;
    branchid = data.id;
    isNewBranch = 0;

    if (data.status == "Inactive") {
        isActive = false;
    }
    
    oldBranch = data.branchName;
    $("#txtBranchName").val(data.branchName);
    $("#txtBranchAddress").val(data.address);
    $("#chkBranch_active").prop("checked",isActive);
    $("#chkBranch_active").prop("disabled",false);
	$("#mdBranchForm").modal("show");
});

$("#btnBranch_save").click(function(){
    var branch = $("#txtBranchName").val();
    var address = $("#txtBranchAddress").val();
    var isActive;
    
    if ($("#chkBranch_active").is(":checked")) {
        isActive = 1;
    } else {
        isActive = 0;
    }
    
    if (branch == "" || address == "") {
        JAlert("Please fill in required fields","red");
    } else {
        $.ajax({
            url: "../program_assets/php/web/masterfile.php",
            data: {
                command       : "branch_save",
                branch        : branch,
                address       : address,
                isactive      : isActive,
                isnewbranch   : isNewBranch,
                oldbranch     : oldBranch,
                branchid      : branchid
            },
            type: 'post',
        }).done(function (data) {
            var data = jQuery.parseJSON(data);
            
            if (!data[0].error) {
                loadBranch();
                $("#mdBranchForm").modal("hide");
            }
            
            JAlert(data[0].message,"orange");
        });
    }
});

$('#txtBranch_search').keyup(function(){
    tblBranch.search($(this).val()).draw() ;
});

function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function numberOnly(id) {
    var element = document.getElementById(id);
    element.value = element.value.replace(/[^0-9]/gi, "");
    
    if (element.value.length > 11) {
        element.value = "";
    }
}