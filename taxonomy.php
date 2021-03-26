<?php get_header(); ?>

<?php $current_taxonomy = aw_taxonomy_by_post_type_and_term(get_object_taxonomies($post->post_type),$term); ?>
<main>
	<article>
    <?php 
        if(have_posts()): get_template_part('template-parts/content-slide'); endif;?>
        <div class="terms_nav">
            <?php 
                if(!empty($current_taxonomy)):
                    foreach (get_terms(array('taxonomy'=>$current_taxonomy,'hide_empty' => false)) as $term_item): ?>
                        <a class="<?php if($term === $term_item->slug):echo 'current'; endif; ?>" href="/index.php/<?php echo $current_taxonomy.'/'.$term_item->slug ;?>">
                            <?php echo $term_item->name; ?>
                        </a>
            <?php endforeach; else: ?>
                <a class="current" href="<?php home_url() ;?>">
                    <?php echo __("No hay datos",'apuestanweb-lang') ?>
            </a>
            <?php endif;  ?>
        </div>
        <section class="container_tarjetitas" >
            <h2 class="sub_title" ><?php echo __("Pronósticos: ".str_replace("-"," ",strtoupper($term))."",'apuestanweb-lang') ?></h2>
            <?php 
                if(have_posts()):
                    while ( have_posts() ) :
                        the_post();
                        get_template_part('template-parts/tarjetita_pronostico'); 
                    endwhile;
                else: echo 'Sin datos para mostrar'; endif; 
            ?>

            <div class="container_pagination" >
                <?php echo paginate_links();?>
            </div> 
        </section>

	</article>

    <?php get_sidebar() ?>
</main>
<?php get_footer();