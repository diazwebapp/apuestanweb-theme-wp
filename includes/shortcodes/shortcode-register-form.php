<?php

function aw_register_form($attr = array()) {
    // Aquí se elimina todo lo relacionado con las membresías y pagos
    $str = '';

    // Solo permitir que los usuarios no registrados vean el formulario
    if (is_user_logged_in()) {
        wp_safe_redirect(home_url());
        exit;
    }

    // Generación del formulario de registro
    $str .= '<style>
    .aw_register_form {
        border: 1px solid rgb(221, 220, 220);
        border-radius: 17px;
        padding: 25px;
        height: max-content;
        background:#e9e9e9;
    }
        .aw_register_form row{
            background:#fff;
        }
    .aw-form-header {
        border-bottom: 2px solid #c6cace;
    }
    .aw_register_form input, .aw_register_form select {
        border-radius: 5px;
    }
    .aw_register_form input[type=submit] {
        padding: 5px;
    }
    .nice-select, .aw_register_form input, .aw_register_form select {
        border: 1px solid var(--blue);
    }
    .aw_register_form .notification {
        position: absolute;
        top: 2.5em;
        right: 1.3em;
        color: var(--danger);
    }
    </style>';

    // Mostrar el formulario de registro
    $str .= '
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 mb-5 shortcode-step d-flex justify-content-between">
                <span class="font-weight-bolder text-uppercase text-body" style="border-bottom:2px solid #0558cb;">' . esc_html(get_the_title()) . '</span>
                <i class="fa fa-angle-right font-weight-bolder text-body" aria-hidden="true"></i>
                <span class="font-weight-bolder text-uppercase text-body">Registrar cuenta</span>
            </div>
            <form method="POST" class="aw_register_form col-md-7 col-lg-8" aria-labelledby="form-title">
                <div class="form-row">
                    <div class="form-group col-12 aw-form-header">
                        <p id="form-title" class="font-weight-bolder text-uppercase text-body py-3">Crear cuenta</p>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="username" class="text-capitalize text-body">Nombre de usuario</label>
                        <input type="text" id="username" name="username" class="form-control mt-2" autocomplete="off" required aria-required="true">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email" class="text-capitalize text-body">Email</label>
                        <input type="email" id="email" name="email" class="form-control mt-2" autocomplete="off" required aria-required="true">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password" class="text-capitalize text-body">Contraseña</label>
                        <input type="password" id="password" name="password" class="form-control mt-2" autocomplete="off" required aria-required="true">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="country" class="text-capitalize text-body">País</label>
                        <select class="form-control mt-2 wide" name="country" id="country" aria-required="true" required>
                            {country_items}
                        </select>
                    </div>
                    <div class="form-group col-12 my-4">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="tos_check" name="tos" value="1" required aria-required="true">
                            <label class="form-check-label ml-5" role="button" for="tos_check">Aceptar <a href="/tos">términos de servicio</a></label>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <input type="submit" class="btn btn-primary px-5" value="Registrarme" aria-label="Enviar el formulario de registro">
                    </div>
                </div>
            </form>
            <div class="col-md-5 col-lg-4">
                <p class="font-weight-bolder text-uppercase text-body py-3">Conviértete en miembro de Apuestan</p>
                <p class="text-body">
                    Para ser miembro de Apuestan, primero debes completar el registro y aceptar nuestros términos de servicio.
                </p>
            </div>
        </div>
    </div>

    <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0;">
        <div id="toastsRegisterForm" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
            <div class="toast-header">
                <img src="[logo-apuestan]" class="rounded mr-2" alt="Logotipo de Apuestan">
                <strong class="mr-auto">Bootstrap</strong>
                <small>Ahora</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body"></div>
        </div>
    </div>
    ';

    // Lógica para cargar la lista de países
    $countries = get_countries_json(); // Aquí se asume que tienes una función que retorna los países
    $country_items = "";
    foreach ($countries as $key => $country) {
        $country_items .= '<option value="' . esc_attr($country->country_short_name) . '">' . esc_html($country->country_name) . '</option>';
    }
    
    // Reemplazar la plantilla de países en el formulario
    $str = str_replace("{country_items}", $country_items, $str);

    return $str;
}

// Registrar el shortcode
add_shortcode('aw-register-form', 'aw_register_form');

// Cargar common.js condicionalmente
function register_js() {
    global $post;
    if (isset($post) && is_a($post, 'WP_Post') && (has_shortcode($post->post_content, 'aw-register-form'))) {
        wp_enqueue_script('register-js', get_template_directory_uri() . '/assets/js/register_form.js', array(), null, true);
        wp_localize_script('register-js', 'register_form_vars', array( 
            'rest_uri' => rest_url(),
            'nonce' => wp_create_nonce('wp_rest') 
        ));
    }
}
add_action('wp_enqueue_scripts', 'register_js');
?>
