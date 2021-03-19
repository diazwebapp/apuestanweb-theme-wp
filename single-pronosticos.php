<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); ?>

<?php get_template_part('components/banner_top') ?>

<main>
    <article>
        <?php if(have_posts()):
                    while(have_posts()):
                        the_post() ;
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
                        <div class="imagen_destacada_container" >
                            <?php if(has_post_thumbnail()) : 
                                        the_post_thumbnail();
                                    else : ?> 
                                        <img src="https://i.pinimg.com/originals/ae/8a/c2/ae8ac2fa217d23aadcc913989fcc34a2.png" alt="">
                            <?php endif; ?>
                        </div>

                        <div style="width:100%;max-width:none;background:white;height:250px;" href="<?php the_permalink() ?>" class="tarjetita_pronostico" >
                                <h3 class="title_pronostico" ><?php echo __(the_title(),'apuestanweb_lang') ?></h3>
                                <div style="height:180px;" class="equipos_pronostico" >
                                    <div style="height:150px;">
                                        <img style="width:110px;height:110px;" src="<?php echo $img_equipo_1[0] ?>" />
                                        <p><?php if($nombre_equipo_1[0]){echo $nombre_equipo_1[0]; }else{echo __("falta equipo 1","apuestanweb_lang"); }  ?></p>
                                    </div>
                                    <div style="height:150px;">
                                        <p><?php echo $fecha_partido[0] ?></p>
                                    </div>
                                    <div style="height:150px;">
                                        <img style="width:110px;height:110px;" src="<?php echo $img_equipo_2[0] ?>" />
                                        <p><?php if($nombre_equipo_2[0]){echo $nombre_equipo_2[0]; }else{echo __("falta equipo 1","apuestanweb_lang"); }  ?></p>
                                    </div>
                                </div>
                                <div style="padding-bottom:30px;" class="average_pronostico" >
                                    <p><?php echo $average_equipo_1[0] ?></p>
                                    <p>%</p>
                                    <p><?php echo $average_equipo_2[0] ?></p>
                                </div>
                        </div>
                        <?php the_content() ?>
            <?php endwhile; endif; ?>
    </article>


    <?php get_sidebar() ?>
</main>

<?php get_footer();