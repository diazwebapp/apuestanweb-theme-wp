<?php
function shortcode_bookmaker($atts)
{
    extract(shortcode_atts(array(
        'num' => 4,
        'title' => false,
        'slogan' => false,
        'model' => 1,
        'payment' => wp_get_post_terms(get_the_ID(), 'bookmaker-payment-methods', array('field' => 'slug')),
        'paginate'=>false,
        'country'=>false
    ), $atts));
    $ret = '';
    
    wp_reset_query();

    $args['post_type'] = 'bk';
    $args['posts_per_page'] = -1;
    $args['order'] = 'DESC';
    $args['orderby'] = 'meta_value_num';
    $args['meta_key'] = '_rating';
    
    
    $terms = [];
    foreach($payment as $term){
        $terms[] = $term->slug;
    }
    
    if(count($terms) > 0){
        $args['tax_query'] = [
            [
                'taxonomy' => 'bookmaker-payment-methods',
                'field'    => 'slug',
                'terms'    => $terms,
            ]
        ];
    }
    $query = new WP_Query($args);
    if ($query) {
        $new_bks = [];
        $location = json_decode(GEOLOCATION);
        $aw_system_country = aw_select_country(["country_code"=>$location->country_code]);
        $aw_system_country_2 = aw_select_country(["country_code"=>strtoupper($country)]);
        foreach ($query->posts as $bookmaker): 
            $exists = null;
            if(empty($country)):
                if(isset($aw_system_country->id)):
                    $exists = aw_detect_bookmaker_on_country($aw_system_country->id,$bookmaker->ID);
                endif;
                if(!isset($aw_system_country->id)):
                    $exists = aw_detect_bookmaker_on_country(1,$bookmaker->ID);
                endif;
                if(isset($exists)):
                    $new_bks[] = $bookmaker;
                endif;
            else:
                if(isset($aw_system_country_2->id)):
                    $exists = aw_detect_bookmaker_on_country($aw_system_country_2->id,$bookmaker->ID);
                endif;
                if(!isset($aw_system_country_2->id)):
                    $exists = aw_detect_bookmaker_on_country(1,$bookmaker->ID);
                endif;
                if(isset($exists)):
                    $new_bks[] = $bookmaker;
                endif;
            endif;
        endforeach;
        //Elementos de la paginación
        $path = $_SERVER["REQUEST_URI"];

        $total_pages = ceil(count($new_bks) / $num);
        $current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
        
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
            
            foreach ($new_bks as $key_bk => $bookmaker):
                if($current_page == 1 and  $key_bk  <= ($num - 1))
                    $ret .= load_template_part("loop/bookmaker_list_{$model}",null,[
                        'post'	=> $bookmaker,
                    ]);
                if($current_page > 1 and  $key_bk  <= ($num - 1))
                    $ret .= load_template_part("loop/bookmaker_list_{$model}",null,[
                        'post'	=> $bookmaker,
                    ]);
                
            endforeach;
        endif;

        if($model ==2):
            
            foreach ($new_bks as $key_bk => $bookmaker):
                if($current_page == 1 and  $key_bk  <= ($num - 1))
                    $ret .= load_template_part("loop/bookmaker_list_{$model}",null,[
                        'post'	=> $bookmaker,
                    ]);
                if($current_page > 1 and  $key_bk  <= ($num - 1))
                    $ret .= load_template_part("loop/bookmaker_list_{$model}",null,[
                        'post'	=> $bookmaker,
                    ]);
                
            endforeach;
        endif;
        

        
        if(count($new_bks) > 0 and $paginate=="yes"){
            $links = '';
            for($i=1;$i<=$total_pages;$i++){
                $path2 = str_replace("page/$current_page/","",$path);
                if($current_page !=$i)
                    $links .= '
                    <a class="page-numbers" href="'.$path2.'page/'.$i.'">'.$i.'</a>';               
                
                if($current_page == $i)
                    $links .= '
                    <span aria-current="page" class="page-numbers current">'.$i.'</span>';
            }
            $ret .= '
            <div class="col-lg-12">
                <div class="blog_pagination">
                    <ul class="pagination_list">
                        '.$links.'
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


add_shortcode('bookmakers', 'shortcode_bookmaker');