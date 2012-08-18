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