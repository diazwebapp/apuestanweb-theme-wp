<?php get_header(); ?>

<main style="margin-top:calc(var(--height-header) * 2);">
	<article> home.php
		<?php if(have_posts()){ 
			get_template_part('template-parts/content-slide');
		} 
			if(!is_front_page()):
				get_template_part('template-parts/content-home');
			endif;
			if(is_front_page()):
				// get taxonomies by post type, and print loop content filtred by term taxonomi
				set_query_var('array_taxonomy',get_term_names(get_object_taxonomies("pronosticos")));
				get_template_part('template-parts/content-archive-pronosticos');
				
			endif;
		?>
            
	</article>

	<?php get_sidebar() ?>
</main>

<?php get_template_part('components/banner_footer') ?>

<?php get_footer();