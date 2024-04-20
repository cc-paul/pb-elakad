/* User Registration */
var tblUser;
var isNewUser;
var oldEmpID;
var oldUsername;
var oldEmailAddress;
var userID;

loadUser();

function loadUser() {
    tblUser = 
    $('#tblUser').DataTable({
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
            className: "btn btn-default btn-sm hide btn-export-user",
            titleAttr: 'Export in Excel',
            text: 'Export in Excel',
            init: function(api, node, config) {
               $(node).removeClass('dt-button buttons-excel buttons-html5')
            },exportOptions: {
                columns: [ 2,3,4,8,7 ]
            }
        }],
        'fnRowCallback' : function( nRow, aData, iDisplayIndex ) {
            $('td', nRow).attr('nowrap','nowrap');
            return nRow;
        },
        'ajax'          : {
        	'url'       : '../program_assets/php/web/account.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_user',
        	}    
        },
        'aoColumns' : [
        	{ mData: 'employeeID'},
            { mData: 'username'},
            { mData: 'firstName'},
            { mData: 'middleName'},
            { mData: 'lastName'},
            { mData: 'mobileNumber'},
            { mData: 'email'},
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

$("#btnAddUser").click(function(){
    oldEmpID = 0;
    userID = 0;
    isNewUser = 1;
    oldEmpID = "";
    oldUsername = "";
    oldEmailAddress = "";
    resetFields();
    $("#btnReset").hide();
	$("#mdAddUser").modal("show");
});

$('#tblUser tbody').on('click', 'td button', function (){
	var data = tblUser.row( $(this).parents('tr') ).data();
    
    isNewUser = 0;
    userID = data.id;
    oldUsername = data.username;
    oldEmailAddress = data.email;
    oldEmpID = data.employeeID;
    
    setTimeout(function() {
        $("#txtEmployeeID").val(data.employeeID);
        $("#cmbPosition").val(data.positionID).trigger("change.select2");
        $("#txtFirstName").val(data.firstName);
        $("#txtMiddleName").val(data.middleName);
        $("#txtLastName").val(data.lastName);
        $("#txtEmailAdress").val(data.email);
        $("#txtUsername").val(data.username);
        $("#txtMobileNumber").val(data.mobileNumber);
        $("#chkActive").prop('checked',data.isActive == 1 ? true : false); 
        $("#chkActive").prop("disabled",false);
        
        $("#btnReset").show();
        $("#mdAddUser").modal("show");
    }, 500);
});

$("#btnSaveUser").click(function(){
    var empID        = $("#txtEmployeeID").val();
    var positionID   = $("#cmbPosition").val();
    var firstName    = $("#txtFirstName").val();
    var middleName   = $("#txtMiddleName").val();
    var lastName     = $("#txtLastName").val();
    var emailAddress = $("#txtEmailAdress").val();
    var username     = $("#txtUsername").val();
    var mobileNumber = $("#txtMobileNumber").val();
    var isActive;
    
    if ($("#chkActive").prop('checked') == true) {
        isActive = 1;
    } else {
        isActive = 0;
    }

    
    if (empID == ""  || firstName == "" || lastName == "" || emailAddress == "" || username == "" || mobileNumber == "") {
        JAlert("Please fill in required fields","red");
    } else if (!validateEmail(emailAddress)) {
        JAlert("Please provide a proper email","red");
    } else if (mobileNumber.length < 11) {
        JAlert("Mobile number must be 11 digits","red");
    } else {
        $.ajax({
            url: "../program_assets/php/web/account.php",
            data: {
                command : "new_user",
                isNewUser : isNewUser,
                userID : userID,
                oldEmpID : oldEmpID,
                oldUsername : oldUsername,
                oldEmailAddress : oldEmailAddress,
                empID : empID,
                positionID : positionID,
                firstName : firstName,
                middleName : middleName,
                lastName : lastName,
                emailAddress : emailAddress,
                username : username,
                mobileNumber : mobileNumber,
                isActive : isActive
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
                
                JAlert(data[0].message,data[0].color);
                
                if (!data[0].error) {
                    loadUser();
                    $("#mdAddUser").modal("hide");
                }
            }
        });
    }
});

$("#btnExportUser").click(function(){
	$(".btn-export-user").click();
});

$('#txtSearchUser').keyup(function(){
    tblUser.search($(this).val()).draw();
});


$('#btnReset').click(function(){
    $.ajax({
        url: "../program_assets/php/web/account.php",
        data: {
            command : "reset_password",
            userID : userID
        },
        type: 'post',
        success: function (data) {
            var data = jQuery.parseJSON(data);
            
            JAlert(data[0].message,data[0].color);
        }
    });
});

function resetFields() {
    $("#txtEmployeeID").val(null);
    $("#cmbPosition").val(null).trigger('change.select2');
    $("#txtFirstName").val(null);
    $("#txtMiddleName").val(null);
    $("#txtLastName").val(null);
    $("#txtEmailAdress").val(null);
    $("#txtUsername").val(null);
    $("#txtMobileNumber").val(null);
    
    $("#chkActive").prop("checked", true);
    $("#chkActive").prop("disabled", true);
}

function validateEmail($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test( $email );
}

function numOnly(selector){
    selector.value = selector.value.replace(/[^0-9]/g,'');
}


/* Freelance Approval */
var tblFreelancer;
var freelanceID;
var freelanceEmail;
var freelanceFullName;

//loadFreelancer();

function loadFreelancer() {
    tblFreelancer = 
    $('#tblFreelancer').DataTable({
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
            className: "btn btn-default btn-sm hide btn-export-freelancer",
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
        	'url'       : '../program_assets/php/web/account.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_freelancer',
        	}    
        },
        'aoColumns' : [
        	{ mData: 'fullName'},
            { mData: 'mobileNumber'},
            { mData: 'fullAddress'},
            { mData: 'birthDate'},
            { mData: 'gender'},
            { mData: 'emailAddress'},
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
        //	{"className": "custom-center", "targets": [9]},
        	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7,8]},
        	{ "width": "1%", "targets": [8] },
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

$('#tblFreelancer tbody').on('click', 'td button', function (){
	var data = tblFreelancer.row( $(this).parents('tr') ).data();
    
    $("#spFullName").html(data.fullName);
    $("#spMobile").html(data.mobileNumber);
    $("#spEmail").html(data.emailAddress);
    $("#spAddress").html(data.fullAddress);
    $("#spServicesOffered").html(data.services);
    freelanceID = data.id;
    freelanceEmail = data.emailAddress;
    freelanceFullName = data.fullName;
    loadImage();
    
    //if (data.status == "Pending") {
    //    $("#dvReject").show();
    //    $("#dvCancel").hide();
    //} else {
    //    $("#dvReject").hide();
    //    $("#dvCancel").show();
    //}
    //
    //if (data.status=="Approved") {
    //    $("#btnApprove").hide();
    //} else {
    //    $("#btnApprove").hide();
    //    $("#btnReject").hide();
    //    $("#btnBan").hide();
    //    $("#btnCancelRequest").hide();
    //}
    //
    //
    //if (data.status=="Cancelled") {
    //    $("#btnApprove").hide();
    //}
    
    
    switch (data.status) {
        case "Approved" :
                //$("#dvHide").addClass("col-sm-6 col-xs-12");
                $("#btnApprove").hide();
                $("#btnReject").hide();
                $("#btnCancelRequest").show();
                $("#btnBan").show();
            break;
        case "Cancelled" :
        case "Declined" :
        case "Banned" :
                //$("#dvHide").addClass("col-sm-9 col-xs-12");
                $("#btnApprove").hide();
                $("#btnReject").hide();
                $("#btnCancelRequest").hide();
                $("#btnBan").hide();
            break;
        case "Pending" :
                //$("#dvHide").addClass("col-sm-6 col-xs-12");
                $("#btnApprove").show();
                $("#btnReject").show();
                $("#btnCancelRequest").hide();
                $("#btnBan").hide();
            break;
    }
    
    $("#mdApproval").modal();
});

$("#btnApprove").click(function(){
	updateStatus("Approved");
});

$("#btnReject").click(function(){
	updateStatus("Declined");
});

$("#btnBan").click(function(){
	updateStatus("Banned");
});

$("#btnCancelRequest").click(function(){
	updateStatus("Cancelled");
});

function updateStatus(status) {
    $.ajax({
        url: '../program_assets/php/web/account.php',
        data: {
            command   : 'change_freelance_status',
            id : freelanceID,
            status : status,
            freelanceEmail : freelanceEmail,
            freelanceFullName : freelanceFullName
        },
        type: 'post',
        success: function (data) {
            var data = jQuery.parseJSON(data);
            
            JAlert(data[0].message,data[0].color);
                
            if (!data[0].error) {  
                loadFreelancer();
                $("#mdApproval").modal("hide");
            }
        }
    });
}

$("#btnExportFreelancer").click(function(){
	$(".btn-export-freelancer").click();
});

$('#txtSearchFreelancer').keyup(function(){
    tblFreelancer.search($(this).val()).draw();
});

function loadImage() {
    $.ajax({
        url: '../program_assets/php/web/account.php',
        data: {
            command   : 'display_freelance_image',
            id : freelanceID
        },
        type: 'post',
        success: function (data) {
            var data = jQuery.parseJSON(data);
            
            $('#dvImages').html("");
            
            for (var i = 0; i < data.length; i++) {
                $('#dvImages').append("" +
                                      
                    '<div class="col-sm-3 col-sm-12">' +
                    '    <br>' +
                    '    <a href='+ data[i].imageLink +' target="_blank">' +
                    '    <img class="img-responsive image-custom" src="'+ data[i].imageLink +'" alt="Photo">' +
                    '    </a>' +
                    '</div>'
                                          
                );
            }
        }
    });
}
