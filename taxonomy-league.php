<?php
get_header();

$term = get_term_by('name',$term,'league' );

wp_enqueue_style( 's-forecasts-css', get_template_directory_uri( ) .'/assets/css/forecasts-styles.css', null, false, 'all' );

 ?>
	<main>
    
            <div class="event_area pb_90">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 mt_25">
                        
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

