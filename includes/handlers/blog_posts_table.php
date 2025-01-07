<?php 


function aw_custom_posts_query($post_type, $per_page, $leagues, $page_param) {
    // Usa el parámetro de paginación específico
    $paged = (get_query_var($page_param)) ? get_query_var($page_param) : 1;

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
        'current' => max(1, get_query_var($page_param)),
        'total'   => $query->max_num_pages,
        'prev_text' => __('<', 'textdomain'),
        'next_text' => __('>', 'textdomain'),
    ));

    return $pagination_links;
}

