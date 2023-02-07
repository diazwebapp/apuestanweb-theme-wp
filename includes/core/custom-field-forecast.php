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
        $equipo_1 = imagecreatefrompng($default_bg);    }
    
    
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

    $img = wp_get_image_editor( $no_team_img );
    if ( ! is_wp_error( $img ) ) {
        $img->resize( 500, 500, true );
        $img->stream();
    }else{
        echo "error seleccionando editor<br/>";
    }
    $html = str_replace("{replacebg}","$default_bg",$html);
    $html = str_replace("{replace-team-1}","$no_team_img",$html);
    $html = str_replace("{replace-team-2}","$no_team_img",$html);
    echo $html;
}