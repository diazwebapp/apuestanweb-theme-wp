<?php get_header(); ?>

<main style="margin-top:calc(var(--height-header) * 2);">
	<article>

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
										<?php __(the_title(), 'apuestanweb_lang') ?>
									</h1>
								<?php }
							?>
						</div>
					</div>
			<?php }  /* End while */ ?>
			</div> <!-- end div slide -->
			<h1>is home.php</h1>
		<?php } 
			if(!is_front_page()):
				get_template_part('template-parts/content-home'); 
			endif;
			if(is_front_page()):
				// get taxonomies by post type, and print loop content filtred by term taxonomi
				set_query_var('array_taxonomy',get_term_names(get_object_taxonomies("pronosticos")));
				get_template_part('template-parts/content-archive-pronosticos');
			endif;
			
		?>
	</article>

	<?php get_sidebar() ?>
</main>

<?php get_template_part('components/banner_footer') ?>

<?php get_footer();