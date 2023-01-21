<?php
// Obtén el ID de la categoría deseada
$category_id = 13;

// Crea el hook de acción al momento de publicar un post
add_action( 'publish_post', 'publish_post_on_telegram' );

// Función para publicar el post en Telegram
function publish_post_on_telegram( $post_id ) {
    // Obtén la información del post
    $post = get_post( $post_id );

    // Verifica si el post pertenece a la categoría deseada
    if ( has_category( $category_id, $post ) ) {
        // Utiliza la API de Telegram para enviar el mensaje al canal
        // Reemplaza el valor de "YOUR_BOT_TOKEN" con el token de tu bot de Telegram
        // Reemplaza el valor de "YOUR_CHANNEL_ID" con el ID del canal de Telegram al que deseas enviar el post
        $bot_token = "5922480323:AAE8gTO8Z7Mrp-reL75ghiljGK2QI4LKxL8";
        $channel_id = "ApuestanPlus";
        $message = $post->post_title . "\n" . get_permalink( $post );
        file_get_contents("https://api.telegram.org/bot$botbot_token/sendMessage?chat_id=$channel_id&text=$message");
    }
    }
