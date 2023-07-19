<?php
function shortcode_bookmaker($atts)
{
    extract(shortcode_atts(array(
        'num' => 4,
        'title' => null,
        'slogan' => null,
        'model' => 1,
        'paginate'=>null,
        'country'=>null
    ), $atts));
    $payment = wp_get_post_terms(get_the_ID(), 'bookmaker-payment-methods', array('field' => 'slug'));
    $casino = wp_get_post_terms(get_the_ID(), 'casinos', array('field' => 'slug'));
    $ret = '<div class="container" >
        <div class="row d-flex justify-content-center">{replace_loop}</div>
    </div>';
    
    wp_reset_query();
   
    $args['post_type'] = 'bk';
    //$args['paged'] = ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1);
    //$args['posts_per_page'] = $num;
    $args['posts_per_page'] = -1;
    $args['orderby'] = 'meta_value';
    $args['meta_key'] = '_rating';
    $args['order'] = 'DESC';
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
        
        $view_list_bk = '';
        foreach ($query->posts as $bookmaker): 
            $exists = null;
            $view_params = [];

            if(isset($aw_system_country)):
                $exists = aw_detect_bookmaker_on_country($aw_system_country->id,$bookmaker->ID);
                
                if(isset($exists)):
                    $view_params['country'] = $aw_system_country;
                    $view_params['post'] = $bookmaker;
                    $view_list_bk .= load_template_part("loop/bookmaker_list_{$model}",null,$view_params);
                endif;
            endif;
            
        endforeach;
    
        $ret = str_replace("{replace_loop}",$view_list_bk,$ret);

        
    } else {
        return '<p>no hay datos</p>';
    }
    wp_reset_query();
    return $ret;
}


add_shortcode('bookmakers', 'shortcode_bookmaker');
