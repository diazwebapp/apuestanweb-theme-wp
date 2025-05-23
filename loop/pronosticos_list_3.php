<?php

$params = get_query_var('params');
$permalink = get_the_permalink($args["forecast"]->ID);
$predictions = carbon_get_post_meta($args["forecast"]->ID, 'predictions');

$sport_term = wp_get_post_terms($args["forecast"]->ID, 'league', array('fields' => 'all'));


$sport['class'] = '' ;
$sport['name'] = '';
if ($sport_term) {
    foreach ( $sport_term as $item ) {
        if($item->parent == 0){
            $sport['class'] = carbon_get_term_meta($item->term_id, 'fa_icon_class');
            $sport['name'] = $item->name;
        }
    }
}
$time = carbon_get_post_meta($args["forecast"]->ID, 'data');

$date = new DateTime($time);
$date = $date->setTimezone(new DateTimeZone($args["timezone"]));

$teams = get_forecast_teams($args["forecast"]->ID,["w"=>50,"h"=>50]);

$aw_system_location = aw_select_country(["country_code"=>$args["country_code"]]);

$bookmaker = [];

//SI EL PAIS ESTÁ CONFIGURADO

if(isset($aw_system_location)):
    $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true,"on_page"=>true]);
    if($bookmaker["name"] == "no bookmaker"){
        $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true]);
    }
    $bookmaker["logo_2x1"] = aq_resize($bookmaker["logo_2x1"],80,25,true,true,true);
    if (!$bookmaker["logo_2x1"]) { $bookmaker["logo_2x1"] = get_template_directory_uri() . '/assets/img/logo2.svg'; }
endif;


$html_predictions = '';

if(!empty($predictions)):
    $prediction['title'] = isset($predictions[0]) ? $predictions[0]['title'] : '';
    $prediction['cuote'] = isset($predictions[0]) ? $predictions[0]['cuote'] : 1;

    $oOddsConverter = new Converter($prediction['cuote'], 'eu');
    $odds_result = $oOddsConverter->doConverting();
    if(is_array($odds_result)):
        $prediction['cuote'] = isset($odds_result[$args["odds"]]) ? $odds_result[$args["odds"]] : 0;
    endif;

    $html_predictions = "<div class='row mt-2'>
                            <div class='col-12 p-1'><p class='text-secondary'>Pronóstico:</p></div>
                            <b class='col-6 p-1'>{$prediction['title']}</b>
                            <span class='col-6 text-right'><b class='oddsbox'>{$prediction['cuote']}</b></span>
                            </div>";
    
endif;
$html_bk = "";
if($bookmaker["name"] !== "no bookmaker"):
    $html_bk = "<div class='row p-1'>
                                <p class='col-2 p-0 text-secondary'>Bonus:</p>
                                <strong class='col-10 text-right'>{$bookmaker['bonus_slogan']}</strong>
                            </div>";
    $html_bk .= "<div class='row mt-3'>
                                <div class='col-6 text-right' >
                                    <a href='{$bookmaker['ref_link']}' title='Apuesta con {$bookmaker['name']}' class='btn' style='background:black;min-height:42px;max-height42px;overflow:hidden;'>
                                        <img src='{$bookmaker["logo_2x1"]}' width='80' height='25' style='object-fit:contain;' alt='logo casa de apuesta' >
                                    </a>
                                </div>
                                <div class='col-6 text-start'>
                                    <a href='{$bookmaker['ref_link']}' title='Apuesta con {$bookmaker['name']}' class='p-2 btn btn-primary font-weight-bold' rel='nofollow noopener noreferrer' target='_blank'>Juega ahora</a>
                                </div>
                            </div>";
endif;
$time_format_html = "<p class='text-light' >".$date->format('g:i a')."</p>";
  if(isset($params['time_format']) && $params['time_format']  == 'count'):
    $time_format_html = "<div class='date_item_pronostico_top'>
                            <input type='hidden' id='date' value='".$date->format('Y-m-d G:i:s')."' />
                            <b id='date_horas'></b>h:<b id='date_minutos'></b>:<b id='date_segundos'></b>
                        </div>";
endif;  



    $tvalue = isset($predictions[0]) ? $predictions[0]['tvalue'] : null;
    $estrellas = "";
    if(isset($tvalue)):
        for($i=1; $i<=5;$i++):
            $estrellas .=  '<span style="font-size:25px;" class="'.($i <= intval($tvalue) ? "text-warning" : "").' px-1 py-2 align-text-bottom" >★</span>';
        endfor;
    endif;

    
    
    $html_free =  "<article class='col-12 col-md-6 mb-1 fmodel-3'>
                
                <div class='border rounded'>
                   
                        <header class='event2_top_box_wrapper text-center py-2 px-2 rounded'>
                            <div class='row mx-auto align-items-center justify-content-center'>
                                <div class='col-3 p-0'>
                                    <img src='{$teams['team1']['logo']}' width='60' height='60' alt='{$teams['team1']['name']}' title='{$teams['team1']['name']}' class='bg-light rounded-circle p-1'>
                                </div>
                                <div class='col-6 p-0' style='line-height:1;'>
                                    <b class='text-light d-block text-center'>". strtoupper($sport['name']) ."</b>
                                        $time_format_html                                   
                                   <time class='text-light text-center d-block' datetime='".$date->format('Y-m-d H:i:s')."'>".date_i18n('D, d M Y', strtotime($date->format('Y-m-d')))."</time>                                
                                </div>
                                <div class='col-3 p-0'>
                                    <img src='{$teams['team2']['logo']}' width='60' height='60' alt='{$teams['team2']['name']}' title='{$teams['team2']['name']}' class='bg-light rounded-circle p-1' >
                                </div>
                                <div class='col-12'>
                                    <a href='$permalink' class='text-light' title='Leer mas sobre {$teams['team1']['name']} vs {$teams['team2']['name']}'>                               
                                    {$teams['team1']['name']} vs {$teams['team2']['name']}                              
                                    </a>
                                </div>
                            </div>
                        </header>
                    
                        <div class='event2_box_middle_content'>
                            <div class='w-100 text-center'>$estrellas</div>
                            
                            {$html_predictions}
                            {$html_bk}
                        </div>
                   </div>
            </article>";
            
                

    
        echo $html_free;
    
