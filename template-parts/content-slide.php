<div class="slide-contenedor" >
	<?php 
		while(have_posts()):
			the_post() ;
				?>

			<div class="miSlider fade" >
				<?php 
					if(has_post_thumbnail()) : 
						the_post_thumbnail();
						else : ?>
						<img loading="lazy" src="<?php echo get_template_directory_uri(). '/assets/images/hh2.png'; ?>" alt="">
					<?php endif;
					if($post->post_type=='pronosticos'): 
						$nombre_equipo_1 = get_post_meta(get_the_ID(),"nombre_equipo_1");
						$img_equipo_1 = get_post_meta(get_the_ID(),"img_equipo_1");
						$resena_equipo_1 = get_post_meta(get_the_ID(),"resena_equipo_1");
						$average_equipo_1 = get_post_meta(get_the_ID(),"average_equipo_1");
					
						$nombre_equipo_2 = get_post_meta(get_the_ID(),"nombre_equipo_2");
						$img_equipo_2 = get_post_meta(get_the_ID(),"img_equipo_2");
						$resena_equipo_2 = get_post_meta(get_the_ID(),"resena_equipo_2");
						$average_equipo_2 = get_post_meta(get_the_ID(),"average_equipo_2");
					
						$fecha_partido = get_post_meta(get_the_ID(),"fecha_partido"); 
						$cuota_empate_pronostico = get_post_meta(get_the_ID(),"cuota_empate_pronostico");?>
						<div class="slide_item_pronostico_top">
							<div>
								<div>
									<div class="item_w_img" >
										<img loading="lazy" src="<?php if($img_equipo_1[0]){ echo $img_equipo_1[0];}else{ echo get_template_directory_uri(). '/assets/images/icon.png'; } ?> " />
										<img loading="lazy" src="<?php if($img_equipo_2[0]){ echo $img_equipo_2[0];}else{ echo get_template_directory_uri(). '/assets/images/icon.png'; } ?> " />
									</div>
								</div>
							</div>
							<div class="date_partido" >
								<input type="hidden" id="date_slide" value="<?php echo $fecha_partido[0] ?>">
								<span id="slide_dias"></span><span id="slide_horas"></span><span id="slide_minutos"></span><span id="slide_segundos"></span>
								<b>DIA</b> <b>HOR</b> <b>MIN</b> <b>SEG</b>
							</div>
						</div>
						<div class="slide_item_pronostico_bottom">
							<h2>
								<?php echo $nombre_equipo_1[0] ?>
							</h2>
							<h2>
								<?php echo $nombre_equipo_2[0] ?>
							</h2>
							<div class="slide_average_pronostico" >
								<p>
									<?php echo ceil(1 / $average_equipo_1[0] * 100)  ?>%
								</p>
								<p>
									<?php echo ceil(1 / $cuota_empate_pronostico[0] * 100) ?> %
								</p>
								<p>
									<?php echo ceil(1 / $average_equipo_2[0] * 100)  ?>%
								</p>
							</div>
						</div>
					<?php endif; ?>
					<?php if($post->post_type=='post'): ?>
						<h3><?php the_title() ?></h3>
					<?php endif; ?>
			</div>
	<?php endwhile; ?>

			<div class="filter_slide"></div>
			<div class="direcciones">
				<button class="atras" id="atras" >&#10094;</button>
				<button class="adelante" id="adelante" >&#10095;</button>
			</div>
	</div> <!-- end div slide -->