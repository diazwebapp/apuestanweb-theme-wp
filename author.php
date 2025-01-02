<?php 

function load_forecaster_script() {
    wp_enqueue_style('s-forecaster-css', get_template_directory_uri() . '/assets/css/forecaster-styles.css'); 
     wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/jquery-3.6.0.min.js', [], '3.6.0', true);
}

add_action('wp_enqueue_scripts', 'load_forecaster_script',2);


get_header();

$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$avatar_url = get_the_author_meta( 'profile_image',$curauth->ID );
$avatar = isset($avatar_url) ? $avatar_url : get_template_directory_uri() . '/assets/img/logo2.svg';

///////ESTADISTICAS DEL AUTOR////////
$stats_vip = get_user_stats($curauth->ID,'=',-1);  
$stats_free = get_user_stats($curauth->ID,'!=',-1);

?>

    <main>
        <!--subscribe--area--start-->
        <div class="subscribe__area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="subscribe__wrap">
                            <div class="sbscribe__fx">
                                <div class="subscribe__lf">
                                    <div class="subscribe__box">
                                        <div class="sub-inn">
                                            <div class="sub-bx-lf">
                                                <div class="subscribe__img">
                                                    <img src="<?php echo $avatar; ?>" alt="author-image">
                                                </div>
                                                <div class="subscribe__icon">
                                                    <!-- <a href="#">facebook</i></a>
                                                    <a href="#">twitter</a>
                                                    <a href="#">instagran</a> -->
                                                </div>
                                            </div>
                                            <div class="sub__box--ri">
                                                <div class="subscribe__icon ic-mbl">
                                                    <!-- <a href="#">facebook</i></a>
                                                    <a href="#">twitter</a>
                                                    <a href="#">instagran</a>> -->
                                                </div>
                                                <h3><?php echo $curauth->nickname; ?></h3>
                                                <p></p>
                                            </div>
                                            <div class="subscribe__btn">
                                                <a href="#">SUSCRIBIRSE</a>
                                            </div>

                                        </div>
                                        
                                    </div>
                                    
                                    <div class="estad__wrap">
                                        <h4>Estadisticas</h4>
                                        <div class="estad__box">
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
                                                                <h5><?php echo $stats_vip['total'] ?></h5>
                                                            </div>
                                                            <p>PRONÓSTICOS</p>
                                                        </div>
                                                        <div class="estad__single">
                                                            <div class="estd__bt">
                                                                <h5><?php echo $stats_vip['tvalue'] ?></h5>
                                                            </div>
                                                            <p>BENEFICIO</p>
                                                        </div>
                                                        <div class="estad__single">
                                                            <div class="estd__bt">
                                                                <h5><?php echo round($stats_vip['porcentaje'],2) ?></h5>
                                                            </div>
                                                            <p>%</p>
                                                        </div>
                                                        <div class="estad__single">
                                                            <div class="estd__bt">
                                                                <h5>152</h5>
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
                                                        <div class="restad__tabl--mid">
                                                            <p>Marzo 2022</p>
                                                            <p>15</p>
                                                            <p>+25,96</p>
                                                            <p>51,07%</p>
                                                        </div>
                                                        <div class="restad__tabl--mid">
                                                            <p>Marzo 2022</p>
                                                            <p>15</p>
                                                            <p>+25,96</p>
                                                            <p>51,07%</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="subs__ri mbllll">
                                        <div class="mens__box">
                                            <div class="mens__logo">
                                                <a href="#"><img src="img/new/pppp.png" alt=""></a>
                                            </div>
                                            <div class="mes--text">
                                                <p>SUSCRIPCION</p>
                                                <h4>MENSUAL</h4>
                                                <h3>$9.99</h3>
                                                <a href="#">UNIRSE</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="estad__wrap est-sec">
                                        <h4>Estadisticas</h4>
                                        <div class="estad__box">
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
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">FECHA</th>
                                                                            <th scope="col">LIGA</th>
                                                                            <th scope="col">PARTIDO</th>
                                                                            <th scope="col">PICK</th>
                                                                            <th scope="col">ESTADO</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>Premier League</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td><i class="fa-solid fa-circle-check"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td><i class="fa-solid fa-circle-check"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td><i class="fa-solid fa-circle-check"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td><i class="fa-solid fa-circle-check"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td><i class="fa-solid fa-circle-check"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td class="rre"><i class="fa-solid fa-circle-xmark"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td class="rre"><i class="fa-solid fa-circle-xmark"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td><i class="fa-solid fa-circle-check"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td><i class="fa-solid fa-circle-check"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td><i class="fa-solid fa-circle-check"></i></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                        <div class="free__table-wd">
                                                            <div class="free__table">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">FECHA</th>
                                                                            <th scope="col">LIGA</th>
                                                                            <th scope="col">PARTIDO</th>
                                                                            <th scope="col">PICK</th>
                                                                            <th scope="col">ESTADO</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td><i class="fa-solid fa-circle-check"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td><i class="fa-solid fa-circle-check"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td><i class="fa-solid fa-circle-check"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td><i class="fa-solid fa-circle-check"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td><i class="fa-solid fa-circle-check"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td><i class="fa-solid fa-circle-xmark"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td><i class="fa-solid fa-circle-xmark"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td><i class="fa-solid fa-circle-check"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td><i class="fa-solid fa-circle-check"></i></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>24 mar</td>
                                                                            <td>NBA</td>
                                                                            <td>miami Heat vs Gs Warriors</td>
                                                                            <td>Mas 215.5 photos</td>
                                                                            <td><i class="fa-solid fa-circle-check"></i></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="subs__ri">
                                    <div class="mens__box">
                                        <div class="mens__logo">
                                            <a href="#"><img src="img/new/pppp.png" alt=""></a>
                                        </div>
                                        <div class="mes--text">
                                            <p>SUSCRIPCION</p>
                                            <h4>MENSUAL</h4>
                                            <h3>$9.99</h3>
                                            <a href="#">UNIRSE</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--subscribe--area--end-->




        <!--info--area--start-->
        <div class="info__area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="info__wrap">
                            <h4>Recibe la información deportiva en primera fila</h4>
                            <div class="info_input__box">
                                <input type="text" name="" id="" placeholder="Correo electrónico">
                                <button type="submit">Enviar</button>
                            </div>
                            <p>*ApuestanWeb es tu sitio de pronósticos y consejos deportivos gratis</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--info--area--end-->

    
    </main>

<?php get_footer(); ?>
