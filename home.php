<?php get_header(); ?>

<main style="margin-top:calc(var(--height-header) * 2);">
	<article> is home.php
		<?php if(have_posts()){ ?>
			<div class="slide_home" >
			<?php while(have_posts()){ 
				the_post() ;
				$post_type = get_post_type(get_the_ID()); ?>

					<div class="slide_home_item" >
						<?php the_post_thumbnail(); ?>
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
										<?php the_title() ?>
									</h1>
								<?php }
							?>
						</div>
					</div>
			<?php }  /* End while */ ?>
			</div> <!-- end div slide -->
		<?php } 
		

		if(is_front_page()){ ?>
			<section class="container_tarjetitas">
				<h2 class="sub_title" >Ultimas entradas</h2>
			<?php
				if(have_posts()){
					while(have_posts()): the_post();

						$categorias = get_the_category(get_the_ID());
						$nombre_equipo_1 = get_post_meta(get_the_ID(),"nombre_equipo_1");
						$img_equipo_1 = get_post_meta(get_the_ID(),"img_equipo_1");
						$resena_equipo_1 = get_post_meta(get_the_ID(),"resena_equipo_1");
						$average_equipo_1 = get_post_meta(get_the_ID(),"average_equipo_1");

						$nombre_equipo_2 = get_post_meta(get_the_ID(),"nombre_equipo_2");
						$img_equipo_2 = get_post_meta(get_the_ID(),"img_equipo_2");
						$resena_equipo_2 = get_post_meta(get_the_ID(),"resena_equipo_2");
						$average_equipo_2 = get_post_meta(get_the_ID(),"average_equipo_2");

						$fecha_partido = get_post_meta(get_the_ID(),"fecha_partido"); 
						
							get_template_part('template-parts/content-home', get_post_type());
							
						endwhile; 
					} ?>

				</section>
			<?php } ?>
            
	</article>

	<?php get_sidebar() ?>
</main>

<?php get_template_part('components/banner_footer') ?>

<?php get_footer();