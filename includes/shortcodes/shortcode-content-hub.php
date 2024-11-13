<?php

function content_hub_categories_shortcode() {
    ob_start();

    echo '<div class="hero-container">';
    echo '<div class="hero-content">';
    echo '<h1 class="hero-title">Academia Apuestan</h1>';
    echo '<p class="hero-description">Aprende con nosotros todo lo referente a la apuestas; mercados, términos, estrategias y más.</p>';
    echo '</div>';
    echo '</div>';

    // Obtener todas las categorías registradas en la taxonomía 'categoria_content_hub'.
    $categories = get_terms(
        array(
            'taxonomy' => 'categoria_content_hub',
            'hide_empty' => false,
            'orderby' => 'date',
            'order' => 'DESC',
            
        )
    );

    if (!empty($categories)) {
        echo '<div class="container">';
        echo '<div class="row">';
        foreach ($categories as $category) {
            $category_h1 = carbon_get_term_meta($category->term_id, 'h1_hub');
            $category_image = carbon_get_term_meta($category->term_id, 'hub_image');

            if ($category_h1 && $category_image) {
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="card custom-card">';
                echo '<img widht="300px" height="200px" src="' . wp_get_attachment_image_url($category_image, 'card-image') . '" class="card-img-top img-fluid" alt="' . $category->name . '">';
                echo '<div class="card-body">';
                echo '<h2 class="card-title">' . $category_h1 . '</h2>';
                echo '<p class="post-count">' . sprintf(_n('%d Recurso', '%d Recursos', $category->count), $category->count) . '</p>'; // Mostrar la cantidad de publicaciones
                echo '<ul class="list-group list-group-flush">';

                // Consulta para mostrar las publicaciones asociadas a la categoría actual.
                $args = array(
                    'post_type' => 'content_hub',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'categoria_content_hub',
                            'field' => 'slug',
                            'terms' => $category->slug,
                        ),
                    ),
                );

                $query = new WP_Query($args);
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        echo '<li class="list-group-item fal fa-chevron-circle-right"><a class="hub-link" href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
                    }
                    wp_reset_postdata();
                } else {
                    echo '<li class="list-group-item">No se encontraron publicaciones asociadas a esta categoría.</li>';
                }

                echo '</ul>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
        echo '</div>';
        echo '</div>';
    } else {
        echo '<p>No se encontraron categorías registradas en la taxonomía.</p>';
    }

    return ob_get_clean();
}

add_shortcode('content_hub_categories', 'content_hub_categories_shortcode');