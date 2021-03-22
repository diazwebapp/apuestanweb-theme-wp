<?php
    $pronosticos = new WP_Query(array('post_type'=>'pronosticos'));
    $posts = new WP_Query(array('post_type'=>'post'));
    $current_user = wp_get_current_user();
?>
<aside>
<?php if($pronosticos->have_posts()): ?>
<div class="aside_widgets">
    <h2><?php echo __('Ultimos pronosticos','apuestanweb-lang') ?></h2>
    <ul>
        <?php while($pronosticos->have_posts()): $pronosticos->the_post();
                
                $nombre_equipo_1 = get_post_meta(get_the_ID(),"nombre_equipo_1");
                $img_equipo_1 = get_post_meta(get_the_ID(),"img_equipo_1");
                $resena_equipo_1 = get_post_meta(get_the_ID(),"resena_equipo_1");
                $average_equipo_1 = get_post_meta(get_the_ID(),"average_equipo_1");

                $nombre_equipo_2 = get_post_meta(get_the_ID(),"nombre_equipo_2");
                $img_equipo_2 = get_post_meta(get_the_ID(),"img_equipo_2");
                $resena_equipo_2 = get_post_meta(get_the_ID(),"resena_equipo_2");
                $average_equipo_2 = get_post_meta(get_the_ID(),"average_equipo_2");
                $tags = wp_get_post_tags(get_the_ID());
                $fecha_partido = get_post_meta(get_the_ID(),"fecha_partido"); ?>
                        <a href="<?php the_permalink() ?>" class="aside_item_pronostico <?php
                                        if(!current_user_can('administrator')){
                                            foreach($tags as $tag){
                                                if($tag->name !== $current_user->roles[0]){
                                                    echo 'block_content';
                                                }
                                            }
                                        }
                                    ?>" >
                            <div >
                                <img src="<?php if($img_equipo_1[0]){ echo $img_equipo_1[0];}else{ echo get_template_directory_uri(). '/assets/images/icon.png'; } ?> " />
                                <img src="<?php if($img_equipo_2[0]){ echo $img_equipo_2[0];}else{ echo get_template_directory_uri(). '/assets/images/icon.png'; } ?> " />
                            </div>
                            <div>
                                <span>
                                    <p class="<?php if(current_user_can('administrator') && $average_equipo_2[0] < $average_equipo_1[0]){echo "bolder" ;} ?>"><?php echo $nombre_equipo_1[0] ?></p>
                                    <small class="<?php if(current_user_can('administrator') && $average_equipo_2[0] < $average_equipo_1[0]){echo "bolder" ;} ?>">
                                        <?php if(current_user_can('administrator')){
                                            echo $average_equipo_1[0];
                                        }else{
                                            foreach($tags as $tag){
                                                if($tag->name == $current_user->roles[0]){
                                                    echo $average_equipo_1[0];
                                                }
                                            }
                                        }?>
                                    </small>
                                </span>
                                <span>
                                    <p class="<?php if(current_user_can('administrator') && $average_equipo_2[0] > $average_equipo_1[0]){echo "bolder" ;} ?>" ><?php echo $nombre_equipo_2[0] ?></p>
                                    <small class="<?php if(current_user_can('administrator') && $average_equipo_2[0] > $average_equipo_1[0]){echo "bolder" ;} ?>">
                                        <?php if(current_user_can('administrator')){
                                            echo $average_equipo_2[0];
                                        }else{
                                            foreach($tags as $tag){
                                                if($tag->name == $current_user->roles[0]){
                                                    echo $average_equipo_2[0];
                                                }
                                            }
                                        }?>
                                    </small>
                                </span>
                            </div>
                            <div>
                                <p>25-11-2021</p>
                            </div>
                        </a>
                    <?php  endwhile; ?>
    </ul>
</div>
<?php endif; ?>
<div class="aside_widgets">
    <h2><?php echo __('ultimos posts','apuestanweb-lang') ?></h2>
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