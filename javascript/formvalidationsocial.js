// JavaScript Document
var regExpEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z]+\.[a-z]{2,4}$/;
var expSC = /^[a-zA-Z0-9_]*$/;
var expLet = /^[a-zA-Z]*$/;
var username = false;

$(document).ready(function() { 
	$("#username").keyup(function() {
		chars = $('#username').val();
		if(checkLength($('#username'), 3)) {
			if(checkSC($('#username'))) {
				chars = $('#username').val();
				if(!chars.match(/\s/g)) {
					$('#username').parents("li").find(".gif-loader").show();
					$("#usernameError").html("")
					$.post("/php/checkavail.php", {username:chars},
						  function(result) {
							  $('#username').parents("li").find(".gif-loader").hide();
							  if(result == 1) {
								  //success
								  $("#usernameError").html("Available").removeClass("error").addClass("available");
								  username = true;
							  }
							  else if(result == 0) {
								  //not available
								  $("#usernameError").html("Not available").addClass("error").removeClass("available");
								  username = false;
							  }
							  else {
								  $("#usernameError").html("Not available").addClass("error").removeClass("available");
								  username = false;
							  }
					});
				}
				else {
					usernameVal = 0;
					$("#usernameError").html("No spaces allowed").addClass("error").removeClass("available");
					username = false;
				}
			}
			else {
				usernameVal = 0;
				$("#usernameError").html("No special characters allowed").addClass("error").removeClass("available");
				username = false;
			}
		}
		else {
			usernameVal = 0;
			$("#usernameError").html("Must be at least 4 characters").addClass("error").removeClass("available");
			username = false;
		}
	});
	
	$("#userpassword").keyup(function() {
		$("#password2").val("");
		$("#pass2Error").html("");
		if(!checkLength($(this), 5)) {
			$("#passError").html("Not long enough").addClass("error").removeClass("available");
		}
		else if(!$(this).val().match(/[A-Z]/)) {
			$("#passError").html("Must contain one capital letter").addClass("error").removeClass("available");
		}
		else if(!$(this).val().match(/[0-9]/)) {
			$("#passError").html("Must contain one number").addClass("error").removeClass("available");
		}
		else {
			$("#passError").html("Valid password").removeClass("error").addClass("available");
		}
	});
	
	$("#userpassword2").keyup(function() {
		if(checkPasswordMatch()) {
			$("#pass2Error").html("Match").removeClass("error").addClass("available");
		}
		else {
			$("#pass2Error").html("Do not match").addClass("error").removeClass("available");
		}
	});
	
	$("#terms").change(function() {
		if($("#terms").attr("checked")) {
			$("#termsError").html("").removeClass("error");
		}
		else {
			$("#termsError").html("You must agree to the Terms of Service").addClass("error").removeClass("available");
		}
	});
	
	$("#tz").change(function() {
		if ($("#tz").val() == "none") {
			$("#timezoneError").html("You must select a timezone").addClass("error").removeClass("available");
		}
		else {
			$("#timezoneError").html("").removeClass("error").addClass("available");
		}
	});
	
	//stores the url parameter
	$.urlParam = function(name){
		var results = null;
		var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
		if(results != null) {
			return results[1] || 0;
		}
	}

	var submit = false;
	$("#social-form").submit(function() {
		submit = true;
	});

	window.onbeforeunload = confirmExit;
});

function confirmExit()
{
	if(!submit)
		return "If you leave this page your account will not be created and you will lose all your changes. Are you sure you want to leave?";
}

function checkLength($element, chars_allowed) {
	if($element.val().length > chars_allowed) {
		return true;	
	}
	else {
		return false;	
	}
}

function checkLetters($element) {
	if($element.val() == "") {
		return false;
	}
	else {
		return expLet.test($element.val());
	}
}

function checkEmail($element) {
	if($element.val() == "") {
		return false;
	}
	else if($element.val().match(regExpEmail)) {
		return true;
	}
	else {
		return false;
	}
}

function checkSC($element) {
	if($element.val() == "") {
		return false;
	}
	else {
		return expSC.test($element.val());
	}
}

function checkPasswordMatch() {
	if($("#userpassword").val() ==  $("#userpassword2").val() && $("#userpassword").val() != "" && $("#userpassword2").val() != "") {
		return true;	
	}
	else {
		return false;	
	}
}

function checkForm() {
	if(username && email && checkPasswordMatch() && $("#userpassword").val().match(/[A-Z]/) && 
		$("#userpassword").val().match(/[0-9]/) && checkLength($("#userpassword"), 5) && $("#terms").attr("checked") && $("#tz").val() != "none") {
		return true;
	}
	else {	
		//check username
		chars = $('#username').val();
		if(checkLength($('#username'), 3)) {
			if(checkSC($('#username'))) {
				$.post("/php/checkavail.php", {username:chars},
					  function(result) {
						  if(result == 1) {
							  //success
							  usernameVal = 2;
						  }
						  else if(result == 0) {
							  //not available
							  usernameVal = 1;
						  }
						  else {
							  usernameVal = 1;
						  }
						  
						  if(usernameVal == 1) {
							  $("#usernameError").html("Not available").addClass("error").removeClass("available");
							  username = false;
						  }
						  else if(usernameVal == 2) {
							  $("#usernameError").html("Available").addClass("available").removeClass("error");
							  username = true;
						  }
				});
			}
			else {
				usernameVal = 0;
				$("#usernameError").html("No special characters").addClass("error").removeClass("available");
				username = false;
			}
		}
		else {
			usernameVal = 0;
			$("#usernameError").html("Must be at least 4 characters").addClass("error").removeClass("available");
			username = false;
		}
		
		//check passowrds
		if(!checkLength($("#userpassword"), 5)) {
			$("#passError").html("Not long enough").addClass("error").removeClass("available");
		}
		else if(!$("#userpassword").val().match(/[A-Z]/)) {
			$("#passError").html("Must contain one capital letter").addClass("error").removeClass("available");
		}
		else if(!$("#userpassword").val().match(/[0-9]/)) {
			$("#passError").html("Must contain one number").addClass("error").removeClass("available");
		}
		else {
			$("#passError").html("Valid password").removeClass("error").addClass("available");
		}
		
		//checkbox terms
		if($("#terms").attr("checked")) {
			$("#termsError").html("").removeClass("error");
		}
		else {
			$("#termsError").html("You must agree to the Terms of Service").addClass("error").removeClass("available");
		}
		
		if ($("#tz").val() == "none") {
			$("#timezoneError").html("You must select a timezone").addClass("error").removeClass("available");
		}
		else {
			$("#timezoneError").html("").removeClass("error").addClass("available");
		}
		
		return false;
	}
}