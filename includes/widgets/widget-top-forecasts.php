<?php

class top_forecasts extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'top_forecast',
            __('TOP FORECAST', 'jbetting')
        );
    }

    private $widget_fields = array();

    public function widget($args, $instance)
    {
        $list = isset($instance['list']) ? $instance['list'] : false;
        $title = isset($instance['title']) ? $instance['title'] :false;


        if (!$title) {
            $title = __('TOP FORECAST', 'jbetting');
        }
        
        wp_reset_query();
            $args = array(
                'post_type' => 'forecast',
                'posts_per_page' => 4,
                'no_found_rows' => true,
                'post_status' => 'publish'
            );
            $query = new WP_Query($args);
            if ($query):
                echo "<div class='col-lg-12 col-md-6'> 
                        <div class='side_box mt_30'>
                            <div class='box_header'>
                                $title
                            </div>
                            <div class='box_body'>";
                while ($query->have_posts()) : $query->the_post();
                    $id = get_The_ID();
                    $permalink = get_the_permalink($id);
                    $time = carbon_get_post_meta($id, 'data');
                    $link = carbon_get_post_meta($id, 'link');
                    $prediction = carbon_get_post_meta($id, 'prediction');

                    
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

                    echo "<a href='$permalink' class='top_box top_box3'>
                            <div class='top_box3_left_content'>
                                <div class='top_box3_img'>
                                    <img width='14' height='14' src='{$teams['team1']['logo']}' class='img-fluid' alt='{$teams['team1']['name']}'>
                                    <p>{$teams['team1']['name']}</p>
                                </div>
                                <div class='top_box3_img top_box3_img2'>
                                    <img width='14' height='14' src='{$teams['team2']['logo']}' class='img-fluid' alt='{$teams['team2']['name']}' >
                                    <p>{$teams['team2']['name']}</p>
                                </div>
                            </div>
                            
                            <div class='top_box3_right_content league_box1'>
                                <i class='{$sport['class']}' ></i>
                                {$sport['name']}
                            </div>
                       </a> ";
                endwhile;
                echo "</div> </div> </div>";
            endif;
        }

    }

function register_new_widget1()
{
    register_widget('top_forecasts');
}

add_action('widgets_init', 'register_new_widget1');
wp_reset_query();