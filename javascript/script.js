//social code
/*(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=340665976008804";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));*/
//twitter
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
//google plus 1
(function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
  // VERSION: 2.2 LAST UPDATE: 13.03.2012
/* 
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 * 
 * Made by Wilq32, wilq32@gmail.com, Wroclaw, Poland, 01.2009
 * Website: http://code.google.com/p/jqueryrotate/ 
 */
(function(j){for(var d,k=document.getElementsByTagName("head")[0].style,h=["transformProperty","WebkitTransform","OTransform","msTransform","MozTransform"],g=0;g<h.length;g++)void 0!==k[h[g]]&&(d=h[g]);var i="v"=="\v";jQuery.fn.extend({rotate:function(a){if(!(0===this.length||"undefined"==typeof a)){"number"==typeof a&&(a={angle:a});for(var b=[],c=0,f=this.length;c<f;c++){var e=this.get(c);if(!e.Wilq32||!e.Wilq32.PhotoEffect){var d=j.extend(!0,{},a),e=(new Wilq32.PhotoEffect(e,d))._rootObj;
b.push(j(e))}else e.Wilq32.PhotoEffect._handleRotation(a)}return b}},getRotateAngle:function(){for(var a=[],b=0,c=this.length;b<c;b++){var f=this.get(b);f.Wilq32&&f.Wilq32.PhotoEffect&&(a[b]=f.Wilq32.PhotoEffect._angle)}return a},stopRotate:function(){for(var a=0,b=this.length;a<b;a++){var c=this.get(a);c.Wilq32&&c.Wilq32.PhotoEffect&&clearTimeout(c.Wilq32.PhotoEffect._timer)}}});Wilq32=window.Wilq32||{};Wilq32.PhotoEffect=function(){return d?function(a,b){a.Wilq32={PhotoEffect:this};this._img=this._rootObj=
this._eventObj=a;this._handleRotation(b)}:function(a,b){this._img=a;this._rootObj=document.createElement("span");this._rootObj.style.display="inline-block";this._rootObj.Wilq32={PhotoEffect:this};a.parentNode.insertBefore(this._rootObj,a);if(a.complete)this._Loader(b);else{var c=this;jQuery(this._img).bind("load",function(){c._Loader(b)})}}}();Wilq32.PhotoEffect.prototype={_setupParameters:function(a){this._parameters=this._parameters||{};"number"!==typeof this._angle&&(this._angle=0);"number"===
typeof a.angle&&(this._angle=a.angle);this._parameters.animateTo="number"===typeof a.animateTo?a.animateTo:this._angle;this._parameters.step=a.step||this._parameters.step||null;this._parameters.easing=a.easing||this._parameters.easing||function(a,c,f,e,d){return-e*((c=c/d-1)*c*c*c-1)+f};this._parameters.duration=a.duration||this._parameters.duration||1E3;this._parameters.callback=a.callback||this._parameters.callback||function(){};a.bind&&a.bind!=this._parameters.bind&&this._BindEvents(a.bind)},_handleRotation:function(a){this._setupParameters(a);
this._angle==this._parameters.animateTo?this._rotate(this._angle):this._animateStart()},_BindEvents:function(a){if(a&&this._eventObj){if(this._parameters.bind){var b=this._parameters.bind,c;for(c in b)b.hasOwnProperty(c)&&jQuery(this._eventObj).unbind(c,b[c])}this._parameters.bind=a;for(c in a)a.hasOwnProperty(c)&&jQuery(this._eventObj).bind(c,a[c])}},_Loader:function(){return i?function(a){var b=this._img.width,c=this._img.height;this._img.parentNode.removeChild(this._img);this._vimage=this.createVMLNode("image");
this._vimage.src=this._img.src;this._vimage.style.height=c+"px";this._vimage.style.width=b+"px";this._vimage.style.position="absolute";this._vimage.style.top="0px";this._vimage.style.left="0px";this._container=this.createVMLNode("group");this._container.style.width=b;this._container.style.height=c;this._container.style.position="absolute";this._container.setAttribute("coordsize",b-1+","+(c-1));this._container.appendChild(this._vimage);this._rootObj.appendChild(this._container);this._rootObj.style.position=
"relative";this._rootObj.style.width=b+"px";this._rootObj.style.height=c+"px";this._rootObj.setAttribute("id",this._img.getAttribute("id"));this._rootObj.className=this._img.className;this._eventObj=this._rootObj;this._handleRotation(a)}:function(a){this._rootObj.setAttribute("id",this._img.getAttribute("id"));this._rootObj.className=this._img.className;this._width=this._img.width;this._height=this._img.height;this._widthHalf=this._width/2;this._heightHalf=this._height/2;var b=Math.sqrt(this._height*
this._height+this._width*this._width);this._widthAdd=b-this._width;this._heightAdd=b-this._height;this._widthAddHalf=this._widthAdd/2;this._heightAddHalf=this._heightAdd/2;this._img.parentNode.removeChild(this._img);this._aspectW=(parseInt(this._img.style.width,10)||this._width)/this._img.width;this._aspectH=(parseInt(this._img.style.height,10)||this._height)/this._img.height;this._canvas=document.createElement("canvas");this._canvas.setAttribute("width",this._width);this._canvas.style.position="relative";
this._canvas.style.left=-this._widthAddHalf+"px";this._canvas.style.top=-this._heightAddHalf+"px";this._canvas.Wilq32=this._rootObj.Wilq32;this._rootObj.appendChild(this._canvas);this._rootObj.style.width=this._width+"px";this._rootObj.style.height=this._height+"px";this._eventObj=this._canvas;this._cnv=this._canvas.getContext("2d");this._handleRotation(a)}}(),_animateStart:function(){this._timer&&clearTimeout(this._timer);this._animateStartTime=+new Date;this._animateStartAngle=this._angle;this._animate()},
_animate:function(){var a=+new Date,b=a-this._animateStartTime>this._parameters.duration;if(b&&!this._parameters.animatedGif)clearTimeout(this._timer);else{(this._canvas||this._vimage||this._img)&&this._rotate(~~(10*this._parameters.easing(0,a-this._animateStartTime,this._animateStartAngle,this._parameters.animateTo-this._animateStartAngle,this._parameters.duration))/10);this._parameters.step&&this._parameters.step(this._angle);var c=this;this._timer=setTimeout(function(){c._animate.call(c)},10)}this._parameters.callback&&
b&&(this._angle=this._parameters.animateTo,this._rotate(this._angle),this._parameters.callback.call(this._rootObj))},_rotate:function(){var a=Math.PI/180;return i?function(a){this._angle=a;this._container.style.rotation=a%360+"deg"}:d?function(a){this._angle=a;this._img.style[d]="rotate("+a%360+"deg)"}:function(b){this._angle=b;b=b%360*a;this._canvas.width=this._width+this._widthAdd;this._canvas.height=this._height+this._heightAdd;this._cnv.translate(this._widthAddHalf,this._heightAddHalf);this._cnv.translate(this._widthHalf,
this._heightHalf);this._cnv.rotate(b);this._cnv.translate(-this._widthHalf,-this._heightHalf);this._cnv.scale(this._aspectW,this._aspectH);this._cnv.drawImage(this._img,0,0)}}()};i&&(Wilq32.PhotoEffect.prototype.createVMLNode=function(){document.createStyleSheet().addRule(".rvml","behavior:url(#default#VML)");try{return!document.namespaces.rvml&&document.namespaces.add("rvml","urn:schemas-microsoft-com:vml"),function(a){return document.createElement("<rvml:"+a+' class="rvml">')}}catch(a){return function(a){return document.createElement("<"+
a+' xmlns="urn:schemas-microsoft.com:vml" class="rvml">')}}}())})(jQuery);

$(document).ready(function() { 
	//category dropdown
	$("#nav-category").click(function() {
		if($("#sub-nav").is(":visible")) {
			$("#sub-nav").fadeOut(50);
		}
		else {
			$("#sub-nav").fadeIn(100);
		}
		$("#dropdown-sub-nav").fadeOut(50);
		$("#dropdown-form-login").fadeOut(50);
		$("#notification-dropdown").fadeOut(50);
	});
	//link for opening the user menu/login dropdown
	$(".dropdown-shortlink").mousedown(function() {
		var $element = $(this);
		var $dropdownform = $("#dropdown-sub-nav");
		var $drowdownformlogin = $("#dropdown-form-login");
		if($dropdownform.length > 0) {
			if($dropdownform.is(":visible")) {
				$dropdownform.fadeOut(50);
			}
			else {
				$dropdownform.fadeIn(100, function() {
					$("#email").focus();
				});
			}
		}
		else if($drowdownformlogin.length > 0) {
			if($drowdownformlogin.is(":visible")) {
				$drowdownformlogin.fadeOut(50);
			}
			else {
				$drowdownformlogin.fadeIn(100, function() {
					$("#email").focus();
				});
			}
		}
		$("#notification-dropdown").fadeOut(50);
		$("#sub-nav").fadeOut(50);
	});
	//notification dropdown
	$("#notification-number").mousedown(function() {
		if($("#notification-dropdown").is(":visible")) {
			$("#notification-dropdown").fadeOut(50);
			$("#notification-dropdown li a").each(function() {
				$(this).removeClass("highlight");
			});
			//change notification image
			$("#notification-number").attr("src","/images/icons/notification-none.png");
			$("#notification-header").html("Notifications (0 new)");
		}
		else {
			$("#notification-dropdown").fadeIn(100);
			var unread = 0;
			$("#notification-dropdown li a").each(function() {
				if($(this).hasClass("highlight")) {
					unread++;	
				}
			});
			
			if(unread != 0) {
				//mark notifications as read
				$.post("/php/notifications.php", {action:"markasread"});
			}
		}
		$("#dropdown-sub-nav").fadeOut(50);
		$("#dropdown-form-login").fadeOut(50);
		$("#sub-nav").fadeOut(50);
	});
	//loads more notifications
	$("#notification-load a").click(function(event) {
		event.preventDefault();
		var lastid = $(".ind-notification:last").attr("data-id");
		$.post("/php/notifications.php", {lastid:lastid, action:"load"},
			function(result) {
				if(result != "" && result != 0) {
					$(result).insertAfter(".ind-notification:last");
				}
				else if(result == 0){
					toastr.warning("No more notifications to load.");
					$("#notification-load").remove();
				}
				else {
					toastr.error("Could not load.");
				}
			});
	});
	//if the main column is clicked, close all dropdowns
	$("#maincolumn").click(function () {
		$(".dropdown").fadeOut(50);
	});
	
	$("div").on("mouseover", ".comment-holder", function () {
		$(this).find(".comment-options").show();
	}).mouseout(function () {
		$(this).find(".comment-options").hide();
	});
	var charLengthReply = 160;
	$("body").on("click", ".comment-options p", function () {
		var $element = $(this);
		var $commentholder = $element.parents(".comment-holder");
		if($element.text() == "Delete") {
			var id = $commentholder.find(".username").attr("data-id");
			if(confirm("Are you sure you want to delete this comment? **All votes and replies will be deleted also**")) {
				$commentholder.find(".gif-loader-replies").show();
				$.post("/php/commentajax.php", {commentid:id, action:"Delete"},
				function(result) {
					$commentholder.find(".gif-loader-replies").hide();
					if(result == 1) {
						toastr.success("Comment deleted.");
						$element.parents(".comment-holder").remove();
					}
					else {
						toastr.error("Something went wrong. Could not delete.");
					}
				});
			}
		}
		else if($element.text() == "Spam") {
			var id = $element.parents(".comment-holder").find(".username").attr("data-id");
			if(confirm("Are you sure you want to report this comment as spam?")) {
				var $parent = $element.parents(".comment-holder");
				$parent.find(".gif-loader-replies").show();
				$element.remove();
				$.post("/php/commentajax.php", {commentid:id, action:"Spam"},
				function(result) {
					$parent.find(".gif-loader-replies").hide();
					if(result == 1) {
						toastr.success("Comment reported as spam. Thank you.");
					}
					else {
						toastr.error("Something went wrong. Could not report.");
					}
				});
			}
		}
		else if($element.text() == "Remove") {
			var id = $element.parents(".comment-holder").find(".username").attr("data-id");
			if(confirm("Are you sure you want to remove this comment from the spam list?")) {
				var $parent = $element.parents(".comment-holder");
				$parent.find(".gif-loader-replies").show();
				$.post("/php/commentajax.php", {commentid:id, action:"Remove"},
				function(result) {
					$parent.find(".gif-loader-replies").hide();
					if(result == 1) {
						toastr.success("Removed from spam list.");
						$element.closest(".spam-holder").remove();
						$parent.remove();
					}
					else {
						toastr.error("Something went wrong. Could not remove.");
					}
				});
			}
		}
	}).on("click", ".votes-up a", function(event) {
		event.preventDefault();
		var id = $(this).attr("data-id");
		var $element = $(this).parent();
		$(this).remove();
		var votes = parseInt($element.find(".votes-up-number").text())
		var htmlString = 'Votes up<img src="/images/icons/thumb-up_1.jpg" alt="Vote up" width="14" height="14"/>(<span class="votes-up-number">' + votes + '</span>)';
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
	}).on("keyup",(".quick-reply-input"), function() {
		 var chars = $(this).val();
		 link = findLink(chars);
		
		 if(link > 0 && $("#link-present").is(":visible") == false) {
			 $(this).parent().find(".link-present").fadeIn(100);
		 }
		 else if(link == 0) {
			 $(this).parent().find(".link-present").fadeOut(50);
		 }
		 
		 charLengthReply = 240 - chars.length + link;
		 if(charLengthReply <= 0) {
			 $(this).parent().find(".reply-character-count").html(charLengthReply).css("color", "red");
		 }
		 else {
			 $(this).parent().find(".reply-character-count").html(charLengthReply).css("color", "green");
		 }
	}).on("focusin",(".quick-reply-input"), function () {
		$(this).css("height","50px");
		$(this).parent().find(".reply-btn-holder").show();
	}).on("click", "p.replies-view", function() {
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
	}).on("click", ".view-all-replies", function() {
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
	}).on("click", ".quick-reply-button", function() {
		var $element = $(this);
		var $commentText = $(this).parents(".reply-padding").find(".quick-reply-input").val();
		var $commentholder = $(this).parents(".comment-holder");
		var id = $commentholder.find(".replies-view").attr("data-id");
		var statususername = $commentholder.find(".username:first").text();
		if($commentText == "" || $commentText.match(/^\s*$/)) {
			toastr.warning("Reply cannot be empty.");
		}
		else if(charLengthReply < 0){
			toastr.warning("Too many characters to submit.");
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

	$(".grumble-like-number").click(function() {
		var $element = $(this);
		var id = $("#subcat-id").attr("data-id");
		if($(".user-inline .dropdown-login").length == 1) {
			$.post("/php/transact-grumble.php", {action:"voteup", subcatid:id},
				function(result) {
					if(result == 1) {
						var likes = parseInt($(".grumble-vote-font").text());
						likes++;
						$(".grumble-vote-font").html(likes);
					}
					else if(result == 0 || result == "") {
						toastr.warning("You have already voted up.");
					}
					else {
						toastr.error("Something went wrong.");
					}
				});
		}
		else {
			toastr.warning("You must be logged in to vote.");
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
		 charLengthGrumble = 600 - chars.length + link;
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
		 
		 charLengthThread = 500 - chars.length + link;
		 if(charLengthThread <= 0) {
			 $(this).parent().find("#character-count").html(charLengthThread).css("color", "red");
		 }
		 else {
			 $(this).parent().find("#character-count").html(charLengthThread).css("color", "green");
		 }
	}).focusin(function () {
		var chars = $(this).val();
		charLengthThread = 500 - chars.length + link;
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
	if($("#login-refer").length > 0) {
		$("#login-refer").val(".." + window.location.pathname);
		$(".social-login a").each(function () {
			var path = $(this).attr("href");
			path = path + "&redirect=.." + window.location.pathname;
			$(this).attr("href", path);
		});
	}
	
	$("#quick-description-submit").click(function(event) {
		if($("#quick-description-grumblename").val().length > 40) {
			event.preventDefault();
			
			toastr.warning("Too many characters in Grumble to submit.");
			$("#quick-description-grumblename").focus();
		}
		else if(charLengthThread < 0) {
			event.preventDefault();
			
			toastr.warning("Too many characters in Grumble Description to submit.");
			$('#quick-description-textarea').focus();
		}
		else if($("#quick-description-grumblename").val().length == 0 || $("#quick-description-textarea").val().length == 0 || $("#quick-description-grumblename").val().match(/^\s*$/) || $("#quick-description-textarea").val().match(/^\s*$/)) {
			event.preventDefault();
			
			toastr.warning("Grumble name/description cannot be empty.");
		}
		else if($("#grumble-dropdown").val() == 0) {
			event.preventDefault();
			
			toastr.warning("A category must be selected.");
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
			var $aactive = $(".tabs a.active:first");
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
			else if($aactive.text() == "Comments"){
				type = "recent-comment";
				last = $("#tab1 .comment-holder:last").find(".username").attr("data-id");
			}
			else if($aactive.text() == "Grumbles"){
				type = "recent";
				last = $("#tab2 .grumble-holder:last").find(".grumble-text-holder a").attr("data-id");
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
				if(type == "recent-comment") {
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
					$.post("/php/categorygrab.php", {userID:userID, type:type, last:last},
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
	});
	
	$("#grumble-comment-form").submit(function(event) {
		var element = $(this);
		event.preventDefault();
		if(charLengthGrumble < 0) {
			toastr.warning("Too many characters to submit.");
		}
		else if($("#quick-compose-textarea").val().length == 0 || $("#quick-compose-textarea").val().match(/^\s*$/)) {
			toastr.warning("Comment cannot be empty.");
		}
		else {
			var commenttext = $("#quick-compose-textarea").val();
			var category = $("#comment-category").val();
			$(element).find(".button").attr("disabled","disabled");
			$(element).find("#gif-loader-comment").show();
			$.post("/php/commentajax.php", {comment:commenttext, category:category},
					function(result) {
					$(element).find("#gif-loader-comment").hide();
					$(element).find(".button").removeAttr("disabled");
					if(result == 0 || result == "") {
						//$("#notification-bar p").html("Something went wrong. Please check your entries.").addClass("error");
						//$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
						toastr.error("Something went wrong. Please check your entries.");
					}
					else if(result == 1) {
						//$("#notification-bar p").html("Already submitted.").removeClass("available").addClass("error");
						//$("#notification-bar").css("marginLeft",-($("#notification-bar").width() / 2)).fadeIn("fast").delay(2500).fadeOut("slow");
						toastr.warning("Already submitted.");
					}
					else if(result != "") {
						if($(".comment-holder").length > 0) {
							$(result).insertBefore(".comment-holder:first");
							var newText = linkText($(".comment-text:first").text());
							$(".comment-text:first").addClass("linked").html(newText);
							shortenLink(".comment-text:first a");
						}
						else {
							$("<div id='comments-left-header'><h4>Comments</h4></div>").insertBefore("#grumble-comment");
							$(result).insertAfter("#grumble-comment");
							$("#comments-left .text-align-center").remove();
							var newText = linkText($(".comment-text:first").text());
							$(".comment-text:first").addClass("linked").html(newText);
							shortenLink(".comment-text:first a");
						}
							
						if($("#comments-left-header").length > 0) {
							var grumblenumber = parseInt($("#comments-left-header span").text()) + 1;
							$("#comments-left-header span").html(grumblenumber);
						}
		
						$("#quick-compose-textarea").val("").css({"height":"20px","background-color":"#FFF9E8"});
						$("#grumble-comment div").hide();
					}
			});
		}
		
	});
	
	$("button").removeAttr("disabled");

	$("#start-new-grumble").mousedown(function() {
		var wheight = $(window).height();
		if(wheight < 450 && wheight >= 360) {
			$("#grumble-lightbox").css("top", "50px");
		}
		else if(wheight < 360) {
			$("#grumble-lightbox").css("top", "5px");
		}
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
	var canLoad2 = true;
	var loadedtype = $("#comments-filter").val();
	if($("#comments-left .comment-holder").length == 10) {
		$(window).scroll(function () {
			if ($(window).scrollTop() >= $(document).height() - $(window).height() && canLoad) {
				canLoad = false;
				subCat = $("#subcat-id").attr("data-id");
				if(subCat == null) {
					subCat = $.urlParam("id");
				}
				if(loadedtype == "recent") 
					var lastid = $(".username:last").attr("data-id");
				else
					var lastid = $(".comment-holder").length;
				$("#gif-loader").fadeIn(50);
				$.post("/php/commentloadajax.php", {typescroll:loadedtype ,pagenumber:pageNumber, number:10, subCat:subCat, lastid:lastid},
					function(result) {
						$("#gif-loader").fadeOut(50);
						if(result == "none") {
							//no more are available
							loadMore = false;
							canLoad = false;
							$("#load-more-grumbles").hide();
							toastr.warning("No more comments to load.");
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
		$("#load-more-grumbles").click(function() {
			if(canLoad) {
				canLoad = false;
				subCat = $("#subcat-id").attr("data-id");
				if(subCat == null) {
					subCat = $.urlParam("id");
				}
				if(loadedtype == "recent") 
					var lastid = $(".username:last").attr("data-id");
				else
					var lastid = $(".comment-holder").length;
				$("#gif-loader").fadeIn(50);
				$.post("/php/commentloadajax.php", {typescroll:loadedtype ,pagenumber:pageNumber, number:10, subCat:subCat, lastid:lastid},
					function(result) {
						$("#gif-loader").fadeOut(50);
						if(result == "none") {
							//no more are available
							loadMore = false;
							canLoad = false;
							$("#load-more-grumbles").hide();
							toastr.warning("No more comments to load.");
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
		$("#comments-filter").change(function() {
			var type = $(this).val();
			subCat = $("#subcat-id").attr("data-id");
			if(subCat == null) {
				subCat = $.urlParam("id");
			}
			if(canLoad2 && type != loadedtype) {
				loadedtype = type;
				canLoad2 = false;
				loadMore = true;
				canLoad = true;
				$(".comment-holder").each(function () {
					$(this).remove();
				});
				$("#gif-loader").show();
				$.post("/php/commentloadajax.php", {type:type, subCat:subCat},
					function(result) {
						canLoad2 = true;
						$("#gif-loader").hide();
						if(result != "none" && result != "") {
							if($("#grumble-comment").length > 0)
								$(result).insertAfter("#grumble-comment");
							else
								$(result).insertAfter("#comments-left-header");
						}
						else {
							toastr.error("No comments loaded.");
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
		
		//set arrow to proper first position
		var margin = $(".tabs a.active").position();
		margin = margin.left + ($(".tabs a.active").width() / 2) - ($("#arrow-top img").width() / 2);
		$("#arrow-top img").css("margin-left",margin);
			
		$(this).on('click', 'a', function(e) {
			//check if the view more button should show up
			if(($("#tab2 .grumble-holder").length >= 10 && $(this).html() == "Recent Grumbles" && !resultDone) || ($("#tab1 .grumble-holder").length >= 10 && $(this).html() == "Top Grumbles" && !topDone)
			|| ($("#tab4 .comment-holder").length >= 10 && $(this).html() == "Recent Comments" && !resultGDone) || ($("#tab3 .comment-holder").length >= 10 && $(this).html() == "Top Comments" && !topGDone)
			|| ($("#tab2 .grumble-holder").length >= 10 && $(this).html() == "Grumbles" && !topDone) || ($("#tab1 .comment-holder").length >= 10 && $(this).html() == "Comments" && !resultGDone)) {
				$(".view-more").slideDown("fast");
			}
			else {
				$(".view-more").slideUp("fast");
			}
			//animate arrow
			var margin = $(this).position();
			margin = margin.left + ($(this).width() / 2) - ($("#arrow-top img").width() / 2);
			$("#arrow-top img").animate({"marginLeft":margin}, "normal");
			
			$active.removeClass('active');
			$content.fadeOut("fast");
	
			$active = $(this);
			$content = $($(this).attr('href'));
	
			$active.addClass('active');
			$content.fadeIn("normal");
	
			e.preventDefault();
		});
	});
	//add a listener for document resize
	if($("ul.tabs").length > 0) {
		$(window).resize(function() {
			//set arrow to proper first position
			var margin = $(".tabs a.active").position();
			margin = margin.left + ($(".tabs a.active").width() / 2) - ($("#arrow-top img").width() / 2);
			$("#arrow-top img").css("margin-left",margin);
		});
	}
	
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
		toastr.error("Incorrect email/password entered.");
	}
	
	$("#forg-submit").click(function(event) {
		if($("#pass-forg").val() == "" || $("#pass-forg2").val() == "") {
			event.preventDefault();
			toastr.warning("Cannot leave a field blank.");
		}
		else if($("#pass-forg").val().length <= 5) {
			event.preventDefault();
			toastr.warning("Password has to be longer than 5 characters.");
		}
		else if($("#pass-forg").val() != $("#pass-forg2").val()) {
			event.preventDefault();
			toastr.warning("Passwords have to match.");
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
		
		$("#sub-category-desc").shorten({"showChars":250});
	}
	if($(".grumble-description").length > 0) {
		$.each($(".grumble-description"), function() {
			var newText = linkText($(this).html());
			$(this).addClass("linked").html(newText);
		});
		
		shortenLink(".grumble-description a");
	}

	if($("#cover-bottom-bar").length > 0) {
		//fix for image caching in IE
		if($.browser.msie) {
			$("#grumble-monster-home img").attr("src", $("#grumble-monster-home img").attr("src") + "?random=" + Math.floor(Math.random()*11));
		}
		$("#grumble-monster-home img").load(function() {
			var $contentholder = $('#cover-content-holder');
			$contentholder.fadeIn("normal").animate({
				left: $(window).width() / 2 - $contentholder.width() / 2,
				top: $(window).height() / 2 - $contentholder.height() / 2
			});
		});
		$("body").css("height",$(window).height());
		$("#cover-bottom-bar img").click(function() {
			animateHomeCover();
		});

		$(window).resize(function(){
			var $contentholder = $('#cover-content-holder');
			var $cover = $("#homepage-cover");
			//cover is down
			if(parseInt($cover.css("marginTop")) == 0) {
				$("body").css("height",$(window).height());
				$cover.css({
					width:$(window).width(),
					height:$(window).height(),
					marginTop:0
				});
			}
			else {
				$("body").css("height","");
				$cover.css({
					width:$(window).width(),
					height:$(window).height(),
					marginTop:-$cover.height() + 48
				});
			}
			$contentholder.css({
				left: $(window).width() / 2 - $contentholder.width() / 2,
				top: ($(window).height() / 2 - $contentholder.height() / 2) - 20
			});
		});

		// To initially run the function:
		$(window).resize();
	}
});

function animateHomeCover() {
	var $cover = $("#homepage-cover");
	var $bottombarimage = $("#cover-bottom-bar img");
	//cover is down
	if(parseInt($cover.css("marginTop")) == 0) {
		$("body").css("height",$(window).height());
		$cover.css({width:$(window).width(),height:$(window).height()});
		$cover.stop().animate({marginTop:-$cover.height() + 48}, 2000);
		$bottombarimage.stop().animate({marginTop:"10px"}, 2000);
		$bottombarimage.rotate({angle:0, animateTo:180});
	}
	//cover is up
	else {
		$("body").css("height","");
		$cover.css({width:$(window).width(),height:$(window).height()});
		$cover.stop().animate({marginTop:0}, 2000);
		$bottombarimage.stop().animate({marginTop:"-42.5px"}, 2000);
		$bottombarimage.rotate({angle:180, animateTo:0});
	}
}

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

// By: Hans Fjällemark and John Papa
// https://github.com/CodeSeven/toastr
// 
// Modified to support css styling instead of inline styling
// Inspired by https://github.com/Srirangan/notifer.js/
;(function(window, $) {
    window.toastr = (function() {
        var 
            defaults = {
                tapToDismiss: true,
                toastClass: 'toast',
                containerId: 'toast-container',
                debug: false,
                fadeIn: 300,
                fadeOut: 700,
                extendedTimeOut: 1000,
                iconClasses: {
                    error: 'toast-error',
                    info: 'toast-info',
                    success: 'toast-success',
                    warning: 'toast-warning'
                },
                iconClass: 'toast-info',
                positionClass: 'toast-center',
                timeOut: 3000, // Set timeOut to 0 to make it sticky
                titleClass: 'toast-title',
                messageClass: 'toast-message'
            },


            error = function(message, title) {
                return notify({
                    iconClass: getOptions().iconClasses.error,
                    message: message,
                    title: title
                })
            },

            getContainer = function(options) {
                var $container = $('#' + options.containerId)

                if ($container.length)
                    return $container

                $container = $('<div/>')
                    .attr('id', options.containerId)
                    .addClass(options.positionClass)

                $container.appendTo($('body'))

                return $container
            },

            getOptions = function() {
                return $.extend({}, defaults, toastr.options)
            },

            info = function(message, title) {
                return notify({
                    iconClass: getOptions().iconClasses.info,
                    message: message,
                    title: title
                })
            },

            notify = function(map) {
                var 
                    options = getOptions(),
                    iconClass = map.iconClass || options.iconClass,
                    intervalId = null,
                    $container = getContainer(options),
                    $toastElement = $('<div/>'),
                    $titleElement = $('<div/>'),
                    $messageElement = $('<div/>'),
                    response = { options: options, map: map }

                if (map.iconClass) {
                    $toastElement.addClass(options.toastClass).addClass(iconClass)
                }

                if (map.title) {
                    $titleElement.append(map.title).addClass(options.titleClass)
                    $toastElement.append($titleElement)
                }

                if (map.message) {
                    $messageElement.append(map.message).addClass(options.messageClass)
                    $toastElement.append($messageElement)
                }

                var fadeAway = function() {
                    if ($(':focus', $toastElement).length > 0)
                		return
                	
                    var fade = function() {
                        return $toastElement.fadeOut(options.fadeOut)
                    }

                    $.when(fade()).done(function() {
                        if ($toastElement.is(':visible')) {
                            return
                        }
                        $toastElement.remove()
                        if ($container.children().length === 0)
                            $container.remove()
                    })
                }

                var delayedFadeAway = function() {
                    if (options.timeOut > 0 || options.extendedTimeOut > 0) {
                        intervalId = setTimeout(fadeAway, options.extendedTimeOut)
                    }
                }

                var stickAround = function() {
                    clearTimeout(intervalId)
                    $toastElement.stop(true, true)
                        .fadeIn(options.fadeIn)
                }

                $toastElement.hide()
                $container.prepend($toastElement)
                $toastElement.fadeIn(options.fadeIn)

                if (options.timeOut > 0) {
                    intervalId = setTimeout(fadeAway, options.timeOut)
                }

                $toastElement.hover(stickAround, delayedFadeAway)

                if (!options.onclick && options.tapToDismiss) {
                    $toastElement.click(fadeAway)
                }

                if (options.onclick) {
                    $toastElement.click(function() {
                        options.onclick() && fadeAway()
                    })
                }

                if (options.debug) {
                    console.log(response)
                }

                return $toastElement
            },

            success = function(message, title) {
                return notify({
                    iconClass: getOptions().iconClasses.success,
                    message: message,
                    title: title
                })
            },

            warning = function(message, title) {
                return notify({
                    iconClass: getOptions().iconClasses.warning,
                    message: message,
                    title: title
                })
            }

        return {
            error: error,
            info: info,
            options: {},
            success: success,
            warning: warning
        }
    })()
} (window, jQuery));
//shorten grumble description
jQuery.fn.shorten = function(settings) {
  var config = {
    showChars : 100,
    ellipsesText : "...",
    moreText : "more",
    lessText : "less"
  };
 
  if (settings) {
    $.extend(config, settings);
  }
 
  $('.morelink').live('click', function() {
    var $this = $(this);
    if ($this.hasClass('less')) {
      $this.removeClass('less');
      $this.html(config.moreText);
    } else {
      $this.addClass('less');
      $this.html(config.lessText);
    }
    $this.parent().prev().toggle();
    $this.prev().toggle();
    return false;
  });
 
  return this.each(function() {
    var $this = $(this);
 
    var content = $this.html();
    if (content.length > config.showChars && $(this).find("a").length == 0) {
      var c = content.substr(0, config.showChars);
      var h = content.substr(config.showChars, content.length - config.showChars);
      var html = c + '<span class="moreellipses">' + config.ellipsesText + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="javascript://nop/" class="morelink colored-link-1">' + config.moreText + '</a></span>';
      $this.html(html);
      $(".morecontent span").hide();
    }
  });
}