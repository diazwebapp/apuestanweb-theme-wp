<?php

$image_att = carbon_get_post_meta($args["post"]->ID, 'logo');
if($image_att):
    $image_png = wp_get_attachment_url($image_att);
else:
    $image_png = get_template_directory_uri() . '/assets/img/logo.svg';
endif;
$bg_att = carbon_get_post_meta($args["post"]->ID, 'background-color');

$rating_float = carbon_get_post_meta($args["post"]->ID, 'rating');
$rating_ceil = floor($rating_float);

$permalink = get_the_permalink($args["post"]->ID);

$bonuses = carbon_get_post_meta($args["post"]->ID, 'country_bonus');

$bonus["country_bonus_slogan"]="";
$bonus["country_bonus_amount"]="";
$bonus["country_bonus_ref_link"]="";
$bonus["country_code"]= "";

if(isset($bonuses) and count($bonuses) > 0):
    foreach($bonuses as $bonus_data):
        if(strtoupper($bonus_data["country_code"]) == strtoupper($args["country"]->country_code)):
            $bonus = $bonus_data;
        endif;
    endforeach;
endif;
$feactures = carbon_get_post_meta($args["post"]->ID, 'feactures');
$html_feactures = "";
if(!empty($feactures) and count($feactures) > 0):
    foreach($feactures as $feacture):
        $html_feactures .= '<p>- '.$feacture['feacture'].'</p>' ;
    endforeach; 
endif;

$title = get_the_title($args["post"]->ID);             

            echo "<div class='bookmaker_box_wrapper mt-5'>
                <div class='bookmaker_left_content'>
                    <div class='d-md-none d-block'>
                        <div class='bookamker_rating_box'>
                            <p> $rating_ceil </p>
                            <div class='bookmaker_rating_list rating '>";
                            echo draw_rating($rating_ceil); 
                echo "      </div>
                        </div>
                    </div>
                    <div class='bookmaker_logo_box' style='background:$bg_att;' >
                        <img src=' $image_png ' width='100' height='40' class='img-fluid' alt=' $title '>
                    </div>
                    <div class='bookmaker_left_text'>
                        <div class='bookmaker_left_heading'>
                        <a href='$permalink' ><h2> $title </h2></a>

                        </div>
                        <div class='bookmaker_left_last_text'>
                            $html_feactures
                        </div>
                    </div>
                </div>
                <div class='bookmaker_left_check mr-3'>
                    
                    <p>{$bonus["country_bonus_slogan"]}</p>
                </div>
                <div class='bookmaker_right_content ml-2'>
                    <div class='d-md-block d-none'>
                        <div class='bookamker_rating_box'>
                            <p> $rating_float </p>
                            <div class='bookmaker_rating_list rating '>";
                            echo draw_rating($rating_ceil); 
            echo                "</div>
                        </div>
                    </div>
                    <div class='bookmaker_right_btn'>
                        <a href='{$bonus["country_bonus_ref_link"]}' class='btn_2'>Reclamar bono</a>
                    </div>
                </div>
            </div>";
   
