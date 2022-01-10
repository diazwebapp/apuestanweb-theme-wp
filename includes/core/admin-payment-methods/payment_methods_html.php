<?php
include 'views/add-account.php';
include 'views/table-accounts.php';
function panel_payment_methods(){
    //form payment accounts
    $countries = get_countries_json();
    $query_methods = get_payment_methods();

    

    //table payment methods
    $list_payment_methods = '<nav class="menu-payment-methods">
                                {data}
                            </nav>';
    
    $list_payment_methods_li = "";
    
    if(count($query_methods) > 0):
        for($key =0; $key<count($query_methods); $key++):
            $list_payment_methods_li .= '<button class="'.($key==0?'active method-item':'method-item').'" >'.$query_methods[$key]["name"].'</button>';
        endfor;
    endif;
    $list_payment_methods = str_replace("{data}",$list_payment_methods_li,$list_payment_methods);
    $form_new_account = add_account('pago movil');
    $table_accounts = print_accounts('pago movil');
    $html = '<div id="wpbody-content" >
                <div class="wrap" >
                    <div id="dashboard-widgets-wrap">
                        '.$list_payment_methods.'
                        <div id="dashboard-widgets" class="aw-metabox-holder">
                            <div class="aw-container">
                                <h2>add account</h2>
                                '.$form_new_account.'
                            </div>
                            <div class="aw-container">
                                <h2>Listado de cuentas</h2>
                                <div class="aw-container-table" id="aw-container-table">
                                    '.$table_accounts.'
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
  return $html;
}
add_action( 'admin_enqueue_scripts', function(){

    wp_enqueue_script('admin-js',get_template_directory_uri() . '/assets/js/admin.js');
    wp_enqueue_style('admin-css');
    
    $data = json_encode([
        "rest_url"=>rest_url()]);
    wp_add_inline_script( 'admin-js', 'const php='.$data, 'before' );
} );
?>