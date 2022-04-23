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
        .col-md-7 > .card{
            border-radius:12px;
            overflow-x:hidden;
            padding:1rem 3rem;
        }
        .col-md-7 > .card .card-header{
            background:transparent;
        }
        .col-md-7 > .card > .card-header > .card-title{
            font-size:3rem;
        }
        .col-md-5 .card-title{
            font-size:2.2rem;
        }
        .card-title{
            color:var(--gray-dark);
        }
        .form-control{
            padding:15px;
            border-radius:5px;
        }
        #payment-select .form-control{
            font-size:2.2rem;
        }
    </style>';
   
    $str = '{styles}
            <div class="row mt-5">
                <div class="col-md-7 col-lg-8">
                    <form class="card" method="post" id="checkout-form">
                        <div class="card-header mb-5">
                            <h2 class="card-title">
                                Metodos de pago
                            </h2>
                        </div>                            
                        <input type="hidden" name="lid" value="'.$_GET['lid'].'"/>
                        <div id="payment-select" >
                            {awpayments}
                        </div>

                        <div class="card-body" >
                            <button class="btn btn-primary d-block" disabled>Pagar</button>
                        </div>
                    </div>                        
                </form>
                <div class="col-md-5 col-lg-4" >     
                    <h3 class="card-title">
                        Hazte miembro de apuestan                            
                    </h3>
                    <div class="card-body">
                        '.$paid->short_description.'
                    </div>
                    <div class="card-header">
                        <h3 class="card-title">Orden</h3>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li class="d-flex justify-content-between">
                                <b>'.$paid->label.'</b>
                                <b>'.$currency.' '.ihc_correct_text($paid->price).'</b>
                            </li>
                            <li><hr/></li>
                            <li class="d-flex justify-content-between">
                                <b>Total: </b>
                                <b>'.$currency.' '.ihc_correct_text($paid->price).'</b>
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
                        <div class="card-header" id="heading-'.$account->id.'" >
                            <h2 class="card-title" >
                                <label class="w-100" style="position:relative;" role="button" for="'.$account->id.'" data-toggle="collapse" data-target="#target-'.$account->id.'" aria-expanded="false" aria-controls="target-'.$account->id.'">

                                    <input type="radio" value="'.$account->id.'" id="'.$account->id.'" name="aw-payment-radio"/>

                                    '.$account->payment_method_name.'
                                    
                                    <i style="position:absolute;right:1rem; top:1rem;" class="'.$method->icon_class.'" ></i>
                                </label>
                                </h2>
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
                        $data["html"] .= '<input type="'.$input->type.'" name="'.$input->name.'" account-id="'.$account->id.'" class="form-control mt-2 register-input"/>';
                        $data["html"] .= '</div>';
                    endforeach;
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

	$data['current_user'] = ["user_login"=>$current_user->user_login,"ID"=>$current_user->ID];
	$data = json_encode($data);
    wp_add_inline_script( 'forms-fix', 'const php_payment_services='.$data, 'before' );

});

add_action( 'wp_enqueue_scripts', function(){
	wp_enqueue_script('common-js', get_template_directory_uri() . '/assets/js/common.js', array(), '1.0.0', true);
	
});
add_shortcode( 'aw-checkout-form', 'aw_checkout_form');
