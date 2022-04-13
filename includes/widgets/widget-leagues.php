<?php

class leaguesd extends WP_Widget {

	function __construct() {
		parent::__construct(
			'leagues',
			__( 'Legue', 'jbetting' )
		);
	}

	private $widget_fields = array();

	public function widget( $args, $instance ) {
		$list  = $instance['list'];
		$title = $instance['title'];
		if ( $title ) {
			echo '<div class="block-name">' . $title . '</div>';
		}
		if ( $list ):
			echo '<div class="leagues">';
			$list_ids = explode( ',', $list );
			foreach ( $list_ids as $term_id ) {

				$term = get_term( $term_id );
			    $bg = carbon_get_term_meta($term_id,'wbg');
			    $bg_src = wp_get_attachment_url($bg);

				$league_img_att = carbon_get_term_meta($term_id,'mini_img');
				$league_img_src = aq_resize(wp_get_attachment_url($league_img_att),52,49,true,true,true);
                $link = get_term_link($term->term_id,'league');
	                echo '<div class="item" style="background: url(' . $bg_src . ') center/cover;">
                                <a href="' . $link . '">
                                    <div class="logo">
                                        <img alt="league" src="'.$league_img_src.'">
                                    </div>
                                    <div class="name">' . $term->name . '</div>
                                </a>
                            </div>';
			}
			echo '</div>';
		else:
			echo 'Enter Ids';
		endif;


	}

	public
	function field_generator(
		$instance
	) {
		$output = '';
		foreach ( $this->widget_fields as $widget_field ) {
			$default = '';
			if ( isset( $widget_field['default'] ) ) {
				$default = $widget_field['default'];
			}
			$widget_value = ! empty( $instance[ $widget_field['id'] ] ) ? $instance[ $widget_field['id'] ] : esc_html__( $default, 'textdomain' );
			switch ( $widget_field['type'] ) {
				default:
					$output .= '<p>';
					$output .= '<label for="' . esc_attr( $this->get_field_id( $widget_field['id'] ) ) . '">' . esc_attr( $widget_field['label'], 'textdomain' ) . ':</label> ';
					$output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( $widget_field['id'] ) ) . '" name="' . esc_attr( $this->get_field_name( $widget_field['id'] ) ) . '" type="' . $widget_field['type'] . '" value="' . esc_attr( $widget_value ) . '">';
					$output .= '</p>';
			}
		}
		echo $output;
	}

	public
	function form(
		$instance
	) {
		$list  = ! empty( $instance['list'] ) ? $instance['list'] : '';
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo __( 'Widget title', 'jbetting' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'list' ) ); ?>"><?php echo __( 'League list (Ids list)', 'jbetting' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'list' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'list' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $list ); ?>">
        </p>
		<?php
		$this->field_generator( $instance );
	}

	public
	function update(
		$new_instance, $old_instance
	) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['list']  = ( ! empty( $new_instance['list'] ) ) ? strip_tags( $new_instance['list'] ) : '';
		$instance['desc']  = ( ! empty( $new_instance['desc'] ) ) ? strip_tags( $new_instance['desc'] ) : '';
		foreach ( $this->widget_fields as $widget_field ) {
			switch ( $widget_field['type'] ) {
				default:
					$instance[ $widget_field['id'] ] = ( ! empty( $new_instance[ $widget_field['id'] ] ) ) ? strip_tags( $new_instance[ $widget_field['id'] ] ) : '';
			}
		}

		return $instance;
	}
}

function register_new_widget6() {
	register_widget( 'leaguesd' );
}

add_action( 'widgets_init', 'register_new_widget6' );
wp_reset_query();