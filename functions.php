<?php

/*--------------------------------------------------------------*/
/*                            CORE                              */
/*--------------------------------------------------------------*/
include "includes/core/session.php";
include "includes/core/post-type.php";
include "includes/core/taxonomy.php";
include "includes/core/meta-fields.php";
include "includes/libs/aqua-resize/aqua-resize.php";
include "includes/libs/odds-converter/converter.class.php"; 
include "includes/templates-emails/settings.php"; 
include "includes/templates-emails/template-email-1.php"; 
include "includes/templates-emails/template-email-2.php";
include "includes/core/notification-module/notification-core.php"; 

/*--------------------------------------------------------------*/
/*                         SHORTCODES                           */
/*--------------------------------------------------------------*/

include "includes/shortcodes/shortcode-social-contact.php";
//include "includes/shortcodes/shortcode-prices.php";
include "includes/shortcodes/shortcode-parley.php";
include "includes/shortcodes/shortcode-parley-vip.php";
include "includes/shortcodes/shortcode-profile-forecaster.php";
include "includes/shortcodes/shortcode-blog.php";
include "includes/shortcodes/shortcode-forecasts.php";
include "includes/shortcodes/shortcode-related-forecasts.php";
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
//include "includes/shortcodes/shortcode-checkout-form.php";
include "includes/shortcodes/shortcode-login-form.php";
include "includes/shortcodes/predictions-list.php";
include "includes/shortcodes/shortcode-content-hub.php";
include "includes/shortcodes/apis/futbol/shorcode-h2h-futbol.php";
include "includes/shortcodes/apis/futbol/shortcode-form-team.php";
include "includes/shortcodes/apis/futbol/shortcode-team1-form.php";
include "includes/shortcodes/apis/futbol/shortcode-team2-form.php";
include "includes/shortcodes/apis/basket/basket-h2h.php";






/*--------------------------------------------------------------*/
/*                         WIDGETS                              */
/*--------------------------------------------------------------*/

include "includes/widgets_area.php";
include "includes/widgets/widget-top-bk.php";
include "includes/widgets/widget-forecasts.php";
include "includes/widgets/widget-bk-bonus.php";
include "includes/widgets/widget-authors.php";

/*--------------------------------------------------------------*/
/*                         GEOLOCATION API                      */
/*--------------------------------------------------------------*/

include "includes/handlers/geolocation.php";

/*--------------------------------------------------------------*/
/*                         HANDLERS                             */
/*--------------------------------------------------------------*/

include "includes/ajax_handlers/news_loadmore.php";
include "includes/handlers/get_forecast_teams.php";
include "includes/handlers/get_bookmaker_by_post.php";
include "includes/handlers/author_posts_table.php";
include "includes/handlers/blog_posts_table.php";
//include "includes/handlers/aw-memberships-controllers.php";
include "includes/handlers/get_countries.php";
//include "includes/handlers/paypal-tools.php";

/*--------------------------------------------------------------*/
/*                        TOOLS PANEL ADMIN                     */
/*--------------------------------------------------------------*/

include "includes/core/bookmaker-location-panel/bk-location-panel.php";
//include "includes/core/payment-dashboard/payment-dashboard.php";


/*--------------------------------------------------------------*/
/*                         REST API                             */
/*--------------------------------------------------------------*/

include "rest-api/register-routes.php";
//include "rest-api/telegram-post-publisher.php";

//include "rest-api/translator-ia.php";
//include "rest-api/payment-accounts-controller.php";
//include "rest-api/payment-methods-controller.php";
//include "rest-api/payment-history-controller.php";
include "rest-api/user-register-controller.php";
//include "rest-api/paypal-api-controller.php";
include "rest-api/forecasts-controller.php";
include "rest-api/parley-controller.php";
include "rest-api/notification-controller.php";
include "rest-api/imagen-detacada-controller.php";
include "rest-api/forecaster-controller.php";

register_nav_menus(array(
    'top' => __('Top menu', 'jbetting'),
    'movil'=> __('Movil menu', 'jbetting'),
    'footer'=> __('Footer', 'jbetting'),
));


add_action('after_setup_theme', 'my_theme_setup');


function my_theme_setup()
{
    add_theme_support('post-thumbnails');
    
}

