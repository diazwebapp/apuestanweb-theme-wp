<?php
function load_posts() {

	$args                = unserialize( stripslashes( $_POST['query'] ) );
	$args['paged']       = $_POST['page'] + 1;
	$args['post_status'] = 'publish';
	$args['post_type']   = 'post';

	$query = new WP_Query( $args );
	// print_r($query);
	if ( $query->have_posts() ) :
		if($_POST['model'] == 1 || $_POST['model'] == ''):
			while ( $query->have_posts() ): $query->the_post();
				load_template_part( "loop/posts-grid" );
			endwhile;
		endif;
		if($_POST['model'] == 2):
			while ( $query->have_posts() ): $query->the_post();
				load_template_part( "loop/posts-grid_2" );
			endwhile;
		endif;
        if($_POST['model'] == 3):
			while ( $query->have_posts() ): $query->the_post();
				load_template_part( "loop/posts-grid_3" );
			endwhile;
		endif;
        if($_POST['model'] == 4):
			while ( $query->have_posts() ): $query->the_post();
				load_template_part( "loop/posts-grid_4" );
			endwhile;
		endif;
	endif;
	die();
}

add_action( 'wp_ajax_loadmore_posts', 'load_posts' );
add_action( 'wp_ajax_nopriv_loadmore_posts', 'load_posts' );
