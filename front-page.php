<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); 

$cpt = new WP_Query(array('post_type'=>'pronosticos')); ?>

<main style="margin-top:calc(var(--height-header) * 2);">
	<article>
        <?php if(have_posts()){
            set_query_var('blog_page',$cpt);
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
                $cards_cpt = new WP_Query($args); ?>
                <section class="container_tarjetitas" >
                    <h2 class="sub_title" ><?php echo __("Pronósticos: ".strtoupper($term->name)."", 'apuestanweb-lang'); ?></h2>
                    <?php 
                        // The Loop
                        while ( $cards_cpt->have_posts() ) :
                            $cards_cpt->the_post();
                            $post_tax = wp_get_post_terms( get_the_ID(), $term->taxonomy, array( 'fields' => 'slugs' ) );
                            if($post_tax[0] == $term->slug) : 
                                get_template_part('template-parts/tarjetita_pronostico');
                        endif; endwhile; ?>
                </section>
            <?php endforeach; ?>
            
	</article>

	<?php get_sidebar() ?>
</main>

<?php get_template_part('components/banner_footer') ?>

<?php get_footer();