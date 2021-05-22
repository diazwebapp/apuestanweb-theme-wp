<?php
//short_codes

$style_casa_apuesta_2 = '<style>
	.tarjeta_casa_apuesta_2{
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
		max-width:320px;
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
function stars($puntuacion){
	$stars = '';
	for($i=0;$i<$puntuacion; $i++){ $stars .= '✭';}
	return $stars;
}
function shortcode_casas_apuesta($attr){ 
    extract( shortcode_atts( array( 'limit' => '' ), $attr ) );
	$c_a = new wp_query(array(
		"post_type"=>"casaapuesta",
        'posts_per_page' => $limit
	));
	
	$html = $style_casa_apuesta_2;

	while($c_a->have_posts()) : $c_a->the_post();
		$puntuacion = get_post_meta(get_the_ID(),'puntuacion_casa_apuesta')[0];
		
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
						<a href="'.get_the_permalink(get_the_ID()).'" >'. __('Start Now','apuestanweb-lang'). '</a>
					</div>
				</div>';
	endwhile; 

	return $html;
}
add_shortcode('t_casa_apuesta_2','shortcode_casas_apuesta');

function shortcode_casa_apuesta($attr){ 
    extract( shortcode_atts( array( 'id' => get_the_ID() ), $attr ) );
	
	$puntuacion = get_post_meta($id,'puntuacion_casa_apuesta')[0];
	global $style_casa_apuesta_2;
	$html = $style_casa_apuesta_2 . '<div class="tarjeta_casa_apuesta_2">
				<div style="position:relative;" >
					<img src="'. get_the_post_thumbnail_url($id,'puntuacion_casa_apuesta') .'" />
					<div class="circle" >
						<img src="'. get_post_meta($id,'url_logo_casa_apuesta')[0] .'" />
					</div>
				</div>
				<div>
					<h3 style="margin: 3px 0;">'. get_post_meta($id,'slogan_casa_apuesta')[0].'</h3>
					<div style="position:relative;"><span class="stars_content" >'. stars($puntuacion) .'</span><span>✭✭✭✭✭</span></div>
					<a href="'.get_the_permalink($id).'" >'. __('Start Now','apuestanweb-lang'). '</a>
				</div>
			</div>';
 

	return $html;
}
add_shortcode('t_casa_apuesta','shortcode_casa_apuesta');

function punt_pronostico($attr){
	extract( shortcode_atts( array( 'post_id' => get_the_ID() ), $attr ) );
	
	$html = '';
	$puntuacion = get_post_meta($post_id,'puntuacion_p')[0];
	$refear_link = get_post_meta($post_id,"refear_link")[0];
	$equipo_ganador = get_post_meta($post_id,"equipo_ganador")[0]; ?>
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
			<div>Pronostico</div>
			
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
add_shortcode('puntuacion_pronostico','punt_pronostico');
function shortcode_pronosticos_filtered($attr){
	extract( shortcode_atts( array( 'deporte' => false, 'limit' => 4 ), $attr ) );
	$terms = wp_get_object_terms( get_the_ID(),'deporte');
	if($deporte){
		$terms = get_terms('deporte');
	}
	if(!$deporte){
		$terms = wp_get_object_terms( get_the_ID(),'deporte');
	}
	$current_user = wp_get_current_user();
		wp_register_script('js-tarjetitas', get_template_directory_uri(). '/assets/js/js-tarjetitas.js', '1', true );
		wp_enqueue_script('js-tarjetitas');
		wp_localize_script( 'js-tarjetitas', 'taxonomy_data', array(
			'terms' => $terms,
			'post_rest_slug' => 'pronosticos',
			'class_container_tarjetitas' => 'container_tarjetitas',
			'class_delimiter' => 'container_pagination',
			'init' => $limit,
			'current_user' => $current_user,
		) );

		
		$html = '';
		if( $terms && !is_wp_error( $terms)):
			// get taxonomies by post type, and print loop content filtred by term taxonomi
			foreach ($terms as $term) : var_dump($term);
				if($deporte && $deporte == $term->name):
					$html .= '<div termid="'. $term->term_id . '" class="container_tarjetitas" >
					<b class="sub_title" >'. __("Pronósticos: ". strtoupper($term->name)."", 'apuestanweb-lang') .'</b>
					
				</div>
				<div class="container_pagination" ></div>';
				endif;
				if(!$deporte) :
					$html .= '<div termid="'. $term->term_id . '" class="container_tarjetitas" >
					<b class="sub_title" >'. __("Pronósticos: ". strtoupper($term->name)."", 'apuestanweb-lang') .'</b>
				
					</div>
					<div class="container_pagination" ></div>';
				endif;
	 	endforeach; endif;
		return $html ;
}
add_shortcode('all_pronosticos_filtered','shortcode_pronosticos_filtered');