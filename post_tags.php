<?php get_header(); ?>
<?php 
    get_template_part('components/banner_top');
?>

<main>
	<article> tags
		<?php
		var_dump($tag);
		if(have_posts()){
			while(have_posts()){
				the_post();
				the_title();
			}
		}
		?> 
	</article>

    <?php get_sidebar() ?>
</main>
<?php get_footer();