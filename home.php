<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); ?>

<main>
	<section>
		<!-- Slide -->
		<?php if(have_posts()){ get_template_part('template-parts/content-slide');} ?>

		<!-- Navegacion de deportes -->
		<div class="terms_nav">
			<?php 
                foreach (get_terms(array('taxonomy'=>'deporte','hide_empty'=>false)) as $key => $term_item):  ?>
                    <a class="<?php if($term === $term_item->slug):echo 'current'; endif; ?>" href="/index.php/<?php echo $term_item->taxonomy.'/'.$term_item->slug;?>">
                        <?php echo $term_item->name; ?>
                    </a>
            <?php endforeach;  ?>
		</div>
		<!-- Listado de posts -->
        <article class="container_posts">
		<?php

			while(have_posts()): the_post(); 
				get_template_part('template-parts/tarjetita_post');
			endwhile; ?>
		</article>	
		
		<div class="container_pagination" >
			<?php echo paginate_links();?>
		</div> 
	</section>

	<?php get_sidebar() ?>
</main>

<?php get_template_part('components/banner_footer') ?>

<?php get_footer();