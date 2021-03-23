<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); 
$args = array(
	'post_type' => 'pronosticos',
	'posts_per_page' => get_option('to_count_pronosticos'), 
	'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
	'tax_query' => array(
		array(
			'taxonomy' => $term->taxonomy,
			'terms'    => $term->slug,
		),
	),
); 
$cards_cpt = new WP_Query($args);
?>

<main style="margin-top:calc(var(--height-header) * 2);">
	<article> index
		<!-- Slide -->
		<?php if($cards_cpt->have_posts()){ get_template_part('template-parts/content-slide');} ?>

		<!-- Navegacion de deportes -->
		<div class="terms_nav">
			<?php 
                foreach (get_terms(array('taxonomy'=>'deportes','hide_empty'=>false)) as $key => $term_item):  ?>
                    <a class="<?php if($term === $term_item->slug):echo 'current'; endif; ?>" href="/index.php/<?php echo $term_item->taxonomy.'/'.$term_item->slug;?>">
                        <?php echo $term_item->name; ?>
                    </a>
            <?php endforeach;  ?>
		</div>
		<!-- Listado de posts -->
        <section class="container_posts">
		<?php

			while($cards_cpt->have_posts()): $cards_cpt->the_post(); 
				get_template_part('template-parts/tarjetita_post');
			endwhile; ?>
		</section>	
		<div class="container_pagination" style="width:100%;min-width:100%;display:flex;justify-content:center;" >
				<?php echo paginate_links() ?>
		</div>
	</article>

	<?php get_sidebar() ?>
</main>

<?php get_template_part('components/banner_footer') ?>

<?php get_footer();