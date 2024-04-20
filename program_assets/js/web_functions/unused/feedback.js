var tblFeedBack;


loadFeedBack();
function loadFeedBack() {
    tblFeedBack = 
    $('#tblFeedBack').DataTable({
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
        	'url'       : '../program_assets/php/web/feedback.php',
        	'type'      : 'POST',
        	'data'      : {
        		saving_mode : 'all',
        	}    
        },
        'aoColumns' : [
        	{ mData: 'fullName'},
            { mData: 'dateCreated'},
            { mData: 'feedBack'}
        ],
        //'aoColumnDefs': [
        //	{"className": "custom-center", "targets": [8]},
        //	{"className": "dt-center", "targets": [0,1,2,3,4,5,6,7]},
        //	{ "width": "1%", "targets": [8] },
        //	{"className" : "hide_column", "targets": [9]} 
        //],
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
        }
    }).on('user-select', function (e, dt, type, cell, originalEvent) {
        if ($(cell.node()).parent().hasClass('selected')) {
            e.preventDefault();
        }
    });
}

$('#txtSearch').keyup(function(){
    tblFeedBack.search($(this).val()).draw() ;
});