function get_key()
{
     return true;
}
//insertar img destacada en feeds
function insert_featured_image_in_feed( $content ) {
    global $post;
    if ( has_post_thumbnail( $post->ID ) ) {
       $content = '' . get_the_post_thumbnail( $post->ID, 'medium' ) . '' . $content;
    }
    return $content;
 }
 add_filter( 'the_excerpt_rss', 'insert_featured_image_in_feed', 1000 );
 add_filter( 'the_content_feed', 'insert_featured_image_in_feed', 1000 );
 
function load_template_part($template_name, $part_name = null, $args=false)
{
    ob_start();
    get_template_part($template_name, $part_name, $args);
    $var = ob_get_contents();
    ob_end_clean();

    return $var;
}
add_filter('wp_get_attachment_image_attributes', 'add_lazy_loading_to_images'); 

function add_lazy_loading_to_images($attr) { 
    $attr['loading'] = 'lazy'; return $attr; 
}

function disable_all_styles() { 
    // Desregistrar estilos de WordPress core y plugins 
    wp_dequeue_style('wp-block-library'); 
    // Gutenberg 
    wp_dequeue_style('wp-block-library-theme');
    // Gutenberg Theme 
    wp_dequeue_style('wc-blocks-style'); 
    wp_dequeue_style('woocommerce-inline'); 
    // WooCommerce
    
    wp_dequeue_style('contact-form-7');
    // Contact Form 7
    // Desregistrar estilos específicos de plugins si conoces sus handles // 
    //wp_dequeue_style('plugin-style-handle'); 
    // Reemplazar con el handle específico del plugin 
} 
add_action('wp_enqueue_scripts', 'disable_all_styles', 100);

add_action('wp_enqueue_scripts', 'jbetting_src');
function jbetting_src()
{
    
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/bootstrap-4.2.1-dist/css/bootstrap.min.css', array(), '4.2.1');
    //wp_enqueue_style('helper', get_template_directory_uri() . '/assets/css/helper.css', array(), null);
    wp_enqueue_style('main-css', get_stylesheet_uri());
    //wp_enqueue_style('responsive', get_template_directory_uri() . '/assets/css/responsive.css', array(), null);
    //wp_enqueue_style('load-c', get_template_directory_uri() . '/assets/css/load-css.css', array(), null);


    wp_deregister_script('jquery');
    //wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/jquery-3.6.0.min.js', array(), '3.6.0', false);

    //wp_enqueue_script('popper-js', get_template_directory_uri() . '/assets/js/popper.min.js', array('jquery'), null, true);
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/bootstrap-4.2.1-dist/js/bootstrap.min.js', array('jquery'), '4.2.1', true);
    
    
    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);
    //wp_enqueue_script('load', get_template_directory_uri() . '/assets/js/load.min.js', array(), '1.2.4', true);
    

    // wp_register_script('stick-js', get_template_directory_uri() . '/assets/js/jquery.sticky-kit.min.js', array('jquery'), null, true);
    // wp_enqueue_script( 'stick-js' );

    //wp_enqueue_script( 'noti-js' );
    //wp_localize_script('noti-js','dcms_vars',['ajaxurl'=>admin_url('admin-ajax.php')]);
   // wp_enqueue_script( 'ihc-front_end_js', IHC_URL . 'assets/js/functions.min.js', ['jquery'], 10.6, true );

   //wp_enqueue_script('custom-search', get_template_directory_uri() . '/assets/js/custom-search.js', array('jquery'), null, true);

   // Variables que se pasan a script.js con wp_localize_script
   //wp_localize_script('custom-search', 'frontendajax', array('url' => admin_url('admin-ajax.php')));

}


