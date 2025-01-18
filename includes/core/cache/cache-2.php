<?php
/*//////////////////cacheado/////////////*/
add_action('template_redirect', function() {
    global $wp;

    // URLs que no deben cachearse
    $excluded_urls = array(
        home_url('/wp-admin'),
        home_url('/mi-pagina-excluida'),
    );

    // Obtén el ID del post si es una URL de post
    $post_id = url_to_postid(home_url($wp->request));

    // Verifica si la URL está en la lista de exclusión o si no es una URL válida de post
    if (in_array(home_url($wp->request), $excluded_urls) || !$post_id) {
        // Permite que WordPress procese la solicitud normalmente
        return;
    }

    // Construye la URL del post usando get_permalink()
    $requested_url = get_permalink($post_id);

    // Normaliza la URL para usarla como clave en la Transients API
    $cache_key = 'page_cache_' . md5($requested_url);

    // Verifica si la respuesta está en la cache
    $cached_content = get_transient($cache_key);

    if (false !== $cached_content) {
        // Si está en cache, muestra el contenido y detén la ejecución
        echo "vengo de caché";
        echo $cached_content;
        exit;
    }

    // Si no está en cache, permite que WordPress procese la solicitud normalmente
    ob_start();
}, 1);

// Hook para guardar la salida en cache después de que WordPress haya procesado la solicitud
add_action('wp_footer', function() {
    global $wp;

    // URLs que no deben cachearse
    $excluded_urls = array(
        home_url('/wp-admin'),
        home_url('/mi-pagina-excluida'),
    );

    // Obtén el ID del post si es una URL de post
    $post_id = url_to_postid(home_url($wp->request));

    // Verifica si la URL está en la lista de exclusión o si no es una URL válida de post
    if (in_array(home_url($wp->request), $excluded_urls) || !$post_id) {
        // Permite que WordPress procese la solicitud normalmente
        return;
    }

    // Construye la URL del post usando get_permalink()
    $requested_url = get_permalink($post_id);

    // Solo cachea si no se está realizando una solicitud de administrador (admin)
    if (!is_admin()) {
        $cache_key = 'page_cache_' . md5($requested_url);

        // Obtén el contenido generado por WordPress
        $output = ob_get_clean();

        // Mensaje de depuración
        error_log('Output before caching: ' . $output);

        // Guarda el contenido en la cache
        set_transient($cache_key, $output, HOUR_IN_SECONDS);

        // Verificar si se guardó en la cache correctamente
        $cached_content = get_transient($cache_key);
        error_log('Cached content after saving: ' . $cached_content);

        // Muestra el contenido
        echo $output;
    }
}, 1);


////////////////////invalidar////////////////////

add_action('save_post', 'invalidate_cache_for_post');
add_action('delete_post', 'invalidate_cache_for_post');

function invalidate_cache_for_post($post_id) {
    // Mensaje de depuración
    error_log("Invalidate cache for post: $post_id");

    // Obtén el post
    $post = get_post($post_id);

    // Asegúrate de que el post no esté en la papelera
    if ($post && $post->post_status !== 'trash') {
        // Construye la URL del post usando get_permalink()
        $post_url = get_permalink($post);

        // Mensaje de depuración
        error_log("Post URL: $post_url");

        // Invalidar la cache para la URL del post
        invalidate_cache_for_url($post_url);
    }
}

function invalidate_cache_for_url($url) {
    $cache_key = 'page_cache_' . md5($url);

    // Mensaje de depuración
    error_log("Invalidating cache for URL: $url");

    // Obtener contenido de cache antes de invalidar
    $cached_content = get_transient($cache_key);
    if ($cached_content) {
        error_log("Cache content before invalidation: " . $cached_content);
    } else {
        error_log("No cache content found for URL: $url");
    }

    delete_transient($cache_key);

    // Verificar si la cache se eliminó correctamente
    if (false === get_transient($cache_key)) {
        error_log("Cache invalidated for URL: $url");
    } else {
        error_log("Failed to invalidate cache for URL: $url");
    }
}
