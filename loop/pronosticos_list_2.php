<?php
$params = get_query_var('params');
$image_att = carbon_get_post_meta(get_the_ID(), 'img');
$image_png = wp_get_attachment_url($image_att);
$time = carbon_get_post_meta(get_the_ID(), 'data');
$prediction = carbon_get_post_meta(get_the_ID(), 'prediction');
$status = carbon_get_post_meta(get_the_ID(), 'status');
$vip = carbon_get_post_meta(get_the_ID(), 'vip');
$permalink = get_the_permalink(get_the_ID());
$fecha = date('d M', strtotime($time));
$hora = date('g:i a', strtotime($time));
$sport_term = wp_get_post_terms(get_the_ID(), 'league', array('fields' => 'all'));
$teams = get_forecast_teams(get_the_ID(),["w"=>50,"h"=>50]);
$bookmaker = get_bookmaker_by_post(get_the_ID(),["w"=>79,"h"=>18]);
//Componente si es vip
$vipcomponent ="<a href='{$params['vip_link']}' class='game_btn v2'>
                    <p>{$params['text_vip_link']}</p>
                </a>";
if($vip !='yes')
    $vipcomponent ="<a href='{$bookmaker['ref_link']}' class='game_btn'>
                        <img src='{$bookmaker['logo']}' alt='{$bookmaker['name']}'>
                        <p>Haz una apuesta</p>
                    </a>";
//Liga y deporte
$sport['class'] = '' ;
$sport['name'] = '';
$league['class'] = '' ;
$league['name'] = '';
if ($sport_term) {
    foreach ( $sport_term as $item ) {
        if($item->parent == 0){
            $sport['class'] = carbon_get_term_meta($item->term_id, 'fa_icon_class');
            $sport['name'] = $item->name;
        }
        if($item->parent != 0){
            $league['class'] = carbon_get_term_meta($item->term_id, 'fa_icon_class');
            $league['name'] = $item->name;
        }
    }
}


$p1 = carbon_get_post_meta(get_the_ID(), 'p1');
if (!$p1) {
    $p1 = 'n/a';
}
$x = carbon_get_post_meta(get_the_ID(), 'x');
if (!$x) {
    $x = 'n/a';
}
$p2 = carbon_get_post_meta(get_the_ID(), 'p2');
if (!$p2) {
    $p2 = 'n/a';
}

if ($teams['team1']['logo'] and $teams['team2']['logo']):
    
    echo "<div class='col-lg-4 col-md-6 mt_30'>
        
            <div class='game_box'>
                <div class='game_top'>
                    <div class='d-flex align-items-center'>
                        <span class='{$league['class']}' ><b>{$league['name']}</b></span>  
                    </div>
                    <div class='d-flex align-items-center'>
                      <span class='{$sport['class']}' ><b>{$sport['name']}</b></span>  
                    </div>
                </div>
                <a href='$permalink'  >
                <div class='d-flex align-items-center club_box'>
                    <img width='24px' height='24px' loading='lazy' src='{$teams['team1']['logo']}' alt='{$teams['team1']['name']}'>
                    <div>
                        <p><strong>$hora</strong></p>
                        <p>$fecha</p>
                    </div>
                    <img width='24px' height='24px' loading='lazy' src='{$teams['team2']['logo']}' alt='{$teams['team2']['name']}'>
                </div>
                <p class='team_text'>{$teams['team1']['name'] }- {$teams['team2']['name']}</p>
            </a>
                {$vipcomponent}
            </div>
    </div>";
endif; ?>