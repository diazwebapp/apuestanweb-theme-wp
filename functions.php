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
//comprueba si un post existe
function aw_post_exists($post_name,$post_type){
	$query = new WP_Query( array( 'pagename' => $post_name,'post_type'=>$post_type ) );
	if($query->have_posts()){
		$query->the_post();
		return true;
	}else{
		return false;
	};
}
//Cambiando estilos e login
function my_login_logo() { ?>
	<style type="text/css">
	  #login h1 a, .login h1 a {
	  background-image: url(<?php echo get_template_directory_uri(). '/assets/images/hh2.png'; ?>);
		width:100%;
		background-size: contain;
		background-repeat: no-repeat;
	  }
	</style>
  <?php }//end my_login_logo()
  add_action( 'login_enqueue_scripts', 'my_login_logo' );
  
  function my_login_logo_url() {
	return home_url();
  }//end my_login_logo_url()
  add_filter( 'login_headerurl', 'my_login_logo_url' );
  
  function my_login_logo_url_title() {
	return 'Apuestanweb';
  }//end my_login_logo_url_title()
  add_filter( 'login_headertitle', 'my_login_logo_url_title' );


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
		'izquierda'  => __( 'Desktop Izquierda', 'apuestanweb-lang' ),
		'derecha'  => __( 'Desktop Derecha', 'apuestanweb-lang' ),
		'mobile'  => __( 'Mobile', 'apuestanweb-lang' ),
		'sub_header'  => __( 'Menu de sub_header', 'apuestanweb-lang' )
	));
     
	// Ready for i18n
	load_theme_textdomain( "apuestanweb-lang", get_template_directory_uri(). "/lang");

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
	
	if(!aw_post_exists('blog','page')){
		wp_insert_post(array(
			'post_title'   => 'Blog',
			'post_status'  => 'publish',
			'post_type'		=> 'page'
			/* 'tax_input'    => array(
				'hierarchical_tax'     => $hierarchical_tax,
				'non_hierarchical_tax' => $non_hierarchical_terms,
			),
			'meta_input'   => array(
				'test_meta_key' => 'value of test_meta_key',
			), */
		));
	 } 
	 if(!aw_post_exists('e-sports','page')){
		wp_insert_post(array(
			'post_title'   => 'E-Sports',
			'post_status'  => 'publish',
			'post_type'		=> 'page'
			/* 'tax_input'    => array(
				'hierarchical_tax'     => $hierarchical_tax,
				'non_hierarchical_tax' => $non_hierarchical_terms,
			),
			'meta_input'   => array(
				'test_meta_key' => 'value of test_meta_key',
			), */
		));
	 } 
}

// Añadiendo soporte de logo personalizado
if(function_exists('add_theme_support')){
	add_action( 'after_setup_theme', 'apuestanweb_setup' );
}

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
		'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'excerpt' ),
		'taxonomies'            => array('deporte','estado','post_tag'),
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
		'name'                => _x( 'deportes', 'taxonomy general name', 'apuestanweb-lang' ),
		'singular_name'       => _x( 'deporte', 'taxonomy singular name', 'apuestanweb-lang' ),
		'search_items'        => __( 'Buscar deportes', 'apuestanweb-lang' ),
		'all_items'           => __( 'Todos los tipos de deportes', 'apuestanweb-lang' ),
		'parent_item'         => __( 'deporte padre', 'apuestanweb-lang' ),
		'parent_item_colon'   => __( 'deporte Padre:', 'apuestanweb-lang' ),
		'edit_item'           => __( 'Editar deporte', 'apuestanweb-lang' ),
		'update_item'         => __( 'Editar deporte', 'apuestanweb-lang' ),
		'add_new_item'        => __( 'Agregar nuevo deporte', 'apuestanweb-lang' ),
		'new_item_name'       => __( 'Nuevo deporte', 'apuestanweb-lang' ),
		'menu_name'           => __( 'deporte', 'apuestanweb-lang' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'deportes' ),
		'show_in_rest'      => true,
		'show_in_nav_menus' => true
	);
	// Nombre de taxonomia, post type al que se aplica y argumentos.
	register_taxonomy( 'deporte', array( 'pronosticos' ), $args );
}
add_action( 'init', 'taxonomia_tipo_deporte' );

