<?php

class w_authors extends WP_Widget {

    function __construct()
    {
        parent::__construct(
            'top_authors',
            __('TOP AUTHORS', 'jbetting')
        );
    }
    public function widget( $args, $instance ) {
        $title = isset($instance['title']) ? $instance['title'] : __( 'Top Pronosticadores', 'jbetting' );
        $limit = isset($instance['limit']) ? $instance['limit'] : 10;
        $forecasts_limit = isset($instance['forecasts_limit']) ? $instance['forecasts_limit'] : 10;

        $args['meta_key']  = 'rank';
        $args['orderby']   = 'meta_value_num';
        $args['order']     = 'DESC';
        $args['role__in'] = ['administrator', 'author'];
        $args['number']     = $limit;
        $users = new WP_User_Query($args);
        
		if ($users) {
			echo '<div class="col-lg-12 col-md-6">
                    <div class="side_box mt-5">
                        <div class="box_header">' . $title . '</div>                    
                        <div class="box_body">
                        ';
			foreach ($users->get_results() as $key => $user) {
                $stats = get_user_stats($user->ID,'=',[],$forecasts_limit);
                $acerted = $stats["acertados"];
                $failed = $stats["fallidos"];
                $rank = $stats["tvalue"];
                $display_name = get_the_author_meta("display_name", $user->ID );
                $avatar= get_the_author_meta( 'profile_image',$user->ID );
                $key++;
                $link = get_author_posts_url( $user->ID);
                $flechita_indicadora = "";
                $flechita_up = '<span class="dropdown-toggle dropup-toggle dropdown-toggle-win" ></span>';
                $flechita_down = '<span class="dropdown-toggle dropdown-toggle-loss"></span>';
                
                if(floatval($acerted) > floatval($failed)):
                    $flechita_indicadora = $flechita_up;
                endif;
                if(floatval($acerted) > floatval($failed)):
                    $flechita_indicadora = $flechita_up;
                endif;
                if(floatval($acerted) < floatval($failed)):
                    $flechita_indicadora = $flechita_down;
                endif;
                echo "<div class='top_box mb-2'>
                        <a href='$link' class='row'>
                            <div class='top_serial col-12 mt-3'>
                                <span class='serial'>{$key}</span>
                                <img width='40' height='40' src='$avatar' class='rounded-circle object-fit-contain mx-2'>
                                <b class='text-truncate text-uppercase'>$display_name</b>
                            </div>
                            <div class='text_box col-12'>
                                <div class='text-center'>  
                                    <table class='table m-0'>
                                        <thead>
                                            <tr>                                   
                                            <th scope='col'><small> W - L </small></th>
                                            <th scope='col'><small> PROFIT </small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr> 
                                                <td>$flechita_indicadora <small>$acerted - $failed</small></td>
                                                <td><small>$$rank</small>
                                            </tr>
                                            <tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </a>
                        
                    </div>";
            }
            
			echo '<b class="mt-3" >Ultimos '.$forecasts_limit.' picks</b></div> </div></div>';
		} else {
			echo 'Nothing found!';
		}
	}
    
    function update($new_instance, $old_instance){
        // Función de guardado de opciones
        $instance = $old_instance;
        $instance["title"] = strip_tags($new_instance["title"]);
        $instance["limit"] = strip_tags($new_instance["limit"]);
        $instance["forecasts_limit"] = strip_tags($new_instance["forecasts_limit"]);
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
         <p>
            <label for="<?php echo $this->get_field_id('forecasts_limit'); ?>">limite de pronosticos del Widget</label>
            <input class="widefat" id="<?php echo $this->get_field_id('forecasts_limit'); ?>" name="<?php echo $this->get_field_name('forecasts_limit'); ?>" type="text" value="<?php echo esc_attr($instance["forecasts_limit"]); ?>" />
         </p>
         <?php
    }
}

function aw_register_widget_authors() {
    register_widget( 'w_authors' );
    }
    add_action( 'widgets_init', 'aw_register_widget_authors' );
    
?>