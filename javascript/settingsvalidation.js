// JavaScript Document
var expSC = /[!@#%*+=~`$&^]/;
var username = false;
var saving = false;
var changes = false;
var passwords = false;

$(document).ready(function() {
	var usernameval = $(".dropdown-login").text();
	
	$("#email-noti-thread").change(function () {
		changes = true;
	});
	$("#email-noti-comment").change(function () {
		changes = true;
	});
	$("#username-change-input").keyup(function () {
		var element = $(this);
		if(chars != $(".dropdown-login").text()) {
			if(checkLength(element, 3)) {
				if(checkSC(element)) {
					var chars = $('#username-change-input').val();
					if(!chars.match(/\s/g)) {
						$.post("/php/checkavail.php", {username:chars, settings:true},
							  function(result) {
								  if(result == 1) {
									  $("#notification-bar p").html("Username Available.").removeClass("error").addClass("available");
									  showBar();
									  username = true;
								  }
								  else if(result == 0) {
									  $("#notification-bar p").html("Username not available.").addClass("error").removeClass("available");
									  showBar();
									  username = false;
								  }
								  else {
									  username = false;
								  }
						});
					}
					else {
						$("#notification-bar p").html("Username cannot contain spaces.").addClass("error").removeClass("available");
						$(element).parent().find(".gif-loader-settings").fadeIn(2000);
						showBar();
					}
				}
				else {
					$(element).parent().find(".gif-loader-settings").fadeIn(2000);
					$("#notification-bar p").html("Username cannot contain special characters.").addClass("error").removeClass("available");
					showBar();
				}
			}
			else {
				$(element).parent().find(".gif-loader-settings").fadeIn(2000);
				$("#notification-bar p").html("Username must be at least 4 characters.").addClass("error").removeClass("available");
				showBar();
			}
		}
	}).focusout(function() {
		hideBar();
	});
	
	$("#pass-change").keyup(function () {
		var element = $(this);
		if(checkLength(element, 5)) {
			$(element).parent().find(".validation-settings:eq(0)").fadeIn(2000);
			passwords = true;
		}
		else {
			passwords = false;
		}
	}).focusout(function() {
		hideBar();
	});
	
	$("#pass-change2").keyup(function () {
		var element = $(this);
		if(checkPasswordMatch() && checkLength($("#pass-change"), 5)) {
			$(element).parent().find(".validation-settings:eq(1)").fadeIn(2000);
			passwords = true;
		}
		else {
			passwords = false;
		}
	}).focusout(function() {
		hideBar();
	});
			
	$(".button").click(function() {
		if($(this).text() == "Save") {
			var chars = $('#username-change-input').val();
			var currentpass = $("#pass-current").val();
			var newpass = $("#pass-change").val();
			var newpass2 = $("#pass-change2").val();
			var threadcheck = $("#email-noti-thread").is(":checked");
			var commentcheck = $("#email-noti-comment").is(":checked");
			
			if(username || changes || passwords) {
				if(!saving) {
					$("#gif-loader-settings").fadeIn("fast");
					saving = true;
					$("#notification-bar p").html("Saving...").removeClass("error").addClass("available");
					$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast");
						
					$.post("/php/settingsajax.php", {user:chars, username:usernameval, currentpass:currentpass, newpass:newpass, newpass2:newpass2, threadcheck:threadcheck, commentcheck:commentcheck},
						function(result) {
						if(result == 1) {
							$("#notification-bar p").html("Success. Redirecting to homepage...").removeClass("error").addClass("available");
							$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).delay(1000, function() {
								location = "http://" + window.location.hostname;
							});
						}
						else if(result == 2) {
							$("#notification-bar p").html("Success.").removeClass("error").addClass("available");
							$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
						}
						else if(result == 0) {
							$("#notification-bar p").html("Something went wrong. Please check your entries.").addClass("error").removeClass("available");
							$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
						}
						$("#gif-loader-settings").fadeOut("fast");
						//$("#settings-holder").stop().animate({"top":"-500px"}, "slow");
						//$("#settings-background").stop().fadeOut("slow");
						//clear fields
						$("#pass-current").val();
						$("#pass-change").val();
						$("#pass-change2").val();
					});
				}
			}
			else {
				$("#notification-bar p").html("No changes detected.").addClass("error").removeClass("available");
				$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
			}
		}
	});
});

function showBar() {
	if(!$("#notification-bar").is(":visible")) {
		$("#notification-bar").stop().fadeIn("fast");
	}
	$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2));
}

function hideBar() {
	if($("#notification-bar").is(":visible")) {
		$("#notification-bar").stop().fadeOut("fast");
	}
}

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

function checkPasswordMatch() {
	if($("#pass-change").val() ==  $("#pass-change2").val() && $("#pass-change").val() != "" && $("#pass-change2").val() != "") {
		return true;	
	}
	else {
		return false;	
	}
}
