<?php
$params = get_query_var( 'params' );
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
$bonus = carbon_get_post_meta(get_the_ID(), 'bonus_slogan') ? carbon_get_post_meta(get_the_ID(), 'bonus_slogan') : 'n/a';
$bonus_amount = carbon_get_post_meta(get_the_ID(), 'bonus_amount') ? carbon_get_post_meta(get_the_ID(), 'bonus_amount') : 'n/a';
$bonus_amount_table = carbon_get_post_meta(get_the_ID(), 'bonus_amount_table') ? carbon_get_post_meta(get_the_ID(), 'bonus_amount_table') : 'n/a';
$title = get_the_title(get_the_ID());             
$stars = draw_rating($rating_ceil); 

$location = json_decode(GEOLOCATION);
$aw_system_country = aw_select_country(["country_code"=>$location->country_code]);
$bk_countries = aw_select_relate_bookakers($aw_system_country->id, []);

if(count($bk_countries) > 0):
    foreach($bk_countries as $country):
        
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
                        <p>{$country['bonus_slogan']}</p>
                    </div>
                    <div class='bonus_bottom'>
                        <a href='$permalink' ><p>Review</p></a>
                        <a href='{$country['ref']}' class='button'>Obtener bono</a>
                    </div>
                </div>
            </div>";
        
    endforeach;
endif;