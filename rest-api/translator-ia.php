<?php

function openai_translation($content) {
    // Configura la API key de OpenAI
    $api_key = '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';

    // Obtiene el ID de la publicación actual
    $post_id = get_the_ID();

    // Obtiene el idioma de la publicación actual
    $post_lang = get_post_meta($post_id, 'lang', true);

    // Si el idioma es inglés, no hace falta traducir
    if ($post_lang === 'en') {
        return $content;
    }

    // Texto que quieres traducir
    $text = $content;
    $title = get_the_title($post_id);

    // Parámetros de la llamada a la API
    $data = array(
        "model" => "text-davinci-002",
        "prompt" => "translate from $post_lang to en:\n$title\n$text",
        "temperature" => 0.7,
        "max_tokens" => 60
    );

    // Codifica los datos en formato JSON
    $data_string = json_encode($data);

    // Configura la URL y las opciones de la llamada a la API
    $url = "https://api.openai.com/v1/completions";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    ));

    // Realiza la llamada a la API y obtiene la respuesta
    $response = curl_exec($ch);
    $response_obj = json_decode($response);

    // Si se pudo obtener la traducción, la guarda como metadato de la publicación
    if (!empty($response_obj->choices[0]->text)) {
        // Obtiene el texto generado por el modelo
        $translated_content = $response_obj->choices[0]->text;

        // Verifica si ya existe una publicación con el título traducido
        $translated_title = $response_obj->choices[0]->text;
        $translated_post = get_page_by_title($translated_title, OBJECT, 'post');
        if ($translated_post) {
            // Si la publicación ya existe, actualiza su contenido y título
            $translated_post_id = $translated_post->ID;
            wp_update_post(array(
                'ID' => $translated_post_id,
                'post_content' => $translated_content,
                'post_title' => $translated_title,
            ));
        } else {
            // Si la publicación no existe, la crea
            $post_author = get_the_author_meta('ID');
            $post_status = get_post_status();
            $post_type = get_post_type();
            $destination_blog_id = 2;

            // Cambia al contexto de la red de destino
            switch_to_blog($destination_blog_id);

            $post_args = array(
                'post_title' => $translated_title,
                'post_content'=> $translated_content,
                'post_author' => $post_author,
                'post_status' => $post_status,
                'post_type' => $post_type
            );

            $translated_post_id = wp_insert_post($post_args);

            restore_current_blog();

            // Si se pudo crear la publicación traducida en la otra red, guarda su ID en la publicación original
            if (!empty($translated_post_id)) {
                add_post_meta($post_id, 'translated_post_id', $translated_post_id);
            }
            // Devuelve el contenido original
            return $translated_content;
        
        }}  else {
                // Si no se pudo obtener la traducción, devuelve el contenido original
                return $content;
          }

     }
    
     add_filter('the_content', 'openai_translation');



?>
