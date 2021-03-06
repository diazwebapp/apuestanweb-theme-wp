<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Apuestan_web
 * @since Apuestan web 1.0
 */

get_header();


?>

    <article>
        <?php if(have_posts()){
                    while(have_posts()){
                        the_post() ;
                        $post_type = get_post_type(get_the_ID());
                        $categorias = get_the_category(get_the_ID());
                        $nombre_equipo_1 = get_post_meta(get_the_ID(),"nombre_equipo_1");
                        $img_equipo_1 = get_post_meta(get_the_ID(),"img_equipo_1");
                        $resena_equipo_1 = get_post_meta(get_the_ID(),"resena_equipo_1");
                        $average_equipo_1 = get_post_meta(get_the_ID(),"average_equipo_1");
                    
                        $nombre_equipo_2 = get_post_meta(get_the_ID(),"nombre_equipo_2");
                        $img_equipo_2 = get_post_meta(get_the_ID(),"img_equipo_2");
                        $resena_equipo_2 = get_post_meta(get_the_ID(),"resena_equipo_2");
                        $average_equipo_2 = get_post_meta(get_the_ID(),"average_equipo_2");
                    
                        $fecha_partido = get_post_meta(get_the_ID(),"fecha_partido");
                        ?>
                        <div class="imagen_destacada_container" ><?php the_post_thumbnail() ?></div>
                        
                    <?php if($post_type === 'pronosticos'){ ?>
                        <div style="width:100%;max-width:none;background:white;height:250px;" href="<?php the_permalink() ?>" class="tarjetita_pronostico" >
                                <h3 class="title_pronostico" ><?php the_title() ?></h3>
                                <div style="height:180px;" class="equipos_pronostico" >
                                    <div style="height:150px;">
                                        <img style="width:110px;height:110px;" src="<?php echo $img_equipo_1[0] ?>" />
                                        <p><?php echo $nombre_equipo_1[0] ?></p>
                                    </div>
                                    <div style="height:150px;">
                                        <p><?php echo $fecha_partido[0] ?></p>
                                    </div>
                                    <div style="height:150px;">
                                        <img style="width:110px;height:110px;" src="<?php echo $img_equipo_2[0] ?>" />
                                        <p><?php echo $nombre_equipo_2[0] ?></p>
                                    </div>
                                </div>
                                <div style="padding-bottom:30px;" class="average_pronostico" >
                                    <p><?php echo $average_equipo_1[0] ?></p>
                                    <p>%</p>
                                    <p><?php echo $average_equipo_2[0] ?></p>
                                </div>
                        </div>
                       <?php the_content() ?>
                    <?php }else{ ?>
                        <section >
                            <h2 class="sub_title" >entrada de blog</h2> 
                            <div>
                                <?php the_content() ?>
                            </div>
                        </section>
                    <?php } /**end if */
                 } /**End while */ 
        } ?>
    </article>


<?php include 'aside.php'; ?>

	
<?php get_footer();