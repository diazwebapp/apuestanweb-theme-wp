<?php
add_action( 'wp_print_styles', function(){
    wp_deregister_style( 'nice_select' );
}, 100 );
add_action( 'wp_print_scripts', function(){
    wp_deregister_script( 'plugins' );
}, 100 );


function aw_register_form($attr=array()){
    
        $html = '<div class="container" >
                    <form class="aw-form">
                        <p class="title-form" >Register</p>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputName">Nombre</label>
                                <input type="text" class="form-control" id="inputName" placeholder="Nombre" />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputApellido">Apellido</label>
                                <input type="text" class="form-control" id="inputApellido" placeholder="Apellido" />
                            </div>
    
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Email</label>
                                <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                            </div>
    
                            <div class="form-group col-md-6">
                                <label for="inlineFormCustomSelectPref">Preference</label><br/>
                                <select id="inlineFormCustomSelectPref">
                                    <option selected>Choose...</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Password</label>
                                <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Password</label>
                                <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                            </div>
    
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label" for="gridCheck">
                                        Check me out
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>';
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
                        padding:30px;
                        border:1px solid black;
                    }
                    .aw-form .title-form{
                        border-bottom:3px solid #ccc;
                        font-size:3rem;
                        margin-bottom:20px;
                    }
                    .aw-form label{
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
                        padding:0px !important;
                    }
                    .aw-form input[type="checkbox"]{
                        display:inline !important;
                        width:unset !important;
                    }
                    .ihc-tos-wrap{
                        text-align:left !important;
                    }
                    .ihc-tos-wrap a{
                        margin-left:10px;
                    }
                    .aw-hide-pw{
                        right:3%;
                        position:absolute;
                        top:55px;
                    }
            </style>';
        $str .= '<div class="aw-form "><p class="title-form" >Register</p>' . $obj_form->form() . '</div>';
        $str = str_replace('ihc-form-create-edit',"form-row",$str);
        $str = str_replace('iump-form-text',"form-group col-md-6",$str);
        $str = str_replace('iump-labels-register','',$str);
        $str = str_replace('iump-form-password',"form-group col-md-6",$str);
        $str = str_replace('iump-form-ihc_country',"form-group col-md-6",$str);
        $str = str_replace('iump-form-checkbox',"form-group col-md-6",$str);
        $str = str_replace('ihc-strength-wrapper','',$str);
        $str = str_replace('ihc-hide-pw','aw-hide-pw',$str);
        $str = str_replace('<div class="iump-form-line-register iump-form-upload_image"','<div style="display:none;"',$str);
        
        return $str;
    }else{
        
      return "<h2>Yá estás registrado</h2>";
    }
}
add_shortcode( 'aw-register-form', 'aw_register_form' );