<?php
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

function apuestanweb_load_css_files() {
	wp_enqueue_style( 'apuestanweb-style', get_template_directory_uri() . '/assets/css/styles.css' );
    wp_enqueue_script( 'apuestanweb-js', get_template_directory_uri() . '/assets/js/scripts.js', array( 'js' ), '', true );
}
add_action( 'wp_enqueue_scripts', 'apuestanweb_load_css_files' );

function apuestanweb_load_scripts() {
	
		wp_register_script( 'theme_scripts', get_template_directory_uri(). '/assets/js/scripts.js');
		wp_enqueue_script( 'theme_scripts' );
	
}
add_action( 'wp_enqueue_scripts', 'apuestanweb_load_scripts' );

// Removes some links from the header
function my_theme_remove_headlinks() {
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'start_post_rel_link' );
    remove_action( 'wp_head', 'index_rel_link' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
    remove_action( 'wp_head', 'adjacent_posts_rel_link' );
    remove_action( 'wp_head', 'parent_post_rel_link' );
    remove_action( 'wp_head', 'feed_links_extra', 3 );
    remove_action( 'wp_head', 'feed_links', 2 );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'my_theme_remove_headlinks' );

//limite de palabras del etracto
function my_theme_excerpt($length) {
    return 25;
}
add_filter( 'excerpt_length', 'my_theme_excerpt' );

function apuestanweb_setup() {

	register_nav_menus(array(
		'izquierda'  => __( 'Desktop Izquierda', 'apuestanweb_lang' ),
		'derecha'  => __( 'Desktop Derecha', 'apuestanweb_lang' ),
		'mobile'  => __( 'Mobile', 'apuestanweb_lang' ),
		'sub_header'  => __( 'Menu de sub_header', 'apuestanweb_lang' )
	));
     
	// Ready for i18n
	load_theme_textdomain( "apuestanweb_lang", TEMPLATEPATH . "/lang");

	// Use thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Enable support for custom logo.
	add_theme_support( 'custom-logo', array(
		'height' => 240,
		'width' => 240,
		'flex-height' => true,
		'header-text' => array('site-title'),
		'unlink-homepage-logo' => false
	) );

	// Switch default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

}

// Añadiendo soporte de logo personalizado
if(function_exists('add_theme_support')){
	add_action( 'after_setup_theme', 'apuestanweb_setup' );
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
		'taxonomies'            => array( 'deportes', 'progreso' ),
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
add_action( 'init', 'taxonomia_tipo_deporte' );
function taxonomia_tipo_progreso() {
	$labels = array(
		'name'                => _x( 'progreso', 'taxonomy general name', 'apuestanweb_lang' ),
		'singular_name'       => _x( 'progreso', 'taxonomy singular name', 'apuestanweb_lang' ),
		'search_items'        => __( 'Buscar progreso', 'apuestanweb_lang' ),
		'all_items'           => __( 'Todos los tipos de progreso', 'apuestanweb_lang' ),
		'parent_item'         => __( 'progreso padre', 'apuestanweb_lang' ),
		'parent_item_colon'   => __( 'progreso Padre:', 'apuestanweb_lang' ),
		'edit_item'           => __( 'Editar progreso', 'apuestanweb_lang' ),
		'update_item'         => __( 'Editar progreso', 'apuestanweb_lang' ),
		'add_new_item'        => __( 'Agregar nuevo progreso', 'apuestanweb_lang' ),
		'new_item_name'       => __( 'Nuevo progreso', 'apuestanweb_lang' ),
		'menu_name'           => __( 'progreso', 'apuestanweb_lang' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'progreso' ),
		'show_in_rest'      => true
	);
	// Nombre de taxonomia, post type al que se aplica y argumentos.
	register_taxonomy( 'progreso', array( 'pronosticos' ), $args );
}
add_action( 'init', 'taxonomia_tipo_progreso' );
// Agrega post personalizados a la página inicial de WP */
function get_posts_types( $query ) {
		if ( is_home() && $query->is_main_query() ) {
			$query->set( 'post_type', array( 'post' ) );
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
		return get_terms(['taxonomy' => $taxonomy,'hide_empty' => true]);
	};
}
//Creando shortcode pronosticos
function pronosticos_sections() {
	foreach (get_term_names(get_object_taxonomies('pronosticos')) as $term) : 
		$args = array(
			'posts_per_page' => get_option('to_count_pronosticos'), 
			'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
			'tax_query' => array(
				array(
					'taxonomy' => $term->taxonomy,
					'terms'    => $term->slug,
				),
			),
		); 
		$cpt = new WP_Query($args); ?>
		<section class="container_tarjetitas" >
			<h2 class="sub_title" ><?php echo __("Pronósticos: ".strtoupper($term->name)."", 'apuestanweb_lang'); ?></h2>
			<?php 
				// The Loop
				while ( $cpt->have_posts() ) :
					$cpt->the_post();
					$post_tax = wp_get_post_terms( get_the_ID(), $term->taxonomy, array( 'fields' => 'slugs' ) );
					if($post_tax[0] == $term->slug) : 
						get_template_part('template-parts/tarjetita_pronostico');
					endif; endwhile; ?>
		</section>
	<?php endforeach; 
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
