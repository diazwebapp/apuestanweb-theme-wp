<?php
get_header();

var_dump(single_term_title('',false ));
$term = get_term_by('name',$term,'league' );

 ?>
	<main>
    
            <div class="event_area pb_90">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 mt_25">
                        
                        <?php echo do_shortcode("[forecasts model='2' num='6' title='$term->name' filter='yes' paginate='yes' ]") ?>

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

