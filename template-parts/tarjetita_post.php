<div href="<?php the_permalink() ?>" class="tarjetita_post" >
    <div class="img_post" >
        <?php if(has_post_thumbnail()) : 
                    the_post_thumbnail();
                else : ?> 
                <img src="<?php echo get_template_directory_uri(). '/assets/images/hh2.png'; ?>" alt="">
        <?php endif; ?>
    </div>
    <p><?php if($post->post_excerpt == "" || !$post->post_excerpt){ echo $post->post_title ;}else{ echo $post->post_excerpt; }?></p>
    <a class="btn_outline" href="<?php the_permalink() ?>">Ver más</a>
</div>