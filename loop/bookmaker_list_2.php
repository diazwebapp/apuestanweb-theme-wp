<?php

$image_att = carbon_get_post_meta($args["post"]->ID, 'logo');
if($image_att):
    $image_png = wp_get_attachment_url($image_att);
else:
    $image_png = get_template_directory_uri() . '/assets/img/logo.svg';
endif;
$bg_att = carbon_get_post_meta($args["post"]->ID, 'background-color');

$rating_ceil = ceil(carbon_get_post_meta($args["post"]->ID, 'rating'));
$ref = carbon_get_post_meta($args["post"]->ID, 'ref');
$permalink = get_the_permalink();
$bonus_slogan = carbon_get_post_meta($args["post"]->ID, 'bonus_slogan') ? carbon_get_post_meta($args["post"]->ID, 'bonus_slogan') : 'n/a';
$feactures = carbon_get_post_meta($args["post"]->ID, 'feactures');
$html_feactures = "";
if(!empty($feactures) and count($feactures) > 0):
    foreach($feactures as $feacture):
        $html_feactures .= '<p>- '.$feacture['feacture'].'</p>' ;
    endforeach; 
endif;

$stars = draw_rating($rating_ceil);
$title = get_the_title($args["post"]->ID);             

echo "<div class='col-lg-4 col-6 mt_30'> ";
echo "<div class='tbox'>
<div>
    <img style='height:30px;width:auto;object-fit:contain;' src='$image_png' class='timg img-fluid' alt='$title'  title='$title'>
</div>
    <div class='rating mt_15'> ";
        echo $stars; 
echo "</div>
    <p class='mt_30'>$bonus_slogan</p>
    <a href='{$ref}' class='button mt_25 w-100'>apostar</a>
    <p class='sub_title mt_20'><a href=' $permalink ' >Revision </a></p>
</div>";
echo "</div>";