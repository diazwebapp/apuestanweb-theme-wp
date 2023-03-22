<?php

$params = get_query_var('params');
$vip = carbon_get_post_meta($args["forecast"]->ID, 'vip');
$permalink = get_the_permalink($args["forecast"]->ID);
$predictions = carbon_get_post_meta($args["forecast"]->ID, 'predictions');
$site_logo_url = get_template_directory_uri() . '/assets/img/event-logo.png';
$lock_image_url = get_template_directory_uri() . '/assets/img/lock.png';
$idevent = "match_".$args["forecast"]->ID;

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

$teams = get_forecast_teams($args["forecast"]->ID,["w"=>50,"h"=>50]);

$aw_system_location = aw_select_country(["country_code"=>$args["country_code"]]);

$bookmaker = [];

//SI EL PAIS ESTÁ CONFIGURADO
if(isset($aw_system_location)):
    $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true,"on_page"=>true]);
    if($bookmaker["name"] == "no bookmaker"){
        $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true]);
    }
endif;

$html_predictions = '';

if(!empty($predictions)):
    $prediction['title'] = isset($predictions[0]) ? $predictions[0]['title'] : '';
    $prediction['cuote'] = isset($predictions[0]) ? $predictions[0]['cuote'] : 1;

    $oOddsConverter = new Converter($prediction['cuote'], 'eu');
    $odds_result = $oOddsConverter->doConverting();
    if(is_array($odds_result)):
        $prediction['cuote'] = isset($odds_result[$args["odds"]]) ? $odds_result[$args["odds"]] : 0;
    endif;

    $html_predictions = "<div class='event2_box_middle_heading'>
                            <h3>{$prediction['title']}</h3>
                            <p>{$prediction['cuote']}</p>
                            </div>";
endif;
$time_format_html = "<p>".$date->format('g:i a')."</p>";
if($params['time_format']  == 'count'):
    $time_format_html = "<div class='date_item_pronostico_top'>
                            <input type='hidden' id='date' value='".$date->format('Y-m-d G:i:s')."' />
                            <b id='date_horas'></b>h:<b id='date_minutos'></b>:<b id='date_segundos'></b>
                        </div>";
endif;  


