<?php 

$posts = $wpdb->get_results( 
    $wpdb->prepare("SELECT * FROM {$wpdb->prefix}posts where post_status='publish' and post_type='pronosticos' ")
); 

foreach ($posts as $key => $post) { 

    $post_cats = get_the_category($post->ID);
    $nombre_equipo_1 = get_post_meta($post->ID,"nombre_equipo_1");
    $img_equipo_1 = get_post_meta($post->ID,"img_equipo_1");
    $resena_equipo_1 = get_post_meta($post->ID,"resena_equipo_1");
    $average_equipo_1 = get_post_meta($post->ID,"average_equipo_1");

    $nombre_equipo_2 = get_post_meta($post->ID,"nombre_equipo_2");
    $img_equipo_2 = get_post_meta($post->ID,"img_equipo_2");
    $resena_equipo_2 = get_post_meta($post->ID,"resena_equipo_2");
    $average_equipo_2 = get_post_meta($post->ID,"average_equipo_2");

    $fecha_partido = get_post_meta(get_the_ID(),"fecha_partido"); 
    foreach($post_cats as $post_cat){
        if($post_cat->name == $category_wp->name){?>
    
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
    <?php } } }?>
    
    <?php ?>