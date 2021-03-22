<?php get_header(); ?>
<?php get_template_part('components/banner_top');
$current_taxonomy = aw_taxonomy_by_post_type_and_term(get_object_taxonomies($post->post_type),$term); ?>
<main>
	<article> 
    <?php 
        if(have_posts()): get_template_part('template-parts/content-slide'); endif;?>
        <div class="terms_nav">
            <?php 
                foreach (get_terms(array('taxonomy'=>$current_taxonomy,'hide_empty' => false)) as $term_item): ?>
                    <a class="<?php if($term === $term_item->slug):echo 'current'; endif; ?>" href="/index.php/<?php echo 'deportes/'.$term_item->slug ;?>">
                        <?php echo $term_item->name; ?>
                    </a>
            <?php endforeach;  ?>
        </div>
        <section class="container_tarjetitas" >
            <h2 class="sub_title" ><?php echo __("Pronósticos: ".strtoupper($term)."",'apuestanweb_lang') ?></h2>
            <?php 
                while ( have_posts() ) :
                    the_post();
                    get_template_part('template-parts/tarjetita_pronostico'); 
                endwhile; ?>

            <div class="container_pagination" style="width:100%;min-width:100%;display:flex;justify-content:center;" >
                <?php echo paginate_links();?>
            </div> 
        </section>

	</article>

    <?php get_sidebar() ?>
</main>
<?php get_footer();