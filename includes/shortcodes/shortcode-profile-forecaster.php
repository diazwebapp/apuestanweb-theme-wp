<?php
function shortcode_profile_forecaster($atts)
{
    extract(shortcode_atts(array(
        'model' => 1,
    ), $atts));

    $ret = "";
    $profiles = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 0;
    var_dump($profiles);
    $ret = load_template_part("loop/profile-forecaster-{$model}"); 

    return $ret;
}


add_shortcode('profile-forecaster', 'shortcode_profile_forecaster');