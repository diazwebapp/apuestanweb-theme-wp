<?php
    $term= get_term_by( 'slug', get_query_var( 'term'), get_query_var( 'taxonomy') );
    $pronosticos = new WP_Query(array(
        'post_type'=>'pronosticos',
        'posts_per_page' => 4
    ));
   
    $posts = new WP_Query(array('post_type'=>'post','posts_per_page' => 4));
    $current_user = wp_get_current_user();

    $usuarios = get_users();

    function statics_user($post_author){
        
        $author_posts = new wp_Query(array(
            'author' => $post_author,
            'tax_query'=>array(
                array(
                    'taxonomy' => 'deporte',
                    'terms' => 'all'
                )
            )
        ));

        $total_p = $author_posts->post_count; 
        $total_s=0; 
        $total_f=0;
            foreach ($author_posts->get_posts() as $key => $data) {
                $state = get_post_meta($data->ID,'estado_pronostico');
                if($state[0] == 'acertado'){
                    $total_s++;
                }
                if($state[0] == 'no_acertado'){
                    $total_f++;
                }
            }
        return array(
            'total_p' => $total_p,
            'total_c' => $total_s+$total_f,
            'total_s' => $total_s,
            'total_f' => $total_f,
            'average' => ceil($total_s / ($total_s+$total_f) * 100).'%',
        );
    }
?>
<aside>
<?php if($pronosticos->have_posts()): ?>
<div class="aside_widgets">
    <h2 class="sub_title" ><?php echo __('Ultimos pronosticos','apuestanweb-lang') ?></h2>
    <ul>
        <?php while($pronosticos->have_posts()): $pronosticos->the_post();
                
                $nombre_equipo_1 = get_post_meta(get_the_ID(),"nombre_equipo_1")[0];
                $img_equipo_1 = get_post_meta(get_the_ID(),"img_equipo_1")[0];
                $resena_equipo_1 = get_post_meta(get_the_ID(),"resena_equipo_1")[0];
                $average_equipo_1 = ceil(1 / get_post_meta(get_the_ID(),"average_equipo_1")[0] * 100);

                $nombre_equipo_2 = get_post_meta(get_the_ID(),"nombre_equipo_2")[0];
                $img_equipo_2 = get_post_meta(get_the_ID(),"img_equipo_2")[0];
                $resena_equipo_2 = get_post_meta(get_the_ID(),"resena_equipo_2")[0];
                $average_equipo_2 = ceil(1 / get_post_meta(get_the_ID(),"average_equipo_2")[0] * 100);

                $acceso_pronostico = get_post_meta(get_the_ID(),"acceso_pronostico")[0];
                $fecha_partido = get_post_meta(get_the_ID(),"fecha_partido")[0];
                if($post->post_type=='pronosticos'): ?>

                        <a href="<?php the_permalink() ?>" class="item_w_pronostico" >
                            <div class="item_w_img" >
                                <img src="<?php if($img_equipo_1){ echo $img_equipo_1;}else{ echo get_template_directory_uri(). '/assets/images/icon.png'; } ?> " />
                                <img src="<?php if($img_equipo_2){ echo $img_equipo_2;}else{ echo get_template_directory_uri(). '/assets/images/icon.png'; } ?> " />
                            </div>

                            <div class="item_w_eq">
                            <?php  //verificando si no es free y tienen rl rango necesario
                            
                                        if($acceso_pronostico !== 'free'):
                                            
                                            if($acceso_pronostico == $current_user->roles[0] || $current_user->roles[0] == 'administrator' || $current_user->roles[0] == 'author' || $current_user->roles[0] == 'editor'){ ?>
                                                    <p class="<?php if($average_equipo_2 < $average_equipo_1){echo "bolder flechita" ;} ?>"><?php echo $nombre_equipo_1 ?></p>                                    
                                                    <p class="<?php if($average_equipo_2 > $average_equipo_1){echo "bolder flechita" ;} ?>" ><?php echo $nombre_equipo_2 ?></p> 
                                            <?php }else{ ?>
                                                <p ><?php echo $nombre_equipo_1 ?></p>                                    
                                                <p ><?php echo $nombre_equipo_2 ?></p>
                                            <?php }
                                        else: ?>
                                            <p ><?php echo $nombre_equipo_1 ?></p>                                    
                                            <p ><?php echo $nombre_equipo_2 ?></p> 
                                    <?php endif; ?>                  
                            </div>

                            <div class="item_w_av <?php
                                        if($acceso_pronostico !== 'free'):
                                            if($current_user->roles[0] != 'administrator' && $current_user->roles[0] != 'author' && $current_user->roles[0] != 'editor'){
                                                if($acceso_pronostico != $current_user->roles[0]):
                                                    echo 'block_content';
                                                endif;
                                            }
                                        endif;
                                    ?>">
                                    
                                    <?php  
                                        if($acceso_pronostico !== 'free' || $acceso_pronostico == null):
                                            if($acceso_pronostico == $current_user->roles[0] || $current_user->roles[0] == 'administrator' || $current_user->roles[0] == 'author' || $current_user->roles[0] == 'editor'): ?>
                                                <p class=" <?php if($average_equipo_2 < $average_equipo_1){echo "bolder flechita" ;} ?> ">
                                                    <?php echo $average_equipo_1 ?>
                                                </p>
                                                <p class=" <?php if($average_equipo_2 > $average_equipo_1){echo "bolder flechita" ;} ?> ">
                                                    <?php echo $average_equipo_2 ?>
                                                </p>     
                                        <?php endif;
                                           
                                        else: ?>
                                            <p>
                                                <?php echo $average_equipo_1 ?>
                                            </p>
                                            <p>
                                                <?php echo $average_equipo_2 ?>
                                            </p>
                                <?php endif; ?>
                            </div>

                            <div>
                                <b><?php echo $acceso_pronostico; ?></b>
                                <p>25-11-2021</p>
                            </div>
                        </a>
                    <?php endif; endwhile; ?>
    </ul>
