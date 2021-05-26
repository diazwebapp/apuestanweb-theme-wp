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
    extract( shortcode_atts( array( 'limit' => false, 'style'=>false, 'model'=>'1', 'button'=>false, 'id'=>false ), $attr ) );
	$casas_apuestas = new wp_query(array(
		"post_type"=>"casaapuesta",
		"posts_per_page" => $limit
	));
	$html = '';
	wp_enqueue_style( 'casa_apuesta_css', get_template_directory_uri() . '/assets/css/tarjetita_casa_apuesta.css' );


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
			'style'			=> $style,
			'button'		=> $button
		);
		if($id && $id == $casaApuesta->ID){
			if($model == 1){
				$html .= casa_apuesta_1($data);
			}
			if($model == 2){
				$html .= casa_apuesta_2($data);
			}
		}
		if(!$id && $id != $casaApuesta->ID){
			if($model == 1){
				$html .= casa_apuesta_1($data);
			}
			if($model == 2){
				$html .= casa_apuesta_2($data);
			}
		}
		
	}
	return $html;
}
add_shortcode('casasapuesta','shortcode_casas_apuesta');
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
			<div>'.$eleccion.'</div>
			
			<div>
				<b style="color:grey;">'.$equipo_ganador.'</b>
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
		'taxonomy' => 'deporte',
		'hide_empty' => true,
	) );
	$current_user = wp_get_current_user();
	wp_enqueue_style( 'pronosticos_css', get_template_directory_uri() . '/assets/css/tarjetita_pronostico_'.$model.'.css' );
	wp_register_script('js-tarjetitas', get_template_directory_uri(). '/assets/js/js-tarjetitas.js', '1', true );
	wp_enqueue_script('js-tarjetitas');
	wp_localize_script( 'js-tarjetitas', 'taxonomy_data', array(
		'terms' => $terms,
		'post_rest_slug' => 'pronosticos',
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
    extract( shortcode_atts( array( 'limit' => false, 'style'=>false, 'model'=>'1', 'button'=>false, 'id'=>false, 'deporte'=>false  ), $attr ) );
	$pronosticos = new wp_query(array(
		"post_type"=>"pronosticos",
		"posts_per_page" => $limit,
		"tax_query" => array(
			'taxonomy' => 'deporte',
			''
		)
	));
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
		}		
	}
	
	return $html;
}

add_shortcode('pronostico','shortcode_pronostico');
//Sports menu
function sports_menu($attr){
	extract( shortcode_atts( array( 'taxonomy' => 'categories','deporte' => false), $attr ) );
	$class = '' ;
	$html = '<div class="terms_nav">';
	if ( has_nav_menu( 'sports_bar' ) ) :
		$locations = get_nav_menu_locations();
		$menu = get_term( $locations['sports_bar'], 'nav_menu' );
		$menu_items = wp_get_nav_menu_items($menu->term_id);

		foreach ($menu_items as $tax_term): if($term === $tax_term->title): 'current'; endif;?>
			<a class="<?php if($term === $tax_term->title):echo 'current'; endif; ?>" href="<?php echo $tax_term->url ;?>" >
				<?php echo $tax_term->title; ?></p>
			</a>
		<?php endforeach;

	endif;
	$html .= '</div>';
	return $html;
}