<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); 
$casas_apuestas = new wp_query(array(
    "post_type"=>"casaapuesta"
));
?>
<main>
    <section>
        <?php if(have_posts()):
                while(have_posts()):
                    the_post() ;
                    $slogan = get_post_meta(get_the_ID(),'slogan_casa_apuesta')[0];
                    $url_logo = get_post_meta(get_the_ID(),'url_logo_casa_apuesta')[0];
                    $puntuacion = get_post_meta(get_the_ID(),'puntuacion_casa_apuesta')[0];
                    $tiempo_pago = get_post_meta(get_the_ID(),'tiempo_pago_casa_apuesta')[0];
                    ?>
                    
                    <article>
                        <div class="casa_apuesta_prew " >
                            <?php 
                                echo do_shortcode('[t_casa_apuesta]');
                                get_template_part('template-parts/tarjeta_casa_apuesta_h');
                            ?>
                        </div>
                        <?php __(the_content(),'apuestanweb-lang') ?>
                    </article>
        <?php endwhile; endif;?>
        <hr></hr>
            <article>
            <h2 class="sub_title" >Otras Casas de apuestas</h2>
            <?php if($casas_apuestas->have_posts()):
                    while($casas_apuestas->have_posts()):
                        $casas_apuestas->the_post() ;
                        
                        get_template_part('template-parts/tarjeta_casa_apuesta_h');
                       
             endwhile; endif;?>
            </article>
    </section>


    <?php get_sidebar() ?>
</main>

<?php get_footer();