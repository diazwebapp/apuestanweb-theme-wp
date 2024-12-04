<?php

function aw_custom_thumb() {
	add_meta_box('forecast_img_destacada_personalizada', 'Imagen destacada personalizada', 'aw_forecast_imagen_destacada_personalizada', 'forecast', 'normal', 'default');
}
function aw_forecast_imagen_destacada_personalizada() {
	global $post;
    $default_bg =  get_template_directory_uri() . '/assets/img/plantilla-1.png';
    $no_team_img =  get_template_directory_uri() . '/assets/img/cross.png';
     
    /* if ( has_post_thumbnail() ) {
        $attachment_image = wp_get_attachment_url( get_post_thumbnail_id() );
        $default_bg = esc_attr( $attachment_image ) ;	
    }  */
    $template = '<div style="position:relative !important;width:854px;max-width:854px;height:480px;top:0;left:0;background:red;" id="thumb-template">
    <img src="{replacebg}" width="854" height="480" id="plantilla" style="height:480px;"/>
    <img src="{replace-team-1}" width="130px" height="130px" class="d-none img-fluid" style="position: absolute;top: 36.8%;left: 16.4%;width: 130px;max-height:130px;height:130px;object-fit:contain;" id="equipo-1" />
    <img src="{replace-team-1}" width="130px" height="130px" class="d-none img-fluid" style="position: absolute;top: 36.8%;left: 68.5%;width: 130px;max-height:130px;height:130px;object-fit:contain;" id="equipo-2" />

    
</div>';
	$html = '
    <div class="container>
        <div class="row" style="min-height:580px;height:580px;">
           
            <div class="col-12" style="min-height:480px;height:480px;">
                <div style="
                    position: absolute !important;
                    max-width: 854px;
                    width: 854px;
                    height:480px;
                    top: 0;
                    left: calc(0% + 15px);
                    width: calc(100% - 30px);
                    
                ">
                        <img src="{replacebg}" width="854" height="480" id="plantilla" style="opacity:1;height:480px;" />
                        <button class="btn btn-outline-light" type="button" style="position:absolute;top:5px;left:5px;background:rgba(0,0,0, .3);" target-html-id="plantilla" onclick="aw_set_imgs(this)">reemplazar plantilla <i class="dashicons dashicons-edit" ></i></button>

                        <div role="button" class="d-flex justify-content-center align-items-center text-light" style="
                                        position: absolute;
                                        top: 36.8%;
                                        left: 16.4%;
                                        background: rgba(0,0,0, .3);
                                        width: 130px;
                                        height: 130px;
                                    " 
                        target-html-id="equipo-1" onclick="aw_set_imgs(this)">
                            <i class="dashicons dashicons-edit" ></i>
                        </div>

                        <div type="button" class="d-flex justify-content-center align-items-center text-light" "
                                        position: absolute;
                                        top: 36.8%;
                                        left: 68.5%;
                                        background: rgba(0,0,0, .3);
                                        width: 130px;
                                        height: 130px;
                                    " 
                        target-html-id="equipo-2" onclick="aw_set_imgs(this)">
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