<?php get_header();?>
<div class="container">
<div class="hero">
    <div class="category-title">
        <a href="javascript:history.go(-1);" style="color: white;font-size: 15px;">
            <i class="fas fa-arrow-left"></i> Regresar
        </a>
    </div>
</div>

<div class="breadcrumb" style="background: white;">
    <p id="breadcrumbs">
        <a href="<?php echo esc_url( home_url() ); ?>">Inicio</a> - 
        <a href="<?php echo esc_url( home_url( '/apuestas-deportivas/' ) ); ?>">Apuestas deportivas</a> - 
        <?php the_title(); ?>
    </p>
</div>

<div class="entry-wrapper">
    <aside id="secondary" class="widget-area">
        <div class="related-entries">
            <span class="widget-title">Recursos</span>
            <ul>
                <?php
                $current_category = get_the_terms(get_the_ID(), 'categoria_content_hub');
                if ($current_category && !is_wp_error($current_category)) {
                    $current_category_slug = $current_category[0]->slug;
                    $args = array(
                        'post_type' => 'content_hub',
                        'posts_per_page' => 6, // Mostrar la entrada actual + 5 entradas relacionadas
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'categoria_content_hub',
                                'field' => 'slug',
                                'terms' => $current_category_slug,
                            ),
                        ),
                    );

                    $related_query = new WP_Query($args);
                    while ($related_query->have_posts()) {
                        $related_query->the_post();
                        $class = (get_the_ID() === get_queried_object_id()) ? 'class="current-post fal fa-chevron-circle-right"' : '';
                        echo '<li ' . $class . '><a class="hub-link" href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
                        
                    }
                    wp_reset_postdata();
                }
                ?>
            </ul>
        </div>
    </aside>

    <main id="primary" class="content-area">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="entry-content">
                
                    <h1 class="post-content hub_title"><?php the_title(); ?></h1>
                
                <div class="post-content single_event_content text-break">
                    <p class="post-date">Publicado: <?php echo get_the_date(); ?></p> <!-- Agregar la fecha de publicación -->

                    <?php the_content(); ?>
                </div>
            </div>
        </article>
        <div class="nav-links">
            <?php
            $current_category = get_the_terms(get_the_ID(), 'categoria_content_hub');
            $current_category_slug = $current_category[0]->slug;

            $args_prev = array(
                'post_type' => 'content_hub',
                'posts_per_page' => 1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'categoria_content_hub',
                        'field' => 'slug',
                        'terms' => $current_category_slug,
                    ),
                ),
                'date_query' => array(
                    'after' => get_the_time('Y-m-d H:i:s'),
                ),
                'order' => 'ASC',
            );
            $prev_query = new WP_Query($args_prev);
            $prev_post = $prev_query->posts[0];

            $args_next = array(
                'post_type' => 'content_hub',
                'posts_per_page' => 1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'categoria_content_hub',
                        'field' => 'slug',
                        'terms' => $current_category_slug,
                    ),
                ),
                'date_query' => array(
                    'before' => get_the_time('Y-m-d H:i:s'),
                ),
                'order' => 'DESC',
            );
            $next_query = new WP_Query($args_next);
            $next_post = $next_query->posts[0];

            if (!empty($prev_post)) {
                echo '<a href="' . get_permalink($prev_post->ID) . '" class="nav-previous">
                <i class="fas fa-arrow-left"></i>
                 <span class="nav-post-title">' . get_the_title($prev_post->ID) . '</span>
                </a>';
            }

            if (!empty($next_post)) {
                echo '<a href="' . get_permalink($next_post->ID) . '" class="nav-next">                    
                    <span class="nav-post-title">' . get_the_title($next_post->ID) . '</span>
                    <i class="fas fa-arrow-right"></i>
                </a>';
            }
            ?>
        </div>





        
    </main>
</div>
</div>
<?php get_footer();?>