function enqueuing_admin_scripts(){
    wp_register_script('admin-js', get_template_directory_uri() . '/assets/js/admin.js', array(), '1.0.0', true);
    wp_register_style('admin-css', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.0.0', false);
    wp_enqueue_style('bootstrap-dash.min', get_template_directory_uri() . '/assets/bootstrap-4.2.1-dist/css/bootstrap.min.css', array(), null);
    wp_enqueue_script('bootstrap.js', get_template_directory_uri() . '/assets/bootstrap-4.2.1-dist/js/bootstrap.min.js', array(), '1.0.0', true);
    
    wp_enqueue_script( 'admin_medios', get_template_directory_uri() . '/assets/js/medios.js', array('jquery','media-upload','thickbox'), null, false );
    wp_enqueue_script( 'dom-image-js', get_template_directory_uri() . '/assets/js/dom-to-image.min.js', array(), null, false );
    
}
 
add_action( 'admin_enqueue_scripts', 'enqueuing_admin_scripts' );
   
      
function draw_rating($rating)
{
    $ret = '';
    $count = 1;
    while ($count <= 5) {
        
        $ret .= '<i class="fas fa-star" '.($count <= $rating ? 'style="color:#F4D31F;"' : "").' ></i>';
       
        $count++;
    }
    

    return $ret;
}



function tg_remove_empty_paragraph_tags_from_shortcodes_wordpress( $content ) {
    $toFix = array( 
        '<p>['    => '[', 
        ']</p>'   => ']', 
        ']<br />' => ']'
    ); 
    return strtr( $content, $toFix );
}
add_filter( 'the_content', 'tg_remove_empty_paragraph_tags_from_shortcodes_wordpress' );


// active code menu
    function active_menu( $classes, $item ) {
        $classes['class'] = "nav-link"; // Add class to every "<a>" tags
        if ( in_array('current-page-ancestor', $item->classes) || in_array('current-menu-item', $item->classes) ) {
            $classes['class'] = 'nav-link active'; // Add class to current menu item's "<a>" tag
        }
        return $classes;
    }
    add_filter( 'nav_menu_link_attributes', 'active_menu', 10, 2 ); 
  
    add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
        $filetype = wp_check_filetype( $filename, $mimes );
        return [
            'ext'             => $filetype['ext'],
            'type'            => $filetype['type'],
            'proper_filename' => $data['proper_filename']
        ];
      
      }, 10, 4 );
      
      function cc_mime_types( $mimes ){
        $mimes['svg'] = 'image/svg+xml';
        $mimes['webp'] = 'image/webp';
        $mimes['avif'] = 'image/avif';
        $mimes['avis'] = 'image/avif-sequence';

        return $mimes;
      }
      add_filter( 'upload_mimes', 'cc_mime_types' );
      
    



/////Obtiene los enlaces de RRSS///////
function get_rrss() {
    define('tl',carbon_get_theme_option('tl'));
    define('fb',carbon_get_theme_option('fb'));
    define('tw',carbon_get_theme_option('tw'));
    define('ig',carbon_get_theme_option('ig'));
    
}

add_action( 'wp_loaded', 'get_rrss' );



/////configurando smtp///////


///// Detectando registro de usuarios
add_action( 'user_register', 'aw_actions_after_register_user', 10, 1 ); 

function aw_actions_after_register_user( $user_id ) {
    
    function tipo_de_contenido_html() {
        return 'text/html';
    }
    $memberInfo = get_userdata($user_id);
    $blogname = get_bloginfo( "name" );
    $admin_email = get_option( "admin_email" );

    $headers[]= "From: Apuestan <$admin_email>";

    $body= aw_email_templates_2(["blogname"=>$blogname,"username"=>$memberInfo->user_login]);

    add_filter( "wp_mail_content_type", "tipo_de_contenido_html" );
    wp_mail($memberInfo->user_email,"Apuestan registration user: $memberInfo->user_login" ,$body,$headers);
}


function user_rss( $contact_methods ) {
    // Añade el campo de Twitter
    $contact_methods['twitter'] = 'Twitter Username';
    // Añade el campo de Facebook
    $contact_methods['facebook'] = 'Facebook URL';
    // Añade el campo de Instagram
    $contact_methods['instagram'] = 'Instagram URL';
    // Devuelve los campos de contacto modificados
    return $contact_methods;
  }
  add_filter( 'user_contactmethods', 'user_rss' );  

  function crb_modify_association_field_query_args( $args, $name ) {
    $args['orderby'] = 'date';
    $args['order'] = 'DESC';
    return $args;
}
add_filter( 'carbon_fields_association_field_options_forecasts_post_post', 'crb_modify_association_field_query_args', 10, 2 );


  function crb_modify_association_field_title( $title, $name, $id, $type, $subtype ) {
    if ( 'post' === $type ) {
        // obtener las taxonomías del post
        $leagues = wp_get_post_terms( $id, 'league' );
        if ( ! empty( $leagues ) ) {
            $league_names = array();
            foreach ( $leagues as $league ) {
                $league_names[] = $league->name;
            }
            $title .= ' (' . implode( ', ', $league_names ) . ')';
        }
    }
    return $title;
}
add_filter( 'carbon_fields_association_field_title', 'crb_modify_association_field_title', 10, 5 );

