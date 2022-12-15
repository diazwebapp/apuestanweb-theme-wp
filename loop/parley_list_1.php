<?php

///Buscamos el pais en la base de datos
$aw_system_location = aw_select_country(["country_code"=>$args["country_code"]]);
$params = get_query_var('params');
$vip = carbon_get_post_meta(get_the_ID(), 'vip');
$permalink = get_the_permalink(get_the_ID());
$content = get_the_content(get_the_ID());
$time = carbon_get_post_meta(get_the_ID(), 'data');
$fecha = date('D M', strtotime($time));
$hora = date('g:i a', strtotime($time));
$forecasts = carbon_get_post_meta(get_the_ID(), 'forecasts');

$bookmaker = json_encode([]);
//SI EL PAIS ESTÁ CONFIGURADO
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

$parley_id = get_the_ID();
$alt_logo = get_template_directory_uri() . '/assets/img/logo2.svg';
echo "<div class='parley_wrapper'>
<div class='parley_top_content'>
    <h2>Parley $fecha</h2>
    <img src='$alt_logo' class='img-fluid' alt=''>
</div>";
    if($forecasts and count($forecasts) > 0){
        $parley_cuotes = 1;
        foreach ($forecasts as $event) {
            $predictions = carbon_get_post_meta($event['id'], 'predictions');
            $prediction = [];
            $permalink_event = get_the_permalink($event['id']);
            $prediction['title'] = isset($predictions[0]) ? $predictions[0]['title']: '';
            $prediction['cuote'] = isset($predictions[0]) ? $predictions[0]['cuote']: 1;
            $parley_cuotes = $parley_cuotes * $prediction['cuote'];
            $oOddsConverter = new Converter($prediction['cuote'], 'eu');
            $odds_result = $oOddsConverter->doConverting();
            
            $prediction['cuote'] = $odds_result[$args["odds"]];
            
            $teams = get_forecast_teams($event['id'],["w"=>24,"h"=>24]);
            $time = carbon_get_post_meta($event['id'], 'data');
            $fecha =  date('d M', strtotime($time));
            $hora =  date('g:i a', strtotime($time));

            $sport_term = wp_get_post_terms($event['id'], 'league', array('fields' => 'all'));

            $sport['name'] = '';
            $sport['logo'] = get_template_directory_uri() . '/assets/img/logo2.svg';

            if ($sport_term) {
                foreach ( $sport_term as $item ) {
                    if($item->parent == 0){
                        $sport_logo = wp_get_attachment_url(carbon_get_term_meta($item->term_id, 'logo'));
                        if($sport_logo)
                            $sport['logo'] = $sport_logo;
                        $sport['name'] = $item->name;
                    }
                }
            }

            echo "<div class='parley_box mx-2'>
                <div class='parley_left_content'>
                    <div class='parley_game_name_wrapper'>
                        <div class='parley_game_name'>
                            <div class='category-grid'>
                                <span>{$sport['name']}</span>
                            </div>
                        
                            <div class='d-lg-block d-none'>
                                <time>$fecha, $hora</time>
                            </div>
                        </div>
                        <div class='d-lg-none d-block'>
                            <div class='mobile_parley_time'>
                                <p>$fecha, $hora</p>
                            </div>
                        </div>
                    </div>                  
                    <div class='parley_match_time'>
                        <div class='parley_flag'>
                            <div class='parley_team'>
                                <img src='{$teams['team1']['logo']}' class='img-fluid' alt=''>
                                <p>{$teams['team1']['name']}</p>
                            </div>
                            <div class='parley_team parley_team2'>
                                <img src='{$teams['team2']['logo']}' class='img-fluid' alt=''>
                                <p class='p2'>{$teams['team2']['name']}</p>
                             </div>
                        </div>
                        <div class=''>
                            <div class='d-lg-none d-block'>
                                <div class='parley_right_first'>
                                    <p class='p1'>{$prediction['title']}</p>
                                    <p class='p2'>{$prediction['cuote']}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='parley_right_content'>
                    <div class='d-lg-block d-none'>
                        <div class='parley_right_first'>
                            <p class='p1'>{$prediction['title']}</p>
                            <p class='p2'>{$prediction['cuote']}</p>
                        </div>
                    </div>
                </div>
                <div class='event-link'>
                    <a href='$permalink_event'>
                        Ver análisis
                    </a>
                </div>  
                </div>";
            echo "<div class='parley_collpase_content'>
            <div id='one{$event['id']}' class='collapse' >
                <div class='parley_collapse_wrapper'>
                    <div class='parley_collapse'>
                        $content
                    </div>
                </div>
            </div>

        </div>";
        }
    }
    echo "<div class='parley_box2'>
                <div class='parley_left_content2 d-md-block d-none'>
                    <img width='90' height='30' style='object-fit:contain;' src='{$bookmaker["logo_2x1"]}' class='img-fluid' alt=''>
                </div>
                <div class='parley_right_content2'>

                    <div class='blog_select_box parley_right_content2_mb'>
                        <select class='form-select' onchange='parley_calc_cuotes(this)' name='apu' id='apu' data='$parley_id' >
                            <option value='10'>Apuesta $10</option>
                            <option value='15'>Apuesta $15</option>
                            <option value='20'>Apuesta $20</option>
                            <option value='50'>Apuesta $50</option>
                        </select>
                        
                    </div>
                    <div class='gana_box parley_right_content2_mb'>
                    <input type='hidden' id='jscuote_$parley_id' value='$parley_cuotes'/>
                       <p>Gana: $ <span id='jsresult_$parley_id' >". round($parley_cuotes * 10,2) ."</span></p>
                    </div>
                    <div class='parley_left_content2 parley_right_content2_mb d-md-none d-block'>
                    <img width='90' height='30' style='object-fit:contain;' src='{$bookmaker["logo_2x1"]}' class='img-fluid' alt=''>
                    </div>
                    <div class='parley_btn_2 parley_right_content2_mb'> 
                        <a href='{$bookmaker['ref_link']}' class='button' rel='nofollow noopener noreferrer' target='_blank' >Apostar ahora</a>
                    </div>      
                </div>
            </div>";
echo "</div>";
