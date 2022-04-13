<?php

class top_bonuses extends WP_Widget {

	function __construct() {
		parent::__construct(
			'top_bonuses',
			__( 'BONUSES', 'jbetting' )
		);
	}

	private $widget_fields = array();

	public function widget( $args, $instance ) {
		$num   = isset($instance['count']) ? $instance['count'] : 4;
		$list  = isset($instance['list']) ? $instance['list'] : 4;
		$title = isset($instance['title']) ? $instance['title'] : __( 'Bonuses', 'jbetting' );

		
		wp_reset_query();
		$args = array(
			'post_type'      => 'bonus',
			'posts_per_page' => $num,
		);
		
		$query_bonus = new WP_Query( $args );
		if ( $query_bonus->have_posts() ) {
			echo '<div class="col-lg-12 col-md-6">
                    <div class="side_box mt_30">
                        <div class="box_header">' . $title . '</div>
                        <div class="box_body">
                        ';
			while ( $query_bonus->have_posts() ):
				$query_bonus->the_post();
				$id = get_the_ID();
				$bk        = get_bookmaker_by_post( $id, ["w"=>69,"h"=>28], ["w"=>100,"h"=>50] );
				
				$link      = carbon_get_post_meta( get_the_ID(), 'link' );
				$short     = carbon_get_post_meta( get_the_ID(), 'short' );
				$summa     = carbon_get_post_meta( get_the_ID(), 'summa' );
				echo '<div class="top_box top_box2">
							<div class="d-flex align-items-center justify-content-between">
								<div class="top_serial">
									<img src="'.$bk['logo'].'" class="img-fluid" alt="'.$bk['name'].'" title="'.$bk['name'].'">
								</div>
								<div class="top_box_content">
									<p>'.$short.'</p>
									<a href="'.$link .'" class="button">'.$summa.'</a>
								</div>
							</div>
						</div>';
			endwhile;
			echo '</div> </div> </div>';
		} else {
			echo 'Nothing found!';
		}


	}

}

function register_new_widget2() {
	register_widget( 'top_bonuses' );
}

add_action( 'widgets_init', 'register_new_widget2' );
wp_reset_query();