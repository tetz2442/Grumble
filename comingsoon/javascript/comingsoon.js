// JavaScript Document
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33671147-1']);
  _gaq.push(['_trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
  
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
(function($) {
	$.fn.countdown = function(options, callback) {

		//custom 'this' selector
		thisEl = $(this);

		//array of custom settings
		var settings = { 
			'date': null,
			'format': null
		};

		//append the settings array to options
		if(options) {
			$.extend(settings, options);
		}
		
		//main countdown function
		function countdown_proc() {
			
			eventDate = Date.parse(settings['date']) / 1000;
			currentDate = Math.floor($.now() / 1000);
			
			if(eventDate <= currentDate) {
				callback.call(this);
				clearInterval(interval);
			}
			
			seconds = eventDate - currentDate;
			
			days = Math.floor(seconds / (60 * 60 * 24)); //calculate the number of days
			seconds -= days * 60 * 60 * 24; //update the seconds variable with no. of days removed
			
			hours = Math.floor(seconds / (60 * 60));
			seconds -= hours * 60 * 60; //update the seconds variable with no. of hours removed
			
			minutes = Math.floor(seconds / 60);
			seconds -= minutes * 60; //update the seconds variable with no. of minutes removed
			
			//conditional Ss
			if (days == 1) { thisEl.find(".timeRefDays").text("day"); } else { thisEl.find(".timeRefDays").text("days"); }
			if (hours == 1) { thisEl.find(".timeRefHours").text("hour"); } else { thisEl.find(".timeRefHours").text("hours"); }
			if (minutes == 1) { thisEl.find(".timeRefMinutes").text("minute"); } else { thisEl.find(".timeRefMinutes").text("minutes"); }
			if (seconds == 1) { thisEl.find(".timeRefSeconds").text("second"); } else { thisEl.find(".timeRefSeconds").text("seconds"); }
			
			//logic for the two_digits ON setting
			if(settings['format'] == "on") {
				days = (String(days).length >= 2) ? days : "0" + days;
				hours = (String(hours).length >= 2) ? hours : "0" + hours;
				minutes = (String(minutes).length >= 2) ? minutes : "0" + minutes;
				seconds = (String(seconds).length >= 2) ? seconds : "0" + seconds;
			}
			
			//update the countdown's html values.
			if(!isNaN(eventDate)) {
				thisEl.find(".days").text(days);
				thisEl.find(".hours").text(hours);
				thisEl.find(".minutes").text(minutes);
				thisEl.find(".seconds").text(seconds);
			} else { 
				alert("Invalid date. Here's an example: 12 Tuesday 2012 17:30:00");
				clearInterval(interval); 
			}
		}
		
		//run the function
		countdown_proc();
		
		//loop the function
		interval = setInterval(countdown_proc, 1000);
		
	}
}) (jQuery);
  
var regExpEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z]+\.[a-z]{2,4}$/;
var email = false;

$(document).ready(function() { 
	$("#countdown").countdown({
		date: "19 september 2012 18:30:00",
		format: "on"
	});
			
});