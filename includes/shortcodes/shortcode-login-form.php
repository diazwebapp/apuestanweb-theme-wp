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
    /* <div class="card bg-light">
<article class="card-body mx-auto" style="max-width: 400px;">
<h4 class="card-title mt-3 text-center">Create Account</h4>
<p class="text-center">Get started with your free account</p>
<p>
  <a href="" class="btn btn-block btn-twitter"> <i class="fab fa-twitter"></i> &nbsp; Login via Twitter</a>
  <a href="" class="btn btn-block btn-facebook"> <i class="fab fa-facebook-f"></i> &nbsp; Login via facebook</a>
</p>
<p class="divider-text">
      <span class="bg-light">OR</span>
  </p>
<form>
<div class="form-group input-group">
  <div class="input-group-prepend">
      <span class="input-group-text"> <i class="fa fa-user"></i> </span>
   </div>
      <input type="text" value="" id="iump_login_username" name="log" placeholder="Username">
  </div> <!-- form-group// -->
  <div class="form-group input-group">
    <div class="input-group-prepend">
      <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
   </div>
      <input type="password" value="" id="iump_login_password" name="pwd" placeholder="Password">
  </div> 
                                                                   
</form>
</article>
</div>*/
    
    $str .= '<script>
        document.addEventListener("DOMContentLoaded",()=>{
            const form = document.querySelector("#ihc_login_form")
            if(form){
              const divs = form.querySelectorAll("div")
              const div_register = form.querySelector("div.impu-form-links-reg")
              const div_lost_pass = form.querySelector("div.impu-form-links-pass")
              const div_social = form.querySelector("div.ihc-sm-wrapp-fe")
              const div_submit = form.querySelector("div.impu-form-links-reg")
              
              
              divs.forEach(div=>{
                div.remove()
              })
              form.appendChild(div_social)
              form.innerHTML += `
                  <div class="form-group input-group">
                      <div class="input-group-prepend">
                          <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                      </div>
                      <input type="text" value="" id="iump_login_username" name="log" placeholder="Username">
                  </div>
                  <div class="form-group input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                  </div>
                      <input type="password" value="" id="iump_login_password" name="pwd" placeholder="Password">
                  </div>
              `
              form.appendChild(div_lost_pass)
              form.appendChild(div_submit)
              form.appendChild(div_register)
            }
        })
        </script>';
	return $str;
}
add_shortcode( 'aw-login-form', 'aw_login_form' );