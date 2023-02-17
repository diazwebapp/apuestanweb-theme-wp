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
        
            <div class="col-12">

                <div id="imagen-destacada-personalizada" class="d-flex justify-content-around align-items-center" style="width:720px;height:360px;position:relative !important; background-image:url({replacebg});background-repeat:no-repeat;background-size:cover;background-position:center center;">
                
                    <img src="{replace-team-1}" width="100" height="100" target-html-attr="src" ubicacion="left" onclick="aw_set_imgs(this)" id="logo-equipo-1"/>
                        <span class="text-light text-bold" >VS</span>
                    <img src="{replace-team-2}" width="100" height="100" target-html-attr="src" ubicacion="right" onclick="aw_set_imgs(this)" id="logo-equipo-2"/>
                </div>

            </div>
            <div class="col-12">
                <div class="row mt-3">
                    <div class="col-md-4">
                        <input type="checkbox" id="help_replace_thumb" name="replace_thumbnail">
                        <label for="help_replace_thumb" >remmplazar imagen destacada?</label>
                    </div>
                    <div class="col-md-4 mx-2">
                        <button class="aw_upload_image_button btn btn-primary" onclick="aw_set_imgs(this)" target-html-id="imagen-destacada-personalizada" target-html-attr="background-image" >cambiar fondo</button>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-success" id="btnSave2" onclick="generate_base64(this)" >generar base64</button>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="base64" name="base64" >
        <input type="hidden" name="post_name" value="{post_name}" />
    </div>
    ';
    
    wp_nonce_field( "base64nonce", "base64nonce" );
    /* 
    function redimencionar_imagen($ruta,$dimenciones=[100,100]){
        $ruta = imagescale(
            $ruta,
            $dimenciones[0],
            $dimenciones[1],
            $mode = IMG_BILINEAR_FIXED
        );
        return $ruta;
    }
    $dir = ABSPATH . '/wp-content/uploads/cuadrado.png';
   
    // Creo dos imagenes, una es el fondo y la otra el texto que le voy a superponer 
    $ext_plantilla = pathinfo($default_bg, PATHINFO_EXTENSION);
    if($ext_plantilla == 'png'){
        $plantilla = imagecreatefrompng($default_bg); 
    }
    if($ext_plantilla == 'jpeg'){
        $plantilla = imagecreatefromjpeg($default_bg); 
    }
    if($ext_plantilla == 'webp'){
        $plantilla = imagecreatefromwebp($default_bg); 
    }
    $plantilla = redimencionar_imagen($plantilla,[720,280]);

    $ext_equipo_1 = pathinfo($no_team_img, PATHINFO_EXTENSION);
    if($ext_equipo_1 == 'png'){
        $equipo_1 = imagecreatefrompng($no_team_img); 
    }
    if($ext_equipo_1 == 'jpeg'){
        $equipo_1 = imagecreatefromjpeg($no_team_img); 
    }
    if($ext_equipo_1 == 'webp'){
        $equipo_1 = imagecreatefromwebp($no_team_img); 
    }
    if(empty($equipo_1)){
        $equipo_1 = imagecreatefrompng($default_bg);   
     }
    
    
    $equipo_1 = redimencionar_imagen($equipo_1,[100,100]);

    // Obtengo los tamaños de las imagenes 
    $plantillaAncho = imagesx($plantilla); 
    $plantillaAlto = imagesy($plantilla); 
    $equipo_1Ancho = imagesx($equipo_1); 
    $equipo_1Alto = imagesy($equipo_1); 
    // Posision horizontal del logo 1
    $h = $plantillaAncho / 6;
    $v = ($plantillaAlto / 2) + ($equipo_1Alto / 2) ;
    // Copiamo la imágen de fondo a la imagen final  
    imagecopy($plantilla,$equipo_1,$h,$v - $equipo_1Alto,0,0,$equipo_1Ancho,$equipo_1Alto); 
    
    // Damos salida a la imagen final 
    imagepng($plantilla,$dir);
     */

    $html = str_replace("{replacebg}","$default_bg",$html);
    $html = str_replace("{replace-team-1}","$no_team_img",$html);
    $html = str_replace("{replace-team-2}","$no_team_img",$html);
    
    $html = str_replace("{post_name}",$post->post_name,$html);
    echo $html;
}
