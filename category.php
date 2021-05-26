<?php get_header(); ?>
<?php 
    $param_cat = str_replace("/","",str_replace("/category/","",$_SERVER["PATH_INFO"]));
    $current_taxonomy = aw_taxonomy_by_post_type_and_term(get_object_taxonomies($post->post_type),$param_cat);
?>

<main>
	<article> 
        <?php
            if(have_posts()) : get_template_part('template-parts/content-slide'); ?>
            <div class="terms_nav">
                <?php 
                    foreach (get_terms(array('taxonomy'=>'category','hide_empty'=>true)) as $key => $term_item): ?>
                        <a class="<?php if($param_cat=== $term_item->slug):echo 'current'; endif; ?>" href="/index.php/<?php echo $current_taxonomy.'/'.$term_item->slug ;?>">
                            <?php if($term_item->slug == 'sin-categoria'){echo __('todo','apuestanweb-lang');}else{echo $term_item->name;}; ?>
                        </a>
                <?php endforeach;  ?>
            </div>
        <section class="container_posts" >
            <?php while(have_posts()): the_post() ; 
                get_template_part('template-parts/tarjetita_post');
            endwhile; endif; 
        ?>
        </section>
        <div class="container_pagination">
            <?php echo paginate_links() ?> 
        </div>
	</article>

    <?php get_sidebar() ?>
</main>
<?php get_footer();