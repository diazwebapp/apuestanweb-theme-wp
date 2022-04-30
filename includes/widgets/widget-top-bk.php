<?php

class top_bk extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'top_bk',
            __('TOP BOOKMAKERS', 'jbetting')
        );
    }

    private $widget_fields = array();

    public function widget($args, $instance)
    {
        $num = 4;
        $title = isset($instance['title']) ? $instance['title'] : __('Bookmakers', 'jbetting');

        wp_reset_query();
        $args = array(
            'post_type' => 'bk',
            'posts_per_page' => $num,
            'order' => 'DESC',
            'meta_key' => '_rating',
            'orderby' => 'meta_value_num',

        );

        $query = new WP_Query($args);
        if ($query->have_posts()) {
            $key = 0;
            echo '<div class="col-lg-12 col-md-6">
                    <div class="side_box mt_30">
                        <div class="box_header">' . $title . '</div>
                        <div class="box_body">
                        ';
            while ($query->have_posts()):
                
                $query->the_post();
                $image_att = carbon_get_post_meta(get_the_ID(), 'mini_img');
                $image_png = wp_get_attachment_url($image_att);
                $rating_ceil = ceil(carbon_get_post_meta(get_the_ID(), 'rating'));
                $bonus = carbon_get_post_meta(get_the_ID(), 'bonus_sum_table') ? carbon_get_post_meta(get_the_ID(), 'bonus_sum_table') : 'n/a';
                $ref = carbon_get_post_meta(get_the_ID(), 'ref');

                $bk_countries = carbon_get_post_meta(get_the_ID(),'countries');
                $location = json_decode(GEOLOCATION);
                if($location->success == true and $bk_countries and count($bk_countries) > 0):
                    foreach($bk_countries as $country):
                        if($country['country_code'] == $location->country_code):
                            $key++;
                            echo '<div class="top_box">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="top_serial">
                                            <span class="serial">'.$key.'</span>
                                            <img src="'.$image_png.'" class="img-fluid" alt="">
                                        </div>
                                        <div class="ratings">
                                            <span>'.$rating_ceil.'</span>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                    
                                    <div class="btn_groups">
                                        <a href="'.get_the_permalink().'" class="button">Revision</a>
                                        <a href="'.$country['ref'].'" class="button">Apostar</a>
                                    </div>
                                </div>';
                            else:
                                echo "";
                            endif;
                    endforeach;
                endif;
                if(!$location->success):
                    $key++;
                    echo '<div class="top_box">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="top_serial">
                                <span class="serial">'.$key.'</span>
                                <img src="'.$image_png.'" class="img-fluid" alt="">
                            </div>
                            <div class="ratings">
                                <span>'.$rating_ceil.'</span>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        
                        <div class="btn_groups">
                            <a href="'.get_the_permalink().'" class="button">Revision</a>
                            <a href="'.$ref.'" class="button">Apostar</a>
                        </div>
                    </div>';
                endif;
            endwhile;
            
            echo '</div> </div> </div>';
        } else {
            echo 'Nothing found';
        }


    }

}

function register_new_widget3()
{
    register_widget('top_bk');
}

add_action('widgets_init', 'register_new_widget3');
wp_reset_query();