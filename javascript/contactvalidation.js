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
					$("#notification-bar p").html("Cannot leave a field blank.").addClass("error").removeClass("available");
					$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
				}
				else if($("#contact-textarea").val().length > 255) {
					$("#notification-bar p").html("Message has to be less than 255 characters.").addClass("error").removeClass("available");
					$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
				}
				else if(!checkEmail($("#email-contact"))) {
					//email not valid
					$("#notification-bar p").html("Email not valid.").addClass("error").removeClass("available");
					$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
				}
				else {
					sending = true;
					$("#notification-bar p").html("Sending...").removeClass("error").addClass("available");
					$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(1000).fadeOut("slow");
					
					var name = $("#fullname-contact").val();
					var email = $("#email-contact").val();
					var message = $("#contact-textarea").val();
					var type = $(".contact-dropdown").val();
					$.post("/php/contactajax.php", {name:name, email:email, message:message, type:type},
					  function(result) {
						  sending = false;
						  if(result == 1) {
							$("#contact-form").html("Message sent successfully. Thank you.");
							$("#contact-form").addClass("text-align-center");
						  }
						  else {
							$("#notification-bar p").html("Message could not send. Please Retry.").addClass("error").removeClass("available");
							$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
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
					$("#notification-bar p").html("Cannot leave a field blank.").addClass("error").removeClass("available");
					$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
				}
				else if($("#contact-textarea").val().length > 255) {
					$("#notification-bar p").html("Message has to be less than 255 characters.").addClass("error").removeClass("available");
					$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
				}
				else {
					sending = true;
					$("#notification-bar p").html("Sending...").removeClass("error").addClass("available");
					$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(1000).fadeOut("slow");
					
					var username = $("#contact-username").val();
					var message = $("#contact-textarea").val();
					var type = $(".contact-dropdown").val();
					$.post("/php/contactajax.php", {username:username, message:message, type:type},
					  function(result) {
						  sending = false;
						  if(result == 1) {
							$("#contact-form").html("Message sent successfully. Thank you.");
							$("#contact-form").addClass("text-align-center");
						  }
						  else {
							$("#notification-bar p").html("Message could not send. Please Retry.").addClass("error").removeClass("available");
							$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
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