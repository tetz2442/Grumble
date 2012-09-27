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
						toastr.success("Deleted.");
						$parent.remove();
					}
					else {
						toastr.error("Something went wrong. Could not delete.");
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
						toastr.success("Marked as resolved.");
						$parent.remove();
					}
					else {
						toastr.error("Something went wrong. Could not resolve.");
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
					toastr.success("Message sent.");
					$("#contact-lightbox").fadeOut("fast");
					$("#compose-textarea").val("");
				}
				else {
					toastr.error("Something went wrong. Could not send.");
				}
			});
	});
});