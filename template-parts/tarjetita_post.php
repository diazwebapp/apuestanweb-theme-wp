<a href="<?php the_permalink() ?>" class="tarjetita_post" >
    <div class="img_post" >
        <?php if(has_post_thumbnail()) : 
                    the_post_thumbnail();
                else : ?> 
                <img src="https://i.pinimg.com/originals/ae/8a/c2/ae8ac2fa217d23aadcc913989fcc34a2.png" alt="">
        <?php endif; ?>
    </div>
    <small><span style="color:var(--secondary-color);" ><?php echo strtoupper($args) ?></span> <?php the_date('y-m-d')?></small>
    <h3 class="title_post" ><?php echo __(the_title(),'apuestanweb_lang') ?></h3>
    <p>
        <?php echo __(the_excerpt(),'apuestanweb_lang') ?>
    </p>
</a>