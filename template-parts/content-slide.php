<div class="slide_aw" >
			<?php if(get_query_var('blog_page')):
			
					while(get_query_var('blog_page')->have_posts()):
						get_query_var('blog_page')->the_post() ;
						$post_type = get_post_type(get_the_ID()); ?>

							<div class="slide_item" >
								<?php 
									if(has_post_thumbnail()) : 
										the_post_thumbnail();
										else : ?>
										<img src="<?php echo get_template_directory_uri(). '/assets/images/hh2.png'; ?>" alt="">
									<?php endif; 
									if($post_type=='pronosticos'): 
										$nombre_equipo_1 = get_post_meta(get_the_ID(),"nombre_equipo_1");
										$img_equipo_1 = get_post_meta(get_the_ID(),"img_equipo_1");
										$resena_equipo_1 = get_post_meta(get_the_ID(),"resena_equipo_1");
										$average_equipo_1 = get_post_meta(get_the_ID(),"average_equipo_1");
									
										$nombre_equipo_2 = get_post_meta(get_the_ID(),"nombre_equipo_2");
										$img_equipo_2 = get_post_meta(get_the_ID(),"img_equipo_2");
										$resena_equipo_2 = get_post_meta(get_the_ID(),"resena_equipo_2");
										$average_equipo_2 = get_post_meta(get_the_ID(),"average_equipo_2");
									
										$fecha_partido = get_post_meta(get_the_ID(),"fecha_partido"); ?>
										<div class="slide_item_pronosticos">
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
										</div>
									<?php endif;
									if($post_type=='post'): ?>
									<h1>
										<?php __(the_title(), 'apuestanweb-lang')  ?>
									</h1>
									<?php endif; ?>
							</div>
					<?php endwhile; endif;
					if(!get_query_var('blog_page')):
						while(have_posts()):
							the_post() ;
							$post_type = get_post_type(get_the_ID()); ?>
	
							<div class="slide_item" >
								<?php 
									if(has_post_thumbnail()) : 
										the_post_thumbnail();
										else : ?>
										<img src="<?php echo get_template_directory_uri(). '/assets/images/hh2.png'; ?>" alt="">
									<?php endif;
									if($post_type=='pronosticos'): 
										$nombre_equipo_1 = get_post_meta(get_the_ID(),"nombre_equipo_1");
										$img_equipo_1 = get_post_meta(get_the_ID(),"img_equipo_1");
										$resena_equipo_1 = get_post_meta(get_the_ID(),"resena_equipo_1");
										$average_equipo_1 = get_post_meta(get_the_ID(),"average_equipo_1");
									
										$nombre_equipo_2 = get_post_meta(get_the_ID(),"nombre_equipo_2");
										$img_equipo_2 = get_post_meta(get_the_ID(),"img_equipo_2");
										$resena_equipo_2 = get_post_meta(get_the_ID(),"resena_equipo_2");
										$average_equipo_2 = get_post_meta(get_the_ID(),"average_equipo_2");
									
										$fecha_partido = get_post_meta(get_the_ID(),"fecha_partido"); ?>
										<div class="slide_item_pronosticos">
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
										</div>
									<?php endif;
									if($post_type=='post'): ?>
									<h1>
										<?php __(the_title(), 'apuestanweb-lang')  ?>
									</h1>
									<?php endif; ?>
							</div>
					<?php endwhile; endif; ?>
			</div> <!-- end div slide -->