<?php
// Slide background
$slide_bg = get_template_directory_uri() . '/assets/img/banner2.png';
$event_bg_att = carbon_get_post_meta(get_the_ID(), 'wbg');
$stadium = carbon_get_post_meta(get_the_ID(), 'stadium');
$event_bg = wp_get_attachment_url($event_bg_att);
if($event_bg)
    $slide_bg = $event_bg;

$time = carbon_get_post_meta(get_the_ID(), 'data');
$prediction = carbon_get_post_meta(get_the_ID(), 'prediction');
$link = carbon_get_post_meta(get_the_ID(), 'link');
$fecha = date('d M', strtotime($time));
$hora = date('g:i a', strtotime($time));
$permalink = get_the_permalink();
$cross_img = get_template_directory_uri(  ) . '/assets/img/cross.png';

if ($time) {
    $new_format_time = date('d.m.Y H:s', strtotime($time));
} else {
    $new_format_time = 'n/a';
}
$sport_term = wp_get_post_terms(get_the_ID(), 'league', array('fields' => 'all'));
$arr_sport = array();
if ($sport_term) {
    foreach ($sport_term as $item) {
        $arr_sport[] = '<a href="' . get_term_link($item, "league") . '>' . $item->name . '</a>';
        // Slide background optional
        if($item->parent == 0)
            $logo_sport_src = wp_get_attachment_url(carbon_get_term_meta($item->term_id, 'wbg'));
            if($logo_sport_src and !$event_bg)
                $slide_bg = $logo_sport_src;
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
echo "<div class='owl-item' >
        <div class='item' style='background-image:url( $slide_bg ); background-repeat:no-repeat;background-size:cover;'>
            <div class='row align-items-center'>
                <div class='col-lg-7 main_text'>
                    <p>Enfrentamiento</p>
                    <div class='media align-items-center'>
                        <div class='hero_team_logo_box'>
                            <div class='team_logo'>
                                <img style='width:40px;height:40px;' src=' {$teams['team1']['logo']} ' class='img-fluid' alt=' {$teams['team1']['name']} '>
                                <div class='flag' style='overflow:hidden;'>
                                    <img width='20' height='20' src=' {$teams['team1']['logo']} ' class='img-fluid' alt=' {$teams['team1']['name']} '>
                                </div>
                            </div>
                            <div class='cross_img d-lg-none d-block'>
                                <img src='$cross_img' class='img-fluid'>
                            </div>                                
                            <div class='team_logo'>
                                <img style='width:40px;height:40px;' src=' {$teams['team2']['logo']} ' class='img-fluid' alt=' {$teams['team2']['name']} '>
                                <div class='flag' style='overflow:hidden;'>
                                    <img width='20' height='20' src=' {$teams['team2']['logo']} ' class='img-fluid' alt=' {$teams['team2']['name']} '>
                                </div>
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
                        <a href='$permalink' class='btn_2'>".__('View forecast','jbetting')."</a>
                    </div>
                </div>
                <div class='col-lg-5 hero_team_col'>
                    <div class='team_box'>
                        <img  src='{$teams['team1']['logo']}' class='img-fluid'  alt='{$teams['team1']['name']}'>
                        <div class='w-100'>
                            <p>vs</p>
                        </div>
                        <img  src='{$teams['team2']['logo']}' class='img-fluid'  alt='{$teams['team2']['name']}'>
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