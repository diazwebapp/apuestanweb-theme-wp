<?php get_header(); ?>
<?php get_template_part('components/banner_top') ?>

<main>
	<article>
    <?php
   
        if(have_posts()) : while(have_posts()): the_post() ; ?>
            <section>
                <h2 class="sub_title" ><?php the_title() ?></h2>
            </section>
        <?php endwhile; endif;  echo $term;
    ?>
            
	</article>

    <?php get_sidebar() ?>
</main>
<?php get_footer();