<?php 
function get_bookmaker_custom_data($id){
   
    $bookmaker['name'] = get_the_title( $id );
     $aw_system_country = aw_select_country(["table_id"=>$country_id]);
        
        $bonuses = carbon_get_post_meta($list->ID, 'country_bonus');
        if(isset($bonuses) and count($bonuses) > 0):
          foreach($bonuses as $bonus_data):
              if(strtoupper($bonus_data["country_code"]) == strtoupper($aw_system_country->country_code)):
                $bookmaker["bonus_slogan"] = $bonus_data['country_bonus_slogan'];
                $bookmaker["bonus_amount"] = $bonus_data['country_bonus_amount'];
                $bookmaker["ref_link"] = $bonus_data['country_bonus_ref_link'];
              endif;
          endforeach;
        endif;
       
        $bookmaker["background_color"] = carbon_get_post_meta($list->ID, 'background-color');
        $bookmaker["feactures"] = carbon_get_post_meta($list->ID, 'feactures');
        $bookmaker["rating"] = carbon_get_post_meta($list->ID, 'rating');
        $bookmaker["general_feactures"] = carbon_get_post_meta($list->ID, 'general_feactures');
        $bookmaker["payment_methods"] = get_bookmaker_payments($list->ID);
        if (carbon_get_post_meta($list->ID, 'logo')):
          $logo = carbon_get_post_meta($list->ID, 'logo');
          $bookmaker["logo"] = wp_get_attachment_url($logo);
        endif; 
        if (carbon_get_post_meta($list->ID, 'logo_2x1')):
          $logo = carbon_get_post_meta($list->ID, 'logo_2x1');
          $bookmaker["logo_2x1"] = wp_get_attachment_url($logo);
        endif;        
      
    return $bookmaker;
} 

function get_bookmaker_payments($bookmaker_id){
    $methods = carbon_get_post_meta($bookmaker_id, 'payment_methods');
    $bookmaker_payment_methods = [];
    if(isset($methods) and count($methods) > 0){
        
        foreach($methods as $key_item => $item){
            
            
            if (isset($item['payment_method'][0]["id"]) && isset($item['payment_method'][0]["subtype"])) {
                $term = get_term($item['payment_method'][0]["id"], $item['payment_method'][0]["subtype"]);
                if (!is_wp_error($term) && isset($term->term_id)) {
                    $default_logo = get_template_directory_uri() . "/assets/img/logo2.svg";

                    $logo = carbon_get_term_meta($term->term_id, 'logo_1x1');
                    if ($logo) {
                        $logo = (wp_get_attachment_url($logo)) ? wp_get_attachment_url($logo) : $default_logo;
                    }

                    $logo_2x1 = carbon_get_term_meta($term->term_id, 'logo_2x1');
                    if ($logo_2x1) {
                        $logo_2x1 = (wp_get_attachment_url($logo_2x1)) ? wp_get_attachment_url($logo_2x1) : $default_logo;
                    }

                    $bookmaker_payment_methods[$key_item] = $term;
                    $bookmaker_payment_methods[$key_item]->logo_1x1 = $logo;
                    $bookmaker_payment_methods[$key_item]->logo_2x1 = $logo_2x1;
                    $bookmaker_payment_methods[$key_item]->payment_method_chars = [];

                    if (isset($item["caracteristicas"]) && count($item["caracteristicas"]) > 0) {
                        foreach ($item["caracteristicas"] as $char) {
                            $bookmaker_payment_methods[$key_item]->payment_method_chars[] = [
                                "titulo" => $char["title"],
                                "contenido" => $char["content"]
                            ];
                        }
                    }
                    $bookmaker_payment_methods[$key_item] = json_decode(json_encode($bookmaker_payment_methods[$key_item]));
                }
            }
        }
    }
    return $bookmaker_payment_methods;
}