<?php 
function blog_posts_pagination_ajax() {
    //check_ajax_referer('pagination_nonce', 'nonce');

    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $model = isset($_POST['model']) ? intval($_POST['model']) : 1;
    $post_type = sanitize_text_field($_POST['post_type']);
    $per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 6;
    $leagues = isset($_POST['leagues']) ? sanitize_text_field($_POST['leagues']) : '[all]';

    $args = [
        'post_type' => $post_type,
        'posts_per_page' => $per_page,
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
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            // Renderiza el contenido del post
            echo load_template_part("loop/posts-grid_{$model}", null, []);
        }
        $posts_html = ob_get_clean();

        // Generar paginación
        $pagination_links = paginate_links([
            'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'format'    => '?paged=%#%',
            'current'   => $paged,
            'total'     => $query->max_num_pages,
            'prev_text' => '<',
            'next_text' => '>',
            'type'      => 'plain',
        ]);

        wp_send_json_success([
            'html' => $posts_html,
            'pagination' => $pagination_links,
            'max_pages' => $query->max_num_pages,
        ]);
    } else {
        wp_send_json_error(['message' => 'No posts found']);
    }

    wp_die();
}

add_action('wp_ajax_blog_posts_pagination', 'blog_posts_pagination_ajax');
add_action('wp_ajax_nopriv_blog_posts_pagination', 'blog_posts_pagination_ajax');

