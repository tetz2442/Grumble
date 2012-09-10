// JavaScript Document
//social code
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=340665976008804";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
//twitter
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
//google plus 1
(function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
  
$(document).ready(function() { 
	$("#maincolumn").delay(50).fadeIn(150);
	$("#footer").delay(50).fadeIn(150);

	$("#nav-category").click(function() {
		var $element = $(this);
		if($("#sub-nav").is(":visible")) {
			$("#sub-nav").fadeOut(50,function() {
				$element.find(".drop-image").attr("src", "/images/arrow.png");
			});
		}
		else {
			$("#sub-nav").fadeIn(100).css("display","list-item");
			$element.find(".drop-image").attr("src", "/images/arrow-down.png");
		}
	});
	
	$(".dropdown-shortlink").mousedown(function() {
		var $element = $(this);
		var $dropdownform = $("#dropdown-sub-nav");
		var $drowdownformlogin = $("#dropdown-form-login");
		if($dropdownform.length > 0) {
			if($dropdownform.is(":visible")) {
				$dropdownform.fadeOut(50, function() {
					$element.parents("body").find(".login-drop-image").attr("src", "/images/arrow.png");
				});
			}
			else {
				$dropdownform.fadeIn(100, function() {
					$("#email").focus();
				});
				$element.parents("body").find(".login-drop-image").attr("src", "/images/arrow-down.png");
			}
		}
		else if($drowdownformlogin.length > 0) {
			if($drowdownformlogin.is(":visible")) {
				$drowdownformlogin.fadeOut(50, function() {
					$element.parents("body").find(".login-drop-image").attr("src", "/images/arrow.png");
				});
			}
			else {
				$drowdownformlogin.fadeIn(100, function() {
					$("#email").focus();
				});
				$element.parents("body").find(".login-drop-image").attr("src", "/images/arrow-down.png");
			}
		}
	});
	
	$("div").on("mouseover", ".comment-holder", function () {
		$(this).find(".comment-options").show();
	}).mouseout(function () {
		$(this).find(".comment-options").hide();
	});
	
	$("body").on("click", ".comment-options p", function () {
		var $element = $(this);
		var $commentholder = $element.parents(".comment-holder");
		if($element.text() == "Delete") {
			var id = $commentholder.find(".username").attr("data-id");
			if(confirm("Are you sure you want to delete this Comment? **All votes and replies will be deleted also**")) {
				$commentholder.find(".gif-loader-replies").show();
				$.post("/php/commentajax.php", {commentid:id, action:"Delete"},
				function(result) {
					$commentholder.find(".gif-loader-replies").hide();
					if(result == 1) {
						$("#notification-bar p").html("Comment deleted.").removeClass("error").addClass("available");
						$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
						$commentholder.remove();
					}
					else {
						$("#notification-bar p").html("Something went wrong. Could not delete.").removeClass("available").addClass("error");
						$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
					}
				});
			}
		}
		else if($element.text() == "Spam") {
			var id = $element.parents(".comment-holder").find(".username").attr("data-id");
			if(confirm("Are you sure you want to report this comment as spam?")) {
				var $parent = $element.parents(".comment-holder");
				$element.parents(".comment-holder").find(".gif-loader-replies").show();
				$element.remove();
				$.post("/php/commentajax.php", {commentid:id, action:"Spam"},
				function(result) {
					$parent.find(".gif-loader-replies").hide();
					if(result == 1) {
						$("#notification-bar p").html("Comment reported as spam. Thank you.").removeClass("error").addClass("available");
						$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
					}
					else {
						$("#notification-bar p").html("Something went wrong. Could not report.").removeClass("available").addClass("error");
						$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
					}
				});
			}
		}
	});

	//adds a vote to vote up
	$("body").on("click", ".votes-up a", function(event) {
		event.preventDefault();
		var id = $(this).attr("data-id");
		var $element = $(this).parent();
		$(this).remove();
		var votes = parseInt($element.find(".votes-up-number").text())
		var htmlString = 'Votes up<img src="/images/thumb-up_1.jpg" alt="Vote up" width="14" height="14"/>(<span class="votes-up-number">' + votes + '</span>)';
		$element.html(htmlString);
		$element.parents(".comment-holder").find(".gif-loader-replies").show();
		$.post("/php/votes.php", {vote_up:id},
			function(result) {
				$element.parents(".comment-holder").find(".gif-loader-replies").hide();
				if(result == 1) {
					votes = votes + 1;
					$element.find(".votes-up-number").html(votes);
				}
			});
	});
	
	var charLengthReply = 160;
	$("body").on("keyup",(".quick-reply-input"), function() {
		 var chars = $(this).val();
		 link = findLink(chars);
		
		 if(link > 0 && $("#link-present").is(":visible") == false) {
			 $(this).parent().find(".link-present").fadeIn(100);
		 }
		 else if(link == 0) {
			 $(this).parent().find(".link-present").fadeOut(50);
		 }
		 
		 charLengthReply = 160 - chars.length + link;
		 if(charLengthReply <= 0) {
			 $(this).parent().find(".reply-character-count").html(charLengthReply).css("color", "red");
		 }
		 else {
			 $(this).parent().find(".reply-character-count").html(charLengthReply).css("color", "green");
		 }
	}).on("focusin",(".quick-reply-input"), function () {
		$(this).css("height","50px");
		$(this).parent().find(".reply-btn-holder").show();
	});
	
	//opens and load comments
	$("body").on("click", "p.replies-view", function() {
		var $element = $(this);
		var id = $element.attr("data-id");
		var $commentholder = $element.parents(".comment-holder");
		if($commentholder.find(".replies").is(":visible") == false) {
			if($element.attr("data-replies") == 0) {
				$commentholder.find(".replies").slideDown("fast");
				$element.find("a").html("Close");
			}
			else if($commentholder.find(".ind-reply").length > 0) {
				$commentholder.find(".replies").slideDown("fast");
				$element.find("a").html("Close");
			}
			else {
				$commentholder.find(".gif-loader-replies").show();
				$commentholder.find(".view-all-replies").show();
				$.post("/php/repliesajax.php", {reply:id, type:"load", amount:"few"},
					function(result) {
						$commentholder.find(".gif-loader-replies").hide();
						if(result != "") {
							$(result).insertBefore($commentholder.find(".quick-reply-input"));
							$commentholder.find(".replies").slideDown("fast");
							$element.find("a").html("Close");
							
							$($commentholder.find(".reply-text")).each(function() {
								var newText = linkText($(this).html());
								$(this).addClass("linked").html(newText);
							});
							shortenLink(".reply-text a");
						}
				});
			}
		}
		else if($element.find("a").html() == "Close") {
			$commentholder.find(".replies").slideUp("fast");
			$element.find("a").html($element.attr("data-html"));
		}
	});
	
	$("div").on("click", ".view-all-replies", function() {
		var $element = $(this);
		var id = $element.attr("data-id");
		$element.parents(".comment-holder").find(".gif-loader-replies").show();
		$.post("/php/repliesajax.php", {reply:id, type:"load", amount:"all"},
			function(result) {
				$element.parents(".comment-holder").find(".gif-loader-replies").hide();
				if(result != "") {
					$.each($(".ind-reply"), function() {
						$(this).remove();
					});
					$(result).insertBefore($element.parents(".comment-holder").find(".quick-reply-input"));
					$element.hide();
					
					$($element.parents(".comment-holder").find(".reply-text")).each(function() {
						var newText = linkText($(this).html());
						$(this).addClass("linked").html(newText);
					});
					shortenLink(".reply-text a");
				}
		});
	});
	
	//checks if the submit comment button has been clicked
	$("body").on("click", ".quick-reply-button", function() {
		var $element = $(this);
		var $commentText = $(this).parents(".reply-padding").find(".quick-reply-input").val();
		var $commentholder = $(this).parents(".comment-holder");
		var id = $commentholder.find(".replies-view").attr("data-id");
		var statususername = $commentholder.find(".username:first").text();
		if($commentText == "") {
			$("#notification-bar p").html("Reply cannot be empty.").addClass("error").removeClass("available");
			$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
		}
		else if(charLengthReply < 0){
			$("#notification-bar p").html("Too many characters to submit.").addClass("error").removeClass("available");
			$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
		}
		else {
			$commentholder.find(".gif-loader-replies").show();
			$element.attr("disabled","disabled");
			$.post("/php/repliesajax.php", {reply:id, type:"enter", text:$commentText, statususername:statususername},
			function(result) {
				$commentholder.find(".gif-loader-replies").hide();
				$element.removeAttr("disabled");
				if(result != "") {
					$(result).insertBefore($commentholder.find(".quick-reply-input"));
					
					var $newcomment = $commentholder.find(".ind-reply:last .reply-text");
					var newText = linkText($newcomment.html());
					$newcomment.addClass("linked").html(newText);
					shortenLink(".ind-reply:last .reply-text a");
					
					$commentholder.find(".ind-reply:last").slideDown("fast");
					$commentholder.find(".quick-reply-input").val("");
					$commentholder.find(".reply-character-count").html("160");
					var replies = parseInt($commentholder.find(".replies-view").attr("data-replies")) + 1;
					$commentholder.find(".replies-view").attr("data-replies", replies);
					$commentholder.find(".replies-view span").html("(" + replies + ")");
					$commentholder.find(".view-all-replies p").html("View All Replies (" + replies + ")");
					$commentholder.find(".reply-btn-holder").hide();
					$commentholder.find(".quick-reply-input").css("height","25px");
				}
			});
		}
	});
	
	var link = 0;
	var charLengthGrumble = 0;
	$('#quick-compose-textarea').keypress(function(event) {
		if (event.keyCode == 13) { 
			event.preventDefault(); 
		}
	}).keyup(function() {
		var chars = $(this).val();
		 link = findLink(chars);
		
		 if(link > 0 && $("#link-present").is(":visible") == false) {
			 $("#link-present").fadeIn(100);
		 }
		 else if(link == 0) {
			 $("#link-present").fadeOut(50);
		 }
		 charLengthGrumble = 160 - chars.length + link;
		 if(charLengthGrumble <= 0) {
			 $(this).parent().find("#character-count").html(charLengthGrumble).css("color", "red");
		 }
		 else {
			 $(this).parent().find("#character-count").html(charLengthGrumble).css("color", "green");
		 }
	}).focusin(function () {
		$(this).css({"height":"75px","background-color":"white"});
		$("#grumble-comment div").show();
	});
	
	$('#quick-description-grumblename').keyup(function() {
		 var chars = $(this).val();
		 var charLength = 40 - chars.length;
		 if(charLength <= 0) {
			 $(this).parent().find("#character-count").html(charLength).css("color", "red");
		 }
		 else {
			 $(this).parent().find("#character-count").html(charLength).css("color", "green");
		 }
	}).focusin(function () {
		 var chars = $(this).val();
		 var charLength = 40 - chars.length;
		 if(charLength <= 0) {
			 $(this).parent().find("#character-count").html(charLength).css("color", "red");
		 }
		 else {
			 $(this).parent().find("#character-count").html(charLength).css("color", "green");
		 }
	});
	
	var charLengthThread;
	$('#quick-description-textarea').keypress(function(event) {
		if (event.keyCode == 13) { 
			event.preventDefault(); 
		}
	}).on("keyup", function() {
		var chars = $(this).val();
		 link = findLink(chars);
		
		 if(link > 0 && $("#link-present").is(":visible") == false) {
			 $("#link-present").fadeIn(100);
		 }
		 else if(link == 0) {
			 $("#link-present").fadeOut(50);
		 }
		 
		 charLengthThread = 255 - chars.length + link;
		 if(charLengthThread <= 0) {
			 $(this).parent().find("#character-count").html(charLengthThread).css("color", "red");
		 }
		 else {
			 $(this).parent().find("#character-count").html(charLengthThread).css("color", "green");
		 }
	}).focusin(function () {
		var chars = $(this).val();
		charLengthThread = 255 - chars.length + link;
		if(charLengthThread <= 0) {
			 $(this).parent().find("#character-count").html(charLengthThread).css("color", "red");
		}
		else {
			 $(this).parent().find("#character-count").html(charLengthThread).css("color", "green");
		}
	});
	
	if($("#referrer").length > 0) {
		$("#referrer").val(window.location.pathname);	
	}
	
	$("#quick-description-submit").click(function(event) {
		if($("#quick-description-grumblename").val().length > 40) {
			event.preventDefault();
			
			$("#notification-bar p").html("Too many characters in Grumble to submit.").addClass("error");
			$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
			$("#quick-description-grumblename").focus();
		}
		else if(charLengthThread < 0) {
			event.preventDefault();
			
			$("#notification-bar p").html("Too many characters in Grumble Description to submit.").addClass("error");
			$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
			$('#quick-description-textarea').focus();
		}
		else if($("#quick-description-grumblename").val().length == 0 || $("#quick-description-textarea").val().length == 0) {
			event.preventDefault();
			
			$("#notification-bar p").html("Grumble name/description cannot be empty.").addClass("error");
			$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
		}
		else if($("#grumble-dropdown").val() == 0) {
			event.preventDefault();
			
			$("#notification-bar p").html("A category must be selected.").addClass("error");
			$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
		}
	});
	
	//may be able to delete//////
	$("#open-quick-compose").mousedown(function() {
		$("#lightbox-container").fadeIn(100);
		$("#comment-status-lightbox").fadeIn(100, function() {
			$("#quick-compose-textarea").focus();
		});
		
		$("#lightbox-container").click(function() {
			$("#lightbox-container").fadeOut(50);
			$("#comment-status-lightbox").fadeOut(50);
		});
		$(".close-quick-submit").click(function() {
			$("#lightbox-container").fadeOut(50);
			$("#comment-status-lightbox").fadeOut(50);
		});
	});
	
	//validate login
	$(".submit-login").click(function(event) {
		if($("#email").val() == "" || $("#password").val() == "") {
			event.preventDefault();
		}
	});
	
	var canLoad = true;
	var resultDone = false;
	var topDone = false;
	var resultGDone = false;
	var topGDone = false;
	$(".button").mousedown(function(event) {
		if($(this).val() == "View More" && canLoad) {
			canLoad = false;
			var $aactive = $(".tabs a.active");
			if($("#cat-header h1").length > 0)
				var catID = $("#cat-header h1").attr("data-id");
			if($(".user-name").length > 0)
				var userID = $(".user-name").attr("data-id");
			var type = "";
			var last = 0;
			if($aactive.text() == "Top Grumbles") {
				type = "top";
				last = $("#tab1 .grumble-holder").length;
			}
			else if($aactive.text() == "Recent Grumbles"){
				type = "recent";
				last = $("#tab2 .grumble-holder:last").find(".grumble-text-holder a").attr("data-id");
			}
			else if($aactive.text() == "Top Comments"){
				type = "top-comment";
				last = $("#tab3 .comment-holder").length;
			}
			else if($aactive.text() == "Recent Comments"){
				type = "recent-comment";
				last = $("#tab4 .comment-holder:last").find(".username").attr("data-id");
			}
			else if($(".tabs-profile a.active").text == "Comments"){
				type = "recent-grumble";
				last = $("#tab1 .comment-holder:last").find(".username").attr("data-id");
			}
			else if($(".tabs-profile a.active").text == "Grumbles"){
				type = "recent";
				last = $("#tab2 .grumble-holder:last").find(".comment-text-holder a").attr("data-id");
			}
			
			//load for category page
			if(catID != undefined) {
				$("#gif-loader").show();
				$.post("/php/categorygrab.php", {catID:catID, type:type, last:last},
				function(result) {
					$("#gif-loader").hide();
					canLoad = true;
					if(result != "none" && type =="top") {
						$(result).insertAfter($("#tab1 .grumble-holder:last"));
						
						$.each($(".grumble-description"), function() {
							if(!$(this).hasClass("linked")) {
								var newText = linkText($(this).html());
								$(this).addClass("linked").html(newText);
							}
						});
						
						shortenLink(".grumble-description a");
					}
					else if(result != "none" && type =="recent") {
						$(result).insertAfter($("#tab2 .grumble-holder:last"));
						
						$.each($(".grumble-description"), function() {
							if(!$(this).hasClass("linked")) {
								var newText = linkText($(this).html());
								$(this).addClass("linked").html(newText);
							}
						});
						
						shortenLink(".grumble-description a");
					}
					else if(result == "none" && type == "top") {
						topDone == "true";
						$(".view-more").slideUp("fast");
					}
					else if(result == "none" && type == "recent") {
						resultDone == "true";
						$(".view-more").slideUp("fast");
					}
				});
			}
			//grab for profile
			else if(userID != undefined) {
				$("#gif-loader").show();
				if(type == "recent-grumble") {
					$.post("/php/commentloadajax.php", {userID:userID, type:type, last:last},
					function(result) {
						$("#gif-loader").hide();
						canLoad = true;
						if(result != "none" && type =="recent-comment") {
							$(result).insertAfter($("#tab1 .comment-holder:last"));

						}
						else if(result == "none" && type == "recent-comment") {
							resultGDone == "true";
							$(".view-more").slideUp("fast");
						}
					});	
				}
				else if(type == "recent") {
					$("#gif-loader").show();
					$.post("/php/categorygrab.php", {userID:userID, catID:catID, type:type, last:last},
					function(result) {
						$("#gif-loader").hide();
						canLoad = true;
						if(result != "none" && type =="recent") {
							$(result).insertAfter($("#tab2 .grumble-holder:last"));
						}
						else if(result == "none" && type == "recent") {
							resultDone == "true";
							$(".view-more").slideUp("fast");
						}
					});
				}
			}
			else {
				//grab for homepage
				$("#gif-loader").show();
				if(type == "top" || type == "recent") {
					$.post("/php/categorygrab.php", {type:type, last:last},
					function(result) {
						canLoad = true;
						$("#gif-loader").hide();
						if(result != "none" && type =="top") {
							$(result).insertAfter($("#tab1 .grumble-holder:last"));
							
							$.each($(".grumble-description"), function() {
								if(!$(this).hasClass("linked")) {
									var newText = linkText($(this).html());
									$(this).addClass("linked").html(newText);
								}
							});
							
							shortenLink(".grumble-description a");
						}
						else if(result != "none" && type =="recent") {
							$(result).insertAfter($("#tab2 .grumble-holder:last"));
							
							$.each($(".grumble-description"), function() {
								if(!$(this).hasClass("linked")) {
									var newText = linkText($(this).html());
									$(this).addClass("linked").html(newText);
								}
							});
							
							shortenLink(".grumble-description a");
						}
						else if(result == "none" && type == "top") {
							topDone == "true";
							$(".view-more").slideUp("fast");
						}
						else if(result == "none" && type == "recent") {
							resultDone == "true";
							$(".view-more").slideUp("fast");
						}
					});	
				}
				else if(type == "top-comment" || type == "recent-comment") {
					$.post("/php/commentloadajax.php", {type:type, last:last, location:"home"},
					function(result) {
						$("#gif-loader").hide();
						canLoad = true;
						if(result != "none" && type =="top-comment") {
							$(result).insertAfter($("#tab3 .comment-holder:last"));
							
							$.each($(".comment-text"), function() {
								if(!$(this).hasClass("linked")) {
									var newText = linkText($(this).html());
									$(this).addClass("linked").html(newText);
								}
							});
							
							shortenLink(".comment-text a");
						}
						else if(result != "none" && type =="recent-comment") {
							$(result).insertAfter($("#tab4 .comment-holder:last"));
							
							$.each($(".comment-text"), function() {
								if(!$(this).hasClass("linked")) {
									var newText = linkText($(this).html());
									$(this).addClass("linked").html(newText);
								}
							});
							
							shortenLink(".comment-text a");
						}
						else if(result == "none" && type == "top-comment") {
							topGDone == "true";
							$(".view-more").slideUp("fast");
						}
						else if(result == "none" && type == "recent-comment") {
							resultGDone == "true";
							$(".view-more").slideUp("fast");
						}
					});	
				}
			}
		}
		else if($(this).text() == "Settings") {
			$("#settings-holder").stop().animate({"top":"46px"}, "normal");
			$("#settings-background").stop().fadeIn("normal");
			
			$("#settings-background").click(function() {
				$("#settings-holder").stop().animate({"top":"-500px"}, "normal");
				$("#settings-background").stop().fadeOut("normal");
			});
		}
		else if($(this).text() == "Close") {
			$("#settings-holder").stop().animate({"top":"-500px"}, "normal");
			$("#settings-background").stop().fadeOut("normal");
		}
		else if($(this).val() == "Submit Comment") {
			var element = $(this);
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
			
							$("#quick-compose-textarea").val("").css({"height":"20px","background-color":"#f0f0f0"});
							$("#grumble-comment div").hide();
						}
				});
			}
		}
	});
	
	$("button").removeAttr("disabled");
	
	$("#start-new-grumble").mousedown(function() {
		$("#lightbox-container").fadeIn(100);
		$("#grumble-lightbox").fadeIn(100, function() {
			$("#quick-description-grumblename").focus();
		});
		
		$("#lightbox-container").click(function() {
			$("#lightbox-container").fadeOut(50);
			$("#grumble-lightbox").fadeOut(50);
			$("#help-callout").fadeOut(50);
		});
		$(".close-quick-submit").click(function() {
			$("#lightbox-container").fadeOut(50);
			$("#grumble-lightbox").fadeOut(50);
			$("#help-callout").fadeOut(50);
		});
	});
	
	//load more grumbles when scrolling at bottom of page
	var loadMore = true;
	var pageNumber = 1;
	var subCat = 0;
	if($("#comments-left .comment-holder").length == 10) {
		$(window).scroll(function () {
			if ($(window).scrollTop() >= $(document).height() - $(window).height() && canLoad) {
				canLoad = false;
				subCat = $("#subcat-id").attr("data-id");
				if(subCat == null) {
					subCat = $.urlParam("id");
				}
				var lastid = $(".username:last").attr("data-id");
				$("#gif-loader").fadeIn(50);
				$.post("/php/commentloadajax.php", {pagenumber:pageNumber, number:10, subCat:subCat, lastid:lastid},
					function(result) {
						$("#gif-loader").fadeOut(50);
						if(result == "none") {
							//no more are available
							loadMore = false;
							canLoad = false;
							
							$("#notification-bar p").html("No more Grumbles to load.").addClass("error").removeClass("available");
							$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
						}
						else if(result != "") {
							canLoad = true;
							loadMore = true;
							pageNumber++;
		
							//insert
							$(result).insertAfter($(".comment-holder:last"));
							
							$.each($(".comment-text"), function() {
								if(!$(this).hasClass("linked")) {
									var newText = linkText($(this).html());
									$(this).addClass("linked").html(newText);
								}
							});
							
							shortenLink(".comment-text a");
						}
				});
			}
		});
	}
	
	$('ul.tabs').each(function(){
		var $active, $content, $links = $(this).find('a');
	
		$active = $links.first().addClass('active');
		$content = $($active.attr('href'));
	
		$links.not(':first').each(function () {
			$($(this).attr('href')).hide();
		});
	
		$(this).on('click', 'a', function(e){
			if(($("#tab2 .grumble-holder").length >= 10 && $(this).html() == "Recent Grumbles" && !resultDone) || ($("#tab1 .grumble-holder").length >= 10 && $(this).html() == "Top Grumbles" && !topDone)
			|| ($("#tab4 .comment-holder").length >= 10 && $(this).html() == "Recent Comments" && !resultGDone) || ($("#tab3 .comment-holder").length >= 10 && $(this).html() == "Top Comments" && !topGDone)) {
				$(".view-more").slideDown("fast");
			}
			else {
				$(".view-more").slideUp("fast");
			}
			if($(this).html() == "Recent Grumbles")
				$("#arrow-top img").animate({"marginLeft":"169px"}, "normal");
			else if($(this).html() == "Top Grumbles")
				$("#arrow-top img").animate({"marginLeft":"48px"}, "normal");
			else if($(this).html() == "Top Comments")
				$("#arrow-top img").animate({"marginLeft":"286px"}, "normal");
			else if($(this).html() == "Recent Comments")
				$("#arrow-top img").animate({"marginLeft":"407px"}, "normal");
			$active.removeClass('active');
			$content.fadeOut("fast");
	
			$active = $(this);
			$content = $($(this).attr('href'));
	
			$active.addClass('active');
			$content.fadeIn("normal");
	
			e.preventDefault();
		});
	});
	
	$('ul.tabs-profile').each(function(){
		var $active, $content, $links = $(this).find('a');
	
		$active = $links.first().addClass('active');
		$content = $($active.attr('href'));
	
		$links.not(':first').each(function () {
			$($(this).attr('href')).hide();
		});
	
		$(this).on('click', 'a', function(e){
			if(($("#tab2 .grumble-holder").length >= 10 && $(this).html() == "Grumbles" && !topDone) || ($("#tab1 .comment-holder").length >= 10 && $(this).html() == "Comments" && !resultGDone)) {
				$(".view-more").slideDown("fast");
			}
			else {
				$(".view-more").slideUp("fast");
			}
			if($(this).html() == "Grumbles")
				$("#arrow-top-profile img").animate({"marginLeft":"193px"}, "normal");
			else if($(this).html() == "Comments")
				$("#arrow-top-profile img").animate({"marginLeft":"58px"}, "normal");
			$active.removeClass('active');
			$content.fadeOut("fast");
	
			$active = $(this);
			$content = $($(this).attr('href'));
	
			$active.addClass('active');
			$content.fadeIn("normal");
	
			e.preventDefault();
		});
	});
	
	//stores the url parameter
	$.urlParam = function(name){
		var results = null;
		var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
		if(results != null) {
			return results[1] || 0;
		}
	}
	
	if($.urlParam("login") == 1) {
		var $element = $("#dropdown-form");
		$("#dropdown-form").fadeIn(100);
		$element.parent().find(".login-drop-image").attr("src", "images/arrow-down.png");
		$("#email").focus();
	}
	
	if($.urlParam("create") == "new") {
		$("#lightbox-container").fadeIn(100);
		$("#grumble-share").fadeIn(100);
		
		$("#lightbox-container").click(function() {
			$("#lightbox-container").fadeOut(50);
			$("#grumble-share").fadeOut(50);
		});
		$(".close-quick-submit").click(function() {
			$("#lightbox-container").fadeOut(50);
			$("#grumble-share").fadeOut(50);
		});
	}
	
	if($.urlParam("login") == "failed") {
		$("#notification-bar p").html("Incorrect email/password entered.").addClass("error");
		$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
	}
	
	$("#forg-submit").click(function(event) {
		if($("#pass-forg").val() == "" || $("#pass-forg2").val() == "") {
			event.preventDefault();
			$("#notification-bar p").html("Cannot leave a field blank.").addClass("error");
			$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
		}
		else if($("#pass-forg").val().length <= 5) {
			event.preventDefault();
			$("#notification-bar p").html("Password has to be longer than 5 characters.").addClass("error");
			$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
		}
		else if($("#pass-forg").val() != $("#pass-forg2").val()) {
			alert($("#pass-forg").val() + "," + $("#pass-forg2").val());
			event.preventDefault();
			$("#notification-bar p").html("Passwords have to match.").addClass("error");
			$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
		}
	});
	
	$(".help-callout").click(function(event) {
		$("#help-callout div").html("");
		var id = $(this).attr("data-id");
		var position = $(this).offset();
		$("#help-callout").css({"left":position.left - 18,"top":position.top + 25}).fadeIn(100);
		
		$("#help-callout").mouseleave(function() {
			$("#help-callout").fadeOut(50);
		});
		$("label").mouseenter(function() {
			$("#help-callout").fadeOut(50);
		});
		
		$.post("/php/helploadajax.php", {id:id},
			function(result) {
				if(result != "") {
					$("#help-callout div").append(result);
				}
				else {
					$("#help-callout div").append("<p>No help found.</p>");
				}
		});
	});
	
	/*
	These next three ifs linkText text blocks
	*/
	if($(".comment-text").length > 0) {
		$.each($(".comment-text"), function() {
			var newText = linkText($(this).html());
			$(this).addClass("linked").html(newText);
		});
		
		shortenLink(".comment-text a");
	}
	if($("#sub-category-desc").length > 0) {
		var catText = linkText($("#sub-category-desc").html());
		$("#sub-category-desc").html(catText);
		
		shortenLink("#sub-category-desc a");
	}
	if($(".grumble-description").length > 0) {
		$.each($(".grumble-description"), function() {
			var newText = linkText($(this).html());
			$(this).addClass("linked").html(newText);
		});
		
		shortenLink(".grumble-description a");
	}
});

