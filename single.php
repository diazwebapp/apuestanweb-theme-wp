<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); ?>

<?php get_template_part('components/banner_top') ?>

<main>
    <article>
        <?php if(have_posts()): while(have_posts()): the_post(); ?>
                <div class="imagen_destacada_container" ><?php the_post_thumbnail() ?></div>
                <h1><?php echo __(get_the_title(),'apuestanweb-lang') ?></h1>
                <?php echo __(get_the_content(),'apuestanweb-lang') ?>
                    
        <?php endwhile; endif; ?>
    </article>


    <?php get_sidebar() ?>
</main>

<?php get_footer();