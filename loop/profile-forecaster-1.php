<?php

$url = get_the_permalink(get_the_ID());
$html = "<h3 style='color:red;'>ingrese el id del perfil ejemplo $url?profile=1</h3>" ;
if(isset($_GET['profile'])):
    $id_author = isset($_GET['profile']) ? $_GET['profile'] : 1;
    $forecasts = print_table("forecast",'free',$id_author,true);
    $forecasts_vip = print_table("forecast",'vip',$id_author,true);
    $posts = print_table("post",false,$id_author,true);

   $acerted = get_the_author_meta("forecast_acerted", $id_author );
    $failed = get_the_author_meta("forecast_failed", $id_author );
    $nulled = get_the_author_meta("forecast_nulled", $id_author );
    $rank = get_the_author_meta("rank", $id_author );
    $display_name = get_the_author_meta("display_name", $id_author );
    $avatar_url = get_avatar_url($id_author);
    $avatar = isset($avatar_url) ? $avatar_url : get_template_directory_uri() . '/assets/img/logo2.svg';
    $total_forecast = $acerted + $failed;
    $porcentage = $acerted * 100 / $total_forecast;
    $stats_vip = get_user_stats($id_author,'=');
    $stats_free = get_user_stats($id_author,'!=');
    /*  //estadisticas ultimos 2 meses
    $num = 4;
    $stats_months_vip_html = '';
    $stats_months_free_html = '';
    for($i=1;$i<$num;$i++){
        $month_first_day = date("Y-m-1", strtotime("-$i month"));
        $month_last_day = date("Y-m-t", strtotime("-$i month"));

        $stats_months_vip = get_user_stats($id_author,'=',["start_date"=>$month_first_day,"last_date"=>$month_last_day]);
        $stats_months_free = get_user_stats($id_author,'!=',["start_date"=>$month_first_day,"last_date"=>$month_last_day]);
        $stats_months_vip_html .= '<div class="restad__tabl--mid">
                            <p>'.date("M", strtotime("-$i month")).'</p>
                            <p>'.$stats_months_vip["total"].'</p>
                            <p>'.$stats_months_vip["tvalue"].'</p>
                            <p>'.round($stats_months_vip["porcentaje"],2).'%</p>
                        </div>';
        $stats_months_free_html .= '<div class="restad__tabl--mid">
                            <p>'.date("M", strtotime("-$i month")) .'</p>
                            <p>'.$stats_months_free["total"].'</p>
                            <p>'.$stats_months_free["tvalue"].'</p>
                            <p>'.round($stats_months_free["porcentaje"],2).'%</p>
                        </div>';
    }
    
    $profile = '<div class="sub-inn">
        <div class="sub-bx-lf">
            <div class="subscribe__img">
                <img src="'.$avatar.'" alt="">
            </div>
            <div class="subscribe__icon">
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
        </div>
        <div class="sub__box--ri">
            <div class="subscribe__icon ic-mbl">
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
            <h3>'.$display_name.'</h3>
            <p>Algun texto aquí o quitar este elemento</p>
        </div>
        <div class="subscribe__btn">
            <a href="#">RANKING '.$total_forecast.'</a>
        </div>

    </div>
    <div class="mb-tx">
        <p>El Manchester United es líder del grupo F pero no puede relajarse porque está a tan solo 2 puntos de la tercera posición.</p>
    </div>'; 
    $stats = '<div class="estad__box">
        <ul class="nav estad-tabs" id="myTab" role="tablist">
            <li class="estad-item" role="presentation">
                <a class="estad-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">VIP</a>
            </li>
            <li class="estad-item" role="presentation">
                <a class="estad-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Free</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="estad__wp">
                    <div class="estad__single">
                        <div class="estd__bt">
                            <h5>'.$stats_vip['total'].'</h5>
                        </div>
                        <p>PRONÓSTICOS</p>
                    </div>
                    <div class="estad__single">
                        <div class="estd__bt">
                            <h5>'.$stats_vip['tvalue'].'</h5>
                        </div>
                        <p>BENEFICIO</p>
                    </div>
                    <div class="estad__single">
                        <div class="estd__bt">
                            <h5>'.round($stats_vip['porcentaje'],2).'%</h5>
                        </div>
                        <p>%</p>
                    </div>
                    <div class="estad__single">
                        <div class="estd__bt">
                            <h5>'.$stats_vip['total'].'</h5>
                        </div>
                        <p>PRONÓSTICOS</p>
                    </div>
                </div>
                <div class="estad__tabl">
                    <div class="estad__tabl---head">
                        <p>FECHA</p>
                        <p>PICKS</p>
                        <p>BENEFICIO</p>
                        <p>% Acierto</p>
                    </div>
                    {months_stats_vip}
                </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="estad__wp">
                        <div class="estad__single">
                        <div class="estd__bt">
                            <h5>'.$stats_free['total'].'</h5>
                        </div>
                        <p>PRONÓSTICOS</p>
                    </div>
                    <div class="estad__single">
                        <div class="estd__bt">
                            <h5>'.$stats_free['tvalue'].'</h5>
                        </div>
                        <p>BENEFICIO</p>
                    </div>
                    <div class="estad__single">
                        <div class="estd__bt">
                            <h5>'.round($stats_free['porcentaje'],2).'%</h5>
                        </div>
                        <p>%</p>
                    </div>
                    <div class="estad__single">
                        <div class="estd__bt">
                            <h5>'.$stats_free['total'].'</h5>
                        </div>
                        <p>PRONÓSTICOS</p>
                    </div>
                </div>
                <div class="estad__tabl">
                    <div class="estad__tabl---head">
                        <p>FECHA</p>
                        <p>PICKS</p>
                        <p>BENEFICIO</p>
                        <p>% Acierto</p>
                    </div>
                    {months_stats_free}
                </div>
            </div>
        </div>
    </div>';
    $stats = str_replace("{months_stats_vip}",$stats_months_vip_html,$stats);
    $stats = str_replace("{months_stats_free}",$stats_months_free_html,$stats);
    $stats_full = '<div class="estad__box">
    <div class="free__tab">
        <nav>
            <div class="nav free-tabs" id="nav-tab" role="tablist">
                <a class="free-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">VIP</a>
                <a class="free-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">FREE</a>
                <a class="free-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">ARTICULOS</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                <div class="free__table-wd">
                    <div class="free__table">
                        '.$forecasts_vip.'
                    </div>
                </div>


            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="free__table-wd">
                    <div class="free__table">
                        '.$forecasts.'
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                <div class="free__table-wd">
                    <div class="free__table">
                        '.$posts.'
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>';

    
    $html = '<div class="subscribe__box">
                '.$profile.'
            </div>
            <div class="estad__wrap">
                <h4>Estadisticas</h4>
                '.$stats.'
            </div>
            <div class="estad__wrap est-sec">
                <h4>Estadisticas</h4>
                '.$stats_full.'
            </div>
    '; */
endif;
echo $html;