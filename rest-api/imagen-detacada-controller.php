<?php
if(!function_exists('aw_imagen_destacada_controller')):
    function aw_imagen_destacada_controller(WP_REST_Request $request){
        global $wpdb;
        $params = $request->get_json_params();
        $resp = [
            "status" => "ok"
        ];
        $resp["message"] = "imagen destacada creada y aplicada correctamente";
        if(isset( $params["post_id"] ) && isset($params["base64"])):
            $post = get_post($params["post_id"]);
            $base_64 = str_replace("data:image/png;base64,","",$params["base64"]);
            $wp_upload_dir = wp_upload_dir();
            $bin = base64_decode($base_64); //decodificamos
            $size = getImageSizeFromString($bin);
            if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
                $resp["status"] = "error";
                $resp["message"] = 'Base64 value is not a valid image';
                return $resp;
              }
            $im = imagecreatefromstring($bin); //creamos imagen
            $filename = $post->ID.".png"; // le damos nombre
            $ruta = $wp_upload_dir['path'] . "/" .$filename ; // creamos un path
            imagepng($im,$ruta); // generamos la imagen en el disco
            
            $result = true ;//aw_set_imagen_destacada($ruta,$post->ID);
            if(empty($result)):
                $resp["status"] = "error";
                $resp["message"] = "error generando o aplicando la imagen destacada";
            endif;
        else:
            $resp["status"] = "error";
            $resp["message"] = "falta base64 o post_id";
        endif;
        $resp = json_decode(json_encode($resp));
        return $resp;
    }
else:
    echo "la funcion aw_imagen_destacada_controller ya existe";
endif;
function aw_set_imagen_destacada($image_full_path,$parent_post_id){
    $status = true;
    // Check the type of file. We'll use this as the 'post_mime_type'.
    $filetype = wp_check_filetype( basename( $image_full_path ), null );

    // Prepare an array of post data for the attachment.
    $attachment = array(
        'guid'           => $image_full_path, 
        'post_mime_type' => $filetype['type'],
        'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $image_full_path ) ),
        'post_content'   => '',
    );

    // Insert the attachment.
    $attach_id = wp_insert_attachment( $attachment, $image_full_path, $parent_post_id );
    if(is_wp_error(  $attach_id )){
        $status = false;
        return $status;
    }
    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
    require_once( ABSPATH . 'wp-admin/includes/image.php' );

    // Generate the metadata for the attachment, and update the database record.
    $attach_data = wp_generate_attachment_metadata( $attach_id, $image_full_path );
    wp_update_attachment_metadata( $attach_id, $attach_data );

    $apply_thumb = set_post_thumbnail( $parent_post_id, $attach_id );
    if(empty($apply_thumb)){
        $status = false;
        return $status;
    }
    return $status;
}
