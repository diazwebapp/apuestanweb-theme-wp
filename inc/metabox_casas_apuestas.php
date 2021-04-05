<?php 
add_meta_box(
	'meta_casa_apuesta',
	'Datos casa apuesta',
	'func_casa_apuesta',
	'casaapuesta',
	'normal',
	'high'
);

function func_casa_apuesta($post){ 
    wp_nonce_field( 'grabar_meta', 'casaapuesta_nonce' ); 
    $slogan = get_post_meta($post->ID,'slogan_casa_apuesta')[0];
    $puntuacion = get_post_meta($post->ID,'puntuacion_casa_apuesta')[0];
    $tiempo_pago = get_post_meta($post->ID,'tiempo_pago_casa_apuesta')[0];
    $url_logo = get_post_meta($post->ID,'url_logo_casa_apuesta')[0];

    $metodo_pago_1= get_post_meta($post->ID,'m_p_icon_1')[0];
    $metodo_pago_2= get_post_meta($post->ID,'m_p_icon_2')[0];
    $metodo_pago_3= get_post_meta($post->ID,'m_p_icon_3')[0];
    $metodo_pago_4= get_post_meta($post->ID,'m_p_icon_4')[0]; ?>
    <style>
    .adm_meta_ca > div{
        margin:0 5px;
        width:250px;
        display:grid;
        grid-template-columns:1fr;
    }
    .adm_meta_ca > .upload_img{
        width:130px;
        overflow:hidden;
    }
    .adm_meta_ca > div > *{
        width:90%;
    }
    .adm_meta_ca > div > button{
        background:blue;
    }
    </style>
	<div class="adm_meta_ca" style="display:flex;flex-flow:row wrap;align-items:flex-start;align-content:flex-start;" >
        <div class="upload_img" >
            <button id="btn_lca">Subir logo</button>
            <img width="80px" height="80px" style="object-fit:cover;" id="prev_img" />
            <input type="hidden" name="url_logo_casa_apuesta" id="url_logo_casa_apuesta">
        </div>

        <div class="upload_img">
            <button id="m_p_icon_1">m. Pago 1</button>
            <img width="80px" height="80px" style="object-fit:cover;" id="prev_img_m_p_icon_1" src="<?php echo $metodo_pago_1 ?>"/>
            <input type="hidden" name="m_p_icon_1" id="url_m_p_icon_1" value="<?php echo $metodo_pago_1 ?>">
        </div>
        <div class="upload_img">
            <button id="m_p_icon_2">m. Pago 2</button>
            <img width="80px" height="80px" style="object-fit:cover;" id="prev_img_m_p_icon_2" src="<?php echo $metodo_pago_2 ?>"/>
            <input type="hidden" name="m_p_icon_2" id="url_m_p_icon_2" value="<?php echo $metodo_pago_2 ?>">
        </div>
        <div class="upload_img">
            <button id="m_p_icon_3">m. Pago 3</button>
            <img width="80px" height="80px" style="object-fit:cover;" src="<?php echo $metodo_pago_3 ?>" id="prev_img_m_p_icon_3" />
            <input type="hidden" name="m_p_icon_3" id="url_m_p_icon_3" value="<?php echo $metodo_pago_3 ?>">
        </div>
        <div class="upload_img">
            <button id="m_p_icon_4">m. Pago 4</button>
            <img width="80px" height="80px" style="object-fit:cover;" src="<?php echo $metodo_pago_4 ?>" id="prev_img_m_p_icon_4" />
            <input type="hidden" name="m_p_icon_4" value="<?php echo $metodo_pago_4 ?>" id="url_m_p_icon_4">
        </div>

        <div >
            <label for="puntuacion_casa_apuesta">Puntuación:</label>
            <input type="number" steep="any" name="puntuacion_casa_apuesta" id="puntuacion_casa_apuesta" value="<?php echo $puntuacion ?>">
        </div>

        <div >
            <label for="slogan_casa_apuesta">Slogan:</label>
            <input type="text" name="slogan_casa_apuesta" id="slogan_casa_apuesta" value="<?php echo $url_logo  ?>" >
        </div>

        <div >
            <label for="tiempo_pago_casa_apuesta">Pago en:</label>
            <input type="number" name="tiempo_pago_casa_apuesta" id="tiempo_pago_casa_apuesta" value="<?php echo esc_attr( $tiempo_pago) ?>" >
        </div>
    </div>
<?php } 
//cargando el js
function aw_admin(){
    wp_enqueue_media();
    wp_register_script( 'theme_scripts', get_template_directory_uri(). '/assets/js/scripts_admin.js');
		wp_enqueue_script( 'theme_scripts' );
}

// Enqueu script
add_action("admin_enqueue_scripts", "aw_admin");

//guardando datos de los meta
/**
 * Graba los campos personalizados que vienen del formulario de edición del post
 *
 * @param int $post_id Post ID.
 *
 * @return bool|int
 */
function ca_save_meta_boxes( $post_id ) {
	// Comprueba que el tipo de post es pronostico.
	if ( isset( $_POST ) && 'casaapuesta' !== $_POST['post_type'] ) {
		return $post_id;
	}
	// Comprueba que el usuario actual tiene permiso para editar esto
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		wp_die(
			'<h1>' . __( 'Necesitas más privilegios para publicar contenidos.', 'apuestanweb-lang' ) . '</h1>' .
			'<p>' . __( 'Lo siento, no puedes crear contenidos desde esta cuenta.', 'apuestanweb-lang' ) . '</p>',
			403
		);
	}
	// Ahora puedes grabar los datos

    // 1- logo
	$url_logo_casa_apuesta = sanitize_post( $_POST['url_logo_casa_apuesta'] );
	update_post_meta( $post_id, 'url_logo_casa_apuesta', $url_logo_casa_apuesta );

    // 2- puntuacion
	$puntuacion_casa_apuesta = sanitize_post( $_POST['puntuacion_casa_apuesta'] );
	update_post_meta( $post_id, 'puntuacion_casa_apuesta', $puntuacion_casa_apuesta );

    // 3- slogan
	$slogan_casa_apuesta = sanitize_post( $_POST['slogan_casa_apuesta'] );
	update_post_meta( $post_id, 'slogan_casa_apuesta', $slogan_casa_apuesta );

    // 4- tiempo de pago
	$tiempo_pago_casa_apuesta = sanitize_post( $_POST['tiempo_pago_casa_apuesta'] );
	update_post_meta( $post_id, 'tiempo_pago_casa_apuesta', $tiempo_pago_casa_apuesta );

    // 5- metodo de pago 1
	$m_p_icon_1 = sanitize_post( $_POST['m_p_icon_1'] );
	update_post_meta( $post_id, 'm_p_icon_1', $m_p_icon_1 );

    // 6- metodo de pago 2
	$m_p_icon_2 = sanitize_post( $_POST['m_p_icon_2'] );
	update_post_meta( $post_id, 'm_p_icon_2', $m_p_icon_2 );

    // 7- metodo de pago 3
	$m_p_icon_3 = sanitize_post( $_POST['m_p_icon_3'] );
	update_post_meta( $post_id, 'm_p_icon_3', $m_p_icon_3 );

    // 8- metodo de pago 4
	$m_p_icon_4 = sanitize_post( $_POST['m_p_icon_4'] );
	update_post_meta( $post_id, 'm_p_icon_4', $m_p_icon_4 );
    return true;
}
add_action( 'save_post', 'ca_save_meta_boxes' );