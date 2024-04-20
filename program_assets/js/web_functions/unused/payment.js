var tblPayments;

$("#btnAdd").click(function(){
	$("#mdPaymentGenerator").modal("show");
    $("#txtAmount").val("");
});

$("#btnSave").click(function(){
	var amount = $("#txtAmount").val();
    
    if (amount == "" || amount == 0 || amount < 0) {
        JAlert("Please provide an amount","orange");
    } else {
        $.ajax({
            url: "../program_assets/php/web/payment.php",
            data: {
                command : 'add',
                amount  : amount
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
 
                JConfirm(data[0].message, () => {
                    $("#mdPaymentGenerator").modal("hide");
                    loadPayment();
                });
            }
        });
    }
});

loadPayment();

function loadPayment() {
    tblPayments = 
    $('#tblPayments').DataTable({
        'destroy'       : true,
        'paging'        : true,
        'lengthChange'  : false,
        'pageLength'    : 12,
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
        	'url'       : '../program_assets/php/web/payment.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'view',
        	}    
        },
        'aoColumns' : [
        	{ mData: 'ref'},
            { mData: 'amount'},
            { mData: 'isUsed'},
            { mData: 'fullName'},
            { mData: 'id',
                    render: function (data,type,row) {
                        var disabled = "";
                        
                        if (row.isUsed == "Yes") {
                            disabled="disabled";
                        }
                        
                        return '<div class="input-group">' + 
                               '	<button type="submit" class="btn btn-default btn-xs dt-button list" '+ disabled +'>' +
                               '		<i class="fa fa-trash"></i>' +
                               '	</button>' +
                               '</div>';
                    }
                }
            ],
        'aoColumnDefs': [
        	{"className": "custom-center", "targets": [4]},
        	{"className": "dt-center", "targets": [0,1,2,3]},
        	{ "width": "1%", "targets": [4] }
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
        }
    }).on('user-select', function (e, dt, type, cell, originalEvent) {
        if ($(cell.node()).parent().hasClass('selected')) {
            e.preventDefault();
        }
    });
}


$('#tblPayments tbody').on('click', 'td button', function (){
	var selected_data = tblPayments.row( $(this).parents('tr') ).data();
    
    $.ajax({
        url: "../program_assets/php/web/payment.php",
        data: {
            command : 'delete',
            id : selected_data.id
        },
        type: 'post',
        success: function (data) {
            var data = jQuery.parseJSON(data);

            JConfirm(data[0].message, () => {
                $("#mdPaymentGenerator").modal("hide");
                loadPayment();
            });
        }
    });
});

$('#txtSearch').keyup(function(){
    tblPayments.search($(this).val()).draw() ;
});