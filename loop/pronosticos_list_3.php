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

    $html_predictions = "<div class='row'>
                            <b class='col-6 p-1'>{$prediction['title']}</b>
                            <span class='col-6 text-start'><b class='p-1' style='border-radius: .3rem;color:#0558cb;background-color:#ddeafd;font-size: .8rem;font-weight: 700;'>{$prediction['cuote']}</b></span>
                            </div>";
endif;
$time_format_html = "<p>".$date->format('g:i a')."</p>";
if($params['time_format']  == 'count'):
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

    
    
    $html_free =  "<div class='col-md-6 mt-5'>
                
                <div class='event2_box'>
                   
                        <div class='event2_top_box_wrapper'>
                            <div class='event2_top_box'>
                                <div class='event_top_left'>
                                    <img src='{$teams['team1']['logo']}' width='36' height='36' alt='{$teams['team1']['name']}' title='{$teams['team1']['name']}' class='img-fluid'>
                                </div>
                                <div class='event_top_middle'>
                                    <p class='p1 {$sport['class']}'><b>". strtoupper($sport['name']) ."</b></p>
                                        $time_format_html                                   
                                    <p class='p2'><time datetime='".$date->format('Y-m-d H:i:s')."'>".date_i18n('D, d M Y', strtotime($date->format('Y-m-d')))."</time></p>                                    
                                </div>
                                <div class='event_top_right'>
                                    <img src='{$teams['team2']['logo']}' width='36' height='36' alt='{$teams['team2']['name']}' title='{$teams['team2']['name']}' class='img-fluid' >
                                </div>
                            </div>
                            <div class='text-center'>
                                <span><a href='$permalink'>                               
                                {$teams['team1']['name']} vs {$teams['team2']['name']}                              
                                </a></span>
                            </div>
                        </div>
                    
                        <div class='event2_box_middle_content'>
                            <div class='w-100'>$estrellas</div>
                            <p >Pronóstico:</p>
                            {$html_predictions}
                            <div class='row'>
                                <p class='col-4'>Bonus:</p>
                                <strong class='col-8'>{$bookmaker['bonus_slogan']}</strong>
                            </div>
                            <div class='row'>
                                <div class='col-6 text-right'>
                                    <a href='{$bookmaker['ref_link']}' class='btn' style='background:black;min-height:42px;max-height42px;overflow:hidden;'>
                                        <img src='{$bookmaker['logo']}' width='80' height='30' style='object-fit:contain;' alt='logo casa de apuesta' >
                                    </a>
                                </div>
                                <div class='col-6 text-start'>
                                    <a href='{$bookmaker['ref_link']}' class='p-2 btn btn-primary font-weight-bold' rel='nofollow noopener noreferrer' target='_blank'>Juega ahora</a>
                                </div>
                            </div>
                        </div>
                   </div>
            </div>";
            
                

    
        echo $html_free;
    
