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
    if ($query) {
        $new_bks = [];
        $location = json_decode(GEOLOCATION);
        $aw_system_country = aw_select_country(["country_code"=>$location->country_code]);
        foreach ($query->posts as $bookmaker): 
            $exists = aw_detect_bookmaker_on_country($aw_system_country->id,$bookmaker->ID);
            if(isset($exists)):
                $new_bks[] = $bookmaker;
            endif;
        endforeach;
        
        if($model == 1): 
            $ret .=  "<div class='testimonial_area'>
                <div class='container'>
                    <div class='row small_gutter'>
                        <div class='col-12 text-center pb_30'>
                            <h5 class='sub_title'> $slogan </h5>
                            <h2 class='title_lg mt_5'> $title </h2>
                        </div>";
                        foreach ($new_bks as $key_bk => $bookmaker):
                            $post = $query->post;
                            $ret .= load_template_part('loop/bookmaker_list');                            
                        endforeach;
            $ret .=  "</div>
                </div>
            </div>";
        endif;

        if($model == 2):
            foreach ($new_bks as $key_bk => $bookmaker):
                $post = $query->post;
                var_dump($post);
                $ret .= load_template_part("loop/bookmaker_list_{$model}");
            endforeach;
        endif;
        
        if($model == 3):
            $ret =  "<div style='margin:15px auto;' class='bonus_wrap'>
            <div class='row'>";
            
            foreach ($new_bks as $key_bk => $bookmaker):
                
                $post = $query->post;
                $ret .= load_template_part("loop/bookmaker_list_{$model}");
            endforeach;
            $ret .=  "</div>
            </div>";
        endif;
        ?>
        <script>
            document.addEventListener('DOMContentLoaded',()=>{

                var counters = document.querySelectorAll('#count_bk_model_3');
                if(counters.length > 0){
                    for(var count = 0; count < counters.length;count++ ){
                        counters[count].textContent = count+1
                    }
                }

            })
        </script>
        <?php
    } else {
        return '<p>no hay datos</p>';
    }
    wp_reset_query();
    return $ret;
}


add_shortcode('bookmaker', 'shortcode_bookmaker');
