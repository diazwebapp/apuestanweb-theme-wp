<?php $posts = $wpdb->get_results( 
    $wpdb->prepare("SELECT * FROM {$wpdb->prefix}posts where post_status='publish' ")
); ?>
<aside>
<div class="aside_posts">
    <h2>Ultimos pronosticos</h2>
    <ul>
        <?php foreach ($posts as $key => $post) { 

                $categorias = get_the_category($post->ID);
                $nombre_equipo_1 = get_post_meta($post->ID,"nombre_equipo_1");
                $img_equipo_1 = get_post_meta($post->ID,"img_equipo_1");
                $resena_equipo_1 = get_post_meta($post->ID,"resena_equipo_1");
                $average_equipo_1 = get_post_meta($post->ID,"average_equipo_1");

                $nombre_equipo_2 = get_post_meta($post->ID,"nombre_equipo_2");
                $img_equipo_2 = get_post_meta($post->ID,"img_equipo_2");
                $resena_equipo_2 = get_post_meta($post->ID,"resena_equipo_2");
                $average_equipo_2 = get_post_meta($post->ID,"average_equipo_2");

                $fecha_partido = get_post_meta(get_the_ID(),"fecha_partido");
                        if($post->post_type == "pronosticos"){?>
                        <a href="<?php the_permalink() ?>" class="aside_item_pronostico" >
                            <div >
                                <img src="<?php echo $img_equipo_1[0] ?>" />
                                <img src="<?php echo $img_equipo_2[0] ?>" />
                            </div>
                            <div>
                                <span>
                                    <p class="<?php if($average_equipo_2[0] < $average_equipo_1[0]){echo "bolder" ;} ?>"><?php echo $nombre_equipo_1[0] ?></p>
                                    <small class="<?php if($average_equipo_2[0] < $average_equipo_1[0]){echo "bolder" ;} ?>"><?php echo $average_equipo_1[0] ?></small>
                                </span>
                                <span>
                                    <p class="<?php if($average_equipo_2[0] > $average_equipo_1[0]){echo "bolder" ;} ?>" ><?php echo $nombre_equipo_2[0] ?></p>
                                    <small class="<?php if($average_equipo_2[0] > $average_equipo_1[0]){echo "bolder" ;} ?>"><?php echo $average_equipo_2[0] ?></small>
                                </span>
                            </div>
                            <div>
                                <p>25-11-2021</p>
                            </div>
                        </a>
                    <?php 
                    }
			}?>
    </ul>
</div>

<div class="aside_posts">
    <h2>ultimos posts</h2>
    <ul>
        <?php foreach ($posts as $key => $post) { 

                    if($post->post_type == "post"){?>
					<a href="<?php the_permalink() ?>" class="aside_item_post">
                        <div>
                            <?php the_post_thumbnail() ?>
                        </div>
                        <div>
                            <h4><?php the_title(); ?></h4>
                            <?php the_excerpt(); ?>
                        </div>
                    </a>
				<?php }
			}?>
    </ul>
</div>
</aside>