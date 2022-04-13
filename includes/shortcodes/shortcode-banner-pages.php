<?php
function shortcode_banner($atts)
{
    
    global $term;
    extract(shortcode_atts(array(
        'model' => false,
        'text' => '',
        'title' => '',
        'src_logo' => false,
        'src_bg' => false,
        'link' => false,
        'text_link' => false,
        'vip_link' => false,
        'text_vip_link' => false
    ), $atts));
    $ret = '';
    //definiendo el background
    if(!$src_bg):
        if(is_category() or is_tax() or is_tag()):
            $src_bg = wp_get_attachment_url(carbon_get_term_meta($term->term_id, 'wbg'));
                if(!$src_bg):
                    $src_bg = get_template_directory_uri() . '/assets/img/banner2.png';
                endif;
        endif;
        if(is_page()):
            $src_bg = wp_get_attachment_url(carbon_get_post_meta(get_the_ID(), 'wbg'));            
            if(!$src_bg){
                $src_bg = get_the_post_thumbnail_url(get_the_ID());
                if(!$src_bg):
                    $src_bg = get_template_directory_uri() . '/assets/img/banner2.png';
                endif;
            }
        endif;
        if(!$src_bg):
            $src_bg = get_template_directory_uri() . '/assets/img/banner2.png';
        endif;
    endif;

    //definiendo el logo
    if(!$src_logo):
        if(is_page()):
            $src_logo = carbon_get_post_meta(get_the_ID(), 'fa_icon_class');
        endif;
       if(is_category() or is_tax() or is_tag()):
            $src_logo = carbon_get_term_meta($term->term_id, 'fa_icon_class');
       endif;        
    endif;
   
    if(is_page() && !$title)
        $title = get_the_title( );
    if(is_post_type_archive() && !$title)
        $title = post_type_archive_title( '', false );
    if(is_category() or is_tax())
        $title = single_term_title('',false );
    if(is_tag())
        $title = single_tag_title('',false );
    

    set_query_var("params",[
        "src_bg" => "url({$src_bg})",
        "src_logo" => $src_logo,
        "text" => $text,
        "title" => $title,
        'link' => $link,
        'text_link' => $text_link,
        'vip_link' => $vip_link,
        'text_vip_link' => $text_vip_link
    ]);

    if($model):
        $ret = load_template_part("/loop/banner_{$model}");
    else:
        $ret = load_template_part("/loop/banner_1");
    endif;
    return $ret;
}


add_shortcode('banner', 'shortcode_banner');