$content = get_the_content(false, false, $args["forecast"]->ID);
$content_without_headers = preg_replace('/<h[1-6].*?>(.*?)<\/h[1-6]>/i', '', $content);



    $flechita = get_template_directory_uri() . '/assets/img/s55.png';
    $tvalue = isset($predictions[0]) ? $predictions[0]['tvalue'] : null;
    $estrellas = "";
    if(isset($tvalue)):
        for($i=1; $i<=5;$i++):
            $estrellas .=  '<i style="font-size:15px;" class="fa fa-star '.($i <= intval($tvalue) ? "text-warning" : "").' px-1 py-1 align-text-bottom" ></i>';
        endfor;
    endif;

    $estado_usuario = "permitido";
    if(function_exists("aw_get_user_type")):
        $user_type = aw_get_user_type($args["current_user"]);
        if($user_type == "unreg"){
            $estado_usuario = "no permitido";
        }
    endif;
    
    $html_vip_loked = "<div class='col-md-6 mt_30'>
                
                        <div class='event2_box event2_box3'>
                        
                                <div class='event2_top_box_wrapper event2_top_box_wrapper3'>
                                    <div class='event2_top_box'>
                                        <div class='event_top_left'>
                                            <img src='{$teams['team1']['logo']}' alt='{$teams['team1']['name']}' title='{$teams['team1']['name']}' class='img-fluid'>
                                        </div>
                                        <div class='event_top_middle'>
                                        <p class='p1 {$sport['class']}'><b>". strtoupper($sport['name']) ."</b></p>
                                            $time_format_html
                                            <p class='p2'><time datetime='".$date->format('Y-m-d H:i:s')."'>".date_i18n('D, d M Y', strtotime($date->format('Y-m-d')))."</time></p>                                    
                                        </div>
                                        <div class='event_top_right'>

                                            <img src='{$teams['team2']['logo']}' alt='{$teams['team2']['name']}' title='{$teams['team2']['name']}' class='img-fluid' >
                                        </div>
                                    </div>
                                    <h2><a href='$permalink'>                               
                                    {$teams['team1']['name']} vs {$teams['team2']['name']}                              
                                    </a> </h2>
                                </div>
                            
                                <div class='event2_box3_middle'>
                                    <div class='event2_box3_middle_content'>
                                        <div>
                                            <img class='img-fluid' width='170px' height='40px' src='".get_template_directory_uri() . '/assets/img/apnpls.svg'."'  alt='ApuestanPlus'>
                                            <p class='p1'>CONVIERTE EN MIEMBRO PREMIUM</p>
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
    
                    </div> "
    ;
    $html_vip_unloked =  "<div class='col-md-6 mt_30'>
                
                    <div class='event2_box'>
                    
                            <div class='event2_top_box_wrapper event2_top_box_wrapper3'>
                                <div class='event2_top_box'>
                                    <div class='event_top_left'>
                                        <img src='{$teams['team1']['logo']}' alt='{$teams['team1']['name']}' title='{$teams['team1']['name']}' class='img-fluid'>
                                    </div>
                                    <div class='event_top_middle'>
                                        <p class='p1 {$sport['class']}'><b>". strtoupper($sport['name']) ."</b></p>
                                            $time_format_html                                   
                                        <p class='p2'><time datetime='".$date->format('Y-m-d H:i:s')."'>".date_i18n('D, d M Y', strtotime($date->format('Y-m-d')))."</time></p>                                    
                                    </div>
                                    <div class='event_top_right'>
                                        <img src='{$teams['team2']['logo']}' alt='{$teams['team2']['name']}' title='{$teams['team2']['name']}' class='img-fluid' >
                                    </div>
                                </div>
                                <p class='p3' >
                                    <h2><a href='$permalink'>                               
                                    {$teams['team1']['name']} vs {$teams['team2']['name']}                              
                                    </a> </h2>
                                </p>
                            </div>
                        
                            <div class='event2_box_middle_content'>
                                <div class='text-center'>$estrellas</div>
                                <p class='p1'>Pronóstico:</p>
                                {$html_predictions}
                                <div class='event2_box_bonus'>
                                    <p class='p2'>Bonus:</p>
                                    <p class='p3'>{$bookmaker['bonus_slogan']}</p>
                                </div>
                                <div class='event_btn_box'>
                                    <div class='event_btn_img'>
                                        <a href='{$bookmaker['ref_link']}'>
                                        <img src='{$bookmaker['logo']}' class='img-fluid' width='80' height='20' alt='' style='background:{$bookmaker['background_color']}'>
                                        </a>
                                    </div>
                                    <div >
                                        <a href='{$bookmaker['ref_link']}' class='button-ev2' rel='nofollow noopener noreferrer'>Juega ahora</a>
                                    </div>
                                </div>
                            </div>
                    
                        
                        <div class='panel-group' id='accordion' role='tablist' aria-multiselectable='false'>
                            <div class='panel2 panel-default'>
                            <div class='panel-heading accor_btn' role='tab' id='headingOne'>
                                <button type='button' data-toggle='collapse' data-target='#$idevent' aria-expanded='false'>
                                    <i class='fal fa-angle-down'></i>
                                </button>
                            </div>

                            <div id='$idevent' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingOne'>
                                <div class='panel-body text-break'>
                                <p>$content_without_headers</p> 
                                </div>
                            </div>
                        </div>
                    </div>          
                </div>
                    
                </div> "
                ;
    $html_free =  "<div class='col-md-6 mt_30'>
                
                <div class='event2_box'>
                   
                        <div class='event2_top_box_wrapper'>
                            <div class='event2_top_box'>
                                <div class='event_top_left'>
                                    <img src='{$teams['team1']['logo']}' alt='{$teams['team1']['name']}' title='{$teams['team1']['name']}' class='img-fluid'>
                                </div>
                                <div class='event_top_middle'>
                                    <p class='p1 {$sport['class']}'><b>". strtoupper($sport['name']) ."</b></p>
                                        $time_format_html                                   
                                    <p class='p2'><time datetime='".$date->format('Y-m-d H:i:s')."'>".date_i18n('D, d M Y', strtotime($date->format('Y-m-d')))."</time></p>                                    
                                </div>
                                <div class='event_top_right'>
                                    <img src='{$teams['team2']['logo']}' alt='{$teams['team2']['name']}' title='{$teams['team2']['name']}' class='img-fluid' >
                                </div>
                            </div>
                            <p class='p3' >
                                <h2><a href='$permalink'>                               
                                {$teams['team1']['name']} vs {$teams['team2']['name']}                              
                                </a> </h2>
                            </p>
                        </div>
                    
                        <div class='event2_box_middle_content'>
                            <p class='p1'>Pronóstico:</p>
                            {$html_predictions}
                            <div class='event2_box_bonus'>
                                <p class='p2'>Bonus:</p>
                                <p class='p3'>{$bookmaker['bonus_slogan']}</p>
                            </div>
                            <div class='event_btn_box'>
                                <div class='event_btn_img'>
                                    <a href='{$bookmaker['ref_link']}'>
                                    <img src='{$bookmaker['logo']}' class='img-fluid' width='80' height='20' alt='' style='background:{$bookmaker['background_color']}'>
                                    </a>
                                </div>
                                <div >
                                    <a href='{$bookmaker['ref_link']}' class='button-ev2' rel='nofollow noopener noreferrer'>Juega ahora</a>
                                </div>
                            </div>
                        </div>
                   
                     
                    <div class='panel-group' id='accordion' role='tablist' aria-multiselectable='false'>
                        <div class='panel panel-default'>
                        <div class='panel-heading accor_btn' role='tab' id='headingOne'>
                            <button class='d-flex align-items-center justify-content-between'type='button' data-toggle='collapse' data-target='#$idevent' aria-expanded='false'>
                                <i class='fal fa-angle-down'></i>
                            </button>
                        </div>

                        <div id='$idevent' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingOne'>
                            <div class='panel-body text-break'>
                            <p>$content_without_headers</p> 
                            </div>
                        </div>
                    </div>
                  </div>          
            </div>
                
        </div> "
    ;
    if($vip and  $estado_usuario == "permitido"){
        echo $html_vip_unloked;
    }
    if($vip and  $estado_usuario == "no permitido"){
        echo $html_vip_loked;
    }
    if(!$vip){
        echo $html_free;
    }
    
