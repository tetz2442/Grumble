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
					$("#contact-error").html("Cannot leave a field blank");
					$("#contact-error").addClass("error");
					$("#contact-error").removeClass("available");
				}
				else if($("#contact-textarea").val().length > 255) {
					$("#contact-error").html("Message has to be less than 255 characters");
					$("#contact-error").addClass("error");
					$("#contact-error").removeClass("available");
				}
				else if(!checkEmail($("#email-contact"))) {
					//email not valid
					$("#contact-error").html("Email not valid");
					$("#contact-error").addClass("error");
					$("#contact-error").removeClass("available");
				}
				else {
					sending = true;
					$("#contact-error").html("Sending...");
					$("#contact-error").removeClass("error");
					$("#contact-error").addClass("available");
					
					var name = $("#fullname-contact").val();
					var email = $("#email-contact").val();
					var message = $("#contact-textarea").val();
					var type = $(".contact-dropdown").val();
					$.post("php/contactajax.php", {name:name, email:email, message:message, type:type},
					  function(result) {
						  sending = false;
						  if(result == 1) {
							$("#contact-form").html("Message sent successfully. Thank you.");
							$("#contact-form").addClass("text-align-center");
						  }
						  else {
							$("#contact-error").html("Message could not send. Please Retry.");
							$("#contact-error").addClass("error");
							$("#contact-error").removeClass("available");
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
					$("#contact-error").html("Message cannot be blank");
					$("#contact-error").addClass("error");
					$("#contact-error").removeClass("available");
				}
				else if($("#contact-textarea").val().length > 255) {
					$("#contact-error").html("Message has to be less than 255 characters");
					$("#contact-error").addClass("error");
					$("#contact-error").removeClass("available");
				}
				else {
					sending = true;
					$("#contact-error").html("Sending...");
					$("#contact-error").removeClass("error");
					$("#contact-error").addClass("available");
					
					var username = $("#contact-username").val();
					var message = $("#contact-textarea").val();
					var type = $(".contact-dropdown").val();
					$.post("php/contactajax.php", {username:username, message:message, type:type},
					  function(result) {
						  sending = false;
						  if(result == 1) {
							$("#contact-form").html("Message sent successfully. Thank you.");
							$("#contact-form").addClass("text-align-center");
						  }
						  else {
							$("#contact-error").html("Message could not send. Please Retry.");
							$("#contact-error").addClass("error");
							$("#contact-error").removeClass("available");
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