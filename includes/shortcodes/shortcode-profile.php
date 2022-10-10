<?php
function shortcode_profile($atts)
{
    extract(shortcode_atts(array(
        'model' => 1,
        'id' => false
    ), $atts));

    $ret = "";
    
    $ret = get_template_part("loop/profile_view_{$model}"); 

    return $ret;
}


add_shortcode('profile', 'shortcode_profile');