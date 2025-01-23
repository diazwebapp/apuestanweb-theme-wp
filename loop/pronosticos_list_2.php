<?php

$params = get_query_var('params');
$image_att = carbon_get_post_meta($args["forecast"]->ID, 'img');
$image_png = wp_get_attachment_url($image_att);
$prediction = carbon_get_post_meta($args["forecast"]->ID, 'prediction');
$status = carbon_get_post_meta($args["forecast"]->ID, 'status');
$vip = carbon_get_post_meta($args["forecast"]->ID, 'vip');
$permalink = get_the_permalink($args["forecast"]->ID);
$sport_term = wp_get_post_terms($args["forecast"]->ID, 'league', array('fields' => 'all'));
$teams = get_forecast_teams($args["forecast"]->ID,["w"=>50,"h"=>50]);
$time = carbon_get_post_meta($args["forecast"]->ID, 'data');
$formatted_date = __(wp_date('j M', strtotime($time)), 'jbetting');
$small_logo = get_template_directory_uri() . '/assets/img/logo2.svg';

$aw_system_location = aw_select_country(["country_code"=>$args["country_code"]]);

$bookmaker = [];
//SI EL PAIS ESTÁ CONFIGURADO
if(isset($aw_system_location)):
    $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true,"on_page"=>true]);
    if($bookmaker["name"] == "no bookmaker"){
        $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true]);
    }
    $bookmaker["logo_2x1"] = aq_resize($bookmaker["logo_2x1"],80,25,true,true,true);
    if (!$bookmaker["logo_2x1"]) { $bookmaker["logo_2x1"] = $small_logo; }
endif;
$date = new DateTime($time);
$date = $date->setTimezone(new DateTimeZone($args["timezone"]));


$vipcomponent ="<a href='{$bookmaker['ref_link']}' class='game_btn border mt-2 p-1'>
                        <img src='{$bookmaker['logo_2x1']}' width='80' height='25' alt='{$bookmaker['name']}' style='background:{$bookmaker['background_color']}'>
                        <p class='text-secondary'>Haz una apuesta</p>
                    </a>";
//Liga y deporte
//taxonomy league
$tax_leagues = wp_get_post_terms($args["forecast"]->ID,'league');  

//forecast sport
$sport = false;
if(isset($tax_leagues) and count($tax_leagues) > 0):
    foreach($tax_leagues as $tax_league):
        if($tax_league->parent == 0):
            $sport = $tax_league; //define forecast sport
            $icon_class = carbon_get_term_meta($sport->term_id,'fa_icon_class');
            $sport->icon_html = !empty($icon_class) ? '<i class="'.$icon_class.'" ></i>' : '<img  width="20" height="20" class="img-fluid" loading="lazy" src="'.$small_logo.'" alt="'.$sport->name.'"/>';
        endif;
    endforeach;
endif;

//forecast League
$league = false;

if(isset($sport)):
    $leagues = [];
    foreach($tax_leagues as $tax_league):
        if($tax_league->parent == $sport->term_id):
            $leagues[] = $tax_league;
        endif;
    endforeach;
    if(isset($leagues) and count($leagues) > 0):
        $league = $leagues[0]; //define forecast sport
        $icon_class = carbon_get_term_meta($league->term_id,'fa_icon_class');
        
        $league->icon_html =  '<img width="20" height="20" class="img-fluid" loading="lazy" src="'.$small_logo.'" alt="'.$league->name.'" />';
    endif;
endif;

$time_format_html = "<p>".$date->format('g:i a')."</p>";
if($params['time_format']  == 'count'):
    $time_format_html = "<div class='date_item_pronostico_top'>
                            <input type='hidden' id='date' value='".$date->format('Y-m-d G:i:s')."' />
                            <b id='date_horas'></b>h:<b id='date_minutos'></b>:<b id='date_segundos'></b>
                        </div>";
endif; 

    echo "<div class='col-sm-6 col-md-4 mb-2 p-sm-1'>
        
             <div class='game_box py-3 px-sm-1'>
                <div class='game_top'>
                    <div class='d-flex align-items-center text-dark'>
                        ".(isset($league->icon_html) ? $league->icon_html:'')." 
                        ".(isset($league->name) ? $league->name:'')."
                    </div>
                    <div class='d-flex align-items-center text-dark'>
                        ".(isset($sport->icon_html) ? $sport->icon_html : '')." 
                    </div>
                </div>
                <a href='$permalink'  >
                <div class='d-flex align-items-center justify-content-between text-center my-3'>
                    <img width='40px' height='40px' loading='lazy' src='{$teams['team1']['logo']}' alt='{$teams['team1']['name']}'>
                    <div class='full-date text-dark'>
                        $time_format_html
                        <time class='text-dark' datetime='".$date->format('Y-m-d H:i:s')."'>".$formatted_date."</time>
                    </div>
                    <img width='40px' height='40px' loading='lazy' src='{$teams['team2']['logo']}' alt='{$teams['team2']['name']}'>
                </div>
                <p class='team_text text-dark'>{$teams['team1']['name'] } - {$teams['team2']['name']}</p>
            </a>
                {$vipcomponent}
            </div>
    </div>"; 

