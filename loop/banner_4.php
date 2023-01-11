<?php
// background pages or forecast

$params = get_query_var('params');
$text = !empty($params['text']) ? $params['text'] : 'Disfruta del contenido Premium';
$text_vip_link = !empty($params['text_vip_link']) ? $params['text_vip_link'] : 'VIP';

echo "<div class='event_area'>
        <div class='container'>
            <div class='row align-items-center'>
            <div class='col-lg-8 mt_25'>   
                <h1 class='title'>{$params['title']}</h1> ";            
                echo do_shortcode("[related-forecasts num='{$params['num']}' league='all']");	
        echo "</div>
                <div class='col-lg-4 mt_25'>
                    <div class='vip_box' style='background-image:url(".get_template_directory_uri() . '/assets/img/vip.png'.");'>
                        <img src='".get_template_directory_uri() . '/assets/img/apnpls.svg'."' alt='vip'>
                        <h3>$text</h3>
                        <p>Sé miembro de ApuestanPlus</p>
                        <a href='".PERMALINK_VIP."'>$text_vip_link</a>
                    </div>
                </div>
            </div>
        </div>
</div>";