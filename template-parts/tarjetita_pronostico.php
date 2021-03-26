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
    $tags = wp_get_post_tags(get_the_ID());
    $fecha_partido = get_post_meta(get_the_ID(),"fecha_partido");
    $estado_pronostico = get_post_meta(get_the_ID(),"estado_pronostico");
?>
<div class="tarjetita_pronostico" >
    <h3 class="title_pronostico" ><?php echo __($estado_pronostico[0], 'apuestanweb-lang') ?></h3>
    <div class="equipos_pronostico" >
        <div>
            <img src="<?php if($img_equipo_1[0]){ echo $img_equipo_1[0];}else{ echo get_template_directory_uri(). '/assets/images/hh2.png'; } ?>" />
            <p><?php if($nombre_equipo_1[0]){echo $nombre_equipo_1[0]; }else{echo __("falta equipo 1","apuestanweb-lang"); }  ?></p>
        </div>
        <div>
            <p><?php echo $fecha_partido[0] ?></p>
            <span>8:00 pm</span>
        </div>
        <div>
        <img src="<?php if($img_equipo_2[0]){ echo $img_equipo_2[0];}else{ echo get_template_directory_uri(). '/assets/images/hh2.png'; } ?>" />
            <p><?php if($nombre_equipo_2[0]){echo __($nombre_equipo_2[0],'apuestanweb-lang'); }else{echo __("falta equipo 1","apuestanweb-lang"); } ?></p>
        </div>
    </div>
    <?php  
            if(count($tags) > 0):
                foreach($tags as $tag):
                    if($tag->name == $current_user->roles[0] || $current_user->roles[0] == 'administrator'){ ?>
                        <div class="average_pronostico" >
                            <p>
                                <?php echo ceil(1 / $average_equipo_1[0] * 100); ?>%
                            </p>
                            <p>
                                <?php echo $tag->name; ?>
                            </p>
                            <p>
                                <?php echo ceil(1 / $average_equipo_2[0] * 100);?>%
                            </p>
                        </div>
                        <a href="<?php the_permalink() ?>">
                            Ver pronostico
                        </a>
                    <?php }else{?>
                        <button class="block_content"></button>
                    <?php }
                endforeach; endif;
            if(count($tags) == 0): ?>
                    <div class="average_pronostico" >
                            <p>
                                <?php echo ceil(1 / $average_equipo_1[0] * 100); ?>%
                            </p>
                            <p>
                                <?php echo $tag->name; ?>
                            </p>
                            <p>
                                <?php echo ceil(1 / $average_equipo_2[0] * 100);?>%
                            </p>
                    </div>
                    <a href="<?php the_permalink() ?>">
                        Ver pronostico
                    </a>
    <?php   endif;?>
   
</div>
