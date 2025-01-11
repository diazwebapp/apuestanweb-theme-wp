<?php 

function load_forecaster_script() {
    wp_enqueue_style('s-forecaster-css', get_template_directory_uri() . '/assets/css/forecaster-styles.css'); 
    //wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/jquery-3.6.0.min.js', [], '3.6.0', true);
}

add_action('wp_enqueue_scripts', 'load_forecaster_script',2);


get_header();

// VALIDAR GEOLOCALIXACION
$geolocation = isset($_SESSION["geolocation"]) ? json_decode($_SESSION["geolocation"]) : null;


$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$avatar_url = get_the_author_meta( 'profile_image',$curauth->ID );
$avatar = isset($avatar_url) ? $avatar_url : get_template_directory_uri() . '/assets/img/logo2.svg';

///////ESTADISTICAS DEL AUTOR////////
$stats_vip = get_user_stats($curauth->ID,'=',-1);  
$stats_free = get_user_stats($curauth->ID,'!=',-1);

///////ESTADISTICAS ULTIMOS 2 MESES/////////
$num = 3;
$stats_months_vip_html = '';
$stats_months_free_html = '';
for($i=1;$i<$num;$i++){
    $month_first_day = date("Y-m-1", strtotime("-$i month"));
    $month_last_day = date("Y-m-t", strtotime("-$i month"));

    $stats_months_vip = get_user_stats($curauth->ID,'=',["start_date"=>$month_first_day,"last_date"=>$month_last_day]);
    $stats_months_free = get_user_stats($curauth->ID,'!=',["start_date"=>$month_first_day,"last_date"=>$month_last_day]);
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

$query_vip = aw_custom_forecasts_query('vip',4,null,'page_forecast_vip');
$query_free = aw_custom_forecasts_query('free',4,null,'page_forecast_free');
$query_post = aw_custom_posts_query('post',4,null,'page_post');

$tr_pronosticos_vip = generate_table_tr($query_vip);
$tr_pronosticos_free = generate_table_tr($query_free);
$tr_posts = generate_table_tr($query_post);

$activeClassVip = $activeClassFree = $activeClassBlog = "";

if (!isset($_GET['page_forecast_free']) && 
    !isset($_GET['page_post'])) {
    $activeClassVip = "show active";
} elseif (isset($_GET['page_forecast_free']) && 
          !isset($_GET['page_forecast_vip']) && 
          !isset($_GET['page_post'])) {
    $activeClassFree = "show active";
} elseif (isset($_GET['page_post']) && 
          !isset($_GET['page_forecast_vip']) && 
          !isset($_GET['page_forecast_free'])) {
    $activeClassBlog = "show active";
}

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
                                        <h4 id="estadisticas" >Estadisticas</h4>
                                        <div class="estad__box">
                                            <ul class="nav estad-tabs nav-tabs" role="tablist">
                                                <li class="estad-item" role="presentation">
                                                    <a class="estad-link nav-link active" id="vip-stats-tab" data-toggle="tab" href="#estadisticas" role="tab" aria-controls="home" aria-selected="true">VIP</a>
                                                </li>
                                                <li class="estad-item" role="presentation">
                                                    <a class="estad-link nav-link" id="free-stats-tab" data-toggle="tab" href="#estadisticas" role="tab" aria-controls="profile" aria-selected="false">Free</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="vip-stats-tab">
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
                                                    </div>
                                                    <div class="estad__tabl">
                                                        <div class="estad__tabl---head">
                                                            <p>FECHA</p>
                                                            <p>PICKS</p>
                                                            <p>BENEFICIO</p>
                                                            <p>% Acierto</p>
                                                        </div>
                                                        
                                                        <?php echo $stats_months_vip_html ?>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" role="tabpanel" aria-labelledby="free-stats-tab">
                                                    <div class="estad__wp">
                                                        <div class="estad__single">
                                                            <div class="estd__bt">
                                                                <h5><?php echo $stats_free['total'] ?></h5>
                                                            </div>
                                                            <p>PRONÓSTICOS</p>
                                                        </div>
                                                        <div class="estad__single">
                                                            <div class="estd__bt">
                                                                <h5><?php echo $stats_free['tvalue'] ?></h5>
                                                            </div>
                                                            <p>BENEFICIO</p>
                                                        </div>
                                                        <div class="estad__single">
                                                            <div class="estd__bt">
                                                                <h5><?php echo round($stats_free['porcentaje'],2) ?></h5>
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
                                                        
                                                        <?php echo $stats_months_free_html ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="estad__wrap est-sec">
                                        <h4 id="publicaciones">Publicaciones</h4>
                                        <div class="estad__box">
                                            <div class="free__tab">
                                                <ul class="nav free-tabs nav-tabs" id="nav-tab" role="tablist">
                                                    
                                                        <a class="free-link nav-link <?= $activeClassVip ?>" id="apuestanplus" data-toggle="tab" href="#publicaciones" role="tab" aria-controls="apuestanplus" aria-selected="true">ApuestanPlus</a>
                                                        <a class="free-link nav-link <?= $activeClassFree ?>" id="free-tabs" data-toggle="tab" href="#publicaciones" role="tab" aria-controls="free-tabs" aria-selected="false">FREE</a>
                                                        <a class="free-link nav-link <?= $activeClassBlog ?>" id="posts-tabs" data-toggle="tab" href="#publicaciones" role="tab" aria-controls="posts-tabs" aria-selected="false">ARTICULOS</a>
                                                    
                                                </ul>
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade <?= $activeClassVip ?>" id="apuestanplus" role="tabpanel" aria-labelledby="apuestanplus">
                                                        <div class="free__table-wd">
                                                            <div class="free__table">
                                                                <!-- TABLA PRONOSTICOS VIP -->
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
                                                                        <?php echo $tr_pronosticos_vip ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <ul class="pagination_list" id="pagination_vip">
                                                                <?php echo aw_custom_pagination($query_vip,'page_forecast_vip'); ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade <?= $activeClassFree ?>" id="free-tabs" role="tabpanel" aria-labelledby="free-tabs">
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
                                                                        <?php echo $tr_pronosticos_free ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <ul class="pagination_list" id="pagination_free">
                                                                <?php echo aw_custom_pagination($query_free,'page_forecast_free'); ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade <?= $activeClassBlog ?>" id="posts-tabs" role="tabpanel" aria-labelledby="posts-tabs">
                                                        <div class="free__table-wd">
                                                            <div class="free__table">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">FECHA</th>
                                                                            <th scope="col">TITULO</th>
                                                                            <th scope="col">LIGA</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php echo $tr_posts ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <ul class="pagination_list" id="pagination_post">
                                                                <?php echo aw_custom_pagination($query_post,'page_post'); ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    // Mapeo de IDs de los UL y los parámetros correspondientes
    const paginationMapping = {
        'pagination_free': 'page_forecast_free',
        'pagination_vip': 'page_forecast_vip',
        'pagination_post': 'page_post',
    };

    // Iterar sobre cada ID de la lista de paginación
    Object.keys(paginationMapping).forEach(paginationId => {
        const paginationList = document.getElementById(paginationId);

        if (paginationList) {
            // Capturar todos los enlaces dentro del ul
            const links = paginationList.querySelectorAll('a');

            links.forEach(link => {
                // Obtener la URL base actual
                let url = new URL(link.href, window.location.origin);

                // Limpiar TODOS los parámetros existentes
                url.search = ''; // Limpia toda la query string

                // Extraer el número de página del enlace (última parte del pathname)
                let pageNumber = link.textContent.trim();

                // Validar si el número de página es válido
                if (!isNaN(pageNumber)) {
                    // Asignar el nuevo parámetro correspondiente
                    url.searchParams.set(paginationMapping[paginationId], pageNumber);

                    // Actualizar el atributo href con la nueva URL limpia
                    link.href = url.toString() + "#publicaciones";
                }
            });
        }
    });
});


    </script>
    </main>

<?php get_footer(); ?>
