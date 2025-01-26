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
                    $sport['name'] = '';
                    if ($sport_term) {
                        foreach ( $sport_term as $item ) {
                            if($item->parent == 0){
                                $sport['name'] = $item->name;
                            }
                        }
                    }

                    echo "<div class='top_box mb-2 f-widget py-1 px-2'>
                            
                                <a href='$permalink' class='row mx-0 my-2' title='Leer pronostico {$teams['team1']['name']} vs {$teams['team2']['name']}'>
                                    <div class='col-3 d-flex align-items-center px-0'>
                                        <small class='text-truncate m-auto text-uppercase text-dark'>{$sport['name']}</small>                           
                                    </div>
                            
                                    <div class='col-8 px-0'>
                                        <div class='pb-2 d-flex flex-nowrap align-items-center'>
                                            <img loading='lazy' width='30px' class='mx-2 mx-xl-3' height='30px' src='{$teams['team1']['logo']}' alt='{$teams['team1']['name']}'>
                                            <small class='text-dark'>{$teams['team1']['name']}</small>
                                        </div>
                                        <div class='d-flex flex-nowrap align-items-center'>
                                            <img loading='lazy' width='30px' class='mx-2 mx-xl-3' height='30px' src='{$teams['team2']['logo']}' alt='{$teams['team2']['name']}' >
                                            <small class='text-dark'>{$teams['team2']['name']}</small>
                                        </div>
                                    </div>
                                    <div class='col-1 d-flex align-items-center px-0'>
                                        <i class='angle-right'>
                                            <svg width='20px' height='20px' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                            <path fill-rule='evenodd' clip-rule='evenodd' d='M12 7C12.2652 7 12.5196 7.10536 12.7071 7.29289L19.7071 14.2929C20.0976 14.6834 20.0976 15.3166 19.7071 15.7071C19.3166 16.0976 18.6834 16.0976 18.2929 15.7071L12 9.41421L5.70711 15.7071C5.31658 16.0976 4.68342 16.0976 4.29289 15.7071C3.90237 15.3166 3.90237 14.6834 4.29289 14.2929L11.2929 7.29289C11.4804 7.10536 11.7348 7 12 7Z' fill='#007bff'/>
                                            </svg>
                                        </i>
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