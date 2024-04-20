var one_time = 0;

$("#btn_signin").click(function(){
	login();
});

$(".login").keyup(function(event) {
    if (event.keyCode === 13) {
        login();
    }
});

function login () {
	var username = $("#txt_username").val();
	var password = $("#txt_password").val();

	if (username == "" || password == "") {
		JAlert("Please provide all Account Details","red");
	} else {
		$.ajax({
		    url: '../program_assets/php/web/login.php',
		    data: {
		        'username': username,
		        'password': password
		    },
		    type: 'post',
		    success: function(data) {
		    	var hasAccess = data.trim();
				
				if (hasAccess == 1) {
					window.location.href = "../pages/profile";
				} else {
					JAlert("Account does not exist","red");
				}
		    }
		});
	}
}

function JConfirm (message,confirmCallback) {
	var [c_message,c_color] = message.split('-');
	var default_color;
	
	if (c_color == null) {
		default_color = "orange";
	} else {
		default_color = c_color;
	}
	
	$.confirm({
		title    : 'System Message',
		content  : c_message,
		type     : default_color,
		icon     : 'fa fa-question-circle',
		backgroundDismiss : false,
		backgroundDismissAnimation : 'glow',
		buttons: {
			confirm: confirmCallback
		}
	});
}

function JAlert (message,type,confirmCallback) {
	$.alert({
		title    : 'System Message',
		content  : message,
		type     : type,
		icon     : 'fa fa-warning',
		backgroundDismiss : false,
		backgroundDismissAnimation : 'glow'
	});
}