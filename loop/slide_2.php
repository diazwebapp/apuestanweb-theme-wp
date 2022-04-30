<?php
// Slide background
$slide_bg = get_template_directory_uri() . '/assets/img/banner2.png';
$event_bg_att = carbon_get_post_meta(get_the_ID(), 'wbg');
$stadium = carbon_get_post_meta(get_the_ID(), 'stadium');
$event_bg = wp_get_attachment_url($event_bg_att);
if($event_bg)
    $slide_bg = $event_bg;


$prediction = carbon_get_post_meta(get_the_ID(), 'prediction');
$link = carbon_get_post_meta(get_the_ID(), 'link');

$permalink = get_the_permalink();
$cross_img = get_template_directory_uri(  ) . '/assets/img/cross.png';

$time = carbon_get_post_meta(get_the_ID(), 'data');
$geolocation = json_decode(GEOLOCATION);
$date = new DateTime($time);
if($geolocation->success !== false):
    $date = $date->setTimezone(new DateTimeZone($geolocation->timezone));
endif;

$sport_term = wp_get_post_terms(get_the_ID(), 'league', array('fields' => 'all'));

$sport['name'] = '';
if ($sport_term) {
    foreach ( $sport_term as $item ) {
        if($item->parent == 0){
            $sport['name'] = $item->name;
        }
    }
}
//Equipos
$teams = get_forecast_teams(get_the_ID());
//bk
$bookmaker = get_bookmaker_by_post(get_the_ID());

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
    echo '<div class="slider__single--box">
    <div class="slider__box--top">
        <p>'.$sport['name'].'</p>
        <p>'.$date->format('g:i a').'</p>
    </div>
    <div class="slider__box--main">
        <div class="slider__main--menu">
            <ul>
                <li><a href="#"><img src="'.$teams['team1']['logo'].'" alt="">'.$teams['team1']['name'].'</a></li>
                <li><a href="#"><img src="'.$teams['team2']['logo'].'" alt="">'.$teams['team2']['name'].'</a></li>
            </ul>
        </div>
        <div class="slider__nmbr__wpa">
            <div class="slider__number--fx">
                <div class="slider__nmbr--single">
                    <div class="slider-ct">
                        <span>'.$p1.'</span>
                    </div>
                    <div class="sl--bt">
                        <a href="#">1.90</a>
                    </div>
                </div>
                <div class="slider__nmbr--single">
                    <div class="slider-ct">
                        <span>'.$x.'</span>
                    </div>
                    <div class="sl--bt">
                        <a href="#">1.90</a>
                    </div>
                </div>
                <div class="slider__nmbr--single">
                    <div class="slider-ct">
                        <span>'.$p2.'</span>
                    </div>
                    <div class="sl--bt">
                        <a href="#">1.90</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="slider___hover--main">
        <a href="'.$bookmaker['ref_link'].'"><img src="'.$bookmaker['logo'].'" alt="'.$bookmaker['name'].'"></a>
    </div>
    </div>';
    
endif; 