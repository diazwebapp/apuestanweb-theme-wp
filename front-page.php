<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); ?>

<main style="margin-top:calc(var(--height-header) * 2);">
	<article> front-page.php
		<?php if(have_posts()){ 
			get_template_part('template-parts/content-slide');
		} 
			// get taxonomies by post type, and print loop content filtred by term taxonomi
			foreach (get_term_names(get_object_taxonomies('pronosticos')) as $key => $term) : 
                $args = array(
                    'posts_per_page' => get_option('to_count_pronosticos'), 
                    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => $term->taxonomy,
                            'terms'    => $term->slug,
                        ),
                    ),
                ); 
                $cpt = new WP_Query($args); ?>
                <section class="container_tarjetitas" >
                    <h2 class="sub_title" ><?php echo __("Pronósticos: ".strtoupper($term->name)."", 'apuestanweb_lang'); ?></h2>
                    <?php 
                        // The Loop
                        while ( $cpt->have_posts() ) :
                            $cpt->the_post();
                            $post_tax = wp_get_post_terms( get_the_ID(), $term->taxonomy, array( 'fields' => 'slugs' ) );
                            if($post_tax[0] == $term->slug) : 
                                get_template_part('template-parts/tarjetita_pronostico');
                        endif; endwhile; ?>
                </section>
			<?php endforeach; 
			
			the_content(); ?>
            
	</article>

	<?php get_sidebar() ?>
</main>

<?php get_template_part('components/banner_footer') ?>

<?php get_footer();