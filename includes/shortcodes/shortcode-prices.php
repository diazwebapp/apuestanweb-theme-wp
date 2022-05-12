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

		$fields = get_option('ihc_user_fields');
		///PRINT COUPON FIELD
		$num = ihc_array_value_exists($fields, 'ihc_coupon', 'name');
		$coupon_field = ($num===FALSE || empty($fields[$num]['display_public_ap'])) ? FALSE : TRUE;
		////PRINT SELECT PAYMENT
		$key = ihc_array_value_exists($fields, 'payment_select', 'name');
		$select_payment = ($key===FALSE || empty($fields[$key]['display_public_ap'])) ? FALSE : TRUE;

		$str = '';

		$u_type = ihc_get_user_type();
		if ($u_type!='unreg' && $u_type!='pending' && $levels && ihcCheckCheckoutSetup() == FALSE){
			//DEPRECATED
			global $current_user;
			$taxes = Ihc_Db::get_taxes_rate_for_user((isset($current_user->ID)) ? $current_user->ID : 0);
			$register_template = get_option('ihc_register_template');
			$default_payment = get_option('ihc_payment_selected');
			if ($select_payment && empty( $attr['is_admin_preview'] ) ){
				$payments_available = ihc_get_active_payments_services();
				$register_fields_arr = ihc_get_user_reg_fields();
				$key = ihc_array_value_exists($register_fields_arr, 'payment_select', 'name');
				if (!empty($payments_available) && count($payments_available)>1 && $key!==FALSE && !empty($register_fields_arr[$key]['display_public_ap'])){
					$payment_select_string = ihc_print_payment_select($default_payment, $register_fields_arr[$key], $payments_available, 0);
				}
			}

			$the_payment_type = ( ihc_check_payment_available($default_payment) ) ? $default_payment : '';
			ob_start();
			require IHC_PATH . 'public/views/account_page-subscription_page-top_content.php';
			$str = ob_get_contents();
			ob_end_clean();
		}

		///bt message
		if (!empty($_GET['ihc_lid'])){
			global $current_user;
			$str = ihc_print_bank_transfer_order($current_user->ID, $_GET['ihc_lid']);
			global $stop_printing_bt_msg;
			$stop_printing_bt_msg = TRUE;
		}
        set_query_var( 'params', [
            "slogan" => $slogan,
            "memberships" => $levels,
            "register_url" => $register_url,
            "select_payment" => $select_payment
        ] );
        if(!$model || $model == 1):
            $str .= load_template_part("loop/prices_{$model}"); 
        endif;
		
		return $str;
	}
	return '';
}


add_shortcode('prices', 'shortcode_prices');