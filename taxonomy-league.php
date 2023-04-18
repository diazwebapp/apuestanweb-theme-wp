<?php
get_header();
$term = get_term_by('name',$term,'league' );
$migas_de_pan_html = '<li><a href="'.get_home_url().'">Inicio</a></li>';
$taxonomy_page = carbon_get_term_meta($term->term_id,'taxonomy_page');
$term->redirect = isset($taxonomy_page[0]) ? $taxonomy_page[0] : null;

if(isset($term->redirect)):
    $permalink = get_permalink($term->redirect["id"]);
    wp_redirect( $permalink, 301 );
endif;

$term->permalink = isset($term->redirect) ? get_permalink($term->redirect["id"]) : get_term_link($term, 'league');
$migas_de_pan_html .= '<li><a href="'.$term->permalink.'" >'.$term->name.'</a></li>' ;
wp_enqueue_style( 's-forecasts-css', get_template_directory_uri( ) .'/assets/css/forecasts-styles.css', null, false, 'all' );

 ?>
	<main>
    
            <div class="event_area pb_90">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 mt_25">
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

