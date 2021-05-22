<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header();

$author_posts = new wp_Query(array(
    'post_type' => $post->post_type,
    'author' => $post->post_author,
    'post_not_in' => array( $post->ID ),
    'tax_query'=>array(
        array(
            'taxonomy' => 'deporte',
            'terms' => 'all'
        )
    )
));


?>


<main>
    <section>
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
                        $cuota_empate_pronostico = get_post_meta(get_the_ID(),"cuota_empate_pronostico");
                        $puntuacion = get_post_meta($post->ID,'puntuacion_p');
                        ?>

                       
                        <div href="<?php the_permalink() ?>" class="tarjetita_pronostico single_pronostico" >
                            <h3 class="title_pronostico" ><?php __(the_title(),'apuestanweb-lang') ?></h3>
                            <div class="equipos_pronostico" >
                                <div >
                                    <img src="<?php echo $img_equipo_1[0] ?>" />
                                    <p><?php if($nombre_equipo_1[0]){echo $nombre_equipo_1[0]; }else{echo __("falta equipo 1","apuestanweb-lang"); }  ?></p>
                                </div>
                                <div >
                                    <p><?php echo $fecha_partido[0] ?></p>
                                </div>
                                <div >
                                    <img  src="<?php echo $img_equipo_2[0] ?>" />
                                    <p><?php if($nombre_equipo_2[0]){echo $nombre_equipo_2[0]; }else{echo __("falta equipo 1","apuestanweb-lang"); }  ?></p>
                                </div>
                            </div>
                            <div class="average_pronostico" >
                                <p><?php echo ceil(1 / $average_equipo_1[0] * 100) ?> %</p>
                                <p><?php echo ceil( 1 / $cuota_empate_pronostico[0] * 100) ?> %</p>
                                <p><?php echo ceil( 1 / $average_equipo_2[0] * 100) ?> %</p>
                            </div>
                        </div>
                        <article>
                            <?php __(the_content(),'apuestanweb-lang') ?>
                            <?php echo do_shortcode("[puntuacion_pronostico]"); ?>
                        </article>
                        <?php comments_template(); ?> 
                        
            <?php endwhile; endif;
        
            set_query_var('data_card_author',array('post'=>$post,'pronosticos'=>$author_posts));
            get_template_part('components/card_author');
            
            
            // posts del autor -->
			if($author_posts->have_posts()): ?>
				<article class="container_posts">
					<?php
						while($author_posts->have_posts()): $author_posts->the_post(); 
                            
							get_template_part('template-parts/tarjetita_post');
						endwhile; ?>
						
				</article>
				<div class="container_pagination" >
					<?php echo paginate_links(array(
							'base' => str_replace( '9999999999', '%#%', esc_url( get_pagenum_link( '9999999999') ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var('paged') ),
							'total' => $author_posts->max_num_pages
						) ) ?>
					
				</div>
            <?php endif; ?>
    </section>


    <?php get_sidebar() ?>
</main>

<?php get_footer();