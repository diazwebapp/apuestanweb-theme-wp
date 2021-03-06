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
                the_post(); 
                ?>
                <div class="imagen_destacada_container">
                    <?php the_post_thumbnail() ?>
                </div>
                <h1><?php the_title() ?></h1>
            <?php }
    } ?>

    <?php if(is_front_page() && !$pagename){
       $depo = $wpdb->get_results( 
        $wpdb->prepare("SELECT * FROM {$wpdb->prefix}posts where post_status='publish' and post_type='deporte' ")
        ); 
        foreach($depo as $deporte){
            ?>
                <section class="container_tarjetitas">
                    <h2 class="sub_title" ><?php echo $deporte->post_title; ?></h2>
                    <?php require_once 'components/tarjetita_pronostico.php';
                        fill_post($deporte->post_name,'pronosticos');
                    ?>
                </section>
        <?php }
                
    } ?>

    <?php if(!is_front_page() && $pagename){ 
        if(have_posts()){
            if($pagename == 'blog'){ ?>
                <section class="container_tarjetitas">
                    <h2 class="sub_title" >Ultimas entradas</h2>
                    <?php include 'components/tarjetita_post.php'; ?>
                </section>
            <?php }else{ ?>
                <section >
                    <?php the_content() ?>
                </section>
            <?php }
            
    } ?>    
   <?php } ?>
    </article>


<?php include 'aside.php'; ?>

	
<?php get_footer();