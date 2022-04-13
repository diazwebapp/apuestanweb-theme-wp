<?php
// background pages or forecast

$params = get_query_var('params');

echo "<div class='event_area'>
        <div class='container'>
            <div class='row align-items-center'>
            <div class='col-lg-8 mt_25'>   
                <h3 class='title'>{$params['title']}</h3> ";            
                echo do_shortcode("[forecasts num='4' league='all']");	
        echo "</div>
                <div class='col-lg-4 mt_25'>
                    <div class='vip_box' style='background-image:url(".get_template_directory_uri() . '/assets/img/vip.png'.");'>
                        <img src='".get_template_directory_uri() . '/assets/img/icon8.svg'."' alt='vip'>
                        <h2>Disfruta del contenido VIP</h2>
                        <p>Obtén tu pase dorado ahora mismo</p>
                        <a href='".PERMALINK_VIP."'>{$params['text_vip_link']}</a>
                    </div>
                </div>
            </div>
        </div>
</div>";