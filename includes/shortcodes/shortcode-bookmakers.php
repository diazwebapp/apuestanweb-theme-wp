<?php
function shortcode_bookmaker($atts)
{
    extract(shortcode_atts(array(
        'num' => 4,
        'title' => false,
        'slogan' => false,
        'model' => 1,
        'payment' => wp_get_post_terms(get_the_ID(), 'bookmaker-payment-methods', array('field' => 'slug')),
        'casino' => wp_get_post_terms(get_the_ID(), 'casinos', array('field' => 'slug')),
        'paginate'=>false,
        'country'=>false
    ), $atts));
    $ret = '<div class="container" >
        <div class="row small_gutter">{replace_loop}</div>
    </div>';
    
    wp_reset_query();

    $args['post_type'] = 'bk';
    $args['posts_per_page'] = -1;
    $args['order'] = 'DESC';
    $args['orderby'] = 'meta_value_num';
    $args['meta_key'] = '_rating';
    $args['tax_query'] = ["relation"=>"AND"];
    
    $terms = [];
    $casinos = [];
    foreach($payment as $term){
        $terms[] = $term->slug;
    }
    foreach($casino as $term_casino){
        $casinos[] = $term_casino->slug;
    }
    if(count($terms) > 0){
        $args['tax_query'][] = [
            [
                'taxonomy' => 'bookmaker-payment-methods',
                'field'    => 'slug',
                'terms'    => $terms,
            ]
        ];
    }
    if(count($casinos) > 0){
        $args['tax_query'][]  = [
            'taxonomy' => 'casinos',
            'field'    => 'slug',
            'terms'    => $casinos,
        ];
    }
    $query = new WP_Query($args);
    if ($query) {
        $new_bks = [];
        $location = json_decode($_SESSION["geolocation"]);
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
        $view_list_bk = '';

        foreach ($new_bks as $key_bk => $bookmaker):
            if($current_page == 1 and  $key_bk  <= ($num - 1))
                $view_list_bk .= load_template_part("loop/bookmaker_list_{$model}",null,[
                    'post'	=> $bookmaker,
                ]);
            if($current_page > 1 and  $key_bk  <= ($num - 1))
                $view_list_bk .= load_template_part("loop/bookmaker_list_{$model}",null,[
                    'post'	=> $bookmaker,
                ]);
            
        endforeach;

        
        $ret = str_replace("{replace_loop}",$view_list_bk,$ret);

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
    } else {
        return '<p>no hay datos</p>';
    }
    wp_reset_query();
    return $ret;
}


add_shortcode('bookmakers', 'shortcode_bookmaker');
