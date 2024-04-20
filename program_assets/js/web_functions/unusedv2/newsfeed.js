var isNewNews;
var tblNewsFeed;
var oldTitle;
var id;
var newsFeedID;

loadStory();

function loadStory() {
    tblNewsFeed = 
    $('#tblNewsFeed').DataTable({
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
            className: "btn btn-default btn-sm hide btn-export-story",
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
        	'url'       : '../program_assets/php/web/newsfeed.php',
        	'type'      : 'POST',
        	'data'      : {
        		command : 'display_feed',
        	}    
        },
        'aoColumns' : [
        	{ mData: 'title'},
            { mData: 'story',
                render: function (data,type,row) {
                    return row.story.substring(0,90) + '...';
                }
            },
            { mData: 'status'},
            { mData: 'fullName'},
            { mData: 'fdateCreated'},
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
        	{"className": "custom-center", "targets": [5]},
        	{"className": "dt-center", "targets": [0,1,2,3,4]},
        	{ "width": "1%", "targets": [0,2,3,4,5] },
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

$("#btnAddStory").click(function(){
    $("#txtTitle").val(null);
    $("#txtStory").val(null);
    $("#lblCount").text("(0)");
    isNewNews = 1;
    oldTitle = "";
    id = 0;
    $("#dvImages").hide();
    $("#btnAttach").hide();
    
    $("#chkActive").prop("checked", true);
    $("#chkActive").prop("disabled", true);
    
	$("#mdNewsFeed").modal("show");
});

$('#txtStory').on('input',function(e){
	$("#lblCount").text("(" + $('#txtStory').val().length + ")");
});

$('#tblNewsFeed tbody').on('click', 'td button', function (){
	var data = tblNewsFeed.row( $(this).parents('tr') ).data();
    
    $("#txtTitle").val(data.title);
    $("#txtStory").val(data.story);
    $("#lblCount").text("(" + $('#txtStory').val().length + ")");
    isNewNews = 0;
    oldTitle = data.title;
    id = data.id;
    
    $("#chkActive").prop("checked", data.isActive == 1 ? true : false);
    $("#mdNewsFeed").modal("show");
    
    
    loadImage();
});

function loadImage() {
    $("#dvImages").show();
    $("#btnAttach").show();
    
    $.ajax({
        url: "../program_assets/php/web/newsfeed",
        data: {
            command   : 'display_image',
            id : id
        },
        type: 'post',
        success: function (data) {
            var data = jQuery.parseJSON(data);
            
            $('#dvImages').html("");
            
            for (var i = 0; i < data.length; i++) {
                $('#dvImages').append("" +
                                      
                    '<div class="col-sm-3 col-sm-12">' +
                    '    <br>' +
                    '    <img class="img-responsive image-custom" src="../photos/'+ data[i].fileName +'" alt="Photo">' +
                    '    <button id="btnDeleteImage" type="button" class="btn btn-block btn-default btn-sm cust-textbox" onclick="deleteImage('+ data[i].id +')">' +
                    '        <i class="fa fa-trash"></i>' +
                    '    </button>' +
                    '</div>'
                                          
                );
            }
        }
    });
}

$("#btnSaveStory").click(function(){
    var title = $("#txtTitle").val();
    var story = $("#txtStory").val();
    var isActive;
    
    if ($("#chkActive").prop('checked') == true) {
        isActive = 1;
    } else {
        isActive = 0;
    }
    
    if (title == "" || story == "") {
        JAlert("Please fill in required fields","red");
    } else if ($('#txtStory').val().length < 500) {
        JAlert("Story must be at least 500 characters","red");
    } else {
        $.ajax({
            url: "../program_assets/php/web/newsfeed",
            data: {
                command  : 'save_news',
                isNewNews : isNewNews,
                title : title,
                story : story,
                isActive : isActive,
                oldTitle : oldTitle,
                id : id
            },
            type: 'post',
            success: function (data) {
                var data = jQuery.parseJSON(data);
                
                JAlert(data[0].message,data[0].color);
                
                if (!data[0].error) {
                    loadStory();
                    $("#mdNewsFeed").modal("hide");
                }
            }
        });
    }
});

$("#btnExportStory").click(function(){
	$(".btn-export-story").click();
});

$('#txtSearchStory').keyup(function(){
    tblNewsFeed.search($(this).val()).draw() ;
});

function openImage() {
    javascript:document.getElementById('image_uploader').click();
}

$('#image_uploader').change(function (e) {
	var file_data = $('#image_uploader').prop('files')[0];
	var form_data = new FormData();
    form_data.append('file', file_data);
	form_data.append('newsFeedID', id);
	$.ajax({
	    url: '../program_assets/php/upload/upload_photos.php',
	    dataType: 'text',
	    cache: false,
	    contentType: false,
	    processData: false,
	    data: form_data,
	    type: 'post',
	    success: function(data) {
            var data = jQuery.parseJSON(data);
                
            JAlert(data[0].message,data[0].color);
            
            if (!data[0].error) {
                loadImage();
            }
            
            //location.reload();
        }
	});
});

function deleteImage(id) {
    $.ajax({
        url: "../program_assets/php/web/newsfeed",
        data: {
            command  : 'delete_image',
            id : id
        },
        type: 'post',
        success: function (data) {
            var data = jQuery.parseJSON(data);
            
            if (!data[0].error) {
                loadImage();
            }
        }
    });
}