// JavaScript Document
$("#quick-compose-submit").click(function(event) {
	if($(this).parent().find("#quick-compose-textarea").val().length > 160 || $(this).parent().find("#quick-compose-textarea").val().length == 0) {
		event.preventDefault();
	}
	/*else {
		event.preventDefault();
		var text = $('#quick-compose-textarea').val();
		$('#quick-compose-textarea').html($('#quick-compose-textarea').text());
		text = convertToLink($('#quick-compose-textarea').text());
		var cat = $(this).parents("#grumble-status-lightbox").find("#lightbox-category").val();
		$.post("php/transact-grumble.php", {action:"Submit Grumble", grumble:text, category:cat},
		function(result) {
			if(result != "") {
				alert(result);
			}
		});
	}*/
});

/*if($(".grumble-text").length > 0) {
	$.each($(".grumble-text"), function() {
		var newText = linkify($(this).html());
		$(this).html(newText);
		if((".oembed").length > 0) {
			var links = $(this).find(".oembed").attr("href");
			var embed = $(this).parent().find(".embed-link");
			$(embed).oembed(links, { 
			embedMethod: "append",
			maxWidth: 400, 
			maxHeight: 300});
		}
	});
}*/

/*function linkify(inputText) {
    var replaceText, replacePattern1, replacePattern2;

    //URLs starting with http://, https://, or ftp://
    replacePattern1 = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
    replacedText = inputText.replace(replacePattern1, '<a href="$1" target="_blank" class="colored-link-1">$1</a>');

    //URLs starting with "www." (without // before it, or it'd re-link the ones done above).
    replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
    replacedText = replacedText.replace(replacePattern2, '$1<a href="http://$2" target="_blank" class="colored-link-1">$2</a>');

    return replacedText;
}*/

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
			$('#emails').parent().find(".gif-loader").show();
			$.post("/php/checkavail.php", {email:chars},
				  function(result) {
					  $('#emails').parent().find(".gif-loader").hide();
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

	/*var element = $(this);
			if(charLengthGrumble < 0) {
				$("#notification-bar p").html("Too many characters to submit.").addClass("error");
				$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
			}
			else if($("#quick-compose-textarea").val().length == 0) {
				$("#notification-bar p").html("Grumble cannot be empty.").addClass("error");
				$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
			}
			else {
				var commenttext = $("#quick-compose-textarea").val();
				var category = $("#comment-category").val();
				$(element).attr("disabled","disabled");
				$(element).parent().find("#gif-loader-comment").show();
				$.post("/php/commentajax.php", {comment:commenttext, category:category},
						function(result) {
						$(element).parent().find("#gif-loader-comment").hide();
						$(element).removeAttr("disabled");
						if(result == 0 || result == "") {
							$("#notification-bar p").html("Something went wrong. Please check your entries.").addClass("error");
							$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
						}
						else if(result == 1) {
							$("#notification-bar p").html("Already submitted.").removeClass("available").addClass("error");
							$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
						}
						else if(result != "") {
							if($(".comment-holder").length > 0) {
								$(result).insertBefore(".comment-holder:first");
								var newText = linkText($(".comment-text:first").text());
								$(".comment-text:first").addClass("linked").html(newText);
								shortenLink(".comment-text:first a");
							}
							else {
								$("#notification-bar p").html("Refreshing page...").removeClass("error").addClass("available");
								$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).show();
								document.location.reload(true);
							}
								
							if($("#comments-left-header").length > 0) {
								var grumblenumber = parseInt($("#comments-left-header span").text()) + 1;
								$("#comments-left-header span").html(grumblenumber);
							}
			
							$("#quick-compose-textarea").val("").css({"height":"20px","background-color":"#FFF9E8"});
							$("#grumble-comment div").hide();
						}
				});
			}*/