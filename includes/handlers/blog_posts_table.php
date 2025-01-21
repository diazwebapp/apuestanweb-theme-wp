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
        'type' => 'array',
        'current' => max(1, get_query_var($page_param)),
        'total'   => $query->max_num_pages,
        'prev_text' => __('<i class="angle-left" >
<svg width="22px" height="22px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M12 7C12.2652 7 12.5196 7.10536 12.7071 7.29289L19.7071 14.2929C20.0976 14.6834 20.0976 15.3166 19.7071 15.7071C19.3166 16.0976 18.6834 16.0976 18.2929 15.7071L12 9.41421L5.70711 15.7071C5.31658 16.0976 4.68342 16.0976 4.29289 15.7071C3.90237 15.3166 3.90237 14.6834 4.29289 14.2929L11.2929 7.29289C11.4804 7.10536 11.7348 7 12 7Z" fill="#007bff"/>
</svg></i>', 'textdomain'),
        'next_text' => __('<i class="angle-right">
<svg width="22px" height="22px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M12 7C12.2652 7 12.5196 7.10536 12.7071 7.29289L19.7071 14.2929C20.0976 14.6834 20.0976 15.3166 19.7071 15.7071C19.3166 16.0976 18.6834 16.0976 18.2929 15.7071L12 9.41421L5.70711 15.7071C5.31658 16.0976 4.68342 16.0976 4.29289 15.7071C3.90237 15.3166 3.90237 14.6834 4.29289 14.2929L11.2929 7.29289C11.4804 7.10536 11.7348 7 12 7Z" fill="#007bff"/>
</svg></i>', 'textdomain'),
    ));
    $pagination_html = '';
    if (is_array($pagination_links)) { 
        $pagination_html = '<ul class="pagination_list" id="blog_pagination_list">'; 
        foreach ($pagination_links as $page_link) { 
            $pagination_html .= '<li>' . $page_link . '</li>'; 
        } 
        $pagination_html .= '</ul>';  
    }
    return $pagination_html; 
}

