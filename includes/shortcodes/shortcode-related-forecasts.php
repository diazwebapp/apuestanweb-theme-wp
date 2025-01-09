<?php

function shortcode_related_forecast($atts)
{
    // Usar shortcode_atts para obtener los valores de los atributos
    $atts = shortcode_atts(array(
        'num' => 6,
        'league' => wp_get_post_terms(get_the_ID(), 'league', array('field' => 'slug')),
        'date' => null,
        'model' => 1,
        'text_vip_link' => 'VIP',
        'filter' => null,
        'time_format' => null,
        'paginate' => null,
        'title' => null
    ), $atts);
    global $post;
    
    // Asegurarse de que solo se carga el CSS si es necesario
    if (is_a($post, 'WP_Post') && (has_shortcode($post->post_content, 'forecasts') || is_single())) {
        wp_enqueue_style('s-forecasts-css', get_template_directory_uri() . '/assets/css/forecasts-styles.css', [], null, 'all');
    }

    $ret = "";

    // Verificar si la geolocalización está disponible
    $geolocation = isset($_SESSION["geolocation"]) ? json_decode($_SESSION["geolocation"]) : null;
    if (!$geolocation) {
        return '<h1>No se pudo obtener la geolocalización.</h1>';
    }

    // Obtener tipo de probabilidades (odds)
    $odds = get_option('odds_type');

    // Asignar título basado en el tipo de página
    $title = $atts['title'];
    if (!$title) {
        if (is_page()) {
            $title = get_the_title();
        } elseif (is_post_type_archive()) {
            $title = post_type_archive_title('', false);
        } elseif (is_category() || is_tax()) {
            $title = single_term_title('', false);
        } elseif (is_tag()) {
            $title = single_tag_title('', false);
        }

        // Verificar si hay un H1 personalizado
        $custom_h1 = carbon_get_post_meta(get_the_ID(), 'custom_h1');
        $title = empty($custom_h1) ? $title : $custom_h1;
    }

    // Si se necesita filtro, mostrar el formulario para seleccionar fecha
    if ($atts['filter']) {
        $ret .= "<div class='row'>
                    <h2 class='title col-8'>" . esc_html($title) . "</h2>
                    <div class='col-4 justify-content-end d-flex event_select'>
                        <select name='ord' data-type='forecast' id='element_select_forecasts' onchange='filter_date_items(this)'>
                            <option value='' " . (!$atts['date'] ? 'selected' : '') . ">" . __('Todo', 'jbetting') . "</option>
                            <option value='ayer' " . ($atts['date'] == 'ayer' ? 'selected' : '') . ">" . __('Ayer', 'jbetting') . "</option>
                            <option value='hoy' " . ($atts['date'] == 'hoy' ? 'selected' : '') . ">" . __('Hoy', 'jbetting') . "</option>
                            <option value='mañana' " . ($atts['date'] == 'mañana' ? 'selected' : '') . ">" . __('Mañana', 'jbetting') . "</option>
                        </select>
                    </div>
                </div>";
    }

    // Procesar la variable 'league' correctamente
    if (is_array($atts['league']) && count($atts['league']) > 0) {
        $league_arr = implode(',', array_map(function($item) {
            return $item->slug;
        }, $atts['league']));
    } elseif (is_string($atts['league'])) {
        $league_arr = $atts['league'];
    } else {
        $league_arr = '';
    }
    
    // Preparar parámetros para la consulta
    $args = [
        'paged' => (get_query_var('paged') ? get_query_var('paged') : 1),
        'posts_per_page' => $atts['num'],
        'leagues' => $league_arr,
        'date' => $atts['date'],
        'model' => $atts['model'],
        'time_format' => $atts['time_format'],
        'text_vip_link' => $atts['text_vip_link'],
        'rest_uri' => get_rest_url(null, 'aw-forecasts/forecasts'),
        'country_code' => $geolocation->country_code,
        'timezone' => $geolocation->timezone,
        'odds' => $odds,
        'exclude_post' => null,
        'current_user_id' => get_current_user_id(),
    ];
    
    // Usamos sprintf para incluir la variable 'paged' en el botón
    $args['btn_load_more'] = sprintf(
        "<button onclick='load_more_items(this)' data-page='%d' data-type='forecast' id='load_more_forecast' class='loadbtn btn d-flex justify-content-center mt-5'>%s</button><br/>",
        $args['paged'],
        __('Cargar más', 'jbetting')
    );
    

    // Excluir el pronóstico actual si es una página de pronóstico
    if (get_post_type() == "forecast" && is_single()) {
        $args['exclude_post'] = get_the_ID();
    }

    // Construir la cadena de parámetros de la consulta
    $params = http_build_query([
        'paged' => $args['paged'],
        'posts_per_page' => $args['posts_per_page'],
        'leagues' => $args['leagues'],
        'date' => $args['date'],
        'model' => $args['model'],
        'time_format' => $args['time_format'],
        'text_vip_link' => $args['text_vip_link'],
        'country_code' => $args['country_code'],
        'timezone' => $args['timezone'],
        'exclude_post' => $args['exclude_post'],
        'current_user_id' => $args['current_user_id'],
        'odds' => $args['odds']
    ]);

    wp_add_inline_script('common-js', "let forecasts_fetch_vars = " . json_encode($args));

    // Realizar la solicitud HTTP
    $response = wp_remote_get($args['rest_uri'] . '?' . $params, ['timeout' => 15]);

    // Procesar la respuesta
    $query = wp_remote_retrieve_body($response);
    if (is_wp_error($query)) {
        return '<h1>Error al obtener los datos. Por favor, intenta más tarde.</h1>';
    }

    // Verificar que la respuesta sea válida
    $data_json = json_decode($query);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return '<h1>Datos inválidos recibidos. Intenta más tarde.</h1>';
    }

    // Determinar la clase de la envoltura dependiendo del modelo
    $home_class = ($args['model'] && $args['model'] != 1) ? 'row' : 'event_wrap pt_30';

    // Reemplazar los datos del ciclo y construir el HTML
    $loop_html = $data_json->html;
    $ret .= "<div class='$home_class' id='games_list'>{$loop_html}</div>";

    return $ret;
}

add_shortcode('related-forecasts', 'shortcode_related_forecast');
