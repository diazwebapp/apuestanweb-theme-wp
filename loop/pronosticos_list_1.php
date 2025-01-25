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
    
    $new_html='
    <article>
        <a href="'.$permalink.'" class="row border rounded align-items-center py-2 mx-1 mb-2 text-center">
            
            <div class="d-none d-sm-block col-sm-2 col-md-1">
                <b class="text-dark">'.$sport['name'].'</b>
            </div>
            <div class="col-3 col-sm-1">
                <img width="36" height="36" src="'.$teams['team1']['logo'].'" alt="'.$teams['team1']['name'].'">
            </div>
            <div class="col-6 col-sm-4 col-md-6 text-truncate">
                <h5 style="font-size:1.1rem !important;" class="d-none d-md-block mb-0">'.$teams['team1']['name'].' vs '.$teams['team2']['name'].'</h5>

                <h5 style="font-size:1.1rem !important;" class="d-md-none mb-0">'.$teams['team1']['acronimo'] .' vs '. $teams['team2']['acronimo'].'</h5>
            </div>
            <div class="col-3 col-sm-1">
                <img width="36" height="36" src="'.$teams['team2']['logo'].'" alt="'.$teams['team2']['name'].'">
            </div>
            

            <div class="col-12 col-sm-4 col-md-3 date_item_pronostico_top">  
                
                <input type="hidden" id="date" value="'.$date->format('Y-m-d G:i:s').'" />
                <b id="date_dias"></b>
                <b id="date_horas"></b>
                <b id="date_minutos"></b>
                <b id="date_segundos"></b>
            
            </div>
           
        </a>
    </article>
    ';
    echo $new_html;
} 