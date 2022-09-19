<?php
function shortcode_bookmaker($atts)
{
    extract(shortcode_atts(array(
        'num' => 2,
        'title' => false,
        'slogan' => false,
        'model' => 1,
        'payment' => wp_get_post_terms(get_the_ID(), 'bookmaker-payment-methods', array('field' => 'slug')),
        'paginate'=>false
    ), $atts));
    $ret = '';
    
    wp_reset_query();

    $args['post_type'] = 'bk';
    $args['posts_per_page'] = -1;
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
        //Elementos de la paginación
        $path = $_SERVER["REQUEST_URI"];

        $total_pages = ceil(count($new_bks) / $num);
        $current_page = 1;
        var_dump($_GET);
        if(isset($_GET["page"])){
            $current_page = intval($_GET["page"]) > $total_pages ? $total_pages :intval($_GET["page"]);
        }
        $cut = $current_page * $num -2;
        if($cut > count($new_bks)){
            $cut = $cut - count($new_bks)  ;
            $cut = $cut * $current_page;
        }
        array_splice($new_bks,0, ($current_page == 1) ? $current_page -1 : $cut );
        
        if($model == 1): 
            $ret .=  "<div class='testimonial_area'>
                <div class='container'>
                    <div class='row small_gutter'>
                        <div class='col-12 text-center pb_30'>
                            <h5 class='sub_title'> $slogan </h5>
                            <h2 class='title_lg mt_5'> $title </h2>
                        </div>";
                        foreach ($new_bks as $key_bk => $bookmaker):        
                            $ret .= get_template_part('loop/bookmaker_list',null,[
                                'post'	=> $bookmaker,
                            ]);                            
                        endforeach;
            $ret .=  "</div>
                </div>
            </div>";
        endif;

        if($model == 2):
            
            foreach ($new_bks as $key_bk => $bookmaker):
                if($current_page == 1 and  $key_bk  <= ($num - 1))
                    $ret .= get_template_part("loop/bookmaker_list_{$model}",null,[
                        'post'	=> $bookmaker,
                    ]);
                if($current_page > 1 and  $key_bk  <= ($num - 1))
                    $ret .= get_template_part("loop/bookmaker_list_{$model}",null,[
                        'post'	=> $bookmaker,
                    ]);
                
            endforeach;
        endif;
        
        if($model == 3):
            $ret =  "<div style='margin:15px auto;' class='bonus_wrap'>
            <div class='row'>";
            
            foreach ($new_bks as $key_bk => $bookmaker):
                $ret .= get_template_part("loop/bookmaker_list_{$model}",null,[
                    'post'	=> $bookmaker,
                ]);
            endforeach;
            $ret .=  "</div>
            </div>";
        endif;
        if(count($new_bks) > 0 and $paginate=="yes"){
            
            $ret .= '
            <div class="col-lg-12">
                <div class="blog_pagination">
                    <ul class="pagination_list">
                        <span aria-current="page" class="page-numbers current">1</span>
                        <a class="page-numbers" href="'.$path.'page/'.($current_page+1).'">2</a>
                        <a class="next page-numbers" href="'.$path.'page/'.($current_page+1).'">&gt;</a>
                    </ul>
                </div>
            </div>
            ';
        }
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
