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
		$mt = MT::get_instance();
		$ctx =& $mt->context();
		$blog_id = 'blog:' . $ctx->stash('blog_id');

	if ($matches[1]){
		$line = '@' . $matches[2];
	}
	else {
		$conf = $mt->db()->fetch_plugin_data ( 'TwUserLinky', 'configuration:' . $blog_id );
		$link_target = $conf['twLinky_target'];
		$link_class = $conf['twLinky_class'];
		$target = $link_target ==='1' ? ' target="_blank"' : '';
		$class  = $link_class ==='1' ? ' class="twitter-anywhere-user"' : '';

		$line = '<a' . $class . ' href="//www.twitter.com/' .$matches[2]. '"' . $target . '>' .'@'. $matches[2] . '</a>';
	}
return $line;
}