<?php

$image_att = carbon_get_post_meta(get_the_ID(), 'mini_img');
if($image_att):
    $image_png = wp_get_attachment_url($image_att);
else:
    $image_png = get_template_directory_uri() . '/assets/img/logo.svg';
endif;
$bg_att = carbon_get_post_meta(get_the_ID(), 'wbg');
if($bg_att):
    $bg_png = wp_get_attachment_url($bg_att);
else:
    $bg_png = get_template_directory_uri() . '/assets/img/banner2.png';
endif;
$rating_ceil = ceil(carbon_get_post_meta(get_the_ID(), 'rating'));
$ref = carbon_get_post_meta(get_the_ID(), 'ref');
$permalink = get_the_permalink();
$bonus = carbon_get_post_meta(get_the_ID(), 'bonus_slogan') ? carbon_get_post_meta(get_the_ID(), 'bonus_slogan') : 'n/a';
$bonus_amount = carbon_get_post_meta(get_the_ID(), 'bonus_amount') ? carbon_get_post_meta(get_the_ID(), 'bonus_amount') : 'n/a';
$feactures = carbon_get_post_meta(get_the_ID(), 'feactures');
$html_feactures = "";
if(!empty($feactures) and count($feactures) > 0):
    foreach($feactures as $feacture):
        $html_feactures .= '<p>- '.$feacture['feacture'].'</p>' ;
    endforeach; 
endif;

$title = get_the_title(get_the_ID());             
$location = json_decode(GEOLOCATION);
$aw_system_country = aw_select_country(["country_code"=>$location->country_code]);
$bk_countries = aw_select_relate_bookakers($aw_system_country->id, []);
var_dump($bk_countries);
if(count($bk_countries) > 0):
    foreach($bk_countries as $country):
        
            echo "<div class='bookmaker_box_wrapper mt_30'>
                <div class='bookmaker_left_content'>
                    <div class='d-md-none d-block'>
                        <div class='bookamker_rating_box'>
                            <p> $rating_ceil </p>
                            <div class='bookmaker_rating_list rating '>";
                            echo draw_rating($rating_ceil); 
                echo "      </div>
                        </div>
                    </div>
                    <div class='bookmaker_logo_box' style='background-image:url( $bg_png );background-size:cover;' >
                        <img src=' $image_png ' class='img-fluid' alt=' $title '>
                    </div>
                    <div class='bookmaker_left_text'>
                        <div class='bookmaker_left_heading'>
                            <h4> $title </h4>
                            <div class='bookmaker_left_check'>
                                <img src='img/s21.svg' class='img-fluid' alt=''>
                                <p>{$country['bonus_slogan']}</p>
                            </div>
                        </div>
                        <div class='bookmaker_left_last_text'>
                            $html_feactures
                        </div>
                    </div>
                </div>
                <div class='bookmaker_right_content'>
                    <div class='d-md-block d-none'>
                        <div class='bookamker_rating_box'>
                            <p> $rating_ceil </p>
                            <div class='bookmaker_rating_list rating '>";
                            echo draw_rating($rating_ceil); 
            echo                "</div>
                        </div>
                    </div>
                    <div class='bookmaker_right_btn'>
                        <a href='{$country['ref']}' class='btn_2'>Quiero Apostar</a>
                    </div>
                </div>
            </div>";
       
    endforeach;
endif;
