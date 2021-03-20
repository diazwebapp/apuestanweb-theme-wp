<?php get_header(); ?>
<?php get_template_part('components/banner_top') ?>

<main>
	<article> 
    <?php
    $current_cat = str_replace("/","",str_replace("/deportes/","",$_SERVER["PATH_INFO"]));
    echo $current_cat;
        if(have_posts()): get_template_part('template-parts/content-slide'); endif;?>
        <div class="terms_nav">
            <?php 
                foreach (get_term_names(get_object_taxonomies($post->post_type)) as $key => $term_item): ?>
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