<?php 
function get_bookmaker_by_post($id,$size_logo=["w"=>30,"h"=>30],$size_wallpaper=["w"=>1080,"h"=>400]){
    //Seteamos valores por defecto de la casa de apuesta
    $bookmaker["name"] = "no bookmaker";
    $bookmaker["logo"] = get_template_directory_uri() . '/assets/img/logo2.svg';
    $bookmaker["wallpaper"] = get_template_directory_uri() . '/assets/img/baner2.png';
    //Buscamos la casa de apuesta del pronostico
    $bk = isset(carbon_get_post_meta($id, 'bk')[0]) ? carbon_get_post_meta($id, 'bk')[0]['id'] : false ;
    if($bk):
        //Si existe una casa de apuesta seteamos sus valores
        $bookmaker['name'] = get_the_title( $bk );
        $bookmaker["bonus_amount"] = carbon_get_post_meta($bk, 'bonus_amount');
        $bookmaker["ref_link"] = carbon_get_post_meta($bk, 'ref');
        $bookmaker["bonus_slogan"] = carbon_get_post_meta($bk, 'bonus_slogan');
        
        if (carbon_get_post_meta($bk, 'mini_img')):
            $logo = carbon_get_post_meta($bk, 'mini_img');
            $bookmaker['logo'] = wp_get_attachment_url($logo);
        endif;
        if (carbon_get_post_meta($bk, 'wbg')):
            $wallpaper = carbon_get_post_meta($bk, 'wbg');
            $bookmaker['wallpaper'] = wp_get_attachment_url($wallpaper);
        endif;

        
        $bookmaker['name'] = get_the_title($alt_bk['bk'][0]['id']);
        $bookmaker["bonus_amount"] = carbon_get_post_meta($alt_bk['bk'][0]['id'], 'bonus_amount');
        $bookmaker["ref_link"] = carbon_get_post_meta($alt_bk['bk'][0]['id'], 'ref');
        $bookmaker["bonus_slogan"] = carbon_get_post_meta($alt_bk['bk'][0]['id'], 'bonus_slogan');
        $logo = carbon_get_post_meta($alt_bk['bk'][0]['id'], 'mini_img');
        $bookmaker['logo'] = wp_get_attachment_url($logo);
        $wallpaper = carbon_get_post_meta($alt_bk['bk'][0]['id'], 'wbg');
        $bookmaker['wallpaper'] = wp_get_attachment_url($wallpaper);
    endif;
    
    return $bookmaker;
} 
