<?php get_header(); ?>

<?php $current_taxonomy = aw_taxonomy_by_post_type_and_term(get_object_taxonomies($post->post_type),$term); ?>
<main>
	<section>
    <?php 
        if(have_posts()): get_template_part('template-parts/content-slide'); endif;?>
        <div class="terms_nav">
            <?php 
                if(!empty($current_taxonomy)):
                    foreach (get_terms(array('taxonomy'=>$current_taxonomy,'hide_empty' => false)) as $term_item): ?>
                        <a class="<?php if($term === $term_item->slug):echo 'current'; endif; ?>" href="<?php echo site_url().'/'.$current_taxonomy.'/'.$term_item->slug ;?>">
                            <?php echo $term_item->name; ?>
                        </a>
            <?php endforeach; else: 
                if ( has_nav_menu( 'sub_header' ) ) :
					$locations = get_nav_menu_locations();
					$menu = get_term( $locations['sub_header'], 'nav_menu' );
					$menu_items = wp_get_nav_menu_items($menu->term_id);
			
					foreach ($menu_items as $tax_term): ?>
						<a class="<?php if($term === $tax_term->title):echo 'current'; endif; ?>" href="<?php echo $tax_term->url ;?>" >
							<?php echo $tax_term->title; ?></p>
						</a>
					<?php endforeach;

				endif;
             endif;  ?>
        </div>
        <article class="container_tarjetitas" >
            <h2 class="sub_title" ><?php echo __("Pronósticos: ".str_replace("-"," ",strtoupper($term))."",'apuestanweb-lang') ?></h2>
            <?php 
                if(have_posts()):
                    while ( have_posts() ) :
                        the_post();
                        get_template_part('template-parts/tarjetita_pronostico'); 
                    endwhile;
                else: echo 'Sin datos para mostrar'; endif; 
            ?>
 
        </article>

            <div class="container_pagination" >
                <?php echo paginate_links();?>
            </div>
	</section>

    <?php get_sidebar() ?>
</main>
<?php get_footer();