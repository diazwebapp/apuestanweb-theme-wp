<?php
function jbetting_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Forecast', 'jbetting' ),
		'id'            => 'forecast-right',
		'before_widget' => '<div class="simple-widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="name">',
		'after_title'   => '</div>',
		'description'   => esc_html__( 'Right pages of the forecast', 'jbetting' )
	) );

}
add_action( 'widgets_init', 'jbetting_widgets_init' );