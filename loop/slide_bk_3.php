<?php

$image_att = carbon_get_post_meta($args["bookmaker"]->ID, 'logo');
if($image_att):
    $image_png = wp_get_attachment_url($image_att);
else:
    $image_png = get_template_directory_uri() . '/assets/img/logo.svg';
endif;
$bg_att = carbon_get_post_meta($args["bookmaker"]->ID, 'background-color');

$rating_float = carbon_get_post_meta($args["bookmaker"]->ID, 'rating');
$rating_ceil = floor($rating_float);

$permalink = get_the_permalink($args["bookmaker"]->ID);
$feactures = carbon_get_post_meta($args["bookmaker"]->ID, 'feactures');
$color = carbon_get_post_meta($args["bookmaker"]->ID, 'background-color');

$html_feactures = "";
if(!empty($feactures) and count($feactures) > 0):
    foreach($feactures as $feacture):
        $html_feactures .= '<p>- '.$feacture['feacture'].'</p>' ;
    endforeach; 
endif;

$stars = draw_rating($rating_ceil);
$title = get_the_title($args["bookmaker"]->ID);             

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

echo "<div class='col-lg-3 col-6 mt_30'> ";
echo "<div class='tbox'>
<div>
    <img style='height:30px;width:16rem;object-fit:contain;background:$color;padding: 6px;border-radius: 6px;' src='$image_png' class='timg img-fluid' alt='$title'  title='$title'>
</div>
    <div class='rating mt_15'> ";
        echo $stars; 
echo "</div>
    <p class='h-static mt_30 '>{$bonus["country_bonus_slogan"]}</p>
    <a href='{$bonus["country_bonus_ref_link"]}' class='button mt_25 w-100' rel='nofollow noreferrer noopener' target='_blank'>apostar</a>
    <p class='sub_title mt_20'><a href=' $permalink ' >Revision </a></p>
</div>";
echo "</div>";