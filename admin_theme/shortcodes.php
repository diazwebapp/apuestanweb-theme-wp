<?php
//short_codes

function stars($puntuacion){
	$stars = '';
	for($i=0;$i<$puntuacion[0]; $i++){ $stars .= '✭';}
	return $stars;
}
function short_code_casa_apuesta_1($attr){ 
    extract( shortcode_atts( array( 'limit' => '' ), $attr ) );
	$c_a = new wp_query(array(
		"post_type"=>"casaapuesta",
        'posts_per_page' => $limit
	));
	$html = '
	<style>
		.tarjeta_casa_apuesta_2{
			width:min-content;
			min-width:250px;
            height: 240px;
			margin:5px auto ;
			border:unset;
            border-radius:16px;
            overflow:hidden;
            box-shadow: 0px 0px 3px grey;
		}
        .tarjeta_casa_apuesta_2 > div{
            position: relative;
            display: flex;
            flex-flow: column;
            justify-content: center;
            align-items: center;
        }
		.tarjeta_casa_apuesta_2 > div:first-child{
            height: 140px;
            overflow: hidden;
            background-size: cover;
			position:relative !important;
		}
        .tarjeta_casa_apuesta_2 > div *{
            text-align:center;
        }
        .tarjeta_casa_apuesta_2 > div:first-child img{
            width:100%;
            height:100%;
            object-fit: cover;
        }
        .tarjeta_casa_apuesta_2 > div:first-child > img{
            position: absolute;
            top:0;
            left:0;
        }
        
        .tarjeta_casa_apuesta_2 > div:first-child div{
            position: absolute;
            z-index: 10;
            width:120px;
            background: white;
            text-align: center;
            overflow: hidden;
        }
        .tarjeta_casa_apuesta_2 > div:last-child .stars_content{
            color: gold;
            position: absolute;
        }
        .tarjeta_casa_apuesta_2 > div a{
            margin:5px 0;
            width: 90%;
            color: rgb(30 115 191);
            border:2px solid rgb(30 115 191);
            text-decoration:none;
            padding:5px 0;
            border-radius:7px;
        }
		.tarjeta_casa_apuesta_2 > div:first-child .circle{
			height:120px;
			left:calc(50% - 60px);
			border-radius: 50%;
			z-index: 10;
			padding: 10px;
		}
        .tarjeta_casa_apuesta_2 > div:first-child .circle img{
            width:100%;
            height:100%;
            object-fit: contain;
            margin: 0 auto;
        }
	</style>';

	while($c_a->have_posts()) : $c_a->the_post();
		$puntuacion = get_post_meta(get_the_ID(),'puntuacion_casa_apuesta');
		
		$html .= '<div class="tarjeta_casa_apuesta_2">
					<div style="position:relative;" >
						<img src="'. get_the_post_thumbnail_url(get_the_ID(),'puntuacion_casa_apuesta') .'" />
						<div class="circle" >
							<img src="'. get_post_meta(get_the_ID(),'url_logo_casa_apuesta')[0] .'" />
						</div>
					</div>
					<div>
						<h3 style="margin: 3px 0;">'. get_post_meta(get_the_ID(),'slogan_casa_apuesta')[0].'</h3>
						<div style="position:relative;"><span class="stars_content" >'. stars($puntuacion) .'</span><span>✭✭✭✭✭</span></div>
						<a href="'.get_the_permalink(get_the_ID()).'" >'. _x('start','apuestanweb-lang'). '</a>
					</div>
				</div>';
	endwhile; 

	return $html;
}
add_shortcode('t_casa_apuesta_2','short_code_casa_apuesta_1');

//puntuacion pronosticos
function eqp_ganador($average_equipo_1,$average_equipo_2,$nombre_equipo_1,$nombre_equipo_2){
	if($average_equipo_1[0] < $average_equipo_2[0]): return $nombre_equipo_1[0];endif;
	if($average_equipo_1[0] > $average_equipo_2[0]): return $nombre_equipo_2[0];endif;
}
function punt_pronostico(){
	$html = '';
	$puntuacion = get_post_meta(get_the_ID(),'puntuacion_p');
	$nombre_equipo_1 = get_post_meta(get_the_ID(),"nombre_equipo_1");
	$average_equipo_1 = get_post_meta(get_the_ID(),"average_equipo_1");

	$nombre_equipo_2 = get_post_meta(get_the_ID(),"nombre_equipo_2");
	$average_equipo_2 = get_post_meta(get_the_ID(),"average_equipo_2");
		$html .= '<div class="cont_p_p" >
			<div style="min-width:280px;overflow:hidden;width:min-content;" >
				<b style="color:white;">'.eqp_ganador($average_equipo_1,$average_equipo_2,$nombre_equipo_1,$nombre_equipo_2) .'</b>
			</div>
			<div style="margin:0px auto;width:min-content;min-width:280px;display:flex;flex-flow:row nowrap;justify-content:space-around;align-items:center;background:#043a69;border-radius:7px;padding:10px 3px;" >
				<b style="color:white;">'.__('Level','apuestanweb-lang').'</b>
				<div style="position:relative;"><span style="color:gold;position:absolute;" >'.stars($puntuacion).'</span><span>✭✭✭✭✭</span></div>
				<a style="color:white;text-decoration:none;background:#ff4141;padding:3px 10px; border-radius:5px;" href="!#" >'.__('start','apuestanweb-lang').'</a>
			</div>
		</div>';

	return $html;
}
add_shortcode('puntuacion_pronostico','punt_pronostico');