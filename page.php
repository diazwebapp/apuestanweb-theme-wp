<?php get_header(); ?>

<main style="margin-top:calc(var(--height-header) * 2);">
    <article>
    
        <div class="imagen_destacada_container">
        <?php if(has_post_thumbnail()) : 
                    the_post_thumbnail();
                else : ?> 
                    <img src="https://wallpaperaccess.com/full/552032.jpg" alt="">
        <?php endif; ?>
        </div>
        <section>
            <h1><?php the_title() ?></h1>
            <?php
                if(is_singular()): 
                    the_content(); 
                endif;
                if(is_front_page() && is_singular()): echo 'es front y singular page' . '<br />' ;
                    // get taxonomies by post type, and print loop content filtred by term taxonomi
                    set_query_var('array_taxonomy',get_term_names(get_object_taxonomies('pronosticos')));
                    get_template_part('template-parts/content-archive-pronosticos');
                endif;

                if(!is_front_page() && is_singular()): echo 'es front y singular page' . '<br />' ;
                    // get taxonomies by post type, and print loop content filtred by term taxonomi
                    set_query_var('array_taxonomy',get_term_names(get_object_taxonomies('pronosticos')));
                    get_template_part('template-parts/content-home'); 
                endif;
            ?>
        </section>

    </article>

    <?php get_sidebar() ?>
</main>
<?php get_footer();