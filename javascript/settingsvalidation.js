// JavaScript Document
var expSC = /[!@#%*+=~`$&^]/;
var username = false;
var saving = false;
var changes = false;
var usernamechange = false;
var passwords = false;

$(document).ready(function() {
	$("#email-noti-thread").change(function () {
		changes = true;
	});
	$("#email-noti-comment").change(function () {
		changes = true;
	});
	$("#username-change-input").keyup(function () {
		usernamechange = true;
	});
			
	$(".button").click(function() {
		if($(this).text() == "Save") {
			var chars = $('#username-change-input').val();
			var currentpass = $("#pass-current").val();
			var newpass = $("#pass-change").val();
			var newpass2 = $("#pass-change2").val();
			var threadcheck = $("#email-noti-thread").is(":checked");
			var commentcheck = $("#email-noti-comment").is(":checked");
			
			if(usernamechange && chars != $(".dropdown-login").text()) {
				if(checkLength($('#username-change-input'), 3)) {
					if(checkSC($('#username-change-input'))) {
						if(!chars.match(/\s/g)) {
							$.post("/php/checkavail.php", {username:chars, settings:true},
								  function(result) {
									  if(result == 1) {
										  $("#notification-bar p").html("Username Available.").removeClass("error").addClass("available");
										  $("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(1000).fadeOut("slow");
										  username = true;
									  }
									  else if(result == 0) {
										  $("#notification-bar p").html("Username not available.").addClass("error").removeClass("available");
										  $("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
										  username = false;
									  }
									  else {
										  username = false;
									  }
							});
						}
						else {
							$("#notification-bar p").html("Username cannot contain spaces.").addClass("error").removeClass("available");
							$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
						}
					}
					else {
						$("#notification-bar p").html("Username cannot contain special characters.").addClass("error").removeClass("available");
						$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
					}
				}
				else {
					$("#notification-bar p").html("Username must be at least 4 characters.").addClass("error").removeClass("available");
					$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
				}
			}
			
			if(currentpass != "" && newpass != "" && newpass2 != "") {
				if(checkLength($('#pass-current'), 5) || checkLength($('#pass-change'), 5) || checkLength($('#pass-change'), 5)) {
					passwords = true;
				}
				else {
					passwords = false;
					$("#notification-bar p").html("Passwords must be over 5 characters.").addClass("error").removeClass("available");
					$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
				}
			}
			
			if(username || changes || passwords) {
				if(!saving) {
					$("#gif-loader-settings").fadeIn("fast");
					saving = true;
					$("#notification-bar p").html("Saving...").removeClass("error").addClass("available");
					$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(1000).fadeOut("slow");
						
					$.post("/php/settingsajax.php", {user:chars, usernamevalid:username, currentpass:currentpass, newpass:newpass, newpass2:newpass2, threadcheck:threadcheck, commentcheck:commentcheck},
						function(result) {
							alert(result);
						$("#gif-loader-settings").fadeOut("fast");
						saving = false;
					});
				}
			}
			/*else {
				$("#notification-bar p").html("No changes detected.").addClass("error").removeClass("available");
				$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
			}*/
		}
	});
});

function checkLength(element, chars_allowed) {
	if(element.val().length > chars_allowed) {
		return true;	
	}
	else {
		return false;	
	}
}

function checkSC(element) {
	if(element.val() == "") {
		return false;
	}
	else {
		return !expSC.test(element.val());
	}
}
