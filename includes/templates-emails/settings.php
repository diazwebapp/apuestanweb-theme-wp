<?php
/**
 * Adds a submenu page under a custom post type parent.
 */
function books_register_ref_page() {
    add_submenu_page(
        'tools.php',
        __( 'emails', 'textdomain' ),
        __( 'Personalización de emails', 'textdomain' ),
        'manage_options',
        '?page=books-shortcode-ref',
        'books_ref_page_callback'
    );
}

/**
 * Display callback for the submenu page.
 */
function books_ref_page_callback() { 
    add_option( "email-text-register", "gracias por registrarte" );
    if(isset($_GET["message"])){
        echo $_GET["message"];
        return ;
    }
    ?>
    <div class="wrap">
        <h1><?php _e( 'Books Personalización de emails', 'textdomain' ); ?></h1>
        <div class="container">
            <div class="card mx-auto">
                <form>
                    <textarea name="message" id="" cols="30" rows="10">

                    </textarea>
                    <input type="button" value="guardar">
                </form>
            </div>
        </div>
        <p><?php echo get_option("email-text-register") ?></p>
    </div>
    <?php
}
add_action( 'admin_menu', 'books_register_ref_page' );