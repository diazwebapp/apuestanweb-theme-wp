<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); 
$casas_apuestas = new wp_query(array(
    "post_type"=>"casaapuesta"
));
?>
<main>
    <article>
        <?php if(have_posts()):
                    while(have_posts()):
                        the_post() ;
                        $slogan = get_post_meta(get_the_ID(),'slogan_casa_apuesta')[0];
                        $url_logo = get_post_meta(get_the_ID(),'url_logo_casa_apuesta')[0];
                        $puntuacion = get_post_meta(get_the_ID(),'puntuacion_casa_apuesta')[0];
                        $tiempo_pago = get_post_meta(get_the_ID(),'tiempo_pago_casa_apuesta')[0];
                        ?>

                        <div class="tarjetita_casa_apuesta_single imagen_destacada_container" >
                            <?php the_post_thumbnail() ?>
                        </div>
                        <?php __(the_content(),'apuestanweb-lang') ?>
            <?php endwhile; endif;?>
            <section>
            <?php if($casas_apuestas->have_posts()):
                    while($casas_apuestas->have_posts()):
                        $casas_apuestas->the_post() ;
                        
                        get_template_part('template-parts/tarjeta_casa_apuesta_h');
                        echo __(the_content(),'apuestanweb-lang');
             endwhile; endif;?>
            </section>
    </article>


    <?php get_sidebar() ?>
</main>

<?php get_footer();