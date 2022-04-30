<?php
function shortcode_bookmaker($atts)
{
    extract(shortcode_atts(array(
        'num' => 10,
        'title' => false,
        'slogan' => false,
        'model' => 1
    ), $atts));
    $ret = '';
    
    wp_reset_query();

    $args['post_type'] = 'bk';
    $args['posts_per_page'] = $num;
    $args['order'] = 'DESC';
    $args['orderby'] = 'meta_value_num';
    $args['meta_key'] = '_rating';
    
    $query = new WP_Query($args);
    if ($query->have_posts()) { 
        if($model == 1): 
            $ret .=  "<div class='testimonial_area'>
                <div class='container'>
                    <div class='row small_gutter'>
                        <div class='col-12 text-center pb_30'>
                            <h5 class='sub_title'> $slogan </h5>
                            <h2 class='title_lg mt_5'> $title </h2>
                        </div>";
                        while ($query->have_posts()):
                            $query->the_post();
                            $ret .= load_template_part('loop/bookmaker_list');                            
                        endwhile;
            $ret .=  "</div>
                </div>
            </div>";
        endif;

        if($model == 2):
            while ($query->have_posts()):
                $query->the_post();
                $ret .= load_template_part("loop/bookmaker_list_{$model}");
            endwhile;
        endif;
        
        if($model == 3):
            $count = 0;
            $ret =  "<div style='margin:15px auto;' class='bonus_wrap'>
            <div class='row'>";
            while ($query->have_posts()):
                $count++;
                set_query_var( 'params', [
                    "count" => $count
                ] );
                $query->the_post();
                $ret .= load_template_part("loop/bookmaker_list_{$model}");
            endwhile;
            $ret .=  "</div>
            </div>";
        endif;
        
    } else {
        return '<p>no hay datos</p>';
    }
    wp_reset_query();
    return $ret;
}


add_shortcode('bookmaker', 'shortcode_bookmaker');
