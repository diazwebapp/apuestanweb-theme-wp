<?php

function aw_forecast_img_destacada_personalizada() {
	add_meta_box('forecast_img_destacada_personalizada', 'Imagen destacada personalizada', 'aw_forecast_imagen_destacada_personalizada', 'forecast', 'normal', 'default');
}
function aw_forecast_imagen_destacada_personalizada() {
	global $post;
    $default_bg =  get_template_directory_uri() . '/assets/img/plantilla-1.png';
    $no_team_img =  get_template_directory_uri() . '/assets/img/cross.png';
     
    if ( has_post_thumbnail() ) {
        $attachment_image = wp_get_attachment_url( get_post_thumbnail_id() );
        $default_bg = esc_attr( $attachment_image ) ;	
    } 
    $template = '<div style="position:relative !important;max-width:768px;top:0;left:0;" id="thumb-template">
    <img src="{replacebg}" width="768" height="403" id="plantilla" />
    <img src="{replace-team-1}" width="105" height="105" class="d-none img-fluid" style="position: absolute;top: 38%;left: 20%;width: 13%;max-height:25%;object-fit:contain;" id="equipo-1" />
    <img src="{replace-team-1}" width="105" height="105" class="d-none img-fluid" style="position: absolute;top: 38%;left: 67%;width: 13%;max-height:25%;object-fit:contain;" id="equipo-2" />

    
</div>';
	$html = '
    <div class="container">
        <div class="row">
        
            <div class="col-12" >
                '.$template.'
                <div style="
                    position: absolute !important;
                    max-width: 768px;
                    top: 0;
                    left: calc(0% + 15px);
                    width: calc(100% - 30px);
                ">
                        <img src="{replacebg}" width="768" height="403" id="plantilla" style="opacity:0.1;" />
                        <button class="btn btn-outline-light" type="button" style="position:absolute;top:5px;left:5px;background:rgba(0,0,0, .5);" target-html-id="plantilla" onclick="aw_set_imgs(this)">reemplazar plantilla <i class="dashicons dashicons-edit" ></i></button>

                        <div role="button" class="d-flex justify-content-center align-items-center text-light" style="position: absolute;top: 37.3%;left: 19.7%;background: rgba(0,0,0, .3);width: 13.5%;height: 25.8%;" target-html-id="equipo-1" onclick="aw_set_imgs(this)">
                            <i class="dashicons dashicons-edit" ></i>
                        </div>

                        <div type="button" class="d-flex justify-content-center align-items-center text-light" style="position: absolute;top: 37.3%;left: 67%;background:rgba(0,0,0, .3);width: 13.5%;height: 25.8%;" target-html-id="equipo-2" onclick="aw_set_imgs(this)">
                            <i class="dashicons dashicons-edit" ></i>
                        </div>
                    
                </div>
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
