<?php


function publish_normal_post_on_telegram( $post_id ) {
    error_log('publish_normal_post_on_telegram was called');
    $post = get_post( $post_id );

    // Solo envía una notificación si el post es publicado y no se está actualizando
		if ( $post->post_status == 'publish' && get_post_meta( $post_id, '_publish_notification_sent', true ) != '1' ) {
			if ( $post->post_type == 'post' ) {
				$image_id = get_post_thumbnail_id($post_id);
				if ( $image_id ) {
					$image_url = wp_get_attachment_url($image_id);
                    $bot_token = $_ENV['BOT_TOKEN'];
					$channel_id = $_ENV['CHANNEL_ID'];
					$message = urlencode('Título: ' . $post->post_title . "\n" .
					'Link: [Ver publicacion](' . get_permalink($post) . ')' . "\n" .
					'Siguenos en nuestras redes: ' . "\n" .
					'[Instagram]('.esc_url("https://www.instagram.com/apuestan") . ") - " .
					'[Twitter]('.esc_url("https://www.twitter.com/apuestan") . ") - " .
					'[Facebook]('.esc_url("https://www.facebook.com/apuestan") . ")"
					);
          
					file_get_contents("https://api.telegram.org/bot$bot_token/sendPhoto?chat_id=$channel_id&photo=$image_url&caption=$message&parse_mode=Markdown"); 
					error_log('Image ID: ' . $image_id);
					error_log('Image URL: ' . $image_url);
					update_post_meta( $post_id, '_publish_notification_sent', '1' );
				} 
			}
		}
	}
add_action( 'publish_post', 'publish_normal_post_on_telegram' );

function publish_forecast_on_telegram( $post_id ) {

    	$post = get_post($post_id);

    // Solo envía una notificación si el post es publicado y no se está actualizando
    if ( $post->post_status == 'publish' && get_post_meta( $post_id, '_publish_notification_sent', true ) != '1' ) {

        // Verifica si el post es del tipo forecast
        if ( $post->post_type == 'forecast' ) {
			
			error_log($post_id);

            // Verifica si el post tiene la categoría VIP
			$terms = get_the_terms( $post_id, 'league' );
			error_log( 'Terms: ' . print_r( $terms, true ) );
			
			$is_vip = false;

			if ( $terms ) {
				error_log( 'Terms2: ' . print_r( $terms, true ) );

				foreach ( $terms as $term ) {
					if ( $term->term_id == 12 ) {
						$is_vip = true;
					break;
					}
				}
			

                if ( $is_vip ) {
                    // Si pertenece a la categoría VIP, envía al canal VIP
                    $bot_tokenvip = $_ENV['BOT_TOKENVIP'];
                    $channel_idvip = $_ENV['CHANNEL_IDVIP'];
					
					if ( has_post_thumbnail( $post_id ) ) {
					$image_url = get_the_post_thumbnail_url( $post_id ); // Obtiene la URL de la imagen destacada
                    $messagevip = urlencode('Nueva publicación: ' . $post->post_title . "\n" .
											'Link: [Ver prediccion](' . esc_url("https://www.apuestan.com/plus/picks/") . ')' . "\n" .
											'Siguenos en nuestras redes: ' . "\n" .
											'[Instagram]('.esc_url("https://www.instagram.com/apuestan") . ") - " .
											'[Twitter]('.esc_url("https://www.twitter.com/apuestan") . ") - " .
											'[Facebook]('.esc_url("https://www.facebook.com/apuestan") . ")"
										   
										   );
					} 
					file_get_contents("https://api.telegram.org/bot$bot_tokenvip/sendPhoto?chat_id=$channel_idvip&photo=$image_url&caption=$messagevip&parse_mode=Markdown"); 

					update_post_meta( $post_id, '_publish_notification_sent', '1' );

                } else {
					// Si no pertenece a la categoría VIP, envía al canal normal
                    $bot_token = $_ENV['BOT_TOKEN'];
					$channel_id = $_ENV['CHANNEL_ID'];
					if ( has_post_thumbnail( $post_id ) ) {
					$image_url = get_the_post_thumbnail_url( $post_id ); // Obtiene la URL de la imagen destacada
					$message = urlencode('Título: ' . $post->post_title . "\n" .
					'Link: [Ver prediccion](' . get_permalink($post) . ')' . "\n" .
					'Siguenos en nuestras redes: ' . "\n" .
					'[Instagram]('.esc_url("https://www.instagram.com/apuestan") . ") - " .
					'[Twitter]('.esc_url("https://www.twitter.com/apuestan") . ") - " .
					'[Facebook]('.esc_url("https://www.facebook.com/apuestan") . ")"
					);
					file_get_contents("https://api.telegram.org/bot$bot_token/sendPhoto?chat_id=$channel_id&photo=$image_url&caption=$message&parse_mode=Markdown"); 
					update_post_meta( $post_id, '_publish_notification_sent', '1' );	
					}
 			
					}
			}	
        }
    }
}
add_action( 'publish_forecast', 'publish_forecast_on_telegram' );
