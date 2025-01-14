<?php

findClosestMatch($needle, $haystack);

function basket_h2h_shortcode($atts) {
    // Obtiene el ID de la publicación actual.
    $current_post_id = get_the_ID();

    // Obtiene los atributos pasados al shortcode (si los necesitas).
    $atts = shortcode_atts(array(
        'team1' => '',
        'team2' => '',
    ), $atts);

    // Carga el archivo JSON de equipos.
    // Obtiene la ruta de la carpeta del tema activo.
    $theme_directory = get_template_directory();

    // Construye la ruta completa a la carpeta "includes/json".
    $json_directory = $theme_directory . '/includes/json';
    
    // Carga el archivo JSON desde la carpeta "json" del tema activo.
    $teams_json = file_get_contents($json_directory . '/nba.json');
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


    // Define una clave única para la información en caché, basada en el ID de la publicación actual y el nombre del equipo.
    $cache_key = 'basket_h2h_' . $current_post_id . '_' . $atts['team1'] . '_' . $atts['team2'];

    // Intenta obtener la información desde la caché.
    $cached_data = get_transient($cache_key);

    if ($cached_data) {
        // Si la información está en caché, la muestra.
        return $cached_data;
    } else {
// Verifica si se obtuvieron los IDs de API de los equipos.
if ($team1_name && $team2_name) {
    // Construye la URL de la API con los IDs de los equipos.
    $api_url = "https://v1.basketball.api-sports.io/games?h2h=$team1_id-$team2_id";

    // Realiza la solicitud a la API y obtén la respuesta.
    $response = wp_safe_remote_get($api_url, array(
        'headers' => array(
            'x-rapidapi-host' => 'v3.football.api-sports.io',
            'x-rapidapi-key' => 'c4350da63ff88a372f6e672cb574dc6f',
        ),
    ));

    // Verifica si la solicitud fue exitosa.
    if (is_wp_error($response)) {
        return 'Hubo un error al obtener los datos de la API.';
    }

    // Procesa la respuesta de la API.
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
// Verifica si la solicitud a la API fue exitosa y se obtuvieron los datos de los enfrentamientos.
// Verifica si la solicitud a la API fue exitosa y se obtuvieron los datos de los enfrentamientos.
    if (isset($data['response'])) {
    $h2h = $data['response'];

    // Filtra y muestra solo los últimos 5 enfrentamientos más recientes con estado "Match Finished".
    $recent_finished_matches = array_filter($h2h, function($match) {
        return $match['status']['long'] === 'Game Finished';
    });

    // Ordena los enfrentamientos por fecha en orden descendente (los más recientes primero).
    usort($recent_finished_matches, function($a, $b) {
        return $b['timestamp'] - $a['timestamp'];
    });

    // Toma los 5 enfrentamientos más recientes con estado "Match Finished".
    $recent_finished_matches = array_slice($recent_finished_matches, 0, 5);

            // Inicializa una variable de salida HTML.
            $output = '<div class="recent-matches mt-3">';
            $output .= '<h2>Últimos 5 enfrentamientos '.$team1_name.' vs '.$team2_name.':</h2>';
            $output .= '<div class="table-responsive">';
            $output .= '<table class="table custom-table">';
            $output .= '<thead>';
            $output .= '<tr>';
            $output .= '<th scope="col">Fecha</th>';
            $output .= '<th scope="col">Local</th>';
            $output .= '<th scope="col">FT</th>';
            $output .= '<th scope="col">Visitante</th>';
            $output .= '<th scope="col">Competición</th>';
            $output .= '</tr>';
            $output .= '</thead>';
            $output .= '<tbody>';

            // Itera a través de los últimos 5 enfrentamientos más recientes con estado "Match Finished".
            foreach ($recent_finished_matches as $match) {
                // Obtén información relevante del enfrentamiento.
                $home_team = $match['teams']['home']['name'];
                $away_team = $match['teams']['away']['name'];
                $home_goals = $match['scores']['home']['total'];
                $away_goals = $match['scores']['away']['total'];
                $match_date = date('d-m-Y', $match['timestamp']); // Convierte el timestamp en una fecha y hora legible.
                $competition_name = $match['league']['name']; // Obtiene el nombre de la competición (liga).
                // Determina quién es el ganador y quién es el perdedor
                $winner = ($home_goals > $away_goals) ? 'home' : 'away';
                $loser = ($home_goals < $away_goals) ? 'home' : 'away';
                // Agrega cada enfrentamiento como una fila en la tabla.
                $output .= '<tr>';
                $output .= '<td class="match-date">' . $match_date . '</td>';
                $output .= '<td class="team-name ' . (($home_goals === $away_goals) ? 'draw' : ($winner === 'home' ? 'win' : ($loser === 'home' ? 'loss' : ''))) . '">' . $home_team . (($home_goals === $away_goals) ? ' <span class="draw-label">E</span>' : ($winner === 'home' && $home_goals !== $away_goals ? ' <span class="win-label">G</span>' : ($loser === 'home' && $home_goals !== $away_goals ? ' <span class="loss-label">P</span>' : ''))) . '</td>';
                $output .= '<td class="score"> ' . $home_goals . ' - ' . $away_goals . '</td>';
                $output .= '<td class="team-name ' . (($home_goals === $away_goals) ? 'draw' : ($winner === 'away' ? 'win' : ($loser === 'away' && $home_goals !== $away_goals ? 'loss' : ''))) . '">';
                $output .= (($home_goals === $away_goals) ? ' <span class="draw-label">E</span>' : ($winner === 'away' && $home_goals !== $away_goals ? ' <span class="win-label">G</span>' : ($loser === 'away' && $home_goals !== $away_goals ? ' <span class="loss-label">P</span>' : '')));
                $output .= $away_team;
                $output .= '</td>';
                $output .= '<td class="competition">' . $competition_name . '</td>';
                $output .= '</tr>';
                
                
            }

            $output .= '</tbody>';
            $output .= '</table>';
            $output .= '</div>';
            $output .= '</div>';

            // Almacena la información en caché durante un período de tiempo determinado (por ejemplo, 1 día).
            set_transient($cache_key, $output);

            return $output;
        } else {
            return 'No se encontró información de enfrentamientos entre los equipos.';
        }
    }
}

}

add_shortcode('basket_h2h', 'basket_h2h_shortcode');