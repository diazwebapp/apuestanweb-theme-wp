<?php 
function get_bookmaker_by_post($id,$size_logo=["w"=>30,"h"=>30],$size_wallpaper=["w"=>1080,"h"=>400]){

    $bk = isset(carbon_get_post_meta($id, 'bk')[0]) ? carbon_get_post_meta($id, 'bk')[0]['id'] : false ;
    $bookmaker = [
        "name" => "no bookmaker",
        "logo" => get_template_directory_uri() . '/assets/img/logo2.svg',
        "wallpaper" => get_template_directory_uri() . '/assets/img/baner2.png',
        "ref_link" => carbon_get_post_meta($bk, 'ref'),
        "bonus" => carbon_get_post_meta($bk, 'bonus'),
        "bonus_sum" => carbon_get_post_meta($bk, 'bonus_sum'),
        "bonus_sum_table" => carbon_get_post_meta($bk, 'bonus_sum_table')
    ];

    /* if($bk):
        $bookmaker['name'] = get_the_title( $bk );
        if (carbon_get_post_meta($bk, 'mini_img')):
            $logo = carbon_get_post_meta($bk, 'mini_img');
            $bookmaker['logo'] = aq_resize(wp_get_attachment_url($logo), $size_logo['w'], $size_logo['h'], true, true, true);
        endif;
        if (carbon_get_post_meta($bk, 'wbg')):
            $wallpaper = carbon_get_post_meta($bk, 'wbg');
            $bookmaker['wallpaper'] = aq_resize(wp_get_attachment_url($wallpaper),  $size_wallpaper['w'], $size_wallpaper['h'], true, true, true);
        endif;
    endif; */
    if($bk):
        $bookmaker['name'] = get_the_title( $bk );
        if (carbon_get_post_meta($bk, 'mini_img')):
            $logo = carbon_get_post_meta($bk, 'mini_img');
            $bookmaker['logo'] = wp_get_attachment_url($logo);
        endif;
        if (carbon_get_post_meta($bk, 'wbg')):
            $wallpaper = carbon_get_post_meta($bk, 'wbg');
            $bookmaker['wallpaper'] = wp_get_attachment_url($wallpaper);
        endif;
    endif;
    
    return $bookmaker;
} 