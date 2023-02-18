<?php

function aw_forecast_img_destacada_personalizada() {
	add_meta_box('forecast_img_destacada_personalizada', 'Imagen destacada personalizada', 'aw_forecast_imagen_destacada_personalizada', 'forecast', 'normal', 'default');
}
function aw_forecast_imagen_destacada_personalizada() {
	global $post;
    $default_bg =  get_template_directory_uri() . '/assets/img/plantilla-1.png';
    $no_team_img =  get_template_directory_uri() . '/assets/img/event2-1.png';
     
    if ( has_post_thumbnail() ) {
        $attachment_image = wp_get_attachment_url( get_post_thumbnail_id() );
        $default_bg = esc_attr( $attachment_image ) ;	
    } 
	$html = '
    <div class="container">
        <div class="row">
        
            <div class="col-12" style="position:relative !important;">

                <img src="{replacebg}" width="768" height="403" id="plantilla" />
                <img src="{replace-team-1}" width="105" height="105" class="d-none" style="position:absolute; absolute;top: 150px;left: 167px;" id="equipo-1" />
                <img src="{replace-team-1}" width="105" height="105" class="d-none" style="position:absolute; absolute;top: 150px;right: 374px;" id="equipo-2" />

                <button class="btn btn-outline-light" type="button" style="position:absolute;top:5px;left:5px;background:rgba(0,0,0, .5);" target-html-id="plantilla" onclick="aw_set_imgs(this)">reemplazar background <i class="dashicons dashicons-edit" ></i></button>

                <button class="btn btn-outline-light" type="button" style="position:absolute; absolute;top: 150px;left: 165px;background:rgba(0,0,0, .5);min-width:105px !important;min-height:105px !important;" target-html-id="equipo-1" onclick="aw_set_imgs(this)"><i class="dashicons dashicons-edit" ></i></button>

                <button class="btn btn-outline-light" type="button" style="position:absolute; absolute;top: 150px;left: 528px;background:rgba(0,0,0, .5);min-width:105px !important;min-height:105px !important;" target-html-id="equipo-2" onclick="aw_set_imgs(this)"><i class="dashicons dashicons-edit" ></i></button>
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
