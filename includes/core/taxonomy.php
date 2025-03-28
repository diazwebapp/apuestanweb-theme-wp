<?php

function custom_taxonomy_league() {

	$labels = array(
		'name'                       => __( 'League', 'jbetting' ),
		'singular_name'              => __( 'League', 'jbetting' ),
		'menu_name'                  => __( 'League', 'jbetting' ),
		'all_items'                  => __( 'All', 'jbetting' ),
		'parent_item'                => __( 'Parent Item', 'jbetting' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jbetting' ),
		'new_item_name'              => __( 'New Item Name', 'jbetting' ),
		'add_new_item'               => __( 'Add New Item', 'jbetting' ),
		'edit_item'                  => __( 'Edit Item', 'jbetting' ),
		'update_item'                => __( 'Update Item', 'jbetting' ),
		'view_item'                  => __( 'View Item', 'jbetting' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jbetting' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jbetting' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jbetting' ),
		'popular_items'              => __( 'Popular Items', 'jbetting' ),
		'search_items'               => __( 'Search Items', 'jbetting' ),
		'not_found'                  => __( 'Not Found', 'jbetting' ),
		'no_terms'                   => __( 'No items', 'jbetting' ),
		'items_list'                 => __( 'Items list', 'jbetting' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jbetting' ),
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_in_rest' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'league')
	);
	register_taxonomy( 'league', array( 'forecast', 'page', 'post', 'parley' ), $args );

}
add_action( 'init', 'custom_taxonomy_league', 0 );

function custom_taxonomy_bookmaker_payment_methods() {

	$labels = array(
		'name'                       => __( 'bookmaker payment methods', 'jbetting' ),
		'singular_name'              => __( 'bookmaker payment methods', 'jbetting' ),
		'menu_name'                  => __( 'bookmaker payment methods', 'jbetting' ),
		'all_items'                  => __( 'All', 'jbetting' ),
		'parent_item'                => __( 'Parent Item', 'jbetting' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jbetting' ),
		'new_item_name'              => __( 'New Item Name', 'jbetting' ),
		'add_new_item'               => __( 'Add New Item', 'jbetting' ),
		'edit_item'                  => __( 'Edit Item', 'jbetting' ),
		'update_item'                => __( 'Update Item', 'jbetting' ),
		'view_item'                  => __( 'View Item', 'jbetting' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jbetting' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jbetting' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jbetting' ),
		'popular_items'              => __( 'Popular Items', 'jbetting' ),
		'search_items'               => __( 'Search Items', 'jbetting' ),
		'not_found'                  => __( 'Not Found', 'jbetting' ),
		'no_terms'                   => __( 'No items', 'jbetting' ),
		'items_list'                 => __( 'Items list', 'jbetting' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jbetting' ),
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_in_rest' => true
	);
	register_taxonomy( 'bookmaker-payment-methods', array( 'bk', 'page' ), $args );

}
add_action( 'init', 'custom_taxonomy_bookmaker_payment_methods', 0 );

function taxonomy_casinos() {

	$labels = array(
		'name'                       => __( 'casinos', 'jbetting' ),
		'singular_name'              => __( 'casino', 'jbetting' ),
		'menu_name'                  => __( 'casinos', 'jbetting' ),
		'all_items'                  => __( 'All', 'jbetting' ),
		'parent_item'                => __( 'Parent Item', 'jbetting' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jbetting' ),
		'new_item_name'              => __( 'New Item Name', 'jbetting' ),
		'add_new_item'               => __( 'Add New Item', 'jbetting' ),
		'edit_item'                  => __( 'Edit Item', 'jbetting' ),
		'update_item'                => __( 'Update Item', 'jbetting' ),
		'view_item'                  => __( 'View Item', 'jbetting' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jbetting' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jbetting' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jbetting' ),
		'popular_items'              => __( 'Popular Items', 'jbetting' ),
		'search_items'               => __( 'Search Items', 'jbetting' ),
		'not_found'                  => __( 'Not Found', 'jbetting' ),
		'no_terms'                   => __( 'No items', 'jbetting' ),
		'items_list'                 => __( 'Items list', 'jbetting' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jbetting' ),
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_in_rest' => true
	);
	register_taxonomy( 'casinos', array( 'bk', 'page' ), $args );

}
add_action( 'init', 'taxonomy_casinos', 0 );

function crear_taxonomia_content_hub() {
    $labels = array(
        'name'              => 'Categorías de Content Hub',
        'singular_name'     => 'Categoría de Content Hub',
        'search_items'      => 'Buscar Categorías de Content Hub',
        'all_items'         => 'Todas las Categorías',
        'parent_item'       => 'Categoría principal',
        'parent_item_colon' => 'Categoría principal:',
        'edit_item'         => 'Editar Categoría',
        'update_item'       => 'Actualizar Categoría',
        'add_new_item'      => 'Agregar nueva Categoría',
        'new_item_name'     => 'Nombre de la nueva Categoría',
        'menu_name'         => 'Categorías de Content Hub',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'categoria-content-hub'),
    );

    register_taxonomy('categoria_content_hub', array( 'content_hub' ), $args);

}
add_action('init', 'crear_taxonomia_content_hub', 0);
