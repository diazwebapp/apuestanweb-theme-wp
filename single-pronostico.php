<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header();

$current_user = wp_get_current_user();

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
                echo do_shortcode('[pronostico paginate="'.false.'" id="'.$post->ID.'" ]'); ?>

                <article>
                    <?php 
                        if($current_user->ID != 0 ):
                            if($current_user->roles[0] == 'vip' || $current_user->roles[0] == 'administrator' || $current_user->roles[0] == 'editor' || $current_user->roles[0] == 'author'):
                                __(the_content(),'apuestanweb-lang');
                                echo do_shortcode('[eleccion]'); 
                            else:
                                    echo 'contenido bloqueado';
                            endif;
                        endif;

                        if($current_user->ID == 0 ):
                            echo 'contenido bloqueado';
                        endif;
                    ?>
                </article>
                                  
            <?php 
        
            set_query_var('data_card_author',array('post'=>$post,'pronosticos'=>$author_posts));
            get_template_part('components/card_author');
        endif; ?>
    </section>


    <?php get_sidebar() ?>
</main>

<?php get_footer();
