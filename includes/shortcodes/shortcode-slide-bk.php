<?php
function shortcode_slide_bk($atts)
{
    extract(shortcode_atts(array(
        'num' => 10,
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'model' => 1
    ), $atts));
    $ret = '';
    /*welcome */
    
    wp_reset_query();
        $args = array(
            'post_type' => 'bk',
            'posts_per_page' => $num,
            'order' => $order,
            'orderby' => $orderby,

        );


    if ($orderby == 'meta_value_num') {
        $args['meta_key'] = '_rating';
    }
    
    $query_bk = new WP_Query($args);
    if ($query_bk->have_posts()) { 
        if($model == 1): 
            $ret =  "<div class='owl-carousel slider2 owl-loaded owl-drag'>
                        <div class='owl-stage-outer'>
                            <div class='owl-stage' style='transform: translate3d(-517px, 0px, 0px); transition: all 1s ease 0s; width: 1410px; padding-left: 15px; padding-right: 15px;'>";
                        while ($query_bk->have_posts()):
                            $query_bk->the_post();
                            $ret .= get_teplate_part("loop/slide_bk_$model");                            
                        endwhile;
            $ret .=  "          </div>
                        </div>
                    <div class='owl-nav'>
                    </div>
                    <div class='owl-dots disabled'></div>
            </div>";
        endif;
    } else {
        return 'not found';
    }
    wp_reset_query();
    return $ret;
}


add_shortcode('slide_bk', 'shortcode_slide_bk');
