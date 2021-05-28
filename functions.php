<?php
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
require_once('inc/cpt_tax.php' );
require_once('inc/metabox_casas_apuestas.php' );
//include shortcodes
require_once('inc/shortcodes.php');
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

add_filter( 'excerpt_length', 'my_theme_excerpt' );

function apuestanweb_setup() {

	register_nav_menus(array(
		'left'  => __( 'Desktop Left', 'apuestanweb-lang' ),
		'right'  => __( 'Desktop Right', 'apuestanweb-lang' ),
		'mobile'  => __( 'Mobile', 'apuestanweb-lang' ),
		'sports_bar'  => __( 'Menu sports', 'apuestanweb-lang' )
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
		'height' => 48,
		'width' => 48,
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
		'posts_per_page' => 1000,
		'post_type' => 'pronostico'
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
	update_user_meta( $user_id, 'pronosticos_realizados', $total_p );

}
 
?>