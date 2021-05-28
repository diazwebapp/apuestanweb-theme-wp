<?php 
function pronostico_1($data){
    $button;
    if($data['button']){
        $button .= '<a class="btn_outline" href="'.$data['link'].'" >'. __($data['button'],'apuestanweb-lang') .'</a>';
    }
    $html = '
        <div class="tarjetita_pronostico_1 single_pronostico" style="'.$data['style'].'" >
                <h3 class="title_pronostico" >'.$data['nombre_equipo_1'].' vs '.$data['nombre_equipo_2'].'</h3>
                                            
                <div class="equipos_pronostico" >
                    <div>
                        <img loading="lazy" src="'.$data['img_equipo_1'].'" alt="'.$data['nombre_equipo_1'].'"/>
                        <p>'.$data['nombre_equipo_1'].'</p>  
                    </div>
                    <div>
                        <p>'.$data['fecha_partido'].'</p>
                        <span>'.$data['hora_partido'].'</span>
                    </div>
                    <div>
                        <img loading="lazy" src="'.$data['img_equipo_2'].'" alt="'.$data['nombre_equipo_2'].'"/>   
                        <p>'.$data['nombre_equipo_2'].'</p>  
                    </div>
                </div>
                <div class="average_pronostico" >

                    <p>'.$data['average_equipo_1'].'</p> <p>'.$data['cuota_empate_pronostico'].'</p> <p>'.$data['average_equipo_2'].'</p>
                 
                </div> 
                '.$button.'
        </div> ';
    return $html;
}

function pronostico_2($data){
    $metodos_pago;
    $button;
    if($data['button']){
        $button =  __($data['button'],'apuestanweb-lang') ;
    }
    if(!$data['button']){
        $button =  __('view','apuestanweb-lang');
    }
    if($data['metodo_pago_1']): 
        $metodos_pago .= '<img loading="lazy" src="'. $data['metodo_pago_1'] .'" >';
    endif; 
    if($data['metodo_pago_2']): 
        $metodos_pago .= '<img loading="lazy" src="'. $data['metodo_pago_2'] .'" >';
    endif; 
    if($data['metodo_pago_3']): 
        $metodos_pago .= '<img loading="lazy" src="'. $data['metodo_pago_3'] .'" >';
    endif; 
    if($data['metodo_pago_4']): 
        $metodos_pago .= '<img loading="lazy" src="'. $data['metodo_pago_4'] .'" >';
    endif; 

    $html = '
        <div class="tarjetita_pronostico_2" style="'.$data['style'].'">
            <div>
                <b>22:00</b>
                <div>
                    
                    <img loading="lazy" src="'.$data['img_equipo_1'].'" alt="'.$data['nombre_equipo_1'].'"/>
                
                    <img loading="lazy" src="'.$data['img-equipo_2'].'" alt="'.$data['nombre_equipo_2'].'"/>
                    
                </div>
            </div>
            <div>
                <b>'.$data['nombre_equipo_1'].' vs '.$data['nombre_equipo_2'].'</b>
                <small>'.$data['average_equipo_1'].' | '.$data['average_equipo_2'].'</small>
            </div>
            <div>
                <b>'.$data['acceso_pronostico'].'</b>
                <a class="btn_outline" href="'.$data['link'].'" >'. $button .'</a>
            </div> 
        </div> ';
    return $html;
}

function pronostico_vip($data){
    $metodos_pago;
    $button;
    if($data['button']){
        $button =  __($data['button'],'apuestanweb-lang') ;
    }
    if(!$data['button']){
        $button =  __('view','apuestanweb-lang');
    }
    if($data['metodo_pago_1']): 
        $metodos_pago .= '<img loading="lazy" src="'. $data['metodo_pago_1'] .'" >';
    endif; 
    if($data['metodo_pago_2']): 
        $metodos_pago .= '<img loading="lazy" src="'. $data['metodo_pago_2'] .'" >';
    endif; 
    if($data['metodo_pago_3']): 
        $metodos_pago .= '<img loading="lazy" src="'. $data['metodo_pago_3'] .'" >';
    endif; 
    if($data['metodo_pago_4']): 
        $metodos_pago .= '<img loading="lazy" src="'. $data['metodo_pago_4'] .'" >';
    endif; 

    $html = '
        <div class="tarjetita_pronostico_2" style="'.$data['style'].'">
            <div>
                <b>22:00</b>
                <div>
                    
                    <img loading="lazy" src="'.$data['img_equipo_1'].'" alt="'.$data['nombre_equipo_1'].'"/>
                
                    <img loading="lazy" src="'.$data['img-equipo_2'].'" alt="'.$data['nombre_equipo_2'].'"/>
                    
                </div>
            </div>
            <div>
                <b>'.$data['nombre_equipo_1'].' vs '.$data['nombre_equipo_2'].'</b>
                <small>'.$data['average_equipo_1'].' | '.$data['average_equipo_2'].'</small>
            </div>
            <div>
                <b>'.$data['acceso_pronostico'].'</b>
                <a href="'.$data['link'].'" >'. $button .'</a>
            </div> 
        </div> ';
    return $html;
}