function taxonomia_tipo_estado() {
	$labels = array(
		'name'                => _x( 'estados', 'taxonomy general name', 'apuestanweb-lang' ),
		'singular_name'       => _x( 'estado', 'taxonomy singular name', 'apuestanweb-lang' ),
		'search_items'        => __( 'Buscar estado', 'apuestanweb-lang' ),
		'all_items'           => __( 'Todos los tipos de estados', 'apuestanweb-lang' ),
		'parent_item'         => __( 'estado padre', 'apuestanweb-lang' ),
		'parent_item_colon'   => __( 'estado Padre:', 'apuestanweb-lang' ),
		'edit_item'           => __( 'Editar estado', 'apuestanweb-lang' ),
		'update_item'         => __( 'Editar estado', 'apuestanweb-lang' ),
		'add_new_item'        => __( 'Agregar nuevo estado', 'apuestanweb-lang' ),
		'new_item_name'       => __( 'Nuevo estado', 'apuestanweb-lang' ),
		'menu_name'           => __( 'estado', 'apuestanweb-lang' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'estados' ),
		'show_in_rest'      => true,
		'show_in_nav_menus' => true
	);
	// Nombre de taxonomia, post type al que se aplica y argumentos.
	register_taxonomy( 'estado', array( 'pronosticos' ), $args );
}
add_action( 'init', 'taxonomia_tipo_estado' );

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
		'name' => __('Apuestanweb Sidebar','apuestanweb-lang'),
		'before_widget' => '<div class="aside_widgets" >',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));

	register_sidebar(array(
		'id' => 'top_widget',
		'name' => __('Apuestanweb top banner','apuestanweb-lang'),
		'before_widget' => '<div class="aside_widgets" >',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));
}

add_action('widgets_init','widgets_apuestanweb');

function aw_taxonomy_by_post_type_and_term($array_tax,$term){
	$trems = array();
	if(isset($term)){
		foreach($array_tax as $taxonomy_name){
			foreach(get_terms(array('taxonomy'=>$taxonomy_name,'hide_empty'=>false)) as $term_1){
				if($taxonomy_name == $term_1->taxonomy && $term_1->name == $term){
					return $taxonomy_name;
				}
			}
		}
	}
}

function aw_terms_by_taxs($array_taxonomies){
	$terms = array();
	
		foreach (get_terms(array('hide_empty' => false)) as $term) {
			foreach ($array_taxonomies as $key => $taxonomy) {
				if($taxonomy == $term->taxonomy){
					$terms[] = $term ;
				}
			}
		}
	
	return $terms;
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
			<h2 class="sub_title" ><?php echo __("Pronósticos: ".strtoupper($term->name)."", 'apuestanweb-lang'); ?></h2>
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
$post_arr = array(
    'post_title'   => 'E-Sports',
    'post_content' => 'Test post content',
	'post_status'  => 'publish',
	'post_type'		=> 'page'
    /* 'tax_input'    => array(
        'hierarchical_tax'     => $hierarchical_tax,
        'non_hierarchical_tax' => $non_hierarchical_terms,
    ),
    'meta_input'   => array(
        'test_meta_key' => 'value of test_meta_key',
    ), */
);

function my_login_redirect($user_name, $user) {
	foreach($user->roles as $rol){
		if($rol !== 'administrator'){
			wp_redirect(home_url());
			exit;
		}
	}
}
add_action( 'wp_login', 'my_login_redirect', 10, 3 );

// Accedemos a la variable global creada por WordPress
global $wp_roles;
// Añadimos un nuevo rol para este tipo de usuarios

$wp_roles->add_role('VIP', 'VIP', array(
	'read' => true, // Les damos permisos de lectura (como a los suscriptores)
	'edit_posts' => false, // No tienen permisos suficientes para editar entradas
	'delete_posts' => false, // No tienen permisos suficientes para eliminar entradas
	'leer_datos' => true // Creamos una capacidad nueva exclusiva para este rol
  ));