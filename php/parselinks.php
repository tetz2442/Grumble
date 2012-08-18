<?php
/* takes the text and converts links to a links */
function parseLinks($url)
{
	$url                                    =    str_replace("\\r","\r",$url);
    $url                                    =    str_replace("\\n","\n<BR>",$url);
    $url                                    =    str_replace("\\n\\r","\n\r",$url);

    $in=array(
    '`((?:https?|ftp)://\S+[[:alnum:]]/?)`si',
    '`((?<!//)(www\.\S+[[:alnum:]]/?))`si'
    );
    $out=array(
    '<a href="$1" target="_blank" class="colored-link-1">$1</a> ',
    '<a href="http://$1" target="_blank" class="colored-link-1">$1</a>'
    );
    return preg_replace($in,$out,$url);
}

/*URLs starting with http://, https://, or ftp://
    replacePattern1 = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
    replacedText = inputText.replace(replacePattern1, '<a href="$1" target="_blank" class="colored-link-1">$1</a>');

    //URLs starting with "www." (without // before it, or it'd re-link the ones done above).
    replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
    replacedText = replacedText.replace(replacePattern2, '$1<a href="http://$2" target="_blank" class="colored-link-1">$2</a>');*/
?>