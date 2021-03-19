<?php
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

function apuestanweb_load_css_files() {
   wp_register_style( 'css', get_template_directory_uri() . '/style.css' );
   wp_register_style( 'theme-css', get_stylesheet_uri(), array('css') );
   wp_enqueue_style('theme-css');
}
add_action( 'wp_enqueue_scripts', 'apuestanweb_load_css_files' );

function apuestanweb_load_scripts() {
	
		wp_register_script( 'theme_scripts', get_template_directory_uri(). '/assets/js/scripts.js');
		wp_enqueue_script( 'theme_scripts' );
	
}
add_action( 'wp_enqueue_scripts', 'apuestanweb_load_scripts' );

function apuestanweb_setup() {

	$locations = array(
		'izquierda'  => __( 'Desktop Izquierda', 'apuestanweb_lang' ),
		'derecha'  => __( 'Desktop Derecha', 'apuestanweb_lang' ),
		'mobile'  => __( 'Mobile', 'apuestanweb_lang' ),
		'sub_header'  => __( 'Menu de sub_header', 'apuestanweb_lang' )
	);

	register_nav_menus( $locations );

	// Retrieve the directory for the internationalization files
    $lang_dir = get_template_directory() . '/lang';
     
    // Set the theme's text domain using the unique identifier from above
    load_theme_textdomain('apuestanweb_lang', $lang_dir);
}

