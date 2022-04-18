<?php
$params = get_query_var('params');
$time = carbon_get_post_meta(get_the_ID(), 'data');
$vip = carbon_get_post_meta(get_the_ID(), 'vip');
$permalink = get_the_permalink();
$predictions = carbon_get_post_meta(get_the_ID(), 'predictions');
$site_logo_url = get_template_directory_uri() . '/assets/img/event-logo.png';
$lock_image_url = get_template_directory_uri() . '/assets/img/lock.png';
$idevent = "match_".get_the_ID();

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
$bk = get_bookmaker_by_post(get_the_ID(),["w"=>79,"h"=>18]);


$html_predictions = '';
$prediction['title'] = isset($predictions[0]) ? $predictions[0]['title'] : '';
$prediction['cuote'] = isset($predictions[0]) ? $predictions[0]['cuote'] : '';

if(!empty($predictions))
        $html_predictions = "<div class='event2_box_middle_heading'>
                                <h4>{$prediction['title']}</h4>
                                <p>{$prediction['cuote']}</p>
                            </div>";
    
if ($teams['team1']['logo'] and $teams['team2']['logo']):
    $fecha = date('d M', strtotime($time)) ;
    $hora = date('g:i a', strtotime($time));
    $content = get_the_content(get_the_ID()) ;
    $flechita = get_template_directory_uri() . '/assets/img/s55.png';
    
    if($vip == 'yes'){
        echo "
            <div class='col-md-6 mt_30'>
                
                <div class='event2_box event2_box3'>
                   
                        <div class='event2_top_box_wrapper event2_top_box_wrapper3'>
                            <div class='event2_top_box'>
                                <div class='event_top_left'>
                                    <img src='{$teams['team1']['logo']}' alt='{$teams['team1']['name']}' title='{$teams['team1']['name']}' class='img-fluid'>
                                </div>
                                <div class='event_top_middle'>
                                <p class='p1 {$sport['class']}'><b>". strtoupper($sport['name']) ."</b></p>
                                    <div class='date_item_pronostico_top'>
                                        <input type='hidden' id='date' value='$time' />
                                        <b id='date_horas'></b>:<b id='date_minutos'></b> <b>m</b>
                                    </div>
                                    <p class='p2'><span>$fecha</span></p>
                                </div>
                                <div class='event_top_right'>
                                    <img src='{$teams['team2']['logo']}' alt='{$teams['team2']['name']}' title='{$teams['team2']['name']}' class='img-fluid' >
                                </div>
                            </div>
                            <p class='p3' >
                            {$teams['team1']['name']} vs {$teams['team2']['name']}
                            </p>
                        </div>
                    
                        <div class='event2_box3_middle'>
                            <div class='event2_box3_middle_content'>
                                <div>
                                    <img src='$site_logo_url' alt=''>
                                    <p class='p1'>CONVIERTE EN MIEMBRO PREMIUM</p>
                                    <p class='p2'></p>
                                    <a href='{$params['vip_link']}' class='button'>
                                        {$params['text_vip_link']}
                                    </a>
                                </div>
                                <div class='event2_box3_middle_img_box'>
                                    <img src='$lock_image_url' class='img-fluid'>
                                </div>
                            </div>
                        </div>
                    
            </div>
                
            </div> ";
    }
    if($vip != 'yes'){
        echo "
            <div class='col-md-6 mt_30'>
                
                <div class='event2_box'>
                   
                        <div class='event2_top_box_wrapper'>
                            <div class='event2_top_box'>
                                <div class='event_top_left'>
                                    <img src='{$teams['team1']['logo']}' alt='{$teams['team1']['name']}' title='{$teams['team1']['name']}' class='img-fluid'>
                                </div>
                                <div class='event_top_middle'>
                                    <p class='p1 {$sport['class']}'><b>". strtoupper($sport['name']) ."</b></p>
                                    <div class='date_item_pronostico_top'>
                                        <input type='hidden' id='date' value='$time' />
                                        <b id='date_horas'></b>:<b id='date_minutos'></b> <b>m</b>
                                    </div>
                                    <p class='p2'><span>$fecha</span></p>
                                </div>
                                <div class='event_top_right'>
                                    <img src='{$teams['team2']['logo']}' alt='{$teams['team2']['name']}' title='{$teams['team2']['name']}' class='img-fluid' >
                                </div>
                            </div>
                            <p class='p3' >
                                {$teams['team1']['name']} vs {$teams['team2']['name']}
                            </p>
                        </div>
                    
                        <div class='event2_box_middle_content'>
                            <p class='p1'>Pronóstico:</p>
                            {$html_predictions}
                            <div class='event2_box_bonus'>
                                <p class='p2'>Bonus:</p>
                                <p class='p3'>{$bk['bonus']}</p>
                            </div>
                            <div class='event_btn_box'>
                                <div class='event_btn_img'>
                                    <img src='{$bk['logo']}' class='img-fluid' alt=''>
                                </div>
                                <div >
                                    <a href='{$bk['ref_link']}' class='button'>Juega ahora</a>
                                </div>
                            </div>
                        </div>
                   
                     
                    <div class='panel-group' id='accordion' role='tablist' aria-multiselectable='false'>
                        <div class='panel panel-default'>
                        <div class='panel-heading accor_btn' role='tab' id='headingOne'>
                            <button type='button' data-toggle='collapse' data-target='#$idevent' aria-expanded='false'>
                                <i class='fal fa-angle-down'></i>
                            </button>
                        </div>

                        <div id='$idevent' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingOne'>
                            <div class='panel-body'>
                            $content 
                            </div>
                        </div>
                    </div>
                  </div>          
            </div>
                
        </div> ";
    }
endif; 