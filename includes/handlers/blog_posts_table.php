<?php 


function aw_custom_posts_query($post_type, $per_page, $leagues, $page_param) {
    // Usa el parámetro de paginación específico
    global $wp_query;
    $paged = (get_query_var($page_param)) ? get_query_var($page_param) : 1;
    if(is_home() and $wp_query->is_main_query() and (!isset($leagues) or $leagues !== '[all]')){
        return $wp_query;
    }
    $args = [
        'post_type' => $post_type,
        'paged' => $paged,
    ];

    if (isset($leagues) && $leagues !== '[all]') {
        $p = str_replace(["[", "]"], "", $leagues);
        $args['tax_query'] = [
            [
                'taxonomy' => 'league',
                'field' => 'slug',
                'terms' => [$p]
            ]
        ];
    }
    if(isset($per_page)){
        $args['posts_per_page'] = $per_page;
    }
    $query = new WP_Query($args);
    
    return $query;
}
function aw_custom_forecasts_query($vip, $per_page, $leagues, $page_param) {
    // Usa el parámetro de paginación específico
    $paged = (get_query_var($page_param)) ? get_query_var($page_param) : 1;

    $args = [
        'post_type' => 'forecast',
        'paged' => $paged,
    ];
    //$args['date'] = $date;
    $args['meta_key']       = '_data';
    $args['orderby']        = 'meta_value';
    $args['order']          = 'ASC';  
    if(isset($per_page)){
            $args['posts_per_page'] = $per_page;
        }
          
    if (isset($leagues) && $leagues !== '[all]') {
        $p = str_replace(["[", "]"], "", $leagues);
        $args['tax_query'] = [
            [
                'taxonomy' => 'league',
                'field' => 'slug',
                'terms' => [$p]
            ]
        ];
    }
    
    if (isset($vip) && ($vip === 'free' || $vip === 'vip')) {
        $meta_compare = ($vip === 'free') ? '!=' : '='; // Si es "free", usar '!=', de lo contrario usar '='
        $args['meta_query'] = [
            [
                'key' => 'vip', 
                'value' => 'yes',
                'compare' => $meta_compare, // Operador de comparación
            ],
        ];
    }

    $query = new WP_Query($args);
    return $query;
}
function aw_custom_pagination($query, $page_param) {
    // Usa el parámetro de paginación específico
    $pagination_links = paginate_links(array(
        'base'    => add_query_arg($page_param, '%#%'),
        'format'  => '?'.$page_param.'=%#%',
        'type' => 'array',
        'current' => max(1, get_query_var($page_param)),
        'total'   => $query->max_num_pages,
        'prev_text' => 'anterior',
        'next_text' => 'siguiente'
    ));
    $pagination_html = '';
    if (is_array($pagination_links)) { 
        
        foreach ($pagination_links as $page_link) { 
            $pagination_html .= '<li>' . $page_link . '</li>'; 
        }  
    }
    return $pagination_html; 
}

///////////test ajax///////

function cargar_mas_test() {
    $page = intval($_POST['page']) + 1; // Incrementa la página actual
    $view_params = json_decode(stripslashes($_POST['view_params']), true);

    $query = aw_custom_posts_query('forecast', $view_params['num'], null, 'page_forecast');

    if ($query->posts) {
        foreach ($query->posts as $forecast) {
            $view_params["forecast"] = $forecast;
            echo load_template_part("loop/pronosticos_list_{$view_params['model']}", null, $view_params);
        }
    }
    wp_reset_postdata();
    die();
}
add_action('wp_ajax_cargar_mas_test', 'cargar_mas_test');
add_action('wp_ajax_nopriv_cargar_mas_test', 'cargar_mas_test');