</div>
<?php endif; ?>

<div class="aside_widgets">
    <h2 class="sub_title" ><?php echo _e('Los mejores autores','apuestanweb-lang');  ?></h2>
    <ul>
        <?php 
            if($usuarios != false):
                    $cont = 0;
                foreach ($usuarios as $user ) :
                    
                    //$post_tax = wp_get_post_terms( get_the_ID(), get_query_var('taxonomy'), array( 'fields' => 'slugs' ) );
                    
                    $static = statics_user($user->ID);
                    if($user->roles[0] == 'administrator' || $user->roles[0] == 'author' || $user->roles[0] == 'editor' ):
                        $cont++; ?>
                        
                        <a href="<?php the_permalink() ?>" class="aside_item_usuarios">
                            <div>
                                <?php echo $cont; ?>
                            </div>
                            <div>
                                <?php echo get_avatar( get_the_author_meta('email'), '80' ); ?>
                            </div>
                            <div>
                                <h4><?php echo $user->display_name ; ?></h4>
                                <p><?php echo $static['total_s'] .'-'. $static['total_f'] . '('.$static['average'].') T'.$static['total_c']?></p>
                                <b>+100</b>
                            </div>
                        </a>
                <?php endif; endforeach; 
        endif; ?>
    </ul>
</div>

<div class="aside_widgets">
    <h2 class="sub_title" ><?php echo __('ultimos posts','apuestanweb-lang') ?></h2>
    <ul>
        <?php 
            while($posts->have_posts()):
                $posts->the_post(); 
                $post_type = get_post_type(get_the_ID());
                if($post_type== "post"): ?>
                <a href="<?php the_permalink() ?>" class="aside_item_post">
                    <div>
                        <?php if(has_post_thumbnail()) : 
                                the_post_thumbnail();
                            else : ?> 
                            <img src="<?php echo get_template_directory_uri(). '/assets/images/hh2.png'; ?>" alt="">
                        <?php endif; ?>
                    </div>
                    <div>
                        <h4><?php echo __(the_title(),'apuestanweb-lang'); ?></h4>
                        <?php the_excerpt(); ?>
                    </div>
                </a>
                <?php endif; endwhile; ?>
    </ul>
</div>


<?php
    if(is_active_sidebar('primary_widget')) : ?>
        <?php dynamic_sidebar('primary_widget'); ?>
    <?php endif;
    ?>
</aside>