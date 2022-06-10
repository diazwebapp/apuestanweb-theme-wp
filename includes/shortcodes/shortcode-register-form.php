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
		
		.form-group input, .input-group-text{font-size:2.5rem !important;}
		.card-title{font-size:3.3rem !important;}
		.divider-text {
			position: relative;
			text-align: center;
			margin-top: 15px;
			margin-bottom: 15px;
		}
        #payment-field div, #payment-field table{
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
        </style>';
        
        $str .= '<div class="card bg-light"><div id="aw-container-register-form" class="card-body mx-auto">' . $obj_form->form() . '</div></div>';
        $str .= '<template id="temp"><li class="list-group-item d-flex justify-content-between align-items-center">
            <input type="radio" style="display:inline-block !important;" onChange="aw_change_register_payment_method(this)"/>
            <label role="button"></label>
        </li>
        </template>

        <template id="aw-temp"><li class="list-group-item list-group-item-action flex-column align-items-start">
            <input type="radio" style="display:inline-block !important;" onChange="aw_change_register_payment_method(this)"/>
            <label data-toggle="collapse" role="button" aria-expanded="false" style="width:calc(100% - 20px);display:inline-block;text-align:right;" ></label>
            <div class="collapse method_data list-group w-100" ></div>
        </li></template>';
        //data-toggle="collapse" role="button" aria-expanded="false"
        return $str;
    }else{
        
      return "<h2>Yá estás registrado</h2>";
    }

    
    
}
add_action( 'wp_enqueue_scripts', function(){
        wp_enqueue_script( 'forms-fix', get_template_directory_uri() . '/assets/js/forms_fix.js', [], null, true);

        $data["um_payment_methods"] = ihc_get_active_payments_services();
        $data["rest_api_uri"] = rest_url();
        wp_add_inline_script( 'forms-fix', 'const php_payment_services='.json_encode($data), 'before' );
    });


add_shortcode( 'aw-register-form', 'aw_register_form');
