<?php
global $str; $wpdb; $paid;

if(isset($_GET['lid'])):
    $lid = $_GET['lid'];
    $table = $wpdb->prefix."ihc_memberships";
    $paid = $wpdb->get_row("SELECT payment_type,short_description, label, price FROM $table WHERE id=$lid");
endif;

function aw_checkout_form($attr=array()){
    global $paid,$str;$currency;
    $currency = !empty(get_option( 'ihc_custom_currency_code', true )) ? get_option( 'ihc_custom_currency_code', true ) : get_option( 'ihc_currency', true );
    $data = [];
    
	$data['css'] = '<style>
        #checkout-form{
            border:1px solid #707070;
            border-radius:17px;
            padding:25px;
            height: max-content;
        }
        #checkout-form .aw-form-header{
            border-bottom:2px solid  #c6cace;
        }
        .form-control{
            border-radius:5px;
        }
        #payment-select .form-control{
            font-size:2.2rem;
        }
    </style>';
   
    $str = '{styles}
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 mb-5 shortcode-step d-flex justify-content-between">
                <span class="font-weight-bolder text-uppercase text-body">'.get_the_title(get_option('ihc_general_register_default_page')).'</span>
                <i class="fa fa-angle-right font-weight-bolder text-body"></i>
                <span class="font-weight-bolder text-uppercase text-body" style="border-bottom:2px solid #0558cb;">'.get_the_title().'</span>
                <i class="fa fa-angle-right font-weight-bolder text-body"></i>
                <span class="font-weight-bolder text-uppercase text-body">'.get_the_title(get_option('ihc_thank_you_page')).'</span>
            </div>
            <div class="col-md-7 col-lg-8">
                <form method="post" id="checkout-form">
                    <div class="aw-form-header mb-5">
                        <p class="font-weight-bolder text-uppercase text-body py-3" id="paypal-checkout">
                            Metodos de pago '.$_SESSION["checkout_action"].'
                        </p>
                    </div>                            
                    <input type="hidden" name="lid" value="'.$_GET['lid'].'"/>
                    <div class="labelcol" id="payment-select" >
                        {awpayments}
                    </div>

                    <div class="card-body" >
                        <button style="font-size:1.8rem" class="btn btn-primary d-block px-5" disabled>Pagar</button>
                    </div>                       
                </form>
            </div>
            <div class="col-md-5 col-lg-4" >     
                <p class="font-weight-bolder text-uppercase text-body py-3">
                    Hazte miembro de apuestan                            
                </p>
                <div class="card-body">
                    <p class="text-body">
                        '.$paid->short_description.'
                    </p>
                </div>
                <div class="aw-form-header">
                    <p class="font-weight-bolder text-uppercase text-body py-3">Orden</p>
                </div>
                
                <ul>
                    <li class="d-flex justify-content-between">
                        <b class="font-weight-bolder text-capitalize text-body">'.$paid->label.'</b>
                        <b class="font-weight-bolder text-capitalize text-body">'.$currency.' '.ihc_correct_text($paid->price).'</b>
                    </li>
                    <li><hr/></li>
                    <li class="d-flex justify-content-between">
                        <b class="font-weight-bolder text-capitalize text-body">Total: </b>
                        <b class="font-weight-bolder text-capitalize text-body">'.$currency.' '.ihc_correct_text($paid->price).'</b>
                    </li>
                </ul>                  
            </div>
        </div>
    </div>
    ';

    if($paid->payment_type == "payment"):
        //$data["um_payment_methods"] = ihc_get_active_payments_services();
        $data["html"] = "";
        $payment_methods = aw_select_payment_method(false,1);
        //$data["pm"] = $payment_methods;
        foreach($payment_methods as $method){
            $accounts = aw_select_payment_account(false,1,$method->id,false);
            $register_inputs = aw_select_payment_method_register_inputs($method->id);
            if(count($accounts) > 0):
                //recorremos todas las cuentas
                foreach($accounts as $account):
                    $account_metas = aw_select_payment_account_metas($account->id);
                    $data["html"] .= '<div>
                        <div class="aw-form-header py-3" id="heading-'.$account->id.'" >
                            <h2 class="text-body" >
                                <label class="w-100 text-capitalize" style="position:relative;" role="button" for="'.$account->id.'" data-toggle="collapse" data-target="#target-'.$account->id.'" aria-expanded="false" aria-controls="target-'.$account->id.'">
                                    <input type="radio" value="'.$account->id.'" id="'.$account->id.'" data-method="'.$account->payment_method_name.'" name="aw-payment-radio"/>
                                    '.$account->payment_method_name.'                                    
                                    <i style="position:absolute;right:1rem; top:1rem;" class="'.$method->icon_class.'" ></i>
                                </label>
                                </h2>
                        </div>
                    
                        <div id="target-'.$account->id.'" class="collapse" aria-labelledby="heading-'.$account->id.'" data-parent="#payment-select">
                            <div class="card-body">';
                    if(strtolower($account->payment_method_name) !== 'paypal'):
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
                            $data["html"] .= '<div class="form-group font-weight-bold">';
                            $data["html"] .= '<label>'.$input->name.'</label>';
                            $data["html"] .= '<input type="'.$input->type.'" name="'.$input->name.'" account-id="'.$account->id.'" class="form-control mt-2 register-input"/>';
                            $data["html"] .= '</div>';
                        endforeach;
                    endif;
                    $data["html"] .= '</div>'; //cerramos card body
                    $data["html"] .= '</div>'; //cerramos div collapse
                    $data["html"] .= '</div>'; //cerramos card
                endforeach;
            endif;
        }
    endif;
        
    if($paid->payment_type == 'free'):
        $data['html'] = "?????????";
    endif;
    $str = str_replace("{awpayments}",$data['html'],$str);
    $str = str_replace("{styles}",$data['css'],$str);

    return $str;  
}

add_action( 'wp_enqueue_scripts', function(){
    global $paid;
    wp_enqueue_script( 'forms-fix', get_template_directory_uri() . '/assets/js/forms_fix.js', [], null, true);
    
    $data["rest_api_uri"] = rest_url();
    
    $current_user = wp_get_current_user(  );

	$_SESSION["current_user"] = ["user_login"=>$current_user->user_login,"ID"=>$current_user->ID];
    $data["current_user_id"] = $_SESSION["current_user"]['ID'];
	$data = json_encode($data);
    wp_add_inline_script( 'forms-fix', 'const php_payment_services='.$data, 'before' );

});

add_action( 'wp_enqueue_scripts', function(){
	wp_enqueue_script('common-js', get_template_directory_uri() . '/assets/js/common.js', array(), '1.0.0', true);
	
});
add_shortcode( 'aw-checkout-form', 'aw_checkout_form');
