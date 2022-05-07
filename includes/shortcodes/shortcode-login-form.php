<?php

function aw_login_form($attr=array()){
	/*
	 * Attributes:  template , remember , register , lost_pass , social , captcha .
	 * @param array
	 * @return string
	 */
	///////////// LOGIN FORM
	$str = '';
	if (!IHCACTIVATEDMODE){
		$str .= ihc_public_notify_trial_version();
	}
	$msg = '';
	$user_type = ihc_get_user_type();
	if ($user_type!='unreg'){
		////////////REGISTERED USER
		if ($user_type=='pending'){
			//pending user
			$msg = ihc_correct_text(get_option('ihc_register_pending_user_msg', true));
			if ($msg){
				$str .= '<div class="ihc-login-pending">' . $msg . '</div>';
			}
		} else {
			//already logged in
			if ($user_type=='admin'){
				$str .= '<div class="ihc-warning-message">' . esc_html__('Administrator Info: Login Form is not showing up once you\'re logged. You may check how it it looks for testing purpose by openeing the page into a separate incognito browser window. ', 'ihc') . '<i>' . esc_html__('This message will not be visible for other users', 'ihc') . '</i></div>';
			}
		}
	} else {
		/////////////UNREGISTERED
		$meta_arr = ihc_return_meta_arr('login');
		
		if (isset($attr['remember'])){
			$meta_arr['ihc_login_remember_me'] = $attr['remember'];
		}
		if (isset($attr['register'])){
			$meta_arr['ihc_login_register'] = $attr['register'];
		}
		if (isset($attr['lost_pass'])){
			$meta_arr['ihc_login_pass_lost'] = $attr['lost_pass'];
		}
		if (isset($attr['social'])){
			$meta_arr['ihc_login_show_sm'] = $attr['social'];
		}
		if (isset($attr['captcha'])){
			$meta_arr['ihc_login_show_recaptcha'] = $attr['captcha'];
		}

		if (ihc_is_magic_feat_active('login_security')){
			require_once IHC_PATH . 'classes/Ihc_Security_Login.class.php';
			$security_object = new Ihc_Security_Login();
			if ($security_object->is_ip_on_black_list()){
				$show_form = FALSE;
				$hide_form_message = esc_html__('You are not allowed to see this Page.', 'ihc');
			} else {
				$show_form = $security_object->show_login_form();
				if (!$show_form){
					$hide_form_message = $security_object->get_locked_message();
				}
			}
		} else {
			$show_form = TRUE;
		}
		if ($show_form){
			$str .= ihc_print_form_login($meta_arr);
		}  else if (!empty($hide_form_message)){
			$str .= '<div class="ihc-wrapp-the-errors">' . $hide_form_message . '</div>';
		}
	}

	//print the message
	if (isset($_GET['ihc_success_login']) && $_GET['ihc_success_login']){
		/************************** SUCCESS ***********************/
		$msg .= get_option('ihc_login_succes');
		if (!empty($msg)){
			$str .= '<div class="ihc-login-success">' . ihc_correct_text($msg) . '</div>';
		}
	}
    /* <section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
      <div class="col-md-8 col-lg-7 col-xl-6">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
          class="img-fluid" alt="Phone image">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
        <form>
          <!-- Email input -->
          <div class="form-outline mb-4">
            <input type="email" id="form1Example13" class="form-control form-control-lg" />
            <label class="form-label" for="form1Example13">Email address</label>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-4">
            <input type="password" id="form1Example23" class="form-control form-control-lg" />
            <label class="form-label" for="form1Example23">Password</label>
          </div>

          <div class="d-flex justify-content-around align-items-center mb-4">
            <!-- Checkbox -->
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
              <label class="form-check-label" for="form1Example3"> Remember me </label>
            </div>
            <a href="#!">Forgot password?</a>
          </div>

          <!-- Submit button -->
          <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>

          <div class="divider d-flex align-items-center my-4">
            <p class="text-center fw-bold mx-3 mb-0 text-muted">OR</p>
          </div>

          <a class="btn btn-primary btn-lg btn-block" style="background-color: #3b5998" href="#!"
            role="button">
            <i class="fab fa-facebook-f me-2"></i>Continue with Facebook
          </a>
          <a class="btn btn-primary btn-lg btn-block" style="background-color: #55acee" href="#!"
            role="button">
            <i class="fab fa-twitter me-2"></i>Continue with Twitter</a>

        </form>
      </div>
    </div>
  </div>
</section> */
    $str .= "<style>
                .aw-login-form{
                    max-width:400px;
                    margin:0 auto;
                    border:1px solid black;
                    border-radius:15px;
                    padding:30px;
                }
                .aw-login-form .title-form{
                    margin:0 auto 30px auto;
                    text-align:center;
                    font-size:2.5rem;
                }
                #ihc_login_form{
                    display:grid;
                }
                #ihc_login_form input{
                    height:40px;
                    line-height:40px;
                    border-radius:8px;
                    padding: 0 4px !important;
                    border: 1px solid lightblue !important;
                    margin:10px auto;
                }
                #ihc_login_form input[type='submit']{
                    background:var(--blue);
                    max-width:150px !important;
                    color:white;
                }
                .form-outline{
                    position:relative !important;
                }
                .ihc-hide-pw{
                    top:10%;
                    right:1%;
                }
                #ihc_login_form > div:nth-child(5){
                    display:grid;
                    text-align:center;
                    order:1;
                }
                .impu-form-links div:nth-child(1){
                    order:2;
                }
                .impu-form-links div:nth-child(2){
                    margin:20px auto;
                }
                .impu-form-links div:nth-child(2) a,.aw-login-form .title-form{
                    color:black !important;
                }
                .impu-form-links div:nth-child(1) a,.aw-login-form .title-form{                    
                    text-transform:uppercase;
                }
    </style>";
    $str = str_replace('ihc-login-form-wrap ihc-login-template-1','aw-login-form ',$str);
    $str = str_replace('impu-form-line-fr','form-outline mb-4',$str);
    $str = str_replace('<input','<input class="form-control form-control-lg"',$str);
    $str = str_replace('impu-form-label-fr','form-label',$str);
    $str = str_replace('<span','<label ',$str);
    $str = str_replace('</span','</label',$str);
    $str .= "<script>
        document.addEventListener('DOMContentLoaded',()=>{
            let inputs = document.querySelectorAll('input')
            let form = document.querySelector('.aw-login-form')
            if(inputs.length > 0){
                inputs.forEach(input=>{
                    if(input.name === 'rememberme'){
                        input.parentNode.remove()
                    }
                })
            }
            if(form){
                form.style.display = 'block'
                let p = document.createElement('p')
                p.textContent = 'login'
                p.classList.add('title-form')
                form.insertAdjacentElement('afterbegin',p)
            }
        })
        </script>";
	return $str;
}
add_shortcode( 'aw-login-form', 'aw_login_form' );