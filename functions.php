<?php
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
require_once('inc/metabox_casas_apuestas.php' );
//include shortcodes
require_once('admin_theme/shortcodes.php');
require_once('admin_theme/admin_theme.php');

function apuestanweb_load_css_files() {
	wp_enqueue_style( 'apuestanweb-style', get_template_directory_uri() . '/assets/css/styles.css' );
}
add_action( 'wp_enqueue_scripts', 'apuestanweb_load_css_files' );

function apuestanweb_load_scripts() {
		wp_register_script( 'chart', get_template_directory_uri(). '/assets/js/chart.js');
		wp_enqueue_script( 'chart' );
	
		wp_register_script( 'theme_scripts', get_template_directory_uri(). '/assets/js/scripts.js');
		wp_enqueue_script( 'theme_scripts' );

		wp_register_script( 'slide_scripts', get_template_directory_uri(). '/assets/js/slide_script.js');
		wp_enqueue_script( 'slide_scripts' );
			
}
add_action( 'wp_enqueue_scripts', 'apuestanweb_load_scripts' );

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
  add_filter( 'login_headertext', 'my_login_logo_url_title' );


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
		'izquierda'  => __( 'Desktop Left', 'apuestanweb-lang' ),
		'derecha'  => __( 'Desktop Right', 'apuestanweb-lang' ),
		'mobile'  => __( 'Mobile', 'apuestanweb-lang' ),
		'sub_header'  => __( 'Menu subheader', 'apuestanweb-lang' ),
		'user_menu'  => __( 'Menu user', 'apuestanweb-lang' )
	));
     
	// Ready for i18n
	load_theme_textdomain( 'apuestanweb-lang' );

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
		'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'excerpt','author','post_meta' ),
		'taxonomies'            => array(),
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
        $post_types = array_merge( array( 'post', 'pronosticos') );
    }
    return $query;
}
add_filter( 'pre_get_posts', 'my_get_posts' ); 

// Creando taxonomia, para pronosticos.

function taxonomia_tipo_deporte() {
	$labels = array(
		'name'                => _x( 'deporte', 'taxonomy general name', 'apuestanweb-lang' ),
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
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'show_in_nav_menus' => true,
		'rewrite' => array('slug' => 'deporte', 'with_front' => true)
	);
	// Nombre de taxonomia, post type al que se aplica y argumentos.
	register_taxonomy( 'deporte', array( 'pronosticos' ), $args );
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

//Activando widgeths
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

remove_role('vip');

//Extrae estadisticas del autor
function statics_user($user_id){
	$total_p = 0; 
	$total_s=0; 
	$total_f=0;
	$total_c = 0;
	$total_av = 0;

	
	$author_posts = new wp_Query(array(
		'author' => $user_id,
		'tax_query'=>array(
			array(
				'taxonomy' => 'deporte',
				'terms' => 'all'
			)
		)
	));

	$total_p = $author_posts->post_count; 

	while($author_posts->have_posts()) : $author_posts->the_post();
		$state = get_post_meta(get_the_ID(),'estado_pronostico');
		if($state[0] == 'acertado'){
			$total_s++;
		}
		if($state[0] == 'no_acertado'){
			$total_f++;
		}
	endwhile;
	//Calculamos los pronosticos completados sumando los success y failed
	$total_c = $total_s+$total_f;
	// si el total completados es mayor a cero calculamos el average para que no de errores
	if($total_c > 0){
		$total_av = ceil($total_s / $total_c * 100);
	}

	update_user_meta( $user_id, 'average_aciertos', $total_av );
	update_user_meta( $user_id, 'pronosticos_completados', $total_c );
	update_user_meta( $user_id, 'pronosticos_acertados', $total_s );
	update_user_meta( $user_id, 'pronosticos_no_acertados', $total_f );
	update_user_meta( $user_id, 'pronosticos_realozados', $total_p );

}

?>