<?php
global $str; $wpdb; $paid;

if(isset($_GET['lid'])):
    $lid = $_GET['lid'];
    $table = $wpdb->prefix."ihc_memberships";
    $paid = $wpdb->get_var("SELECT payment_type FROM $table WHERE id=$lid");
endif;


function aw_checkout_form($attr=array()){
    global $paid,$str;

	$user_type = ihc_get_user_type();
	if ($user_type=='unreg'){
        ///////ONLY UNREGISTERED CAN SEE THE REGISTER FORM

        /// ROLE LEVL DETECTION
        $shortcodes_attr['role'] = (isset($attr['role'])) ? $attr['role'] : FALSE;
        /// Autologin
        $shortcodes_attr['autologin'] = (isset($attr['autologin'])) ? $attr['autologin'] : FALSE;
        // MAQUETAR HTML IGUAL AL DISEÑO DE ADOBE XD
        // IMPLEMETAR COMPROBACIONES DE INPUTS HTML5 Y JS NECESARIOS
        // APLICAR LA MEMBRESÍA MANUALMENTE, COPIANDO PARTE DELCODIGO QUE SE USÓ PARA ACUALIZAR O ACTIVAR MEMBRESIAS CON EL ANTERIOR ENFOQUE
        // SI LA MEMBRESIA NÓ ES DE PAGA LLEVAR A LA PAGINA DE GRACIAS, SI NÓ LLEVAR AL 
        
        //////////// STYLES CSS ///////////
        $str .= '<style>
        .aw_checkout_form input{
            border-radius:5px;
            padding:18px;
            font-size:1.8rem;
        }
        .aw_checkout_form input[type=submit]{
            padding:10px;
        }
        .nice-select, .aw_checkout_form input{
            border:1px solid var(--blue);
        }
        .aw_checkout_form label, .aw_checkout_form h2{
            color:var(--gray-dark);
        }
        </style>';
        $str .= '
        <div class="container">
            <form method="post" class="aw_checkout_form">
                <div class="form-row">
                    <div class="form-group col-12">
                        <h2>Crear cuenta</h2>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Username</label>
                        <input type="text" name="username" class="form-control mt-2" required autocomplete="false">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">email</label>
                        <input type="email" name="email" class="form-control mt-2" required autocomplete="false">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">password</label>
                        <input type="password" name="password" class="form-control mt-2" required autocomplete="false">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Country</label></br>
                        <select class="form-control mt-2 wide" name="country" id="search_select" required>
                            {country_items}
                        </select>
                    </div>
                    <div class="form-group col-12">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="tos_check" required>
                            <label class="form-check-label ml-4" role="button" for="tos_check">Check me out</label>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <input type="submit" class="btn btn-primary" disabled value="Register" name="create_user">
                    </div>
                </div>
            </form>
        </div>
        ';
        $countries = get_countries_json();
        $country_items = "";
        foreach($countries as $country):
            $country_items .= '<option value="'.$country->country_short_name.'" >'.$country->country_name.'</option>';
        endforeach;
        $str = str_replace("{country_items}",$country_items,$str);
        return $str;
    }    
}

add_action( 'wp_enqueue_scripts', function(){
    global $paid;
    wp_enqueue_script( 'forms-fix', get_template_directory_uri() . '/assets/js/forms_fix.js', [], null, true);
    
    $data["rest_api_uri"] = rest_url();
    $data["client_geolocation"] = json_decode(GEOLOCATION);
    if($paid !== "free"):
        $data["um_payment_methods"] = ihc_get_active_payments_services();
        $data["html"] = "";
        $payment_methods = aw_select_payment_method(false,1);
        $data["pm"] = $payment_methods;
        foreach($payment_methods as $method){
        $accounts = aw_select_payment_account(false,1,$method->id,false);
        $register_inputs = aw_select_payment_method_register_inputs($method->id);
        if(count($accounts) > 0):
            //recorremos todas las cuentas
            foreach($accounts as $account):
                $account_metas = aw_select_payment_account_metas($account->id);
                $data["html"] .= '<div class="card">
                    <div class="card-header d-flex justify-content-between" id="heading-'.$account->id.'" >
                        <h2>
                            <input type="radio" onChange="aw_change_register_payment_method(this)" data-method="'.$account->payment_method_name.'" value="'.$account->id.'" id="'.$account->id.'" name="aw-payment-radio"/>
                            <label role="button" for="'.$account->id.'" data-toggle="collapse" data-target="#target-'.$account->id.'" aria-expanded="false" aria-controls="target-'.$account->id.'">
                                '.$account->payment_method_name.'
                            </label>
                            </h2>
                        <i class="'.$method->icon_class.'" ></i>
                    </div>
                
                    <div id="target-'.$account->id.'" class="collapse" aria-labelledby="heading-'.$account->id.'" data-parent="#payment-select">
                        <div class="card-body">';
                //recorremos los metas 
                foreach($account_metas as $meta):
                    $data["html"] .= '<h3 class="d-block" >'.$meta->meta_key.'</h3>';
                    $data["html"] .= '<div class="input-group mb-3">
                    <input type="text" id="'.$meta->id.$meta->meta_key.'" value="'.$meta->meta_value.'" class="form-control" readonly style="outline:none !important;border:none;background:transparent;font-size:1.7rem;">
                    <div class="input-group-append">
                    <label class="input-group-text copy" title="copiar al portapapeles" for="'.$meta->id.$meta->meta_key.'" type="button" ><i style="font-size:1.5rem;" class="fa fa-copy"></i></label>
                    </div>
                </div>';
                endforeach;
                //recorremos todos los inputs para que el cliente registre su pago
                foreach($register_inputs as $input):
                    $data["html"] .= '<div class="form-group">';
                    $data["html"] .= '<label>'.$input->name.'</label>';
                    $data["html"] .= '<input type="'.$input->type.'" data-method="'.$account->id.'" name="'.$input->name.'" class="form-control"/>';
                    $data["html"] .= '</div>';
                endforeach;
                $data["html"] .= '</div>'; //cerramos card body
                $data["html"] .= '</div>'; //cerramos div collapse
                $data["html"] .= '</div>'; //cerramos card
            endforeach;
        endif;
        }
    endif;
    
    wp_add_inline_script( 'forms-fix', 'const php_payment_services='.json_encode($data), 'before' );

});


add_shortcode( 'aw-checkout-form', 'aw_checkout_form');
