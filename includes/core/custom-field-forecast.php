<?php

function aw_forecast_img_destacada_personalizada() {
	add_meta_box('forecast_img_destacada_personalizada', 'Imagen destacada personalizada', 'aw_forecast_imagen_destacada_personalizada', 'forecast', 'normal', 'default');
}
function aw_forecast_imagen_destacada_personalizada() {
	global $post;
    $default_bg =  get_template_directory_uri() . '/assets/img/event2-bg.png';
    $no_team_img =  get_template_directory_uri() . '/assets/img/logo2.svg';
     
    if ( has_post_thumbnail() ) {
        $attachment_image = wp_get_attachment_url( get_post_thumbnail_id() );
        $default_bg = esc_attr( $attachment_image ) ;	
    } 
	$html = '
    <div class="container">
        <div class="row">
        
            <div class="col-12" style="position:relative !important;">

                <div id="imagen-destacada-personalizada" class="d-flex justify-content-around align-items-center" style="width:720px;height:360px;position:relative !important; background-image:url({replacebg});background-repeat:no-repeat;background-size:cover;background-position:center center;">
                
                    <img src="{replace-team-1}" width="100" height="100" target-html-attr="src" ubicacion="left" onclick="aw_set_imgs(this)" id="logo-equipo-1" class="btn btn-outline-light"/>
                        
                    <img src="{replace-team-2}" width="100" height="100" target-html-attr="src" ubicacion="right" onclick="aw_set_imgs(this)" id="logo-equipo-2" class="btn btn-outline-light"/>
                </div>
                <button class="aw_upload_image_button btn btn-outline-light" onclick="aw_set_imgs(this)" target-html-id="imagen-destacada-personalizada" target-html-attr="background-image" style="position:absolute !important;top:2px;left:18px;background-color:rgba(0,0,0, .2) !important;"><i class="dashicons dashicons-edit" ></i></button>

            </div>
            <div class="col-12">
                <div class="row mt-3">
                    <div class="col-md-4">
                        <button class="btn btn-success" id="btnSave2" post-id="'.$post->ID.'" onclick="generate_base64(this)" >Aplicar imagen destacada</button>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
    ';
    
    $html = str_replace("{replacebg}","$default_bg",$html);
    $html = str_replace("{replace-team-1}","$no_team_img",$html);
    $html = str_replace("{replace-team-2}","$no_team_img",$html);
 
    echo $html;
}
