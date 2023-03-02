<?php
if(!session_id()):
session_start();
endif;

add_action('init', function(){
    
    if(!str_contains($_SERVER["PHP_SELF"], "wp-admin")) {
        setUserRating();
    }
    
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

    $page_forecaster = empty(get_option( 'ihc_general_register_view_user')) ? "#":get_option( 'ihc_general_register_view_user');
    if($page_forecaster):
        define('PERMALINK_PROFILE',get_the_permalink($page_forecaster));
    endif;
    

    //odds-converter
    if(!isset($_SESSION['odds_format'])):
        $_SESSION['odds_format'] = 2;
    endif;
    if(isset($_GET['odds_format'])):
        update_option( "odds_type", $_GET['odds_format']);
    endif;

    ///////////geolocation

    if(!isset($_SESSION["geolocation"])){
        
        $data = geolocation_api($_SERVER["REMOTE_ADDR"]);
        $_SESSION["geolocation"] = json_encode($data);
    }
    
});