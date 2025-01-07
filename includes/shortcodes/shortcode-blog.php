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
                <div class="blog_pagination my-5">
                    <ul class="pagination_list" id="blog_pagination_list">
                       {paginate}
                    </ul>
                </div>
            </div>';
    $query = aw_custom_posts_query('post', $num, $leagues,'page_post');
    $template = "";
    while ($query->have_posts()) :
        $query->the_post();
        $template .= load_template_part("loop/posts-grid_{$model}", null, []);
    endwhile; 
    $html = str_replace('{posts}',$template,$html);

    if($paginate){
        $nav_pages = aw_custom_pagination($query,'page_post');
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
