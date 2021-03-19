<div class="slide_home" >
			<?php while(have_posts()){ 
				the_post() ;
				$post_type = get_post_type(get_the_ID()); ?>

					<div class="slide_home_item" >
						<?php if(has_post_thumbnail()) : 
							the_post_thumbnail();
						else : ?> 
						<img src="https://i.pinimg.com/originals/ae/8a/c2/ae8ac2fa217d23aadcc913989fcc34a2.png" alt="">
						<?php endif; ?>
						<div class="slide_title_pronostico">
						
							<?php
								if($post_type == 'pronosticos'){ 
									$nombre_equipo_1 = get_post_meta(get_the_ID(),"nombre_equipo_1");
									$img_equipo_1 = get_post_meta(get_the_ID(),"img_equipo_1");
									$resena_equipo_1 = get_post_meta(get_the_ID(),"resena_equipo_1");
									$average_equipo_1 = get_post_meta(get_the_ID(),"average_equipo_1");
								
									$nombre_equipo_2 = get_post_meta(get_the_ID(),"nombre_equipo_2");
									$img_equipo_2 = get_post_meta(get_the_ID(),"img_equipo_2");
									$resena_equipo_2 = get_post_meta(get_the_ID(),"resena_equipo_2");
									$average_equipo_2 = get_post_meta(get_the_ID(),"average_equipo_2");
								
									$fecha_partido = get_post_meta(get_the_ID(),"fecha_partido");?>
										<h2>
											<?php echo $nombre_equipo_1[0] ?>
										</h2>
										<h2>
											<?php echo $nombre_equipo_2[0] ?>
										</h2>
										<div class="slide_average_pronostico" >
											<p><?php echo $average_equipo_1[0] ?></p>
											<p>%</p>
											<p><?php echo $average_equipo_2[0] ?></p>
										</div>
								<?php }else if($post_type == 'post'){ ?>
									<h1>
										<?php __(the_title(), 'apuestanweb_lang')  ?>
									</h1>
								<?php }
							?>
						</div>
					</div>
			<?php }  /* End while */ ?>
			</div> <!-- end div slide -->