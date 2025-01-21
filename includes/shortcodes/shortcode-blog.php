<?php
function shortcode_blog($atts) {
    // Establecer valores predeterminados de los atributos del shortcode
    $atts = shortcode_atts([
        'model' => 1,
        'paginate' => 'yes',
        'num' => 6,
        'leagues' => '[all]'
    ], $atts);

    // Generar el HTML base
    $html = '<div class="w-100 mx-auto mt-3">
                <div class="row" id="blog_posts_container">
                    {posts}
                </div>
                <div class="blog_pagination my-5">
                    <ul class="pagination_list" id="blog_pagination_list">
                       {paginate}
                    </ul>
                </div>
            </div>';

    // Realizar la consulta personalizada de posts
    $query = aw_custom_posts_query('post', $atts['num'], $atts['leagues'], 'page_post');

    $template = "";
    
    if ($query) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            $template .= load_template_part("loop/posts-grid_{$atts['model']}", null, []); 
        }
        wp_reset_postdata();
    }

    // Reemplazar {posts} en el HTML con los posts generados
    $html = str_replace('{posts}', $template, $html);

    // Reemplazar {paginate} en el HTML con la paginación generada
    if ($atts['paginate'] and $atts['paginate'] === 'yes') {
        $nav_pages = aw_custom_pagination($query, 'page_post');
        $html = str_replace('{paginate}', $nav_pages, $html);
    } else {
        $html = str_replace('{paginate}', "", $html);
    }
    
    return $html;
}
add_shortcode('blog', 'shortcode_blog');
