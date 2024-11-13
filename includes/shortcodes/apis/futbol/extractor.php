<?php
// Define la URL del nuevo endpoint de la API.
$api_url = 'https://v1.basketball.api-sports.io/teams?league=12&season=2023-2024';

// Configura las opciones para la solicitud a la API, incluyendo las cabeceras con tu clave de API.
$request_args = array(
    'headers' => array(
        'x-rapidapi-host' => 'v3.football.api-sports.io',
        'x-rapidapi-key' => 'c4350da63ff88a372f6e672cb574dc6f', // Reemplaza con tu clave de API.
    ),
);

// Realiza la solicitud a la API.
$response = wp_safe_remote_get($api_url, $request_args);

// Verifica si la solicitud fue exitosa.
if (is_wp_error($response)) {
    echo 'Hubo un error al obtener los datos de la API.';
} else {
    // Procesa la respuesta de la API.
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    // Verifica si la solicitud a la API fue exitosa y si se obtuvieron datos de equipos.
    if (isset($data['response']) && is_array($data['response'])) {
        // Filtra y procesa los datos de los equipos según sea necesario.
        $teams_data = array();
        foreach ($data['response'] as $team) {
            // Obtén el nombre y el ID del equipo y agrégalos al arreglo.
            $team_name = $team['team']['name'];
            $team_id = $team['team']['id'];
            $teams_data[] = array(
                'name' => $team_name,
                'id' => $team_id,
            );
        }

        // Convierte los datos de los equipos en formato JSON.
        $json_data = json_encode($teams_data, JSON_PRETTY_PRINT);

        // Guarda los datos en un archivo JSON.
        $file_path = ABSPATH . '309.json'; // Esto guardará el archivo en la raíz del sitio.
        file_put_contents($file_path, $json_data);

        echo 'Los datos de los equipos se han guardado en un archivo JSON.';
    } else {
        echo 'No se encontraron datos de equipos en la respuesta de la API.';
    }
}


add_shortcode('extractor', 'extractor_shortcode');