<?php

$url = get_the_permalink(get_the_ID());
$html = "<h3 style='color:red;'>ingrese el id del perfil ejemplo $url?profile=1</h3>" ;
if(isset($_GET['profile'])):
    $id_author = isset($_GET['profile']) ? $_GET['profile'] : 1;

    $posts = print_table("post",false,$id_author,true);
    
    
    $display_name = get_the_author_meta("display_name", $id_author);
    $biography = get_the_author_meta( 'description', $id_author );

    $avatar_url = get_avatar_url($id_author);
    $avatar = isset($avatar_url) ? $avatar_url : get_template_directory_uri() . '/assets/img/logo2.svg';
    
    $stats_vip = get_user_stats($id_author,'=',-1);
    
    $stats_free = get_user_stats($id_author,'!=',-1);
    //estadisticas ultimos 2 meses
    $num = 3;
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
        <div class="subscribe__icon">';
            $twitter_handle = get_user_meta( $id_author, 'twitter', true );
            $facebook_url = get_user_meta( $id_author, 'facebook', true );
            $instagram_url = get_user_meta( $id_author, 'instagram', true );


            if ( $twitter_handle ) {
                $profile .= '<a href="https://twitter.com/' . esc_attr( $twitter_handle ) . '" aria-label="follow me on twitter" rel="nofollow noreferrer noopener" target="_blank"><i class="fab fa-twitter"></i></a>';
            }
            if ( $facebook_url ) {
                $profile .= '<a href="' . esc_url( $facebook_url ) . '"  aria-label="follow me on facebook" rel="nofollow noreferrer noopener" target="_blank"><i class="fab fa-facebook" ></i></a>';
            }
            if ( $instagram_url ) {
                $profile .= '<a href="' . esc_url( $instagram_url ) . '" aria-label="follow me on instagram" rel="nofollow noreferrer noopener" target="_blank"><i class="fab fa-instagram" ></i></a>';
            }
            $profile .= '</div></div>
            <div class="sub__box--ri">
                    <h2>'.$display_name.'</h2>
                     <p>'.$biography.'</p>                           
                </div>
                
                <div class="subscribe__btn">
                    <a href="/plus">Subscribete</a>
                </div>

        </div>';

    
     
    $stats = '<div class="estad__box">
        <ul class="nav estad-tabs" id="myTab" role="tablist">
            <li class="estad-item" role="presentation">
                <a class="estad-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">ApuestanPlus</a>
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
                <a class="free-link '.(isset($_GET['page_vip']) ? "active": "").'" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">ApuestanPlus</a>
                <a class="free-link '.(isset($_GET['page_free']) ? "active": "").'" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Free</a>
                <a class="free-link '.(isset($_GET['page_posts']) ? "active": "").'" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Articulos</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade '.(!isset($_GET['page_free']) and !isset($_GET['page_posts']) ? "show active ": "").'" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                <div class="free__table-wd">
                    <div class="free__table">
                        '.$args["table_forecasts_vip"].'
                    </div>
                </div>


            </div>
            <div class="tab-pane fade '.(isset($_GET['page_free']) ? "sow active": "").'" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="free__table-wd">
                    <div class="free__table">
                        '.$args["table_forecasts_free"].'
                    </div>
                </div>
            </div>
            <div class="tab-pane fade '.(isset($_GET['page_posts']) ? "show active": "").'" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
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
                <h4>Publicaciones</h4>
                '.$stats_full.'
            </div>
    ';
endif;
echo $html;