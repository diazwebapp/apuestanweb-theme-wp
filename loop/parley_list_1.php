<?php

$params = get_query_var('params');
$bookmaker = get_bookmaker_by_country();
$vip = carbon_get_post_meta(get_the_ID(), 'vip');
$permalink = get_the_permalink(get_the_ID());
$content = get_the_content(get_the_ID());
$time = carbon_get_post_meta(get_the_ID(), 'data');
$fecha = date('D M', strtotime($time));
$hora = date('g:i a', strtotime($time));
$forecasts = carbon_get_post_meta(get_the_ID(), 'forecasts');

$parley_id = get_the_ID();
echo "<div class='parley_wrapper'>
<div class='parley_top_content'>
    <h2>Parley $fecha</h2>
    <img src='img/logo2.svg' class='img-fluid' alt=''>
</div>";
    if($forecasts and count($forecasts) > 0){
        $parley_cuotes = 1;
        foreach ($forecasts as $event) {
            $predictions = carbon_get_post_meta($event['id'], 'predictions');
            $prediction = [];
            $prediction['title'] = isset($predictions[0]) ? $predictions[0]['title']: '';
            $prediction['cuote'] = isset($predictions[0]) ? $predictions[0]['cuote']: 1;
            
            
            if($parley_cuotes >= 1){
                $parley_cuotes *= floatval($prediction['cuote']);
            }
            
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
                        $sport_logo = wp_get_attachment_url(carbon_get_term_meta($item->term_id, 'mini_img'));
                        if($sport_logo)
                            $sport['logo'] = $sport_logo;
                        $sport['name'] = $item->name;
                    }
                }
            }
            if(is_float($prediction['cuote'])):
                $oOddsConverter = new Converter($prediction['cuote'], 'eu');
                $odds_result = $oOddsConverter->doConverting();
                $prediction['cuote'] = $odds_result[$_SESSION['odds_format']];
            endif;


            echo "<div class='parley_box'>
                <div class='parley_left_content'>
                    <div class='parley_game_name_wrapper'>
                        <div class='parley_game_name'>
                            <h5>{$sport['name']}</h5>
                        
                        <div class='d-lg-block d-none'>
                            <time>$fecha, $hora</time>
                        </div>
                        </div>
                        <div class='d-lg-none d-block'>
                            <div class='mobile_parley_time'>
                                <p>$fecha / $hora</p>
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
                    <div class='question2'>
                      <a href='$permalink'>
                            Ver análisis
                        </a>
                    </div>
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
                    <img style='width:102px;height:33px;object-fit:contain;' src='{$bookmaker['logo']}' class='img-fluid' alt=''>
                </div>
                <div class='parley_right_content2'>

                    <div class='blog_select_box parley_right_content2_mb'>
                        <select class='form-select' onchange='test(this)' name='apu' id='apu' data='$parley_id' >
                            <option value='10'>Apuesta $10</option>
                            <option value='15'>Apuesta $15</option>
                            <option value='20'>Apuesta $20</option>
                            <option value='50'>Apuesta $50</option>
                        </select>
                        
                    </div>
                    <div class='gana_box parley_right_content2_mb'>
                    <input type='hidden' id='jscuote_$parley_id' value='$parley_cuotes'/>
                       <p>Gana: $ <span id='jsresult_$parley_id' >". $parley_cuotes * 10 ."</span></p>
                    </div>
                    <div class='parley_left_content2 parley_right_content2_mb d-md-none d-block'>
                    <img style='width:102px;height:33px;object-fit:contain;' src='{$bookmaker['logo']}' class='img-fluid' alt=''>
                    </div>
                    <div class='parley_btn_2 parley_right_content2_mb'> 
                        <a href='{$bookmaker['ref_link']}' class='button'>Apostar ahora</a>
                    </div>      
                </div>
            </div>";
echo "</div>";
