<?php get_header(); 

$terms = get_terms('deporte',array('hide_empty' => true));
$current_user = get_current_user();
    wp_register_script('js-tarjetitas', get_template_directory_uri(). '/assets/js/js-tarjetitas.js', '1', true );
    wp_enqueue_script('js-tarjetitas');
    wp_localize_script( 'js-tarjetitas', 'taxonomy_data', array(
        'terms' => $terms,
        'post_rest_slug' => 'pronosticos',
        'class_container_tarjetitas' => 'container_tarjetitas',
        'class_delimiter' => 'container_pagination',
        'limit' => array(),
        'current_user' => $current_user,
       ) );
       
?>

<main>
	<section>
    <?php 
        if(have_posts()): get_template_part('template-parts/content-slide'); endif;?>
        <div class="terms_nav">
            <?php 
                foreach (get_terms(array('taxonomy'=>'deporte','hide_empty' => false)) as $term_item): if($term_item->parent == 0): ?>
                    <a class="<?php if($term === $term_item->slug):echo 'current'; endif; ?>" href="<?php echo site_url().'/deporte\/'.$term_item->slug ;?>">
                        <?php echo $term_item->name; ?>
                    </a>
            <?php endif; endforeach; ?>
        </div>

        <?php 
            foreach (get_terms(array('taxonomy'=>'deporte')) as $term_item): if($term_item->name == $term): ?>
                <article termid="<?php echo $term_item->term_id; ?>" class="container_tarjetitas" >
                    <h2 class="sub_title" ><?php echo __("Pronósticos: ".str_replace("-"," ",strtoupper($term))."",'apuestanweb-lang') ?></h2>
                    
                </article>
        <?php endif; endforeach; ?>
            <div class="container_pagination" >
                
            </div>
	</section>

    <?php get_sidebar() ?>
</main>
<?php get_footer();