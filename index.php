<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); 
?>

<main>
	<section>
		<!-- Slide -->
		<?php if(have_posts()){ echo do_shortcode('[aw_slide]');} ?>

		<!-- Navegacion de deportes -->
		<?php echo do_shortcode('[sportsmenu taxonomy="category" ]'); ?>
		<!-- Listado de posts -->
        <article class="container_posts">
		<?php

			while(have_posts()): the_post(); 
				get_template_part('template-parts/tarjetita_post');
			endwhile; ?>
		</article>	
		<div class="container_pagination" >
				<?php echo paginate_links() ?>
		</div>
	</section>

	<?php get_sidebar() ?>
</main>

<?php get_footer();