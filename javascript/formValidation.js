// JavaScript Document
var regExpEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z]+\.[a-z]{2,4}$/;
var expSC = /[!@#%*+=~`$&^-]/;
var expLet = /[0-9!@#%*+=~`$&^]/;
var username = false;
var email = false;

$(document).ready(function() { 
	//check if the fields have been pre-filled, then validates
	if($("#firstname").val() != "" || $("#lastname").val() != "" && $("#emails").val() != "") {
		if(checkLength($("#firstname"), 1)) {
			if(checkLetters($("#firstname"))) {
				$("#firstnameError").html("Success").removeClass("error").addClass("available");
			}
			else {
				$("#firstnameError").html("No numbers or special characters allowed").addClass("error").removeClass("available");
			}
		}
		else {
			$("#firstnameError").html("Must be longer than 1 character").addClass("error").removeClass("available");
		}
		if(checkLength($("#lastname"), 1)) {
			if(checkLetters($("#lastname"))) {
				$("#lastnameError").html("Success").removeClass("error").addClass("available");
			}
			else {
				$("#lastnameError").html("No numbers or special characters allowed").addClass("error").removeClass("available");
			}
		}
		else {
			$("#lastnameError").html("Must be longer than 1 character").addClass("error").removeClass("available");
		}
		chars = $('#emails').val();
		if(checkEmail($("#emails"))) {
			$('#emails').parents("tr").find(".gif-loader").show();
			$.post("/php/checkavail.php", {email:chars},
				  function(result) {
					  $('#emails').parents("tr").find(".gif-loader").hide();
					  if(result == 1) {
						  //success
						$("#emailError").html("Valid email address").removeClass("error").addClass("available");
						email = true;
					  }
					  else if(result == 0) {
						  //not available
						  $("#emailError").html("Email has already been taken.").addClass("error").removeClass("available");
						email = false;
					  }
					  else {
						 $("#emailError").html("Invalid Email").addClass("error").removeClass("available");
						email = false;
					  }
			});
		}
		else {
			$("#emailError").html("Invalid Email").addClass("error").removeClass("available");
			email = false;
		}
	}
	
	$("#firstname").keyup(function() {
		if(checkLength($(this), 1)) {
			if(checkLetters($("#firstname"))) {
				$("#firstnameError").html("Success").removeClass("error").addClass("available");
			}
			else {
				$("#firstnameError").html("No numbers or special characters allowed").addClass("error").removeClass("available");
			}
		}
		else {
			$("#firstnameError").html("Must be longer than 1 character").addClass("error").removeClass("available");
		}
	});
	
	$("#lastname").keyup(function() {
		if(checkLength($(this), 1)) {
			if(checkLetters($("#lastname"))) {
				$("#lastnameError").html("Success").removeClass("error").addClass("available");
			}
			else {
				$("#lastnameError").html("No numbers or special characters allowed").addClass("error").removeClass("available");
			}
		}
		else {
			$("#lastnameError").html("Must be longer than 1 character").addClass("error").removeClass("available");
		}
	});
	
	$("#username").keyup(function() {
		//var value = $("#username").val();
		//var usernameVal = checkUsername($(this), 3);
		chars = $('#username').val();
		if(checkLength($('#username'), 3)) {
			if(checkSC($('#username'))) {
				chars = $('#username').val();
				if(!chars.match(/\s/g)) {
					$('#username').parents("tr").find(".gif-loader").show();
					$("#usernameError").html("")
					$.post("/php/checkavail.php", {username:chars},
						  function(result) {
							  $('#username').parents("tr").find(".gif-loader").hide();
							  if(result == 1) {
								  //success
								  $("#usernameError").html("Username available").removeClass("error").addClass("available");
								  username = true;
							  }
							  else if(result == 0) {
								  //not available
								  $("#usernameError").html("Username not available").addClass("error").removeClass("available");
								  username = false;
							  }
							  else {
								  $("#usernameError").html("Username not available").addClass("error").removeClass("available");
								  username = false;
							  }
					});
				}
				else {
					usernameVal = 0;
					$("#usernameError").html("No spaces allowed in username").addClass("error").removeClass("available");
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
			$("#usernameError").html("Username must be at least 4 characters").addClass("error").removeClass("available");
			username = false;
		}
	});
	
	$("#emails").keyup(function() {
		chars = $('#emails').val();
		if(checkEmail($(this))) {
			$('#emails').parents("tr").find(".gif-loader").show();
			$.post("/php/checkavail.php", {email:chars},
				  function(result) {
					  $('#emails').parents("tr").find(".gif-loader").hide();
					  if(result == 1) {
						  //success
						  $("#emailError").html("Valid email address").removeClass("error").addClass("available");
						email = true;
					  }
					  else if(result == 0) {
						  //not available
						  $("#emailError").html("Email has already been taken.").addClass("error").removeClass("available");
						email = false;
					  }
					  else {
						 $("#emailError").html("Invalid Email").addClass("error").removeClass("available");
						email = false;
					  }
			});
		}
		else {
			$("#emailError").html("Invalid Email").addClass("error").removeClass("available");
			email = false;
		}
	});
	
	$("#userpassword").keyup(function() {
		$("#password2").val("");
		$("#pass2Error").html("");
		if(!checkLength($(this), 5)) {
			$("#passError").html("Password not long enough").addClass("error").removeClass("available");
		}
		else if(!$(this).val().match(/[A-Z]/)) {
			$("#passError").html("Passord must contain one capital letter").addClass("error").removeClass("available");
		}
		else if(!$(this).val().match(/[0-9]/)) {
			$("#passError").html("Passord must contain one number").addClass("error").removeClass("available");
		}
		else {
			$("#passError").html("Valid password").removeClass("error").addClass("available");
		}
	});
	
	$("#userpassword2").keyup(function() {
		if(checkPasswordMatch()) {
			$("#pass2Error").html("Passwords match").removeClass("error").addClass("available");
		}
		else {
			$("#pass2Error").html("Passwords do not match").addClass("error").removeClass("available");
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
	
	
	$("#about-create").click(function() {
		if($("#fullname").val() == "" || $("#emails").val() == "") {
			event.preventDefault();
			$("#createError").html("Cannot leave a field blank").addClass("error").removeClass("available");
		}
		else {
			$("#createError").html("").addClass("available").removeClass("error");
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
	
	if($.urlParam("create") == "fail") {
		$("#notification-bar p").html("Error when creating account.").addClass("error").removeClass("available");
		$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
	}
});

function checkLength(element, chars_allowed) {
	if(element.val().length > chars_allowed) {
		return true;	
	}
	else {
		return false;	
	}
}

function checkLetters(element) {
	if(element.val() == "") {
		return false;
	}
	else {
		return !expLet.test(element.val());
	}
}

function checkEmail(element) {
	if(element.val() == "") {
		return false;
	}
	else if(element.val().match(regExpEmail)) {
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
	if($("#userpassword").val() ==  $("#userpassword2").val() && $("#userpassword").val() != "" && $("#userpassword2").val() != "") {
		return true;	
	}
	else {
		return false;	
	}
}

function checkForm() {
	if(checkLength($("#firstname"), 1) && checkLength($("#lastname"), 1) && username && email && checkPasswordMatch() && checkLength($("#userpassword"), 5) && $("#terms").attr("checked") && $("#tz").val() != "none") {
		return true;
	}
	else {	
		//check first name
		if(checkLength($("#firstname"), 1)) {
			if(checkLetters($("#firstname"))) {
				$("#firstnameError").html("Success").addClass("available").removeClass("error");
			}
			else {
				$("#firstnameError").html("No numbers or special characters allowed").addClass("error").removeClass("available");
			}
		}
		else {
			$("#firstnameError").html("Must be longer than 1 character").addClass("error").removeClass("available");
		}
		
		//check last name
		if(checkLength($("#lastname"), 1)) {
			if(checkLetters($("#lastname"))) {
				$("#lastnameError").html("Success").addClass("available").removeClass("error");
			}
			else {
				$("#lastnameError").html("No numbers or special characters allowed").addClass("error").removeClass("available");
			}
		}
		else {
			$("#lastnameError").html("Must be longer than 1 character").addClass("error").removeClass("available");
		}
		
		//check username
		chars = $('#username').val();
		if(checkLength($('#username'), 3)) {
		$('#username').parents("tr").find(".gif-loader").show();
		$.post("/php/checkavail.php", {username:chars},
			  function(result) {
				  $('#username').parents("tr").find(".gif-loader").hide();
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
					  $("#usernameError").html("Username not available").addClass("error").removeClass("available");
					  username = false;
				  }
				  else if(usernameVal == 2) {
					  $("#usernameError").html("Username available").addClass("available").removeClass("error");
					  username = true;
				  }
		});
		}
		else {
			usernameVal = 0;
			$("#usernameError").html("Username must be at least 4 characters").addClass("error").removeClass("available");
			username = false;
		}
		
		//check email
		if(checkEmail($("#emails"))) {
			$.post("/php/checkavail.php", {email:chars},
				  function(result) {
					  if(result == 1) {
						  //success
						  $("#emailError").html("Valid email address").addClass("available").removeClass("error");
						email = true;
					  }
					  else if(result == 0) {
						  //not available
						  $("#emailError").html("Email has already been taken.").addClass("error").removeClass("available");
						email = false;
					  }
					  else {
						 $("#emailError").html("Invalid Email").addClass("error").removeClass("available");
						email = false;
					  }
			});
		}
		else {
			$("#emailError").html("Invalid Email").addClass("error").removeClass("available");
			email = false;
		}
		
		//check passowrds
		if(!checkLength($("#userpassword"), 5)) {
			$("#passError").html("Password not long enough").addClass("error").removeClass("available");
		}
		else if(!$("#userpassword").val().match(/[A-Z]/)) {
			$("#passError").html("Passord must contain one capital letter").addClass("error").removeClass("available");
		}
		else if(!$("#userpassword").val().match(/[0-9]/)) {
			$("#passError").html("Passord must contain one number").addClass("error").removeClass("available");
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