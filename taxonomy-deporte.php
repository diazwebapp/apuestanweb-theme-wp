<?php get_header(); ?>

<main>
	<section>
    <?php 
        if(have_posts()): get_template_part('template-parts/content-slide'); endif;?>
        <div class="terms_nav">
            <?php 
                foreach (get_terms(array('taxonomy'=>'deportes','hide_empty' => true)) as $term_item): if($term->parent == 0): ?>
                    <a class="<?php if($term === $term_item->slug):echo 'current'; endif; ?>" href="<?php echo site_url().'\deportes/'.$term_item->slug ;?>">
                        <?php echo $term_item->name; ?>
                    </a>
            <?php endif; endforeach; ?>
            </div>
            <?php ?>

            <?php  if($term !=='' && $term){
                echo do_shortcode('[pronosticos deporte='.$term.']');
            } ?>
        
	</section>

    <?php get_sidebar() ?>
</main>
<?php get_footer();