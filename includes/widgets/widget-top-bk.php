<?php

class w_bookmakers extends WP_Widget{

    function __construct()
    {
        parent::__construct(
            'top_bookmakers',
            __('TOP BOOKMAKERS', 'jbetting')
        );
    }

    public function widget($args, $instance){
        $title = isset($instance['title']) ? __( $instance['title'], 'jbetting' ) : __( 'TOP bookmaker', 'jbetting' );
        $limit = isset($instance['limit']) ? $instance['limit'] : 10;

        wp_reset_query();
        $args = array(
            'post_type' => 'bk',
            'posts_per_page' => $limit,
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

    function update($new_instance, $old_instance){
        // Función de guardado de opciones
        $instance = $old_instance;
        $instance["title"] = strip_tags($new_instance["title"]);
        $instance["limit"] = strip_tags($new_instance["limit"]);
        // Repetimos esto para tantos campos como tengamos en el formulario.
        return $instance;
    }

    function form($instance){
        // Formulario de opciones del Widget, que aparece cuando añadimos el Widget a una Sidebar
        ?>
         <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title del Widget</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
         </p>
         <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>">Limit del Widget</label>
            <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo esc_attr($instance["limit"]); ?>" />
         </p>
         <?php
    }

}

function register_new_widget3(){
    register_widget('w_bookmakers');
}

add_action('widgets_init', 'register_new_widget3');

wp_reset_query();