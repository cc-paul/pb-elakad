var tblProjects;
var tabStatus = "";
var previousID = 0;

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
        	'url'       : '../program_assets/php/web/kpi.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_projects',
                filter  : tabStatus
        	}    
        },
        'aoColumns' : [
            { mData: 'projectNumber'},
            { mData: 'quotationNumber'},
            { mData: 'poNumber'},
            { mData: 'quotationSubject'},
            { mData: 'clientsName'},
            { mData: 'total'},
            { mData: 'startDate'},
            { mData: 'endDate'},
            { mData: 'status'},
            { mData: 'fullName'}
        ],
        //'aoColumnDefs': [
        //	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7,8,9]},
        //    //{ "width": "20%", "targets": [4] },
        //    //{ "width": "9%", "targets": [8] }
        //],
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


$('#tblProjects tbody').on('click', 'td', function (){
	var data = tblProjects.row( $(this).parents('tr') ).data();
    
    $("#dvTitleHolder").html('<i class="fa fa-fw fa-bar-chart"></i> ' + data.projectNumber);
    
    var progress = (Number(data.totalInstalled.replaceAll(",","")) / Number(data.totalQty.replaceAll(",",""))) * 100;
    
    console.log(data.totalInstalled.replaceAll(",",""));
    console.log(data.totalQty.replaceAll(",",""));
    
    if (Number(data.totalInstalled.replaceAll(",","")) == Number(data.totalQty.replaceAll(",",""))) {
        progress = 100;
    }
    
    var progress2 = 100 - progress;
    
    $('#dvProgress1').css("width",progress + "%");
    $('#dvProgress2').css("width",progress2 + "%");
    
    $("#spStartDate").text(data.startDate);
    $("#spEndDate").text(data.endDate);
    
    $("#sp1").text(data.totalQty);
    $("#sp2").text(data.totalDelivered);
    $("#sp3").text(data.totalInstalled);
    $("#sp4").text(data.totalUpdatedStocks);
    
    $("#spd1").text(data.clientsName);
    $("#spd2").text(data.address);
    $("#spd3").text(data.contactPerson);
    $("#spd4").text(data.landLine);
    $("#spd5").text(data.contactNumber);
    $("#spd6").text(data.emailAddress);
    
    $("#spde1").text(data.quotationSubject);
    $("#spde2").text(data.total);
    $("#spde3").text(data.startDate);
    $("#spde4").text(data.endDate);
    $("#spde5").text(data.status);
    $("#spde6").text(data.fullName);
    $("#spde7").text(data.reason);
    
    var arrMaterials = [];
    
    //arrMaterials.push(Number(data.totalQty));
    //arrMaterials.push(Number(data.totalDelivered));
    arrMaterials.push(Number(data.totalInstalled));
    arrMaterials.push(Number(data.totalUpdatedStocks));
    
    console.log(arrMaterials);
    
    generatePieGraph('myCanvas', {
        animation: true, 
        // Animation speed
        animationSpeed: 20, 
        // Shows value & text
        fillTextData: true,
        // Text color
        fillTextColor: '#fff',
        // Higher values gives closer view to center 
        fillTextAlign: 1.85,
        // 'horizontal' or 'vertical' or 'inner'
        fillTextPosition: 'inner', 
        values: arrMaterials,
        colors: ['#00a65a', '#f39c12', ]
    });
});