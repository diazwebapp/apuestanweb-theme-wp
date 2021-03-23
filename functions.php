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
		'izquierda'  => __( 'Desktop Izquierda', 'twentytwenty' ),
		'derecha'  => __( 'Desktop Derecha', 'twentytwenty' ),
		'mobile'  => __( 'Mobile', 'twentytwenty' ),
		'sub_header'  => __( 'Menu de sub_header', 'twentytwenty' )
	));
     
	// Ready for i18n
	load_theme_textdomain( 'twentytwenty' );

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
		'name'                  => _x( 'pronosticos', 'Pronostico General Name', 'twentytwenty' ),
		'singular_name'         => _x( 'pronostico', 'Pronostico Singular Name', 'twentytwenty' ),
		'menu_name'             => __( 'Pronosticos', 'twentytwenty' ),
		'name_admin_bar'        => __( 'Pronostico', 'twentytwenty' ),
		'archives'              => __( 'Item Archives', 'twentytwenty' ),
		'attributes'            => __( 'Item Attributes', 'twentytwenty' ),
		'parent_item_colon'     => __( 'Parent Item:', 'twentytwenty' ),
		'all_items'             => __( 'All Items', 'twentytwenty' ),
		'add_new_item'          => __( 'Add New Item', 'twentytwenty' ),
		'add_new'               => __( 'Add New', 'twentytwenty' ),
		'new_item'              => __( 'New Item', 'twentytwenty' ),
		'edit_item'             => __( 'Edit Item', 'twentytwenty' ),
		'update_item'           => __( 'Update Item', 'twentytwenty' ),
		'view_item'             => __( 'View Item', 'twentytwenty' ),
		'view_items'            => __( 'View Items', 'twentytwenty' ),
		'search_items'          => __( 'Search Item', 'twentytwenty' ),
		'not_found'             => __( 'Not found', 'twentytwenty' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'twentytwenty' ),
		'featured_image'        => __( 'Featured Image', 'twentytwenty' ),
		'set_featured_image'    => __( 'Set featured image', 'twentytwenty' ),
		'remove_featured_image' => __( 'Remove featured image', 'twentytwenty' ),
		'use_featured_image'    => __( 'Use as featured image', 'twentytwenty' ),
		'insert_into_item'      => __( 'Insert into item', 'twentytwenty' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'twentytwenty' ),
		'items_list'            => __( 'Items list', 'twentytwenty' ),
		'items_list_navigation' => __( 'Items list navigation', 'twentytwenty' ),
		'filter_items_list'     => __( 'Filter items list', 'twentytwenty' ),
	);
	$args = array(
		'label'                 => __( 'pronostico', 'twentytwenty' ),
		'description'           => __( 'Post Type Description', 'twentytwenty' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'excerpt' ),
		'taxonomies'            => array('post_tag'),
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

//añadir CPT al loop wp
function my_get_posts( $query )
{
    global $wp_query;
    if ( !is_preview() && !is_admin() && !is_singular() )
    {
        $args = array(
            'public' => true ,
            '_builtin' => false
        );
        $output = 'names';
        $operator = 'and';
        $post_types = get_post_types( $args , $output , $operator );
        $post_types = array_merge( $post_types , array( 'post', 'pronosticos') );
        if ($query->is_feed)
        {
            /* Si es el Feed no insertes los custom posts, si quiere mostrarlo quita este if */
        } else {
            $my_post_type = get_query_var( 'post_type' );
            if ( empty( $my_post_type ) )
            {
                $query->set( 'post_type' , $post_types );
            }
        }
    }
    return $query;
}
add_filter( 'pre_get_posts', 'my_get_posts' );

// Creando taxonomia, para pronosticos.

function taxonomia_tipo_deporte() {
	$labels = array(
		'name'                => _x( 'deportes', 'taxonomy general name', 'twentytwenty' ),
		'singular_name'       => _x( 'deporte', 'taxonomy singular name', 'twentytwenty' ),
		'search_items'        => __( 'Buscar deporte', 'twentytwenty' ),
		'all_items'           => __( 'Todos los tipos de deportes', 'twentytwenty' ),
		'parent_item'         => __( 'deporte padre', 'twentytwenty' ),
		'parent_item_colon'   => __( 'deporte Padre:', 'twentytwenty' ),
		'edit_item'           => __( 'Editar deporte', 'twentytwenty' ),
		'update_item'         => __( 'Editar deporte', 'twentytwenty' ),
		'add_new_item'        => __( 'Agregar nuevo deporte', 'twentytwenty' ),
		'new_item_name'       => __( 'Nuevo deporte', 'twentytwenty' ),
		'menu_name'           => __( 'deportes', 'twentytwenty' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'show_in_nav_menus' => true,
		'rewrite' => array('slug' => 'deportes', 'with_front' => true)
	);
	// Nombre de taxonomia, post type al que se aplica y argumentos.
	register_taxonomy( 'deportes', array( 'pronosticos' ), $args );
}
add_action( 'init', 'taxonomia_tipo_deporte' );

function taxonomia_tipo_estado() {
	$labels = array(
		'name'                => _x( 'estados', 'taxonomy general name', 'twentytwenty' ),
		'singular_name'       => _x( 'estado', 'taxonomy singular name', 'twentytwenty' ),
		'search_items'        => __( 'Buscar estado', 'twentytwenty' ),
		'all_items'           => __( 'Todos los tipos de estados', 'twentytwenty' ),
		'parent_item'         => __( 'estado padre', 'twentytwenty' ),
		'parent_item_colon'   => __( 'estado Padre:', 'twentytwenty' ),
		'edit_item'           => __( 'Editar estado', 'twentytwenty' ),
		'update_item'         => __( 'Editar estado', 'twentytwenty' ),
		'add_new_item'        => __( 'Agregar nuevo estado', 'twentytwenty' ),
		'new_item_name'       => __( 'Nuevo estado', 'twentytwenty' ),
		'menu_name'           => __( 'estados', 'twentytwenty' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'show_in_nav_menus' => true,
		'rewrite' => array('slug' => 'estados', 'with_front' => true)
	);
	// Nombre de taxonomia, post type al que se aplica y argumentos.
	register_taxonomy( 'estados', array( 'pronosticos' ), $args );
}
add_action( 'init', 'taxonomia_tipo_estado' );

// Register CPT casas apuestas
function cpt_casa_apuestas() {

	$labels = array(
		'name'                  => _x( 'Casa apuestas', 'Casa apuesta General Name', 'twentytwenty' ),
		'singular_name'         => _x( 'Casa apuesta', 'Casa apuesta Singular Name', 'twentytwenty' ),
		'menu_name'             => __( 'Casa apuestas', 'twentytwenty' ),
		'name_admin_bar'        => __( 'Casa apuesta', 'twentytwenty' ),
		'archives'              => __( 'Item Archives', 'twentytwenty' ),
		'attributes'            => __( 'Item Attributes', 'twentytwenty' ),
		'parent_item_colon'     => __( 'Parent Item:', 'twentytwenty' ),
		'all_items'             => __( 'All Items', 'twentytwenty' ),
		'add_new_item'          => __( 'Add New Item', 'twentytwenty' ),
		'add_new'               => __( 'Add New', 'twentytwenty' ),
		'new_item'              => __( 'New Item', 'twentytwenty' ),
		'edit_item'             => __( 'Edit Item', 'twentytwenty' ),
		'update_item'           => __( 'Update Item', 'twentytwenty' ),
		'view_item'             => __( 'View Item', 'twentytwenty' ),
		'view_items'            => __( 'View Items', 'twentytwenty' ),
		'search_items'          => __( 'Search Item', 'twentytwenty' ),
		'not_found'             => __( 'Not found', 'twentytwenty' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'twentytwenty' ),
		'featured_image'        => __( 'Featured Image', 'twentytwenty' ),
		'set_featured_image'    => __( 'Set featured image', 'twentytwenty' ),
		'remove_featured_image' => __( 'Remove featured image', 'twentytwenty' ),
		'use_featured_image'    => __( 'Use as featured image', 'twentytwenty' ),
		'insert_into_item'      => __( 'Insert into item', 'twentytwenty' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'twentytwenty' ),
		'items_list'            => __( 'Items list', 'twentytwenty' ),
		'items_list_navigation' => __( 'Items list navigation', 'twentytwenty' ),
		'filter_items_list'     => __( 'Filter items list', 'twentytwenty' ),
	);
	$args = array(
		'label'                 => __( 'Casa apuesta', 'twentytwenty' ),
		'description'           => __( 'Casa apuesta Description', 'twentytwenty' ),
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
		'name' => __('Apuestanweb Sidebar','twentytwenty'),
		'before_widget' => '<div class="aside_widgets" >',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));

	register_sidebar(array(
		'id' => 'top_widget',
		'name' => __('Apuestanweb top banner','twentytwenty'),
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
				if($taxonomy_name == $term_1->taxonomy && $term_1->slug == $term){
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
function aw_terms_by_taxs_2($array_taxonomies){
	$terms = array();
	
		foreach (get_terms(array('hide_empty' => true)) as $term) {
			foreach ($array_taxonomies as $key => $taxonomy) {
				if($taxonomy == $term->taxonomy){
					$terms[] = $term ;
				}
			}
		}
	
	return $terms;
}

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