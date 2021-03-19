<?php
/**
* Template Name: pronosticos
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
 get_header(); ?>

<main style="margin-top:calc(var(--height-header) * 2);">
	<article>

    <?php if(have_posts()){
                get_template_part('template-parts/content-slide');
			} 
            
            // get taxonomies by post type, and print loop content filtred by term taxonomi
            
            foreach (get_term_names(get_object_taxonomies($post->post_type)) as $key => $term) : ?>
                <section class="container_tarjetitas" >
                    <h2 class="sub_title" ><?php echo __("Pronósticos: ".strtoupper($term->name)."", 'apuestanweb_lang'); ?></h2>
                    <?php 
                        // The Loop
                        while ( have_posts() ) :
                            the_post();
                            $post_tax = wp_get_post_terms( get_the_ID(), $term->taxonomy, array( 'fields' => 'slugs' ) );
                            if($post_tax[0] == $term->slug) : 
                                get_template_part('template-parts/tarjetita_pronostico');
                        endif; endwhile; ?>

                    <div class="container_pagination" style="width:100%;min-width:100%;display:flex;justify-content:center;" >
                        <?php echo paginate_links();?>
                    </div>
                </section>
            <?php endforeach; ?> 
	</article>

    <?php get_sidebar() ?>
</main>
<?php get_footer(); 