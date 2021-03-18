<?php

    // Loop de post filtrado por taxonomias
        
    foreach (get_query_var('array_taxonomy') as $key => $term) { 
        $args = array(
            'post_type' => 'pronosticos',
            'posts_per_page' => get_option('to_count_pronosticos'), 
            'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
            'tax_query' => array(
                array(
                    'taxonomy' => $term->taxonomy,
                    'terms'    => $term->slug,
                ),
            ),
        ); 
        $query = new WP_Query($args);  ?>
        <section class="container_tarjetitas" >
            <h2 class="sub_title" ><?php echo $term->name; ?></h2>
            <?php 
                // The Loop
                while ( $query->have_posts() ) {
                    $query->the_post();
                    $nombre_equipo_1 = get_post_meta(get_the_ID(),"nombre_equipo_1");
                    $img_equipo_1 = get_post_meta(get_the_ID(),"img_equipo_1");
                    $resena_equipo_1 = get_post_meta(get_the_ID(),"resena_equipo_1");
                    $average_equipo_1 = get_post_meta(get_the_ID(),"average_equipo_1");

                    $nombre_equipo_2 = get_post_meta(get_the_ID(),"nombre_equipo_2");
                    $img_equipo_2 = get_post_meta(get_the_ID(),"img_equipo_2");
                    $resena_equipo_2 = get_post_meta(get_the_ID(),"resena_equipo_2");
                    $average_equipo_2 = get_post_meta(get_the_ID(),"average_equipo_2");

                    $fecha_partido = get_post_meta(get_the_ID(),"fecha_partido");

                    //consultando taxonomia de cada post, mostrando asi solo los que coincidan
                    $post_tax = wp_get_post_terms( get_the_ID(), $term->taxonomy, array( 'fields' => 'slugs' ) );
                    
                    if($post_tax[0] == $term->slug) : ?>
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
                }
            ?>  

<div class="container_pagination" style="width:100%;min-width:100%;display:flex;justify-content:center;" >
        <?php echo paginate_links();?>
</div>                
        </section>
    <?php } ?>

