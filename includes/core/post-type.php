<?php

function create_bk() {

	$labels = array(
		'name'                  => __( 'Bookmaker', 'jbetting' ),
		'singular_name'         => __( 'Bookmaker', 'jbetting' ),
		'menu_name'             => __( 'Bookmaker', 'jbetting' ),
		'name_admin_bar'        => __( 'Bookmaker', 'jbetting' ),
		'archives'              => __( 'Archive', 'jbetting' ),
		'attributes'            => __( 'Attributes', 'jbetting' ),
		'parent_item_colon'     => __( 'Parent Item:', 'jbetting' ),
		'all_items'             => __( 'All bookmakers', 'jbetting' ),
		'add_new_item'          => __( 'All bookmakers', 'jbetting' ),
		'add_new'               => __( 'Add', 'jbetting' ),
		'new_item'              => __( 'Add', 'jbetting' ),
		'edit_item'             => __( 'Edit', 'jbetting' ),
		'update_item'           => __( 'Update bookmaker', 'jbetting' ),
		'view_item'             => __( 'View', 'jbetting' ),
		'view_items'            => __( 'View', 'jbetting' ),
		'search_items'          => __( 'Find', 'jbetting' ),
		'not_found'             => __( 'Nothing found', 'jbetting' ),
		'not_found_in_trash'    => __( 'Nothing found', 'jbetting' ),
		'featured_image'        => __( 'Thumbnail', 'jbetting' ),
		'set_featured_image'    => __( 'Set Thumbnail', 'jbetting' ),
		'remove_featured_image' => __( 'Delete Thumbnail', 'jbetting' ),
		'use_featured_image'    => __( 'Use as Thumbnail', 'jbetting' ),
		'insert_into_item'      => __( 'Paste', 'jbetting' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'jbetting' ),
		'items_list'            => __( 'Items list', 'jbetting' ),
		'items_list_navigation' => __( 'Items list navigation', 'jbetting' ),
		'filter_items_list'     => __( 'Filter items list', 'jbetting' ),
	);
	$args   = array(
		'label'               => __( 'Bookmaker', 'jbetting' ),
		'description'         => __( 'Bookmaker', 'jbetting' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'comments' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-star-filled',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'rewrite' => array('slug' => 'casas-apuestas', 'with_front'=> true)
	);
	register_post_type( 'bk', $args );

}

add_action( 'init', 'create_bk', 0 );


function create_forecast() {

	$labels = array(
		'name'                  => __( 'Pronósticos', 'jbetting' ),
		'singular_name'         => __( 'Pronósticos', 'jbetting' ),
		'menu_name'             => __( 'Pronósticos', 'jbetting' ),
		'name_admin_bar'        => __( 'Pronósticos', 'jbetting' ),
		'archives'              => __( 'Archive', 'jbetting' ),
		'attributes'            => __( 'Attributes', 'jbetting' ),
		'parent_item_colon'     => __( 'Parent Item:', 'jbetting' ),
		'all_items'             => __( 'Todos', 'jbetting' ),
		'add_new_item'          => __( 'Todos', 'jbetting' ),
		'add_new'               => __( 'Añadir nuevo', 'jbetting' ),
		'new_item'              => __( 'Add', 'jbetting' ),
		'edit_item'             => __( 'Edit', 'jbetting' ),
		'update_item'           => __( 'Update casino', 'jbetting' ),
		'view_item'             => __( 'View', 'jbetting' ),
		'view_items'            => __( 'View', 'jbetting' ),
		'search_items'          => __( 'Find', 'jbetting' ),
		'not_found'             => __( 'Nothing found', 'jbetting' ),
		'not_found_in_trash'    => __( 'Nothing found', 'jbetting' ),
		'featured_image'        => __( 'Thumbnail', 'jbetting' ),
		'set_featured_image'    => __( 'Set Thumbnail', 'jbetting' ),
		'remove_featured_image' => __( 'Delete Thumbnail', 'jbetting' ),
		'use_featured_image'    => __( 'Use as Thumbnail', 'jbetting' ),
		'insert_into_item'      => __( 'Paste', 'jbetting' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'jbetting' ),
		'items_list'            => __( 'Items list', 'jbetting' ),
		'items_list_navigation' => __( 'Items list navigation', 'jbetting' ),
		'filter_items_list'     => __( 'Filter items list', 'jbetting' ),
	);
	$args   = array(
		'label'               => __( 'Forecast', 'jbetting' ),
		'description'         => __( 'Forecast', 'jbetting' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'author', 'comments', 'thumbnail'),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 4,
		'menu_icon'           => 'dashicons-yes-alt',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'show_in_rest' 		  => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'rewrite' => array('slug' => 'pronosticos', 'with_front'=> true)

	);
	register_post_type( 'forecast', $args );

}

add_action( 'init', 'create_forecast', 0 );


function create_team() {

	$labels = array(
		'name'                  => __( 'Team', 'jbetting' ),
		'singular_name'         => __( 'Team', 'jbetting' ),
		'menu_name'             => __( 'Team', 'jbetting' ),
		'name_admin_bar'        => __( 'Team', 'jbetting' ),
		'archives'              => __( 'Archive', 'jbetting' ),
		'attributes'            => __( 'Attributes', 'jbetting' ),
		'parent_item_colon'     => __( 'Parent Item:', 'jbetting' ),
		'all_items'             => __( 'All', 'jbetting' ),
		'add_new_item'          => __( 'All', 'jbetting' ),
		'add_new'               => __( 'Add', 'jbetting' ),
		'new_item'              => __( 'Add', 'jbetting' ),
		'edit_item'             => __( 'Edit', 'jbetting' ),
		'update_item'           => __( 'Update', 'jbetting' ),
		'view_item'             => __( 'View', 'jbetting' ),
		'view_items'            => __( 'View', 'jbetting' ),
		'search_items'          => __( 'Find', 'jbetting' ),
		'not_found'             => __( 'Nothing found', 'jbetting' ),
		'not_found_in_trash'    => __( 'Nothing found', 'jbetting' ),
		'featured_image'        => __( 'Thumbnail', 'jbetting' ),
		'set_featured_image'    => __( 'Set Thumbnail', 'jbetting' ),
		'remove_featured_image' => __( 'Delete Thumbnail', 'jbetting' ),
		'use_featured_image'    => __( 'Use as Thumbnail', 'jbetting' ),
		'insert_into_item'      => __( 'Paste', 'jbetting' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'jbetting' ),
		'items_list'            => __( 'Items list', 'jbetting' ),
		'items_list_navigation' => __( 'Items list navigation', 'jbetting' ),
		'filter_items_list'     => __( 'Filter items list', 'jbetting' ),
	);
	$args   = array(
		'label'               => __( 'Team', 'jbetting' ),
		'description'         => __( 'Team', 'jbetting' ),
		'labels'              => $labels,
		'supports'            => array( 'title',  ),
		'hierarchical'        => false,
		'show_in_menu'        => true,
		'menu_position'       => 4,
		'menu_icon'           => 'dashicons-networking',
		'show_in_admin_bar'   => true,
		'can_export'          => true,
		'capability_type'     => 'page',
		'public'              => false,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'exclude_from_search' => true,
		'show_in_nav_menus'   => false,
		'has_archive'         => false,
		'rewrite'             => false,
	);
	register_post_type( 'team', $args );

}

add_action( 'init', 'create_team', 0 );


/* 
function create_bonus() {

	$labels = array(
		'name'                  => __( 'bonus_slogan', 'jbetting' ),
		'singular_name'         => __( 'bonus_slogan', 'jbetting' ),
		'menu_name'             => __( 'bonus_slogan', 'jbetting' ),
		'name_admin_bar'        => __( 'bonus_slogan', 'jbetting' ),
		'archives'              => __( 'Archive', 'jbetting' ),
		'attributes'            => __( 'Attributes', 'jbetting' ),
		'parent_item_colon'     => __( 'Parent Item:', 'jbetting' ),
		'all_items'             => __( 'All', 'jbetting' ),
		'add_new_item'          => __( 'All', 'jbetting' ),
		'add_new'               => __( 'Add', 'jbetting' ),
		'new_item'              => __( 'Add', 'jbetting' ),
		'edit_item'             => __( 'Update', 'jbetting' ),
		'update_item'           => __( 'Update', 'jbetting' ),
		'view_item'             => __( 'View', 'jbetting' ),
		'view_items'            => __( 'View', 'jbetting' ),
		'search_items'          => __( 'Find', 'jbetting' ),
		'not_found'             => __( 'Nothing found', 'jbetting' ),
		'not_found_in_trash'    => __( 'Nothing found', 'jbetting' ),
		'featured_image'        => __( 'Thumbnail', 'jbetting' ),
		'set_featured_image'    => __( 'Set Thumbnail', 'jbetting' ),
		'remove_featured_image' => __( 'Delete Thumbnail', 'jbetting' ),
		'use_featured_image'    => __( 'Use as Thumbnail', 'jbetting' ),
		'insert_into_item'      => __( 'Paste', 'jbetting' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'jbetting' ),
		'items_list'            => __( 'Items list', 'jbetting' ),
		'items_list_navigation' => __( 'Items list navigation', 'jbetting' ),
		'filter_items_list'     => __( 'Filter items list', 'jbetting' ),
	);
	$args   = array(
		'label'               => __( 'bonus_slogan', 'jbetting' ),
		'description'         => __( 'bonus_slogan', 'jbetting' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'comments','thumbnail' ),
		'hierarchical'        => false,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-buddicons-community',
		'show_in_admin_bar'   => true,
		'can_export'          => true,
		'capability_type'     => 'page',
		'public'              => false,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'exclude_from_search' => true,
		'show_in_nav_menus'   => false,
		'has_archive'         => false,
		'rewrite'             => false,
	);
	register_post_type( 'bonus_slogan', $args );

}

add_action( 'init', 'create_bonus', 0 );
 */
function create_parley() {

	$labels = array(
		'name'                  => __( 'parley', 'jbetting' ),
		'singular_name'         => __( 'parley', 'jbetting' ),
		'menu_name'             => __( 'parley', 'jbetting' ),
		'name_admin_bar'        => __( 'parley', 'jbetting' ),
		'archives'              => __( 'Archive', 'jbetting' ),
		'attributes'            => __( 'Attributes', 'jbetting' ),
		'parent_item_colon'     => __( 'Parent Item:', 'jbetting' ),
		'all_items'             => __( 'All', 'jbetting' ),
		'add_new_item'          => __( 'All', 'jbetting' ),
		'add_new'               => __( 'Add', 'jbetting' ),
		'new_item'              => __( 'Add', 'jbetting' ),
		'edit_item'             => __( 'Edit', 'jbetting' ),
		'update_item'           => __( 'Update casino', 'jbetting' ),
		'view_item'             => __( 'View', 'jbetting' ),
		'view_items'            => __( 'View', 'jbetting' ),
		'search_items'          => __( 'Find', 'jbetting' ),
		'not_found'             => __( 'Nothing found', 'jbetting' ),
		'not_found_in_trash'    => __( 'Nothing found', 'jbetting' ),
		'featured_image'        => __( 'Thumbnail', 'jbetting' ),
		'set_featured_image'    => __( 'Set Thumbnail', 'jbetting' ),
		'remove_featured_image' => __( 'Delete Thumbnail', 'jbetting' ),
		'use_featured_image'    => __( 'Use as Thumbnail', 'jbetting' ),
		'insert_into_item'      => __( 'Paste', 'jbetting' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'jbetting' ),
		'items_list'            => __( 'Items list', 'jbetting' ),
		'items_list_navigation' => __( 'Items list navigation', 'jbetting' ),
		'filter_items_list'     => __( 'Filter items list', 'jbetting' ),
	);
	$args   = array(
		'label'               => __( 'parley', 'jbetting' ),
		'description'         => __( 'parley', 'jbetting' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'comments' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-yes-alt',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'parley', $args );

}

add_action( 'init', 'create_parley', 0 );
