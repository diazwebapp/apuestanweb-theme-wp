<?php

$image_att = carbon_get_post_meta($args["bookmaker"]->ID, 'logo');
if($image_att):
    $image_png = wp_get_attachment_url($image_att);
else:
    $image_png = get_template_directory_uri() . '/assets/img/logo.svg';
endif;
$rating_ceil = ceil(carbon_get_post_meta($args["bookmaker"]->ID, 'rating'));
$ref = carbon_get_post_meta($args["bookmaker"]->ID, 'ref');
$permalink = get_the_permalink($args["bookmaker"]->ID);
$num_comments = get_comments_number();
$bonus_slogan = carbon_get_post_meta($args["bookmaker"]->ID, 'bonus_slogan') ? carbon_get_post_meta($args["bookmaker"]->ID, 'bonus_slogan') : '';
$title = get_the_title($args["bookmaker"]->ID);   
$stars = draw_rating($rating_ceil);


    echo "<div class='owl-item' style='width: 142.5px; margin-right: 15px;'> ";
        echo "<div class='tbox'>
            <img style='height:30px;width:auto;object-fit:contain;' src='$image_png' class='timg img-fluid' alt='$title  title='$title'>
            <div class='rating mt_15'> ";
                echo $stars; 
        echo "        </div>
            <p class='mt_30'>$bonus_slogan</p>
            <a href='{$ref}' class='button mt_25 w-100'>apostar</a>
            <p class='sub_title mt_20'><a href=' $permalink ' >Revision </a></p>
        </div>";
    echo "</div>";
