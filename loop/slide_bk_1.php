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

    echo "<div class='owl-item' style='width: 142.5px; margin-right: 15px;'> ";
        echo "<div class='tbox'>
        <div>
            <img style='height:30px;width:auto;object-fit:contain;' src='$image_png' class='timg img-fluid' alt='$title'  title='$title'>
        </div>
            <div class='rating mt_15'> ";
                echo $stars; 
        echo "        </div>
            <p class='mt_30'>{$bonus["country_bonus_slogan"]}</p>
            <a href='{$bonus["country_bonus_ref_link"]}' class='button mt_25 w-100' rel='nofollow'>apostar</a>
            <p class='sub_title mt_20'><a href=' $permalink ' >Revision </a></p>
        </div>";
    echo "</div>";
