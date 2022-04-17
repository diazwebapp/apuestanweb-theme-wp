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
".$date->format('d M')." = date('d M', strtotime($time));
$hora = date('g:i a', strtotime($time));
//Componente si es vip

$vipcomponent ="<div class='plogo'>
                    <img src='{$bookmaker['logo']}' class='img-fluid' alt='{$bookmaker['name']}'>
                </div>
                    <a href='{$params['vip_link']}'><p>{$params['text_vip_link']}</p></a>
                <div class='rate'>?</div>";
if(!$vip)
    $vipcomponent ="<div class='plogo'>
                        <img src='{$bookmaker['logo']}' class='img-fluid' alt='{$bookmaker['name']}'>
                    </div>
                        <a href='$permalink'><p>{$prediction['title']}</p></a>
                    <div class='rate'>{$prediction['cuote']}</div>";
//leagues
$sport['name'] = '';
$sport['logo'] = get_template_directory_uri() . '/assets/img/logo2.svg';
if ($sport_term) {
    foreach ( $sport_term as $item ) {
        if($item->parent == 0){
            $sport_logo = wp_get_attachment_url(carbon_get_term_meta($item->term_id, 'mini_img'));
            if($sport_logo)
                $sport['logo'] = $sport_logo;
            $sport['name'] = $item->name;
        }
    }
}
echo "<div class='prediction_box'>
            <div class='d-flex align-items-center justify-content-between'>
                <p class='game_name'><img src='{$sport['logo']}' alt='{$sport['name']}'>{$sport['name']}</p>
                <p>
                    <span class='time'>$hora</span>
                    <span class='date'>".$date->format('d M')."</span>
                </p>
            </div> 

            <div class='d-flex align-items-center justify-content-between mt_15'>
                <div class='media align-items-center'>
                    <img src='{$teams['team1']['logo']}' class='mr_45' alt='{$teams['team1']['name']}'>
                    <p class='media-body text-uppercase'>{$teams['team1']['name']}</p>
                </div>                                
                <div class='media align-items-center'>
                    <p class='media-body text-uppercase'>{$teams['team2']['name']}</p>
                    <img src='{$teams['team2']['logo']}' class='ml_45' alt='{$teams['team2']['name']}'>
                </div>
            </div>
            <div class='rate_box'>
                {$vipcomponent}
            </div>
</div>";