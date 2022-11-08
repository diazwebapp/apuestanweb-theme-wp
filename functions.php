<?php
/*--------------------------------------------------------------*/
/*                         SHORTCODES                           */
/*--------------------------------------------------------------*/
include "includes/shortcodes/shortcode-prices.php";
include "includes/shortcodes/shortcode-parley.php";
include "includes/shortcodes/shortcode-profile-forecaster.php";
include "includes/shortcodes/shortcode-blog.php";
include "includes/shortcodes/shortcode-forecasts.php";
include "includes/shortcodes/shortcode-forecasts-vip.php";
include "includes/shortcodes/shortcode-related-posts.php";
include "includes/shortcodes/shortcode-slide.php";
include "includes/shortcodes/shortcode-slide-bk.php";
include "includes/shortcodes/shortcode-bookmakers.php";
include "includes/shortcodes/shortcode-banner-pages.php";
include "includes/shortcodes/shortcode-banner-bookmaker.php";
include "includes/shortcodes/shortcode-leagues-menu.php";
include "includes/shortcodes/shortcode-predictions.php";
include "includes/shortcodes/shortcode-user-stats.php";
include "includes/shortcodes/shortcode-register-form.php";
include "includes/shortcodes/shortcode-checkout-form.php";
include "includes/shortcodes/shortcode-login-form.php";
/*--------------------------------------------------------------*/
/*                         WIDGETS                              */
/*--------------------------------------------------------------*/
include "includes/widgets_area.php";
include "includes/widgets/widget-top-bk.php";
include "includes/widgets/widget-forecasts.php";
//include "includes/widgets/widget-bonuses.php";
include "includes/widgets/widget-authors.php";

/*--------------------------------------------------------------*/
/*                            CORE                              */
/*--------------------------------------------------------------*/
include "includes/core/meta-fields.php";
include "includes/core/post-type.php";
include "includes/core/taxonomy.php";
include "includes/libs/aqua-resize/aqua-resize.php";
include "includes/libs/odds-converter/converter.class.php";

/*--------------------------------------------------------------*/
/*                         HANDLERS                             */
/*--------------------------------------------------------------*/
include "includes/ajax_handlers/mailchimp.php";
include "includes/ajax_handlers/forecast_loadmore.php";
include "includes/ajax_handlers/forecast_filter.php";
include "includes/ajax_handlers/news_loadmore.php";
include "includes/handlers/get_forecast_teams.php";
include "includes/handlers/get_bookmaker_by_post.php";
include "includes/handlers/author_posts_table.php";
include "includes/handlers/blog_posts_table.php";
include "includes/handlers/aw-memberships-controllers.php";
include "includes/handlers/get_countries.php";
include "includes/handlers/paypal-tools.php";

/*--------------------------------------------------------------*/
/*                        TOOLS PANEL ADMIN                     */
/*--------------------------------------------------------------*/
include "includes/core/bookmaker-location-panel/bk-location-panel.php";
include "includes/core/payment-dashboard/payment-dashboard.php";
/*--------------------------------------------------------------*/
/*                         GEOLOCATION API                      */
/*--------------------------------------------------------------*/
include "includes/handlers/geolocation.php";

/*--------------------------------------------------------------*/
/*                         REST API                             */
/*--------------------------------------------------------------*/
include "rest-api/register-routes.php";
include "rest-api/payment-accounts-controller.php";
include "rest-api/payment-methods-controller.php";
include "rest-api/payment-history-controller.php";
include "rest-api/user-register-controller.php";
include "rest-api/paypal-api-controller.php";
include "rest-api/forecasts-controller.php";
include "rest-api/parley-controller.php";

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

register_nav_menus(array(
    'top' => __('Top menu', 'jbetting'),
));


add_action('after_setup_theme', 'my_theme_setup');

function my_theme_setup()
{
    add_theme_support('post-thumbnails');
    load_theme_textdomain('jbetting', get_template_directory() . '/lang');
    global $post;
    if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'posts' ) ) {
        //wp_enqueue_style( 's-pages-css', get_template_directory_uri( ) .'/assets/css/s-pages.css', null, false, 'all' );
    }
    if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'pages' ) ) {
        //wp_enqueue_style( 's-pages-css', get_template_directory_uri( ) .'/assets/css/s-pages.css', null, false, 'all' );
    }
}

function get_key()
{
     return true;
}

function load_template_part($template_name, $part_name = null, $args=false)
{
    ob_start();
    get_template_part($template_name, $part_name, $args);
    $var = ob_get_contents();
    ob_end_clean();

    return $var;
}
add_action('wp_enqueue_scripts', 'jbetting_src');
function jbetting_src()
{
    wp_enqueue_style('bootstrap.min', get_template_directory_uri() . '/assets/bootstrap-4.6.1-dist/css/bootstrap.min.css', array(), null);
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets//fonts/font-awesome-5/css/fontawesome.min.css', array(), null);
    wp_enqueue_style('nice_select', get_template_directory_uri() . '/assets/css/nice-select2.css', array(), null);
    wp_enqueue_style('owl.carousel', get_template_directory_uri() . '/assets/css/owl.carousel.min.css', array(), null);
    wp_enqueue_style('helper', get_template_directory_uri() . '/assets/css/helper.css', array(), null);
    wp_enqueue_style('main-css', get_stylesheet_uri());
    wp_enqueue_style('responsive', get_template_directory_uri() . '/assets/css/responsive.css', array(), null);

    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/jquery-3.6.0.min.js', array(), null, false);
    
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/bootstrap-4.6.1-dist/js/bootstrap.min.js', array(), null, false);
    wp_enqueue_script('nice-select', get_template_directory_uri() . '/assets/js/nice-select2.js', array(), null, false);
    wp_enqueue_script('owl.carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array(), null, true);
    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);
    wp_enqueue_script('common-js', get_template_directory_uri() . '/assets/js/common.js', array(), '1.0.0', true);
}

