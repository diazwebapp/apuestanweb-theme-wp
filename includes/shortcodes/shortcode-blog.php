<?php
function shortcode_blog($atts) {
    extract(shortcode_atts(array(
        'model' => 1,
        'paginate' => true,
        'num' => 2,
        'leagues' => '[all]'
    ), $atts));


    $html = '<div class="blog_container">
                <div class="row" id="blog_posts_container">
                    {posts}
                </div>
                <div class="blog_pagination">
                    <ul class="pagination_list" id="blog_pagination_list">
                       {paginate}
                    </ul>
                </div>
            </div>';
    $query = blog_posts_table('post', $num, $leagues,'page_post');
    $template = "";
    while ($query->have_posts()) :
        $query->the_post();
        $template .= load_template_part("loop/posts-grid_{$model}", null, []);
    endwhile; 
    $html = str_replace('{posts}',$template,$html);

    if($paginate){
        $nav_pages = aw_pagination_posts($query,'page_post');
        $html = str_replace('{paginate}',$nav_pages, $html);
    }else{
        $html = str_replace('{paginate}', "", $html);
    }
    wp_localize_script('blog_js', 'pagination_data', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'model' => $model,
        'perPage' => $num,
        'leagues' => $leagues,
        'page' => (get_query_var('page_post')) ? get_query_var('page_post') : 1,
        'maxPages' => $query->max_num_pages
    ]);
    return $html;
}
add_shortcode('blog', 'shortcode_blog');


function blog_posts_table($post_type, $per_page, $leagues, $page_param) {
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
function forecast_posts_table($vip, $per_page, $leagues, $page_param) {
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
function aw_pagination_posts($query, $page_param) {
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


function aw_load_blog_js() {
    global $post;
    
    wp_enqueue_script('blog_js', get_template_directory_uri() . '/assets/js/blog-pagination.js', array(), null, true);
    
    
}
//add_action('wp_enqueue_scripts', 'aw_load_blog_js');