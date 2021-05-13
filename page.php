<?php 
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); ?>

<main>
    <section>
        <div class="imagen_destacada_container">
        <?php if(has_post_thumbnail()) : 
                    the_post_thumbnail();
               endif; ?>
        </div>
        <article>
            <?php
                if(have_posts()):
                    while(have_posts()):
                        the_post();
                        the_content(); 
                    endwhile; endif;
            ?>
        </article>
        <div class="container_pagination" >
            <?php echo paginate_links();?>
        </div> 
    </section>

    <?php get_sidebar() ?>
</main>
<?php get_footer();