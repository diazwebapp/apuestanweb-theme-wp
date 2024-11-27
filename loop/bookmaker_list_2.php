<?php

$image_att = carbon_get_post_meta($args["post"]->ID, 'logo');
if($image_att):
    $image_png = wp_get_attachment_url($image_att);
else:
    $image_png = get_template_directory_uri() . '/assets/img/logo.svg';
endif;
$bg_att = carbon_get_post_meta($args["post"]->ID, 'background-color');

$rating_ceil = floor(carbon_get_post_meta($args["post"]->ID, 'rating'));

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

$stars = draw_rating($rating_ceil);
$title = get_the_title($args["post"]->ID);             

echo "<div class='col-lg-3 col-6 mt-5'> ";
echo "<div class='tbox'>
<div>
    <img width='100' height='30' style='
    object-fit: contain;
    background: #000000;
    padding: 6px;
    border-radius: 6px;' src='$image_png' alt='$title'  title='$title'>
</div> 
    <div class='rating mt_15'> ";
        echo $stars; 
echo "</div>
    <p class='mt-5'>{$bonus["country_bonus_slogan"]}</p>
    <a href='{$bonus["country_bonus_ref_link"]}' class='btn btn-primary btn-lg mt-3 btn-block font-weight-bold' style='font-size:1.8rem;' rel='nofollow'>apostar</a>
    <p class='sub_title mt-3'><a href=' $permalink ' >Revision </a></p>
</div>";
echo "</div>";