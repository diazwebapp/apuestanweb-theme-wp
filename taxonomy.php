<?php get_header(); ?>

<?php $current_taxonomy = aw_taxonomy_by_post_type_and_term(get_object_taxonomies($post->post_type),$term); ?>
<main>
	<section>
    <?php 
        if(have_posts()): get_template_part('template-parts/content-slide'); endif;?>
        <div class="terms_nav">
            <?php 
                if(!empty($current_taxonomy)):
                    foreach (get_terms(array('taxonomy'=>$current_taxonomy,'hide_empty' => true)) as $term_item): if($term->parent == 0): ?>
                        <a class="<?php if($term === $term_item->slug):echo 'current'; endif; ?>" href="<?php echo site_url().'/'.$current_taxonomy.'/'.$term_item->slug ;?>">
                            <?php echo $term_item->name; ?>
                        </a>
            <?php endif; endforeach; ?>
            </div>
            <?php  echo do_shortcode('[pronosticos deporte='.$term.']'); 
            endif; ?>
        
	</section>

    <?php get_sidebar() ?>
</main>
<?php get_footer();