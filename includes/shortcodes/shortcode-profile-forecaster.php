<?php
function shortcode_profile_forecaster($atts)
{
    extract(shortcode_atts(array(
        'model' => 1,
    ), $atts));

    $ret = "";
    $page = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
    var_dump($page);
    $ret = load_template_part("loop/profile-forecaster-{$model}"); 

    return $ret;
}


add_shortcode('profile-forecaster', 'shortcode_profile_forecaster');