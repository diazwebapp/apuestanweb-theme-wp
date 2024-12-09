<?php
function shortcode_slide($atts)
{
    extract(shortcode_atts(array(
        'num' => 4,
        'model' => 1,
        'date' => false
    ), $atts));
    
    $ret = '';
    $geolocation = json_decode($_SESSION["geolocation"]);
    wp_reset_query();
    $alt_logo = get_template_directory_uri() . '/assets/img/logo2.svg';
    $args = array(
        'post_type' => 'forecast',
        'posts_per_page' => $num,
    );
    if ($date and $date != "") {
        if($date == 'hoy')
            $current_date = date('Y-m-d');
        if($date == 'ayer')
            $current_date = date('Y-m-d', strtotime('-1 days'));
        if($date == 'mañana')
            $current_date = date('Y-m-d',strtotime('+1 days'));
            
        $args['meta_query']   = [
                [
                    'key' => '_data',
                    'compare' => '==',
                    'value' => $current_date,
                    'type' => 'DATE'
                ]
            ];
    }
    $query = new WP_Query($args);
    if ($query->have_posts()) { 
        if($model==1):
            $ret = "<div class='container mt-5 home_container'>
                <div class='owl-carousel slider owl-loaded owl-drag' >
                    <div class='owl-stage-outer' >
                        <div class='owl-stage' >";
                            while ($query->have_posts()):
                                $query->the_post();
                                $ret .= load_template_part("loop/slide_$model",null,[
                                    "timezone" => isset($geolocation) ? $geolocation->timezone : null
                                ]);
                            endwhile;
            $ret .="        </div>
                    </div>
                </div>
            </div>";
        endif;
        if($model == 2): 
            $ret =  '<div class="slider__area">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="slider__wrap">
                                        <div class="slider__top">
                                            <div class="slider__live__logo">
                                                <a href="#"><img src="'.$alt_logo.'" alt=""></a>
                                            </div>
                                            <div class="slider__live__menu">
                                                <ul>
                                                    <li><a href="#">Partidos</a></li>
                                                    <li><a href="#" >Live</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="slider__inner">
                                            <div class="slider__active owl-carousel">';
                                            while ($query->have_posts()):
                                                $query->the_post();
                                                $ret .= load_template_part("loop/slide_$model");
                                            endwhile;
                                                
            $ret .='                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         </div>
                    </div>';
        endif;
    } else {
        echo do_shortcode('[banner]');
    }
    wp_reset_postdata( );
    return $ret;
}


add_shortcode('slide_forecasts', 'shortcode_slide');

// Cargar owl.carousel condicionalmente
function load_owl_carousel_if_shortcode_exists() {
    global $post;
    if (isset($post) && is_a($post, 'WP_Post') && (has_shortcode($post->post_content, 'slide_forecasts'))) {
        wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/jquery-3.6.0.min.js', array(), '3.6.0', false);
        wp_enqueue_script('owl.carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array(), null, true);
    }
}
add_action('wp_enqueue_scripts', 'load_owl_carousel_if_shortcode_exists');

// Asegurarse de que el CSS solo se cargue si es necesario
function load_slide_forecasts_styles() {
    global $post;
    if (isset($post) && is_a($post, 'WP_Post') && (has_shortcode($post->post_content, 'forecasts'))) {
        wp_enqueue_style('owl.carousel', get_template_directory_uri() . '/assets/css/owl.carousel.min.css', array(), null);
    }
}
add_action('wp_enqueue_scripts', 'load_slide_forecasts_styles');