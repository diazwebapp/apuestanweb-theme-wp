<?php

$params = get_query_var("params");
$alt_logo = get_template_directory_uri() . '/assets/img/event-logo.png';
$html_logo = "<img src='$alt_logo' class='logo_dark' alt='{$params['title']}' >";
if($params['src_logo']):
    $html_logo = "<span class='{$params['src_logo']}' ></span>";
endif;

echo '<div class="vip_box v2">
<div class="row align-items-center">
    <div class="col-md-9">
        '.$html_logo.'
        <h4>CONVIERTE EN MIEMBRO PREMIUM</h4>
        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam no numy sit eirmod…</p>
        <a href="'.$params['memberships_page'].'">Quiero ser VIP</a>
    </div>
    <div class="col-md-3 d-none d-md-block">
        <img src="img/value.png" class="w-100" alt="">
    </div>
</div>
</div>';