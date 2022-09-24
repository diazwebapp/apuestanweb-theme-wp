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

        if (carbon_get_post_meta($bk, 'mini_img')):
            $logo = carbon_get_post_meta($bk, 'mini_img');
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
            $default = [];
            $default[0] = get_template_directory_uri( ) . "/assets/img/logo2.svg";
            $default[1] = 30;
            $default[2] = 30;
            $logo = carbon_get_term_meta($item["payment_method"][0]["id"],'img_icon');
            
            $logo = isset($logo[0]) ? wp_get_attachment_image_src( $logo[0], [30,30] ): $default; 
            $bookmaker_payment_methods[$key_item] = [
                "id" => $item["payment_method"][0]["id"],
                "img_icon" => $logo,
                "payment_method_chars" => []
            ];

            if(!empty($item["caracteristicas"]) and count($item["caracteristicas"]) > 0){
                foreach($item["caracteristicas"] as $char){
                    $bookmaker_payment_methods[$key_item]["payment_method_chars"][] = [
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
/* function get_bookmaker_payments($bookmaker_id){
    $methods = carbon_get_post_meta(get_the_ID(), 'payment_methods');
    $bookmaker_payment_methods = [];
    if(!empty($methods) and count($methods) > 0){
        foreach($methods as $key_item => $item){
            $default = [];
            $default[0] = get_template_directory_uri( ) . "/assets/img/logo2.svg";
            $default[1] = 40;
            $default[2] = 40;
            $logo = carbon_get_term_meta($item["payment_method"][0]["id"],'img_icon');
            
            $logo = isset($logo[0]) ? wp_get_attachment_image_src( $logo[0], [40,40] ): $default; 
            $bookmaker_payment_methods[$key_item] = [
                "id" => $item["payment_method"][0]["id"],
                "img_icon" => $logo,
                "payment_method_chars" => []
            ];

            if(!empty($item["caracteristicas"]) and count($item["caracteristicas"]) > 0){
                foreach($item["caracteristicas"] as $char){
                    $bookmaker_payment_methods[$key_item]["payment_method_chars"][] = [
                        "titulo" => $char["title"],
                        "contenido" => $char["content"]
                    ];
                }
            }
            $bookmaker_payment_methods[$key_item] = json_decode(json_encode($bookmaker_payment_methods[$key_item]));
        }
    }
    return $bookmaker_payment_methods;
} */