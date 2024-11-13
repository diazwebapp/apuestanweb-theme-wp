<?php

$params = get_query_var('params');
$image_att = carbon_get_post_meta($args["forecast"]->ID, 'img');
$image_png = wp_get_attachment_url($image_att);
$status = carbon_get_post_meta($args["forecast"]->ID, 'status');
$vip = carbon_get_post_meta($args["forecast"]->ID, 'vip');
$permalink = get_the_permalink($args["forecast"]->ID);
$sport_term = wp_get_post_terms($args["forecast"]->ID, 'league', array('fields' => 'all'));
$teams = get_forecast_teams($args["forecast"]->ID,["w"=>50,"h"=>50]);

//configurando zona horaria
$time = carbon_get_post_meta($args["forecast"]->ID, 'data');
$date = new DateTime($time);
$date = $date->setTimezone(new DateTimeZone($args["timezone"]));


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


    $author_id = $args["forecast"]->post_author;
    // $author_id = get_the_author_meta( 'ID' );
    $acerted = get_the_author_meta("forecast_acerted", $author_id );
    $failed = get_the_author_meta("forecast_failed", $author_id );
    $nulled = get_the_author_meta("forecast_nulled", $author_id );
    $display_name = get_the_author_meta("display_name", $author_id );
    $avatar_url = get_avatar_url($author_id);
    $flechita_up = get_template_directory_uri(  ) . '/assets/img/love2.png';
    $flechita_down = get_template_directory_uri(  ) . '/assets/img/love1.png';
    $avatar = isset($avatar_url) ? $avatar_url : get_template_directory_uri() . '/assets/img/logo2. svg';
    $flechita_indicadora = "";
    if(floatval($acerted) > floatval($failed)):
        $flechita_indicadora = $flechita_up;
    endif;
    if(floatval($acerted) < floatval($failed)):
        $flechita_indicadora = $flechita_down;
    endif;

    echo "<div class='vip_lock_box'>
    <div class='vip_left_content'>
        <div class='vip_img'>
            <img src='$avatar' class='img-flud' alt=''>
        </div>
        <div class='vip_left_text'>
            <h5>$display_name</h5>
            <div class='pick_box'>
                <img style='width:24px;height:24px;object-fit:contain;' src='$flechita_up' class='img-fluid' alt=''>
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
                    <div class='d-lg-none d-block league_box1'>
                        <i class='icon_leages {$league['class']}'></i>
                        <b>{$league['name']}</b>
                    </div>  
                    <div class='team_flag team_flag2'>
                        <img style='width:50px;height:50px;object-fit:contain;' src='{$teams['team2']['logo']}' class='img-fluid' alt=''>
                    </div>
                </div>
                <p class='d-lg-block d-none'>
                    <span style='margin:0 5px;'>".$date->format('d-m-Y g:i a')."</span>
                </p>
            </div>
            <div class='d-lg-block d-none'> 
                <div class='league_box_wrapper'>
                    <div class='league_box1'>
                        <i class='icon_leages {$league['class']}'></i>
                        <b>{$league['name']}</b>
                    </div>
                    <div class='league_box1'>
                        <img style='width:24px;height:24px;object-fit:contain;' src='".get_template_directory_uri( ) . '/assets/img/icon8.svg' ."' class='img-fluid' alt=''>
                        <i class='icon_leagues {$sport['class']}'></i>
                    </div>
                </div>
            </div>
        </div>
        <div class='vip_right_btn'>
            <a href='{$params['memberships_page']}'>
                <img style='width:24px;height:24px;object-fit:contain;' src='".get_template_directory_uri( ) . '/assets/img/lock.png' ."' class='img-fluid' alt=''>
                {$params['text_vip_link']}
            </a>
        </div>
    </div>
</div>";
