<?php
function shortcode_slide($atts)
{
    add_action( 'wp_print_styles', function(){
        wp_deregister_style( 'bootstrap.min' );
        wp_deregister_style( 'owl.crousel' );
    }, 100 );
    add_action( 'wp_print_scripts', function(){
        wp_deregister_script( 'plugins' );
    }, 100 );
    extract(shortcode_atts(array(
        'num' => 4,
        'model' => 1,
        'date' => false
    ), $atts));
    
    $ret = '';
    wp_reset_query();
    $alt_logo = get_template_directory_uri() . '/assets/img/logo2.svg';
    $args = array(
        'post_type' => 'forecast',
        'posts_per_page' => $num,
    );
    if ($date and $date != "") {
        if($date == 'today')
            $current_date = date('Y-m-d');
        if($date == 'yesterday')
            $current_date = date('Y-m-d', strtotime('-1 days'));
        if($date == 'tomorrow')
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
        $ret = "<div class='container mt_55 home_container'>
            <div class='owl-carousel slider owl-loaded owl-drag' >
                <div class='owl-stage-outer' >
                    <div class='owl-stage' >";
                        while ($query->have_posts()):
                            $query->the_post();
                            $ret .= load_template_part("loop/slide_$model");
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
                                                    <li><a href="apuestanweb.com" >Live</a></li>
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
                                </div">
                            </div>
                         </div">
                    </div>';
        endif;
    } else {
        echo do_shortcode('[banner]');
    }
    
    return $ret;
}


add_shortcode('slide_forecasts', 'shortcode_slide');