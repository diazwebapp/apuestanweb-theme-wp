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

        $args['meta_key']  = 'rank';
        $args['orderby']   = 'meta_value_num';
        $args['order']     = 'DESC';
        $args['number']     = $limit;
        $users = new WP_User_Query($args);
        
		if ($users) {
			echo '<div class="col-lg-12 col-md-6">
                    <div class="side_box mt_30">
                        <div class="box_header">' . $title . '</div>                    
                        <div class="box_body">
                        ';
			foreach ($users->get_results() as $key => $user) {
                $acerted = get_the_author_meta("forecast_acerted", $user->ID );
                $failed = get_the_author_meta("forecast_failed", $user->ID );
                $nulled = get_the_author_meta("forecast_nulled", $user->ID );
                $rank = get_the_author_meta("rank", $user->ID );
                $latest = floatval($acerted) + floatval($failed) + floatval($nulled);
                $display_name = get_the_author_meta("display_name", $user->ID );
                $avatar= get_avatar_url($user->ID);
                $key++;
                $link = PERMALINK_PROFILE.'?profile='.$user->ID;
                $flechita_indicadora = "";
                $flechita_up = '<i class="fas fa-angle-up"></i>';
                $flechita_down = '<i class="fas fa-angle-down"></i>';
                if(floatval($acerted) > floatval($failed)):
                    $flechita_indicadora = $flechita_up;
                endif;
                if(floatval($acerted) > floatval($failed)):
                    $flechita_indicadora = $flechita_up;
                endif;
                if(floatval($acerted) < floatval($failed)):
                    $flechita_indicadora = $flechita_down;
                endif;
                echo "<div class='top_box v2'>
                        <a href='$link' class='d-flex align-items-center justify-content-between'>
                            <div class='top_serial'>
                                <span class='serial'>{$key}</span>
                                <img src='$avatar' class='img-fluid'>
                            </div>
                            <div class='text_box'>
                                <h4>$display_name</h4>
                                <div class='statswg'>  
                                    <table class='table'>
                                        <thead>
                                            <tr>                                   
                                            <th scope='col'>W-L</th>
                                            <th scope='col'>Profit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr> 
                                                <td>$flechita_indicadora $acerted - $failed</td>
                                                <td>$$rank</td>
                                            </tr>
                                            <tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </a>
                        
                    </div>";
            }
            
			echo '<h3>Ultimos 10 picks</h3></div> </div></div>';
		} else {
			echo 'Nothing found!';
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

function aw_register_widget_authors() {
    register_widget( 'w_authors' );
    }
    add_action( 'widgets_init', 'aw_register_widget_authors' );
    
?>