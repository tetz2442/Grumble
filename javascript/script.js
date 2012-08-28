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
		if($("#dropdown-form").length > 0) {
			if($("#dropdown-form").is(":visible")) {
				$("#dropdown-form").fadeOut(50, function() {
					$element.parents("body").find(".login-drop-image").attr("src", "/images/arrow.png");
				});
			}
			else {
				$("#dropdown-form").fadeIn(100, function() {
					$("#email").focus();
				});
				$element.parents("body").find(".login-drop-image").attr("src", "/images/arrow-down.png");
			}
		}
		else if($("#dropdown-form-login").length > 0) {
			if($("#dropdown-form-login").is(":visible")) {
				$("#dropdown-form-login").fadeOut(50, function() {
					$element.parents("body").find(".login-drop-image").attr("src", "/images/arrow.png");
				});
			}
			else {
				$("#dropdown-form-login").fadeIn(100, function() {
					$("#email").focus();
				});
				$element.parents("body").find(".login-drop-image").attr("src", "/images/arrow-down.png");
			}
		}
	});

	//adds a vote to vote up
	$("body").on("click", ".votes-up a", function(event) {
		event.preventDefault();
		var id = $(this).attr("rel");
		var $element = $(this).parent();
		$(this).remove();
		var votes = parseInt($element.find(".votes-up-number").text())
		var htmlString = 'Vote up(<span class="votes-up-number">' + votes + '</span>)';
		$element.html(htmlString);
		$element.parents(".grumble-holder").find(".gif-loader-comments").show();
		$.post("/php/votes.php", {vote_up:id},
			function(result) {
				$element.parents(".grumble-holder").find(".gif-loader-comments").hide();
				if(result == 1) {
					votes = votes + 1;
					$element.find(".votes-up-number").html(votes);
				}
			});
	});
	
	$("body").on("keyup",(".quick-comment-input"), function(event) {
		/*if (event.keyCode == 13) { 
			event.preventDefault(); 
		}*/
		 var chars = $(this).val();
		 var charLength = 160 - chars.length;
		 if(charLength <= 0) {
			 $(this).parent().find(".comment-character-count").html(charLength);
			 $(this).parent().find(".comment-character-count").css("color", "red");
		 }
		 else {
			 $(this).parent().find(".comment-character-count").html(charLength);
			 $(this).parent().find(".comment-character-count").css("color", "green");
		 }
	});
	
	//opens and load comments
	$("body").on("click", "p.comments-view", function() {
		var $element = $(this);
		var id = $element.attr("rel");
		if($element.parents(".grumble-holder").find(".comments").is(":visible") == false) {
			if($element.attr("data-comments") == 0) {
				$element.parents(".grumble-holder").find(".comments").slideDown("fast");
				$element.find("a").html("Close");
			}
			else if($element.parents(".grumble-holder").find(".ind-comment").length > 0) {
				$element.parents(".grumble-holder").find(".comments").slideDown("fast");
				$element.find("a").html("Close");
			}
			else {
				$element.parents(".grumble-holder").find(".gif-loader-comments").show();
				$element.parents(".grumble-holder").find(".view-all-comments").show();
				$.post("/php/comments.php", {comment:id, type:"load", amount:"few"},
					function(result) {
						$element.parents(".grumble-holder").find(".gif-loader-comments").hide();
						if(result != "") {
							$(result).insertBefore($element.parents(".grumble-holder").find(".quick-comment-input"));
							$element.parents(".grumble-holder").find(".comments").slideDown("fast");
							$element.find("a").html("Close");
						}
				});
			}
		}
		else if($element.find("a").html() == "Close") {
			$element.parents(".grumble-holder").find(".comments").slideUp("fast");
			$element.find("a").html($element.attr("data-html"));
		}
	});
	
	$("body").on("click", "div.view-all-comments", function() {
		var $element = $(this);
		var id = $element.attr("rel");
		$element.parents(".grumble-holder").find(".gif-loader-comments").show();
		$.post("/php/comments.php", {comment:id, type:"load", amount:"all"},
			function(result) {
				$element.parents(".grumble-holder").find(".gif-loader-comments").hide();
				if(result != "") {
					$.each($(".ind-comment"), function() {
						$(this).remove();
					});
					$(result).insertBefore($element.parents(".grumble-holder").find(".quick-comment-input"));
					$element.hide();
				}
		});
	});
	
	//checks if the submit comment button has been clicked
	$("body").on("click", ".quick-comment-button", function() {
		var $element = $(this);
		var $commentText = $(this).parent().find(".quick-comment-input").val();
		var id = $(this).parents(".grumble-holder").find(".comments-view").attr("rel");
		var statususername = $(this).parents(".grumble-holder").find(".username:first").text();
		if($commentText != "" && $commentText.length <= 160) {
			$element.parents(".grumble-holder").find(".gif-loader-comments").show();
			$.post("/php/comments.php", {comment:id, type:"enter", text:$commentText, statususername:statususername},
			function(result) {
				$element.parents(".grumble-holder").find(".gif-loader-comments").hide();
				if(result != "") {
					$(result).insertBefore($element.parents(".grumble-holder").find(".quick-comment-input"));
					$element.parents(".grumble-holder").find(".ind-comment:last").slideDown("fast");
					$element.parents(".grumble-holder").find(".quick-comment-input").val("");
					$element.parents(".grumble-holder").find(".comment-character-count").html("160");
					$element.parents(".grumble-holder").find(".comments-view").attr("data-comments", (parseInt($element.parents(".grumble-holder").find(".comments-view").attr("data-comments")) + 1));
					$element.parents(".grumble-holder").find(".comments-view span").html("(" + $element.parents(".grumble-holder").find(".comments-view").attr("data-comments") + ")");
					$element.parents(".grumble-holder").find(".view-all-comments p").html("View All Comments(" + $element.parents(".grumble-holder").find(".comments-view").attr("data-comments") + ")");
				}
			});
		}
	});
	
	var link = 0;
	var charLengthGrumble = 0;
	$('#quick-compose-textarea').keypress(function(event) {
		if (event.keyCode == 13 && $("#quick-compose-textarea").is(":focus")) { 
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
		 charLengthGrumble = 160 - chars.length + link;
		 if(charLengthGrumble <= 0) {
			 $(this).parent().find("#character-count").html(charLengthGrumble);
			 $(this).parent().find("#character-count").css("color", "red");
		 }
		 else {
			 $(this).parent().find("#character-count").html(charLengthGrumble);
			 $(this).parent().find("#character-count").css("color", "green");
		 }
	});
	
	$('#quick-description-threadname').keyup(function() {
		 var chars = $(this).val();
		 var charLength = 40 - chars.length;
		 if(charLength <= 0) {
			 $(this).parent().find("#character-count").html(charLength);
			 $(this).parent().find("#character-count").css("color", "red");
		 }
		 else {
			 $(this).parent().find("#character-count").html(charLength);
			 $(this).parent().find("#character-count").css("color", "green");
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
			 $(this).parent().find("#character-count").html(charLengthThread);
			 $(this).parent().find("#character-count").css("color", "red");
		 }
		 else {
			 $(this).parent().find("#character-count").html(charLengthThread);
			 $(this).parent().find("#character-count").css("color", "green");
		 }
	});
	
	if($("#referrer").length > 0) {
		$("#referrer").val(window.location.pathname);	
	}
	
	$("#quick-compose-submit").click(function(event) {
		if(charLengthGrumble < 0) {
			event.preventDefault();
			
			$("#notification-bar p").html("Too many characters to submit.").addClass("error");
			$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
		}
		else if($(this).parents("#grumble-status-lightbox").find("#quick-compose-textarea").val().length == 0) {
			event.preventDefault();
			
			$("#notification-bar p").html("Grumble cannot be empty.").addClass("error");
			$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
		}
	});
	
	$("#quick-description-submit").click(function(event) {
		if($("#quick-description-threadname").val().length > 40 || charLengthThread < 0) {
			event.preventDefault();
			
			$("#notification-bar p").html("Too many characters to submit.").addClass("error");
			$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
		}
		else if($("#quick-description-threadname").val().length == 0 || $("#quick-description-textarea").val().length == 0) {
			event.preventDefault();
			
			$("#notification-bar p").html("Thread name/description cannot be empty.").addClass("error");
			$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
		}
		else if($("#thread-dropdown").val() == 0) {
			event.preventDefault();
			
			$("#notification-bar p").html("A category must be selected.").addClass("error");
			$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
		}
	});
	
	$("#open-quick-compose").mousedown(function() {
		$("#lightbox-container").fadeIn(100);
		$("#grumble-status-lightbox").fadeIn(100, function() {
			$("#quick-compose-textarea").focus();
		});
		
		$("#lightbox-container").click(function() {
			$("#lightbox-container").fadeOut(50);
			$("#grumble-status-lightbox").fadeOut(50);
		});
		$(".close-quick-submit").click(function() {
			$("#lightbox-container").fadeOut(50);
			$("#grumble-status-lightbox").fadeOut(50);
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
			if($("#cat-header h1").length > 0)
				var catID = $("#cat-header h1").attr("rel");
			if($(".user-name").length > 0)
				var userID = $(".user-name").attr("rel");
			var type = "";
			var last = 0;
			if($(".tabs a.active").html() == "Top Threads") {
				type = "top";
				last = $("#tab1 .thread-holder").length;
			}
			else if($(".tabs a.active").html() == "Recent Threads"){
				type = "recent";
				last = $("#tab2 .thread-holder:last").find(".thread-text-holder a").attr("data-id");
			}
			else if($(".tabs a.active").html() == "Top Grumbles"){
				type = "top-grumble";
				last = $("#tab3 .grumble-holder").length;
			}
			else if($(".tabs a.active").html() == "Recent Grumbles"){
				type = "recent-grumble";
				last = $("#tab4 .grumble-holder:last").find(".username").attr("rel");
			}
			else if($(".tabs-profile a.active").html() == "Grumbles"){
				type = "recent-grumble";
				last = $("#tab1 .grumble-holder:last").find(".username").attr("rel");
			}
			else if($(".tabs-profile a.active").html() == "Threads"){
				type = "recent";
				last = $("#tab2 .thread-holder:last").find(".thread-text-holder a").attr("data-id");
			}
			
			//load for category page
			if(catID != undefined) {
				$("#gif-loader").show();
				$.post("/php/categorygrab.php", {catID:catID, type:type, last:last},
				function(result) {
					$("#gif-loader").hide();
					canLoad = true;
					if(result != "none" && type =="top") {
						$(result).insertAfter($("#tab1 .thread-holder:last"));
						
						$.each($(".thread-description"), function() {
							if(!$(this).hasClass("linked")) {
								var newText = linkify($(this).html());
								$(this).addClass("linked").html(newText);
							}
						});
						
						shortenLink(".thread-description a");
					}
					else if(result != "none" && type =="recent") {
						$(result).insertAfter($("#tab2 .thread-holder:last"));
						
						$.each($(".thread-description"), function() {
							if(!$(this).hasClass("linked")) {
								var newText = linkify($(this).html());
								$(this).addClass("linked").html(newText);
							}
						});
						
						shortenLink(".thread-description a");
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
					$.post("/php/grumbleloadajax.php", {userID:userID, type:type, last:last},
					function(result) {
						$("#gif-loader").hide();
						canLoad = true;
						if(result != "none" && type =="recent-grumble") {
							$(result).insertAfter($("#tab1 .grumble-holder:last"));
						}
						else if(result == "none" && type == "recent-grumble") {
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
							$(result).insertAfter($("#tab2 .thread-holder:last"));
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
							$(result).insertAfter($("#tab1 .thread-holder:last"));
							
							$.each($(".thread-description"), function() {
								if(!$(this).hasClass("linked")) {
									var newText = linkify($(this).html());
									$(this).addClass("linked").html(newText);
								}
							});
							
							shortenLink(".thread-description a");
						}
						else if(result != "none" && type =="recent") {
							$(result).insertAfter($("#tab2 .thread-holder:last"));
							
							$.each($(".thread-description"), function() {
								if(!$(this).hasClass("linked")) {
									var newText = linkify($(this).html());
									$(this).addClass("linked").html(newText);
								}
							});
							
							shortenLink(".thread-description a");
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
				else if(type == "top-grumble" || type == "recent-grumble") {
					$.post("/php/grumbleloadajax.php", {type:type, last:last, location:"home"},
					function(result) {
						$("#gif-loader").hide();
						canLoad = true;
						if(result != "none" && type =="top-grumble") {
							$(result).insertAfter($("#tab3 .grumble-holder:last"));
							
							$.each($(".grumble-text"), function() {
								if(!$(this).hasClass("linked")) {
									var newText = linkify($(this).html());
									$(this).addClass("linked").html(newText);
								}
							});
							
							shortenLink(".grumble-text a");
						}
						else if(result != "none" && type =="recent-grumble") {
							$(result).insertAfter($("#tab4 .grumble-holder:last"));
							
							$.each($(".grumble-text"), function() {
								if(!$(this).hasClass("linked")) {
									var newText = linkify($(this).html());
									$(this).addClass("linked").html(newText);
								}
							});
							
							shortenLink(".grumble-text a");
						}
						else if(result == "none" && type == "top-grumble") {
							topGDone == "true";
							$(".view-more").slideUp("fast");
						}
						else if(result == "none" && type == "recent-grumble") {
							resultGDone == "true";
							$(".view-more").slideUp("fast");
						}
					});	
				}
			}
		}
		else if($(this).text() == "Settings") {
			$("#settings-holder").stop().animate({"top":"48px"}, "normal");
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
	});
	
	$("button").removeAttr("disabled");
	
	$("#start-new-thread").mousedown(function() {
		$("#lightbox-container").fadeIn(100);
		$("#grumble-thread-lightbox").fadeIn(100, function() {
			$("#quick-description-threadname").focus();
		});
		
		$("#lightbox-container").click(function() {
			$("#lightbox-container").fadeOut(50);
			$("#grumble-thread-lightbox").fadeOut(50);
			$("#help-callout").fadeOut(50);
		});
		$(".close-quick-submit").click(function() {
			$("#lightbox-container").fadeOut(50);
			$("#grumble-thread-lightbox").fadeOut(50);
			$("#help-callout").fadeOut(50);
		});
	});
	
	//load more grumbles when scrolling at bottom of page
	var loadMore = true;
	var pageNumber = 1;
	var subCat = 0;
	if($("#grumbles-left .grumble-holder").length == 10) {
		$(window).scroll(function () {
			if ($(window).scrollTop() >= $(document).height() - $(window).height() && canLoad) {
				canLoad = false;
				subCat = $("#subcat-id").attr("data-id");
				if(subCat == null) {
					subCat = $.urlParam("id");
				}
				var lastid = $(".username:last").attr("rel");
				$("#gif-loader").fadeIn(50);
				$.post("/php/grumbleloadajax.php", {pagenumber:pageNumber, number:"10", subCat:subCat, lastid:lastid},
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
							$(result).insertAfter($(".grumble-holder:last"));
							
							$.each($(".grumble-text"), function() {
								if(!$(this).hasClass("linked")) {
									var newText = linkify($(this).html());
									$(this).addClass("linked").html(newText);
								}
							});
							
							shortenLink(".grumble-text a");
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
			if(($("#tab2 .thread-holder").length >= 10 && $(this).html() == "Recent Threads" && !resultDone) || ($("#tab1 .thread-holder").length >= 10 && $(this).html() == "Top Threads" && !topDone)
			|| ($("#tab4 .grumble-holder").length >= 10 && $(this).html() == "Recent Grumbles" && !resultGDone) || ($("#tab3 .grumble-holder").length >= 10 && $(this).html() == "Top Grumbles" && !topGDone)) {
				$(".view-more").slideDown("fast");
			}
			else {
				$(".view-more").slideUp("fast");
			}
			if($(this).html() == "Recent Threads")
				$("#arrow-top img").animate({"marginLeft":"235px"}, "normal");
			else if($(this).html() == "Top Threads")
				$("#arrow-top img").animate({"marginLeft":"70px"}, "normal");
			else if($(this).html() == "Top Grumbles")
				$("#arrow-top img").animate({"marginLeft":"400px"}, "normal");
			else if($(this).html() == "Recent Grumbles")
				$("#arrow-top img").animate({"marginLeft":"565px"}, "normal");
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
			if(($("#tab2 .thread-holder").length >= 10 && $(this).html() == "Threads" && !topDone) || ($("#tab1 .grumble-holder").length >= 10 && $(this).html() == "Grumbles" && !resultGDone)) {
				$(".view-more").slideDown("fast");
			}
			else {
				$(".view-more").slideUp("fast");
			}
			if($(this).html() == "Threads")
				$("#arrow-top-profile img").animate({"marginLeft":"193px"}, "normal");
			else if($(this).html() == "Grumbles")
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
		$("#grumble-thread-share").fadeIn(100);
		
		$("#lightbox-container").click(function() {
			$("#lightbox-container").fadeOut(50);
			$("#grumble-thread-share").fadeOut(50);
		});
		$(".close-quick-submit").click(function() {
			$("#lightbox-container").fadeOut(50);
			$("#grumble-thread-share").fadeOut(50);
		});
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
	These next three ifs linkify text blocks
	*/
	if($(".grumble-text").length > 0) {
		$.each($(".grumble-text"), function() {
			var newText = linkify($(this).html());
			$(this).addClass("linked").html(newText);
		});
		
		shortenLink(".grumble-text a");
	}
	if($("#sub-category-desc").length > 0) {
		var catText = linkify($("#sub-category-desc").html());
		$("#sub-category-desc").html(catText);
		
		shortenLink("#sub-category-desc a");
	}
	if($(".thread-description").length > 0) {
		$.each($(".thread-description"), function() {
			var newText = linkify($(this).html());
			$(this).addClass("linked").html(newText);
		});
		
		shortenLink(".thread-description a");
	}
});

function linkify(inputText) {
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
		var textReplace = $(this).text();
		textReplace = textReplace.replace(/(https?):\/\//, "");
		textReplace = textReplace.replace(/www\./, "");
		if(textReplace.length > 30) {
			textReplace = textReplace.substring(0, 27) + "...";
		}
		$(this).text(textReplace);
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