<?php

function aw_login_form($attr = array()) {
    // Si el usuario ya está logueado, no mostramos el formulario
    if (is_user_logged_in()) {
        // Redirección después del login exitoso
        return;
    }
    // Preparamos pagina de registro
    $register_page = isset(carbon_get_theme_option('register_page')[0]) ? carbon_get_theme_option('register_page')[0]['id']: null;
    if (!is_user_logged_in() && $register_page) {
        $register_page = parse_url(get_permalink($register_page), PHP_URL_PATH);
    }
    // Estilos del formulario
    $str = '<style>
    .aw_login_form {
        border: 1px solid #707070;
        border-radius: 17px;
        padding: 25px;
        height: max-content;
    }
    .aw-form-header {
        border-bottom: 2px solid #c6cace;
    }
    .aw_login_form input {
        border-radius: 5px;
        padding: 18px;
        font-size: 1.8rem;
    }
    .aw_login_form input[type=submit] {
        padding: 5px;
    }
    .aw_login_form input {
        border: 1px solid var(--blue);
    }
    .aw_login_form .notification {
        color: var(--danger);
        margin-bottom: 15px;
    }
    </style>';

    // Mostrar el formulario de login
    $str .= '
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 mb-5 shortcode-step d-flex justify-content-between">
                <span class="font-weight-bolder text-uppercase text-body" style="border-bottom:2px solid #0558cb;">' . esc_html(get_the_title()) . '</span>
                <i class="fa fa-angle-right font-weight-bolder text-body" aria-hidden="true"></i>
                <span class="font-weight-bolder text-uppercase text-body">Iniciar sesión</span>
            </div>
            <form id="aw_login_form" method="POST" class="aw_login_form col-md-7 col-lg-8" aria-labelledby="login-form-title">
    <div id="notification" style="display: none;"></div>
    <div class="form-row">
        <div class="form-group col-12 aw-form-header">
            <p id="login-form-title" class="font-weight-bolder text-uppercase text-body py-3">Acceso a tu cuenta</p>
        </div>
        <div class="form-group col-12">
            <label for="login-username" class="text-capitalize text-body">Nombre de usuario o correo electrónico</label>
            <input type="text" id="login-username" name="log" class="form-control mt-2" autocomplete="off" required aria-required="true">
        </div>
        <div class="form-group col-12">
            <label for="login-password" class="text-capitalize text-body">Contraseña</label>
            <input type="password" id="login-password" name="pwd" class="form-control mt-2" autocomplete="off" required aria-required="true">
        </div>
        <div class="form-group col-12 my-3">
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="remember-me" name="rememberme" value="forever">
                <label class="form-check-label ml-5" role="button" for="remember-me">Recordarme</label>
            </div>
        </div>
        <div class="form-group col-12">
            '. wp_nonce_field('aw_login_action', 'aw_login_nonce') .'
            <input type="submit" class="btn btn-primary px-5" value="Iniciar sesión" aria-label="Enviar el formulario de inicio de sesión">
        </div>
    </div>
</form>


            <div class="col-md-5 col-lg-4">
                <p class="font-weight-bolder text-uppercase text-body py-3">¿Eres nuevo en Apuestan?</p>
                <p class="text-body">
                    Si no tienes una cuenta, <a href="'.$register_page.'">regístrate aquí</a> para comenzar.
                </p>
            </div>
        </div>
    </div>';

    return $str;
}

// Registrar el shortcode para el formulario de login
add_shortcode('aw-login-form', 'aw_login_form');

// Cargar common.js condicionalmente
function load_js_login() {
    global $post;
    if (isset($post) && is_a($post, 'WP_Post') && (has_shortcode($post->post_content, 'aw-login-form'))) {
        wp_enqueue_script('login-js', get_template_directory_uri() . '/assets/js/forms_fix.js', array(), null, true);
        wp_localize_script('login-js', 'aw_login_params', array( 'ajaxurl' => admin_url('admin-ajax.php') ));
    }
}
add_action('wp_enqueue_scripts', 'load_js_login');

function aw_login_action() {
    // Asegúrate de que se está recibiendo el nonce y acción correctos
    check_ajax_referer('aw_login_action', 'aw_login_nonce');
    
    $credentials = [
        'user_login'    => sanitize_text_field($_POST['log']),
        'user_password' => sanitize_text_field($_POST['pwd']),
        'remember'      => isset($_POST['rememberme']),
    ];
    $user = wp_signon($credentials, is_ssl());
    if (is_wp_error($user)) {
        wp_send_json_error($user->get_error_message());
    } else {
        wp_send_json_success(['redirect_url' => home_url()]);
    }
}
add_action('wp_ajax_nopriv_aw_login_action', 'aw_login_action');

// Remplaza el login page de manera automatica
add_action('login_enqueue_scripts', 'custom_login_redirect');
function custom_login_redirect() {
    $login_page = isset(carbon_get_theme_option('login_page')[0]) ? carbon_get_theme_option('login_page')[0]['id']: null;
    if (!is_user_logged_in() && $login_page) {
        wp_redirect(get_permalink($login_page));
        exit();
    } else {
        return; // Esto permite que se muestre la página de inicio de sesión predeterminada
    }
}
?>