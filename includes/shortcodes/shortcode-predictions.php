<?php
function shortcode_predictions($atts)
{
    ob_start();
    
    extract(shortcode_atts(array(
        'model' => 1,
        'id' => null,
    ), $atts));
    $ret = "";
    if($model == 1){

        $id_post = isset($id) ? $id : get_the_ID();
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
        $predictionCount = count($predictions);


        if ($predictionCount === 1) {

            $ret .= "<div class='container mt-2'>
            <div class='row'>";
            // Show the first component HTML if there is only one prediction
            $prediction = $predictions[0];
            $oOddsConverter = new Converter($prediction['cuote'], 'eu');
            $odds_result = $oOddsConverter->doConverting();
            $prediction['cuote'] = $odds_result[get_option('odds_type')];

            $ret .= "<div class='single_event_match_title_box mb-4'>
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
                    <td>{$prediction['title']}</td>
                    <td class=''>{$prediction['cuote']}</td>
                    
                </tr>
            </tbody>
            </table>
            <a href='{$bookmaker['ref_link']}' rel='nofollow noreferrer noopener' target='_blank'><button id='event-button'>Apostar</button></a>
            
            </div>
            <div class='d-flex justify-content-center'>
            <a href='{$bookmaker['ref_link']}' rel='nofollow'><button class='event-button-mv' style='margin-top: 2rem;'>Apostar</button></a>
            </div>

            <hr class='mt-2 mb-3'/>
            
            </div>
            </div>";

        } else {
                // Show the second component HTML if there are more than one prediction
                $ret .= "<div class='container mt-5'>
                            <div class='row'>";
    
                $predictionCounter = 1;
                    foreach($predictions as $prediction){
                        $oOddsConverter = new Converter($prediction['cuote'], 'eu');
                        $odds_result = $oOddsConverter->doConverting();
                        $prediction['cuote'] = $odds_result[get_option( 'odds_type' )];

                        $ret .= "<div class='col-md-6'>
                                    <div class='container border custom-rectangle'>
                                        <span class='text-muted pt-2'>Pronóstico {$predictionCounter}</span>
                                        <div class='row'>
                                            <div class='col-12 d-flex my-2 justify-content-between align-items-center'>
                                                <p style='line-height: 2rem;min-height: 2rem;'>{$prediction['title']}</p>                                           
                                                <span class='oddsbox'>{$prediction['cuote']}</span>
                                            </div>
                                            <div class='col-12 py-3 d-flex justify-content-between align-items-center' style='background: var(--text-color);'>
                                                <a href='{$bookmaker['ref_link']}' rel='nofollow noreferrer noopener' target='_blank' class='mb-1'><img width='120' height='30' loading='lazy' src='{$bookmaker['logo_2x1']}' style='background:{$bookmaker['background_color']};border-radius: 6px;padding: 8px;' alt='{$bookmaker['name']}'></a>
                                                <a href='{$bookmaker['ref_link']}' rel='nofollow noreferrer noopener' target='_blank'><button id='event-button-pp' class='btn btn-success mb-1 ml-1 btn-sm'>¡Gana ahora!</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
            $predictionCounter++;
        }

        $ret .= "</div>
            </div>";


       }
    }
    
    return $ret;
}


add_shortcode('predictions', 'shortcode_predictions');