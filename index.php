<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header();   
?>

<main>
	<section>
		<article>
		<!-- Slide -->
		<?php
		 if(have_posts()){ echo do_shortcode('[aw_slide post_type="pronostico" ]');} ?>

		<!-- Navegacion de deportes -->
		<?php echo do_shortcode('[sportsmenu taxonomy="category" ]'); ?>
		<!-- Listado de posts -->
        <article class="container_posts_1">
			<?php

				while(have_posts()): the_post(); 
					get_template_part('template-parts/tarjetita_post');
				endwhile; ?>
		</article>
		<div class="container_pagination" >
			<?php echo paginate_links() ?>
		</div>
		</article>	
	</section>

	<?php get_sidebar() ?>
</main>

<?php get_footer();