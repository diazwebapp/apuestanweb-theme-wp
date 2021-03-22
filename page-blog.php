<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); 
$query = new wp_Query(array(
	'post_type' => 'post'
));?>

<main style="margin-top:calc(var(--height-header) * 2);">
	<article> page-b
		<?php if($query->have_posts()){ 
				set_query_var('blog_page',$query);
				get_template_part('template-parts/content-slide');

				while($query->have_posts()):
					$query->the_post();
					the_content();
				endwhile; 
			} ?>
		
		<div class="terms_nav" style="position:relative;" >
			<?php 
					
                foreach (get_terms('deporte') as $key => $term_item):  ?>
                    <a class="<?php if($term === $term_item->slug):echo 'current'; endif; ?>" href="/index.php/<?php echo $term_item->taxonomy.'/'.$term_item->slug;?>">
                        <?php echo $term_item->name; ?>
                    </a>
            <?php endforeach;  ?>
		</div>
		
        <section class="container_posts">
		<?php
			
			while($query->have_posts()): $query->the_post(); 
				get_template_part('template-parts/tarjetita_post');
			endwhile; ?>

		<div class="container_pagination" style="width:100%;min-width:100%;display:flex;justify-content:center;" >
				<?php echo paginate_links() ?>
		</div>
		</section>	
	</article>

	<?php get_sidebar() ?>
</main>

<?php get_template_part('components/banner_footer') ?>

<?php get_footer();