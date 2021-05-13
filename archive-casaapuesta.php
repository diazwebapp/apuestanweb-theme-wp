<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); 
$casas_apuestas = new wp_query(array(
    "post_type"=>"casaapuesta"
));
?>
<main>
    <section>
            <article>
            <?php if($casas_apuestas->have_posts()):
                    while($casas_apuestas->have_posts()):
                        $casas_apuestas->the_post() ;

                        get_template_part('template-parts/tarjeta_casa_apuesta_h');
             endwhile; endif;?>

            <div class="container_pagination" >
                <?php echo paginate_links(array(
                        'base' => str_replace( '9999999999', '%#%', esc_url( get_pagenum_link( '9999999999') ) ),
                        'format' => '?paged=%#%',
                        'current' => max( 1, get_query_var('paged') ),
                        'total' => $casas_apuestas->max_num_pages
                    ) ) ?>
            </div>
            </article>
    </section>


    <?php get_sidebar() ?>
</main>

<?php get_footer();