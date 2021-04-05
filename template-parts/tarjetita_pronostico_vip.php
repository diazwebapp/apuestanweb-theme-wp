<?php 
    $current_user = wp_get_current_user();
    $nombre_equipo_1 = get_post_meta(get_the_ID(),"nombre_equipo_1");
    $img_equipo_1 = get_post_meta(get_the_ID(),"img_equipo_1");
    $resena_equipo_1 = get_post_meta(get_the_ID(),"resena_equipo_1");
    $average_equipo_1 = get_post_meta(get_the_ID(),"average_equipo_1");

    $nombre_equipo_2 = get_post_meta(get_the_ID(),"nombre_equipo_2");
    $img_equipo_2 = get_post_meta(get_the_ID(),"img_equipo_2");
    $resena_equipo_2 = get_post_meta(get_the_ID(),"resena_equipo_2");
    $average_equipo_2 = get_post_meta(get_the_ID(),"average_equipo_2");

    $fecha_partido = get_post_meta(get_the_ID(),"fecha_partido");
    $estado_pronostico = get_post_meta(get_the_ID(),"estado_pronostico");
    $acceso_pronostico = get_post_meta(get_the_ID(),"acceso_pronostico");

    $static = statics_user($post->post_author);

?>
<a href="<?php the_permalink() ?>" class="tarjetita_pronostico_vip" >
    <div>
        <div>
            <small><?php echo $nombre_equipo_1[0].' vs '.$nombre_equipo_2[0] ?></small>
            <h2><?php if($average_equipo_1[0] > $average_equipo_2[0]):echo $nombre_equipo_1[0]; else: echo $nombre_equipo_2[0]; endif; ?></h2>
        </div>
        <?php the_excerpt() ?>
    </div>
    <div>
    <?php echo get_avatar( get_the_author_meta('email')); ?>
        <p><?php the_author() ?></p>
        <p><?php echo $static['total_s'] .'-'. $static['total_f'] . '('.$static['average'].') T'.$static['total_c']?></p>
    </div>
</a>
