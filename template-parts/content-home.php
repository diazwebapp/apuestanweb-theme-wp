<section class="container_tarjetitas" >
    <h2 class="sub_title" ><?php echo __('Ultimos posts','apuestanweb') ?></h2>
<?php

    while(have_posts()): the_post(); ?>
        <a href="<?php the_permalink() ?>" class="tarjetita_post" >
            <div class="img_post" >
                <?php the_post_thumbnail() ?>
            </div>
            <small><?php echo $post->post_date_gmt ?></small>
            <h3 class="title_post" ><?php the_title() ?></h3>
            <p>
                <?php the_excerpt() ?>
            </p>
        </a>
<?php endwhile; ?>

<div class="container_pagination" style="width:100%;min-width:100%;display:flex;justify-content:center;" >
        <?php echo paginate_links() ?>
</div>
</section>


<div id="container">
<div id="portfolio_content">
<div id="portfolio_wrap">

    <?php $loop = new WP_Query(array('post_type' => 'pronosticos', 'posts_per_page' => get_option('to_count_pronosticos'), 'paged' => get_query_var('paged') ? get_query_var('paged') : 1 )
); ?>
    <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <span class="title"><?php the_title(); ?></span></br>
        <?php endwhile; ?>  

<?php

$big = 999999999; // need an unlikely integer
 echo paginate_links( array(
    'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
    'format' => '?paged=%#%',
    'current' => max( 1, get_query_var('paged') ),
    'total' => $loop->max_num_pages
) );
?>
</div>
</div>
</div>
</div>

