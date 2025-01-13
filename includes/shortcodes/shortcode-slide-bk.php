<?php
function shortcode_slide_bk($atts)
{
    extract(shortcode_atts(array(
        'title' => false,
        'slogan' => false,
        'model' => 1
    ), $atts));
    $ret = '';
    wp_reset_query();

    $args['post_type'] = 'bk';
    $args['posts_per_page'] = -1;
    $args['order'] = 'DESC';
    $args['orderby'] = 'meta_value_num';
    $args['meta_key'] = '_rating';
    
    $query = new WP_Query($args);
    $location = json_decode($_SESSION["geolocation"]);
    $aw_system_country = aw_select_country(["country_code"=>$location->country_code]);
    if ($query) {
        $new_bks = [];
        
        foreach ($query->posts as $bookmaker): 
            $exists = null;
            if(isset($aw_system_country->id)):
                $exists = aw_detect_bookmaker_on_country($aw_system_country->id,$bookmaker->ID);
            endif;
            if(isset($exists)):
                $new_bks[] = $bookmaker;
            endif;
        endforeach;
    }
    if (count($new_bks) > 0) { 
        $view_params = [];
        $ret =  "<div class='testimonial_area'>
                <div class='container'>
                    <div class='row small_gutter'>
                        <div class='col-12 text-center pb_30'>
                            <p class='sub_title'> $slogan </p>
                            <h2 class='title_lg mt_5'> $title </h2>
                        </div>
                        {replace}
            </div>
                </div>
            </div>";
        if($model == 1): 
            $html = '';
            $html =  "<div class='owl-carousel slider2 owl-loaded owl-drag'>
                        <div class='owl-stage-outer'>
                            <div class='owl-stage' style='linear-gradient(145deg,#03b0f4 0,#051421c4 50%,#dc213e 100%);transform: translate3d(-517px, 0px, 0px); transition: all 1s ease 0s; width: 1410px; padding-left: 15px; padding-right: 15px;'>";
                        foreach ($new_bks as $keybk => $bookmaker):
                            $view_params['country'] = $aw_system_country;
                            $view_params['bookmaker'] = $bookmaker;
                            $html .= load_template_part("loop/slide_bk_$model",null,$view_params);                            
                        endforeach;
            $html .=  "          </div>
                        </div>
                    <div class='owl-nav'>
                    </div>
                    <div class='owl-dots disabled'></div>
            </div>
            
            ";
            $ret = str_replace("{replace}",$html,$ret);
        endif;
        if($model == 2): 
            $html =  "<div style='margin:15px auto;' class='container bonus_wrap'>
                        <div class='row'>";
                        foreach ($new_bks as $keybk => $bookmaker):
                            $view_params['country'] = $aw_system_country;
                            $view_params['bookmaker'] = $bookmaker;
                            $view_params['position'] = $keybk+1;
                            $html .= load_template_part("loop/slide_bk_$model",null,$view_params);                            
                        endforeach;
            $html .=  " </div>
                </div>";
            $ret = str_replace("{replace}",$html,$ret);
        endif;
        if($model == 3): 
            $html =  "<div style='margin:15px auto;' class='container small_gutter'>
                        <div class='row'>";
                        foreach ($new_bks as $keybk => $bookmaker):
                            $view_params['country'] = $aw_system_country;
                            $view_params['bookmaker'] = $bookmaker;
                            $view_params['position'] = $keybk+1;
                            $html .= load_template_part("loop/slide_bk_$model",null,$view_params);                            
                        endforeach;
            $html .=  " </div>
                </div>";
            $ret = str_replace("{replace}",$html,$ret);
        endif;
    } 
    return $ret;
}

add_shortcode('slide_bk', 'shortcode_slide_bk');

// Cargar owl carousel condicionalmente
function load_owl_carousel_slide_bk() {
    global $post;
    if (isset($post) && is_a($post, 'WP_Post') && (has_shortcode($post->post_content, 'slide_bk'))) {
        wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/jquery-3.6.0.min.js', array(), '3.6.0', false);
        wp_enqueue_script('owl.carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array(), null, true);
    }
}
add_action('wp_enqueue_scripts', 'load_owl_carousel_slide_bk');

// Asegurarse de que el CSS solo se cargue si es necesario
function load_slide_bk_styles() {
    global $post;
    if (isset($post) && is_a($post, 'WP_Post') && (has_shortcode($post->post_content, 'slide_bk'))) {
       wp_enqueue_style('owl.carousel', get_template_directory_uri() . '/assets/css/owl.carousel.min.css', array(), null);
        wp_enqueue_style('bk-slide', get_template_directory_uri() . '/assets/css/bookmakers-styles.css', array(), null);
    }
}
add_action('wp_enqueue_scripts', 'load_slide_bk_styles');