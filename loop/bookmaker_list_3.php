<?php

$image_att = carbon_get_post_meta($args["post"]->ID, 'mini_img');
if($image_att):
    $image_png = wp_get_attachment_url($image_att);
else:
    $image_png = get_template_directory_uri() . '/assets/img/logo.svg';
endif;

$rating_ceil = ceil(carbon_get_post_meta($args["post"]->ID, 'rating'));
$ref = carbon_get_post_meta($args["post"]->ID, 'ref');
$permalink = get_the_permalink();
$num_comments = get_comments_number();
$bonus_slogan = carbon_get_post_meta($args["post"]->ID, 'bonus_slogan') ? carbon_get_post_meta($args["post"]->ID, 'bonus_slogan') : 'n/a';
$bonus_amount = carbon_get_post_meta($args["post"]->ID, 'bonus_amount') ? carbon_get_post_meta($args["post"]->ID, 'bonus_amount') : 'n/a';
$bonus_amount_table = carbon_get_post_meta($args["post"]->ID, 'bonus_amount_table') ? carbon_get_post_meta($args["post"]->ID, 'bonus_amount_table') : 'n/a';
$title = get_the_title($args["post"]->ID);             
$stars = draw_rating($rating_ceil); 

$location = json_decode(GEOLOCATION);
$aw_system_country = aw_select_country(["country_code"=>$location->country_code]);
$bk_countries = aw_select_relate_bookakers($aw_system_country->id, []);

echo "<div class='col-4'>
                <div class='bonus_box'>
                    <div class='number_text' id='count_bk_model_3'></div>
                    <div class='bonus_top'>
                        <div class='d-flex align-items-center justify-content-between'>
                            <img src='$image_png' alt=''>
                            <div class='rating'>";
                                echo $stars;
            echo "          </div>
                        </div>
                        <p>$bonus_slogan</p>
                    </div>
                    <div class='bonus_bottom'>
                        <a href='$permalink' ><p>Review</p></a>
                        <a href='$ref' class='button'>Obtener bono</a>
                    </div>
                </div>
            </div>";
        