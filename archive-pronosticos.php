<?php get_header(); ?>
<?php 
$taxonomies = get_object_taxonomies($post->post_type); 
function erick($taxonomies){
    foreach ($taxonomies as $key => $name) {
        return get_terms($name);
    };
}
$taxs = erick($taxonomies);

?>
<main style="margin-top:calc(var(--height-header) * 2);">
	<article> 

    <?php if(have_posts()){ ?>
			<div class="slide_home" >
			<?php while(have_posts()){ 
				the_post() ;
				$nombre_equipo_1 = get_post_meta(get_the_ID(),"nombre_equipo_1");
                $img_equipo_1 = get_post_meta(get_the_ID(),"img_equipo_1");
                $resena_equipo_1 = get_post_meta(get_the_ID(),"resena_equipo_1");
                $average_equipo_1 = get_post_meta(get_the_ID(),"average_equipo_1");
            
                $nombre_equipo_2 = get_post_meta(get_the_ID(),"nombre_equipo_2");
                $img_equipo_2 = get_post_meta(get_the_ID(),"img_equipo_2");
                $resena_equipo_2 = get_post_meta(get_the_ID(),"resena_equipo_2");
                $average_equipo_2 = get_post_meta(get_the_ID(),"average_equipo_2");
            
                $fecha_partido = get_post_meta(get_the_ID(),"fecha_partido");?>

					<div class="slide_home_item" >
						<?php the_post_thumbnail(); ?>
						<div class="slide_title_pronostico">
									
                            <h2>
                                <?php echo $nombre_equipo_1[0] ?>
                            </h2>
                            <h2>
                                <?php echo $nombre_equipo_2[0] ?>
                            </h2>
                            <div class="slide_average_pronostico" >
                                <p><?php echo $average_equipo_1[0] ?></p>
                                <p>%</p>
                                <p><?php echo $average_equipo_2[0] ?></p>
                            </div>
								
						</div>
					</div>
			<?php }  /* End while */ ?>
			</div> <!-- end div slide --> <?php } 
            
            // Loop de post filtrado por taxonomias
        
            foreach ($taxs as $key => $tax) { 
                $args = array(
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'deportes',
                            'terms'    => $tax->slug,
                        ),
                    ),
                ); ?>
                <section class="container_tarjetitas" >
                    <h2 class="sub_title" ><?php echo $tax->slug; ?></h2>
                    <?php 
                        $query = new WP_Query( $args );
    
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

                            $post_tax = wp_get_post_terms( get_the_ID(), 'deportes', array( 'fields' => 'slugs' ) );
                            if($post_tax[0] == $tax->slug) : ?>
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
                </section>
            <?php }
        ?>
	</article>

    <?php get_sidebar() ?>
</main>
<?php get_footer(); apply_filters ( 'taxonomy-images-queried-term-image ', '');