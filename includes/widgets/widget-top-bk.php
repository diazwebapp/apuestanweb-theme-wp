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
        $title = isset($instance['title']) ? __( $instance['title'], 'jbetting' ) : esc_html__( 'TOP bookmaker', 'jbetting' );
        $limit = !empty($instance['limit']) ? $instance['limit'] : 10;
        $location = json_decode($_SESSION["geolocation"]);
        $aw_system_location = aw_select_country(["country_code"=>$location->country_code]);
        $args = ["post_type" => "bk","posts_per_page" => $limit];
        $args['order'] = 'DESC';
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = '_rating';
        $query = new WP_Query($args);
        
        $bookmakers = [];
        if(!isset($aw_system_location)):
            
            foreach ($query->posts as $key => $bookmaker):
                $exists = aw_detect_bookmaker_on_country(1,$bookmaker->ID);
                if($exists):
                    $bookmakers[] = $bookmaker;
                endif;
            endforeach;
        else:
            
            if($query->posts):
                foreach ($query->posts as $key => $bookmaker):
                    $exists = aw_detect_bookmaker_on_country($aw_system_location->id,$bookmaker->ID);
                    if($exists):
                        $bookmakers[] = $bookmaker;
                    endif;
                endforeach;
            endif;
        endif;

        if ($bookmakers and count($bookmakers) > 0) {
            echo '<div class="col-lg-12 col-md-6">
                    <div class="side_box mt-5">
                        <div class="box_header">' . $title . '</div>
                        <div class="box_body">
                        ';
            foreach ($bookmakers as $key => $bookmaker):
                $key++;
                $image_att = carbon_get_post_meta($bookmaker->ID, 'logo_2x1');
                $mime_type = get_post_mime_type($image_att);
                $image_png = wp_get_attachment_url($image_att);
                if($mime_type !== 'image/svg+xml'){
                    $image_png = aq_resize($image_png, 80, 25, true, true, true);
                }

                if (!$image_png) { $image_png = get_template_directory_uri() . '/assets/img/logo2.svg'; }
                $rating_float = carbon_get_post_meta($bookmaker->ID, 'rating');
                $ref = "";
                $color = (carbon_get_post_meta($bookmaker->ID, 'background-color') ?carbon_get_post_meta($bookmaker->ID, 'background-color') : "black");

                $bonuses = carbon_get_post_meta($bookmaker->ID, 'country_bonus');
                if(isset($bonuses) and count($bonuses) > 0):
                    foreach($bonuses as $bonus_data):
                        if(strtoupper($bonus_data["country_code"]) == strtoupper($aw_system_location->country_code)):
                            $ref = $bonus_data["country_bonus_ref_link"];
                        endif;
                    endforeach;
                endif;
                
                
                echo '<div class="top_box mb-2">
                        <div class="row m-0 pt-2">
                            <div class="col-3">
                                <span class="serial">'.$key.'</span>
                            </div>
                            <div class="col-6" style="background:'.$color.';border-radius:.3rem;">
                                <img src="'.$image_png.'" width="80" height="25" class="px-1" style="object-fit:contain;" alt="'.$bookmaker->post_title.'">
                            </div>
                            <div class="col-3 d-flex">
                                <span>'.$rating_float.'</span>
                                <b class="text-warning" >★</b>
                            </div>
                            <div class="my-2 col-12">
                                <a href="'.get_the_permalink($bookmaker->ID).'" class="btn btn-secondary btn-sm" title="Conoce mas de '.$bookmaker->post_title.'">Revision</a>
                                <a rel="nofollow noopener noreferrer" target="_blank" href="'.$ref.'" class="btn btn-primary btn-sm" title="Apostar con '.$bookmaker->post_title.'">Apostar</a>
                            </div>
                        </div>
                    </div>';
            endforeach;
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