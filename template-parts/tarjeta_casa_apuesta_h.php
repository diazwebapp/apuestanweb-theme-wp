 <?php
        $slogan = get_post_meta(get_the_ID(),'slogan_casa_apuesta')[0];
        $url_logo = get_post_meta(get_the_ID(),'url_logo_casa_apuesta')[0];
        $puntuacion = get_post_meta(get_the_ID(),'puntuacion_casa_apuesta')[0];
        $tiempo_pago = get_post_meta(get_the_ID(),'tiempo_pago_casa_apuesta')[0];

        $metodo_pago_1= get_post_meta(get_the_ID(),'m_p_icon_1')[0];
        $metodo_pago_2= get_post_meta(get_the_ID(),'m_p_icon_2')[0];
        $metodo_pago_3= get_post_meta(get_the_ID(),'m_p_icon_3')[0];
        $metodo_pago_4= get_post_meta(get_the_ID(),'m_p_icon_4')[0]; ?>
 <div class="tarjetita_casa_apuesta_horinzontal" >
    <div>
        <div class="casa_apuesta_img_especial">
            <img src="<?php echo $url_logo ?>" alt="<?php the_title() ?>">
        </div>
        <div>
            <b><?php echo $slogan ?></b>
        </div>
        <div>
            <b><?php echo $puntuacion . '/ 5' ?></b>
            <a href="<?php the_permalink() ?>">
                <button>ofertar</button>
            </a>
        </div>
    </div>
    <div>
        <div >
            <b>Tiempo de pago</b>
            <span><?php echo $tiempo_pago ?> días</span>
        </div>
        <div>
            <b>Metodos de pago</b>
        </div>
        <div class="metodos_pago">
            <?php if($metodo_pago_1): ?>
                <img src="<?php echo $metodo_pago_1 ?>" alt="<?php the_title() ?>">
            <?php endif; ?>

            <?php if($metodo_pago_2): ?>
                <img src="<?php echo $metodo_pago_2 ?>" alt="<?php the_title() ?>">
            <?php endif; ?>

            <?php if($metodo_pago_3): ?>
                <img src="<?php echo $metodo_pago_3 ?>" alt="<?php the_title() ?>">
            <?php endif; ?>

            <?php if($metodo_pago_4): ?>
                <img src="<?php echo $metodo_pago_4 ?>" alt="<?php the_title() ?>">
            <?php endif; ?>
        </div>
    
    </div>
</div>