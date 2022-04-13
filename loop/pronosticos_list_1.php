<?php
$image_att = carbon_get_post_meta(get_the_ID(), 'img');
$image_png = wp_get_attachment_url($image_att);
$time = carbon_get_post_meta(get_the_ID(), 'data');
$prediction = carbon_get_post_meta(get_the_ID(), 'prediction');
$permalink = get_the_permalink();
if ($time) {
    $new_format_time = date('d.m.Y H:s', strtotime($time));
} else {
    $new_format_time = 'n/a';
}
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
$teams = get_forecast_teams(get_the_ID(),["w"=>50,"h"=>50]);

if ($teams['team1']['logo'] && $teams['team2']['logo']){  
    $fecha = date('d M', strtotime($time)) .' - '. date('g:i a', strtotime($time));
    $hora = date('g:i a', strtotime($time));
    $content = get_the_content(get_the_ID()) ;
    echo "<a href='$permalink' ><div class='event'>
            <p class='{$sport['class']}'>{$sport['name']}</p>
            <div class='img_logo'>
                <img src='{$teams['team1']['logo']}' alt='{$teams['team1']['name']}'>
            </div>
            <p class='d-none d-lg-flex'>
                <span>{$teams['team1']['name']}</span>
                <span>Vs</span>
                <span>{$teams['team2']['name']}</span>
            </p>
            <div class='d-lg-none d-block'>
                <div class='match_time_box'>
                    <p class='{$sport['class']}'>{$sport['name']}</p>
                    <p>$hora</p>
                </div>
            </div>
            <div class='img_logo'>
                <img src='{$teams['team2']['logo']}' alt='{$teams['team2']['name']}'>
            </div>
            <p>$hora</p>       
            
    </div></a> ";
    
} 