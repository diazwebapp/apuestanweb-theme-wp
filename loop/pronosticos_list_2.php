<?php
$geolocation = isset($_SESSION["geolocation"]) ? json_decode($_SESSION["geolocation"]) : json_decode(GEOLOCATION);;
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

$aw_system_location = aw_select_country(["country_code"=>$geolocation->country_code]);

$bookmaker = json_encode([]);
//SI EL PAIS ESTÁ CONFIGURADO

echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
if(isset($aw_system_location)):
    //SI EL SHORTCODE ES USADO EN UNA PAGINA
    if(is_page()){
        $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true,"on_page"=>true]);
        if($bookmaker["name"] == "no bookmaker"){
            $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true]);
        }
    }
    //SI EL SHORTCODE NÓ ES USADO EN UNA PAGINA
    if(!is_page()){
        $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true]);
    }
endif;
if(!isset($aw_system_location)):
    $bookmaker = aw_select_relate_bookmakers(1, ["unique"=>true,"random"=>true]);
endif;
$date = new DateTime($time);
$date = $date->setTimezone(new DateTimeZone($geolocation->timezone));

//Componente si es vip
$vipcomponent ="<a href='{$params['vip_link']}' class='game_btn v2'>
                    <i class='fa fa-lock'></i>
                    <p>{$params['text_vip_link']}</p>
                </a>";
if($vip !='yes')
    $vipcomponent ="<a href='{$bookmaker['ref_link']}' class='game_btn'>
                        <img src='{$bookmaker['logo']}' width='70' height='25' alt='{$bookmaker['name']}'>
                        <p>Haz una apuesta</p>
                    </a>";
//Liga y deporte
//taxonomy league
$tax_leagues = wp_get_post_terms($args["forecast"]->ID,'league');                            
$icon_img = get_template_directory_uri() . '/assets/img/logo2.svg';

//forecast sport
$sport = false;
if(isset($tax_leagues) and count($tax_leagues) > 0):
    foreach($tax_leagues as $tax_league):
        if($tax_league->parent == 0):
            $sport = $tax_league; //define forecast sport
            $icon_class = carbon_get_term_meta($sport->term_id,'fa_icon_class');
            $sport->icon_html = !empty($icon_class) ? '<i class="'.$icon_class.'" ></i>' : '<img loading="lazy" src="'.$icon_img.'" />';
        endif;
    endforeach;
endif;

//forecast League
$league = false;

if(isset($sport)):
    $leagues = get_terms( 'league', array( 'hide_empty' => true, 'parent' => $sport->term_id ) );
    if(isset($leagues) and count($leagues) > 0):
        $league = $leagues[0]; //define forecast sport
        $icon_class = carbon_get_term_meta($league->term_id,'fa_icon_class');
        $league->icon_html = !empty($icon_class) ? '<i class="'.$icon_class.'" ></i>' : '<img loading="lazy" src="'.$icon_img.'" />';
    endif;
endif;

$time_format_html = "<p><time datetime='".$date->format('h:i')."' >".$date->format('g:i a')."</time></p>";
if($params['time_format']  == 'count'):
    $time_format_html = "<div class='date_item_pronostico_top'>
                            <input type='hidden' id='date' value='".$date->format('Y-m-d h:i:s')."' />
                            <b id='date_horas'></b>h:<b id='date_minutos'></b>:<b id='date_segundos'></b>
                        </div>";
endif;
if ($teams['team1']['logo'] and $teams['team2']['logo']):
    
    echo "<div class='col-lg-4 col-md-6 mt_30'>
        
            <div class='game_box'>
                <div class='game_top'>
                    <div class='d-flex align-items-center league_box1'>
                        ".(isset($league->icon_html) ? $league->icon_html:'')." 
                        ".(isset($league->name) ? $league->name:'')."
                    </div>
                    <div class='d-flex align-items-center'>
                        ".(isset($sport->icon_html) ? $sport->icon_html : '')." 
                    </div>
                </div>
                <a href='$permalink'  >
                <div class='d-flex align-items-center club_box'>
                    <img width='24px' height='24px' loading='lazy' src='{$teams['team1']['logo']}' alt='{$teams['team1']['name']}'>
                    <div>
                        $time_format_html
                        <time datetime='".$date->format('Y-m-d')."'>".$date->format('d M')."</time>
                    </div>
                    <img width='24px' height='24px' loading='lazy' src='{$teams['team2']['logo']}' alt='{$teams['team2']['name']}'>
                </div>
                <p class='team_text'>{$teams['team1']['name'] } - {$teams['team2']['name']}</p>
            </a>
                {$vipcomponent}
            </div>
    </div>";
    
endif; ?>
