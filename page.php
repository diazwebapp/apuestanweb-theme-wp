<?php 
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); ?>

<main style="margin-top:calc(var(--height-header) * 2);">
    <article> fgdfg
        <div class="imagen_destacada_container">
        <?php if(has_post_thumbnail()) : 
                    the_post_thumbnail();
               endif; ?>
        </div>
        <section>
            <?php
                if(have_posts()):
                    while(have_posts()):
                        the_post();
                        the_content(); 
                    endwhile; endif;
            ?>
        </section>

    </article>

    <?php get_sidebar() ?>
</main>
<?php get_footer();