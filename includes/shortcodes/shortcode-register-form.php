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
        $str .='<style>
                    .aw-form{
                        border-radius:10px;
                        padding:20px;
                        border:1px solid black;
                        display:none;
                    }
                    .aw-form form{
                        max-width:400px !important;
                        min-width:250px !important;
                        margin:0 auto;
                        display:grid;
                    }
                    .aw-form form > div:nth-child(4){
                        order:1;
                    }
                    .aw-form .title-form{
                        border-bottom:3px solid #ccc;
                        font-size:3rem;
                        padding: 0 0 20px 0;
                        margin: 0 auto 30px auto;
                        width:90%;
                    }
                    .aw-form label,.aw-form .title-form{
                        color:black;
                    }
                    .aw-form input,.aw-form select,.aw-form .select2-container--default .select2-selection--single{
                        width:100%;
                        padding:10px !important;
                        border-radius:15px !important;
                        display:block;
                        margin:15px auto !important;
                        border:2px solid lightblue !important;
                    }
                    .aw-form .select2-container--default .select2-selection--single{
                        padding: 0 !important;
                        height:45px !important;
                        
                    }
                    .aw-form .select2-selection__rendered{
                        height:45px;
                        line-height:40px !important;
                    }
                    .aw-form .select2-selection__arrow{
                        top:24px !important;
                    }
                    .aw-form input[type="checkbox"]{
                        display:inline !important;
                        width:unset !important;
                    }
                    .ihc-tos-wrap{
                        text-align:left !important;
                        margin-top:30px;
                        order:4;
                    }
                    .ihc-tos-wrap a{
                        margin-left:10px;
                    }
                    .aw-hide-pw{
                        right:1% !important;
                        position:absolute !important;
                        top:20px !important;
                    }
                    .ihc-checkout-page-one-column, .ihc-checkout-page-left-side, .ihc-checkout-page-right-side{
                        display: block !important;
                        min-width: 250px !important;
                        max-width: unset !important;
                        padding: 10px 0 !important;
                        width: 100% !important;
                        box-sizing: border-box;
                        vertical-align: top;
                    }
                    .iump-form-password{
                        position:relative !important;
                    }
            </style>';
        $str .= '<div class="aw-form "><p class="title-form" >Register</p>' . $obj_form->form() . '</div>';
        $str = str_replace('ihc-form-create-edit',"",$str);
        $str = str_replace('iump-form-text',"",$str);
        $str = str_replace('iump-labels-register','',$str);
        $str = str_replace('iump-form-ihc_country',"",$str);
        $str = str_replace('iump-form-checkbox',"",$str);
        $str = str_replace('ihc-strength-wrapper','',$str);
        $str = str_replace('ihc-hide-pw','ihc-hide-pw aw-hide-pw',$str);
        $str = str_replace('ihc-checkout-page-wrap','',$str);
        $str = str_replace('iump-form-line-register ','',$str);
        $str = str_replace('iump-submit-form','',$str);
        
        
        $str .= "<script>
        document.addEventListener('DOMContentLoaded',()=>{
            let inputs = document.querySelectorAll('input')
            let form = document.querySelector('.aw-form')
            if(inputs.length > 0){
                inputs.forEach(input=>{
                    if(input.name === 'user_login'){
                        input.parentNode.remove()
                    }
                })
            }
            if(form){
                form.style.display = 'block'
            }
        })
        </script>";
        return $str;
    }else{
        
      return "<h2>Yá estás registrado</h2>";
    }
}
add_shortcode( 'aw-register-form', 'aw_register_form' );