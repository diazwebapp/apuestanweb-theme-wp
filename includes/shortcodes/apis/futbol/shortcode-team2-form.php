<?php
findClosestMatch($needle, $haystack);

function equipo2_form_shortcode($atts) {
    // Obtiene el ID de la publicación actual.
    $current_post_id = get_the_ID();

    // Obtiene los atributos pasados al shortcode (si los necesitas).
    $atts = shortcode_atts(array(
        'team2' => '', // ID del equipo 2
    ), $atts);

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
    $team2_name = isset($teams["team2"]["name"]) ? $teams["team2"]["name"] : '';

    // Busca el nombre más cercano en el archivo JSON para el equipo 2.
    $team2_name_closest = findClosestMatch($team2_name, array_column($teams_data, 'name'));

    // Obtiene los IDs de API de los equipos a partir de los nombres más cercanos encontrados.
    $team2_id = isset($team_ids[$team2_name_closest]) ? $team_ids[$team2_name_closest] : '';

    // Define una clave única para la información en caché, basada en los IDs de los equipos.
    $cache_key_team2 = 'equipo2_fixtures_' . $current_post_id . '_';

    // Intenta obtener la información desde la caché para el equipo 2.
    $cached_data_team2 = get_transient($cache_key_team2);

    if ($cached_data_team2) {
        // Si la información para el equipo 2 está en caché, la muestra.
        return $cached_data_team2;
    } else {
        // Construye las URL de los endpoints de la API para el equipo 2.
        $api_url_team2 = "https://v3.football.api-sports.io/fixtures?team=$team2_id&last=6";

        // Realiza la solicitud a la API para el equipo 2 y obtén la respuesta.
        $response_team2 = wp_safe_remote_get($api_url_team2, array(
            'headers' => array(
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => 'c4350da63ff88a372f6e672cb574dc6f',
            ),
        ));

        // Verifica si la solicitud fue exitosa.
        if (!is_wp_error($response_team2)) {
            // Procesa la respuesta de la API para el equipo 2.
            $body_team2 = wp_remote_retrieve_body($response_team2);
            $data_team2 = json_decode($body_team2, true);

            if (isset($data_team2['response'])) {
                $fixtures_team2 = $data_team2['response'];

                // Inicializa variables para estadísticas.
                $partidos_jugados = 0;
                $partidos_ganados = 0;
                $partidos_empatados = 0;
                $derrotas = 0;
                $goles_anotados = 0;
                $goles_recibidos = 0;
                $victorias_mas_1_gol = 0;
                $partidos_mas_2_5_goles = 0;
                $ambos_equipos_anotaron = 0;

                // Inicializa variables para contar los partidos en los que el equipo 2 fue local o visitante.
                $partidos_local = 0;
                $partidos_visitante = 0;

                // Crear una matriz para almacenar los resultados de los últimos 6 partidos.
                $form_team2_sequence = array();

                // Contar el número de partidos procesados.
                $matches_count = 0;

                // Iterar a través de los partidos en orden cronológico inverso (los más recientes primero).
                // Itera a través de los últimos 6 enfrentamientos.
                foreach ($fixtures_team2 as $fixture) {
                    // Verifica si el equipo 2 está involucrado en el partido como local o visitante.
                    if ($fixture['teams']['home']['id'] == $team2_id || $fixture['teams']['away']['id'] == $team2_id) {
                        // Obtén información relevante del enfrentamiento.
                        $home_team = $fixture['teams']['home']['name'];
                        $away_team = $fixture['teams']['away']['name'];
                        $home_goals = $fixture['goals']['home'];
                        $away_goals = $fixture['goals']['away'];
                        $fixture_date = date('d-m-Y', $fixture['fixture']['timestamp']);
                        $competition_name = $fixture['league']['name'];

                        // Verifica si el equipo 2 fue local en el partido.
                        $equipo2_local = ($fixture['teams']['home']['id'] == $team2_id);

                        // Calcula los goles anotados y recibidos por el equipo 2 en el partido.
                        if ($equipo2_local) {
                            $goles_anotados += $home_goals;
                            $goles_recibidos += $away_goals;
                            $partidos_local++;
                        } else {
                            $goles_anotados += $away_goals;
                            $goles_recibidos += $home_goals;
                            $partidos_visitante++;
                        }

                        // Verifica el resultado del partido.
                        if ($home_goals > $away_goals && $equipo2_local || $away_goals > $home_goals && !$equipo2_local) {
                            $partidos_ganados++;
                            if (abs($home_goals - $away_goals) > 1) {
                                $victorias_mas_1_gol++;
                            }
                        } elseif ($home_goals == $away_goals) {
                            $partidos_empatados++;
                        } else {
                            $derrotas++;
                        }

                        // Verifica si el partido tiene más de 2.5 goles.
                        if ($home_goals + $away_goals > 2) {
                            $partidos_mas_2_5_goles++;
                        }
                        if ($home_goals > 0 && $away_goals > 0) {
                            $ambos_equipos_anotaron++;
                        }

                        // Construye el evento completo.
                        $event = "$fixture_date - $home_team $home_goals - $away_goals $away_team";

                        // Determina el resultado del partido y agrega el tooltip con el evento completo.
                        if (($home_goals > $away_goals && $equipo2_local) || ($away_goals > $home_goals && !$equipo2_local)) {
                            $result = '<span class="win-label mr-2" data-toggle="tooltip" title="' . $event . '">G</span>';
                        } elseif (($home_goals < $away_goals && $equipo2_local) || ($away_goals < $home_goals && !$equipo2_local)) {
                            $result = '<span class="loss-label mr-2" data-toggle="tooltip" title="' . $event . '">P</span>';
                        } else {
                            $result = '<span class="draw-label mr-2" data-toggle="tooltip" title="' . $event . '">E</span>';
                        }
                
                        $form_team2_sequence[] = $result;
                
                        // Incrementar el contador de partidos procesados.
                        $matches_count++;
                
                        // Si hemos procesado los últimos 6 partidos, salimos del bucle.
                        if ($matches_count >= 6) {
                            break;
                        }
                        
                    }
                }

                // Convertir la matriz en una cadena.
                $form_team2_string = implode('', $form_team2_sequence);

                // Calcula el número total de partidos jugados por el equipo 2.
                $partidos_jugados = $partidos_local + $partidos_visitante;

                // Calcula el promedio de goles anotados por el equipo 2 en los partidos jugados.
                $promedio_goles_team2 = $partidos_jugados > 0 ? $goles_anotados / $partidos_jugados : 0;


                $output_team2 = '<div class="card mb-4 text-center">';
                $output_team2 .= '<div class="card-body">';
                // Título y Form team en la misma línea en pantallas grandes.
                $output_team2 .= '<div class="bg-form d-flex justify-content-between align-items-center mb-4">';
                $output_team2 .= '<h2 class="card-title mb-0">Últimos '.$partidos_jugados.' partidos de '.$team2_name.'</h2>';
                $output_team2 .= '<div class="d-none d-lg-block">'.$form_team2_string.'</div>';
                $output_team2 .= '</div>';

                // Form team debajo del título en pantallas pequeñas.
                $output_team2 .= '<div class="d-lg-none mb-3 text-center">'.$form_team2_string.'</div>';

                // Función para generar una card hijo con subtítulo.
                function generateStatCardTeam2($title, $value) {
                    return '<div class="card mb-2">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-2 text-muted statstext32">' . $title . '</h6>
                                    <p class="card-text text-center">' . $value . '</p>
                                </div>
                            </div>';
                }

                // Agregar las estadísticas como card hijos.
                $output_team2 .= generateStatCardTeam2('Partidos', $partidos_jugados);
                $output_team2 .= generateStatCardTeam2('Victorias', $partidos_ganados);
                $output_team2 .= generateStatCardTeam2('Empates', $partidos_empatados);
                $output_team2 .= generateStatCardTeam2('Derrotas', $derrotas);
                $output_team2 .= generateStatCardTeam2('Goles anotados', $goles_anotados);
                $output_team2 .= generateStatCardTeam2('Goles recibidos', $goles_recibidos);
                $output_team2 .= generateStatCardTeam2('Ambos equipos anotaron', $ambos_equipos_anotaron . '/' . $partidos_jugados);
                $output_team2 .= generateStatCardTeam2('Promedio de goles del equipo', round($promedio_goles_team2, 2));
                $output_team2 .= generateStatCardTeam2('Victorias por más de 1 gol', $victorias_mas_1_gol);
                $output_team2 .= generateStatCardTeam2('Más de 2.5 goles', $partidos_mas_2_5_goles . '/' . $partidos_jugados);

                $output_team2 .= '</div>'; // Cierre de la card-body
                $output_team2 .= '</div>'; // Cierre de la card

                // Agrega el CSS necesario para dar estilo a las cards.
                $output_team2 .= '<style>
                    .card {
                        width: 100%;
                    }
                    .card.mb-2 {
                        width: 12rem;
                        display: inline-block;
                        margin-right: 1rem;
                    }
                </style>';

                
                set_transient($cache_key_team2, $output_team2);

                return $output_team2;
            } else {
                return 'No se encontraron fixtures para el equipo 2 especificado.';
            }
        } else {
            return 'Hubo un error al obtener los datos de la API para el equipo 2.';
        }
    }
}
// Registra el nuevo shortcode.
add_shortcode('equipo2_form', 'equipo2_form_shortcode');
?>
