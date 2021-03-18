<?php 

$posts = $wpdb->get_results( 
    $wpdb->prepare("SELECT * FROM {$wpdb->prefix}posts where post_status='publish' and post_type='post' ")
); 

foreach ($posts as $key => $post) { 

    $categorias = get_the_category($post->ID);
    $nombre_equipo_1 = get_post_meta($post->ID,"nombre_equipo_1");
    $img_equipo_1 = get_post_meta($post->ID,"img_equipo_1");
    $resena_equipo_1 = get_post_meta($post->ID,"resena_equipo_1");
    $average_equipo_1 = get_post_meta($post->ID,"average_equipo_1");

    $nombre_equipo_2 = get_post_meta($post->ID,"nombre_equipo_2");
    $img_equipo_2 = get_post_meta($post->ID,"img_equipo_2");
    $resena_equipo_2 = get_post_meta($post->ID,"resena_equipo_2");
    $average_equipo_2 = get_post_meta($post->ID,"average_equipo_2");

    $fecha_partido = get_post_meta(get_the_ID(),"fecha_partido");?>
            <a href="<?php the_permalink() ?>" class="tarjetita_post" >
                <div class="img_post" >
                    <?php the_post_thumbnail() ?>
                </div>
                <small><?php echo $post->post_date_gmt ?></small>
                <h3 class="title_post" ><?php  _e($post->post_title,'apuestanweb') ?></h3>
                <p>
                    <?php the_excerpt() ?>
                </p>
            </a>
            <?php } ?>