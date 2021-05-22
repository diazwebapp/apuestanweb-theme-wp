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
            <small>
                <?php 
                    echo $nombre_equipo_1[0] . ' ' . $average_equipo_1[0] .' vs '. $nombre_equipo_2[0] . ' ' . $average_equipo_2[0] . ' | ' . $fecha_partido[0]
                ?>
            </small>
            <h2 style="position:relative;" >
                <?php if($average_equipo_1[0] > $average_equipo_2[0]):echo $nombre_equipo_1[0]; else: echo $nombre_equipo_2[0]; endif; ?> 
                <span style="position:absolute;right:10px;font-size:14px;
                <?php 
                    if($estado_pronostico[0] == 'no_acertado'):echo 'background:orange;color:white;';
                    elseif($estado_pronostico[0] == 'acertado'):echo 'background:lightgreen;color:grey;';
                    else:echo 'background:grey;color:white;';endif;
                ?>padding:5px 10px;border-radius:4px;" >
                    <?php 
                        if($estado_pronostico[0] == 'no_acertado') : echo 'Fail'; endif;  
                        if($estado_pronostico[0] == 'acertado') : echo 'Win'; endif; 
                        if($estado_pronostico[0] == 'indefinido') : echo 'waiting'; endif; 
                    ?>
                </span>
            </h2>
        </div>
        <?php the_excerpt() ?>
    </div>
    <div>
    <?php echo get_avatar( get_the_author_meta('email')); ?>
        <p><?php the_author() ?></p>
        <p style="display:inline;margin:5px;font-size:14px;background:lightgreen;padding:5px 10px;border-radius:4px;color:grey;">
            <?php echo get_the_author_meta('pronosticos_acertados') . ' Acertados' ?>
        </p>

        <p style="display:inline;margin:5px;font-size:14px;background:orange;padding:5px 10px;border-radius:4px;color:white;">
            <?php echo get_the_author_meta('pronosticos_no_acertados') . ' Fallidos' ?>
        </p>

        <p><?php echo get_the_author_meta('average_aciertos'). ' Average' ?></p>
    </div>
</a>
