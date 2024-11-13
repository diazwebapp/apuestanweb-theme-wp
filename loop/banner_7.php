<?php

$params = get_query_var("params");
$alt_logo = get_template_directory_uri() . '/assets/img/apnpls.svg';
$text = !empty($params['text']) ? $params['text'] : 'CONVIERTE EN MIEMBRO PREMIUM';

$html_logo = "<img src='$alt_logo' class='w-100' alt='{$params['title']}' >";
$text_vip_link = !empty($params['text_vip_link']) ? $params['text_vip_link'] : 'VIP';
if($params['src_logo']):
    $html_logo = "<img src='{$params['src_logo']}' class='w-100' alt='{$params['title']}' >";
endif;

echo '<div class="vip_box v2">
<div class="row align-items-center">
    <div class="col-md-9">
        <img src='.$alt_logo.' class="logo_dark" alt='.$params['title'].' >
        <h4>'.__("{$params['title']}","jbetting").'</h4>
        <p>'.__("$text","jbetting").'</p>
        <a href="'.$params['memberships_page'].'">'.__("$text_vip_link","jbetting").'</a>
    </div>
    <div class="col-md-3 d-none d-md-block">
        '.$html_logo.'
    </div>
</div>
</div>';