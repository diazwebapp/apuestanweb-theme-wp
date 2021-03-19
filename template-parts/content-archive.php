<?php 
while(have_posts()) : the_post(); 
    if($post->post_type == 'pronosticos') : 
        $nombre_equipo_1 = get_post_meta(get_the_ID(),"nombre_equipo_1");
        $img_equipo_1 = get_post_meta(get_the_ID(),"img_equipo_1");
        $resena_equipo_1 = get_post_meta(get_the_ID(),"resena_equipo_1");
        $average_equipo_1 = get_post_meta(get_the_ID(),"average_equipo_1");

        $nombre_equipo_2 = get_post_meta(get_the_ID(),"nombre_equipo_2");
        $img_equipo_2 = get_post_meta(get_the_ID(),"img_equipo_2");
        $resena_equipo_2 = get_post_meta(get_the_ID(),"resena_equipo_2");
        $average_equipo_2 = get_post_meta(get_the_ID(),"average_equipo_2");

        $fecha_partido = get_post_meta(get_the_ID(),"fecha_partido"); ?>

        <a href="<?php the_permalink() ?>" class="tarjetita_pronostico" >
            <h3 class="title_pronostico" ><?php echo $post->post_title ?></h3>
            <div class="equipos_pronostico" >
                <div>
                    <img src="<?php echo $img_equipo_1[0] ?>" />
                    <p><?php echo $nombre_equipo_1[0] ?></p>
                </div>
                <div>
                    <p><?php echo $fecha_partido[0] ?></p>
                </div>
                <div>
                    <img src="<?php echo $img_equipo_2[0] ?>" />
                    <p><?php echo $nombre_equipo_2[0] ?></p>
                </div>
            </div>
            <div class="average_pronostico" >
                <p><?php echo $average_equipo_1[0] ?></p>
                <p>%</p>
                <p><?php echo $average_equipo_2[0] ?></p>
            </div>
        </a>
    <?php endif; 
    
    if($post->post_type == 'post') : ?>
        <a href="<?php the_permalink() ?>" class="tarjetita_post" >
            <div class="img_post" >
                <?php if(has_post_thumbnail()) : 
							the_post_thumbnail();
						else : ?> 
						<img src="https://wallpaperaccess.com/full/552032.jpg" alt="">
						<?php endif; ?>
            </div>
            <small><?php echo $post->post_date_gmt ?></small>
            <h3 class="title_post" ><?php the_title() ?></h3>
            <p>
                <?php the_excerpt() ?>
            </p>
        </a>
    <?php endif; 
endwhile;  ?>

<div class="nav-previous alignleft"><?php next_posts_link( 'Older posts' ); ?></div>
 
 
 
<div class="nav-next alignright"><?php previous_posts_link( 'Newer posts' ); ?></div>