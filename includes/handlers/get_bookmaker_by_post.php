<?php 
function get_bookmaker_by_post($id,$size_logo=["w"=>30,"h"=>30],$size_wallpaper=["w"=>1080,"h"=>400]){

    $bk = isset(carbon_get_post_meta($id, 'bk')[0]) ? carbon_get_post_meta($id, 'bk')[0]['id'] : false ;

    $bookmaker["name"] = "no bookmaker";
    $bookmaker["logo"] = get_template_directory_uri() . '/assets/img/logo2.svg';
    $bookmaker["wallpaper"] = get_template_directory_uri() . '/assets/img/baner2.png';

    if($bk):
        $bookmaker['name'] = get_the_title( $bk );
        $bookmaker["bonus_sum"] = carbon_get_post_meta($bk, 'bonus_sum');
        $bookmaker["ref_link"] = carbon_get_post_meta($bk, 'ref');
        $bookmaker["bonus"] = carbon_get_post_meta($bk, 'bonus');
        
        if (carbon_get_post_meta($bk, 'mini_img')):
            $logo = carbon_get_post_meta($bk, 'mini_img');
            $bookmaker['logo'] = wp_get_attachment_url($logo);
        endif;
        if (carbon_get_post_meta($bk, 'wbg')):
            $wallpaper = carbon_get_post_meta($bk, 'wbg');
            $bookmaker['wallpaper'] = wp_get_attachment_url($wallpaper);
        endif;

        //geolocation
        $bk_countries = carbon_get_post_meta($bk,'countries');
        $location = json_decode(GEOLOCATION);
        if($location->success == true and $bk_countries and count($bk_countries) > 0):
            foreach($bk_countries as $country):
                if($country['country_code'] == $location->country_code): //si existe coincidencia entre pais del bk y el pais del cliente
                    $bookmaker["ref_link"] = $country['ref'];
                    $bookmaker["bonus"] = $country['bonus'];
                endif;
            endforeach;
        endif;
    endif;
    
    return $bookmaker;
} 