<?php get_header(); ?>
<?php 
$param_tag = str_replace("/","",str_replace("/tag/","",$_SERVER["PATH_INFO"])); 
$current_taxonomy = aw_taxonomy_by_post_type_and_term(get_object_taxonomies($post->post_type),$param_tag);
?>

<main>
	<article> 
    <?php 

        if(have_posts()): get_template_part('template-parts/content-slide'); endif; ?>
        <div class="terms_nav">
            <?php 
                foreach (get_terms(array('taxonomy'=>'post_tag','hide_empty' => false)) as $term_item): ?>
                    <a class="<?php if($term === $term_item->slug):echo 'current'; endif; ?>" href="/index.php/<?php echo 'tag/'.$term_item->slug ;?>">
                        <?php echo __($term_item->name,'apuestanweb-lang'); ?>
                    </a>
            <?php endforeach;  ?>
        </div>
        <section class="container_posts" >
            <?php 
                while (have_posts() ) :
                    the_post();
                    get_template_part('template-parts/tarjetita_post'); 
                endwhile; ?>

            <div class="container_pagination" >
                <?php echo paginate_links();?>
            </div> 
        </section>

	</article>

    <?php get_sidebar() ?>
</main>
<?php get_footer();