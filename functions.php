<?php
/**

 *
 * @package WordPress
 * @subpackage Apuestanweb
 * @since Apuestan web 1.0
 */
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

function apuestanweb_load_css_files() {
   wp_register_style( 'css', get_template_directory_uri() . '/style.css' );
   wp_register_style( 'theme-css', get_stylesheet_uri(), array('css') );
   wp_enqueue_style('theme-css');
}
add_action( 'wp_enqueue_scripts', 'apuestanweb_load_css_files' );

function apuestanwe_load_scripts() {
	
		wp_register_script( 'theme_scripts', get_template_directory_uri(). '/assets/js/scripts.js');
		wp_enqueue_script( 'theme_scripts' );
	
}
add_action( 'wp_enqueue_scripts', 'apuestanwe_load_scripts' );
function apuestanweb_menus() {

	$locations = array(
		'izquierda'  => __( 'Desktop Izquierda', 'apuestanweb' ),
		'derecha'  => __( 'Desktop Derecha', 'apuestanweb' ),
		'mobile'  => __( 'Mobile', 'apuestanweb' ),
		'sub_header'  => __( 'Menu de sub_header', 'apuestanweb' )
	);

	register_nav_menus( $locations );
}

add_action( 'after_setup_theme', 'apuestanweb_menus' );


// Añadiendo soporte de logo personalizado
if(function_exists('add_theme_support')){
	// logo
	$default = array(
		'height' => 64,
		'width'  => 64,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array('site-title'),
		'unlink-homepage-logo' => false
	);
	add_theme_support('custom-logo',$default);

	//imagen destacada
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1568, 9999 );

}

// Register Custom Pronostico
function custom_post_type_pronostico() {

	$labels = array(
		'name'                  => _x( 'pronosticos', 'Pronostico General Name', 'text_domain' ),
		'singular_name'         => _x( 'pronostico', 'Pronostico Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Pronosticos', 'text_domain' ),
		'name_admin_bar'        => __( 'Pronostico', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'pronostico', 'text_domain' ),
		'description'           => __( 'Post Type Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'excerpt' ),
		'taxonomies'            => array( 'deportes' ),
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
	register_post_type( 'pronosticos', $args );

}

add_action( 'init', 'custom_post_type_pronostico');

// Creando taxonomia, para pronosticos.
add_action( 'init', 'taxonomia_tipo_deporte' );

function taxonomia_tipo_deporte() {
	$labels = array(
		'name'                => _x( 'Deporte', 'taxonomy general name', 'deportes' ),
		'singular_name'       => _x( 'Deporte', 'taxonomy singular name', 'deportes' ),
		'search_items'        => __( 'Buscar Deporte', 'deportes' ),
		'all_items'           => __( 'Todos los tipos de deporte', 'deportes' ),
		'parent_item'         => __( 'Deporte padre', 'deportes' ),
		'parent_item_colon'   => __( 'Deporte Padre:', 'deportes' ),
		'edit_item'           => __( 'Editar Deporte', 'deportes' ),
		'update_item'         => __( 'Editar Deporte', 'deportes' ),
		'add_new_item'        => __( 'Agregar nuevo Deporte', 'deportes' ),
		'new_item_name'       => __( 'Nuevo Deporte', 'deportes' ),
		'menu_name'           => __( 'Deporte', 'deportes' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'deportes' ),
		'show_in_rest'      => true
	);
	// Nombre de taxonomia, post type al que se aplica y argumentos.
	register_taxonomy( 'deportes', array( 'pronosticos' ), $args );
}

/* Agrega post personalizados a la página inicial de WP */
/* function get_posts_types( $query ) {
		if ( is_home() && $query->is_main_query() ) {
			$query->set( 'post_type', array( 'post') );
		}

		return $query;
	} */

add_filter( 'pre_get_posts', 'get_posts_types' );

// Register Custom Deporte
function custom_post_type_deporte() {

	$labels = array(
		'name'                  => _x( 'Deportes', 'Deporte General Name', 'text_domain' ),
		'singular_name'         => _x( 'Deporte', 'Deporte Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Deportes', 'text_domain' ),
		'name_admin_bar'        => __( 'Deporte', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Deporte', 'text_domain' ),
		'description'           => __( 'Deporte Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'excerpt' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
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
	register_post_type( 'Deporte', $args );

}
//add_action( 'init', 'custom_post_type_deporte');

// Register CPT casas apuestas
function cpt_casa_apuestas() {

	$labels = array(
		'name'                  => _x( 'Casa apuestas', 'Casa apuesta General Name', 'text_domain' ),
		'singular_name'         => _x( 'Casa apuesta', 'Casa apuesta Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Casa apuestas', 'text_domain' ),
		'name_admin_bar'        => __( 'Casa apuesta', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Casa apuesta', 'text_domain' ),
		'description'           => __( 'Casa apuesta Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail' ),
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

/* add_meta_box(
	'meta_casa_apuesta',
	'Datos casa apuesta',
	'func_casa_apuesta',
	'casaapuesta',
	'normal',
	'high'
);
function func_casa_apuesta($post){ ?>
	<div>Datos de test</div>
<?php } */

/** Activanco widgets */

function widgets_apuestanweb(){
	register_sidebar(array(
		'id' => 'primary_widget',
		'name' => __('Apuestanweb Sidebar'),
		'before_widget' => '<div class="aside_widgets" >',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));

	register_sidebar(array(
		'id' => 'top_widget',
		'name' => __('Apuestanweb top banner'),
		'before_widget' => '<div class="aside_widgets" >',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));
}

add_action('widgets_init','widgets_apuestanweb');