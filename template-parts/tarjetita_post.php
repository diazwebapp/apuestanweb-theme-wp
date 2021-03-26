<a href="<?php the_permalink() ?>" class="tarjetita_post" >
    <div class="img_post" >
        <?php if(has_post_thumbnail()) : 
                    the_post_thumbnail();
                else : ?> 
                <img src="<?php echo get_template_directory_uri(). '/assets/images/hh2.png'; ?>" alt="">
        <?php endif; ?>
    </div>
    <small><span style="color:var(--secondary-color);" ><?php echo strtoupper($args) ?></span> <?php the_date('y-m-d')?></small>
    <h3 class="title_post" ><?php echo sprintf(__(the_title(),'apuestanweb-lang')) ?></h3>
    <?php echo __(the_excerpt(),'apuestanweb-lang') ?>
</a>