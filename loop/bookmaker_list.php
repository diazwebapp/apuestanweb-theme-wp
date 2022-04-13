<?php

$image_att = carbon_get_post_meta(get_the_ID(), 'mini_img');
if($image_att):
    $image_png = wp_get_attachment_url($image_att);
else:
    $image_png = get_template_directory_uri() . '/assets/img/logo.svg';
endif;
$rating_ceil = ceil(carbon_get_post_meta(get_the_ID(), 'rating'));
$ref = carbon_get_post_meta(get_the_ID(), 'ref');
$permalink = get_the_permalink();
$num_comments = get_comments_number();
$bonus = carbon_get_post_meta(get_the_ID(), 'bonus');
$title = get_the_title(get_the_ID());   
$stars = draw_rating($rating_ceil);  
echo "<div class='col-lg-3 col-6 mt_30'>
    <div class='tbox'>
        <img style='height:30px;width:auto;object-fit:contain;' src='$image_png' class='img-fluid' alt='$title  title='$title'>
        <div class='rating mt_15'> ";
            echo $stars; 
echo "        </div>
        <p class='mt_30' $bonus </p>
        <a href='$ref' class='button mt_25 w-100'>Haz tu apuesta</a>
        <p class='sub_title mt_20'><a href=' $permalink ' >Revision </a></p>
    </div>
</div>";