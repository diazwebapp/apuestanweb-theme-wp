<?php

function aw_blog_posts_table($items) {
    $result = '';

    // Verificar si hay posts
    if ($items->have_posts()) {
        while ($items->have_posts()) {
            $items->the_post();

            // Obtener URL de la imagen destacada
            $thumb = get_the_post_thumbnail_url(get_the_ID());
            $thumb = $thumb ? esc_url($thumb) : '';

            // Obtener términos relacionados a ligas
            $leagues = wp_get_post_terms(get_the_ID(), 'league', array('fields' => 'all'));
            $sport = '';

            if (!empty($leagues)) {
                foreach ($leagues as $league) {
                    if ($league->parent === 0) {
                        $sport = esc_html($league->name);
                        break; // Detener el bucle después de encontrar el primer término
                    }
                }
            }

            // Construir el HTML con datos escapados
            $result .= '<div class="col-lg-3 col-md-4 col-6 mt-4">
                            <div class="blog_box">
                                <div class="img_box">
                                    <a href="' . esc_url(get_the_permalink(get_the_ID())) . '" class="blog_img">
                                        <img src="' . esc_url($thumb) . '" class="w-100" alt="' . esc_attr($sport) . '">
                                    </a>
                                </div>
                                <div class="blog_content">
                                    <h5 class="blog_title">
                                        <a href="' . esc_url(get_the_permalink(get_the_ID())) . '">' . esc_html(get_the_title()) . '</a>
                                    </h5>
                                </div>
                            </div>
                        </div>';
        }

        // Restaurar el post global después del loop
        wp_reset_postdata();
    } else {
        // Si no hay posts
        $result .= '<p>No posts found.</p>';
    }

    return $result;
}