function enqueuing_admin_scripts(){
    wp_register_script('admin-js', get_template_directory_uri() . '/assets/js/admin.js', array(), '1.0.0', true);
    wp_register_style('admin-css', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.0.0', false);
    wp_enqueue_style('bootstrap-dash.min', get_template_directory_uri() . '/assets/bootstrap-4.6.1-dist/css/bootstrap.min.css', array(), null);
    wp_enqueue_script('bootstrap.js', get_template_directory_uri() . '/assets/bootstrap-4.6.1-dist/js/bootstrap.min.js', array(), '1.0.0', true);
}
 
add_action( 'admin_enqueue_scripts', 'enqueuing_admin_scripts' );


    /* if ('disable_gutenberg') {
        add_filter('use_block_editor_for_post_type', '__return_false', 100);
        remove_action('wp_enqueue_scripts', 'wp_common_block_scripts_and_styles');
        add_action('admin_init', function () {
            remove_action('admin_notices', ['WP_Privacy_Policy_Content', 'notice']);
            add_action('edit_form_after_title', ['WP_Privacy_Policy_Content', 'notice']);
        });
    } */

function draw_rating($rating)
{
    $ret = '';
    $count = 1;
    while ($count <= 5) {
        if ($count <= $rating):
            $ret .= '<i class="fas fa-star"></i>';
        endif;
        $count++;
    }
    

    return $ret;
}

add_action('init', function(){
    if(!session_id()):
        session_start();
    endif;
    //Definimos configuraciones globales del tema
    
    //Zona horaria
    date_default_timezone_set('America/Caracas');
    //vip page
    $page_id_vip = isset(carbon_get_theme_option('page_vip')[0]) ? carbon_get_theme_option('page_vip')[0]['id']: "#";
    if($page_id_vip):
        define('PERMALINK_VIP',get_the_permalink($page_id_vip));
    endif;
    //buy page
    
    $page_id_buy = empty(get_option( 'ihc_subscription_plan_page')) ? "#":get_option( 'ihc_subscription_plan_page',0);
    if($page_id_buy):
        define('PERMALINK_MEMBERSHIPS',get_the_permalink($page_id_buy));
    endif;

    //profile page 
    //$page_forecaster = isset(carbon_get_theme_option('page_forecaster')[0]) ? carbon_get_theme_option('page_forecaster')[0]['id']: "#";
    $page_forecaster = empty(get_option( 'ihc_general_register_view_user')) ? "#":get_option( 'ihc_general_register_view_user');
    if($page_forecaster):
        define('PERMALINK_PROFILE',get_the_permalink($page_forecaster));
    endif;
    

    //odds-converter
    if(!isset($_SESSION['odds_format'])):
        $_SESSION['odds_format'] = 2;
    endif;
    if(isset($_GET['odds_format'])):
        $_SESSION['odds_format'] = $_GET['odds_format'];
    endif;

    geolocation_api();
});


// active code menu
    function active_menu( $classes, $item ) {
        $classes['class'] = "nav-link"; // Add class to every "<a>" tags
        if ( in_array('current-page-ancestor', $item->classes) || in_array('current-menu-item', $item->classes) ) {
            $classes['class'] = 'nav-link active'; // Add class to current menu item's "<a>" tag
        }
        return $classes;
    }
    add_filter( 'nav_menu_link_attributes', 'active_menu', 10, 2 ); 
  
  function aw_mime_types($mimes) {
	$mimes['webp'] = 'image/webp';
    $mime['avif'] = 'image/avif';
    $mime['avis'] = 'image/avif-sequence';
	return $mimes;
}
add_filter('upload_mimes', 'aw_mime_types');
function filter_webp_quality( $quality, $mime_type ){
    if ( 'image/webp' === $mime_type ) {
       return 50;
    }
    return $quality;
  }

add_filter( 'wp_editor_set_quality', 'filter_webp_quality', 10, 2 );
/////configurando smtp///////

function configuracion_smtp( PHPMailer $phpmailer ){
    $phpmailer->isSMTP(); 
    $phpmailer->Host = 'smtp-relay.sendinblue.com';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 587;
    $phpmailer->Username = 'erickoficial69@gmail.com';
    $phpmailer->Password = 'xsmtpsib-946bcc77fd61f27f43f8069b405d2ea9c363a097d28ed28b6b7d5f9dc05673d6-KkSM6N3mrZRnQVOs';
    $phpmailer->SMTPSecure = false;
    $phpmailer->From = 'From Email';
    $phpmailer->FromName='Nombre del remitente';
}

///// Detectando registro de usuarios
add_action( 'user_register', 'aw_actions_after_register_user', 10, 1 ); 

function aw_actions_after_register_user( $user_id ) {
    $headers[]= 'From: Apuestan <apuestan@gmail.com>';
    $headers[]= 'Cc: Persona1 <diazwebapp@gmail.com>';
    $headers[]= 'Cc: Persona2 <erickoficial69@gmail.com>';
    
    function tipo_de_contenido_html() {
        return 'text/html';
    }
    $memberInfo = get_userdata($user_id);
    add_filter( 'wp_mail_content_type', 'tipo_de_contenido_html' );
    wp_mail( 'erickoficial69@gmail.com',
    'Ejemplo de la función mail en WP '.$memberInfo->user_login.' ',
    '<h1>Correo de apuestan</h1>',
    $headers
    );
}