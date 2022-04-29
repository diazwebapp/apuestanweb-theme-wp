<?php
$params = get_query_var('params');
$teams = get_forecast_teams(get_the_ID(),["w"=>50,"h"=>50]);
$bookmaker = get_bookmaker_by_post(get_the_ID(),["w"=>79,"h"=>18]);
$vip = carbon_get_post_meta(get_the_ID(), 'vip');
$permalink = get_the_permalink(get_the_ID());
$predictions = carbon_get_post_meta(get_the_ID(), 'predictions');
$sport_term = wp_get_post_terms(get_the_ID(), 'league', array('fields' => 'all'));
$prediction['title'] = isset($predictions[0]) ? $predictions[0]['title']: '';
$prediction['cuote'] = isset($predictions[0]) ? $predictions[0]['cuote']: 0;
$time = carbon_get_post_meta(get_the_ID(), 'data');
$geolocation = json_decode(GEOLOCATION);
$date = new DateTime($time);
if($geolocation->success !== false):
    $date = $date->setTimezone(new DateTimeZone($geolocation->timezone));
endif;
//Componente si es vip

$vipcomponent ="<div class='plogo'>
                    <img src='{$bookmaker['logo']}' class='img-fluid' alt='{$bookmaker['name']}'>
                </div>
                    <a href='{$params['vip_link']}'><p>{$params['text_vip_link']}</p></a>
                <div class='rate'>?</div>";
if(!$vip):
    $oOddsConverter = new Converter($prediction['cuote'], 'eu');
    $odds_result = $oOddsConverter->doConverting();
    $prediction['cuote'] = $odds_result[$_SESSION['odds_format']];
    $vipcomponent ="<div class='plogo'>
                        <img src='{$bookmaker['logo']}' class='img-fluid' alt='{$bookmaker['name']}'>
                    </div>
                        <a href='$permalink'><p>{$prediction['title']}</p></a>
                    <div class='rate'>{$prediction['cuote']}</div>";
endif;
//leagues
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
$time_format_html = "<p class='p2'><span>".$date->format('g:i a')."</span></p>";
if($params['time_format']  == 'count'):
    $time_format_html = "<div class='date_item_pronostico_top'>
                            <input type='hidden' id='date' value='".$date->format('Y-m-d h:i:s')."' />
                            <b id='date_horas'></b>h:<b id='date_minutos'></b>:<b id='date_segundos'></b>
                        </div>";
endif;
echo "<div class='prediction_box'>
            <div class='d-flex align-items-center justify-content-between'>
                <p class='game_name {$sport['class']}'>{$sport['name']}</p>
                <p>
                    <time datetime='".$date->format('Y-m-d h:i')."' >".$date->format('d M')."/".$date->format('g:i a')."</time>
                    
                </p>
            </div> 

            <div class='d-flex align-items-center justify-content-between mt_15'>
                <div class='media align-items-center'>
                    <img src='{$teams['team1']['logo']}' class='mr_45' alt='{$teams['team1']['name']}'>
                </div> 
                <div>
                    <p style='margin:0 5px;'>{$teams['team1']['acronimo']} vs {$teams['team2']['name']}</p> 
                </div>                               
                <div class='media align-items-center'>
                    <img src='{$teams['team2']['logo']}' class='ml_45' alt='{$teams['team2']['name']}'>
                </div>
            </div>
            <div class='rate_box'>
                {$vipcomponent}
            </div>
</div>";