// JavaScript Document
$(document).ready(function() { 
	var contactid = 0;
	$(".contact-options a").click( function (event) {
		event.preventDefault();
		var $element = $(this);
		var $parent = $element.parents(".contact-message");
		if($element.text() == "Delete") {
			var id = $element.parent().attr("data-id");
			if(confirm("Are you sure you want to delete this contact message? All messages should be saved.")) {
				$.post("adminajax.php", {contactid:id, action:"Delete"},
				function(result) {
					if(result == 1) {
						$("#notification-bar p").html("Deleted.").removeClass("error").addClass("available");
						$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
						$parent.remove();
					}
					else {
						$("#notification-bar p").html("Something went wrong. Could not delete.").removeClass("available").addClass("error");
						$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
					}
				});
			}
		}
		else if($element.text() == "Resolved") {
			var id = $element.parent().attr("data-id");
			if(confirm("Are you sure you want to mark this as resolved?")) {
				var $parent = $element.parents(".contact-message");
				$.post("adminajax.php", {contactid:id, action:"Resolved"},
				function(result) {
					if(result == 1) {
						$("#notification-bar p").html("Marked as resolved.").removeClass("error").addClass("available");
						$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
						$parent.remove();
					}
					else {
						$("#notification-bar p").html("Something went wrong. Could not resolve.").removeClass("available").addClass("error");
						$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
					}
				});
			}
		}
		else if($element.text() == "Contact User") {
			contactid = $element.parent().attr("data-id");
			var $parent = $element.parents(".contact-message");
			$("#contact-lightbox h3").html("Contact user - <small>" + $parent.find("p strong").text() + "</small>");
			$("#contact-lightbox").fadeIn("fast");
			$(".close-quick-submit").click(function () {
				$("#contact-lightbox").fadeOut("fast");
			}); 
		}
	});

	$("#contact-admin-form").submit(function (event){
		event.preventDefault();
		var message = $("#compose-textarea").val();
		$.post("adminajax.php", {contactid:contactid, message:message, action:"Contact"},
			function(result) {
				if(result == 1) {
					$("#notification-bar p").html("Message sent.").removeClass("error").addClass("available");
					$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
					$("#contact-lightbox").fadeOut("fast");
					$("#compose-textarea").val("");
				}
				else {
					$("#notification-bar p").html("Something went wrong. Could not send.").removeClass("available").addClass("error");
					$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
				}
			});
	});
});