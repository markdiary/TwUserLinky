<?php
    function smarty_modifier_twuserlink ( $str, $args ){
        if ($args != 1) {
            return $str;
        }
        return  preg_replace_callback('/([\\.\\\])?@([0-9a-zA-Z_]{1,15})/', twlink, $str);
    }
    function twlink($matches){
        
        $conf_file = 'mt-config.cgi';
        $mt = MT::get_instance(null, $conf_file);
        $ctx =& $mt->context();
        $blog_id = 'blog:' . $ctx->stash('blog_id');
        $conf = array();
        $conf = $mt->db()->fetch_plugin_config ( 'TwUserLinky' , $blog_id );
        
        $add_segmentation = $conf["twLinky_seg"];
        $link_target = $conf["twLinky_target"];
        $link_class = $conf["twLinky_class"];
        
        if ($matches[1]){
            $line = '@' . $matches[2];
        }
        else {
            $line = '';
            $target = $link_target === "true" ? ' target="_blank"' : '';
            $class  = $link_class === "true" ? ' class="twitter-anywhere-user"' : '';
            $space  = $add_segmentation === "true" ? ' ' : '';
            $data = ' data-blogid="'.$blog_id.'"'. ' data-target="'.$link_target. '" data-seg="'.$add_segmentation. '"';
            $line .= $space . '<a'  . $data . $class . ' href="https://twitter.com/' .$matches[2]. '"' . $target . '>' .'@'. $matches[2] . '</a>' . $space;
        }
        
        return $line;
    }
?>