
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
