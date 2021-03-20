<?php 
    $nombre_equipo_1 = get_post_meta(get_the_ID(),"nombre_equipo_1");
    $img_equipo_1 = get_post_meta(get_the_ID(),"img_equipo_1");
    $resena_equipo_1 = get_post_meta(get_the_ID(),"resena_equipo_1");
    $average_equipo_1 = get_post_meta(get_the_ID(),"average_equipo_1");

    $nombre_equipo_2 = get_post_meta(get_the_ID(),"nombre_equipo_2");
    $img_equipo_2 = get_post_meta(get_the_ID(),"img_equipo_2");
    $resena_equipo_2 = get_post_meta(get_the_ID(),"resena_equipo_2");
    $average_equipo_2 = get_post_meta(get_the_ID(),"average_equipo_2");

    $fecha_partido = get_post_meta(get_the_ID(),"fecha_partido");
?>
<a href="<?php the_permalink() ?>" class="tarjetita_pronostico" >
    <h3 class="title_pronostico" ><?php echo __(the_title(), 'apuestanweb-lang') ?></h3>
    <div class="equipos_pronostico" >
        <div>
            <img src="<?php if($img_equipo_1[0]){ echo $img_equipo_1[0];}else{echo "https://i.pinimg.com/originals/ae/8a/c2/ae8ac2fa217d23aadcc913989fcc34a2.png"; } ?>" />
            <p><?php if($nombre_equipo_1[0]){echo $nombre_equipo_1[0]; }else{echo __("falta equipo 1","apuestanweb-lang"); }  ?></p>
        </div>
        <div>
            <p><?php echo $fecha_partido[0] ?></p>
            <span>8:00 pm</span>
        </div>
        <div>
        <img src="<?php if($img_equipo_2[0]){ echo $img_equipo_2[0];}else{echo "https://i.pinimg.com/originals/ae/8a/c2/ae8ac2fa217d23aadcc913989fcc34a2.png"; } ?>" />
            <p><?php if($nombre_equipo_2[0]){echo $nombre_equipo_2[0]; }else{echo __("falta equipo 1","apuestanweb-lang"); } ?></p>
        </div>
    </div>
    <div class="average_pronostico" >
        <p><?php echo $average_equipo_1[0] ?></p>
        <p>%</p>
        <p><?php echo $average_equipo_2[0] ?></p>
    </div>
</a>
