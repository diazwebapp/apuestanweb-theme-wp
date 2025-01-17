<?php

class W_Forecasts extends WP_Widget {

    function __construct()
    {
        parent::__construct(
            'top_forecast',
            __('TOP FORECAST', 'jbetting')
        );
    }

    function widget($args, $instance)
    {
        $title = isset($instance['title']) ? __( $instance['title'], 'jbetting' ) : __( 'TOP FORECAST', 'jbetting' );
        $limit = isset($instance['limit']) ? $instance['limit'] : 10;

        wp_reset_query();
            $args = array(
                'post_type' => 'forecast',
                'posts_per_page' => $limit,
                'no_found_rows' => true,
                'post_status' => 'publish'
            );
            $query = new WP_Query($args);
            if ($query):
                echo "<div class='col-lg-12 col-md-12'> 
                        <div class='side_box mt-5'>
                            <div class='box_header'>
                                $title
                            </div>
                            <div class='box_body'>";
                while ($query->have_posts()) : $query->the_post();
                    $id = get_The_ID();
                    $permalink = get_the_permalink($id);

                    
					//Equipos
                    $teams = get_forecast_teams($id,["w"=>24,"h"=>24]);
                    
                    //terms
                    $sport_term = wp_get_post_terms( $id, 'league', array( 'fields' => 'all' ) );
                    $sport['class'] = '' ;
                    $sport['name'] = '';
                    if ($sport_term) {
                        foreach ( $sport_term as $item ) {
                            if($item->parent == 0){
                                $sport['class'] = carbon_get_term_meta($item->term_id, 'fa_icon_class');
                                $sport['name'] = $item->name;
                            }
                        }
                    }

                    echo "<div class='top_box mb-2 f-widget py-1 px-2'>
                            
                                <a href='$permalink' class='row mx-0 my-2'>
                                    <div class='col-3 d-flex align-items-center px-0'>
                                        <small class='text-truncate m-auto text-uppercase text-dark'>{$sport['name']}</small>                           
                                    </div>
                            
                                    <div class='col-8 px-0'>
                                        <div class='pb-2 d-flex flex-nowrap align-items-center'>
                                            <img width='30px' class='mx-2 mx-xl-3' height='30px' src='{$teams['team1']['logo']}' alt='{$teams['team1']['name']}'>
                                            <small class='text-dark'>{$teams['team1']['name']}</small>
                                        </div>
                                        <div class='d-flex flex-nowrap align-items-center'>
                                            <img width='30px' class='mx-2 mx-xl-3' height='30px' src='{$teams['team2']['logo']}' alt='{$teams['team2']['name']}' >
                                            <small class='text-dark'>{$teams['team2']['name']}</small>
                                        </div>
                                    </div>
                                    <div class='col-1 d-flex align-items-center px-0'>
                                        <span class='text-primary m-auto font-weight-bold'>></span>
                                    </div>
                                </a>
                            
                       </div> ";
                endwhile;
                echo "</div> </div> </div>";
            endif;
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

    function update($new_instance, $old_instance){
        // Función de guardado de opciones
        $instance = $old_instance;
        $instance["title"] = strip_tags($new_instance["title"]);
        $instance["limit"] = strip_tags($new_instance["limit"]);
        // Repetimos esto para tantos campos como tengamos en el formulario.
        return $instance;
    }

}

function aw_register_widget_forecasts() {
    register_widget( 'W_Forecasts' );
    }
    add_action( 'widgets_init', 'aw_register_widget_forecasts' );
    
?>