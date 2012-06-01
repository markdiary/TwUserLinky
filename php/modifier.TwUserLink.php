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
		$mt = empty($mt)? (MT::get_instance()) : $mt;
		$ctx =& $mt->context();
		$blog_id = 'blog:' . $ctx->stash('blog_id');
		$conf = empty($conf)? $mt->db()->fetch_plugin_data ( 'TwUserLinky', 'configuration:' . $blog_id ) : $conf;
		$link_target = $conf['twLinky_target'];
		$link_class = $conf['twLinky_class'];

	if ($matches[1]){
		$line = '@' . $matches[2];
	}
	else {
		$target = $link_target ==='1' ? ' target="_blank"' : '';
		$class  = $link_class ==='1' ? ' class="twitter-anywhere-user"' : '';

		$line = '<a' . $class . ' href="//www.twitter.com/' .$matches[2]. '"' . $target . '>' .'@'. $matches[2] . '</a>';
	}
return $line;
}