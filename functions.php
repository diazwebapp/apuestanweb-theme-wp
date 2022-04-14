<?php
/*--------------------------------------------------------------*/
/*                         SHORTCODES                           */
/*--------------------------------------------------------------*/
include "includes/shortcodes/shortcode-prices.php";
include "includes/shortcodes/shortcode-parley.php";
include "includes/shortcodes/shortcode-profile.php";
include "includes/shortcodes/shortcode-blog.php";
include "includes/shortcodes/shortcode-forecasts.php";
include "includes/shortcodes/shortcode-forecasts-vip.php";
include "includes/shortcodes/shortcode-related-posts.php";
include "includes/shortcodes/shortcode-slide.php";
include "includes/shortcodes/shortcode-slide-bk.php";
include "includes/shortcodes/shortcode-bookmaker.php";
include "includes/shortcodes/shortcode-banner-pages.php";
include "includes/shortcodes/shortcode-leagues-menu.php";
include "includes/shortcodes/shortcode-predictions.php";
include "includes/shortcodes/shortcode-user-stats.php";
/*--------------------------------------------------------------*/
/*                         WIDGETS                              */
/*--------------------------------------------------------------*/
include "includes/widgets_area.php";
include "includes/widgets/widget-top-bk.php";
include "includes/widgets/widget-top-forecasts.php";
include "includes/widgets/widget-bonuses.php";
include "includes/widgets/widget-subscribe.php";
include "includes/widgets/widget-leagues.php";
include "includes/widgets/widget-authors.php";

/*--------------------------------------------------------------*/
/*                            CORE                              */
/*--------------------------------------------------------------*/
include "includes/core/meta-fields.php";
include "includes/core/post-type.php";
include "includes/core/taxonomy.php";
include "includes/libs/aqua-resize/aqua-resize.php";

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
}

function get_key()
{
     return true;
}

function load_template_part($template_name, $part_name = null)
{
    ob_start();
    get_template_part($template_name, $part_name);
    $var = ob_get_contents();
    ob_end_clean();

    return $var;
}
add_action('wp_enqueue_scripts', 'jbetting_src');
function jbetting_src()
{
    wp_enqueue_style('bootstrap.min', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), null);
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/css/fontawesome.min.css', array(), null);
    wp_enqueue_style('nice', get_template_directory_uri() . '/assets/css/nice-select.css', array(), null);
    wp_enqueue_style('owl.carousel', get_template_directory_uri() . '/assets/css/owl.carousel.min.css', array(), null);
    wp_enqueue_style('helper', get_template_directory_uri() . '/assets/css/helper.css', array(), null);
    wp_enqueue_style('main-css', get_stylesheet_uri());
    wp_enqueue_style('responsive', get_template_directory_uri() . '/assets/css/responsive.css', array(), null);
    
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/jquery-3.4.1.min.js', array(), null, false);
    wp_enqueue_script('plugins', get_template_directory_uri() . '/assets/js/plugins.js', array(), null, false);
    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);
    wp_enqueue_script('common-js', get_template_directory_uri() . '/assets/js/common.js', array(), '1.0.0', true);
    wp_enqueue_script('owl_carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array(), '1.0.0', true);
}


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
    //Definimos configuraciones globales del tema
    
    //vip page
    $page_id_vip = isset(carbon_get_theme_option('page_vip')[0]) ? carbon_get_theme_option('page_vip')[0]['id']: "#";
    if($page_id_vip):
        define('PERMALINK_VIP',get_the_permalink($page_id_vip));
    endif;
    //buy page
    $page_id_buy = isset(carbon_get_theme_option('page_buy')[0]) ? carbon_get_theme_option('page_buy')[0]['id']: "#";
    if($page_id_buy):
        define('PERMALINK_BUY',get_the_permalink($page_id_buy));
    endif;

    //profile page
    $page_id_profile = isset(carbon_get_theme_option('page_profile')[0]) ? carbon_get_theme_option('page_profile')[0]['id']: "#";
    if($page_id_profile):
        define('PERMALINK_PROFILE',get_the_permalink($page_id_profile));
    endif;
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