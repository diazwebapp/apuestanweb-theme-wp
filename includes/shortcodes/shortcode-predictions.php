<?php
function shortcode_predictions($atts)
{
    ob_start();
    
    extract(shortcode_atts(array(
        'model' => 1,
        'text' => '',
        'title' => '',
        'src_logo' => false,
        'src_bg' => false,
        'link' => false
    ), $atts));
    $ret = "";
    if($model == 1){

        $id_post = get_the_ID();
        $geolocation = isset($_SESSION["geolocation"]) ? json_decode($_SESSION["geolocation"]) : json_decode(GEOLOCATION);
        $aw_system_location = aw_select_country(["country_code"=>$geolocation->country_code]);

        $bookmaker = json_encode([]);

        //SI EL PAIS ESTÁ CONFIGURADO
if(isset($aw_system_location)):
    //SI EL SHORTCODE ES USADO EN UNA PAGINA
    if(is_page()){
        $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true,"on_page"=>true]);
        if($bookmaker["name"] == "no bookmaker"){
            $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true]);
        }
    }
    //SI EL SHORTCODE NÓ ES USADO EN UNA PAGINA
    if(!is_page()){
        $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true]);
    }
    //SI EL SHORTCODE ES USADO EN single
    if(is_single()):
        $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true,"on_single"=>true]);
        if($bookmaker["name"] == "no bookmaker"){
            $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true]);
        }
    endif;
endif;
if(!isset($aw_system_location)):
    $bookmaker = aw_select_relate_bookmakers(1, ["unique"=>true,"random"=>true]);
endif;
        
        $predictions = carbon_get_post_meta($id_post, 'predictions');
        if($predictions and count($predictions)> 0):
            
            foreach($predictions as $prediction):
                $oOddsConverter = new Converter($prediction['cuote'], 'eu');
                $odds_result = $oOddsConverter->doConverting();
                $prediction['cuote'] = $odds_result[$_SESSION['odds_format']];

                $ret .= "<br/><div class='single_event_match_title_box'>
                            <div class='row mx-1 px-4 py-4' style='background:white;border-radius:4.3rem;'>
                                <img width='80' height='20' loading='lazy' src='{$bookmaker['logo_2x1']}'  style='object-fit-contain;' alt='{$bookmaker['name']}'>
                                <p class='text-uppercase ml-3' style='font-size:1.4rem;'>
                                    pronóstico: {$prediction['title']}
                                </p>
                                <span class='ml-3 pt-1 text-body'>
                                    {$prediction['tvalue']}
                                    <i class='fas fa-star align-text-top text-warning'></i>
                                </span>
                                
                            </div>
                            
                            <div class='match_title_right_point'>
                                <p class='text-light' style='font-size:1.4rem;' >{$prediction['cuote']}</p>
                            </div>  
                        </div><br/>";
            endforeach;
        endif;
    }
    
    return $ret;
}


add_shortcode('predictions', 'shortcode_predictions');