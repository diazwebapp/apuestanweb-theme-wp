<?php get_header(); ?>
<?php get_template_part('components/banner_top') ?>

<main>
	<article>
        <?php
        $current_cat = str_replace("/","",str_replace("/category/","",$_SERVER["PATH_INFO"]));
            if(have_posts()) : get_template_part('template-parts/content-slide'); ?>
            <div class="terms_nav">
                <?php 
                    foreach (get_term_names(get_object_taxonomies($post->post_type)) as $key => $term_item): ?>
                        <a class="<?php if($current_cat=== $term_item->slug):echo 'current'; endif; ?>" href="/index.php/<?php echo $term_item->taxonomy.'/'.$term_item->slug ;?>">
                            <?php if($term_item->slug == 'sin-categoria'){echo __('todo','apuestanweb_lang');}else{echo $term_item->name;}; ?>
                        </a>
                <?php endforeach;  ?>
            </div>
        <section class="container_posts" >
            <?php while(have_posts()): the_post() ; 
                get_template_part('template-parts/tarjetita_post','',$current_cat);
            endwhile; endif; 
        ?>
        </section>
            
	</article>

    <?php get_sidebar() ?>
</main>
<?php get_footer();