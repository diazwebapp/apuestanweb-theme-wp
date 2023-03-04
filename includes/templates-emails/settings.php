<?php
if(isset($_GET["message"])){
    update_option( "email-bienvenida", $_GET["message"] );
    header("location:".$_SERVER["HTTP_REFERER"]);
}
/**
 * Adds a submenu page under a custom post type parent.
 */
function books_register_ref_page() {
    add_submenu_page(
        'tools.php',
        __( 'emails', 'textdomain' ),
        __( 'Personalización de emails', 'textdomain' ),
        'manage_options',
        'books-shortcode-ref',
        'books_ref_page_callback'
    );
}

/**
 * Display callback for the submenu page.
 */
function books_ref_page_callback() { 
    /* $settings = array(
        'teeny' => true,
        'textarea_rows' => 15,
        'tabindex' => 1
    ); */
    //wp_editor(esc_html( __(get_option('whatever_you_need', 'whatever'))), 'terms_wp_content', $settings);
    ?>
    <div class="wrap">
        <h1><?php _e( 'Books Personalización de emails', 'textdomain' ); ?></h1>
        <div class="container">
            <div class="card mx-auto">
            <textarea class="wp-editor-area" rows="15" tabindex="1" autocomplete="off" cols="40" name="terms_wp_content" id="terms_wp_content" style="display: none;" aria-hidden="true">whatever</textarea>
            </div>
        </div>
        <p><?php echo get_option("email-bienvenida") ?></p>
    </div>
    <?php
}
add_action( 'admin_menu', 'books_register_ref_page' );