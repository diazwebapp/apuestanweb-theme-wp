<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header();
$author_posts = new wp_Query(array(
    'post_type' => 'post'
));
?>


<main>
    <article>
        <?php if(have_posts()):
                    while(have_posts()):
                        the_post() ;?>
                        <div class="imagen_destacada_container" >
                            <?php if(has_post_thumbnail()) : 
                                        the_post_thumbnail();
                                  endif; ?>
                        </div>

                        
                        <?php __(the_content(),'apuestanweb-lang') ?>
            <?php endwhile; endif;

            

            // posts del autor -->

			if($author_posts->have_posts()): ?>
				<section class="container_posts">
					<?php
						while($author_posts->have_posts()): $author_posts->the_post(); 
							get_template_part('template-parts/tarjetita_post');
						endwhile; ?>
						
				</section>
				<div class="container_pagination" >
					<?php echo paginate_links(array(
							'base' => str_replace( '9999999999', '%#%', esc_url( get_pagenum_link( '9999999999') ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var('paged') ),
							'total' => $author_posts->max_num_pages
						) ) ?>
					
				</div>
			<?php endif; ?>
    </article>


    <?php get_sidebar() ?>
</main>

<?php get_footer();