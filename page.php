<?php get_header(); ?>

<main style="margin-top:calc(var(--height-header) * 2);">
    <article>  page.php
    
        <div class="imagen_destacada_container">
            <?php the_post_thumbnail() ?>
        </div>
        <h1><?php the_title() ?></h1>

        <?php the_content(); ?>

    </article>

    <?php get_sidebar() ?>
</main>
<?php get_footer();