function initCors( $value ) {
    $origin = get_http_origin();
    $allowed_origins = ["apuestan.com","apuestan.net"];

  if ( $origin && in_array( $origin, $allowed_origins ) ) {
    header( 'Access-Control-Allow-Origin: ' . esc_url_raw( $origin ) );
    header( 'Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE' );
    header( 'Access-Control-Allow-Credentials: true' );
  }

  return $value;
  }

  add_action( 'rest_api_init', function() {

	remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );

	add_filter( 'rest_pre_serve_request', "initCors");
}, 15 );


//////////////////////// Estructura de enlaces

function custom_permalink_structure($permalink, $post_id, $leavename) {
    $post = get_post($post_id);
    $post_date = strtotime($post->post_date);
    $change_date = strtotime('2023-04-24'); // Reemplaza esta fecha con la fecha en la que deseas que comience la nueva estructura de URL.

    if ($post_date < $change_date) {
        // Estructura de enlace permanente antigua.
        $permalink = home_url(date('/Y/m/d/', $post_date) . $post->post_name . '/');
    }
    return $permalink;
}
add_filter('post_link', 'custom_permalink_structure', 10, 3);

function custom_rewrite_rules() {
    add_rewrite_tag('%custom_post_date%', '([0-9]{4}/[0-9]{2}/[0-9]{2})');
    add_rewrite_rule('^([0-9]{4}/[0-9]{2}/[0-9]{2})/([^/]+)/?$', 'index.php?custom_post_date=$matches[1]&name=$matches[2]', 'top');
}
add_action('init', 'custom_rewrite_rules');

/* function custom_query_vars($query_vars) {
    $query_vars[] = 'custom_post_date';
    return $query_vars;
}
add_filter('query_vars', 'custom_query_vars'); */

//* Integra migas de pan a WordPress sin plugin
function migas_de_pan() {
    $html = '<div class="single_event_breadcrumb text-capitalize">                              
    <ul>';
  if (!is_front_page()) {
     $html .= '<li><a href="'.get_home_url().'">Inicio</a></li>';
     if (is_single() || is_page()) {
       
        if(is_page()) {
            $terms = get_the_terms( get_the_ID(),'league' );
            
            foreach($terms as $term){
                $taxonomy_page = carbon_get_term_meta($term->term_id,'taxonomy_page');
                $term->redirect = isset($taxonomy_page[0]) ? $taxonomy_page[0] : null;
                $term->permalink = isset($term->redirect) ? get_permalink($term->redirect["id"]) : get_term_link($term, 'league');
                $html .= '<li><a href="'.$term->permalink.'" >'.$term->name.'</a></li>' ;
            }
        }if (is_single()) {
            $terms = get_the_terms( get_the_ID(),'league' );
            
            foreach($terms as $term){
                $taxonomy_page = carbon_get_term_meta($term->term_id,'taxonomy_page');
                $term->redirect = isset($taxonomy_page[0]) ? $taxonomy_page[0] : null;
                $term->permalink = isset($term->redirect) ? get_permalink($term->redirect["id"]) : get_term_link($term, 'league');
                $html .= '<li><a href="'.$term->permalink.'" >'.$term->name.'</a></li>' ;
            }
        }
     }
  }
  $html .= '</ul>
  </div>';
  return $html;
}

/* 
function custom_yoast_breadcrumb_links( $links ) {
    if ( is_single() ) {
        global $post;
        $league_term = wp_get_post_terms( $post->ID, 'league' );

        if ( ! is_wp_error( $league_term ) && ! empty( $league_term ) ) {
            $term = $league_term[0];
            $taxonomy_page = carbon_get_term_meta( $term->term_id, 'taxonomy_page' );
            $redirect = isset( $taxonomy_page[0] ) ? $taxonomy_page[0] : null;
            $term_permalink = isset( $redirect ) ? get_permalink( $redirect["id"] ) : get_term_link( $term, 'league' );

            $new_link = array(
                'url' => $term_permalink,
                'text' => $term->name,
                'allow_html' => true,
            );

            // Reemplaza el segundo elemento del breadcrumb con el enlace personalizado
            if ( isset( $links[1] ) ) {
                $links[1] = $new_link;
            }
        }
    }

    return $links;
}

 */
add_filter( 'wpseo_breadcrumb_links', 'custom_yoast_breadcrumb_links', 10, 1 );

