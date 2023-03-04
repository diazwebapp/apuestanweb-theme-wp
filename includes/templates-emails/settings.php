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
                    <form class="form-group">
                        <h2>Mensaje Reqgistro</h2>
                        <div class="card mx-auto">

                            <?php wp_editor( get_option("email-registred"),"email", $registred ); ?>
                        </div>
                        <input class="btn btn-primary mb-2" type="submit" value="guardar">
                    </form>
                </div>

                <div class="col-md-6">
                    <form class="form-group">
                        <h2>Mensaje pago completado</h2>
                        <div class="card mx-auto">

                            <?php wp_editor( get_option("email-pago-completed"),"email2", $completed ); ?>
                        </div>
                        <input class="btn btn-primary mb-2" type="submit" value="guardar">
                    </form>
                </div>
                <div class="col-md-6">
                    <form class="form-group">
                        <h2>Mensaje pago pendiente</h2>
                        <div class="card mx-auto">

                            <?php wp_editor( get_option("email-pago-pending"),"email3", $pending ); ?>
                        </div>
                        <input class="btn btn-primary mb-2" type="submit" value="guardar">
                    </form>
                </div>
                <div class="col-md-6">
                    <form class="form-group">
                        <h2>Mensaje pago fallido</h2>
                        <div class="card mx-auto">

                            <?php wp_editor( get_option("email-pago-failed"),"email4", $failed ); ?>
                        </div>
                        <input class="btn btn-primary mb-2" type="submit" value="guardar">
                    </form>
                </div>
            </div>
            
        </div>
        
    </div>
    <?php
}
add_action( 'admin_menu', 'books_register_ref_page' );