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
    $cuota_empate_pronostico = get_post_meta(get_the_ID(),"cuota_empate_pronostico");

?>
<div class="tarjetita_pronostico" >
    <h3 class="title_pronostico" ><?php echo _e($nombre_equipo_1[0].' vs '.$nombre_equipo_2[0], 'apuestanweb-lang') ?></h3>
    <?php if($acceso_pronostico[0] !== 'free'):?>
        <b data="<?php echo $acceso_pronostico[0] ?>" class="sticker_tarjetita" ></b>
    <?php endif; ?>
    <div class="equipos_pronostico" >
        <div>
            <img loading="lazy" src="<?php if($img_equipo_1[0]){ echo $img_equipo_1[0];}else{ echo get_template_directory_uri(). '/assets/images/hh2.png'; } ?>" />
            <?php 
            if($acceso_pronostico !== 'free'): 
                    if($acceso_pronostico == $current_user->roles[0] || $current_user->roles[0] == 'administrator' || $current_user->roles[0] == 'author' || $current_user->roles[0] == 'editor'){ ?>
                            <p class="<?php if($average_equipo_2[0] < $average_equipo_1[0]){echo "bolder flechita" ;} ?>"><?php echo $nombre_equipo_1[0] ?></p>  
                    <?php }else{ ?>
                        <p ><?php echo $nombre_equipo_1[0] ?></p>   
                    <?php }
                else: ?>
                    <p ><?php echo $nombre_equipo_1[0] ?></p> 
            <?php endif; ?>    
        </div>
        <div>
            <p><?php echo $fecha_partido[0] ?></p>
            <span>8:00 pm</span>
        </div>
        <div>
        <img loading="lazy" src="<?php if($img_equipo_2[0]){ echo $img_equipo_2[0];}else{ echo get_template_directory_uri(). '/assets/images/hh2.png'; } ?>" />
        <?php 
            if($acceso_pronostico !== 'free'): 
                    if($acceso_pronostico == $current_user->roles[0] || $current_user->roles[0] == 'administrator' || $current_user->roles[0] == 'author' || $current_user->roles[0] == 'editor'){ ?>
                            <p class="<?php if($average_equipo_2[0] > $average_equipo_1[0]){echo "bolder flechita" ;} ?>"><?php echo $nombre_equipo_2[0] ?></p>  
                    <?php }else{ ?>
                        <p ><?php echo $nombre_equipo_2[0] ?></p>   
                    <?php }
                else: ?>
                    <p ><?php echo $nombre_equipo_2[0] ?></p> 
            <?php endif; ?> 
        </div>
    </div>
    <?php  //si no es free o no tienen rango necesario
            if($acceso_pronostico[0] !== 'free'):
                if($acceso_pronostico[0] == $current_user->roles[0] || $current_user->roles[0] == 'administrator' || $current_user->roles[0] == 'author' || $current_user->roles[0] == 'editor' ): ?>
                        <div class="average_pronostico" >
                            <p>
                                <?php echo ceil(1 / $average_equipo_1[0] * 100)  ?>%
                            </p>
                            <p>
                                <?php echo ceil(1 / $cuota_empate_pronostico[0] * 100) ?> %
                            </p>
                            <p>
                                <?php echo ceil(1 / $average_equipo_2[0] * 100)  ?>%
                            </p>
                        </div>
                        <a href="<?php the_permalink() ?>">
                            Ver pronostico
                        </a>
                    <?php else:?>
                        <button class="block_content"></button>
                <?php endif; 
                //si el contenido es free o tienen el rango necesario
            else: ?>
                    <div class="average_pronostico" >
                            <p>
                                <?php echo ceil(1 / $average_equipo_1[0] * 100)  ?>%
                            </p>
                            <p>
                                <?php echo ceil(1 / $cuota_empate_pronostico[0] * 100) ?> %
                            </p>
                            <p>
                                <?php echo ceil(1 / $average_equipo_2[0] * 100)  ?>%
                            </p>
                    </div>
                    <a href="<?php the_permalink() ?>">
                        Ver pronostico
                    </a>
    <?php  endif;?>
   
</div>
