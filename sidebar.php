<?php
    
    $pronosticos = new WP_Query(array(
        'post_type'=>'pronostico',
        'meta_key' => 'fecha_partido',
        'order_by' => 'meta_value',
        'order' => 'ASC',
        'posts_per_page' => 4
    ));
   
    $posts = new WP_Query(array(
        'post_type'=>'post',
        'posts_per_page' => 4
    ));
    $current_user = wp_get_current_user();    

    $usuarios = get_users("orderby=meta_value&meta_key=average_aciertos&order=DESC");
?>
<aside>
<?php if($pronosticos->have_posts() && count($pronosticos->posts) > 0): ?>
    <div class="aside_widgets">
        <p><?php echo __('Ultimos Pronosticos','apuestanweb-lang') ?></p>
        <ul>
            <?php while($pronosticos->have_posts()): $pronosticos->the_post();
                    
                    $nombre_equipo_1 = get_post_meta(get_the_ID(),"nombre_equipo_1")[0];
                    $img_equipo_1 = get_post_meta(get_the_ID(),"img_equipo_1")[0];
                    $average_equipo_1 = get_post_meta(get_the_ID(),"average_equipo_1")[0] ;

                    $nombre_equipo_2 = get_post_meta(get_the_ID(),"nombre_equipo_2")[0];
                    $img_equipo_2 = get_post_meta(get_the_ID(),"img_equipo_2")[0];
                    $average_equipo_2 = get_post_meta(get_the_ID(),"average_equipo_2")[0] ;

                    $acceso_pronostico = get_post_meta(get_the_ID(),"acceso_pronostico")[0];
                    $fecha_partido = get_post_meta(get_the_ID(),"fecha_partido")[0];
                ?>
                            <a href="<?php the_permalink() ?>" class="item_w_pronostico" >
                                <div class="item_w_img" >
                                    
                                    <div>
                                        <img loader="lazy" src="<?php if($img_equipo_1){ echo $img_equipo_1;}else{ echo get_template_directory_uri(). '/assets/images/icon.png'; } ?> " />
                                    </div>
                                    <div>
                                        <img loader="lazy" src="<?php if($img_equipo_2){ echo $img_equipo_2;}else{ echo get_template_directory_uri(). '/assets/images/icon.png'; } ?> " />
                                    </div>
                                    
                                </div>

                                <div class="item_w_eq">
                                <p class="<?php if($average_equipo_2 < $average_equipo_1){echo "bolder flechita" ;} ?>"><?php echo $nombre_equipo_1 ?></p>                                    
                                <p class="<?php if($average_equipo_2 > $average_equipo_1){echo "bolder flechita" ;} ?>" ><?php echo $nombre_equipo_2 ?></p> 
                                                            
                                </div>

                                <div class="item_w_av">
                                    <p class="<?php if($average_equipo_2 < $average_equipo_1){echo "bolder flechita" ;} ?> ">
                                                        <?php echo $average_equipo_1 ?>
                                    </p>
                                    <p class="<?php if($average_equipo_2 > $average_equipo_1){echo "bolder flechita" ;} ?> ">
                                                        <?php echo $average_equipo_2 ?>
                                    </p>     
                                            
                                </div>

                                <div>
                                    <b><?php echo $acceso_pronostico; ?></b>
                                    <p><?php echo $fecha_partido ?></p>
                                </div>
                            </a>
                        <?php endwhile; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if($usuarios != false): $cont = 0; ?>

    <div class="aside_widgets">
        <p ><?php echo _e('Best Authors','apuestanweb-lang');  ?></p>
        <ul>
             <?php  
                foreach ($usuarios as $user ) :
                    
                    
                    if($user->roles[0] == 'administrator' || $user->roles[0] == 'author' || $user->roles[0] == 'editor' ):
                        $cont++; ?>
                        
                        <a href="<?php echo home_url()."\user/".$user->user_login?>" class="aside_item_usuarios">
                            <div>
                                <?php echo $user->ID; ?>
                            </div>
                            <div>
                                <?php echo get_avatar( get_the_author_meta('email'), '80' ); ?>
                            </div>
                            <div>
                                <h4><?php echo $user->display_name ?></h4>
                                <p><?php echo get_the_author_meta('pronosticos_acertados',$user->ID) .'-'.get_the_author_meta('pronosticos_no_acertados',$user->ID).' ('.get_the_author_meta('average_aciertos',$user->ID).') '.'T'. get_the_author_meta('pronosticos_completados',$user->ID)?></p>
                               
                            </div>
                        </a>
                <?php endif; endforeach; ?>
    </ul>
</div>

<?php endif; ?>

<div class="aside_widgets">
    <p ><?php echo __('Posts Recientes','apuestanweb-lang') ?></p>
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
                            <img loader="lazy" src="<?php echo get_template_directory_uri(). '/assets/images/hp.png'; ?>" alt="">
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