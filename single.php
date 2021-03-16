<?php get_header(); ?>

<?php get_template_part('components/banner_top') ?>

<main>
    <article>
        <?php if(have_posts()){
                    while(have_posts()){
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
                        <div class="imagen_destacada_container" ><?php the_post_thumbnail() ?></div>
                        
                    <?php if($post->post_type == 'pronosticos'){ ?>
                        <div style="width:100%;max-width:none;background:white;height:250px;" href="<?php the_permalink() ?>" class="tarjetita_pronostico" >
                                <h3 class="title_pronostico" ><?php the_title() ?></h3>
                                <div style="height:180px;" class="equipos_pronostico" >
                                    <div style="height:150px;">
                                        <img style="width:110px;height:110px;" src="<?php echo $img_equipo_1[0] ?>" />
                                        <p><?php echo $nombre_equipo_1[0] ?></p>
                                    </div>
                                    <div style="height:150px;">
                                        <p><?php echo $fecha_partido[0] ?></p>
                                    </div>
                                    <div style="height:150px;">
                                        <img style="width:110px;height:110px;" src="<?php echo $img_equipo_2[0] ?>" />
                                        <p><?php echo $nombre_equipo_2[0] ?></p>
                                    </div>
                                </div>
                                <div style="padding-bottom:30px;" class="average_pronostico" >
                                    <p><?php echo $average_equipo_1[0] ?></p>
                                    <p>%</p>
                                    <p><?php echo $average_equipo_2[0] ?></p>
                                </div>
                        </div>
                       <?php the_content() ?>
                    <?php }else{ ?>
                        <?php the_content() ?>
                    <?php } /**end if */
                 } /**End while */ 
        } ?>
    </article>


    <?php get_sidebar() ?>
</main>

<?php get_footer();