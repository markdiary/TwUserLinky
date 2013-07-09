package TwUserLinky::Tags;

use strict;
use warnings;
use base qw( MT::Plugin );
use MT::Template::Context;

sub _hdlr_tw_user_link{
    my ($str, $arg, $ctx) = @_;
    my $flg = '';
    my $space ='';
    return $str if $arg != 1;
    my $plugin = MT->component('TwUserLinky');
    
    my $blog_id = $ctx->stash('blog_id');
    my $link_target = $plugin->get_config_value('twLinky_target', 'blog:'.$blog_id);
    my $link_class =  $plugin->get_config_value('twLinky_class', 'blog:'.$blog_id);
    my $add_segmentation = $plugin->get_config_value('twLinky_seg', 'blog:'.$blog_id);
    $str =~ s/(?:([\.\\]))?@([0-9a-zA-Z_]{1,15})/&tw_link($1, $2, $link_target, $link_class , $add_segmentation)/eg;
    return $str;
}

sub tw_link {
    my ( $flg, $account, $link_target, $link_class , $add_segmentation) = @_;
    my $line;
    my $target;
    my $class;
    my $space = '';
    if ( $flg ){
        $line = '@'. $account;
    }
    else {
        $target = $link_target eq "true" ? qq( target="_blank") : '';
        $class = $link_class eq "true" ? qq( class="twitter-anywhere-user") : '';
        $space = $add_segmentation eq "true" ? " " : '';
        $line = qq($space<a$class href="https://twitter.com/$account"$target>\@$account</a>$space);
    }
    return $line;
}

1;