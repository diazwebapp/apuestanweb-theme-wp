<?php 
function casa_apuesta_1($data){
    $button;
    if($data['button']){
        $button .= '<a class="btn_outline" href="'.$data['link'].'" >'. __($data['button'],'apuestanweb-lang') .'</a>';
    }
    $html = '<div class="tarjeta_casa_apuesta" style="'.$data['style'].'">
        <div>
            <img src="'.$data['thumb'].'" />
            <div class="circle" >
                <img src="'.$data['logo'].'" />
            </div>
            <div class="rectangle" >'.$data['puntuacion'] .' / 5 ' .'<span >✭</span></div>
        </div>
        <div>
            <h3 style="margin: 3px 0;">'.$data['slogan'] .'</h3>
            '.$button.'
        </div>
    </div>';
    return $html;
}

function casa_apuesta_2($data){
    $metodos_pago;
    $button;
    if($data['button']){
        $button .= '<a class="btn_outline" href="'.$data['link'].'" >'. __($data['button'],'apuestanweb-lang') .'</a>';
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

    $html = ' <div class="tarjetita_casa_apuesta_horinzontal" style="'.$data['style'].'">
        <div>
            <div class="casa_apuesta_img_especial">
                <img loading="lazy" src="'.$data['logo'].'">
            </div>
            <div>
                <b>'.__($data['slogan'],'apuestanweb-lang') .'</b>
            </div>
            <div>
                <b>'.$data['puntuacion'].'/5 <span class="estrellita" >✭</span></b>
                '.$button.'
            </div>
        </div>
        <div>
            <div >
                <b> '. __('Tiempo de pago','apuestanweb-lang') .'</b>
                <span>' .$data['tiempo_pago'] .' días</span>
            </div>
            <div>
                <b>Metodos de pago</b>
            </div>
            <div class="metodos_pago">
                '.$metodos_pago.'
            </div>
        
        </div>
    </div>';
    return $html;
}