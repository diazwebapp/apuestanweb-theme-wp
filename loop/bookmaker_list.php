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
$bonus = carbon_get_post_meta(get_the_ID(), 'bonus_slogan');
$title = get_the_title(get_the_ID());   
$stars = draw_rating($rating_ceil);  

$location = json_decode(GEOLOCATION);
$aw_system_country = aw_select_country(["country_code"=>$location->country_code]);
$bk_countries = aw_select_relate_bookakers($aw_system_country->id, []);

if(count($bk_countries) > 0):
    foreach($bk_countries as $country):
        if($country['country_code'] === $location->country_code):
            echo "<div class='col-lg-3 col-6 mt_30'>
                <div class='tbox'>
                    <img style='height:30px;width:auto;object-fit:contain;' src='$image_png' class='img-fluid' alt='$title  title='$title'>
                    <div class='rating mt_15'> ";
                        echo $stars; 
            echo "        </div>
                    <p class='mt_30'> {$country['bonus_slogan']} </p>
                    <a href='{$country['ref']}' class='button mt_25 w-100'>Haz tu apuesta</a>
                    <p class='sub_title mt_20'><a href=' $permalink ' >Revision </a></p>
                </div>
            </div>";
        else:
            echo "";
        endif;
    endforeach;
endif;
