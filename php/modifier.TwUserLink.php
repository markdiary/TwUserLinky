<?php 
function smarty_modifier_TwUserLink( $str, $args) {
	if ($args != 1) {
		return $str;
	}
	return  preg_replace_callback('/([\\.\\\])?@(\w{1,15})/'
		, twlink
		, $str);
}
function twlink($matches){
	if ($matches[1]){
		$line = '@' . $matches[2];
	}
	else {
		$line = '<a class="twitter-anywhere-user" href="//www.twitter.com/' .$matches[2]. '">'  .'@'. $matches[2] . '</a>';
	}
return $line;
}