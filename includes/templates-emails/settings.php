<?php
if(isset($_GET["registred"])){
    update_option( "email-pago-registred", $_GET["registred"]);
    header("location:".$_SERVER["HTTP_REFERER"]);
}
if(isset($_GET["completed"])){
    update_option( "email-pago-completed", $_GET["completed"]);
    header("location:".$_SERVER["HTTP_REFERER"]);
}
if(isset($_GET["pending"])){
    update_option( "email-pago-pending", $_GET["pending"]);
    header("location:".$_SERVER["HTTP_REFERER"]);
}
if(isset($_GET["failed"])){
    update_option( "email-pago-failed", $_GET["failed"]);
    header("location:".$_SERVER["HTTP_REFERER"]);
}
/**
 * Adds a submenu page under a custom post type parent.
 */
function books_register_ref_page() {
    add_submenu_page(
        'options-general.php',
        __( 'emails', 'jbeting' ),
        __( 'emails messages', 'jbeting' ),
        'manage_options',
        'emails-message-admin',
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
        <div class="container">
            <div class="row">
                <div class="col-12 my-5">
                    <h1>Administracion de plantillas emails</h1>
                    <h2>Variables a reemplazar</h2>
                    {year} -  {blogname} - {username} - {blogurl} - {admin_email}
                </div>
                <div class="col-md-6">
                    <form>
                        <h2>Mensaje Reqgistro</h2>
                        <div class="form-group">

                            <?php wp_editor( get_option("email-registred"),"email", $registred ); ?>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary mb-2" type="submit" value="guardar">
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <form>
                        <h2>Mensaje pago completado</h2>
                        <div class="form-group">

                            <?php wp_editor( get_option("email-pago-completed"),"email2", $completed ); ?>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary mb-2" type="submit" value="guardar">
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <form>
                        <h2>Mensaje pago pendiente</h2>
                        <div class="form-group">

                            <?php wp_editor( get_option("email-pago-pending"),"email3", $pending ); ?>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary mb-2" type="submit" value="guardar">
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <form>
                        <h2>Mensaje pago fallido</h2>
                        <div class="form-group">

                            <?php wp_editor( get_option("email-pago-failed"),"email4", $failed ); ?>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary mb-2" type="submit" value="guardar">
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
        
    </div>
    <?php
}
add_action( 'admin_menu', 'books_register_ref_page' );