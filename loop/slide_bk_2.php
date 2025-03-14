<?php

$image_att = carbon_get_post_meta($args["bookmaker"]->ID, 'logo_2x1');
if($image_att):
    $image_png = wp_get_attachment_url($image_att);
else:
    $image_png = get_template_directory_uri() . '/assets/img/logo.svg';
endif;

$rating_ceil = ceil(carbon_get_post_meta($args["bookmaker"]->ID, 'rating'));

$permalink = get_the_permalink();
$num_comments = get_comments_number();
$title = get_the_title($args["bookmaker"]->ID);             
$stars = draw_rating($rating_ceil); 

$bonuses = carbon_get_post_meta($args["bookmaker"]->ID, 'country_bonus');
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

echo "<div class='col-3'>
                <div class='bonus_box'>
                    <div class='number_text' id='count_bk_model_3'>{$args["position"]}</div>
                    <div class='bonus_top'>
                        <div class='d-flex align-items-center justify-content-between'>
                            <img width='70' height='25' src='$image_png' alt='$title'>
                            <div class='rating'>";
                                echo $stars;
            echo "          </div>
                        </div>
                        <p>{$bonus["country_bonus_slogan"]}</p>
                    </div>
                    <div class='bonus_bottom'>
                        <a href='$permalink' ><p>Review</p></a>
                        <a href='{$bonus["country_bonus_ref_link"]}' class='button'>Obtener bono</a>
                    </div>
                </div>
            </div>";
        