<?php
/*//////////////////cacheado/////////////*/
 
add_action('template_redirect', function() {
    global $wp;

    // URLs que no deben cachearse
    $excluded_urls = array(
        home_url('/wp-admin'),
        home_url('/login'),
        home_url('/mi-pagina-excluida'),
    );

    // Obtén la URL solicitada relativa al sitio con parámetros
    $requested_url = add_query_arg($_GET, home_url($wp->request));

    // Verifica si la URL está en la lista de exclusión
    if (in_array($requested_url, $excluded_urls)) {
        // Permite que WordPress procese la solicitud normalmente
        return;
    }

    // Normaliza la URL para usarla como clave en la Transients API
    $cache_key = 'page_cache_' . md5($requested_url);

    // Verifica si la respuesta está en la cache
    $cached_content = get_transient($cache_key);

    if (false !== $cached_content) {
        // Si está en cache, muestra el contenido y detén la ejecución
        echo "vengo de caché".$cached_content;
        exit;
    }

    // Si no está en cache, permite que WordPress procese la solicitud normalmente
    ob_start();
}, 1);

// Hook para guardar la salida en cache después de que WordPress haya procesado la solicitud
// Hook personalizado para ejecutarse después de wp_footer
add_action('wp_footer', 'aw_cache_hook', 999);

function aw_cache_hook() {
    do_action('after_wp_footer');
}

// Función que se ejecutará después de wp_footer
add_action('after_wp_footer', function() {
    global $wp;

    // URLs que no deben cachearse
    $excluded_urls = array(
        home_url('/wp-admin'),
        home_url('/login'),
        home_url('/mi-pagina-excluida'),
    );

    // Obtén la URL solicitada relativa al sitio con parámetros
    $requested_url = add_query_arg($_GET, home_url($wp->request));

    // Verifica si la URL está en la lista de exclusión
    if (in_array($requested_url, $excluded_urls)) {
        // Permite que WordPress procese la solicitud normalmente
        return;
    }

    // Solo cachea si no se está realizando una solicitud de administrador (admin)
    if (!is_admin()) {
        $cache_key = 'page_cache_' . md5($requested_url);
        // Obtén el contenido generado por WordPress
        $output = ob_get_clean(); 

        // Guarda el contenido en la cache
        $time = 7 * 24 * 60 * 60;
        set_transient($cache_key, $output, $time); // Asegúrate de que el tiempo de expiración es adecuado

        // No cerrar el buffer aquí para permitir la inclusión de scripts y otros elementos al pie de página
        echo $output;
    }
}, 10); // Asegúrate de que el contenido se guarda después de que todos los scripts se hayan cargado

/* Invalidar la Cache Automáticamente al Actualizar/Añadir un Post /// Hook para vaciar la cache al cerrar sesión */
add_action('wp_logout', 'vaciar_toda_la_cache');
add_action('save_post', 'vaciar_toda_la_cache');
add_action('delete_post', 'vaciar_toda_la_cache');


//////invalidar toda la cache
function vaciar_toda_la_cache() {
    global $wpdb;
    // Eliminar todas las transientes
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_%'");
}
add_action('wp_ajax_vaciar_cache', 'vaciar_toda_la_cache'); // Hook para AJAX en admin
add_action('wp_ajax_nopriv_vaciar_cache', 'vaciar_toda_la_cache'); // Hook para AJAX en frontend


/* 

function invalidate_cache_for_url($url) {
    $cache_key = 'page_cache_' . md5($url);
    delete_transient($cache_key);
}

function invalidate_cache_for_post($post_id) {
    
    // Mensaje de depuración
    error_log("Invalidate cache for post: $post_id");

    // Obtén el post
    $post = get_post($post_id);

    // Asegúrate de que el post no esté en la papelera
    if ($post && $post->post_status !== 'trash') {
        // Construye la URL del post
        $post_url = rtrim(add_query_arg(array(), get_permalink($post_id)), '/');
        invalidate_cache_for_url($post_url);
    }
} */