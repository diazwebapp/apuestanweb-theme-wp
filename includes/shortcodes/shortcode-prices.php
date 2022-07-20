<?php

function shortcode_prices($atts)
{
    extract(shortcode_atts(array(
        'model' => 1,
        'slogan' => ''
    ), $atts));
    ////////////////// AUTHORIZE RECURRING PAYMENT
	if (!empty($_GET['ihc_authorize_fields']) && !empty($_GET['lid'])){
		$authorize_str = ihc_authorize_reccuring_payment();
		if (!empty($authorize_str)){
			return $authorize_str;
		}
	}
	////////////////// AUTHORIZE RECURRING PAYMENT

	//// BRAINTREE
	if (!empty($_GET['ihc_braintree_fields']) && !empty($_GET['lid'])){
		$output = ihc_braintree_payment_for_reg_users();
		if (!empty($output)){
			return $output;
		}
	}
	//// BRAINTREE
    $levels = \Indeed\Ihc\Db\Memberships::getAll();
	if ($levels){
		$register_url = '';

		$levels = ihc_reorder_arr($levels);
		$levels = ihc_check_show($levels); /// SHOW/HIDE
		$levels = ihc_check_level_restricted_conditions($levels); /// MAGIC FEAT.

		$levels = apply_filters( 'ihc_public_subscription_plan_list_levels', $levels );
		// @description used in public section - subcription plan. @param list of levels to display ( array )

		$register_page = get_option('ihc_general_register_default_page');
		if ($register_page){
			$register_url = get_permalink($register_page);
		}

		$str = '';

		$u_type = ihc_get_user_type();
		

		
        set_query_var( 'params', [
            "slogan" => $slogan,
            "memberships" => $levels,
            "register_url" => $register_url,
        ] );
        if(!$model || $model == 1):
            $str .= load_template_part("loop/prices_{$model}"); 
        endif;
		
		return $str;
	}
	return '';
}


add_shortcode('prices', 'shortcode_prices');