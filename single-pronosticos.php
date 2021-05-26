<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header();

$author_posts = new wp_Query(array(
    'post_type' => $post->post_type,
    'author' => $post->post_author,
    'post_not_in' => array( $post->ID ),
    'tax_query'=>array(
        array(
            'taxonomy' => 'deporte',
            'terms' => 'all'
        )
    )
));

?>

<main>
    <section>
        <?php if(have_posts()):
                echo do_shortcode('[pronostico id="'.$post->ID.'" ]'); ?>

                <article>
                    <?php __(the_content(),'apuestanweb-lang') ?>
                </article>
                                  
            <?php endif;
        
            set_query_var('data_card_author',array('post'=>$post,'pronosticos'=>$author_posts));
            get_template_part('components/card_author');
            
            
            // posts del autor -->
			if($author_posts->have_posts()): ?>
				<article class="container_posts">
					<?php
						while($author_posts->have_posts()): $author_posts->the_post(); 
                            
							get_template_part('template-parts/tarjetita_post');
						endwhile; ?>
						
				</article>
				<div class="container_pagination" >
					<?php echo paginate_links(array(
							'base' => str_replace( '9999999999', '%#%', esc_url( get_pagenum_link( '9999999999') ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var('paged') ),
							'total' => $author_posts->max_num_pages
						) ) ?>
					
				</div>
            <?php endif; ?>
    </section>


    <?php get_sidebar() ?>
</main>

<?php get_footer();
