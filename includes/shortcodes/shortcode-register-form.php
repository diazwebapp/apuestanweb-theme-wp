<?php
global $str;
function aw_register_form($attr=array()){
    
	if (!IHCACTIVATEDMODE){
		$str .= ihc_public_notify_trial_version();
	}

	$user_type = ihc_get_user_type();
	if ($user_type=='unreg'){
        ///////ONLY UNREGISTERED CAN SEE THE REGISTER FORM

		if (isset($_GET['ihc_register'])){
			return;
		}
        /// TEMPLATE
        if (!empty($attr['template'])){
            $template = $attr['template'];
        } else {
            $template = get_option('ihc_register_template');
        }
        $showForm = true;
		$showForm = apply_filters( 'ump_show_register_form', $showForm );
        if ( !$showForm ){
                return '';
        }
        /// ROLE
        $shortcodes_attr['role'] = (isset($attr['role'])) ? $attr['role'] : FALSE;
        /// Autologin
        $shortcodes_attr['autologin'] = (isset($attr['autologin'])) ? $attr['autologin'] : FALSE;
        /// Predefined Level
        $shortcodes_attr['level'] = (isset($attr['level'])) ? $attr['level'] : FALSE;
        global $ihc_error_register;
        if (empty($ihc_error_register)){
            $ihc_error_register = array();
        }
        if (!class_exists('UserAddEdit')){
            include_once IHC_PATH . 'classes/UserAddEdit.class.php';
        }
        $args = array(
            'user_id' 					=> false,
            'type' 							=> 'create',
            'tos' 							=> true,
            'captcha' 					=> true,
            'action' 						=> '',
            'register_template' => $template,
            'is_public' 				=> true,
            'print_errors' 			=> $ihc_error_register,
            'shortcodes_attr' 	=> $shortcodes_attr,
            'is_modal'					=> isset($attr['is_modal']) ? $attr['is_modal'] : false,
        );
        $obj_form = new UserAddEdit();
        $obj_form->setVariable($args);//setting the object variables
        
        $str .= '<style>
		#aw-container-register-form{
            display:none;
        }
		
		.form-group input, .input-group-text{font-size:2.5rem ;}
		.card-title{font-size:3.3rem !important;}
		.divider-text {
			position: relative;
			text-align: center;
			margin-top: 15px;
			margin-bottom: 15px;
		}
        .input-group input:focus{
            outline:none !important;
            border:none;
        }
        #payment-field table{
            margin:10px auto;
        }
        .form-group table, .form-group table tbody, .form-group table tbody tr{
            width:100%;
        }
        .form-group table tbody td{
            width:50%;
        }
        .form-group table tbody td#product-name div:first-child, .form-group table tbody td#product-subtotal{
            color:black;
            font-weight:bold;
        }
        .form-group table tbody td#product-subtotal, .form-group table tbody td#product-price{
            text-align:right;
        }
        
         
        .form-group #discount {
            display: grid;
            place-items: center;
            place-content: center;
            grid-template-columns: 1fr 1fr;
        }
        .form-group #discount {
            grid-template-columns: 1fr;
            gap:5px;
        }
		.divider-text span {
			padding: 7px;
			font-size: 12px;
			position: relative;   
			z-index: 2;
		}
		.divider-text:after {
			content: "";
			position: absolute;
			width: 100%;
			border-bottom: 1px solid #ddd;
			top: 55%;
			left: 0;
			z-index: 1;
		}
        .ihc-sm-item{
			width:100%;
		}
        .ihc-register-notice{
            width:100%;
        }


.show {display:block;}
        </style>';
        
        $str .= '<div class="card bg-light"><div id="aw-container-register-form" class="card-body mx-auto">' . $obj_form->form() . '</div></div>';
        $str .= '<template id="temp"><div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h2>                                           
                        <input type="radio" onChange="aw_change_register_payment_method(this)" name="aw-payment-radio"/>
                        <label role="button" ></label>
                    </h2>
                </div>
            </div>
        </template>';

        return $str;
    }else{
        
      return "<h2>Yá estás registrado</h2>";
    }

    
    
}
add_action( 'wp_enqueue_scripts', function(){
    wp_enqueue_script( 'forms-fix', get_template_directory_uri() . '/assets/js/forms_fix.js', [], null, true);
    $data["um_payment_methods"] = ihc_get_active_payments_services();
    $data["rest_api_uri"] = rest_url();
    $data["client_geolocation"] = json_decode(GEOLOCATION);
    
    $data["html"] = "";
    $payment_methods = aw_select_payment_method(false,true);
    $data["pm"] = $payment_methods;
    foreach($payment_methods as $method){
       $accounts = aw_select_payment_account(false,true,$method->id,false);
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
                $data["html"] .= '<h3 class="d-block" >'.$meta->key.'</h3>';
                $data["html"] .= '<div class="input-group mb-3">
                <input type="text" id="'.$meta->id.$meta->key.'" value="'.$meta->value.'" class="form-control" readonly style="outline:none !important;border:none;background:transparent;font-size:1.7rem;">
                <div class="input-group-append">
                  <label class="input-group-text copy" title="copiar al portapapeles" for="'.$meta->id.$meta->key.'" type="button" ><i style="font-size:1.5rem;" class="fa fa-copy"></i></label>
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
    
    wp_add_inline_script( 'forms-fix', 'const php_payment_services='.json_encode($data), 'before' );
});


add_shortcode( 'aw-register-form', 'aw_register_form');
