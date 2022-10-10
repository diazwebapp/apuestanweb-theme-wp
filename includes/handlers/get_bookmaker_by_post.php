<?php 
function get_bookmaker_by_post($id){
    //Seteamos valores por defecto de la casa de apuesta
    $bookmaker["name"] = "no bookmaker";
    $bookmaker["logo"] = get_template_directory_uri() . '/assets/img/logo2.svg';
    $bookmaker["background_color"] = '';
    //Buscamos la casa de apuesta del pronostico
    $bk = isset(carbon_get_post_meta($id, 'bk')[0]) ? carbon_get_post_meta($id, 'bk')[0]['id'] : false ;
    if($bk):
        //Si existe una casa de apuesta seteamos sus valores
        $bookmaker['name'] = get_the_title( $bk );
        $bookmaker["bonus_amount"] = carbon_get_post_meta($bk, 'bonus_amount');
        $bookmaker["ref_link"] = carbon_get_post_meta($bk, 'ref');
        $bookmaker["bonus_slogan"] = carbon_get_post_meta($bk, 'bonus_slogan');
        $bookmaker["background_color"] = carbon_get_post_meta($bk,'background-color');

        if (carbon_get_post_meta($bk, 'logo')):
            $logo = carbon_get_post_meta($bk, 'logo');
            $bookmaker['logo'] = wp_get_attachment_url($logo);
        endif;

    endif;
    
    return $bookmaker;
} 

function get_bookmaker_payments($bookmaker_id){
    $methods = carbon_get_post_meta(get_the_ID(), 'payment_methods');
    $bookmaker_payment_methods = [];
    if(!empty($methods) and count($methods) > 0){
        foreach($methods as $key_item => $item){
            $term = get_term($item['payment_method'][0]["id"],$item['payment_method'][0]["subtype"]);
            $default_logo = get_template_directory_uri( ) . "/assets/img/logo2.svg";
            
            $logo = carbon_get_term_meta($term->term_id,'logo_1x1'); 
            $logo = !empty(wp_get_attachment_url( $logo )) ? wp_get_attachment_url( $logo ) : $default_logo; 

            $logo_2x1 = carbon_get_term_meta($term->term_id,'logo_2x1');
            $logo_2x1 = !empty(wp_get_attachment_url( $logo_2x1 )) ? wp_get_attachment_url( $logo_2x1 ) : $default_logo;

            $bookmaker_payment_methods[$key_item] = $term;
            $bookmaker_payment_methods[$key_item]->logo_1x1 = $logo;
            $bookmaker_payment_methods[$key_item]->logo_2x1 = $logo_2x1;
            $bookmaker_payment_methods[$key_item]->payment_method_chars = [];

            if(!empty($item["caracteristicas"]) and count($item["caracteristicas"]) > 0){
                foreach($item["caracteristicas"] as $char){
                    $bookmaker_payment_methods[$key_item]->payment_method_chars[] = [
                        "titulo" => $char["title"],
                        "contenido" => $char["content"]
                    ];
                }
            }
            $bookmaker_payment_methods[$key_item] = json_decode(json_encode($bookmaker_payment_methods[$key_item]));
        }
    }
    return $bookmaker_payment_methods;
}