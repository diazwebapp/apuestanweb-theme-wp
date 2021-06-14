<?php
// Register Custom Pronostico
function custom_post_type_pronostico() {

	$labels = array(
		'name'                  => _x( 'pronosticos', 'Pronostico General Name', 'apuestanweb-lang' ),
		'singular_name'         => _x( 'pronostico', 'Pronostico Singular Name', 'apuestanweb-lang' ),
		'menu_name'             => __( 'Pronosticos', 'apuestanweb-lang' ),
		'name_admin_bar'        => __( 'Pronostico', 'apuestanweb-lang' ),
		'archives'              => __( 'Item Archives', 'apuestanweb-lang' ),
		'attributes'            => __( 'Item Attributes', 'apuestanweb-lang' ),
		'parent_item_colon'     => __( 'Parent Item:', 'apuestanweb-lang' ),
		'all_items'             => __( 'All Items', 'apuestanweb-lang' ),
		'add_new_item'          => __( 'Add New Item', 'apuestanweb-lang' ),
		'add_new'               => __( 'Add New', 'apuestanweb-lang' ),
		'new_item'              => __( 'New Item', 'apuestanweb-lang' ),
		'edit_item'             => __( 'Edit Item', 'apuestanweb-lang' ),
		'update_item'           => __( 'Update Item', 'apuestanweb-lang' ),
		'view_item'             => __( 'View Item', 'apuestanweb-lang' ),
		'view_items'            => __( 'View Items', 'apuestanweb-lang' ),
		'search_items'          => __( 'Search Item', 'apuestanweb-lang' ),
		'not_found'             => __( 'Not found', 'apuestanweb-lang' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'apuestanweb-lang' ),
		'featured_image'        => __( 'Featured Image', 'apuestanweb-lang' ),
		'set_featured_image'    => __( 'Set featured image', 'apuestanweb-lang' ),
		'remove_featured_image' => __( 'Remove featured image', 'apuestanweb-lang' ),
		'use_featured_image'    => __( 'Use as featured image', 'apuestanweb-lang' ),
		'insert_into_item'      => __( 'Insert into item', 'apuestanweb-lang' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'apuestanweb-lang' ),
		'items_list'            => __( 'Items list', 'apuestanweb-lang' ),
		'items_list_navigation' => __( 'Items list navigation', 'apuestanweb-lang' ),
		'filter_items_list'     => __( 'Filter items list', 'apuestanweb-lang' ),
	);
	$args = array(
		'label'                 => __( 'pronostico', 'apuestanweb-lang' ),
		'description'           => __( 'Post Type Description', 'apuestanweb-lang' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt','author','post_meta' ),
		'taxonomies'            => array('deportes'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-analytics',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true
	);
	register_post_type( 'pronostico', $args );

}

add_action( 'init', 'custom_post_type_pronostico');

//añadir CPT al loop wp
function add_custom_post_type_to_query( $query ) {
    if ( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'post_type', array('post', 'pronostico') );
    }
}
add_action( 'pre_get_posts', 'add_custom_post_type_to_query' );

// Creando taxonomia, para pronosticos.

function taxonomia_tipo_deporte() {
	$labels = array(
		'name'                => _x( 'deportes', 'taxonomy general name', 'apuestanweb-lang' ),
		'singular_name'       => _x( 'deporte', 'taxonomy singular name', 'apuestanweb-lang' ),
		'search_items'        => __( 'Buscar deporte', 'apuestanweb-lang' ),
		'all_items'           => __( 'Todos los tipos de deporte', 'apuestanweb-lang' ),
		'parent_item'         => __( 'deporte padre', 'apuestanweb-lang' ),
		'parent_item_colon'   => __( 'deporte Padre:', 'apuestanweb-lang' ),
		'edit_item'           => __( 'Editar deporte', 'apuestanweb-lang' ),
		'update_item'         => __( 'Editar deporte', 'apuestanweb-lang' ),
		'add_new_item'        => __( 'Agregar nuevo deporte', 'apuestanweb-lang' ),
		'new_item_name'       => __( 'Nuevo deporte', 'apuestanweb-lang' ),
		'menu_name'           => __( 'deportes', 'apuestanweb-lang' ),
	);

	$args = array(
		'public' 			=> true,
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' 	=> true,
		'rewrite' => array('slug' => 'deportes', 'with_front' => true)
	);
	// Nombre de taxonomia, post type al que se aplica y argumentos.
	register_taxonomy( 'deportes', array( 'pronostico', 'post' ), $args );
}
add_action( 'init', 'taxonomia_tipo_deporte' );

// Register CPT casas apuestas
function cpt_casa_apuestas() {

	$labels = array(
		'name'                  => _x( 'Casa apuestas', 'Casa apuesta General Name', 'apuestanweb-lang' ),
		'singular_name'         => _x( 'Casa apuesta', 'Casa apuesta Singular Name', 'apuestanweb-lang' ),
		'menu_name'             => __( 'Casa apuestas', 'apuestanweb-lang' ),
		'name_admin_bar'        => __( 'Casa apuesta', 'apuestanweb-lang' ),
		'archives'              => __( 'Item Archives', 'apuestanweb-lang' ),
		'attributes'            => __( 'Item Attributes', 'apuestanweb-lang' ),
		'parent_item_colon'     => __( 'Parent Item:', 'apuestanweb-lang' ),
		'all_items'             => __( 'All Items', 'apuestanweb-lang' ),
		'add_new_item'          => __( 'Add New Item', 'apuestanweb-lang' ),
		'add_new'               => __( 'Add New', 'apuestanweb-lang' ),
		'new_item'              => __( 'New Item', 'apuestanweb-lang' ),
		'edit_item'             => __( 'Edit Item', 'apuestanweb-lang' ),
		'update_item'           => __( 'Update Item', 'apuestanweb-lang' ),
		'view_item'             => __( 'View Item', 'apuestanweb-lang' ),
		'view_items'            => __( 'View Items', 'apuestanweb-lang' ),
		'search_items'          => __( 'Search Item', 'apuestanweb-lang' ),
		'not_found'             => __( 'Not found', 'apuestanweb-lang' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'apuestanweb-lang' ),
		'featured_image'        => __( 'Featured Image', 'apuestanweb-lang' ),
		'set_featured_image'    => __( 'Set featured image', 'apuestanweb-lang' ),
		'remove_featured_image' => __( 'Remove featured image', 'apuestanweb-lang' ),
		'use_featured_image'    => __( 'Use as featured image', 'apuestanweb-lang' ),
		'insert_into_item'      => __( 'Insert into item', 'apuestanweb-lang' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'apuestanweb-lang' ),
		'items_list'            => __( 'Items list', 'apuestanweb-lang' ),
		'items_list_navigation' => __( 'Items list navigation', 'apuestanweb-lang' ),
		'filter_items_list'     => __( 'Filter items list', 'apuestanweb-lang' ),
	);
	$args = array(
		'label'                 => __( 'Casa apuesta', 'apuestanweb-lang' ),
		'description'           => __( 'Casa apuesta Description', 'apuestanweb-lang' ),
		'labels'                => $labels,
		'supports'              => array('title', 'editor', 'thumbnail', 'comments', 'excerpt'),
		'taxonomies'            => false,
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'     => 'page',
		'show_in_rest'        => true,
	);
	register_post_type( 'Casa apuesta', $args );

}
add_action( 'init', 'cpt_casa_apuestas');

$pronosticos = "pronostico";
function prepare_rest_pronosticos($data, $post, $request) {
    $_data = $data->data;
    $fields = get_post_custom($post->ID);
    foreach ($fields as $key => $value){
        $_data[$key] = get_post_meta($post->ID,$key);
    }
    $data->data = $_data;
    return $data;
}
add_filter("rest_prepare_{$pronosticos}", 'prepare_rest_pronosticos', 10, 3);

function user_meta_in_rest(){
	$users = get_users();

	foreach ($users as $key => $user) {
		$metas = get_user_meta($user->ID);
		foreach($metas as $key => $value){
			register_meta('user',$key,['show_in_rest'=>true]);
		}
	}
	return;
}
add_action( 'init', 'user_meta_in_rest');