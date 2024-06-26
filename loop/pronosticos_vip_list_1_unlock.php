<?php
$params = get_query_var('params');
$image_att = carbon_get_post_meta(get_the_ID(), 'img');
$image_png = wp_get_attachment_url($image_att);
$predictions = carbon_get_post_meta(get_the_ID(), 'predictions');
$status = carbon_get_post_meta(get_the_ID(), 'status');
$link = carbon_get_post_meta(get_the_ID(), 'link');
$vip = carbon_get_post_meta(get_the_ID(), 'vip');
$permalink = get_the_permalink(get_the_ID());

//configurando zona horaria
$time = carbon_get_post_meta(get_the_ID(), 'data');
$geolocation = json_decode(GEOLOCATION);
$date = new DateTime($time);
if($geolocation->success !== false):
    $date = $date->setTimezone(new DateTimeZone($geolocation->timezone));
endif;

$sport_term = wp_get_post_terms(get_the_ID(), 'league', array('fields' => 'all'));
$teams = get_forecast_teams(get_the_ID(),["w"=>50,"h"=>50]);
$bookmaker = get_bookmaker_by_post(get_the_ID(),["w"=>79,"h"=>18]);
$id_collapse = get_the_ID();

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

if ($teams['team1']['logo'] and $teams['team2']['logo'] ):
    $author_id = get_the_author_meta( 'ID' );
    $acerted = get_the_author_meta("forecast_acerted", $author_id );
    $failed = get_the_author_meta("forecast_failed", $author_id );
    $nulled = get_the_author_meta("forecast_nulled", $author_id );
    $display_name = get_the_author_meta("display_name", $author_id );
    $rank = get_the_author_meta("rank", $author_id );
    $content = get_the_content(get_the_ID());
    $avatar_url = get_avatar_url($author_id);
    $flechita_up = get_template_directory_uri(  ) . '/assets/img/love2.png';
    $flechita_down = get_template_directory_uri(  ) . '/assets/img/love1.png';
    $coronita = get_template_directory_uri(  ) . '/assets/img/icon8.svg';
    $avatar = isset($avatar_url) ? $avatar_url : get_template_directory_uri() . '/assets/img/logo2. svg';
    $link_profile = PERMALINK_PROFILE.'?profile='.$author_id;
    $flechita_indicadora = "";

    $rating_ceil = 0;
    $prediction = '';
    $cuote = 0;
    if($predictions and count($predictions)> 0):
        $oOddsConverter = new Converter($predictions[0]['cuote'], 'eu');
        $odds_result = $oOddsConverter->doConverting();
        $cuote = $odds_result[$_SESSION['odds_format']];
        $rating_ceil = $predictions[0]['tvalue'];
        $prediction = $predictions[0]['title'];
    endif;

    $html_status = "";
    if($status == 'ok')
        $html_status = "<b class='winl'>WIN</b>";
    if($status == 'fail')
        $html_status = "<b class='winl loss'>loss</b>";

    if(floatval($acerted) > floatval($failed)):
        $flechita_indicadora = $flechita_up;
    endif;
    if(floatval($acerted) < floatval($failed)):
        $flechita_indicadora = $flechita_down;
    endif;
    $stars = draw_rating($rating_ceil); 
    // vip lock box1 -->
    echo        '<div class="vip_lock_box v2 position-relative">
                    <div class="d-none d-sm-inline-block" >
                    '.$html_status.'
                    </div>
                    <div class="vip_left_content">
                        <div class="vip_img">
                            <img src="'.$avatar.'" class="img-flud" alt="">
                        </div>
                        <div class="vip_left_text">
                            <h5>'.$display_name.'</h5>
                            <div class="pick_box">
                                <img src="'.$flechita_indicadora.'" class="img-fluid" alt="">
                                <p>'.$acerted.'-'.$failed.', '.$rank.', Ult 10 picks</p>
                            </div>
                        </div>
                    </div>
                    <img src="'.$coronita.'" class="pplay_icon d-sm-none" alt="">
                    <p class="game_time d-sm-none d-flex align-items-center justify-content-between">
                        <span>'.$league['name'].'</span>
                        <span>'.$date->format('Y-m-d h:i:s').'</span>
                    </p>
                    <div class="rating d-sm-none">
                        '.$stars.'
                    </div>
                    <div class="vip_right_content">
                        <div class="match_time_box">
                            <div class="team_flag_box_wrapper">
                                <div class="team_flag_box">
                                    <div class="team_item">
                                        <div class="team_flag team_flag1">
                                            <img src="'.$teams['team1']['logo'].'" class="img-fluid" alt="'.$teams['team1']['name'].'">
                                        </div>
                                        <p class="d-sm-none">'.$teams['team1']['name'].'</p>
                                    </div>
                                    <div class="d-none d-lg-none d-sm-block">
                                        <div class="league_box1">
                                            <i class="'.$league['class'].'"></i>
                                            <p>'.$league['name'].'</p>
                                        </div>
                                    </div>
                                    <div class="team_item"> 
                                        <div class="team_flag team_flag2">
                                            <img src="'.$teams['team2']['logo'].'" class="img-fluid" alt="'.$teams['team2']['name'].'">
                                        </div>
                                        <p class="d-sm-none">'.$teams['team2']['name'].'</p>
                                    </div>
                                </div>
                                <div class="league_box1 d-lg-flex d-none">
                                    <i class="'.$league['class'].'"></i>
                                    <p>'.$league['name'].'</p>
                                </div>
                            </div>
                            <div class="win_wrap d-sm-none">
                                '.$html_status.'
                            </div>
                            <div class="d-lg-block d-none"> 
                                <div class="league_box_wrapper align-items-center">
                                    <p class="d-lg-block d-none mr_30">
                                    <time>'.$date->format('Y-m-d h:i:s').'</time>
                                    </p>
                                    <div class="league_box1">
                                        <img src="'.$coronita.'" class="img-fluid img_30" alt="">
                                        <i class="'.$sport['class'].'"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="team_name">'.$teams['team1']['name'].' vs '.$teams['team2']['name'].'</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="btn_text">
                                    PRONÓSTICO: '.$prediction.' 
                                    <div class="rate_text d-sm-none">'.$cuote.'</div>
                                </div>
                                <div class="d-none d-sm-flex align-items-center">
                                    <div class="rating">
                                        '.$stars.'
                                    </div>
                                    <div class="rate_text">'.$cuote.'</div>
                                </div>
                            </div>
                            
                            <div class="text-center accor_btn mt_15">
                                <button type="button" data-toggle="collapse" data-target="#col1'.$id_collapse.'" aria-expanded="false">
                                    <i class="fa fa-angle-down"></i>
                                </button>
                            </div>
                            <div class="collapse" id="col1'.$id_collapse.'">
                                <p class="more_text pt_30">'.$content.'</p>
                            </div>
                        </div>
                    </div>
                </div>'    ;                    
                    //<!-- vip lock box2
endif;