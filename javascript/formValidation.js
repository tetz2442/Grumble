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
				$("#firstnameError").html("Success");
				$("#firstnameError").addClass("available");
				$("#firstnameError").removeClass("error");
			}
			else {
				$("#firstnameError").html("No numbers or special characters allowed");
				$("#firstnameError").addClass("error");
				$("#firstnameError").removeClass("available");
			}
		}
		else {
			$("#firstnameError").html("Must be longer than 1 character");
			$("#firstnameError").addClass("error");
			$("#firstnameError").removeClass("available");
		}
		if(checkLength($("#lastname"), 1)) {
			if(checkLetters($("#lastname"))) {
				$("#lastnameError").html("Success");
				$("#lastnameError").addClass("available");
				$("#lastnameError").removeClass("error");
			}
			else {
				$("#lastnameError").html("No numbers or special characters allowed");
				$("#lastnameError").addClass("error");
				$("#lastnameError").removeClass("available");
			}
		}
		else {
			$("#lastnameError").html("Must be longer than 1 character");
			$("#lastnameError").addClass("error");
			$("#lastnameError").removeClass("available");
		}
		chars = $('#emails').val();
		if(checkEmail($("#emails"))) {
			$('#emails').parents("tr").find(".gif-loader").show();
			$.post("/php/checkavail.php", {email:chars},
				  function(result) {
					  $('#emails').parents("tr").find(".gif-loader").hide();
					  if(result == 1) {
						  //success
						$("#emailError").html("Valid email address");
						$("#emailError").addClass("available");
						$("#emailError").removeClass("error");
						email = true;
					  }
					  else if(result == 0) {
						  //not available
						  $("#emailError").html("Email has already been taken.");
						$("#emailError").addClass("error");
						$("#emailError").removeClass("available");
						email = false;
					  }
					  else {
						 $("#emailError").html("Invalid Email");
						$("#emailError").addClass("error");
						$("#emailError").removeClass("available");
						email = false;
					  }
			});
		}
		else {
			$("#emailError").html("Invalid Email");
			$("#emailError").addClass("error");
			$("#emailError").removeClass("available");
			email = false;
		}
	}
	
	$("#firstname").keyup(function() {
		if(checkLength($(this), 1)) {
			if(checkLetters($("#firstname"))) {
				$("#firstnameError").html("Success");
				$("#firstnameError").addClass("available");
				$("#firstnameError").removeClass("error");
			}
			else {
				$("#firstnameError").html("No numbers or special characters allowed");
				$("#firstnameError").addClass("error");
				$("#firstnameError").removeClass("available");
			}
		}
		else {
			$("#firstnameError").html("Must be longer than 1 character");
			$("#firstnameError").addClass("error");
			$("#firstnameError").removeClass("available");
		}
	});
	
	$("#lastname").keyup(function() {
		if(checkLength($(this), 1)) {
			if(checkLetters($("#lastname"))) {
				$("#lastnameError").html("Success");
				$("#lastnameError").addClass("available");
				$("#lastnameError").removeClass("error");
			}
			else {
				$("#lastnameError").html("No numbers or special characters allowed");
				$("#lastnameError").addClass("error");
				$("#lastnameError").removeClass("available");
			}
		}
		else {
			$("#lastnameError").html("Must be longer than 1 character");
			$("#lastnameError").addClass("error");
			$("#lastnameError").removeClass("available");
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
					$.post("/php/checkavail.php", {username:chars},
						  function(result) {
							  $('#username').parents("tr").find(".gif-loader").hide();
							  if(result == 1) {
								  //success
								  $("#usernameError").html("Username available");
								  $("#usernameError").addClass("available");
								  $("#usernameError").removeClass("error");
								  username = true;
							  }
							  else if(result == 0) {
								  //not available
								  $("#usernameError").html("Username not available");
								  $("#usernameError").removeClass("available");
								  $("#usernameError").addClass("error");
								  username = false;
							  }
							  else {
								  $("#usernameError").html("Username not available");
								  $("#usernameError").removeClass("available");
								  $("#usernameError").addClass("error");
								  username = false;
							  }
					});
				}
				else {
					usernameVal = 0;
					$("#usernameError").html("No spaces allowed in username");
					$("#usernameError").removeClass("available");
					$("#usernameError").addClass("error");
					username = false;
				}
			}
			else {
				usernameVal = 0;
				$("#usernameError").html("No special characters allowed");
				$("#usernameError").removeClass("available");
				$("#usernameError").addClass("error");
				username = false;
			}
		}
		else {
			usernameVal = 0;
			$("#usernameError").html("Username must be at least 4 characters");
			$("#usernameError").removeClass("available");
			$("#usernameError").addClass("error");
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
						  $("#emailError").html("Valid email address");
						$("#emailError").addClass("available");
						$("#emailError").removeClass("error");
						email = true;
					  }
					  else if(result == 0) {
						  //not available
						  $("#emailError").html("Email has already been taken.");
						$("#emailError").addClass("error");
						$("#emailError").removeClass("available");
						email = false;
					  }
					  else {
						 $("#emailError").html("Invalid Email");
						$("#emailError").addClass("error");
						$("#emailError").removeClass("available");
						email = false;
					  }
			});
		}
		else {
			$("#emailError").html("Invalid Email");
			$("#emailError").addClass("error");
			$("#emailError").removeClass("available");
			email = false;
		}
	});
	
	$("#userpassword").keyup(function() {
		$("#password2").val("");
		$("#pass2Error").html("");
		if(checkLength($(this), 5)) {
			$("#passError").html("Valid password");
			$("#passError").addClass("available");
			$("#passError").removeClass("error");
		}
		else {
			$("#passError").html("Password not long enough");
			$("#passError").addClass("error");
			$("#passError").removeClass("available");
		}
	});
	
	$("#userpassword2").keyup(function() {
		if(checkPasswordMatch()) {
			$("#pass2Error").html("Passwords match");
			$("#pass2Error").addClass("available");
			$("#pass2Error").removeClass("error");
		}
		else {
			$("#pass2Error").html("Passwords do not match");
			$("#pass2Error").addClass("error");
			$("#pass2Error").removeClass("available");
		}
	});
	
	$("#terms").change(function() {
		if($("#terms").attr("checked")) {
			$("#termsError").html("");
			$("#termsError").removeClass("error");
		}
		else {
			$("#termsError").html("You must agree to the Terms of Service");
			$("#termsError").addClass("error");
			$("#termsError").removeClass("available");
		}
	});
	
	$("#about-create").click(function() {
		if($("#fullname").val() == "" || $("#emails").val() == "") {
			event.preventDefault();
			$("#createError").html("Cannot leave a field blank");
			$("#createError").addClass("error");
			$("#createError").removeClass("available");
		}
		else {
			$("#createError").html("");
			$("#createError").removeClass("error");
			$("#createError").addClass("available");
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
	if(checkLength($("#firstname"), 1) && checkLength($("#lastname"), 1) && username && email && checkPasswordMatch() && checkLength($("#userpassword"), 5) && $("#terms").attr("checked")) {
		return true;
	}
	else {	
		//check first name
		if(checkLength($("#firstname"), 1)) {
			if(checkLetters($("#firstname"))) {
				$("#firstnameError").html("Success");
				$("#firstnameError").addClass("available");
				$("#firstnameError").removeClass("error");
			}
			else {
				$("#firstnameError").html("No numbers or special characters allowed");
				$("#firstnameError").addClass("error");
				$("#firstnameError").removeClass("available");
			}
		}
		else {
			$("#firstnameError").html("Must be longer than 1 character");
			$("#firstnameError").addClass("error");
			$("#firstnameError").removeClass("available");
		}
		
		//check last name
		if(checkLength($("#lastname"), 1)) {
			if(checkLetters($("#lastname"))) {
				$("#lastnameError").html("Success");
				$("#lastnameError").addClass("available");
				$("#lastnameError").removeClass("error");
			}
			else {
				$("#lastnameError").html("No numbers or special characters allowed");
				$("#lastnameError").addClass("error");
				$("#lastnameError").removeClass("available");
			}
		}
		else {
			$("#lastnameError").html("Must be longer than 1 character");
			$("#lastnameError").addClass("error");
			$("#lastnameError").removeClass("available");
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
					  $("#usernameError").html("Username not available");
					  $("#usernameError").removeClass("available");
					  $("#usernameError").addClass("error");
					  username = false;
				  }
				  else if(usernameVal == 2) {
					  $("#usernameError").html("Username available");
					  $("#usernameError").addClass("available");
					  $("#usernameError").removeClass("error");
					  username = true;
				  }
		});
		}
		else {
			usernameVal = 0;
			$("#usernameError").html("Username must be at least 4 characters");
			$("#usernameError").removeClass("available");
			$("#usernameError").addClass("error");
			username = false;
		}
		
		//check email
		if(checkEmail($("#emails"))) {
			$.post("/php/checkavail.php", {email:chars},
				  function(result) {
					  if(result == 1) {
						  //success
						  $("#emailError").html("Valid email address");
						$("#emailError").addClass("available");
						$("#emailError").removeClass("error");
						email = true;
					  }
					  else if(result == 0) {
						  //not available
						  $("#emailError").html("Email has already been taken.");
						$("#emailError").addClass("error");
						$("#emailError").removeClass("available");
						email = false;
					  }
					  else {
						 $("#emailError").html("Invalid Email");
						$("#emailError").addClass("error");
						$("#emailError").removeClass("available");
						email = false;
					  }
			});
		}
		else {
			$("#emailError").html("Invalid Email");
			$("#emailError").addClass("error");
			$("#emailError").removeClass("available");
			email = false;
		}
		
		//check passowrds
		if(checkLength($("#userpassword"), 5)) {
			$("#passError").html("Valid password");
			$("#passError").addClass("available");
			$("#passError").removeClass("error");
		}
		else {
			$("#passError").html("Password not long enough");
			$("#passError").addClass("error");
			$("#passError").removeClass("available");
		}
		
		//checkbox terms
		if($("#terms").attr("checked")) {
			$("#termsError").html("");
			$("#termsError").removeClass("error");
		}
		else {
			$("#termsError").html("You must agree to the Terms of Service");
			$("#termsError").addClass("error");
			$("#termsError").removeClass("available");
		}
		return false;
	}
}