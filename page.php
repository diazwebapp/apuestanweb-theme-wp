<?php 
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); ?>

<main style="margin-top:calc(var(--height-header) * 2);">
    <article>
    
        <div class="imagen_destacada_container">
        <?php if(has_post_thumbnail()) : 
                    the_post_thumbnail();
                else : ?> 
                    <img src="https://i.pinimg.com/originals/ae/8a/c2/ae8ac2fa217d23aadcc913989fcc34a2.png" alt="">
        <?php endif; ?>
        </div>
        <section>
            <h1><?php the_title() ?></h1>
            <?php
                the_content(); 
            ?>
        </section>

    </article>

    <?php get_sidebar() ?>
</main>
<?php get_footer();