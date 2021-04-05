<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); 
$query = new wp_Query(array(
	'posts_per_page' => get_option('to_count_post'), 
    'paged' => ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1
));?>

<main>
	<article> 
		<?php if(have_posts()){ 
				set_query_var('blog_page',$query);
				get_template_part('template-parts/content-slide');

				while(have_posts()):
					the_post();
					the_content();
				endwhile; 
				
			} ?>
		
		<div class="terms_nav" style="position:relative;" >
			<?php 
					
                foreach (get_terms(array('taxonomy'=>'category','hide_empty'=>false)) as $key => $term_item):  ?>
                    <a class="<?php if($term === $term_item->slug):echo 'current'; endif; ?>" href="/index.php/<?php echo $term_item->taxonomy.'/'.$term_item->slug;?>">
                        <?php if($term_item->slug == 'sin-categoria'):echo __('todo','apuestanweb-lang');else:echo __($term_item->name,'apuestanweb-lang');endif; ?>
                    </a>
            <?php endforeach;  ?>
		</div>
		<?php 
			if($query->have_posts()): ?>
				<section class="container_posts">
					<?php
						while($query->have_posts()): $query->the_post(); 
							get_template_part('template-parts/tarjetita_post');
						endwhile; ?>
						
				</section>
				<div class="container_pagination" >
					<?php echo paginate_links(array(
							'base' => str_replace( '9999999999', '%#%', esc_url( get_pagenum_link( '9999999999') ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var('paged') ),
							'total' => $query->max_num_pages
						) ) ?>
					
				</div>
			<?php endif; ?>
	</article>

	<?php get_sidebar() ?>
</main>

<?php get_template_part('components/banner_footer') ?>

<?php get_footer();