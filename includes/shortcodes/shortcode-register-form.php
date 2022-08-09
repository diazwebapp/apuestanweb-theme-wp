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
        .aw-form-title{
            text-transform:uppercase;
            color:var(--gray-dark);
            padding: 10px 0;
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
        .aw_register_form label{
            color:var(--gray-dark);
            text-transform:capitalize;
        }
        .aw_register_form .notification{
            position:absolute;
            top:2.5em;
            right:1.3em;
            color:var(--danger);
        }
        .twitter-timeline::-webkit-scrollbar {
            width: 8px;     /* Tamaño del scroll en vertical */
            height: 8px;    /* Tamaño del scroll en horizontal */
            display: none;  /* Ocultar scroll */
        }
        /* Ponemos un color de fondo y redondeamos las esquinas del thumb */
        .twitter-timeline::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        /* Cambiamos el fondo y agregamos una sombra cuando esté en hover */
        .twitter-timeline::-webkit-scrollbar-thumb:hover {
            background: #b3b3b3;
            box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
        }

        /* Cambiamos el fondo cuando esté en active */
        .twitter-timeline::-webkit-scrollbar-thumb:active {
            background-color: #999999;
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
                <form method="POST" class="aw_register_form col-md-9">
                    <div class="form-row">
                        <div class="form-group col-12 aw-form-header">
                            <h2 class="aw-form-title" >Crear cuenta</h2>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Username</label>
                            <div class="input-group-prepend">
                                <input type="text" name="username" class="form-control mt-2" autocomplete="false" >
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">email</label>

                            <div class="input-group-prepend">
                                <input type="email" name="email" class="form-control mt-2" autocomplete="false">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">password</label>
                            <input type="password" name="password" class="form-control mt-2" autocomplete="false">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Country</label></br>
                            <select class="form-control mt-2 wide" name="country" id="search_select">
                                {country_items}
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="tos_check" name="tos" value="1">
                                <label class="form-check-label ml-4" role="button" for="tos_check">Check me out</label>
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <input type="hidden" name="membership_id" value="'.$_GET['lid'].'">
                            <input type="hidden" name="membership_paid" value="'.strval($register_membership_payment_type).'">
                            <input type="submit" class="btn btn-primary" value="Register">
                        </div>
                    </div>
                </form>
                <div class="col-md-3">
                    <h3 class="aw-form-title">Conviertete en miembro de apuestan</h3>
                    <p style="color:var(--gray-dark);" >
                        En ApuestanWeb nos gustan los deportes, y los pronósticos de fútbol no podían pasar desapersibidos,
                        no por nada, es el deporte mas visto del mundo, gracias a competiciones como la copa del mundo, Eurocopa, 
                        Champion League, entre otras.
                    </p>
                    
                    <a class="twitter-timeline mt-5" data-height="300" data-dnt="true" data-theme="dark" href="https://twitter.com/diazwebapp?ref_src=twsrc%5Etfw">Tweets by diazwebapp</a>
                    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                    
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
