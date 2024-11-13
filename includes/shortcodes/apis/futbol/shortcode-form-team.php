<?php

findClosestMatch($needle, $haystack);

function equipo_form_shortcode($atts) {
    // Obtiene el ID de la publicación actual.
    $current_post_id = get_the_ID();

    // Obtiene los atributos pasados al shortcode (si los necesitas).
    $atts = shortcode_atts(array(
        'team1' => '', // ID del equipo 1
        'team2' => '', // ID del equipo 2
    ), $atts);


    // Carga el archivo JSON de equipos.
    // Obtiene la ruta de la carpeta del tema activo.
    $theme_directory = get_template_directory();

    // Construye la ruta completa a la carpeta "includes/json".
    $json_directory = $theme_directory . '/includes/json';

    // Carga el archivo JSON desde la carpeta "json" del tema activo.
    $teams_json = file_get_contents($json_directory . '/equipos.json');
    // Ajusta la ruta según la ubicación de tu archivo JSON.
    $teams_data = json_decode($teams_json, true);

    // Asocia los nombres de los equipos con sus IDs en un array asociativo.
    $team_ids = array();
    foreach ($teams_data as $team) {
        $team_ids[$team['name']] = $team['id'];
    }

    $teams = get_forecast_teams($current_post_id, ["w" => 50, "h" => 50]);

    // Obtiene los IDs de API de los equipos a partir de sus nombres (buscando coincidencias aproximadas).
    $team1_name = isset($teams["team1"]["name"]) ? $teams["team1"]["name"] : '';
    $team2_name = isset($teams["team2"]["name"]) ? $teams["team2"]["name"] : '';

    // Busca el nombre más cercano en el archivo JSON para el equipo 1.
    $team1_name_closest = findClosestMatch($team1_name, array_column($teams_data, 'name'));
    // Busca el nombre más cercano en el archivo JSON para el equipo 2.
    $team2_name_closest = findClosestMatch($team2_name, array_column($teams_data, 'name'));

    // Obtiene los IDs de API de los equipos a partir de los nombres más cercanos encontrados.
    $team1_id = isset($team_ids[$team1_name_closest]) ? $team_ids[$team1_name_closest] : '';
    $team2_id = isset($team_ids[$team2_name_closest]) ? $team_ids[$team2_name_closest] : '';

    // Define una clave única para la información en caché, basada en los IDs de los equipos.
    $cache_key_team1 = 'equipo_fixtures_' . $atts['team1'] . '_' . $atts['last'];
    $cache_key_team2 = 'equipo_fixtures_' . $atts['team2'] . '_' . $atts['last'];

    // Intenta obtener la información desde la caché para ambos equipos.
    $cached_data_team1 = get_transient($cache_key_team1);
    $cached_data_team2 = get_transient($cache_key_team2);

    if ($cached_data_team1 && $cached_data_team2) {
        // Si la información para ambos equipos está en caché, la muestra.
        return $cached_data_team1 . $cached_data_team2;
    } else {
        // Construye las URL de los endpoints de la API para ambos equipos.
        $api_url_team1 = "https://v3.football.api-sports.io/fixtures?team=$team1_id&last=5";
        $api_url_team2 = "https://v3.football.api-sports.io/fixtures?team=$team2_id&last=5";

        // Realiza la solicitud a la API para el equipo 1 y obtén la respuesta.
        $response_team1 = wp_safe_remote_get($api_url_team1, array(
            'headers' => array(
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => 'c4350da63ff88a372f6e672cb574dc6f',
            ),
        ));

        // Realiza la solicitud a la API para el equipo 2 y obtén la respuesta.
        $response_team2 = wp_safe_remote_get($api_url_team2, array(
            'headers' => array(
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => 'a52ca78197e7c259de11757ac731142e',
            ),
        ));

        // Verifica si ambas solicitudes fueron exitosas.
        if (!is_wp_error($response_team1) && !is_wp_error($response_team2)) {
            // Procesa las respuestas de la API para ambos equipos.
            $body_team1 = wp_remote_retrieve_body($response_team1);
            $data_team1 = json_decode($body_team1, true);

            $body_team2 = wp_remote_retrieve_body($response_team2);
            $data_team2 = json_decode($body_team2, true);

            if (isset($data_team1['response']) && isset($data_team2['response'])) {
                $fixtures_team1 = $data_team1['response'];
                $fixtures_team2 = $data_team2['response'];

                // Inicializa variables de salida HTML con las tablas separadas para cada equipo.
                $output_team1 = '<div class="recent-matches">';
                $output_team1 .= '<h2>Últimos enfrentamientos de ' . $team1_name . ':</h2>';
                $output_team1 .= '<div class="table-responsive">';
                $output_team1 .= '<table class="table custom-table">';
                $output_team1 .= '<thead>';
                $output_team1 .= '<tr>';
                $output_team1 .= '<th scope="col">Fecha</th>';
                $output_team1 .= '<th scope="col">' . $team1_name . '</th>';
                $output_team1 .= '<th scope="col">Puntuación</th>';
                $output_team1 .= '<th scope="col">' . $team2_name . '</th>';
                $output_team1 .= '<th scope="col">Competición</th>';
                $output_team1 .= '</tr>';
                $output_team1 .= '</thead>';
                $output_team1 .= '<tbody>';

                $output_team2 = '<div class="recent-matches">';
                $output_team2 .= '<h2>Últimos enfrentamientos de ' . $team2_name . ':</h2>';
                $output_team2 .= '<div class="table-responsive">';
                $output_team2 .= '<table class="table custom-table">';
                $output_team2 .= '<thead>';
                $output_team2 .= '<tr>';
                $output_team2 .= '<th scope="col">Fecha</th>';
                $output_team2 .= '<th scope="col">' . $team2_name . '</th>';
                $output_team2 .= '<th scope="col">Puntuación</th>';
                $output_team2 .= '<th scope="col">' . $team1_name . '</th>';
                $output_team2 .= '<th scope="col">Competición</th>';
                $output_team2 .= '</tr>';
                $output_team2 .= '</thead>';
                $output_team2 .= '<tbody>';

                // Itera a través de los últimos 6 enfrentamientos más recientes con estado "Match Finished" para el equipo 1.
                foreach ($fixtures_team1 as $fixture) {
                    // Obtén información relevante del enfrentamiento.
                    $home_team = $fixture['teams']['home']['name'];
                    $away_team = $fixture['teams']['away']['name'];
                    $home_goals = $fixture['goals']['home'];
                    $away_goals = $fixture['goals']['away'];
                    $fixture_date = date('d-m-Y', $fixture['fixture']['timestamp']);
                    $competition_name = $fixture['league']['name'];
                    // Determina quién es el ganador y quién es el perdedor
                    $winner = ($home_goals > $away_goals) ? $team1_name : $team2_name;
                    $loser = ($home_goals < $away_goals) ? $team1_name : $team2_name;
                    // Agrega cada enfrentamiento como una fila en la tabla para el equipo 1.
                    $output_team1 .= '<tr>';
                    $output_team1 .= '<td class="match-date">' . $fixture_date . '</td>';
                    $output_team1 .= '<td class="team-name ' . ($winner === $team1_name ? 'win' : ($loser === $team1_name ? 'loss' : '')) . '">' . $home_team . ($winner === $team1_name && $home_goals !== $away_goals ? ' <span class="win-label">G</span>' : ($loser === $team1_name && $home_goals !== $away_goals ? ' <span class="loss-label">P</span>' : '')) . '</td>';
                    $output_team1 .= '<td class="score"> ' . $home_goals . ' - ' . $away_goals . '</td>';
                    $output_team1 .= '<td class="team-name ' . ($winner === $team2_name ? 'win' : ($loser === $team2_name ? 'loss' : '')) . '">';
                    $output_team1 .= ($winner === $team2_name && $home_goals !== $away_goals ? ' <span class="win-label">G</span>' : ($loser === $team2_name && $home_goals !== $away_goals ? ' <span class="loss-label">P</span>' : ''));
                    $output_team1 .= $away_team;
                    $output_team1 .= '</td>';
                    $output_team1 .= '<td class="competition">' . $competition_name . '</td>';
                    $output_team1 .= '</tr>';
                }

                // Itera a través de los últimos 6 enfrentamientos más recientes con estado "Match Finished" para el equipo 2.
                foreach ($fixtures_team2 as $fixture) {
                    // Obtén información relevante del enfrentamiento.
                    $home_team = $fixture['teams']['home']['name'];
                    $away_team = $fixture['teams']['away']['name'];
                    $home_goals = $fixture['goals']['home'];
                    $away_goals = $fixture['goals']['away'];
                    $fixture_date = date('d-m-Y', $fixture['fixture']['timestamp']);
                    $competition_name = $fixture['league']['name'];
                    // Determina quién es el ganador y quién es el perdedor
                    $winner = ($home_goals > $away_goals) ? $team2_name : $team1_name;
                    $loser = ($home_goals < $away_goals) ? $team2_name : $team1_name;
                    // Agrega cada enfrentamiento como una fila en la tabla para el equipo 2.
                    $output_team2 .= '<tr>';
                    $output_team2 .= '<td class="match-date">' . $fixture_date . '</td>';
                    $output_team2 .= '<td class="team-name ' . ($winner === $team2_name ? 'win' : ($loser === $team2_name ? 'loss' : '')) . '">' . $home_team . ($winner === $team2_name && $home_goals !== $away_goals ? ' <span class="win-label">G</span>' : ($loser === $team2_name && $home_goals !== $away_goals ? ' <span class="loss-label">P</span>' : '')) . '</td>';
                    $output_team2 .= '<td class="score"> ' . $home_goals . ' - ' . $away_goals . '</td>';
                    $output_team2 .= '<td class="team-name ' . ($winner === $team1_name ? 'win' : ($loser === $team1_name ? 'loss' : '')) . '">';
                    $output_team2 .= ($winner === $team1_name && $home_goals !== $away_goals ? ' <span class="win-label">G</span>' : ($loser === $team1_name && $home_goals !== $away_goals ? ' <span class="loss-label">P</span>' : ''));
                    $output_team2 .= $away_team;
                    $output_team2 .= '</td>';
                    $output_team2 .= '<td class="competition">' . $competition_name . '</td>';
                    $output_team2 .= '</tr>';
                }

                $output_team1 .= '</tbody>';
                $output_team1 .= '</table>';
                $output_team1 .= '</div>';
                $output_team1 .= '</div>';

                $output_team2 .= '</tbody>';
                $output_team2 .= '</table>';
                $output_team2 .= '</div>';
                $output_team2 .= '</div>';

                // Almacena la información en caché para ambos equipos durante un período de tiempo determinado (por ejemplo, 1 día).
                set_transient($cache_key_team1, $output_team1, 365 * 24 * 60 * 60);
                set_transient($cache_key_team2, $output_team2, 365 * 24 * 60 * 60);

                // Devuelve la salida HTML para ambos equipos.
                return $output_team1 . $output_team2;
            } else {
                return 'No se encontraron fixtures para los equipos especificados.';
            }
        } else {
            return 'Hubo un error al obtener los datos de la API para al menos uno de los equipos.';
        }
    }
}

// Registra el nuevo shortcode.
add_shortcode('tablas_h2h', 'equipo_form_shortcode');
