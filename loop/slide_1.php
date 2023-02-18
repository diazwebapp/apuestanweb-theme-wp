<?php
// Slide background
$slide_bg = get_template_directory_uri() . '/assets/img/banner2.png';
$event_bg_att = carbon_get_post_meta(get_the_ID(), 'wbg');
$stadium = carbon_get_post_meta(get_the_ID(), 'stadium');
$event_bg = wp_get_attachment_url($event_bg_att);
if($event_bg):
    $slide_bg = $event_bg;
endif;

$time = carbon_get_post_meta(get_the_ID(), 'data');
$prediction = carbon_get_post_meta(get_the_ID(), 'prediction');
$link = carbon_get_post_meta(get_the_ID(), 'link');

$permalink = get_the_permalink();
$cross_img = get_template_directory_uri(  ) . '/assets/img/cross.png';

$date = new DateTime($time);
$date = $date->setTimezone(new DateTimeZone($args["timezone"]));

$fecha = date_i18n('d M', strtotime($date->format("y-m-d h:i:s")));
$hora = date('g:i a', strtotime($date->format('y-m-d h:i:s')));

$sport_term = wp_get_post_terms(get_the_ID(), 'league', array('fields' => 'all'));
$arr_sport = array();

if ($sport_term) {
    foreach ($sport_term as $item) {
        $arr_sport[] = '<a href="' . get_term_link($item, "league") . '>' . $item->name . '</a>';
        // Slide background optional
        if($item->parent == 0)
            $bg_term = carbon_get_term_meta($item->term_id, 'wbg');
            $bg_sport_src = isset($bg_term) ? wp_get_attachment_url($bg_term) : get_template_directory_uri() . '/assets/img/logo2.svg';
            if($bg_sport_src and !$event_bg):
                $slide_bg = $bg_sport_src;
            endif;
    }
    $arr_sport = array_reverse($arr_sport);
}

//Equipos
$teams = get_forecast_teams($id);

$p1 = carbon_get_post_meta(get_the_ID(), 'p1');
$x = carbon_get_post_meta(get_the_ID(), 'x');
$p2 = carbon_get_post_meta(get_the_ID(), 'p2');

$oddsp1 = new Converter($p1, 'eu');
$oddsx = new Converter($x, 'eu');
$oddsp2 = new Converter($p2, 'eu');

$p1 = $oddsp1->doConverting();
$x = $oddsx->doConverting();
$p2 = $oddsp2->doConverting();
$p1 = $p1[get_option('odds_type')]; $x = $x[get_option('odds_type')]; $p2 = $p2[get_option('odds_type')];
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
echo "<div class='owl-item' >
        <div class='item' style='background-image:linear-gradient(145deg,#03b0f4 0,#051421c4 50%,#dc213e 100%),url( $slide_bg ); background-repeat:no-repeat;background-size:cover;'>
            <div class='row align-items-center'>
                <div class='col-lg-7 main_text'>
                    <p>Enfrentamiento</p>
                    <div class='media align-items-center'>
                        <div class='hero_team_logo_box'>
                            <div class='team_logo'>
                                <img style='width:40px;height:40px;' src=' {$teams['team1']['logo']} ' class='img-fluid' alt=' {$teams['team1']['name']} '>
                            </div>
                            <div class='cross_img d-lg-none d-block'>
                                <img src='$cross_img' class='img-fluid' alt='teamvs'>
                            </div>                                
                            <div class='team_logo'>
                                <img style='width:40px;height:40px;' src=' {$teams['team2']['logo']} ' class='img-fluid' alt=' {$teams['team2']['name']} '>
                            </div>
                        </div>
                        <div class='media-body team_name'>
                            <h2 class='d-none d-sm-none d-md-block' > {$teams['team1']['name']} <strong>VS</strong>  {$teams['team2']['name']} </h2>
                            <div class='d-block d-sm-block d-md-none'>
                                <h2> {$teams['team1']['acronimo']} <strong>VS</strong>  {$teams['team2']['acronimo']} </h2>
                            </div>
                            <p>$fecha $hora</p>
                        </div>
                    </div>
                    <div class='hero_btn'>
                        <a href='$permalink' class='btn_2'>".__('Ver pronóstico','jbetting')."</a>
                    </div>
                </div>
                <div class='col-lg-5 hero_team_col'>
                    <div class='team_box'>
                        <img width='60px' height='60px' src='{$teams['team1']['logo']}' class='img-fluid'  alt='{$teams['team1']['name']}'>
                        <div class='w-100'>
                            <p>vs</p>
                        </div>
                        <img width='60px' height='60px' src='{$teams['team2']['logo']}' class='img-fluid'  alt='{$teams['team2']['name']}'>
                    </div>                            
                            <div class='team_box mt_25'>
                                <p> $p1 </p>
                                <div class='w-100'>
                                    <p> $x </p>
                                </div>
                                <p> $p2 </p>
                            </div>
                    

                </div>
            </div>
        </div>  
    </div>";

endif; 