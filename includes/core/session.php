<?php 
if( !headers_sent() && '' == session_id() ) {
session_start();
}

add_action('wp_loaded', function(){

    
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

    $page_forecaster = isset(carbon_get_theme_option('profile_page')[0]) ? carbon_get_theme_option('profile_page')[0]['id']: "#";
    if($page_forecaster):
        define('PERMALINK_PROFILE',get_the_permalink($page_forecaster));
    endif;
    

    //odds-converter
    $odds_type = get_option("odds_type");
    if(!$odds_type):
        update_option("odds_type", 2);
    endif;
    if(isset($_GET['odds_format'])):
        update_option("odds_type", $_GET['odds_format']);
    endif;
    
    ///////////geolocation

    if(!isset($_SESSION["geolocation"])){
        
        $data = geolocation_api($_SERVER["REMOTE_ADDR"]);
        $_SESSION["geolocation"] = json_encode($data);
    }
    
});

function aw_timeAgo ($oldTime, $newTime) {
    $timeCalc = strtotime($newTime) - strtotime($oldTime);
    if ($timeCalc >= (60*60*24*30*12*2)){
        $timeCalc = "hace " . intval($timeCalc/60/60/24/30/12) . " años";
        }else if ($timeCalc >= (60*60*24*30*12)){
            $timeCalc = "hace " . intval($timeCalc/60/60/24/30/12) . " año";
        }else if ($timeCalc >= (60*60*24*30*2)){
            $timeCalc = "hace " . intval($timeCalc/60/60/24/30) . " meses";
        }else if ($timeCalc >= (60*60*24*30)){
            $timeCalc = "hace " . intval($timeCalc/60/60/24/30) . " mes";
        }else if ($timeCalc >= (60*60*24*2)){
            $timeCalc = "hace " . intval($timeCalc/60/60/24) . " dias";
        }else if ($timeCalc >= (60*60*24)){
            $timeCalc = " ayer";
        }else if ($timeCalc >= (60*60*2)){
            $timeCalc = "hace " . intval($timeCalc/60/60) . " horas";
        }else if ($timeCalc >= (60*60)){
            $timeCalc = "hace " . intval($timeCalc/60/60) . " hora";
        }else if ($timeCalc >= 60*2){
            $timeCalc = "hace " . intval($timeCalc/60) . " minutos";
        }else if ($timeCalc >= 60){
            $timeCalc = "hace " . intval($timeCalc/60) . " minuto";
        }else if ($timeCalc > 0 or $timeCalc < 0){
            $timeCalc = "hace " .$timeCalc. " segundos";
        }
    return $timeCalc;
}

function aw_get_page_by_title($title){
    $query = new WP_Query(
        array(
            'post_type'              => 'page',
            'title'                  => $title,
            'posts_per_page'         => 1,
            
        )
    );
     
    if ( ! empty( $query->post ) ) {
        return  $query->post;
    } else {
       return  null;
    }
}

//* Integra migas de pan a WordPress sin plugin
function migas_de_pan() {
    $html = '<div class="single_event_breadcrumb text-capitalize">                              
    <ul>';
  if (!is_front_page()) {
     $html .= '<li><a class="text-muted text-capitalize" href="'.get_home_url().'">Inicio</a></li>';
     if (is_single() || is_page()) {
            $terms = get_the_terms( get_the_ID(),'league' );
            
            foreach($terms as $term){
                $taxonomy_page = carbon_get_term_meta($term->term_id,'taxonomy_page');
                $term->redirect = isset($taxonomy_page[0]) ? $taxonomy_page[0] : null;
                $term->permalink = isset($term->redirect) ? get_permalink($term->redirect["id"]) : get_term_link($term, 'league');
                $html .= '<span class="icon-arrow icon-arrow-right bg-secondary mx-2"></span><li><a class="text-muted text-lowercase" href="'.$term->permalink.'" >'.$term->name.'</a></li>' ;
            }
     }
  }
  $html .= '</ul>
  </div>';
  return $html;
}
