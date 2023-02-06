<?php

function aw_forecast_img_destacada_personalizada() {
	add_meta_box('forecast_img_destacada_personalizada', 'Imagen destacada personalizada', 'aw_forecast_imagen_destacada_personalizada', 'forecast', 'normal', 'default');
}
function aw_forecast_imagen_destacada_personalizada() {
	global $post;
    $default_bg =  get_template_directory_uri() . '/assets/img/event2-bg.png';
    $no_team_img =  get_template_directory_uri() . '/assets/img/logo2.svg';
	$html = '
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Imagen destacada personalizada</h3>
                <div id="imagen-destacada-personalizada" class="d-flex justify-content-around align-items-center" style="width:720px;height:360px;position:relative !important; background-image:url({replacebg});background-repeat:no-repeat;background-size:cover;background-position:center center;">
                    <img src="{replace-team-1}" width="100" height="100" target-html-attr="src" onclick="aw_set_imgs(this)"/>
                        <span class="text-light text-bold" >VS</span>
                    <img src="{replace-team-2}" width="100" height="100" target-html-attr="src" onclick="aw_set_imgs(this)"/>
                </div>
            </div>
            <div class="col-12">
                <button class="aw_upload_image_button my-3" onclick="aw_set_imgs(this)" target-html-id="imagen-destacada-personalizada" target-html-attr="background-image" >cambiar fondo</button>
            </div>
        </div>
    </div>
    ';
    $html = str_replace("{replacebg}","$default_bg",$html);
    $html = str_replace("{replace-team-1}","$no_team_img",$html);
    $html = str_replace("{replace-team-2}","$no_team_img",$html);
    echo $html;
}