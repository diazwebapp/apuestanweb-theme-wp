<?php $args = get_query_var('data_card_author');

?>
<div class="card_author <?php if($args['post']->post_type == 'pronosticos'): echo 'card_author_pronostico'; else: echo 'card_author_post'; endif; ?>">
                <?php 
                    $posts = $args['pronosticos']->get_posts();
                    $total_p = $args['pronosticos']->post_count; 
                    $total_s=0; 
                    $total_f=0;
                        foreach ($posts as $key => $data) {
                            $state = get_post_meta($data->ID,'estado_pronostico');
                           if($state[0] == 'acertado'){
                               $total_s++;
                           }
                            if($state[0] == 'no_acertado'){
                                $total_f++;
                            }
                        }
                ?>
                <div>
                    <?php echo get_avatar( get_the_author_meta('email'), '80' ); ?>
                    <!-- <img src="<?php //echo get_template_directory_uri(). '/assets/images/icon.png' ?>" alt="Erick"> -->
                </div>
                <div >
                    <b><?php echo the_author_meta('nickname') ?></b>
                    <p><?php echo $total_s .'-'.$total_f ?></p>
                </div>
                <!-- Solo en pronosticos-->
                <?php if($args['post']->post_type == 'pronosticos'): ?>
                <div>
                    <b><?php echo $args['post']->post_type ?></b>
                    <p><?php echo $total_p ?></p>
                </div>

                <div class="barra-grafica">
                    <canvas data_total="<?php echo $total_p ?>" data_success="<?php echo $total_s ?>" data_failed="<?php echo $total_f ?>" id="grafics" style="width:100%;height:100%;" >
                    </canvas>
                </div>
                <?php endif; ?>
            </div>