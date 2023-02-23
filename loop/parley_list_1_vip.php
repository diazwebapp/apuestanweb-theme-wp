<?php

$params = get_query_var('params');
$vip = carbon_get_post_meta(get_the_ID(), 'vip');
$permalink = get_the_permalink(get_the_ID());
$content = get_the_content(get_the_ID());
$forecasts = carbon_get_post_meta(get_the_ID(), 'forecasts');
$parley_title = get_the_title(get_the_ID());
$time = carbon_get_post_meta(get_the_ID(), 'data');
$date = new DateTime($time);
$date = $date->setTimezone(new DateTimeZone($args["timezone"]));

$fecha = date_i18n('d M', strtotime($date->format("y-m-d h:i:s")));
$hora = date('g:i a', strtotime($date->format('y-m-d h:i:s')));

$bookmaker = json_encode([]);
///Buscamos el pais en la base de datos
$aw_system_location = aw_select_country(["country_code"=>$args["country_code"]]);
//SI EL PAIS ESTÁ CONFIGURADO
if(isset($aw_system_location)):
    //SI EL SHORTCODE ES USADO EN UNA PAGINA
    if(is_page()){
        $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true,"on_page"=>true]);
        if($bookmaker["name"] == "no bookmaker"){
            $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true]);
        }
    }
    //SI EL SHORTCODE NÓ ES USADO EN UNA PAGINA
    if(!is_page()){
        $bookmaker = aw_select_relate_bookmakers($aw_system_location->id, ["unique"=>true,"random"=>true]);
    }
endif;
if(!isset($aw_system_location)):
    $bookmaker = aw_select_relate_bookmakers(1, ["unique"=>true,"random"=>true]);
endif;

$parley_id = get_the_ID();

$estado_usuario = "permitido";
if(function_exists("aw_get_user_type")):
    $user_type = aw_get_user_type($args["current_user"]);
    if($user_type == "unreg"){
        $estado_usuario = "no permitido";
    }
endif;
$html_pronosticos = '<div class="text-center my-3">
            <a href="'.$params['vip_ink'].'" class="btn btn-primary mx-5 px-5">
                <i class="far fa-lock display-4"></i>
                <span class="mx-3 display-4">VIP</span>
            </a>
    </div>'
    ;

$html = "<div class='parley_wrapper'>
        <div class='parley_top_content' style='background-color:#009fe3 !important;'>
            <h2>$parley_title $fecha</h2>
        </div>
        {replace-html-pronosticos}
        {replace-html-box-2}
    </div>";


$html_box_2 = "<div class='parley_box2'>
                <div class='parley_left_content2 d-md-block d-none'>
                    <img width='90' height='30' style='object-fit:contain;' src='{$bookmaker["logo_2x1"]}' class='img-fluid' alt=''>
                </div>
                <div class='parley_right_content2'>

                    <div class='blog_select_box parley_right_content2_mb'>
                        <select class='form-select' onchange='parley_calc_cuotes(this)' name='apu' id='apu' data='$parley_id' >
                            <option value='10'>Apuesta $10</option>
                            <option value='15'>Apuesta $15</option>
                            <option value='20'>Apuesta $20</option>
                            <option value='50'>Apuesta $50</option>
                        </select>
                        
                    </div>
                    <div class='gana_box parley_right_content2_mb'>
                    <input type='hidden' id='jscuote_$parley_id' value='$parley_cuotes'/>
                       <p>Gana: $ <span id='jsresult_$parley_id' >". round($parley_cuotes * 10,2) ."</span></p>
                    </div>
                    <div class='parley_left_content2 parley_right_content2_mb d-md-none d-block'>
                    <img width='90' height='30' style='object-fit:contain;' src='{$bookmaker["logo_2x1"]}' class='img-fluid' alt=''>
                    </div>
                    <div class='parley_btn_2 parley_right_content2_mb'> 
                        <a href='{$bookmaker['ref_link']}' class='button' rel='nofollow noopener noreferrer' target='_blank' >Apostar ahora</a>
                    </div>      
                </div>
            </div>"
;

$html = str_replace("{replace-html-pronosticos}",$html_pronosticos,$html);
$html = str_replace("{replace-html-box-2}",$html_box_2,$html);
echo $html;