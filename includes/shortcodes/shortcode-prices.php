<?php

function shortcode_prices($atts)
{
    extract(shortcode_atts(array(
        'model' => 1,
        'slogan' => ''
    ), $atts));
    $ret = "";
    set_query_var( 'params', [
        "slogan" => $slogan
    ] );
    if(!$model || $model == 1):
        $ret = load_template_part("loop/prices_{$model}"); 
    endif;

    return $ret;
}


add_shortcode('prices', 'shortcode_prices');