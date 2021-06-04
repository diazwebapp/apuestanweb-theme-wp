<?php
//Activando widgets
function widgets_apuestanweb(){
	register_sidebar(array(
		'id' => 'primary_widget',
		'name' => __('Apuestanweb Sidebar','apuestanweb-lang'),
		'before_widget' => '<div class="aside_widgets" >',
		'after_widget' => '</div>',
		'before_title' => '<p>',
		'after_title' => '</p>'
	));

	register_sidebar(array(
		'id' => 'top_widget',
		'name' => __('Apuestanweb top banner','apuestanweb-lang'),
		'before_widget' => '<div class="top_banner_widget" >',
		'after_widget' => '</div>'
	));

	register_sidebar(array(
		'id' => 'bottom_widget',
		'name' => __('Apuestanweb bottom banner','apuestanweb-lang'),
		'before_widget' => '<div class="bottom_banner_widget" >',
		'after_widget' => '</div>'
	));

	register_sidebar(array(
		'id' => 'footer_widget',
		'name' => __('Apuestanweb footer widget','apuestanweb-lang'),
		'before_widget' => '<div class="aw_footer_widget" >',
		'after_widget' => '</div>'
	));

	register_sidebar(array(
		'id' => 'footer_widget_2',
		'name' => __('Apuestanweb footer widget 2','apuestanweb-lang'),
		'before_widget' => '<div class="aw_footer_widget_2" >',
		'after_widget' => '</div>'
	));

	register_sidebar(array(
		'id' => 'footer_widget_3',
		'name' => __('Apuestanweb footer widget 3','apuestanweb-lang'),
		'before_widget' => '<div class="aw_footer_widget_3" >',
		'after_widget' => '</div>'
	));

	register_sidebar(array(
		'id' => 'footer_widget_4',
		'name' => __('Apuestanweb footer widget 4','apuestanweb-lang'),
		'before_widget' => '<div class="aw_footer_widget_4" >',
		'after_widget' => '</div>'
	));
}

add_action('widgets_init','widgets_apuestanweb');