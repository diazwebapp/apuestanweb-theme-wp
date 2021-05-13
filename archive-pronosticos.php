<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); ?>

<main>
	<section>
        <?php if(have_posts()){
			get_template_part('template-parts/content-slide');
		} 
			// get taxonomies by post type, and print loop content filtred by term taxonomi
			foreach (get_terms(array('taxonomy'=>'deporte','hide_empty'=>true)) as $term) : 
                $args = array(
                    'tax_query' => array(
                        array(
                            'taxonomy' => $term->taxonomy,
                            'terms'    => $term->slug,
                        ),
                    ),
                ); 
                $cards_cpt = new WP_Query($args); ?>
                <article class="container_tarjetitas" >
                    <h2 class="sub_title" ><?php echo __("Pronósticos: ".strtoupper($term->name)."", 'apuestanweb-lang'); ?></h2>
                    <?php 
                        // The Loop
                        while ( $cards_cpt->have_posts() ) :
                            $cards_cpt->the_post();
                            $post_tax = wp_get_post_terms( get_the_ID(), $term->taxonomy, array( 'fields' => 'slugs' ) );
                            if($post_tax[0] == $term->slug) : 
                                get_template_part('template-parts/tarjetita_pronostico');
                        endif; endwhile; ?>
                </article>
                <div class="container_pagination" >
                    <a href="<?php echo home_url().'/'.$term->taxonomy.'/'.$term->slug ?>">Ver más</a>
                </div>
            <?php endforeach; ?>
             
	</section>

	<?php get_sidebar() ?>
</main>

<?php get_template_part('components/banner_footer') ?>

<?php get_footer();