<?php
// Definir el shortcode

function shortcode_forecast($atts)
{
    // Extraer los valores del shortcode de forma segura sin usar extract()
    $atts = shortcode_atts(array(
        'num' => 2,
        'league' => wp_get_post_terms(get_the_ID(), 'league', array('field' => 'slug')),
        'date' => null,
        'model' => 1,
        'text_vip_link' => 'VIP',
        'filter' => null,
        'time_format' => null,
        'title' => null
    ), $atts);

    // Asignar las variables
    $num = $atts['num'];
    $league = $atts['league'];
    $date = $atts['date'];
    $model = $atts['model'];
    $text_vip_link = $atts['text_vip_link'];
    $filter = $atts['filter'];
    $time_format = $atts['time_format'];
    $title = $atts['title'];


    $ret = "";

    // Verificar si la geolocalización existe en la sesión
    if (isset($_SESSION["geolocation"])) {
        $geolocation = json_decode($_SESSION["geolocation"]);
    } else {
        $geolocation = null; // Manejar cuando no haya geolocalización
    }

    $odds = get_option('odds_type');

    // Si hay filtro, crear el HTML de la selección
    if ($filter) {
        $ret .= "<div class='row'>
                    <h2 class='title-h2 col-8'>" . (isset($title) ? esc_html($title) : '') . "</h2>
                    <div class='col-4 justify-content-end d-flex event_select'>
                        <select name='ord' data-type='forecast' id='element_select_forecasts' onchange='filter_date_items(this)'>
                            <option value='' " . (!$date ? 'selected' : '') . ">" . __('Todo', 'jbetting') . "</option>
                            <option value='ayer' " . ($date == 'ayer' ? 'selected' : '') . ">" . __('Ayer', 'jbetting') . "</option>
                            <option value='hoy' " . ($date == 'hoy' ? 'selected' : '') . ">" . __('Hoy', 'jbetting') . "</option>
                            <option value='mañana' " . ($date == 'mañana' ? 'selected' : '') . ">" . __('Mañana', 'jbetting') . "</option>
                        </select>
                    </div>
                </div>";
    }

    // Procesar las ligas
    $league_arr = null;
    if (is_array($league) && count($league) > 0) {
        $league_arr = "[{replace-leagues}]";
        $temp_leages = '';
        foreach ($league as $key => $value) {
            $temp_leages .= esc_attr($value->slug) . ','; // Escapar los valores
        }
        $league_arr = str_replace("{replace-leagues}", $temp_leages, $league_arr);
    }

    if (!is_array($league) && is_string($league)) {
        $league_arr = "[{replace-leagues}]";
        $league_arr = str_replace("{replace-leagues}", esc_attr($league), $league_arr); // Escapar el valor
    }

    // Configurar los argumentos de la solicitud
    $args = [];
    $args['paged'] = (get_query_var('paged') ? get_query_var('paged') : 1);
    $args['posts_per_page'] = $num;
    $args['leagues'] = $league_arr;
    $args['date'] = $date;
    $args['model'] = $model;
    $args['time_format'] = $time_format;
    $args['text_vip_link'] = $text_vip_link;
    $args['rest_uri'] = get_rest_url(null, 'aw-forecasts/forecasts');
    $args['country_code'] = $geolocation->country_code ?? ''; // Usar valor por defecto si no hay geolocalización
    $args['timezone'] = $geolocation->timezone ?? '';
    $args['odds'] = $odds;
    $args['exclude_post'] = null;
    $args["current_user_id"] = get_current_user_id();
    $args['btn_load_more'] = "<button onclick='load_more_items(this)' data-page='{$args['paged']}' data-type='forecast' id='load_more_forecast' class='loadbtn btn font-weight-bold py-2 px-3'>
        " . __('Cargar más', 'jbetting') . "
    </button><br/>";

    // Obtener el tipo de post
    $post_type = get_post_type();  // Obtener el tipo de post actual

    // Excluir el post actual si estamos en una página de tipo 'forecast' y es un post único
    if ($post_type == "forecast" && is_single()) {
        $args['exclude_post'] = get_the_ID();
    }

    // Crear los parámetros de la URL para la consulta REST
    $params = "?paged=" . $args['paged'];
    $params .= "&posts_per_page={$args['posts_per_page']}";
    $params .= isset($args['leagues']) ? "&leagues={$args['leagues']}" : "";
    $params .= isset($args['date']) ? "&date={$args['date']}" : "";
    $params .= "&model=$model";
    $params .= isset($args['time_format']) ? "&time_format={$args['time_format']}" : "";
    $params .= isset($args['text_vip_link']) ? "&text_vip_link={$args['text_vip_link']}" : "";
    $params .= isset($args['country_code']) ? "&country_code={$args['country_code']}" : "";
    $params .= isset($args['timezone']) ? "&timezone={$args['timezone']}" : "";
    $params .= isset($args['exclude_post']) ? "&exclude_post={$args['exclude_post']}" : "";
    $params .= "&current_user_id={$args['current_user_id']}";
    $params .= "&odds=$odds";

    wp_add_inline_script('common-js', "let forecasts_fetch_vars = " . json_encode($args));

    // Realizar la solicitud a la API
    $response = wp_remote_get($args['rest_uri'] . $params, array('timeout' => 30)); // Timeout aumentado a 30 segundos

    // Verificar si la respuesta es válida
    if (is_wp_error($response)) {
        return '<h1>No se pudo obtener la información. Intenta más tarde.</h1>';
    }

    // Obtener el cuerpo de la respuesta
    $query = wp_remote_retrieve_body($response);

    // Verificar que la respuesta no esté vacía
    if (empty($query)) {
        return '<h1>No hay datos disponibles en este momento.</h1>';
    }

    $home_class = "event_wrap pt_30";
    if ($model && $model != 1) {
        $home_class = 'row';
    }

    $loop_html = '';
    $ret .= "<div class='$home_class' id='games_list'>{replace_loop}</div>";
    $data_json = json_decode($query);

    // Verificar si los datos fueron decodificados correctamente
    if (json_last_error() !== JSON_ERROR_NONE) {
        return '<h1>Error al procesar los datos de la API.</h1>';
    }

    $loop_html = $data_json->html;

    // Reemplazar el contenido dinámico en el HTML
    $ret = str_replace("{replace_loop}", $loop_html, $ret);

    $ret .= "<div class='container text-center my-5'>";
    if ($data_json->page < $data_json->max_pages) {
        $ret .= $args['btn_load_more'];
    }
    $ret .= "</div>";

    $ret .= '<div class="container my-2 text-center text-muted page-status-indicator">
                ' . __("pagina ", "jbetting") . '
                <span id="current-page-number">' . ($data_json->max_pages == 0 ? 0 : $data_json->page) . '</span> de 
                <span id="max-page-number">' . $data_json->max_pages . '</span>
              </div>';

    return $ret;
}

add_shortcode('forecasts', 'shortcode_forecast');




// Cargar common.js condicionalmente
function load_common_js_if_shortcode_exists() {
    global $post;
    if (isset($post) && is_a($post, 'WP_Post') && (has_shortcode($post->post_content, 'forecasts') || is_single())) {
        wp_enqueue_script('common-js', get_template_directory_uri() . '/assets/js/common.js', array(), null, true);
    }
}
add_action('wp_enqueue_scripts', 'load_common_js_if_shortcode_exists');

// Asegurarse de que el CSS solo se cargue si es necesario
function load_forecast_styles() {
    global $post;
    if (isset($post) && is_a($post, 'WP_Post') && (has_shortcode($post->post_content, 'forecasts') || is_single())) {
        wp_enqueue_style('s-forecasts-css', get_template_directory_uri() . '/assets/css/forecasts-styles.css');
    }
}
add_action('wp_enqueue_scripts', 'load_forecast_styles');