function linkText(inputText) {
    var replaceText, replacePattern1, replacePattern2, replacePattern3;

    //URLs starting with http://, https://
    replacePattern1 = /(\b(https?):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
    replacedText = inputText.replace(replacePattern1, '<a href="$1" target="_blank" class="colored-link-1" title="$1">$1</a>');

    //URLs starting with "www." (without // before it, or it'd re-link the ones done above).
    replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
    replacedText = replacedText.replace(replacePattern2, '$1<a href="http://$2" target="_blank" class="colored-link-1">$2</a>');
	
    return replacedText;
}

function shortenLink(selector) {
	$.each($(selector), function() {
		if(!$(this).hasClass("linked")) {
			var textReplace = $(this).text();
			textReplace = textReplace.replace(/(https?):\/\//, "");
			textReplace = textReplace.replace(/www\./, "");
			if(textReplace.length > 30) {
				textReplace = textReplace.substring(0, 27) + "...";
			}
			$(this).text(textReplace);
		}
	});
}

function findLink(text) {
	var replacePattern1;
    replacePattern1 = /\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\"\\.,<>?\u00AB\u00BB\u201C\u201D\u2018\u2019]))/i;
	
	if(text.match(replacePattern1)) {
		var url = RegExp.$1.length;
		if(url > 30) {
			return url - 30;
		}
		else {
			return 0;
		}
	}
	else {
		return 0;	
	}
}