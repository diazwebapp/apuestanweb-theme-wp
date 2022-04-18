<?php

class top_authors extends WP_Widget {

	function __construct() {
		parent::__construct(
			'top_authors',
			__( 'Top Pronosticadores', 'jbetting' )
		);
	}

	private $widget_fields = array();

	public function widget( $args, $instance ) {
		$title = isset($instance['title']) ? $instance['title'] : __( 'Top Pronosticadores', 'jbetting' );

        $args['meta_key']  = 'rank';
        $args['orderby']   = 'meta_value_num';
        $args['order']     = 'DESC';
        $users = new WP_User_Query($args);
        
		if ($users) {
			echo '<div class="col-lg-12 col-md-6">
                    <div class="side_box mt_30">
                        <div class="box_header">' . $title . '</div>
                        <div class="box_body">
                        ';
			foreach ($users->get_results() as $key => $user) {
                $acerted = get_the_author_meta("forecast_acerted", $user->ID );
                $failed = get_the_author_meta("forecast_failed", $user->ID );
                $nulled = get_the_author_meta("forecast_nulled", $user->ID );
                $rank = get_the_author_meta("rank", $user->ID );
                $latest = floatval($acerted) + floatval($failed) + floatval($nulled);
                $display_name = get_the_author_meta("display_name", $user->ID );
                $avatar= get_avatar_url($user->ID);
                $key++;
                $link = PERMALINK_PROFILE.'?profile='.$user->ID;
                $flechita_indicadora = "";
                $flechita_up = get_template_directory_uri(  ) . '/assets/img/love2.png';
                $flechita_down = get_template_directory_uri(  ) . '/assets/img/love1.png';
                if(floatval($acerted) > floatval($failed)):
                    $flechita_indicadora = $flechita_up;
                endif;
                if(floatval($acerted) > floatval($failed)):
                    $flechita_indicadora = $flechita_up;
                endif;
                if(floatval($acerted) < floatval($failed)):
                    $flechita_indicadora = $flechita_down;
                endif;
                echo "<div class='top_box v2'>
                        <a href='$link' class='d-flex align-items-center justify-content-between'>
                            <div class='top_serial'>
                                <span class='serial'>{$key}</span>
                                <img src='$avatar' class='img-fluid'>
                            </div>
                            <div class='text_box'>
                                <h4>$display_name</h4>
                                <p class='green'>
                                    <img src=' $flechita_indicadora' alt=''>
                                    $acerted - $failed, $rank Ult 10 picks
                                </p>
                            </div>
                        </a>
                    </div>";
            }
			echo '</div> </div> </div>';
		} else {
			echo 'Nothing found!';
		}


	}

}

function register_new_widget_authors() {
	register_widget( 'top_authors' );
}

add_action( 'widgets_init', 'register_new_widget_authors' );
wp_reset_query();