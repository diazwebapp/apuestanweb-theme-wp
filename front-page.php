<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header(); 


$terms = get_terms('deporte',array('hide_empty' => true));
$current_user = wp_get_current_user();
    wp_register_script('js-tarjetitas', get_template_directory_uri(). '/assets/js/js-tarjetitas.js', '1', true );
    wp_enqueue_script('js-tarjetitas');
    wp_localize_script( 'js-tarjetitas', 'taxonomy_data', array(
        'terms' => $terms,
        'post_rest_slug' => 'pronosticos',
        'class_container_tarjetitas' => 'container_tarjetitas',
        'class_delimiter' => 'container_pagination',
        'init' => 1,
        'current_user' => $current_user,
       ) );
?>

<main>
	<section>
       
            <?php if(have_posts()){
                get_template_part('template-parts/content-slide');
            } 
                if( $terms && !is_wp_error( $terms)):
                    // get taxonomies by post type, and print loop content filtred by term taxonomi
                    foreach (get_terms(array('taxonomy'=>'deporte','hide_empty'=>true)) as $term) : 
                        ?>
                         <article termid="<?php echo $term->term_id; ?>" class="container_tarjetitas" >
                            <h2 class="sub_title" ><?php echo __("Pronósticos: ".strtoupper($term->name)."", 'apuestanweb-lang'); ?></h2>
                            
                        </article>
                        <div class="container_pagination" >
                            
                        </div>
                    <?php endforeach; 
                else:  ?>
                    <article class="container_tarjetitas" >
                    <?php while(have_posts()): the_post();
                   get_template_part('template-parts/tarjetita_post');
                endwhile; ?> 
                    </article>  
                        <div class="container_pagination" >
                                
                        </div>
                <?php endif; ?>
             
	</section>
	<?php get_sidebar() ?>
</main>

<?php get_template_part('components/banner_footer') ?>

<?php get_footer();