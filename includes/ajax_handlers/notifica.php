<?php

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

// Función para guardar los resultados en un transient
function set_vip_forecasts_transient() {
    $vip_forecasts = get_vip_forecasts();
    $vip_forecasts_with_terms = array();
    foreach ($vip_forecasts as $forecast) {
        $forecast->terms = wp_get_post_terms( $forecast->ID, 'league' );
        $vip_forecasts_with_terms[] = $forecast;
    }
    set_transient( 'vip_forecasts', $vip_forecasts_with_terms, DAY_IN_SECONDS );
}
add_action( 'save_post', 'set_vip_forecasts_transient' );


// verificando el tipo de publicación y si tiene la categoría vip
function custom_publish_vip_forecast( $post_id ) {
    $post_type = get_post_type( $post_id );
    if ( $post_type == 'forecast' ) {
        $terms = wp_get_post_terms( $post_id, 'league' );
        $vip_term = get_term_by( 'slug', 'vip', 'league' );
        if ( in_array( $vip_term, $terms ) ) {
            set_vip_forecasts_transient();
        }
    }
}
add_action( 'publish_post', 'custom_publish_vip_forecast' );

// función para obtener los datos del transient
function get_vip_forecasts_transient() {
    $vip_forecasts = get_transient( 'vip_forecasts' );
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
    wp_send_json( array( 'isVip' => $is_vip, 'titles' => $vip_forecasts_titles ) );
}

add_action( 'wp_ajax_get_vip_forecasts_transient_callback', 'get_vip_forecasts_transient_callback' );
add_action( 'wp_ajax_nopriv_get_vip_forecasts_transient_callback', 'get_vip_forecasts_transient_callback' );


function mark_notifications_as_read_callback() {
    $transient_name = 'vip_forecasts_transient';
    $notifications = get_transient( $transient_name );
    if ( false === $notifications ) {
        return;
    }
    // aqui marcas como leido
    set_transient( $transient_name, $notifications, DAY_IN_SECONDS );
    wp_send_json_success();
}
add_action( 'wp_ajax_mark_notifications_as_read_callback', 'mark_notifications_as_read_callback' );
