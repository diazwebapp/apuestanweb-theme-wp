<?php
//short_code
require __DIR__ .'/models_casa_apuesta.php' ;
require __DIR__ .'/models_pronostico.php' ;
require __DIR__ .'/models_posts.php' ;

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
			foreach ($casas_apuestas->get_posts() as $casaApuesta) :
		
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
			endforeach;
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
				if($term->parent == 0):
					if($deporte && $deporte == $term->name):
						$html .= '<article termid="'. $term->term_id . '" class="container_tarjetitas_'.$model.'" >
						<b class="sub_title" >'. __("Pronósticos: ". strtoupper($term->name)."", 'apuestanweb-lang') .'</b>
						<div> </div>
					</article>
					<div class="container_pagination" ></div>';
					endif;
					if(!$deporte) :
						$html .= '<article termid="'. $term->term_id . '" class="container_tarjetitas_'.$model.'" >
						<b class="sub_title" >'. __("Pronósticos: ". strtoupper($term->name)."", 'apuestanweb-lang') .'</b>
						<div></div>
						</article>
						<div class="container_pagination" ></div>';
					endif;
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

//posts
function shortcode_posts($attr){ 
    extract( shortcode_atts( array( 'paginate'=>'no', 'limit' => -1, 'model'=>1, 'deporte'=>'all' ), $attr ) );
	$posts;
	if($deporte=='all'){
		$posts = new wp_query(array(
			"post_type"=>"post"
		));
	}
	if($deporte!='all'){
		$posts = new wp_query(array(
			"post_type"=>"post",
			"posts_per_page" => $limit,
			'tax_query'=>array(
				array(
					'taxonomy' => 'deportes',
					'field'	   => 'name',
					'terms' => $deporte
				)
			)
		));
	}
	$html = '<div class="container_posts_'.$model.'" >';
		foreach ($posts->get_posts() as $post) :
	
			$data = array(
				'thumb' 		=> get_the_post_thumbnail_url($post->ID,'post'),
				'link'			=> get_the_permalink($post->ID),
				'model'			=> $model,
				'deporte'			=> $deporte,
			);
			if($model==1){
				$html .= post_1($data,$post);
			}
			if($model==2){
				$html .= post_2($data,$post);
			}
		endforeach;
	$html .= '</div>';
		if($paginate == 'yes'){
			$html .= '<div class="container_pagination">
				<a href="'.home_url().'\blog/'.'" >Ver más</a>
			</div>';
		}
		
	
	return $html;
}
add_shortcode('aw_post_cards','shortcode_posts');
//Banner top
function shortcode_banner_top($attr){
	global $pagename;
	extract( shortcode_atts( array( 
		'image' => get_template_directory_uri() . '/assets/images/basketball.webp',
		'image_bg' => get_template_directory_uri() . '/assets/images/banner_fondo.webp',
		'title' => $pagename,
		'content' => '',
		'url' => 'http://diazwebapp.ga',
		'slug_page' => ''
	), $attr ) );
	

	if(strtolower($pagename) == strtolower($slug_page)):
		
		$html = '
				<style>
					.top_banner{
						width:100%;
						height:200px;
						display:flex;
						flex-flow:row wrap;
						align-items: center;
						justify-content:space-around;
						position:relative;
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
					.top_banner > img{
						width:100%;
						height:200px;
						position:absolute;
						top:0;
						left:0;
						z-index:1;
					}
					.text_content{
						max-height:200px;
						overflow:hidden;
						z-index:2;
						position:relative;
					}
					.text_content p, .text_content b{
						width:100%;
						color:white;
						padding:10px;
					}
					.text_content p{
						padding:20px;
					}
					.text_content b{
						font-size:21px;
					}
					.img_container{
						width:200px;
						height:200px;
						overflow:hidden;
						position:relative;
						z-index:2;
					}
					.img_container img{
						width:98%;
						height:98%;
						object-fit:contain;
					}
				</style>
				<a href="'.$url.'" target="blank" class="top_banner" >
					<img src="'.$image_bg.'" />
					<div class="text_content" >
						<b>'.$title.'</b>
						<p>
							'.$content.'
						</p>
					</div>
					<div class="img_container" >
						<img src="'.$image.'" />
					</div>
				</a>
				';
	endif;
	
	return $html;
}
add_shortcode('banner_top','shortcode_banner_top');

//bottom banner
function shortcode_banner_bottom($attr){
	global $pagename;
	extract( shortcode_atts( array( 
		'image_bg' => get_template_directory_uri() . '/assets/images/banner_fondo.webp',
		'title' => $pagename,
		'content' => '',
		'url' => 'http://diazwebapp.ga',
		'slug_page' => ''
	), $attr ) );
	

	if(strtolower($pagename) == strtolower($slug_page) || strtolower($slug_page) == 'home'):
		
		$html = '
				<style>
					.bottom_banner{
						width:100%;
						display:flex;
						flex-flow:row wrap;
						justify-content:space-around;
						align-items:center;
						position:relative;
					}
					.bottom_banner::before{
						position:absolute;
						height:200px;
						content:"";
						background:var(--primary-color);
						top:100px;
						left:0;
						right:0;
						z-index:1;
					}
					.bottom_banner > img{
						width:100%;
						height:300px;
						position:absolute;
						top:0;
						left:0;
						z-index:1;
					}
					.text_content{
						max-height:200px;
						overflow:hidden;
						z-index:2;
					}
					.text_content p, .text_content b{
						width:100%;
						color:white;
						padding:10px;
					}
					.text_content p{
						padding:20px;
					}
					.text_content b{
						font-size:21px;
					}
					.btn_container{
						width:200px;
						height:200px;
						overflow:hidden;
						z-index:2;
						display:grid;
						place-items:center;
						place-content:center;
					}
					
				</style>
				<div class="bottom_banner" >
					<img src="'.$image_bg.'" />
					<div class="text_content" >
						<b>'.$title.'</b>
						<p>
							'.$content.'
						</p>
					</div>
					<div class="btn_container" >
						<a href="http://diazwebapp.ga" target="blank" class="btn_outline_white" >Ver Anuncio</a>
					</div>
					<div style="width:100%;display:block;z-index:2;text-align:center;" >
					'.do_shortcode('[casa_apuesta limit="4" style="width:280px;margin:5px;"]').'
					</div>
				</div>
				';
	endif;
	
	return $html;
}
add_shortcode('banner_bottom','shortcode_banner_bottom');

function aw_block(){
	$html = '<div style="text-align: center;" >
		<h1>Acceso Denegado</h1>
		<a href="http://facebook.com"><h3>Adquiera Su membresia <b style="color:gold;" >VIP</b></h3></a>
		<div style="position: relative;width:250px;height:250px;margin:auto;" class="candado_svg" >
			<?xml version="1.0" encoding="iso-8859-1"?>
			<!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
			<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
				viewBox="0 0 512 512"  xml:space="preserve">
			<g>
				<g>
					<path d="M405.333,170.667v-21.333C405.333,67.008,338.347,0,256,0S106.667,67.008,106.667,149.333v21.333
						c-35.285,0-64,28.715-64,64V448c0,35.285,28.715,64,64,64h298.667c35.285,0,64-28.715,64-64V234.667
						C469.333,199.381,440.619,170.667,405.333,170.667z M149.333,149.333c0-58.816,47.851-106.667,106.667-106.667
						s106.667,47.851,106.667,106.667v21.333H149.333V149.333z M426.667,448c0,11.776-9.579,21.333-21.333,21.333H106.667
						c-11.755,0-21.333-9.557-21.333-21.333V234.667c0-11.776,9.579-21.333,21.333-21.333h298.667c11.755,0,21.333,9.557,21.333,21.333
						V448z"/>
				</g>
			</g>
			<g>
				<g>
					<path d="M256,245.333c-35.285,0-64,28.715-64,64c0,27.776,17.899,51.243,42.667,60.075v35.925
						c0,11.797,9.557,21.333,21.333,21.333c11.776,0,21.333-9.536,21.333-21.333v-35.925C302.101,360.576,320,337.109,320,309.333
						C320,274.048,291.285,245.333,256,245.333z M256,330.667c-11.755,0-21.333-9.557-21.333-21.333S244.245,288,256,288
						c11.755,0,21.333,9.557,21.333,21.333S267.755,330.667,256,330.667z"/>
				</g>
			</g>

			</svg>

		</div>
		<p>El contenido al que intenta acceder es solo para usuarios VIP!</p>
	</div>';
	return $html;
}
add_shortcode('aw_block','aw_block');