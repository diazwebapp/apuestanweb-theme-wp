<?php
//short_code
require __DIR__ .'/models_casa_apuesta.php' ;
require __DIR__ .'/models_pronostico.php' ;

function stars($puntuacion){
	$stars = '';
	for($i=0;$i<$puntuacion; $i++){ $stars .= '✭';}
	return $stars;
}
//Casas apuesta
function shortcode_casas_apuesta($attr){ 
    extract( shortcode_atts( array( 'paginate'=>'no', 'limit' => -1, 'style'=>false, 'model'=>'1', 'button'=>false, 'id'=>false ), $attr ) );
	$casas_apuestas = new wp_query(array(
		"post_type"=>"casaapuesta",
		"posts_per_page" => $limit
	));
	$html = '';
	wp_enqueue_style( 'casa_apuesta_css', get_template_directory_uri() . '/assets/css/tarjetita_casa_apuesta.css' );

		if($id){
			$data = array(
				'thumb' 		=> get_the_post_thumbnail_url($id,'puntuacion_casa_apuesta'),
				'link'			=> get_the_permalink($id),
				'tiempo_pago'	=> get_post_meta($id,'tiempo_pago_casa_apuesta')[0],
				'slogan' 		=> get_post_meta($id,'slogan_casa_apuesta')[0],
				'logo' 			=> get_post_meta($id,'url_logo_casa_apuesta')[0],
				'puntuacion' 	=> get_post_meta($id,'puntuacion_casa_apuesta')[0],
				'metodo_pago_1'	=> get_post_meta($id,'m_p_icon_1')[0],
				'metodo_pago_2'	=> get_post_meta($id,'m_p_icon_2')[0],
				'metodo_pago_3'	=> get_post_meta($id,'m_p_icon_3')[0],
				'metodo_pago_4'	=> get_post_meta($id,'m_p_icon_4')[0],
				'refear_link'	=> get_post_meta($id,'link')[0],
				'style'			=> $style,
				'button'		=> $button,
				'model'			=> $model
			);
			if($model == 1){
				$html .= casa_apuesta_1($data);
			}
			if($model == 2){
				$html .= casa_apuesta_2($data);
			}
		}
		if(!$id){
			foreach ($casas_apuestas->get_posts() as $casaApuesta) {
		
				$data = array(
					'thumb' 		=> get_the_post_thumbnail_url($casaApuesta->ID,'puntuacion_casa_apuesta'),
					'link'			=> get_the_permalink($casaApuesta->ID),
					'tiempo_pago'	=> get_post_meta($casaApuesta->ID,'tiempo_pago_casa_apuesta')[0],
					'slogan' 		=> get_post_meta($casaApuesta->ID,'slogan_casa_apuesta')[0],
					'logo' 			=> get_post_meta($casaApuesta->ID,'url_logo_casa_apuesta')[0],
					'puntuacion' 	=> get_post_meta($casaApuesta->ID,'puntuacion_casa_apuesta')[0],
					'metodo_pago_1'	=> get_post_meta($casaApuesta->ID,'m_p_icon_1')[0],
					'metodo_pago_2'	=> get_post_meta($casaApuesta->ID,'m_p_icon_2')[0],
					'metodo_pago_3'	=> get_post_meta($casaApuesta->ID,'m_p_icon_3')[0],
					'metodo_pago_4'	=> get_post_meta($casaApuesta->ID,'m_p_icon_4')[0],
					'refear_link'	=> get_post_meta($casaApuesta->ID,'link')[0],
					'style'			=> $style,
					'button'		=> $button,
					'model'			=> $model
				);
				if($model == 1){
					$html .= casa_apuesta_1($data);
				}
				if($model == 2){
					$html .= casa_apuesta_2($data);
				}
			}
			if($paginate == 'yes'){
				$html .= '<div class="container_pagination">
					<a href="'.home_url().'\casaapuesta/'.'" >Ver más</a>
				</div>';
			}
		}
	
	return $html;
}
add_shortcode('casa_apuesta','shortcode_casas_apuesta');
//Eleccion
function shortcode_eleccion($attr){
	extract( shortcode_atts( array( 'post_id' => get_the_ID() ), $attr ) );
	
	$html = '';
	$puntuacion = get_post_meta($post_id,'puntuacion_p')[0];
	$refear_link = get_post_meta($post_id,"refear_link")[0];
	$equipo_ganador = get_post_meta($post_id,"equipo_ganador")[0];
	$eleccion = get_post_meta($post_id,"eleccion")[0]; ?>
	<style>
		.short_equipo_ganador{
			width:100%;
			display:flex;
			flex-flow:row wrap;
			justify-content:center;
		}
		.short_equipo_ganador > div{
			width:min-content;
			min-width:280px;
			display:flex;
			flex-flow:row nowrap;
			justify-content:space-around;
			align-items:center;
			padding:10px 3px;
		
		}
		.short_equipo_ganador > div:nth-child(2){
			background:white;
		}
		.short_equipo_ganador > div:last-child{
			background:#043a69;
			border:1px solid grey;
		}
		@media(min-width:568px){
			.short_equipo_ganador{
				padding:10px;
			}
			.short_equipo_ganador > div:first-child{
				width:100%;
				min-width:unset;
				text-align:left;
				justify-content:flex-start;
			}
			
			.short_equipo_ganador > div{
				min-width: 250px
			}
		}
		@media(min-width:640px){
			.short_equipo_ganador > div:last-child{
				min-width:350px;
			}
		}
	</style>
	<?php
	if($equipo_ganador):
		$html .= '<div class="short_equipo_ganador" >
			<div></div>
			
			<div>
				<b style="color:grey;">'.$eleccion.'</b>
			</div>

			<div>
				<b style="color:white;">'.__('Level','apuestanweb-lang').'</b>
				<div style="position:relative;"><span style="color:gold;position:absolute;" >'.stars($puntuacion).'</span><span style="color:white;" >✭✭✭✭✭</span></div>
				<a style="color:white;text-decoration:none;background:#ff4141;padding:3px 10px; border-radius:5px;" href="'.$refear_link.'" >'.__('Start Now','apuestanweb-lang').'</a>
			</div>
		</div>';
	endif;

	return $html;
}
add_shortcode('eleccion','shortcode_eleccion');
//pronosticos
function shortcode_pronosticos($attr){
	extract( shortcode_atts( array( 'deporte' => false, 'rank' => 0, 'model'=> 1 ), $attr ) );
	$terms = get_terms( array(
		'taxonomy' => 'deportes',
		'hide_empty' => true,
	) );
	$current_user = wp_get_current_user();
	wp_enqueue_style( 'pronosticos_css', get_template_directory_uri() . '/assets/css/tarjetita_pronostico_'.$model.'.css' );
	wp_register_script('js-tarjetitas', get_template_directory_uri(). '/assets/js/js-tarjetitas.js', '1', true );
	wp_enqueue_script('js-tarjetitas');
	wp_localize_script( 'js-tarjetitas', 'taxonomy_data', array(
		'terms' => $terms,
		'post_rest_slug' => 'pronostico',
		'class_container_tarjetitas' => 'container_tarjetitas_'.$model,
		'class_delimiter' => 'container_pagination',
		'current_user' => $current_user,
		'rank' => $rank,
		'model' => 'tarjetita_pronostico_'.$model
	) );

		
		$html = '';
		if( $terms && !is_wp_error( $terms)):
			// get taxonomies by post type, and print loop content filtred by term taxonomi
			foreach ($terms as $term) :
				if($deporte && $deporte == $term->name):
					$html .= '<article termid="'. $term->term_id . '" class="container_tarjetitas_'.$model.'" >
					<b class="sub_title" >'. __("Pronósticos: ". strtoupper($term->name)."", 'apuestanweb-lang') .'</b>
					
				</article>
				<div class="container_pagination" ></div>';
				endif;
				if(!$deporte) :
					$html .= '<article termid="'. $term->term_id . '" class="container_tarjetitas_'.$model.'" >
					<b class="sub_title" >'. __("Pronósticos: ". strtoupper($term->name)."", 'apuestanweb-lang') .'</b>
				
					</article>
					<div class="container_pagination" ></div>';
				endif;
	 	endforeach; endif;
		return $html ;
}
add_shortcode('pronosticos','shortcode_pronosticos');
//Pronostico
function shortcode_pronostico($attr){ 
    extract( shortcode_atts( array( 'paginate' => true,'limit' => -1, 'style'=>false, 'model'=>'1', 'button'=>false, 'id'=>false, 'deporte'=>false  ), $attr ) );
	$pronosticos;
	if(!$deporte){
		$pronosticos = new wp_query(array(
			"post_type"=>"pronostico",
			'meta_key' => 'fecha_partido',
			'order_by' => 'meta_value',
			'order' => 'ASC',
			"posts_per_page" => $limit
		));
	}
	if($deporte){
		$pronosticos = new wp_query(array(
			"post_type"=>"pronostico",
			"posts_per_page" => $limit,
			'meta_key' => 'fecha_partido',
			'order_by' => 'meta_value',
			'order' => 'ASC',
			'tax_query'=>array(
				array(
					'taxonomy' => 'deportes',
					'field'	   => 'name',
					'terms' => $deporte
				)
			)
		));
	}
	
	wp_enqueue_style( 'pronosticos_css', get_template_directory_uri() . '/assets/css/tarjetita_pronostico_'.$model.'.css' );
	$html = '';
	
		foreach ($pronosticos->get_posts() as $pronostico) {
		
			$data = array(
				'nombre_equipo_1' 			=> get_post_meta($pronostico->ID,"nombre_equipo_1")[0],
				'img_equipo_1' 			=> get_post_meta($pronostico->ID,"img_equipo_1")[0],
				'resena_equipo_1' 			=> get_post_meta($pronostico->ID,"resena_equipo_1")[0],
				'average_equipo_1' 		=> get_post_meta($pronostico->ID,"average_equipo_1")[0],
			
				'nombre_equipo_2' 			=> get_post_meta($pronostico->ID,"nombre_equipo_2")[0],
				'img_equipo_2' 			=> get_post_meta($pronostico->ID,"img_equipo_2")[0],
				'resena_equipo_2' 			=> get_post_meta($pronostico->ID,"resena_equipo_2")[0],
				'average_equipo_2' 		=> get_post_meta($pronostico->ID,"average_equipo_2")[0],
			
				'fecha_partido' 			=> get_post_meta($pronostico->ID,"fecha_partido")[0],
				'hora_partido' 			=> get_post_meta($pronostico->ID,"hora_partido")[0],
				'cuota_empate_pronostico' 	=> get_post_meta($pronostico->ID,"cuota_empate_pronostico")[0],
				'puntuacion' 				=> get_post_meta($pronostico->ID,'puntuacion_p')[0],
				'link'			=> get_the_permalink($pronostico->ID),
				'button'		=> $button,
				'style'			=> $style
			);
			if($id && $id == $pronostico->ID){
				if($model == 1){
					$html .= pronostico_1($data);
				}
				if($model == 2){
					$html .= pronostico_2($data);
				}
				if($model == 'vip'){
					$html .= pronostico_vip($data);
				}
			}
			if(!$id && $id != $pronostico->ID){
				if($model == 1){
					$html .= pronostico_1($data);
				}
				if($model == 2){
					$html .= pronostico_2($data);
				}
				if($model == 'vip'){
					$html .= pronostico_vip($data);
				}
				if($paginate){
					if(!$deporte){
						$html .= '<div class="container_pagination">
							<a href="'.home_url().'\pronostico/'.'" >Ver más</a>
						</div>';
					}
					if($deporte){
						$html .= '<div class="container_pagination">
							<a href="'.home_url().'\deportes/'.$deporte.'" >Ver más</a>
						</div>';
					}
				}	
			}	
		}
	
	return $html;
}
add_shortcode('pronostico','shortcode_pronostico');
//Sports menu
function sports_menu($attr){
	global $term;
	extract( shortcode_atts( array( 'deporte' => false,'taxonomy'=>'deportes'), $attr ) );
	$class = '' ;
	
	$html = '<div class="terms_nav">';
	$terms = get_terms(array('taxonomy'=>$taxonomy,'hidde_empty'=>false));
	
		foreach ($terms as $tax_term): if($term == $tax_term->name):$class='class="current"';endif;
			$html .= '<a '.$class.' href="'.home_url()."/".$taxonomy.'/'.$tax_term->slug .'" >
			'.$tax_term->name.'</p>
		</a>';
		endforeach;


	$html .= '</div>';
	return $html;
}
add_shortcode('sportsmenu','sports_menu');

