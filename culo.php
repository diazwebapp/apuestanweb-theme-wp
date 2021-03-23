<?php get_header(); ?>
<?php get_template_part('components/banner_top');
$param_tag = str_replace("/","",str_replace("/tag/","",$_SERVER["PATH_INFO"]));
$query = new wp_Query(array(
    'post_type' => array('post','pronosticos'),
	'posts_per_page' => get_option('to_count_pronosticos'), 
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
    'tax_query' => array(
        array(
            'taxonomy' => $param_tag
        ),
    ),
)); ?>

<main>
	<article> 
    <?php 
    echo $param_tag;
        if(have_posts()): get_template_part('template-parts/content-slide'); endif; ?>
        <div class="terms_nav">
            <?php 
                foreach (get_terms(array('taxonomy'=>'post_tag','hide_empty' => true)) as $term_item): ?>
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

            <div class="container_pagination" style="width:100%;min-width:100%;display:flex;justify-content:center;" >
                <?php echo paginate_links();?>
            </div> 
        </section>

	</article>

    <?php get_sidebar() ?>
</main>
<?php get_footer();