<?php

class w_bonus_bookmakers extends WP_Widget{

    function __construct()
    {
        parent::__construct(
            'bonus_bookmakers',
            __('BONUSES', 'jbetting')
        );
    }

    public function widget($args, $instance){
        $title = isset($instance['title']) ? __( $instance['title'], 'jbetting' ) : __( 'TOP bookmaker', 'jbetting' );
        $limit = !empty($instance['limit']) ? $instance['limit'] : 10;
        $location = json_decode($_SESSION["geolocation"]);
        $aw_system_location = aw_select_country(["country_code"=>$location->country_code]);
        $args = ["post_type" => "bk","posts_per_page" => $limit];
        $args['order'] = 'DESC';
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = '_rating';
        $query = new WP_Query($args);
        $bookmakers = [];
        if(!isset($aw_system_location) and $query->posts):
            //$bookmakers = aw_select_relate_bookmakers(1,["random"=>true,"limit"=>$limit]);
            foreach ($query->posts as $key => $bookmaker):
                $exists = aw_detect_bookmaker_on_country(1,$bookmaker->ID);
                if($exists):
                    $bookmakers[] = $bookmaker;
                endif;
            endforeach;
        else:
            //$bookmakers = aw_select_relate_bookmakers($aw_system_location->id,["random"=>true,"limit"=>$limit]);
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
                    <div class="side_box mt_30">
                        <div class="box_header">' . $title . '</div>
                        <div class="box_body">
                        ';
            foreach ($bookmakers as $key => $bookmaker):
                $key++;
                $image_att = carbon_get_post_meta($bookmaker->ID, 'logo_2x1');
                $image_png = wp_get_attachment_url($image_att);
                $rating_ceil = ceil(carbon_get_post_meta($bookmaker->ID, 'rating'));
                $bonus = carbon_get_post_meta($bookmaker->ID, 'bonus_slogan') ? carbon_get_post_meta($bookmaker->ID, 'bonus_slogan') : 'n/a';
                $ref = carbon_get_post_meta($bookmaker->ID, 'ref');

                echo '<div class="top_box top_box2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="top_serial">
                                <img src="'.$image_png.'" width="80" height="20" class="img-fluid" alt="">
                            </div>
                            <div class="top_box_content">
									<p>'.$bonus.'</p>
									<a href="'.$ref.'" class="button">Obtener bono</a>
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

function register_new_widget4(){
    register_widget('w_bonus_bookmakers');
}

add_action('widgets_init', 'register_new_widget4');

wp_reset_query();