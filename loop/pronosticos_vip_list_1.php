<?php
$params = get_query_var('params');
$image_att = carbon_get_post_meta(get_the_ID(), 'img');
$image_png = wp_get_attachment_url($image_att);
$status = carbon_get_post_meta(get_the_ID(), 'status');
$vip = carbon_get_post_meta(get_the_ID(), 'vip');
$permalink = get_the_permalink(get_the_ID());
$sport_term = wp_get_post_terms(get_the_ID(), 'league', array('fields' => 'all'));
$teams = get_forecast_teams(get_the_ID(),["w"=>50,"h"=>50]);
$bookmaker = get_bookmaker_by_post(get_the_ID(),["w"=>79,"h"=>18]);

//configurando zona horaria
$time = carbon_get_post_meta(get_the_ID(), 'data');

$datetime = new DateTime($time);
$date = $datetime;
$geolocation = aw_get_geolocation();
if($geolocation->success !== false):
    date_default_timezone_set($geolocation->timezone);
    $datetime = new DateTime($time);
    $date = $datetime->setTimezone(new DateTimeZone($geolocation->timezone_gmt));
endif;

//Liga y deporte
$sport = '';
$league = "";
if ($sport_term) {
    foreach ( $sport_term as $item ) {
        if($item->parent == 0){
            $logo_sport_src = wp_get_attachment_url(carbon_get_term_meta($item->term_id, 'mini_img'));
            if(!$logo_sport_src):
                    $logo_sport_src = get_template_directory_uri() . '/assets/img/logo2.svg';
            endif;
            $sport = "<img loading='lazy' style='width:28px;height:28px;object-fit:contain;' src='{$logo_sport_src}' class='img-fluid' alt='{$item->name}' title='{$item->name}'>";
        }
        if($item->parent != 0){
            $logo_league_src = wp_get_attachment_url(carbon_get_term_meta($item->term_id, 'mini_img'));
            if(!$logo_league_src):
                    $logo_league_src = get_template_directory_uri() . '/assets/img/logo2.svg';
            endif;
            $league = "<img loading='lazy'style='width:28px;height:28px;object-fit:contain;' src='{$logo_league_src}' class='img-fluid' alt='{$item->name}' title='{$item->name}'>
                <p>{$item->name}</p>";
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

if ($teams['team1']['logo'] and $teams['team2']['logo']):
    $author_id = get_the_author_meta( 'ID' );
    $acerted = get_the_author_meta("forecast_acerted", $author_id );
    $failed = get_the_author_meta("forecast_failed", $author_id );
    $nulled = get_the_author_meta("forecast_nulled", $author_id );
    $display_name = get_the_author_meta("display_name", $author_id );
    $avatar_url = get_avatar_url($author_id);
    $flechita_up = get_template_directory_uri(  ) . '/assets/img/love2.png';
    $flechita_down = get_template_directory_uri(  ) . '/assets/img/love1.png';
    $avatar = isset($avatar_url) ? $avatar_url : get_template_directory_uri() . '/assets/img/logo2. svg';

    echo "<div class='vip_lock_box'>
    <div class='vip_left_content'>
        <div class='vip_img'>
            <img src='$avatar' class='img-flud' alt=''>
        </div>
        <div class='vip_left_text'>
            <h5>Luis Rodriguez</h5>
            <div class='pick_box'>
                <img src='$flechita_up' class='img-fluid' alt=''>
                <p>$acerted - $failed Ult 10 picks</p>
            </div>
        </div>
    </div>
    <div class='vip_right_content'>
        <div class='match_time_box'>
            <div class='team_flag_box_wrapper'>
                <div class='team_flag_box'>
                    <div class='team_flag team_flag1'>
                        <img style='width:50px;height:50px;object-fit:contain;' src='{$teams['team1']['logo']}' class='img-fluid' alt=''>
                    </div>
                    <div class='d-lg-none d-block'>
                        <div class='league_box1'>
                            $league
                        </div>
                    </div>  
                    <div class='team_flag team_flag2'>
                        <img style='width:50px;height:50px;object-fit:contain;' src='{$teams['team2']['logo']}' class='img-fluid' alt=''>
                    </div>
                </div>
                <p class='d-lg-none d-block vip_mobile_p'><span>Análisis:</span> Lorem ipsum dolor sit amet, conset etur sadipscing elitr, sed diam no numy sit eirmod…</p>
                <p class='d-lg-block d-none'>
                    <span style='margin:0 5px;'>".$date->format('d M')."</span>
                </p>
                <div class='date_item_pronostico_top'>
                    <input type='hidden' id='date' value=".$date->format('Y-m-d h:i:s')." />
                    <b id='date_horas'></b>:<b id='date_minutos'></b> <b>m</b>
                </div>
            </div>
            <div class='d-lg-block d-none'> 
                <div class='league_box_wrapper'>
                    <div class='league_box1'>
                        $league
                    </div>
                    <div class='league_box2'>
                        <img style='width:28px;height:28px;object-fit:contain;' src='".get_template_directory_uri( ) . '/assets/img/icon8.svg' ."' class='img-fluid' alt=''>
                        $sport
                    </div>
                </div>
            </div>
        </div>
        <div class='vip_right_btn'>
            <a href='{$params['memberships_page']}'>
                <img style='width:28px;height:28px;object-fit:contain;' src='".get_template_directory_uri( ) . '/assets/img/lock.png' ."' class='img-fluid' alt=''>
                {$params['text_vip_link']}
            </a>
        </div>
    </div>
</div>";
endif; ?>