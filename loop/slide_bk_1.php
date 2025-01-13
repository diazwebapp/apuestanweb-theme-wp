<?php

$image_att = carbon_get_post_meta($args["bookmaker"]->ID, 'logo');
if($image_att):
    $image_png = wp_get_attachment_url($image_att);
else:
    $image_png = get_template_directory_uri() . '/assets/img/logo.svg';
endif;
$rating_ceil = ceil(carbon_get_post_meta($args["bookmaker"]->ID, 'rating'));

$permalink = get_the_permalink($args["bookmaker"]->ID);
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

    echo "<div class='owl-item slide_bk_model_1'> ";
        echo "<div class='text-center'>
        
            <img src='$image_png' width='90' height='90' class='img-thumbnail mx-auto d-block' alt='$title'  title='$title'>
        
            <div class='rating text-center'> ";
                echo $stars; 
        echo "</div>
            <b class='my-1 text-center d-block'>{$bonus["country_bonus_slogan"]}</b>
            <a href='{$bonus["country_bonus_ref_link"]}' class='my-2 d-block btn btn-primary' rel='nofollow'>apostar</a>
            <a class='font-weight-bold text-center d-block' href=' $permalink ' >Revision</a>
        </div>";
    echo "</div>";
