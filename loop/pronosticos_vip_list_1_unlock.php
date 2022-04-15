<?php
$params = get_query_var('params');
$image_att = carbon_get_post_meta(get_the_ID(), 'img');
$image_png = wp_get_attachment_url($image_att);
$time = carbon_get_post_meta(get_the_ID(), 'data');
$predictions = carbon_get_post_meta(get_the_ID(), 'predictions');
$status = carbon_get_post_meta(get_the_ID(), 'status');
$link = carbon_get_post_meta(get_the_ID(), 'link');
$vip = carbon_get_post_meta(get_the_ID(), 'vip');
$permalink = get_the_permalink(get_the_ID());
$fecha = date('d M', strtotime($time));
$hora = date('g:i a', strtotime($time));
$sport_term = wp_get_post_terms(get_the_ID(), 'league', array('fields' => 'all'));
$teams = get_forecast_teams(get_the_ID(),["w"=>50,"h"=>50]);
$bookmaker = get_bookmaker_by_post(get_the_ID(),["w"=>79,"h"=>18]);
$id_collapse = get_the_ID();

//Componente si es vip
$vipcomponent ="<a href='{$params['vip_link']}' class='game_btn v2'>
                    <p>{$params['text_vip_link']}</p>
                </a>";
if(!$vip)
    $vipcomponent ="<a href='{$bookmaker['ref_link']}' class='game_btn'>
                        <img src='{$bookmaker['logo']}' alt='{$bookmaker['name']}'>
                        <p>Haz una apuesta</p>
                    </a>";
//Liga y deporte
$sport = '';
$league = "";
$logo_league_src = "";
$logo_sport_src = "";
if ($sport_term) {
    foreach ( $sport_term as $item ) {
        if($item->parent == 0){
            $logo_sport_src = wp_get_attachment_url(carbon_get_term_meta($item->term_id, 'mini_img'));
            if(!$logo_sport_src):
                    $logo_sport_src = get_template_directory_uri() . '/assets/img/logo2.svg';
            endif;
        }
        if($item->parent != 0){
            $logo_league_src = wp_get_attachment_url(carbon_get_term_meta($item->term_id, 'mini_img'));
            if(!$logo_league_src):
                    $logo_league_src = get_template_directory_uri() . '/assets/img/logo2.svg';
            endif;
            $league = $item->name;
        }
    }
}



$p1 = carbon_get_post_meta(get_the_ID(), 'p1');
if (!$p1) {
    $p1 = 'n/a';
}
$x = carbon_get_post_meta(get_the_ID(), 'x');
if (!$x) {
    $x = 'n/a';
}
$p2 = carbon_get_post_meta(get_the_ID(), 'p2');
if (!$p2) {
    $p2 = 'n/a';
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
        $rating_ceil = $predictions[0]['tvalue'];
        $cuote = $predictions[0]['cuote'];
        $prediction = $predictions[0]['title'];
    endif;

    $html_status = "";
    if($status == 'ok')
        $html_status = "<div class='winl d-none d-sm-inline-block'>WIN</div>";
    if($status == 'fail')
        $html_status = "<div class='winl loss d-none d-sm-inline-block'>loss</div>";
    if(floatval($acerted) > floatval($failed)):
        $flechita_indicadora = $flechita_up;
    endif;
    if(floatval($acerted) < floatval($failed)):
        $flechita_indicadora = $flechita_down;
    endif;
    echo "<div class='vip_lock_box v2 position-relative'>
    $html_status
    <div class='vip_left_content'>
    
        <div class='vip_img'>
            <img src='$avatar' class='img-flud' alt=''>
        </div>
        <div class='vip_left_text'>
            <a href='$link_profile' ><h5>$display_name</h5></a>
            <div class='pick_box'>
                <img src='$flechita_indicadora' class='img-fluid' alt=''>
                <p>$acerted - $failed Ult $rank picks</p>
            </div>
        </div>
    </div>
    <img style='width:24px;height:24px;object-fit:contain;' src='$logo_league_src' class='pplay_icon d-sm-none' alt='' >
    <p class='game_time d-sm-none d-flex align-items-center justify-content-between'>
        <span>$league</span>
        
        <span class='date_item_pronostico_top'>
                <span style='margin: 0 5px;'>$fecha</span>
                <input type='hidden' id='date' value='$time' />
                <b id='date_horas'></b>:<b id='date_minutos'></b> <b>m</b>
        </span>

    </p>
    <div class='rating d-sm-none'>";
    echo draw_rating($rating_ceil); 
echo "    </div>
    <div class='vip_right_content'>
        <div class='match_time_box'>
            <div class='team_flag_box_wrapper'>
                <div class='team_flag_box'>
                    <div class='team_item'>
                        <div class='team_flag team_flag1'>
                            <img src='{$teams['team1']['logo']}' class='img-fluid' alt=''>
                        </div>
                        <p class='d-sm-none'>{$teams['team1']['name']}</p>
                    </div>
                    <div class='d-none d-lg-none d-sm-block'>
                        <div class='league_box1'>
                            <img style='width:24px;height:24px;object-fit:contain;' src='$logo_league_src' />
                            <p>$league</p>
                        </div>
                    </div>
                    <div class='team_item'> 
                        <div class='team_flag team_flag2'>
                            <img src='{$teams['team2']['logo']}' class='img-fluid' alt=''>
                        </div>
                        <p class='d-sm-none'>{$teams['team2']['name']}</p>
                    </div>
                </div>
                <div class='league_box1 d-lg-flex d-none'>
                    <img style='width:24px;height:24px;object-fit:contain;' src='$logo_league_src' />
                    <p>$league</p>
                </div>
            </div>
            <div class='win_wrap d-sm-none'>
                <div class='winl'>WIN</div>
            </div>
            <div class='d-lg-block d-none'> 
                <div class='league_box_wrapper align-items-center'>
                    <p class='d-lg-block d-none mr_30'>$fecha </p>
                    <div class='date_item_pronostico_top'>
                        <input type='hidden' id='date' value='$time' />
                        <b id='date_horas'></b>:<b id='date_minutos'></b> <b>m</b>
                    </div>
                    <div class='league_box2'>
                        <img style='width:24px;height:24px;object-fit:contain;' src='$coronita' class='img-fluid img_30' alt=''>
                        <img style='width:24px;height:24px;object-fit:contain;' src='$logo_sport_src' class='img-fluid' alt=''>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <p class='team_name'>{$teams['team1']['name']} vs Arsenal</p>
            <div class='d-flex align-items-center justify-content-between'>
                <div class='btn_text'>
                    PRONÓSTICO: $prediction 
                    <div class='rate_text d-sm-none'>$cuote</div>
                </div>
                <div class='d-none d-sm-flex align-items-center'>
                    <div class='rating'>";
                    echo draw_rating($rating_ceil); 
   echo "           </div>
                    <div class='rate_text'>$cuote</div>
                </div>
            </div>
             <div class='text-center accor_btn mt_15'>
                <button type='button' data-toggle='collapse' data-target='#col1_$id_collapse' aria-expanded='false'>
                    <i class='fal fa-angle-down'></i>
                </button>
            </div>
            <div class='collapse' id='col1_$id_collapse'>
                <p class='more_text pt_30'>$content</p>
            </div>
        </div>
    </div>
</div>";
endif; ?>