/* function category_summary_shortcode($atts) {
    $atts = shortcode_atts(array(
        'category' => ''
    ), $atts);

    ob_start();

    // Obtener la categoría por su slug
    $category = get_term_by('slug', $atts['category'], 'categoria_content_hub');

    if ($category) {
        // Mostrar la descripción de la categoría
        if (!empty($category->description)) {
            echo '<div class="category-description">' . $category->description . '</div>';
        }

        // Mostrar los títulos de las publicaciones asociadas a la categoría
        $args = array(
            'post_type' => 'content_hub',
            'posts_per_page' => 6,
            'tax_query' => array(
                array(
                    'taxonomy' => 'categoria_content_hub',
                    'field' => 'slug',
                    'terms' => $category->slug,
                ),
            ),
        );

        $query = new WP_Query($args);
        if ($query->have_posts()) {
            echo '<ul class="category-posts">';
            while ($query->have_posts()) {
                $query->the_post();
                echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }
            echo '</ul>';
            wp_reset_postdata();
        } else {
            echo '<p>No se encontraron publicaciones asociadas a esta categoría.</p>';
        }
    } else {
        echo '<p>Categoría no encontrada.</p>';
    }

    return ob_get_clean();
}
 
add_shortcode('category_summary', 'category_summary_shortcode');
*/

/* 
// Función AJAX para buscar publicaciones del CPT "forecast"
function custom_search_function() {
    $search_query = sanitize_text_field($_POST['search_query']);

    $args = array(
        'post_type' => 'forecast',
        's' => $search_query,
        'post_status' => 'publish',
        'posts_per_page' => 5, // Limita a los últimos 5 resultados
        'orderby' => 'date', // Ordena por fecha
        'order' => 'DESC', // En orden descendente (más recientes primero)
        'sentence' => true, // Utilizar el operador lógico AND
        'search_columns' => array('post_title'), // Limitar la búsqueda a los títulos


    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start(); // Inicia el buffer de salida
        while ($query->have_posts()) : $query->the_post();
            // Obtén la URL amigable usando get_permalink()
            $permalink = get_permalink();
            // Puedes personalizar la salida de cada resultado aquí
            echo '<p><a href="' . esc_url($permalink) . '">' . get_the_title() . '</a></p>';
        endwhile;
        $output = ob_get_clean(); // Obtiene el contenido del buffer y lo limpia

        echo json_encode(array('success' => true, 'results' => $output));
    } else {
        echo json_encode(array('success' => false, 'message' => 'No se encontraron resultados'));
    }

    die();
}

add_action('wp_ajax_custom_search', 'custom_search_function');
add_action('wp_ajax_nopriv_custom_search', 'custom_search_function');

 */

/*  
function enlaces_internos_forecast($atts) {
    // Obtener el atributo de categoría del shortcode (si está presente)
    $atts = shortcode_atts(array(
        'league' => '', // Valor predeterminado vacío si no se especifica la categoría
    ), $atts);

    // Verificar si se ha especificado la categoría 'league'
    if (!empty($atts['league'])) {
        // Configurar la consulta para obtener publicaciones de la taxonomía 'league'
        $args = array(
            'post_type' => 'forecast', // El nombre de tu Custom Post Type
            'tax_query' => array(
                array(
                    'taxonomy' => 'league', // El nombre de la taxonomía (categoría) del CPT "forecast"
                    'field'    => 'slug',
                    'terms'    => $atts['league'],
                ),
            ),
            'posts_per_page' => -1, // Obtener todas las publicaciones
        );

        // Realizar la consulta
        $query = new WP_Query($args);

        // Comprobar si hay publicaciones
        if ($query->have_posts()) {
            $enlaces_internos = '<ul>';

            // Loop a través de las publicaciones y construir enlaces internos
            while ($query->have_posts()) {
                $query->the_post();
                $enlaces_internos .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }

            $enlaces_internos .= '</ul>';

            // Restaurar la configuración original de la consulta de WordPress
            wp_reset_postdata();

            return $enlaces_internos;
        } else {
            return 'No se encontraron pronósticos en la categoría "' . $atts['league'] . '".';
        }
    } else {
        return 'Por favor, especifica la categoría "league" en el shortcode.';
    }
}

 
// Registrar el shortcode
add_shortcode('enlaces_internos_forecast', 'enlaces_internos_forecast');

*/



