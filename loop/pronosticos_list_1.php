<?php
$image_att = carbon_get_post_meta(get_the_ID(), 'img');
$image_png = wp_get_attachment_url($image_att);
$prediction = carbon_get_post_meta(get_the_ID(), 'prediction');
$permalink = get_the_permalink();

$sport_term = wp_get_post_terms(get_the_ID(), 'league', array('fields' => 'all'));

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
$time = carbon_get_post_meta(get_the_ID(), 'data');
$geolocation = json_decode(GEOLOCATION);
$date = new DateTime($time);
if($geolocation->success !== false):
    $date = $date->setTimezone(new DateTimeZone($geolocation->timezone));
endif;
$teams = get_forecast_teams(get_the_ID(),["w"=>50,"h"=>50]);

if ($teams['team1']['logo'] && $teams['team2']['logo']){  
    $content = get_the_content(get_the_ID()) ;
    echo "<a href='$permalink' >
        <div class='event'>
            <p class='league_box1'>
                <i class='{$sport['class']}'></i>
                <b>{$sport['name']}</b>
            </p>
            <div class='img_logo'>
                <img src='{$teams['team1']['logo']}' alt='{$teams['team1']['name']}'>
            </div>
            <p class='d-none d-lg-flex'>
                <span>{$teams['team1']['name']} vs {$teams['team2']['name']}</span>

            </p>
            <div class='d-lg-none d-block'>
                <div class='match_time_box league_box1'>
                        <i class='{$sport['class']}'></i>
                    <p class='date_item_pronostico_top'>
                        <input type='hidden' id='date' value='".$date->format('Y-m-d h:i:s')."' />
                        <b id='date_horas'></b>h:<b id='date_minutos'></b>:<b id='date_segundos'></b>
                    </p>
                </div>
            </div>
            <div class='img_logo'>
                <img src='{$teams['team2']['logo']}' alt='{$teams['team2']['name']}'>
            </div>
            <p class='date_item_pronostico_top'>
                <input id='date' value='".$date->format('Y-m-d h:i:s')."' />
                <b id='date_horas'></b>h:<b id='date_minutos'></b>:<b id='date_segundos'></b>
            </p>
    </div></a> ";
    
} 