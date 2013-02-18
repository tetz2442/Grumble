// JavaScript Document
var expSC = /^[a-zA-Z0-9_]*$/;
var username = false;
var saving = false;
var changes = false;
var passwords = false;
var timezone = false;

$(document).ready(function() {
	var usernameval = $(".dropdown-login").text();
	var timezoneval = $("#tz").val();
	
	$("#email-noti-thread").change(function () {
		changes = true;
	});
	$("#email-noti-comment").change(function () {
		changes = true;
	});
	$("#tz").change(function () {
		if($("#tz").val() != timezoneval)
			timezone = true;
		else
			timezone = false;
	});
	$("#username-change-input").keyup(function () {
		var $element = $(this);
		var chars = $('#username-change-input').val();
		if(chars != usernameval) {
			if(checkLength($element, 3)) {
				if(checkSC($element)) {
					if(!chars.match(/\s/g)) {
						$element.parent().find(".validation-settings").attr("src","/images/ajax-loader.gif").fadeIn(250);
						$.post("/php/checkavail.php", {username:chars, settings:true},
							  function(result) {
								  if(result == 1) {
									  $("#notification-bar p").html("Username Available.").removeClass("error").addClass("available");
									  $element.parent().find(".validation-settings").attr("src","/images/icons/tick-circle_1.png");
									  showBar();
									  username = true;
								  }
								  else if(result == 0) {
									  $("#notification-bar p").html("Username not available.").addClass("error").removeClass("available");
									  $element.parent().find(".validation-settings").attr("src","/images/icons/exclamation-red_1.png");
									  showBar();
									  username = false;
								  }
								  else {
									  $element.parent().find(".validation-settings").fadeOut(250);
									  username = false;
								  }
						});
					}
					else {
						$("#notification-bar p").html("Username cannot contain spaces.").addClass("error").removeClass("available");
						$element.parent().find(".validation-settings").attr("src","/images/icons/exclamation-red_1.png").fadeIn(250);
						showBar();
					}
				}
				else {
					$element.parent().find(".validation-settings").attr("src","/images/icons/exclamation-red_1.png").fadeIn(250);
					$("#notification-bar p").html("Username cannot contain special characters.").addClass("error").removeClass("available");
					showBar();
				}
			}
			else {
				$element.parent().find(".validation-settings").attr("src","/images/icons/exclamation-red_1.png").fadeIn(250);
				$("#notification-bar p").html("Username must be at least 4 characters.").addClass("error").removeClass("available");
				showBar();
			}
		}
		else {
			 $element.parent().find(".validation-settings").fadeOut(250);
			 hideBar();
			 username = false;
		}
	}).focusout(function() {
		hideBar();
	});
	
	$("#pass-change").keyup(function () {
		var element = $(this);
		if(!checkLength(element, 5)) {
			$(element).parent().find(".validation-settings:eq(0)").attr("src","/images/icons/exclamation-red_1.png").fadeIn(250);
			passwords = false;
		}
		else if(!$(this).val().match(/[A-Z]/)) {
			$(element).parent().find(".validation-settings:eq(0)").attr("src","/images/icons/exclamation-red_1.png").fadeIn(250);
			passwords = false;
		}
		else if(!$(this).val().match(/[0-9]/)) {
			$(element).parent().find(".validation-settings:eq(0)").attr("src","/images/icons/exclamation-red_1.png").fadeIn(250);
			passwords = false;
		}
		else {
			$(element).parent().find(".validation-settings:eq(0)").attr("src","/images/icons/tick-circle_1.png").fadeIn(250);
			passwords = true;
		}
	}).focusout(function() {
		hideBar();
	});
	
	$("#pass-change2").keyup(function () {
		var element = $(this);
		if(checkPasswordMatch($("#pass-change"),$("#pass-change2")) && checkLength($("#pass-change"), 5)) {
			$(element).parent().find(".validation-settings:eq(1)").attr("src","/images/icons/tick-circle_1.png").fadeIn(250);
			passwords = true;
		}
		else {
			$(element).parent().find(".validation-settings:eq(1)").attr("src","/images/icons/exclamation-red_1.png").fadeIn(250);
			passwords = false;
		}
	}).focusout(function() {
		hideBar();
	});
			
	$(".button").click(function(event) {
		if($(this).text() == "Save") {
			var chars = $('#username-change-input').val();
			var currentpass = $("#pass-current").val();
			var newpass = $("#pass-change").val();
			var newpass2 = $("#pass-change2").val();
			var tz = $("#tz").val();
			var threadcheck = $("#email-noti-thread").is(":checked");
			var commentcheck = $("#email-noti-comment").is(":checked");
			
			if(username || changes || passwords || timezone) {
				if(!saving) {
					var tabs = $("#settings-holder").find(".tabs a.active").text();
					var obj;
					//get object to send
					if(tabs == "Username" && username)
						obj = {user:chars, username:usernameval};
					else if(tabs == "Email" && changes)
						obj = {threadcheck:threadcheck, commentcheck:commentcheck, username:usernameval};
					else if (tabs == "Password" && passwords)
						obj = {currentpass:currentpass, newpass:newpass, newpass2:newpass2, username:usernameval};
					else if(tabs == "Timezone" && timezone)
						obj = {timezone:tz, username:usernameval};
					else
						obj = "none";

					if(obj != "none") {
						$("#gif-loader-settings").fadeIn("fast");
						saving = true;
						$("#notification-bar p").html("Saving...").removeClass("error").addClass("available");
						$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast");
					
						$.post("/php/settingsajax.php", obj,
							function(result) {
							if(result == 1) {
								usernameval = chars;
								$("#notification-bar p").html("Success, username changed. Refreshing page...").removeClass("error").addClass("available");
								$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).delay(1000).queue(function() {
									location = "http://" + window.location.hostname + "/profile/" + chars + "#settings";
								});
							}
							else if(result == 2) {
								saving = false;
								$("#notification-bar p").html("Success. Password has been Changed.").removeClass("error").addClass("available");
								$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
							}
							else if(result == 3) {
								saving = false;
								$("#notification-bar p").html("Success. Email settings changed.").removeClass("error").addClass("available");
								$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
							}
							else if(result == 4) {
								saving = false;
								$("#notification-bar p").html("Success, timezone changed. Refreshing page...").removeClass("error").addClass("available");
								$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).delay(1000).queue(function() {
									window.location.reload();
								});
							}
							else if(result == 5) {
								saving = false;
								$("#notification-bar p").html("Current password did not match. Settings not changed.").addClass("error").removeClass("available");
								$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
							}
							else if(result == 0) {
								saving = false;
								$("#notification-bar p").html("Something went wrong. Please check your entries.").addClass("error").removeClass("available");
								$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
							}
							else {
								saving = false;
								$("#notification-bar p").html("Error. Please contact us with details.").addClass("error").removeClass("available");
								$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
							}
							
							if(newuser) {
								location = "http://" + window.location.hostname;
							}
							$("#gif-loader-settings").fadeOut("fast");
							
							if(result != 0) {
								//clear fields
								$("#pass-current").val("");
								$("#pass-change").val("");
								$("#pass-change2").val("");
								$("#pass-change").parent().find(".validation-settings:eq(0)").fadeOut(500);
								$("#pass-change2").parent().find(".validation-settings:eq(1)").fadeOut(500);
								username = false;
								passwords = false;
								changes = false;
							}
						});
					}
					else {
						$("#notification-bar p").html("No changes detected on this tab.").addClass("error").removeClass("available");
						$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
					}
				}
			}
			else {
				$("#notification-bar p").html("No changes detected.").addClass("error").removeClass("available");
				$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
			}
		}
		else if ($(this).val() == "Reset Password") {
			if(!passwords) {
				event.preventDefault();
			}
		}
	});
	
	$("a.red").click(function() {
		if($(this).text() == "Delete Account") {
			var deleting = false;
			event.preventDefault();
			var deleteAccount = confirm("Are you sure you want to delete your Grumble account?\n\n All of your Grumbles, Comments, Replies, and settings data will be PERMANENTALY deleted.");
			if(deleteAccount && !deleting) {
				deleting = true;
				$("#notification-bar p").html("Deleting account...").removeClass("error").addClass("available");
				$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(1000).fadeOut("slow");
				$.post("/php/settingsajax.php", {action:"Delete"},
					function(result) {
					if(result == 1) {
						$("#notification-bar p").html("Success, account deleted.").removeClass("error").addClass("available");
						$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2000).queue(function() {
							location = "http://" + window.location.hostname;
						});
					}
					else {
						deleting = false;
						$("#notification-bar p").html("Error. Please try again.").addClass("error").removeClass("available");
						$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
					}
				});
			}
		}
	});
	
	$("#settings-dropdown").click(function () {
		$("#settings-holder").css("top","46px");
		$("#settings-background").stop().fadeIn("normal");
		
		$("#dropdown-form").fadeOut(50, function() {
			$("#dropdown-form").parents("body").find(".login-drop-image").attr("src", "/images/arrow.png");
		});
		
		$("#settings-background").click(function() {
			$("#settings-holder").stop().animate({"top":"-500px"}, "normal");
			$("#settings-background").stop().fadeOut("normal");
		});
	});

	$("#pass-forg").keyup(function () {
		var element = $(this);
		if(!checkLength(element, 5)) {
			$("#notification-bar p").html("Password is not long enough.").addClass("error").removeClass("available");
			showBar();
			passwords = false;
		}
		else if(!$(this).val().match(/[A-Z]/)) {
			$("#notification-bar p").html("Password must contain a capital letter.").addClass("error").removeClass("available");
			showBar();
			passwords = false;
		}
		else if(!$(this).val().match(/[0-9]/)) {
			$("#notification-bar p").html("Password must contain a number.").addClass("error").removeClass("available");
			showBar();
			passwords = false;
		}
		else {
			$("#notification-bar p").html("Valid password.").removeClass("error").addClass("available");
			showBar();
			passwords = true;
		}
	}).focusout(function() {
		hideBar();
	});
	
	$("#pass-forg2").keyup(function () {
		var element = $(this);
		if(checkPasswordMatch($("#pass-forg"),$("#pass-forg2")) && checkLength(element, 5)) {
			$("#notification-bar p").html("Passwords match.").removeClass("error").addClass("available");
			showBar();
			passwords = true;
		}
		else {
			$("#notification-bar p").html("Passwords do not match.").addClass("error").removeClass("available");
			showBar();
			passwords = false;
		}
	}).focusout(function() {
		hideBar();
	});
	
	var cururl = window.location.href;
	var newuser = false;
	if(cururl.indexOf("#settings") != -1) {
		$("#settings-holder").css("top","46px");
		$("#settings-background").stop().fadeIn("normal");
		
		$("#settings-background").click(function() {
			$("#settings-holder").stop().animate({"top":"-500px"}, "normal");
			$("#settings-background").stop().fadeOut("normal");
		});
	}
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
		return expSC.test(element.val());
	}
}

function checkPasswordMatch(field1, field2) {
	if($(field1).val() ==  $(field2).val() && $(field1).val() != "" && $(field2).val() != "") {
		return true;	
	}
	else {
		return false;	
	}
}
