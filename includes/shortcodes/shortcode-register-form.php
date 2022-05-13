<?php

function aw_register_form($attr=array()){
    $str = '';

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
        
        $str .= '<div id="aw-container-register-form" class="card bg-light"><h4 class="card-title" >Register</h4><div class="card-body mx-auto">' . $obj_form->form() . '</div></div>';
        wp_enqueue_script('js_forms', get_template_directory_uri() . '/assets/js/forms_fix.js', array(), null, true);
        return $str;
    }else{
        
      return "<h2>Yá estás registrado</h2>";
    }
}
add_shortcode( 'aw-register-form', 'aw_register_form' );