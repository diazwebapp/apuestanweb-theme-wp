<?php
function shortcode_prices($atts)
{
    extract(shortcode_atts(array(
        'model' => 1,
    ), $atts));
    $ret = "";
    
    if(!$model || $model == 1):
        $ret = load_template_part("loop/prices_{$model}"); 
    endif;

    return $ret;
}


add_shortcode('prices', 'shortcode_prices');