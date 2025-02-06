<?php
get_header();
$term = get_term_by('name',$term,'league' );
var_dump($term);
$migas_de_pan_html = '<li><a href="'.get_home_url().'">Inicio</a></li>';
$taxonomy_page = !empty($term) ? carbon_get_term_meta($term->term_id,'taxonomy_page') : null ;

if(isset($taxonomy_page[0])){
    $perma = get_permalink($taxonomy_page[0]["id"]);
    var_dump($perma . "  perma 1");
}else{
    $perma = get_term_link($term->term_id, 'league');
    var_dump($perma . "  perma 2");
}
die();
$term->permalink = !empty($taxonomy_page[0]) ? get_permalink($taxonomy_page[0]["id"]) : get_term_link($term, 'league');
$migas_de_pan_html .= '<li><a href="'.$term->permalink.'" >'.$term->name.'</a></li>' ;
wp_enqueue_style( 's-forecasts-css', get_template_directory_uri( ) .'/assets/css/forecasts-styles.css', null, false, 'all' );

 ?>
	<main>
    
            <div class="event_area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 mt-3">
                        <?php echo $migas_de_pan_html ?>
                        
                        <?php echo do_shortcode("[forecasts model='2' num='6' filter='yes' league='$term->slug']") ?>

                        </div>
                        <div class="col-lg-3">
                            <div class="row">
                                <?php dynamic_sidebar( 'forecast-right' ); ?>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
    </main>
	
    <?php get_footer(); ?>