function shortcode_slide($attr){
	extract( shortcode_atts( array( 'post_type' => 'post'), $attr ) );
	wp_enqueue_style( 'aw_slide', get_template_directory_uri() . '/assets/css/slide.css' );
	wp_register_script( 'aw_slide_scripts', get_template_directory_uri(). '/assets/js/slide_script.js');
	wp_enqueue_script( 'aw_slide_scripts' );
	$slide = '<div class="slide-contenedor" >';
	
	$posts = new wp_query(array(
		"post_type"=>$post_type,
        'meta_key' => 'fecha_partido',
        'order_by' => 'meta_value',
        'order' => 'ASC',
	));
	
		while($posts->have_posts()): $posts->the_post();
			$url_thumb = get_the_post_thumbnail_url(get_the_ID());
			$slide .='<a href="'.get_permalink().'" class="miSlider fade" >
			<img src="'.$url_thumb.'" alt="'.get_the_title().'"/>
			' ;
			
			if($post_type=='pronostico'):
				$nombre_equipo_1 = get_post_meta(get_the_ID(),"nombre_equipo_1");
				$img_equipo_1 = get_post_meta(get_the_ID(),"img_equipo_1");
				$resena_equipo_1 = get_post_meta(get_the_ID(),"resena_equipo_1");
				$average_equipo_1 = get_post_meta(get_the_ID(),"average_equipo_1");
			
				$nombre_equipo_2 = get_post_meta(get_the_ID(),"nombre_equipo_2");
				$img_equipo_2 = get_post_meta(get_the_ID(),"img_equipo_2");
				$resena_equipo_2 = get_post_meta(get_the_ID(),"resena_equipo_2");
				$average_equipo_2 = get_post_meta(get_the_ID(),"average_equipo_2");
			
				$fecha_partido = get_post_meta(get_the_ID(),"fecha_partido"); 
				$cuota_empate_pronostico = get_post_meta(get_the_ID(),"cuota_empate_pronostico");
				$slide .='
					<div class="slide_item_pronostico_top">
						<div>
							<div>
								<div class="item_w_img" >
									<img loading="lazy" src="'.$img_equipo_1[0].'" />
									<img loading="lazy" src="'.$img_equipo_2[0].'" />
								</div>
							</div>
						</div>
						<div class="date_partido" >
							<input type="hidden" id="date_slide" value="'.date("Y-m-d", $fecha_partido[0]) .'">
							<span id="slide_dias"></span><span id="slide_horas"></span><span id="slide_minutos"></span><span id="slide_segundos"></span>
							<b>DIA</b> <b>HOR</b> <b>MIN</b> <b>SEG</b>
						</div>
					</div>
					<div class="slide_item_pronostico_bottom">
						<h2>
							'.$nombre_equipo_1[0] .'
						</h2>
						<h2>
							'.$nombre_equipo_2[0] .'
						</h2>
						<div class="slide_average_pronostico" >
							<p>
								'. $average_equipo_1[0] .'%
							</p>
							<p>
								'. $cuota_empate_pronostico[0] .' %
							</p>
							<p>
								'. $average_equipo_2[0] .'%
							</p>
						</div>
					</div>';
			endif;
			if($post_type=='post'):
				$images .='<h3>'.$post->title.'</h3>';
			endif;
			//Cierre del miSlide fade
			$slide .= '
			</a>';
		endwhile;		
			
	//controles	
	$slide .= '
	
		<button class="atras" id="atras" >&#10094;</button>
		<button class="adelante" id="adelante" >&#10095;</button>
	';
	//Cierre del container_slide
	$slide .= '</div>';	

	return $slide;
}
add_shortcode('aw_slide','shortcode_slide');

