<?php
session_start();

// Función para obtener publicaciones del CPT "forecast" con la categoría VIP

function get_vip_forecasts() {
    $args = array(
        'post_type' => 'forecast',
        'tax_query' => array(
            array(
                'taxonomy' => 'league',
                'field' => 'slug',
                'terms' => 'vip',
            ),
        ),
    );
    $query = new WP_Query( $args );
    return $query->posts;

    foreach ($posts as $post) {
        $post->league = wp_get_post_terms($post->ID, 'league');
    }
    return $posts;
}

// Función para guardar los resultados en una sesion
function set_vip_forecasts_transient() {
    $vip_forecasts = get_vip_forecasts();
    $vip_forecasts_with_terms = array();
    foreach ($vip_forecasts as $forecast) {
        $forecast->terms = wp_get_post_terms( $forecast->ID, 'league' );
        $forecast->leido = false;
        $vip_forecasts_with_terms[] = $forecast;
    }
/*set_transient( 'vip_forecasts', $vip_forecasts_with_terms, DAY_IN_SECONDS );*/
    $_SESSION['vip_forecasts'] = $vip_forecasts_with_terms;
    

}
add_action( 'save_post', 'set_vip_forecasts_transient' );



// función para obtener los datos
function get_vip_forecasts_transient() {
    // $vip_forecasts = get_transient( 'vip_forecasts' );
    $vip_forecasts = $_SESSION['vip_forecasts'];

    return $vip_forecasts;
}

function register_vip_forecasts_ajax_action() {
    add_action( 'wp_ajax_get_vip_forecasts_transient', 'get_vip_forecasts_transient_callback' );
}
add_action( 'init', 'register_vip_forecasts_ajax_action' );

// Callback de la acción AJAX

function get_vip_forecasts_transient_callback() {
    $vip_forecasts = get_vip_forecasts();
    $is_vip = false;
    $vip_forecasts_titles = array();
    foreach($vip_forecasts as $forecast){
        $terms = wp_get_post_terms($forecast->ID, 'league');
        foreach($terms as $term){
            if($term->slug == "vip"){
                $is_vip = true;
                array_push($vip_forecasts_titles, $forecast->post_title);
                break;
            }
        }
    }

if (!isset($_SESSION['vip_forecasts']) || !$_SESSION['vip_forecasts']) {
    wp_send_json( array( 'isVip' => false, 'titles' => array() ) );
} else {
    wp_send_json( array( 'isVip' => $is_vip, 'titles' => $vip_forecasts_titles ) );
}
}

add_action( 'wp_ajax_get_vip_forecasts_transient_callback', 'get_vip_forecasts_transient_callback' );
add_action( 'wp_ajax_nopriv_get_vip_forecasts_transient_callback', 'get_vip_forecasts_transient_callback' );

// funcion para el contador
function mark_notifications_as_read_callback() {
    $notifications = $_SESSION['vip_forecasts'];
    if ( false === $notifications ) {
        return;
    }
    $_SESSION['vip_forecasts'] = $notifications;
}
add_action( 'wp_ajax_mark_notifications_as_read_callback', 'mark_notifications_as_read_callback' );

// funcion para limpiar las notificaciones
function clear_notifications() {
    // código para limpiar las notificaciones
    foreach ($_SESSION['vip_forecasts'] as $forecast) {
      array_push($_SESSION['read_vip_forecasts'], $forecast->ID);
    }
    $_SESSION['vip_forecasts'] = array();
  }
  
add_action( 'wp_ajax_clear_notifications', 'clear_notifications' );
