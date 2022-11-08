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

$permalink = get_the_permalink(get_the_ID());
$cross_img = get_template_directory_uri(  ) . '/assets/img/cross.png';

$time = carbon_get_post_meta(get_the_ID(), 'data');
$geolocation = json_decode($_SESSION["geolocation"]);
$date = new DateTime($time);
$date = $date->setTimezone(new DateTimeZone($geolocation->timezone));

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
$aw_system_location = aw_select_country(["country_code"=>$geolocation->country_code]);
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

$p1 = carbon_get_post_meta(get_the_ID(), 'p1');
$x = carbon_get_post_meta(get_the_ID(), 'x');
$p2 = carbon_get_post_meta(get_the_ID(), 'p2');

$oddsp1 = new Converter($p1, 'eu');
$oddsx = new Converter($x, 'eu');
$oddsp2 = new Converter($p2, 'eu');

$p1 = $oddsp1->doConverting();
$x = $oddsx->doConverting();
$p2 = $oddsp2->doConverting();
$p1 = $p1[$_SESSION['odds_format']]; $x = $x[$_SESSION['odds_format']]; $p2 = $p2[$_SESSION['odds_format']];

if (!$p1) {
    $p1 = 'n/a';
}

if (!$x) {
    $x = 'n/a';
}

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
                <li><a href="'.$permalink.'"><img src="'.$teams['team1']['logo'].'" alt="">'.$teams['team1']['name'].'</a></li>
                <li><a href="'.$permalink.'"><img src="'.$teams['team2']['logo'].'" alt="">'.$teams['team2']['name'].'</a></li>
            </ul>
        </div>
        <div class="slider__nmbr__wpa">
            <div class="slider__number--fx">
                <div class="slider__nmbr--single">
                    <div class="slider-ct">
                        <span>1</span>
                    </div>
                    <div class="sl--bt">
                        <a href="#">'.$p1.'</a>
                    </div>
                </div>
                <div class="slider__nmbr--single">
                    <div class="slider-ct">
                        <span>x</span>
                    </div>
                    <div class="sl--bt">
                        <a href="#">'.$x.'</a>
                    </div>
                </div>
                <div class="slider__nmbr--single">
                    <div class="slider-ct">
                        <span>2</span>
                    </div>
                    <div class="sl--bt">
                        <a href="#">'.$p2.'</a>
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