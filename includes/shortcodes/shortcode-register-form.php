<?php
global $str; $wpdb; $register_membership_payment_type;

if(isset($_GET['lid'])):
    $lid = $_GET['lid'];
    $table = $wpdb->prefix."ihc_memberships";
    $register_membership_payment_type = $wpdb->get_var("SELECT payment_type FROM $table WHERE id=$lid");
endif;

function aw_register_form($attr=array()){
    global $register_membership_payment_type,$str;
    
	$user_type = ihc_get_user_type();
	if ($user_type=='unreg'){
        ///////ONLY UNREGISTERED CAN SEE THE REGISTER FORM

        /// ROLE LEVL DETECTION
        $shortcodes_attr['role'] = (isset($attr['role'])) ? $attr['role'] : FALSE;

        // SI LA MEMBRESIA NÓ ES DE PAGA LLEVAR A LA PAGINA DE GRACIAS, SI NÓ LLEVAR AL 
        
        //////////// STYLES CSS ///////////
        $str .= '<style>
        .aw_register_form{
            border:1px solid #707070;
            border-radius:17px;
            padding:25px;
            height: max-content;
        }
        .aw-form-header{
            border-bottom:2px solid  #c6cace;
        }
        .aw_register_form input{
            border-radius:5px;
            padding:18px;
            font-size:1.8rem;
        }
        .aw_register_form input[type=submit]{
            padding:5px;
        }
        .nice-select, .aw_register_form input{
            border:1px solid var(--blue);
        }
        .aw_register_form .notification{
            position:absolute;
            top:2.5em;
            right:1.3em;
            color:var(--danger);
        }
        </style>';
        /////////Toasts
        $str .= '<div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0;">
        <div id="toastsRegisterForm" style="width:200px;" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
          <div class="toast-header">
            <img width="16" height="16" src="/favicon.ico" class="rounded mr-2">
            <strong class="mr-auto" style="font-size:2.1rem;">Warning</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="toast-body" style="font-size:2rem">
            Hello, world! This is a toast message.
          </div>
        </div>
      </div>';
        
        $str .= '
        <div class="container mt-5">
            <div class="row" >
                <div class="col-12 mb-5 shortcode-step d-flex justify-content-between">
                    <span class="font-weight-bolder text-uppercase text-body" style="border-bottom:2px solid #0558cb;">'.get_the_title().'</span>
                    <i class="fa fa-angle-right font-weight-bolder text-body"></i>
                    <span class="font-weight-bolder text-uppercase text-body">'.get_the_title(get_option('ihc_checkout_page')).'</span>
                    <i class="fa fa-angle-right font-weight-bolder text-body"></i>
                    <span class="font-weight-bolder text-uppercase text-body">'.get_the_title(get_option('ihc_thank_you_page')).'</span>
                </div>
                <form method="POST" class="aw_register_form col-md-7 col-lg-8">
                    <div class="form-row">
                        <div class="form-group col-12 aw-form-header">
                            <p class="font-weight-bolder text-uppercase text-body py-3" >Crear cuenta</p>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-capitalize text-body">nombre de usuario</label>
                            <div class="input-group-prepend">
                                <input type="text" name="username" class="form-control mt-2" autocomplete="false" >
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-capitalize text-body">email</label>

                            <div class="input-group-prepend">
                                <input type="email" name="email" class="form-control mt-2" autocomplete="false">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-capitalize text-body">contraseña</label>
                            <input type="password" name="password" class="form-control mt-2" autocomplete="false">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-capitalize text-body">pais</label></br>
                            <select class="form-control mt-2 wide" name="country" id="search_select">
                                {country_items}
                            </select>
                        </div>
                        <div class="form-group col-12 my-4">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="tos_check" name="tos" value="1">
                                <label class="form-check-label ml-5" role="button" for="tos_check">Aceptar<a href="/tos"> términos de servicio</a></label>
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <input type="hidden" name="membership_id" value="'.$_GET['lid'].'">
                            <input type="hidden" name="membership_paid" value="'.strval($register_membership_payment_type).'">
                            <input type="submit" class="btn btn-primary px-5" value="Registrarme">
                        </div>
                    </div>
                </form>
                <div class="col-md-5 col-lg-4">
                    <p class="font-weight-bolder text-uppercase text-body py-3">Conviertete en miembro de apuestan</p>
                    <p class="text-body" >
                        Para ser miembro de Apuestan, primero debes completar el registro y aceptar nuestros términos de servicio.
                    </p>
                    
                </div>
            </div>
        </div>
        ';
        $countries = get_countries_json();
        $country_items = "";
        foreach($countries as $key => $country):
            $country_items .= '<option '.($key == 3 ? "selected": "").' value="'.$country->country_short_name.'" >'.$country->country_name.'</option>';
        endforeach;
        $str = str_replace("{country_items}",$country_items,$str);
        return $str;
    }    
}

add_action( 'wp_enqueue_scripts', function(){
    wp_enqueue_script( 'register-form', get_template_directory_uri() . '/assets/js/register_form.js', [], null, true);
    $rest_uri = strval(rest_url());
    wp_add_inline_script( 'register-form', "const register_form_vars ={rest_uri:'$rest_uri'} " );
});


add_shortcode( 'aw-register-form', 'aw_register_form');