//Banner top
function shortcode_banner_top($attr){
	extract( shortcode_atts( array( 
		'image' => '<img loading="lazy" src="'.get_template_directory_uri() . '/assets/images/basketball.webp'.'"/>',
		'bg_img_url' => get_template_directory_uri() . '/assets/images/banner_fondo.svg',
		'title_content' => 'titulo',
		'text_content' => 'Texto del banner',
		'url' => 'http://diazwebapp.ga',
		'slug_page' => ''
	), $attr ) );
	
	global $pagename;

	if(strtolower($pagename) == strtolower($slug_page)):
		$html = '
				<style>
					.top_banner{
						width:100%;
						height:200px;
						display:flex;
						flex-flow:row wrap;
						justify-content:space-between;
						align-items:center;
						background-image:url('.$bg_img_url.');
						background-position:center center;
						background-size:cover;
						padding:0 2%;
					}
					@medi(min-width:640px){
						.top_banner{
							padding:0 5px;
						}
					}
					@medi(min-width:960px){
						.top_banner{
							padding:0 10px;
						}
					}
					.text_content p, .text_content b{
						width:100%;
						color:white;
						padding:10px;
					}
					.text_content p{
						padding:20px;
					}
					.img_container{
						width:200px;
						height:200px;
						overflow:hidden;
					}
					.img_container img{
						width:100%;
						height:100%;
						object-fit:contain;
					}
				</style>
				<a href="'.$url.'" target="blank" class="top_banner" >
					<div class="text_content" >
						<b>'.$title_content.' - '.$pagename.'</b>
						<p>
							'.$text_content.'
						</p>
					</div>
					<div class="img_container" >
						'.$img_url.'
					</div>
				</a>
				';
	endif;
	
	return $html;
}

add_shortcode('banner_top','shortcode_banner_top');