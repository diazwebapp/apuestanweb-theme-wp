<?php
function shortcode_blog($atts) {
    extract(shortcode_atts(array(
        'model' => 1,
        'paginate' => true,
        'num' => 2,
        'leagues' => '[all]'
    ), $atts));

    
    $html = '<div class="container">
                <div class="row" id="blog_posts_container">
                    {posts}
                </div>
                <div class="blog_pagination">
                    <ul class="pagination_list" id="blog_pagination_list">
                       {paginate}
                    </ul>
                </div>
            </div>';
    $query = blog_posts_table('post', $num, $leagues);
    $template = "";
    while ($query->have_posts()) :
        $query->the_post();
        $template .= load_template_part("loop/posts-grid_{$model}", null, []);
    endwhile; 
    $html = str_replace('{posts}',$template,$html);

    if($paginate){
        $nav_pages = aw_pagination_posts($query);
        $html = str_replace('{paginate}',$nav_pages, $html);
    }else{
        $html = str_replace('{paginate}', "", $html);
    }
    wp_localize_script('blog_js', 'pagination_data', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'model' => $model,
        'perPage' => $num,
        'leagues' => $leagues,
        'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1,
        'maxPages' => $query->max_num_pages
    ]);
    return $html;
}
add_shortcode('blog', 'shortcode_blog');


function blog_posts_table($post_type, $per_page, $leagues) {
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
    $args['post_type'] = $post_type;
    $args['posts_per_page'] = $per_page;
    $args['paged'] = $paged;

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
    $query = new WP_Query($args);

    return $query;
}

function aw_pagination_posts($query){
    $pagination_links = paginate_links([
        'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
        'format'    => '?page=%#%',
        'current'   => (get_query_var('page')) ? get_query_var('page') : 1,
        'total'     => $query->max_num_pages,
        'prev_text' => '<',
        'next_text' => '>',
        'type'      => 'plain',
    ]);
    $url = home_url() . 'page/1/';
    $pagination_links = str_replace('<span','<a href="'.$url.'"',$pagination_links);
    $pagination_links = str_replace('</span','</a',$pagination_links);
    return $pagination_links;
}

function aw_load_blog_js() {
    global $post;
    
    wp_enqueue_script('blog_js', get_template_directory_uri() . '/assets/js/blog-pagination.js', array(), null, true);
    
    
}
add_action('wp_enqueue_scripts', 'aw_load_blog_js');