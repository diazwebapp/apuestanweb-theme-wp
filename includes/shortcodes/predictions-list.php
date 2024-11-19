<?php
function forecast_list_shortcode($atts) {
    // Obtener el atributo de categoría del shortcode (si está presente)
    $atts = shortcode_atts(array(
        'league' => '', // Valor predeterminado vacío si no se especifica la categoría
    ), $atts);

    // Obtener la fecha y hora hace 24 horas.
    $fecha_hace_24_horas = date('Y-m-d H:i:s', strtotime('-24 hours'));

    // Configurar la consulta personalizada
    $args = array(
        'post_type'      => 'forecast', // El nombre de tu Custom Post Type
        'post_status'    => 'publish', // Solo mostrar posts publicados
        'date_query'     => array(
            array(
                'after' => $fecha_hace_24_horas, // Obtener posts después de la fecha hace 24 horas
            ),
        ),
        'posts_per_page' => 10, // Mostrar todos los posts encontrados
    );

    // Agregar el filtro por categoría si se especifica en el shortcode
    if (!empty($atts['league'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'league', // El nombre de la taxonomía (categoría) del CPT "forecast"
                'field'    => 'slug',
                'terms'    => $atts['league'],
            ),
        );
    }

    // Realizar la consulta
     // Realizar la consulta
     $forecast_query = new WP_Query($args);

     // Construir el contenido del shortcode
     $content = '';
 
     if ($forecast_query->have_posts()) {
         $content .= '<ul>';
 
         // Comenzar el loop para mostrar los posts
         while ($forecast_query->have_posts()) {
             $forecast_query->the_post();
             $post_title = get_the_title();
             $fecha_hora = '';
 
             // Obtener el valor del campo personalizado usando Carbon Fields
             
                 // Field: Fecha y hora
                 $fecha_hora = carbon_get_post_meta(get_the_ID(), 'data');
   
 
                 // Obtener los equipos usando el código proporcionado
                 $teams = array(
                     "team1" => array(
                         "name" => "no team",
                         "logo" => "",
                         "acronimo" => ""
                     ),
                     "team2" => array(
                         "name" => "no team",
                         "logo" => "",
                         "acronimo" => ""
                     )
                 );
                 $team1_id = isset(carbon_get_post_meta(get_the_ID(), 'team1')[0]) ? carbon_get_post_meta(get_the_ID(), 'team1')[0]['id'] : false;
                 $team2_id = isset(carbon_get_post_meta(get_the_ID(), 'team2')[0]) ? carbon_get_post_meta(get_the_ID(), 'team2')[0]['id'] : false;
 
                 if ($team1_id) {
                     $teams['team1']['name'] = get_the_title($team1_id);
                     $teams['team1']['acronimo'] = carbon_get_post_meta($team1_id, 'acronimo');
                     if (carbon_get_post_meta($team1_id, 'team_logo')) {
                         $team_logo_att = carbon_get_post_meta($team1_id, 'team_logo');
                         $teams['team1']['logo'] = wp_get_attachment_url($team_logo_att);
                     }
                 }
 
                 if ($team2_id) {
                     $teams['team2']['name'] = get_the_title($team2_id);
                     $teams['team2']['acronimo'] = carbon_get_post_meta($team2_id, 'acronimo');
                     if (carbon_get_post_meta($team2_id, 'team_logo')) {
                         $team_logo_att = carbon_get_post_meta($team2_id, 'team_logo');
                         $teams['team2']['logo'] = wp_get_attachment_url($team_logo_att);
                     }
                 }
             
 
             // Agregar el contenido del post a la lista
             $content .= '<li>';
             $content .= '<strong><a href="' . get_permalink() . '">' . $post_title . '</a></strong><br>';
 
             // Mostrar la fecha y hora si está disponible
             
            
                         

             // Mostrar el nombre del equipo 1 si está disponible
             if (!empty($teams['team1']['name'])) {
                 $content .= 'Partido: ' . $teams['team1']['name'] . ' vs ' . $teams['team2']['name'] .'<br>';

             }
            $content .= 'Fecha y hora: ' . $fecha_hora . '<br>';
             
            $content .= '</li>';
         }
 
         $content .= '</ul>';
     } else {
         // No se encontraron posts en las últimas 24 horas o en la categoría especificada
         $content .= 'No se encontraron pronósticos en la categoría "' . $atts['league'] . '" en las últimas 24 horas.';
     }
 
     // Restaurar los datos originales del loop de WordPress
     wp_reset_postdata();
 
     return $content;
 }
 add_shortcode('forecast_list', 'forecast_list_shortcode');