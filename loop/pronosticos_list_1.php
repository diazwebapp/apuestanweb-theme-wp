<?php

$geolocation = json_decode($_SESSION["geolocation"]);
$image_att = carbon_get_post_meta($args["forecast"]->ID, 'img');
$image_png = wp_get_attachment_url($image_att);
$prediction = carbon_get_post_meta($args["forecast"]->ID, 'prediction');
$permalink = get_the_permalink($args["forecast"]->ID);

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

$teams = get_forecast_teams($args["forecast"]->ID);


if ($teams['team1'] && $teams['team2']){  
    
    $new_html='<a href="'.$permalink.'" >
    <div class="row border rounded align-items-center mb-2 py-2 px-1  mx-1 text-center">
            <div class="col-3 d-none d-md-block">
                <b class="text-dark">'.$sport['name'].'</b>
            </div>
            <div class="col-1 p-0">
                <img width="36" height="36" src="'.$teams['team1']['logo'].'" alt="'.$teams['team1']['name'].'">
            </div>
            <div class="col-4 text-truncate">
                <h3 style="font-size:.9rem !important;" class="d-none d-md-block">'.$teams['team1']['name'].' vs '.$teams['team2']['name'].'</h3>

            <h3 style="font-size:.9rem !important;" class="d-md-none"><p>'.$teams['team1']['acronimo'] .' vs '. $teams['team2']['acronimo'].'</p></h3></div>
             
            <div class="col-1 p-0">
                <img width="36" height="36" src="'.$teams['team2']['logo'].'" alt="'.$teams['team2']['name'].'">
            </div>
            
 
            <div class="col-6 col-md-3 date_item_pronostico_top">  
                
                <input type="hidden" id="date" value="'.$date->format('Y-m-d G:i:s').'" />
                <b id="date_dias"></b>
                <b id="date_horas"></b>
                <b id="date_minutos"></b>
                <b id="date_segundos"></b>
            
            </div>
    </div>
    </a>';
    echo $new_html;
} 