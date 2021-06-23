<?php 
function casa_apuesta_1($data){
    $button;
    if($data['button']){
        $button .= '<a class="btn_outline_blue" href="'.$data['refear_link'].'" >'. __($data['button'],'apuestanweb-lang') .'</a>';
    }
    if(!$data['button']){
        $button .= '<a class="btn_outline_blue" href="'.$data['refear_link'].'" >'. __('Offert Now','apuestanweb-lang') .'</a>';
    }
    $html = '<div class="tarjeta_casa_apuesta_'.$data['model'].'" style="'.$data['style'].'">
        <div>
            <img loading="lazy" src="'.$data['thumb'].'" />
            <a href="'.$data['link'].'" class="circle" >
                <img loading="lazy" src="'.$data['logo'].'" />
            </a>
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
        $button .= '<a class="btn_outline refer" href="'.$data['refear_link'].'" >'. __($data['button'],'apuestanweb-lang') .'</a>';
    }
    if(!$data['button']){
        $button .= '<a class="btn_outline refer" href="'.$data['refear_link'].'" >'. __('Offert Now','apuestanweb-lang') .'</a>';
    }
    if($data['metodo_pago_1']): 
        $metodos_pago .= '<img loading="lazy" loading="lazy" src="'. $data['metodo_pago_1'] .'" >';
    endif; 
    if($data['metodo_pago_2']): 
        $metodos_pago .= '<img loading="lazy" loading="lazy" src="'. $data['metodo_pago_2'] .'" >';
    endif; 
    if($data['metodo_pago_3']): 
        $metodos_pago .= '<img loading="lazy" loading="lazy" src="'. $data['metodo_pago_3'] .'" >';
    endif; 
    if($data['metodo_pago_4']): 
        $metodos_pago .= '<img loading="lazy" loading="lazy" src="'. $data['metodo_pago_4'] .'" >';
    endif; 

    $html = ' <div class="tarjeta_casa_apuesta_'.$data['model'].'" style="'.$data['style'].'">
        <div>
            <a href="'.$data['link'].'" class="casa_apuesta_img_especial">
                <img loading="lazy" loading="lazy" src="'.$data['logo'].'">
            </a>
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