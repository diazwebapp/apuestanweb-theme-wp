<?php

$params = get_query_var('params');
$teams = get_forecast_teams($args["forecast"]->ID,["w"=>50,"h"=>50]);

$aw_system_location = aw_select_country(["country_code"=>$args["country_code"]]);

$bookmaker = [];

if(isset($aw_system_location)):
    $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true,"on_page"=>true]);
    if($bookmaker["name"] == "no bookmaker"){
        $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true]);
    }
    $bookmaker["logo"] = aq_resize($bookmaker["logo"],50,50,true,true,true);
    if (!$bookmaker["logo"]) { $bookmaker["logo"] = get_template_directory_uri() . '/assets/img/logo2.svg'; }
endif;

$permalink = get_the_permalink($args["forecast"]->ID);
$predictions = carbon_get_post_meta($args["forecast"]->ID, 'predictions');
$sport_term = wp_get_post_terms($args["forecast"]->ID, 'league', array('fields' => 'all'));
$prediction['title'] = isset($predictions[0]) ? $predictions[0]['title']: '';
$prediction['cuote'] = isset($predictions[0]) ? $predictions[0]['cuote']: 0;
$time = carbon_get_post_meta($args["forecast"]->ID, 'data');
$date = new DateTime($time);
$date = $date->setTimezone(new DateTimeZone($args["timezone"]));


$oOddsConverter = new Converter($prediction['cuote'], 'eu');
$odds_result = $oOddsConverter->doConverting();
$prediction['cuote'] = isset($odds_result[$args["odds"]]) ? $odds_result[$args["odds"]] : 0;
$vipcomponent = '';
if(isset($bookmaker["name"]) && $bookmaker["name"] !== "no bookmaker"):
$vipcomponent ="
                <img loading='lazy' width='50' height='50' src='{$bookmaker['logo']}' class='bg-secondary p-2' alt='{$bookmaker['name']}'>
                
                <a href='$permalink' title='Apuesta con {$bookmaker['name']}' class='text-light text-capitalize' >{$prediction['title']}</a>
                
                <span class='mr-1 oddsbox'>{$prediction['cuote']}</span>
                "
                ;
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
  if(isset($params['time_format']) && $params['time_format']  == 'count'):
    $time_format_html = "<div class='date_item_pronostico_top'>
                            <input type='hidden' id='date' value='".$date->format('Y-m-d G:i:s')."' />
                            <b id='date_horas'></b>h:<b id='date_minutos'></b>:<b id='date_segundos'></b>
                        </div>";
endif;
echo "<article class='border rounded p-3'>
            <header class='d-flex align-items-center justify-content-between'>
                <p class='game_name {$sport['class']}'>{$sport['name']}</p>
                <p>
                    <time datetime='".$date->format('Y-m-d h:i')."' >".$date->format('d M')."/".$date->format('g:i a')."</time>
                    
                </p>
            </header> 

            <div class='d-flex align-items-center justify-content-between my-3'>
                <div class='media align-items-center'>
                    <img loading='lazy' width='50' height='50' src='{$teams['team1']['logo']}' alt='{$teams['team1']['name']}'>
                </div> 
                <div>
                    <p class='small font-weight-bold'>{$teams['team1']['acronimo']} vs {$teams['team2']['name']}</p> 
                </div>                               
                <div class='media align-items-center'>
                    <img loading='lazy' width='50' height='50' src='{$teams['team2']['logo']}' alt='{$teams['team2']['name']}'>
                </div>
            </div>
            <div class='bg-primary rounded-right d-flex justify-content-between align-items-center'>
                {$vipcomponent}
            </div>
</article>";