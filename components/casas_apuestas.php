<?php 

$casas_apuestas = new wp_query(array(
    "post_type"=>"casaapuesta"
));

while($casas_apuestas->have_posts()) : $casas_apuestas->the_post();
    $slogan = get_post_meta(get_the_ID(),'slogan_casa_apuesta');
    $url_logo = get_post_meta(get_the_ID(),'url_logo_casa_apuesta');
    $puntuacion = get_post_meta(get_the_ID(),'puntuacion_casa_apuesta');
    ?>
    
    <div class="tarjeta_casa_apuesta">
        <div>
            <?php the_post_thumbnail() ?>
            <div class="circle" >
                <img src="<?php echo $url_logo[0] ?>" />
            </div>
            <div class="rectangle" ><?php echo $puntuacion[0] .' / 5 ' ?><span >✭</span></div>
        </div>
        <div>
            <h3 style="margin: 3px 0;"><?php echo $slogan[0] ?></h3>
            <a class="btn_outline" href="<?php the_permalink() ?>" ><?php echo __('Start Now','apuestanweb-lang') ?></a>
        </div>
    </div>
    <?php endwhile; ?>
    