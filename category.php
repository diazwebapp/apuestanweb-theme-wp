<?php
$term    = get_queried_object();
$term_id = $term->term_id;
if ( carbon_get_term_meta( $term_id, 'h1' ) ) {
	$h1 = carbon_get_term_meta( $term_id, 'h1' );
} else {
	$h1 = single_term_title( '', false );
}
$textbefore = carbon_get_term_meta( $term_id, 'before_list' );
$textafter = carbon_get_term_meta( $term_id, 'after_list' );


 get_header(); ?>
	<main>
        <?php if ( $textbefore ): echo $textbefore ; endif; ?>
        <?php echo do_shortcode('[banner]') ?>

            <div class="event_area pb_90">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 mt_25">
                        <div class="title_wrap flex-nowrap">
                            <h3 class="title mt_30 w-100"><?php echo $h1 ?></h3>
                            <a href="#" class="mt_30 dropd">Hoy <i class="fal fa-angle-down"></i></a>
                        </div>
                        
                        <?php echo do_shortcode("[related_posts model='4' cat='$term->slug 'paginate='yes']") ?>
                       
                        <?php if ( $textafter ): echo $textafter ; endif; ?>
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

