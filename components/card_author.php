<?php $args = get_query_var('data_card_author');

?>
<div class="card_author <?php if($args['post']->post_type == 'pronosticos'): echo 'card_author_pronostico'; else: echo 'card_author_post'; endif; ?>">
               
    <div>
        <?php echo get_avatar( get_the_author_meta('email'), '80' ); ?>
        <!-- <img src="<?php //echo get_template_directory_uri(). '/assets/images/icon.png' ?>" alt="Erick"> -->
    </div>
    <div >
        <b><?php echo get_the_author_meta( 'display_name',$post->post_author) ?></b>
        <p><?php echo get_the_author_meta('pronosticos_acertados',$post->post_author) .'-'. get_the_author_meta('pronosticos_no_acertados',$post->post_author)?></p>
    </div>
    <!-- Solo en pronosticos-->
    <?php if($args['post']->post_type == 'pronostico'): ?>
    <div>
        <b><?php echo $args['post']->post_type.'s' ?></b>
        <p><?php echo get_the_author_meta('pronosticos_completados',$post->post_author)?></p>
    </div>

    <div class="barra-grafica">
        <canvas data_total="<?php echo get_the_author_meta('pronosticos_completados',$post->post_author) ?>" data_success="<?php echo get_the_author_meta('pronosticos_acertados',$post->post_author) ?>" data_failed="<?php echo get_the_author_meta('pronosticos_no_acertados',$post->post_author) ?>" id="grafics" >
        </canvas>
    </div>
    <?php endif; ?>
</div>