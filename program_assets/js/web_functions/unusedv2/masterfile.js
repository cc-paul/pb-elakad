/* User Registration */
var tblUser;
var isNewUser;
var oldEmpID;
var oldUsername;
var oldEmailAddress;
var userID;
var currentAge = 0;


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
        		command : 'display_user',
        	}    
        },
        'aoColumns' : [
        	{ mData: 'userID'},
            { mData: 'username'},
            { mData: 'firstName'},
            { mData: 'middleName'},
            { mData: 'lastName'},
            { mData: 'mobileNumber'},
            { mData: 'emailAddress'},
            { mData: 'position'},
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
        	{"className": "custom-center", "targets": [10]},
        	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7,8,9]},
        	{ "width": "1%", "targets": [10] },
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
    loadPositionSelect();
    resetFields();
    $("#btnReset").hide();
    $("#btnClientAssignment").hide();
	$("#mdAddUser").modal("show");
});

$('#tblUser tbody').on('click', 'td button', function (){
	var data = tblUser.row( $(this).parents('tr') ).data();
    
    isNewUser = 0;
    userID = data.id;
    oldUsername = data.username;
    oldEmailAddress = data.emailAddress;
    oldEmpID = data.userID;
    
    loadPositionSelect();
    
    setTimeout(function() {
        $("#txtEmployeeID").val(data.userID);
        $("#cmbPosition").val(data.positionID).trigger("change.select2");
        $("#txtFirstName").val(data.firstName);
        $("#txtMiddleName").val(data.middleName);
        $("#txtLastName").val(data.lastName);
        $("#txtEmailAdress").val(data.emailAddress);
        $("#txtUsername").val(data.username);
        $("#txtMobileNumber").val(data.mobileNumber);
        $("#chkActive").prop('checked',data.isActive == 1 ? true : false); 
        $("#chkActive").prop("disabled",false);
        $("#btnReset").show();
        $("#cmbAssgnToClient").val(data.isAssigned).trigger('change.select2');
        $("#cmbGender").val(data.gender).trigger('change.select2');
        $("#txtBirthday").val(data.bday);
        $("#txtJoinDate").val(data.joinDate);
        $("#cmbSourceOfHire").val(data.sourceHire).trigger('change.select2');
        $("#txtWorkYear").val(data.totalYears);
        $("#txtWorkMonth").val(data.totalMonths);
        $("#cmbEmpType").val(data.empType).trigger('change.select2');
        $("#txtContactName").val(data.contactName);
        $("#txtRelationship").val(data.relationship);
        $("#txtRelationMobileNumber").val(data.relationshipNumber);
        $("#txtTIN").val(data.tin);
        $("#txtSSID").val(data.sss);
        $("#txtPID").val(data.pid);
        $("#txtPagIbigID").val(data.pagibigID);
        $("#mdAddUser").modal("show");
        
        if (data.isAssigned == 1) {
            $("#btnClientAssignment").show();
        } else {
            $("#btnClientAssignment").hide();
        }
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
    
    /* New fields */
    var isAssigned         = $("#cmbAssgnToClient").val();
    var bday               = $("#txtBirthday").val();
    var gender             = $("#cmbGender").val();
    var joinDate           = $("#txtJoinDate").val();
    var sourceHire         = $("#cmbSourceOfHire").val();
    var totalYears         = $("#txtWorkYear").val();
    var totalMonths        = $("#txtWorkMonth").val();
    var empType            = $("#cmbEmpType").val();
    var contactName        = $("#txtContactName").val();
    var relationship       = $("#txtRelationship").val();
    var relationshipNumber = $("#txtRelationMobileNumber").val();
    var tin                = $("#txtTIN").val();
    var sss                = $("#txtSSID").val();
    var pid                = $("#txtPID").val();
    var pagibigID          = $("#txtPagIbigID").val();
    
    if ($("#chkActive").prop('checked') == true) {
        isActive = 1;
    } else {
        isActive = 0;
    }
    
    submitBday();
    
    if (empID == "" || positionID == null || firstName == "" || lastName == "" || emailAddress == "" || username == "" || mobileNumber == "" || bday == null || joinDate == null || empType == null) {
        JAlert("Please fill in required fields","red");
    } else if (!validateEmail(emailAddress)) {
        JAlert("Please provide a proper email","red");
    } else if (mobileNumber.length < 11) {
        JAlert("Mobile number must be 11 digits","red");
    } else if (Number(currentAge) < 18) {
        JAlert("Age must be at least 18 years old","red");
    } else {
        $.ajax({
            url: "../program_assets/php/web/masterfile.php",
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
                isActive : isActive,
                isAssigned         : isAssigned,
                bday               : bday,
                gender             : gender,
                joinDate           : joinDate,
                sourceHire         : sourceHire,
                totalYears         : totalYears,
                totalMonths        : totalMonths,
                empType            : empType,
                contactName        : contactName,
                relationship       : relationship,
                relationshipNumber : relationshipNumber,
                tin                : tin,
                sss                : sss,
                pid                : pid,
                pagibigID          : pagibigID
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
        url: "../program_assets/php/web/masterfile.php",
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
    $("#cmbPosition").val(null);
    $("#txtFirstName").val(null);
    $("#txtMiddleName").val(null);
    $("#txtLastName").val(null);
    $("#txtEmailAdress").val(null);
    $("#txtUsername").val(null);
    $("#txtMobileNumber").val(null);
    $("#chkActive").prop("checked", true);
    $("#chkActive").prop("disabled", true);
    
    
    $("#cmbAssgnToClient").val(1).trigger('change.select2');
    $("#cmbGender").val("Male").trigger('change.select2');
    $("#txtBirthday").val(null);
    $("#txtJoinDate").val(null);
    $("#cmbSourceOfHire").val(null).trigger('change.select2');
    $("#txtWorkYear").val(null);
    $("#txtWorkMonth").val(null);
    $("#cmbEmpType").val(null).trigger('change.select2');
    $("#txtContactName").val(null);
    $("#txtRelationship").val(null);
    $("#txtRelationMobileNumber").val(null);
    $("#txtTIN").val(null);
    $("#txtSSID").val(null);
    $("#txtPID").val(null);
    $("#txtPagIbigID").val(null);
}

function loadPositionSelect() {
    $.ajax({
        url: "../program_assets/php/web/masterfile.php",
        data: {
            command : 'select_position',
        },
        type: 'post',
        success: function (data) {
            var data = jQuery.parseJSON(data);
            
            if (data.length != 0) {
                document.getElementById("cmbPosition").options.length = 0;
            
                $('#cmbPosition').append($('<option>', {
                    value: null,
                    text: "-- Please select a postion --",
                    selected: true,
                    disabled: true
                }));
                
                for (var i = 0; i < data.length; i++) {
                    $('#cmbPosition').append($('<option>', {
                        value: data[i].id,
                        text: data[i].position
                    }));
                }
            }
        }
    });
}

function validateEmail($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test( $email );
}

function numOnly(selector){
    selector.value = selector.value.replace(/[^0-9]/g,'');
}

/* Client */
var tblClient;
var oldClientsName;
var oldClientsID;
var isNewClient;


loadClient();

function loadClient() {
    tblClient = 
    $('#tblClient').DataTable({
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
            className: "btn btn-default btn-sm hide btn-export-client",
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
        		command : 'display_client',
        	}    
        },
        'aoColumns' : [
            { mData: 'clientsName'},
            { mData: 'address'},
            { mData: 'contactNumber'},
            { mData: 'landLine'},
            { mData: 'contactPerson'},
            { mData: 'emailAddress'},
            { mData: 'dateCreated'},
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
        	{"className": "custom-center", "targets": [8]},
        	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7,8]},
        	{ "width": "1%", "targets": [7,8] },
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

$("#btnExportClient").click(function(){
	$(".btn-export-client").click();
});

$('#txtSearchClient').keyup(function(){
    tblClient.search($(this).val()).draw() ;
});

$("#btnAddClient").click(function(){
    oldClientsID = 0;
    isNewClient = 1;
    oldClientsName = "";
    
    
    $("#btnBranchAssignment").hide();
    $("#txtClientsName").val(null);
    $("#txtClientsAddress").val(null);
    $("#txtClientsContactNumber").val(null);
    $("#txtClientsContactPerson").val(null);
    $("#txtClientsEmailAddress").val(null);
    $("#txtClientsLandLine").val(null);
    $("#chkClientsActive").prop("checked", true);
    $("#chkClientsActive").prop("disabled", true);
    $("#mdClient").modal("show");
});

$('#tblClient tbody').on('click', 'td button', function (){
    var data = tblClient.row( $(this).parents('tr') ).data();
    oldClientsID = data.id;
    oldClientsName = data.clientsName;
    isNewClient = 0;
    
    $("#btnBranchAssignment").show();
    $("#txtClientsName").val(data.clientsName);
    $("#txtClientsAddress").val(data.address);
    $("#txtClientsContactNumber").val(data.contactNumber);
    $("#txtClientsContactPerson").val(data.contactPerson);
    $("#txtClientsEmailAddress").val(data.emailAddress);
    $("#txtClientsLandLine").val(data.landLine);
    $("#chkClientsActive").prop("checked", data.isActive == 1 ? true : false);
    $("#chkClientsActive").prop("disabled", false); 
    $("#mdClient").modal("show");
});

$("#btnSaveClients").click(function(){
    var clientsName = $("#txtClientsName").val();
    var clientsAddress = $("#txtClientsAddress").val();
    var contactNumber = $("#txtClientsContactNumber").val();
    var contactPerson = $("#txtClientsContactPerson").val();
    var emailAddress = $("#txtClientsEmailAddress").val();
    var landline = $("#txtClientsLandLine").val();
    var isActive;
    
    if ($("#chkClientsActive").prop('checked') == true) {
        isActive = 1;
    } else {
        isActive = 0;
    }
    
    if (clientsName == "" || clientsAddress == "" || contactNumber == "" || emailAddress == "" || landline == "") {
        JAlert("Please fill in required fields","red");
    } else if (!validateEmail(emailAddress)) {
        JAlert("Please provide proper email","red");
    } else if (contactNumber.length < 11) {
        JAlert("Please provide proper mobile number with a digit exactly 11","red");
    } else if (landline.length < 10) {
        JAlert("Please provide proper landline number with a digit exactly 10","red");
    } else {
        $.ajax({
            url: "../program_assets/php/web/masterfile.php",
            data: {
                command : "new_client",
                oldClientsName : oldClientsName,
                oldClientsID : oldClientsID,
                isNewClient : isNewClient,
                clientsName : clientsName,
                clientsAddress : clientsAddress,
                contactNumber : contactNumber,
                contactPerson : contactPerson,
                emailAddress : emailAddress,
                landline : landline,
                isActive : isActive
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
                
                JAlert(data[0].message,data[0].color);
                
                if (!data[0].error) {
                    loadClient();
                    $("#mdClient").modal("hide");
                }
            }
        });   
    }
});

var currentBranchID;
var oldBranchName;
var isNewBranch;

$("#btnBranchAssignment").click(function(){
  $("#mdClient").modal("hide");
  $("#mdBranch").modal("show");
  loadMapping();
  loadBranches();
  
  oldBranchName = "";
  currentBranchID = 0;
  isNewBranch = 1;
  $("#txtBranchName").val("");
  $("#txtBranchAddress").val("");
  $("#txtCoordinates").val("");
});

function loadMapping() {

  mapboxgl.accessToken = 'pk.eyJ1IjoicGFnZW50ZSIsImEiOiJja3p6OHF3NjkwN3JuM2lwa21pZmdxcW14In0.C07RU8giyLyFNTjxbLUS5A';
  const map = new mapboxgl.Map({
      container: 'map', // container ID
      style: 'mapbox://styles/mapbox/streets-v11', // style URL
      center: [121.7740, 12.8797], // starting position [lng, lat]
      zoom: 5, // starting zoom
      projection: 'globe' // display the map as a 3D globe
  });
   
  map.on('style.load', () => {
      map.setFog({}); // Set the default atmosphere style
  });
  
  var marker = new mapboxgl.Marker();
  
  function add_marker (event) {
    var coordinates = event.lngLat;
    console.log('Lng:', coordinates.lng, 'Lat:', coordinates.lat);
    marker.setLngLat(coordinates).addTo(map);
    
    $("#txtCoordinates").val(coordinates.lng + ',' + coordinates.lat);
  }
  
  const geocoder = new MapboxGeocoder({
    // Initialize the geocoder
    accessToken: mapboxgl.accessToken, // Set the access token
    mapboxgl: mapboxgl, // Set the mapbox-gl instance
    marker: false, // Do not use the default marker style
    placeholder: 'Search for places in phillipines', // Placeholder text for the search bar
    proximity: {
      longitude: 121.7740,
      latitude: 12.8797
    } // Coordinates of UC phillipines
  });
  map.addControl(geocoder);
  
  map.on('click', add_marker);
  
  $('#txtBranchAddress').on("keypress", function(e) {
      if (e.keyCode == 13) {
          geocoder.query(this.value);
          return false; // prevent the button click from happening
      }
  });
  
  $(".mapboxgl-ctrl-geocoder").hide();
}

function loadBranches() {
  tblBranchList = 
  $('#tblBranchList').DataTable({
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
    	'url'       : '../program_assets/php/web/masterfile.php',
    	'type'      : 'POST',
    	'data'      : {
    		command : 'display_client_branch',
        clientID : oldClientsID
    	}    
    },
    'aoColumns' : [
    	{ mData: 'branchName'},
      { mData: 'address'},
      { mData: 'coordinates'},
      { mData: 'dateCreated'},
      { mData: 'id',
          render: function (data,type,row) {
              return '<div class="input-group">' + 
                     '	<button id="list_' + row.id + '" name="list_' + row.id + '" type="submit" class="btn btn-default btn-xs dt-button list">' +
                     '		<i class="fa fa-trash"></i>' +
                     '	</button>' +
                     '</div>';
          }
      }
    ],
    'aoColumnDefs': [
    //	{"className": "custom-center", "targets": [8]},
    	{"className": "dt-center", "targets": [0,1,2,3]},
    	{ "width": "1%", "targets": [0,2,3,4] },
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

$("#btnSaveMap").click(function(){
  var branchName  = $("#txtBranchName").val();
  var address     = $("#txtBranchAddress").val();
  var coordinates = $("#txtCoordinates").val();
  
  if (branchName == "" || address == "" || coordinates == "") {
    JAlert("Please fill in required fields","red");
  } else {
    $.ajax({
      url: "../program_assets/php/web/masterfile.php",
      data: { 
        command   : 'save_client_branch',
        clientID : oldClientsID,
        branchName : branchName,
        address : address,
        coordinates : coordinates,
        oldBranchName : oldBranchName,
        currentBranchID : currentBranchID,
        isNewBranch : isNewBranch
      },
      type: 'post',
      success: function (data) {
        var data = jQuery.parseJSON(data);
                
        JAlert(data[0].message,data[0].color);
        
        if (!data[0].error) {
            loadMapping();
            loadBranches();
            oldBranchName = "";
            currentBranchID = 0;
            isNewBranch = 1;
            $("#txtBranchName").val("");
            $("#txtBranchAddress").val("");
            $("#txtCoordinates").val("");
        }
      }
    });
  }
});


$('#tblBranchList tbody').on('click', 'td', function (){
	var data = tblBranchList.row( $(this).parents('tr') ).data();
	
  loadMapping();
  oldBranchName = data.branchName;
  currentBranchID = data.id;
  isNewBranch = 0;
  
  $("#txtBranchName").val(data.branchName);
  $("#txtBranchAddress").val(data.address);
  $("#txtCoordinates").val(data.coordinates);
});

$('#tblBranchList tbody').on('click', 'td button', function (){
  var data = tblBranchList.row( $(this).parents('tr') ).data();
  
  $.ajax({
    url: "../program_assets/php/web/masterfile.php",
    data: { 
      command   : 'delete_branch',
      currentBranchID : currentBranchID,
    },
    type: 'post',
    success: function (data) {
      var data = jQuery.parseJSON(data);
              
      JAlert(data[0].message,data[0].color);
      
      if (!data[0].error) {
          loadMapping();
          loadBranches();
          oldBranchName = "";
          currentBranchID = 0;
          isNewBranch = 1;
          $("#txtBranchName").val("");
          $("#txtBranchAddress").val("");
          $("#txtCoordinates").val("");
      }
    }
  });
});


/* Client POC */
var tblClientAssignment;

$("#btnClientAssignment").click(function(){
	$("#cmbClients").val(null).trigger('change.select2');
    $("#mdAddUser").modal("hide");
    $("#mdClientPOC").modal("show");
    loadClientsAssigned();
});


function loadClientsAssigned() {
    tblClientAssignment = 
    $('#tblClientAssignment').DataTable({
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
        	'url'       : '../program_assets/php/web/masterfile.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_pic_client',
                userID : userID
        	}    
        },
        'aoColumns' : [
        	{ mData: 'clientsName'},
            { mData: 'address'},
            { mData: 'id',
                render: function (data,type,row) {
                    return '<div class="input-group">' + 
                           '	<button id="list_' + row.id + '" name="list_' + row.id + '" type="submit" class="btn btn-default btn-xs dt-button list">' +
                           '		<i class="fa fa-trash"></i>' +
                           '	</button>' +
                           '</div>';
                }
            }
        ],
        'aoColumnDefs': [
        	{"className": "custom-center", "targets": [2]},
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

$("#btnAddClientPIC").click(function(){
	var clientID = $("#cmbClients").val();
    
    if (clientID == null) {
        JAlert("Please select a client first","red");
    } else {
        $.ajax({
            url: "../program_assets/php/web/masterfile",
            data: {
                command   : 'add_pic_client',
                clientID  : clientID,
                userID    : userID
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
                
                JAlert(data[0].message,data[0].color);
        
                if (!data[0].error) {
                    loadClientsAssigned();
                }
            }
        });
    }
});

$('#tblClientAssignment tbody').on('click', 'td button', function (){
	var data = tblClientAssignment.row( $(this).parents('tr') ).data();
    
    $.ajax({
        url: "../program_assets/php/web/masterfile",
        data: {
            command   : 'delete_pic_client',
            clientID  : data.id
        },
        type: 'post',
        success: function (data) {
            var data = jQuery.parseJSON(data);
            
            JAlert(data[0].message,data[0].color);
    
            if (!data[0].error) {
                loadClientsAssigned();
            }
        }
    });
});

/* Area Assignment */
var tblUserAssignment;
var currentUserAssignmentID;
var tblClientAssignment;

loadUserAssignment();

function loadUserAssignment() {
    tblUserAssignment = 
    $('#tblUserAssignment').DataTable({
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
            className: "btn btn-default btn-sm hide btn-export-user-assignment",
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
        		command : 'display_user_assignment',
        	}    
        },
        'aoColumns' : [
        	{ mData: 'userID'},
            { mData: 'username'},
            { mData: 'firstName'},
            { mData: 'middleName'},
            { mData: 'lastName'},
            { mData: 'mobileNumber'},
            { mData: 'emailAddress'},
            { mData: 'position'},
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
        	{"className": "custom-center", "targets": [10]},
        	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7,8,9]},
        	{ "width": "1%", "targets": [10] },
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

$("#btnExportUserAssigment").click(function(){
	$(".btn-export-user-assignment").click();
});

$('#txtSearchUserAssignment').keyup(function(){
    tblUserAssignment.search($(this).val()).draw() ;
});

$('#tblUserAssignment tbody').on('click', 'td button', function (){
	var data = tblUserAssignment.row( $(this).parents('tr') ).data();
    
    currentUserAssignmentID = data.id;
     
    $("#mdAreaAssignment").modal("show");
    $("#cmbClientAssignment").val(null).trigger('select2.change');
    loadAreaAssignments(0);
    loadAreaTableAssignments();
});

$("#cmbClientAssignment").on("change", function() {
    var value = $(this).val();
    var text  = $("#cmbAreaAssignment").find("option:selected").text();
    
    loadAreaAssignments(value);
});

$("#btnAddAreaAssignment").click(function(){
	var clientID = $("#cmbClientAssignment").val();
    var areaID   = $("#cmbAreaAssignment").val();
    
    if (clientID == null || areaID == null) {
        JAlert("Please select a client and area","red");
    } else {
        $.ajax({
            url: "../program_assets/php/web/masterfile",
            data: {
                command   : 'add_area_assignment',
                userID    : currentUserAssignmentID,
                clientID  : clientID,
                areaID    : areaID
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
                
                JAlert(data[0].message,data[0].color);
        
                if (!data[0].error) {
                    loadAreaTableAssignments();
                }
            }
        });
    }
});


function loadAreaTableAssignments() {
    tblClientAreaAssignment = 
  $('#tblClientAreaAssignment').DataTable({
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
    	'url'       : '../program_assets/php/web/masterfile.php',
    	'type'      : 'POST',
    	'data'      : {
    		command : 'display_area_client_assign',
            userID  : currentUserAssignmentID
    	}    
    },
    'aoColumns' : [
    	{ mData: 'clientsName'},
        { mData: 'branchName'},
        { mData: 'address'},
        { mData: 'id',
          render: function (data,type,row) {
              return '<div class="input-group">' + 
                     '	<button id="list_' + row.id + '" name="list_' + row.id + '" type="submit" class="btn btn-default btn-xs dt-button list">' +
                     '		<i class="fa fa-trash"></i>' +
                     '	</button>' +
                     '</div>';
          }
      }
    ],
    'aoColumnDefs': [
    //	{"className": "custom-center", "targets": [8]},
    	{"className": "dt-center", "targets": [0,1,2,3]},
    	{ "width": "1%", "targets": [0,1,3] },
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

$('#tblClientAreaAssignment tbody').on('click', 'td button', function (){
	var data = tblClientAreaAssignment.row( $(this).parents('tr') ).data();
    
    $.ajax({
        url: "../program_assets/php/web/masterfile",
        data: {
            command   : 'delete_co_ass',
            id  : data.id
        },
        type: 'post',
        success: function (data) {
            var data = jQuery.parseJSON(data);
            
            JAlert(data[0].message,data[0].color);
    
            if (!data[0].error) {
                loadAreaTableAssignments();
            }
        }
    });
});

function loadAreaAssignments(value) {
    $.ajax({
        url: "../program_assets/php/web/masterfile",
        data: {
            command  : 'display_area_assignment',
            clientID : value   
        },
        type: 'post',
        success: function (data) {
            var data = jQuery.parseJSON(data);
            
            $('#cmbAreaAssignment').empty();
            $('#cmbAreaAssignment').html('<option value="" selected disabled>Please select an area</option>');
            
            for (var i = 0; i < data.length; i++) {
                $('#cmbAreaAssignment').append(new Option(data[i].area, data[i].id));
            }
        }
    });
}




function submitBday() {
    var Q4A = "Your birthday is: ";
    var Bdate = document.getElementById('txtBirthday').value;
    var Bday = +new Date(Bdate);
    Q4A += Bdate + ". You are " + ~~ ((Date.now() - Bday) / (31557600000));
    currentAge = ~~ ((Date.now() - Bday) / (31557600000));
    console.log(currentAge);
    //var theBday = document.getElementById('resultBday');
    //theBday.innerHTML = Q4A;
}