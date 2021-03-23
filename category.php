<?php get_header(); ?>
<?php 
    get_template_part('components/banner_top');
    $param_cat = str_replace("/","",str_replace("/category/","",$_SERVER["PATH_INFO"]));
    $current_taxonomy = aw_taxonomy_by_post_type_and_term(get_object_taxonomies($post->post_type),$param_cat);
?>

<main>
	<article> 
        <?php
        echo $param_cat;
            if(have_posts()) : get_template_part('template-parts/content-slide'); ?>
            <div class="terms_nav">
                <?php 
                    foreach (get_terms(array('taxonomy'=>$current_taxonomy,'hide_empty'=>false)) as $key => $term_item): ?>
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
            
	</article>

    <?php get_sidebar() ?>
</main>
<?php get_footer();