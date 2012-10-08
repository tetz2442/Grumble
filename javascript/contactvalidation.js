// JavaScript Document
var regExpEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z]+\.[a-z]{2,4}$/;

$(document).ready(function() {
	var sending = false;
	$("#contact-send").click(function(event) {
		//non-registered user
		if($("#fullname-contact").length > 0) {
			if(!sending) {
				if($("#fullname-contact").val() == "" || $("#email-contact").val() == "" || $("#contact-textarea").val() == "") {
					//field not filled in
					toastr.warning("Cannot leave a field blank.");
				}
				else if($("#contact-textarea").val().length > 500) {
					toastr.warning("Message has to be less than 500 characters.");
				}
				else if(!checkEmail($("#email-contact"))) {
					//email not valid
					toastr.warning("Email not valid.");
				}
				else {
					sending = true;
					toastr.success("Sending...");
					
					var name = $("#fullname-contact").val();
					var email = $("#email-contact").val();
					var message = $("#contact-textarea").val();
					var type = $(".contact-dropdown").val();
					$.post("/php/ajaxcontact.php", {name:name, email:email, message:message, type:type},
					  function(result) {
						  sending = false;
						  if(result == 1) {
							$("#contact-form").html("Message sent successfully. Thank you.").addClass("text-align-center");
						  }
						  else {
							toastr.error("Message could not send. Please Retry.");
						  }
					});
				}
			}
		}
		//registered user
		else {
			if(!sending) {
				if($("#contact-textarea").val() == "") {
					//field not filled in
					toastr.warning("Cannot leave a field blank.");
				}
				else if($("#contact-textarea").val().length > 500) {
					toastr.warning("Message has to be less than 500 characters.");
				}
				else {
					sending = true;
					toastr.success("Sending...");
					
					var username = $("#contact-username").val();
					var message = $("#contact-textarea").val();
					var type = $(".contact-dropdown").val();
					$.post("/php/ajaxcontact.php", {username:username, message:message, type:type},
					  function(result) {
						  sending = false;
						  if(result == 1) {
							$("#contact-form").html("Message sent successfully. Thank you.").addClass("text-align-center");
						  }
						  else {
							toastr.error("Message could not send. Please Retry.");
						  }
					});
				}
			}
		}
	});
});

function checkEmail(element) {
	if(element.val().match(regExpEmail)) {
		return true;
	}
	else {
		return false;
	}
}