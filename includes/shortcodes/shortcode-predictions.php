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
        $geolocation = json_decode($_SESSION["geolocation"]);
        $aw_system_location = aw_select_country(["country_code"=>$geolocation->country_code]);

$bookmaker = [];

        //SI EL PAIS ESTÁ CONFIGURADO
if(isset($aw_system_location)):
    //SI EL SHORTCODE ES USADO EN UNA PAGINA
    if(is_page()){
        $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true,"on_page"=>true]);
    }
    
    //SI EL SHORTCODE ES USADO EN single
    if(is_single() or is_singular( )):
        $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true,"on_single"=>true]);
    endif;
    if(!is_single() and !is_singular( ) and !is_page()):
        $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true]);
    endif;
endif;

        
        $predictions = carbon_get_post_meta($id_post, 'predictions');
        if($predictions and count($predictions)> 0):
            
            foreach($predictions as $prediction):
                $oOddsConverter = new Converter($prediction['cuote'], 'eu');
                $odds_result = $oOddsConverter->doConverting();
                $prediction['cuote'] = $odds_result[get_option( 'odds_type' )];

                $ret .= "<div class='single_event_match_title_box'>
                            <div class='tip-p row mx-1 px-4 py-4'>
                            <a href='{$bookmaker['ref_link']}' rel='nofollow noreferrer noopener' target='_blank'><img width='80' height='20' loading='lazy' src='{$bookmaker['logo_2x1']}'  style='background:{$bookmaker['background_color']};border-radius: 6px;padding: 4px;height: 3rem;' alt='{$bookmaker['name']}'></a>
                            </div>
                            <table class='table-single-predict'>
                            <thead>
                                <tr>                                   
                                <th scope='col'>Pronóstico</th>
                                <th scope='col'>Cuota</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr> 
                                    <td>{$prediction['title']}
                                    </td>
                                    <td class=''>{$prediction['cuote']}</td>
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                            <a href='{$bookmaker['ref_link']}' rel='nofollow noreferrer noopener' target='_blank'><button id='event-button'>Apostar</button></a>
                            
                        </div>
                        <div class='d-flex justify-content-center'>
                        <a href='{$bookmaker['ref_link']}' rel='nofollow'><button class='event-button-mv' style='margin-top: 2rem;'>Apostar</button></a>
                        </div>

                        <hr class='mt-2 mb-3'/>";
            endforeach;
        endif;
    }
    
    return $ret;
}


add_shortcode('predictions', 'shortcode_predictions');