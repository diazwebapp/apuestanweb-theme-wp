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
                echo do_shortcode('[pronostico paginate="'.false.'" limit="1" id="'.$post->ID.'" ]'); ?>

                <article>
                    <?php __(the_content(),'apuestanweb-lang') ?>
                </article>
                                  
            <?php echo do_shortcode('[eleccion]'); 
        
            set_query_var('data_card_author',array('post'=>$post,'pronosticos'=>$author_posts));
            get_template_part('components/card_author');
        endif; ?>
    </section>


    <?php get_sidebar() ?>
</main>

<?php get_footer();
