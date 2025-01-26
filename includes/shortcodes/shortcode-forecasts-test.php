<?php
// Definir el shortcode

function shortcode_forecast_test($atts)
{
    $atts = shortcode_atts(array(
        'num' => 3,
        'league' => wp_get_post_terms(get_the_ID(), 'league', array('field' => 'slug')),
        'date' => null,
        'model' => 2,
        'filter' => null,
        'time_format' => null,
        'title' => null,
        'paginate' => 'yes',
        'geolocation' => isset($_SESSION["geolocation"]) ? json_decode($_SESSION["geolocation"]) : null,
        'odds' => get_option('odds_type')
    ), $atts);

    // Procesar las ligas
    $league_arr = null;
    if (is_array($atts['league']) && count($atts['league']) > 0) {
        $leagues = array_map('esc_attr', wp_list_pluck($atts['league'], 'slug'));
        $league_arr = "[" . implode(',', $leagues) . "]";
    } elseif (!is_array($atts['league']) && is_string($atts['league'])) {
        $league_arr = "[" . esc_attr($atts['league']) . "]";
    }

    $query = aw_custom_posts_query('forecast', $atts['num'], null, 'page_forecast');
    
    if (empty($query)) {
        return '<h1>No hay datos disponibles en este momento.</h1>';
    }
    
    $loop_posts = '';
    if ($query->posts) {
        $view_params = [
            "country_code"=> $atts['geolocation']->country_code ?? null,
            "timezone" => $atts['geolocation']->timezone ?? null,
            "odds" => $atts['odds'],
            "time_format" => $atts['time_format'],
            "num" => $atts['num'],
            "model" => $atts['model']
        ];
        foreach ($query->posts as $forecast) {
            $view_params["forecast"] = $forecast;
            $loop_posts .= load_template_part("loop/pronosticos_list_{$atts['model']}", null, $view_params);
        }
        wp_reset_postdata();

    }
        // Pasa los datos necesarios al script de JavaScript
        wp_localize_script('common-js', 'forecastData', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'view_params' => $view_params,
            'max_num_pages' => $query->max_num_pages,
        ));
    
    $home_class = $atts['model'] && $atts['model'] != 1 ? 'row' : 'event_wrap';
    $ret = "
        {replace_filter}
        <section class='$home_class' id='games_list'>{replace_loop}</section>
        {replace_pag_nav}
    ";

    // Si hay filtro, crear el HTML de la selección
    $filter = '';
    if ($atts['filter']) {
        $filter = "<div class='row my-2'>
                    <h2 class='title-h2 col-8'>" . (isset($atts["title"]) ? esc_html($atts["title"]) : '') . "</h2>
                    <div class='col-4 text-right'>
                        <select name='ord' data-type='forecast' id='element_select_forecasts' onchange='filter_date_items(this)' class='myselect'>
                            <option value='' " . (!$atts['date'] ? 'selected' : '') . ">" . __('Todo', 'jbetting') . "</option>
                            <option value='ayer' " . ($atts['date'] == 'ayer' ? 'selected' : '') . ">" . __('Ayer', 'jbetting') . "</option>
                            <option value='hoy' " . ($atts['date'] == 'hoy' ? 'selected' : '') . ">" . __('Hoy', 'jbetting') . "</option>
                            <option value='mañana' " . ($atts['date'] == 'mañana' ? 'selected' : '') . ">" . __('Mañana', 'jbetting') . "</option>
                        </select>
                    </div>
                </div>";
    }
    $ret = str_replace("{replace_filter}", $filter, $ret);
    $ret = str_replace("{replace_loop}", $loop_posts, $ret);
    
    $pag_nav = '';
    if ($atts['paginate'] === 'yes') {
        $pag_nav = "<div class='container container_pagination_forecast text-center my-5'>";
        if ($query->query_vars["paged"] < $query->max_num_pages) {
            $pag_nav .= "<button id='load_more_forecast' data-page='{$query->query_vars["paged"]}' class='loadbtn btn font-weight-bold py-2 px-3'>
                    " . __('Cargar más', 'jbetting') . "
                </button><br/>";
        }
        $pag_nav .= "</div>";
        $pag_nav .= '<div class="container my-2 text-center text-muted page-status-indicator">
                    ' . __("pagina ", "jbetting") . '
                    <span id="current-page-number">' . ($query->max_num_pages == 0 ? 0 : $query->query_vars["paged"]) . '</span> de 
                    <span id="max-page-number">' . $query->max_num_pages . '</span>
                  </div>';
    }
    
    $ret = str_replace("{replace_pag_nav}", $pag_nav, $ret);

    return $ret;
}

add_shortcode('forecasts-test', 'shortcode_forecast_test');



// Cargar common.js condicionalmente
function load_test() {
    global $post;
    if (isset($post) && is_a($post, 'WP_Post') && (has_shortcode($post->post_content, 'forecasts-test') )) {
        wp_enqueue_script('common-js', get_template_directory_uri() . '/assets/js/common.js', array(), null, true);
        wp_enqueue_style('s-forecasts-css', get_template_directory_uri() . '/assets/css/forecasts-styles.css');
    }
}
add_action('wp_enqueue_scripts', 'load_test');

