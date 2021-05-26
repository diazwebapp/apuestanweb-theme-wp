<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); ?>

<main>
	<section>
        <?php if(have_posts()):
			get_template_part('template-parts/content-slide');
			
        	echo do_shortcode('[pronosticos]') ?>
			
		<?php endif; ?> 
             
	</section>

	<?php get_sidebar() ?>
</main>

<?php get_footer();