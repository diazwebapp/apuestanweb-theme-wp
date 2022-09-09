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
        $geolocation = json_decode(GEOLOCATION);
        $aw_system_location = aw_select_country(["country_code"=>$geolocation->country_code]);

        $bookmaker = json_encode([]);

        //SI EL SHORTCODE ES USADO EN SINGLE PAGE
        if(is_single()){
            $bookmaker = aw_select_relate_bookakers($aw_system_location->id, ["unique"=>true,"random"=>true,"on_single"=>true]);
            if($bookmaker["name"] == "no bookmaker"){
                $bookmaker = aw_select_relate_bookakers($aw_system_location->id, ["unique"=>true,"random"=>true]);
            }
        }
        //SI EL SHORTCODE ES USADO EN UNA PAGINA
        if(is_page()){
            $bookmaker = aw_select_relate_bookakers($aw_system_location->id, ["unique"=>true,"random"=>true,"on_page"=>true]);
            if($bookmaker["name"] == "no bookmaker"){
                $bookmaker = aw_select_relate_bookakers($aw_system_location->id, ["unique"=>true,"random"=>true]);
            }
        }
        //SI EL SHORTCODE NÓ ES USADO EN UNA PAGINA
        if(!is_page() and !is_single()){
            $bookmaker = aw_select_relate_bookakers($aw_system_location->id, ["unique"=>true,"random"=>true]);
        }
        
        $predictions = carbon_get_post_meta($id_post, 'predictions');
        if($predictions and count($predictions)> 0):
            
            foreach($predictions as $prediction):
                $oOddsConverter = new Converter($prediction['cuote'], 'eu');
                $odds_result = $oOddsConverter->doConverting();
                $prediction['cuote'] = $odds_result[$_SESSION['odds_format']];

                $ret .= "<br/><div class='single_event_match_title_box'>
                            <div class='match_title_left_box'>
                                <div class='match_title_img_box'>
                                    <img width='90' loading='lazy' src='{$bookmaker['logo']}' class='img-fluid' alt='{$bookmaker['name']}'>
                                </div>
                                <div class='match_title_left_content'>
                                    <p style='text-transform:uppercase;' ><span class='match_title_left_text'>pronóstico: </span> {$prediction['title']}</p>
                                    <div class='ratings'>
                                        <span>{$prediction['tvalue']}</span>
                                        <i class='fas fa-star'></i>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class='match_title_right_box'>
                                <div class='match_title_right_point'>
                                    <p>{$prediction['cuote']}</p>
                                </div>
                            </div>    
                        </div><br/>";
            endforeach;
        endif;
    }
    
    return $ret;
}


add_shortcode('predictions', 'shortcode_predictions');