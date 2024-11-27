<?php
// background pages or forecast

$params = get_query_var('params');
$text = !empty($params['text']) ? $params['text'] : 'Disfruta del contenido Premium';
$text_vip_link = !empty($params['text_vip_link']) ? $params['text_vip_link'] : 'VIP';

echo "<div class='event_area'>
        <div class='container'>
            <div class='row align-items-center'>
            <div class='col-lg-8 mt-3'>   
                <h1 class='title'>{$params['title']}</h1> ";            
                echo do_shortcode("[related-forecasts num='{$params['num']}' league='all']");	
        echo "</div>

        <div class='col-lg-4 mb-4'>
                <div class='academic-card mt-4'>
                    <div class='academic-card-body'>
                        <h5 class='academic-card-title'>Academia Apuestan</h5>
                        <p class='academic-card-text'>Explora nuestros valiosos recursos de apredizaje.</p>
                        <a href='/apuestas-deportivas' class=' btn-primary academic-card-btn'>Visitar</a>

                    </div>
                    <div class='icon-box'>
                        <i class='fas fa-book'></i>
                    </div>

                </div>            
                <div class='academic-card mb_4'>
                    <div class='academic-card-body'>
                        <h5 class='academic-card-title'>Noticias</h5>
                        <p class='academic-card-text'>Visita nuestra sección de Noticias, alineaciones probables y mucho más.</p>
                        <a href='/noticias' class=' btn-primary academic-card-btn'>Visitar</a>

                    </div>
                    <div class='icon-box'>
                        <i class='fas fa-newspaper'></i>
                    </div>

                </div>            
                <div class='academic-card mb_4'>
                    <div class='academic-card-body'>
                        <h5 class='academic-card-title'>Bonos de Apuestas</h5>
                        <p class='academic-card-text'>Los mejores bonos para duplicar tus depositos.</p>
                        <a href='/bonos' class=' btn-primary academic-card-btn'>Visitar</a>

                    </div>
                    <div class='icon-box'>
                        <i class='fas fa-gift'></i>
                    </div>

                </div>            
        
            </div>
</div>";

/* <div class='col-lg-4 mt-3'>
<div class='vip_box' style='background-image:url(".get_template_directory_uri() . '/assets/img/vip.png'.");'>
    <img src='".get_template_directory_uri() . '/assets/img/apnpls.svg'."' alt='vip'>
    <h3>$text</h3>
    <p>Sé miembro de ApuestanPlus</p>
    <a href='".PERMALINK_VIP."'>$text_vip_link</a>
</div>
</div>
</div>
</div> */