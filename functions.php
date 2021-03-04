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
	);

	register_nav_menus( $locations );
}

add_action( 'after_setup_theme', 'apuestanweb_menus' );


// Añadiendo soporte de logo personalizado

function add_theme_feactures(){
	// logo
	$default = array(
		'height' => 64,
		'width'  => 64,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array('site-title'),
		'unlink-homepage-logo' => false
	);

	//imagen destacada
	add_theme_support('custom-logo',$default);
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1568, 9999 );
}

add_action('after_setup_theme','add_theme_feactures');

// Register Custom Pronostico
function custom_post_type_pronostico() {

	$labels = array(
		'name'                  => _x( 'Pronosticos', 'Pronostico General Name', 'text_domain' ),
		'singular_name'         => _x( 'Pronostico', 'Pronostico Singular Name', 'text_domain' ),
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
		'label'                 => __( 'Pronostico', 'text_domain' ),
		'description'           => __( 'Pronostico Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions' ),
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
	register_post_type( 'pronosticos', $args );

/**
 * Agrega el tipo personalizado pronostico a la página inicial de WP
 *
 * @param Query $query
 *
 * @return Query
 */
	function get_posts_y_pronosticos( $query ) {
		if ( is_home() && $query->is_main_query() ) {
			$query->set( 'post_type', array( 'post','pronosticos' ) );
		}

		return $query;
	}
	add_filter( 'pre_get_posts', 'get_posts_y_pronosticos' );
}
add_action( 'init', 'custom_post_type_pronostico');

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
add_action( 'init', 'custom_post_type_deporte');

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

add_meta_box(
	'meta_casa_apuesta',
	'Datos casa apuesta',
	'func_casa_apuesta',
	'casaapuesta',
	'normal',
	'high'
);
function func_casa_apuesta($post){ ?>
	<div>Datos de test</div>
<?php }
/* Funcion para insertar paginas */
/* function insertData(){
	global $wpdb;
	$wpdb->insert( 'wp_posts', 
	  array( 
		'post_title' => 'pronosticos', 
		'post_type' => 'page',
		'post_status' => 'publish',
	  )
	);
}

  // Ejecutamos nuestro funcion en WordPress
  add_action('wp', 'insertData'); */

/*   function paginate_aw($prev = '<', $next = '>'){
	  global $wp_query, $wp_rewrite;
	  $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

	  $pagination = array(
		  'base' => '',
		  'format' => '',
		  'total' => $wp_query->max_num_pages,
		  'current' => $current,
		  'prev_text' => __($prev),
		  'next_text' => __($next),
		  'type' => 'plain'
	  );

	  if($wp_rewrite->using_permalinks())
		  $pagination['base'] = user_trailingslashit(trailingslashit(remove_query_arg('s',get_pagenum_link(1) )) . 'page/%#%/', 'paged');
	  if(!empty($wp_query->query_vars['s']))
		  $pagination['add_args'] = array('s'=>$wp_query->query_var('s'));
	echo paginate_links($pagination);
  }
 */