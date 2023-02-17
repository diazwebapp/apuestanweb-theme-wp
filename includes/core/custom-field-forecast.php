<?php

function aw_forecast_img_destacada_personalizada() {
	add_meta_box('forecast_img_destacada_personalizada', 'Imagen destacada personalizada', 'aw_forecast_imagen_destacada_personalizada', 'forecast', 'normal', 'default');
}
function aw_forecast_imagen_destacada_personalizada() {
	global $post;
    $default_bg =  get_template_directory_uri() . '/assets/img/event2-bg.png';
    $no_team_img =  get_template_directory_uri() . '/assets/img/logo2.svg';
    
	$html = '
    <input type="text" class="hidden" id="input-equipo-1" value="{replace-team-1}">
    <input type="text" class="hidden" id="input-equipo-2" value="{replace-team-2}">
    <input type="text" class="hidden" id="plantilla" value="{replacebg}">
    <div class="container">
        <div class="row">
        
            <div class="col-12" style="position:relative !important;">

                <div id="imagen-destacada-personalizada" class="d-flex justify-content-around align-items-center" style="width:720px;height:360px;position:relative !important; background-image:url({replacebg});background-repeat:no-repeat;background-size:cover;background-position:center center;">
                
                    <img src="{replace-team-1}" width="100" height="100" target-html-attr="src" ubicacion="left" onclick="aw_set_imgs(this)" id="logo-equipo-1"/>
                        <span class="text-light text-bold" >VS</span>
                    <img src="{replace-team-2}" width="100" height="100" target-html-attr="src" ubicacion="right" onclick="aw_set_imgs(this)" id="logo-equipo-2"/>
                </div>
                <button class="aw_upload_image_button btn btn-primary" onclick="aw_set_imgs(this)" target-html-id="imagen-destacada-personalizada" target-html-attr="background-image" style="position:absolute !important;top:2px;left:2px;"><i class="dashicons dashicons-edit" ></i></button>

            </div>
            <div class="col-12">
                <div class="row mt-3">
                    <div class="col-md-4">
                        <input type="checkbox" id="help_replace_thumb" name="replace_thumbnail">
                        <label for="help_replace_thumb" >remmplazar imagen destacada?</label>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-success" id="btnSave2" post-id="'.$post->ID.'" onclick="generate_base64(this)" >generar base64</button>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
    ';
    
    wp_nonce_field( "base64nonce", "base64nonce" );
    
    $html = str_replace("{replacebg}","$default_bg",$html);
    $html = str_replace("{replace-team-1}","$no_team_img",$html);
    $html = str_replace("{replace-team-2}","$no_team_img",$html);
    
    $html = str_replace("{post_name}",$post->post_name,$html);
 
    echo $html;
}