add_action( 'after_setup_theme', 'apuestanweb_setup' );


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
		'name'                  => _x( 'pronosticos', 'Pronostico General Name', 'apuestanweb_lang' ),
		'singular_name'         => _x( 'pronostico', 'Pronostico Singular Name', 'apuestanweb_lang' ),
		'menu_name'             => __( 'Pronosticos', 'apuestanweb_lang' ),
		'name_admin_bar'        => __( 'Pronostico', 'apuestanweb_lang' ),
		'archives'              => __( 'Item Archives', 'apuestanweb_lang' ),
		'attributes'            => __( 'Item Attributes', 'apuestanweb_lang' ),
		'parent_item_colon'     => __( 'Parent Item:', 'apuestanweb_lang' ),
		'all_items'             => __( 'All Items', 'apuestanweb_lang' ),
		'add_new_item'          => __( 'Add New Item', 'apuestanweb_lang' ),
		'add_new'               => __( 'Add New', 'apuestanweb_lang' ),
		'new_item'              => __( 'New Item', 'apuestanweb_lang' ),
		'edit_item'             => __( 'Edit Item', 'apuestanweb_lang' ),
		'update_item'           => __( 'Update Item', 'apuestanweb_lang' ),
		'view_item'             => __( 'View Item', 'apuestanweb_lang' ),
		'view_items'            => __( 'View Items', 'apuestanweb_lang' ),
		'search_items'          => __( 'Search Item', 'apuestanweb_lang' ),
		'not_found'             => __( 'Not found', 'apuestanweb_lang' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'apuestanweb_lang' ),
		'featured_image'        => __( 'Featured Image', 'apuestanweb_lang' ),
		'set_featured_image'    => __( 'Set featured image', 'apuestanweb_lang' ),
		'remove_featured_image' => __( 'Remove featured image', 'apuestanweb_lang' ),
		'use_featured_image'    => __( 'Use as featured image', 'apuestanweb_lang' ),
		'insert_into_item'      => __( 'Insert into item', 'apuestanweb_lang' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'apuestanweb_lang' ),
		'items_list'            => __( 'Items list', 'apuestanweb_lang' ),
		'items_list_navigation' => __( 'Items list navigation', 'apuestanweb_lang' ),
		'filter_items_list'     => __( 'Filter items list', 'apuestanweb_lang' ),
	);
	$args = array(
		'label'                 => __( 'pronostico', 'apuestanweb_lang' ),
		'description'           => __( 'Post Type Description', 'apuestanweb_lang' ),
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
		'has_archive'           => 'pronosticos',
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
		'name'                => _x( 'Deporte', 'taxonomy general name', 'apuestanweb_lang' ),
		'singular_name'       => _x( 'Deporte', 'taxonomy singular name', 'apuestanweb_lang' ),
		'search_items'        => __( 'Buscar Deporte', 'apuestanweb_lang' ),
		'all_items'           => __( 'Todos los tipos de deporte', 'apuestanweb_lang' ),
		'parent_item'         => __( 'Deporte padre', 'apuestanweb_lang' ),
		'parent_item_colon'   => __( 'Deporte Padre:', 'apuestanweb_lang' ),
		'edit_item'           => __( 'Editar Deporte', 'apuestanweb_lang' ),
		'update_item'         => __( 'Editar Deporte', 'apuestanweb_lang' ),
		'add_new_item'        => __( 'Agregar nuevo Deporte', 'apuestanweb_lang' ),
		'new_item_name'       => __( 'Nuevo Deporte', 'apuestanweb_lang' ),
		'menu_name'           => __( 'Deporte', 'apuestanweb_lang' ),
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

// Agrega post personalizados a la página inicial de WP */
function get_posts_types( $query ) {
		if ( is_home() && $query->is_main_query() ) {
			$query->set( 'post_type', array( 'post','pronosticos') );
		}

		return $query;
	} 

add_filter( 'pre_get_posts', 'get_posts_types' );

// Register CPT casas apuestas
function cpt_casa_apuestas() {

	$labels = array(
		'name'                  => _x( 'Casa apuestas', 'Casa apuesta General Name', 'apuestanweb_lang' ),
		'singular_name'         => _x( 'Casa apuesta', 'Casa apuesta Singular Name', 'apuestanweb_lang' ),
		'menu_name'             => __( 'Casa apuestas', 'apuestanweb_lang' ),
		'name_admin_bar'        => __( 'Casa apuesta', 'apuestanweb_lang' ),
		'archives'              => __( 'Item Archives', 'apuestanweb_lang' ),
		'attributes'            => __( 'Item Attributes', 'apuestanweb_lang' ),
		'parent_item_colon'     => __( 'Parent Item:', 'apuestanweb_lang' ),
		'all_items'             => __( 'All Items', 'apuestanweb_lang' ),
		'add_new_item'          => __( 'Add New Item', 'apuestanweb_lang' ),
		'add_new'               => __( 'Add New', 'apuestanweb_lang' ),
		'new_item'              => __( 'New Item', 'apuestanweb_lang' ),
		'edit_item'             => __( 'Edit Item', 'apuestanweb_lang' ),
		'update_item'           => __( 'Update Item', 'apuestanweb_lang' ),
		'view_item'             => __( 'View Item', 'apuestanweb_lang' ),
		'view_items'            => __( 'View Items', 'apuestanweb_lang' ),
		'search_items'          => __( 'Search Item', 'apuestanweb_lang' ),
		'not_found'             => __( 'Not found', 'apuestanweb_lang' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'apuestanweb_lang' ),
		'featured_image'        => __( 'Featured Image', 'apuestanweb_lang' ),
		'set_featured_image'    => __( 'Set featured image', 'apuestanweb_lang' ),
		'remove_featured_image' => __( 'Remove featured image', 'apuestanweb_lang' ),
		'use_featured_image'    => __( 'Use as featured image', 'apuestanweb_lang' ),
		'insert_into_item'      => __( 'Insert into item', 'apuestanweb_lang' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'apuestanweb_lang' ),
		'items_list'            => __( 'Items list', 'apuestanweb_lang' ),
		'items_list_navigation' => __( 'Items list navigation', 'apuestanweb_lang' ),
		'filter_items_list'     => __( 'Filter items list', 'apuestanweb_lang' ),
	);
	$args = array(
		'label'                 => __( 'Casa apuesta', 'apuestanweb_lang' ),
		'description'           => __( 'Casa apuesta Description', 'apuestanweb_lang' ),
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
		'name' => __('Apuestanweb Sidebar','apuestanweb_lang'),
		'before_widget' => '<div class="aside_widgets" >',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));

	register_sidebar(array(
		'id' => 'top_widget',
		'name' => __('Apuestanweb top banner','apuestanweb_lang'),
		'before_widget' => '<div class="aside_widgets" >',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));
}

add_action('widgets_init','widgets_apuestanweb');


//Extrayendo terminos, recibe como parametro un arreglo de taxonomias
function get_term_names($taxonomies){
	foreach ($taxonomies as $key => $taxonomy) {
		return get_terms($taxonomy);
	};
}
//Creando shortcode pronosticos
function pronosticos_sections() {
	// get taxonomies by post type, and print loop content filtred by term taxonomi
	set_query_var('array_taxonomy',get_term_names(get_object_taxonomies('pronosticos')));
	get_template_part('template-parts/content-archive-pronosticos');
}
add_shortcode('pronosticos_list', 'pronosticos_sections');

//pagination
function pagination_nav() {
    global $wp_query;
 
    if ( $wp_query->max_num_pages > 1 ) { ?>
        <nav class="pagination" role="navigation">
            <div class="nav-previous"><?php next_posts_link( 'Siguiente >' ); ?></div>
            <div class="nav-next"><?php previous_posts_link( '< Anterior' ); ?></div>
        </nav>
<?php }
}
