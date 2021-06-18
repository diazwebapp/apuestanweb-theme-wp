<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header();

$current_user = wp_get_current_user();

$author_posts = new wp_Query(array(
    'post_type' => $post->post_type,
    'author' => $post->post_author,
    'post_not_in' => array( $post->ID )
));

function content_action($content){
    $content .= "[eleccion]";
    return $content;
}
add_action('the_content','content_action');
?>

<main>
    <section>
        <?php if(have_posts()):
                echo do_shortcode('[pronostico paginate="'.false.'" id="'.$post->ID.'" ]'); ?>
                <article>
                    <?php 
                        __(the_content(),'apuestanweb-lang');
                    ?>
                </article>
                <div class="card_author <?php if($post->post_type == 'pronosticos'): echo 'card_author_pronostico'; else: echo 'card_author_post'; endif; ?>">
               
                    <div>
                        <?php echo get_avatar($post->post_author, '80' ); ?>
                    </div>
                    <div >
                        <b><?php echo get_the_author_meta( 'display_name',$post->post_author) ?></b>
                        <p><?php echo get_the_author_meta('pronosticos_acertados',$post->post_author) .'-'.get_the_author_meta('pronosticos_no_acertados',$post->post_author).' ('.get_the_author_meta('average_aciertos',$post->post_author).'%) '.'T'. get_the_author_meta('pronosticos_completados',$post->post_author)?></p>
                    </div>
                    <!-- Solo en pronosticos-->
                    <?php if($post->post_type == 'pronostico'): ?>
                    <div>
                        <b><?php echo $post->post_type.'s' ?></b>
                        <p><?php echo get_the_author_meta('pronosticos_completados',$post->post_author)?></p>
                    </div>

                    <div class="barra-grafica">
                        <canvas data_total="<?php echo get_the_author_meta('pronosticos_completados',$post->post_author) ?>" data_success="<?php echo get_the_author_meta('pronosticos_acertados',$post->post_author) ?>" data_failed="<?php echo get_the_author_meta('pronosticos_no_acertados',$post->post_author) ?>" id="grafics" >
                        </canvas>
                    </div>
                    <?php endif; ?>
                </div>
        <?php  
        
            /* set_query_var('data_card_author',array('post'=>$post,'pronosticos'=>$author_posts));
            get_template_part('components/card_author'); */
        endif; ?>
    </section>


    <?php get_sidebar() ?>
</main>

<?php get_footer();
