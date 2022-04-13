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
$num_comments = get_comments_number();
$bonus = carbon_get_post_meta(get_the_ID(), 'bonus') ? carbon_get_post_meta(get_the_ID(), 'bonus') : 'n/a';
$bonus_sum = carbon_get_post_meta(get_the_ID(), 'bonus_sum') ? carbon_get_post_meta(get_the_ID(), 'bonus_sum') : 'n/a';
$bonus_sum_table = carbon_get_post_meta(get_the_ID(), 'bonus_sum_table') ? carbon_get_post_meta(get_the_ID(), 'bonus_sum_table') : 'n/a';
$title = get_the_title(get_the_ID());             
$stars = draw_rating($rating_ceil); 

echo "<div class='col-4'>
    <div class='bonus_box'>
        <div class='number_text'>1</div>
        <div class='bonus_top'>
            <div class='d-flex align-items-center justify-content-between'>
                <img src='$image_png' alt=''>
                <div class='rating'>";
                    echo $stars;
echo "          </div>
            </div>
            <p>$bonus</p>
        </div>
        <div class='bonus_bottom'>
            <a href='$permalink' ><p>Review</p></a>
            <a href='$ref' class='button'>Obtener bono</a>
        </div>
    </div>
</div>";