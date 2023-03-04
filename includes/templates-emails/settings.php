<?php
if(isset($_GET["registred"])){
    update_option( "email-registred", $_GET["registred"]);
    header("location:".$_SERVER["HTTP_REFERER"]);
}
if(isset($_GET["completed"])){
    update_option( "email-completed", $_GET["completed"]);
    header("location:".$_SERVER["HTTP_REFERER"]);
}
if(isset($_GET["pending"])){
    update_option( "email-pending", $_GET["pending"]);
    header("location:".$_SERVER["HTTP_REFERER"]);
}
if(isset($_GET["failed"])){
    update_option( "email-failed", $_GET["failed"]);
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
        'vista_configuracion_emails'
    );
}

/**
 * Display callback for the submenu page.
 */
function vista_configuracion_emails() { 
    $registred = array(
        'teeny' => true,
        'textarea_name' => 'registred'
    );
    $completed = array(
        'teeny' => true,
        'textarea_name' => 'completed'
    );
    $pending = array(
        'teeny' => true,
        'textarea_name' => 'pending'
    );
    $failed = array(
        'teeny' => true,
        'textarea_name' => 'failed'
    );
    
    ?>
    <div class="wrap">
        <h1><?php _e( 'Books Personalización de emails', 'textdomain' ); ?></h1>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form action="">
                        <label for="">Mensaje Reqgistro</label>
                        <div class="card mx-auto">

                            <?php wp_editor( get_option("email-registred"), $registred ); ?>
                        </div>
                        <input type="submit" value="guardar">
                    </form>
                </div>

                <div class="col-md-6">
                    <form action="">
                        <label for="">Mensaje pago completado</label>
                        <div class="card mx-auto">

                            <?php // wp_editor( get_option("email-pago-completed"), $completed ); ?>
                        </div>
                        <input type="submit" value="guardar">
                    </form>
                </div>
                <div class="col-md-6">
                    <form action="">
                        <label for="">Mensaje pago pendiente</label>
                        <div class="card mx-auto">

                            <?php // wp_editor( get_option("email-pago-pending"), $pending ); ?>
                        </div>
                        <input type="submit" value="guardar">
                    </form>
                </div>
                <div class="col-md-6">
                    <form action="">
                        <label for="">Mensaje pago fallido</label>
                        <div class="card mx-auto">

                            <?php // wp_editor( get_option("email-pago-failed"), $failed ); ?>
                        </div>
                        <input type="submit" value="guardar">
                    </form>
                </div>
            </div>
            
        </div>
        <?php echo get_option("email-bienvenida") ?>
    </div>
    <?php
}
add_action( 'admin_menu', 'books_register_ref_page' );