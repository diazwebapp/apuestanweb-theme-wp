<?php

function shortcode_prices($atts)
{
    extract(shortcode_atts(array(
        'model' => 1,
        'slogan' => ''
    ), $atts));
    
    $levels = \Indeed\Ihc\Db\Memberships::getAll();
	if ($levels){
		$register_url = '';
		$checkout_url = '';

		$levels = ihc_reorder_arr($levels);
		$levels = ihc_check_show($levels); /// SHOW/HIDE
		$levels = ihc_check_level_restricted_conditions($levels); /// MAGIC FEAT.

		$levels = apply_filters( 'ihc_public_subscription_plan_list_levels', $levels );
		// @description used in public section - subcription plan. @param list of levels to display ( array )

		$register_page = get_option('ihc_general_register_default_page');
		$checkout_page = get_option('ihc_checkout_page');
		if ($register_page){
			$register_url = get_permalink($register_page);
		}
		if ($checkout_page){
			$checkout_url = get_permalink($checkout_page);
		}
		$str = '';

        set_query_var( 'params', [
            "slogan" => $slogan,
            "memberships" => $levels,
            "register_url" => is_user_logged_in() ? $checkout_url : $register_url ,
        ] );
        if(!$model || $model == 1):
            $str .= load_template_part("loop/prices_{$model}"); 
        endif;
		
		return $str;
	}
	return '';
}

add_action( 'wp_enqueue_scripts', function(){
	wp_enqueue_script('common-js', get_template_directory_uri() . '/assets/js/common.js', array(), '1.0.0', true);
	$current_user = wp_get_current_user(  );

	$jsdata['rest_uri'] = rest_url();
	$_SESSION["current_user"] = ["user_login"=>$current_user->user_login,"ID"=>$current_user->ID];
	$jsdata["current_user_id"] = $current_user->ID;
	$jsdata = json_encode($jsdata);
    wp_add_inline_script( 'common-js', "const php_js_prices = $jsdata" );
});

add_shortcode('prices', 'shortcode_prices');