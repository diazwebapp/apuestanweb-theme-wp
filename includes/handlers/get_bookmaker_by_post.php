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

        
        //Obtenemos la geolocalizacion del cliente y los paises configurados de dicha casa de apuesta
        $location = json_decode(GEOLOCATION);
        $bk_countries = carbon_get_post_meta($bk,'countries');
        //verificamos que tenemos geolocalizado al cliente y existen paises configurados en la casa de apuesta
        if($bk_countries and count($bk_countries) > 0):
            //Rerorremos todos los paises consigurados de la casa de apuesta actual
            foreach($bk_countries as $country):
                //si existe coincidencia entre pais de la casa de apuesta actual y el pais del cliente 
                if($country['country_code'] == $location->country_code):
                    //Seteamos link de referido y bonus slogan
                    $bookmaker["ref_link"] = $country['ref'];
                    $bookmaker["bonus"] = $country['bonus'];
                endif;
                //Si no existe coincidencia buscamos casas de apuestas alternativas o variaciones
                if($country['country_code'] != $location->country_code):
                    $bk_alternatives = carbon_get_post_meta($bk, 'alt_bk') ;

                    //Verificamos que tenemos las casas de apuestas altenativas
                    if($bk_alternatives and count($bk_alternatives) > 0): 
                        //Recorremos las casas de apuestas alternativas
                        foreach($bk_alternatives as $alt_bk):
                            //Comprobamos que el pais de la casa de apuesta alternativa coincida con el pais del cliente
                            if($alt_bk['country_code'] == $location->country_code):
                                //Seteamos sus nuevos valores
                                $bookmaker['name'] = get_the_title($alt_bk['bk'][0]['id']);
                                $bookmaker["bonus_sum"] = carbon_get_post_meta($alt_bk['bk'][0]['id'], 'bonus_sum');
                                $bookmaker["ref_link"] = carbon_get_post_meta($alt_bk['bk'][0]['id'], 'ref');
                                $bookmaker["bonus"] = carbon_get_post_meta($alt_bk['bk'][0]['id'], 'bonus');
                                $logo = carbon_get_post_meta($alt_bk['bk'][0]['id'], 'mini_img');
                                $bookmaker['logo'] = wp_get_attachment_url($logo);
                                $wallpaper = carbon_get_post_meta($alt_bk['bk'][0]['id'], 'wbg');
                                $bookmaker['wallpaper'] = wp_get_attachment_url($wallpaper);
                                //buscamos los paises configurados de la casa de apuesta alternativa 
                                $alternative_bk_countries = carbon_get_post_meta($alt_bk['bk'][0]['id'],'countries');
                                //Verificamos que existan paises configurados en esta casa de apuesta alternativa
                                if($alternative_bk_countries and count($alternative_bk_countries) > 0):
                                    //Al obtener lo paises las recorremos
                                    foreach($alternative_bk_countries as $alternative_bk_country):
                                        //Comprobamos que el pais configurado en la casa de apuesta alternativa coincida con el pais del cliente
                                        if($alternative_bk_country['country_code'] ==  $location->country_code):
                                            //Seteamos link de referido y bonus slogan
                                            $bookmaker["ref_link"] =  $alternative_bk_country['ref'];
                                            $bookmaker["bonus"] =  $alternative_bk_country['bonus'];
                                        endif;
                                    endforeach;
                                endif;
                            endif;
                        endforeach;
                    endif;        
                endif;
            endforeach;
        endif;
    endif;
    
    return $bookmaker;
} 

function get_bookmaker_by_country($location=false,$unique=false){
    if(!$location){
        $location = json_decode(GEOLOCATION);
    }
    ///Buscamos el pais en la base de datos
    $aw_system_location = aw_select_country(["country_code"=>$location->country_code]);
    $related_bookmaker = aw_select_relate_bookakers($aw_system_location->id, true, true);
    $bookmaker["name"] = "no bookmaker";
    $bookmaker["logo"] = get_template_directory_uri() . '/assets/img/logo2.svg';
    $bookmaker["wallpaper"] = get_template_directory_uri() . '/assets/img/baner2.png';
    if($related_bookmaker){
        //Si existe una casa de apuesta seteamos sus valores
        $bookmaker['name'] = $related_bookmaker->post_title;
        $bookmaker["bonus_sum"] = carbon_get_post_meta($related_bookmaker->ID, 'bonus_sum');
        $bookmaker["ref_link"] = carbon_get_post_meta($related_bookmaker->ID, 'ref');
        $bookmaker["bonus"] = carbon_get_post_meta($related_bookmaker->ID, 'bonus');
        
        if (carbon_get_post_meta($related_bookmaker->ID, 'mini_img')):
            $logo = carbon_get_post_meta($related_bookmaker->ID, 'mini_img');
            $bookmaker['logo'] = wp_get_attachment_url($logo);
        endif;
        if (carbon_get_post_meta($related_bookmaker->ID, 'wbg')):
            $wallpaper = carbon_get_post_meta($related_bookmaker->ID, 'wbg');
            $bookmaker['wallpaper'] = wp_get_attachment_url($wallpaper);
        endif;
    }
    return $bookmaker;
}