<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Apuestan_web
 * @since Apuestan web 1.0
 */

get_header();

?>

	<article> 
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
			<?php } /* End while */ ?>
			</div> <!-- end div slide -->
			
			<?php if(is_front_page() && is_home()){ 
				$depo = $wpdb->get_results( 
					$wpdb->prepare("SELECT * FROM {$wpdb->prefix}posts where post_status='publish' and post_type='deporte' ")
				); 
				foreach($depo as $deporte){
					$cat_wp = get_the_category($deporte->ID);
					foreach($cat_wp as $category_wp){ ?>
						<section class="container_tarjetitas">
							<h2 class="sub_title" ><?php echo $category_wp->name; ?></h2>
							<?php include 'components/tarjetita_pronostico.php'; ?>
						</section>
					<?php }
				} 
			} ?>

			<?php if(!is_front_page() && is_home()){ ?>
				<section class="container_tarjetitas">
					<h2 class="sub_title" >Post más relevantes</h2>
					<?php include 'components/tarjetita_post.php'; ?>
				</section>
			<?php } ?>

			<?php if(!is_front_page() && !is_home()){ 
				$depo = $wpdb->get_results( 
					$wpdb->prepare("SELECT * FROM {$wpdb->prefix}posts where post_status='publish' and post_type='deporte' ")
				); 
				foreach($depo as $deporte){
					$cat_wp = get_the_category($deporte->ID);
					foreach($cat_wp as $category_wp){ ?>
						<section class="container_tarjetitas">
							<h2 class="sub_title" ><?php echo $category_wp->name; ?></h2>
							<?php include 'components/tarjetita_pronostico.php'; ?>
						</section>
					<?php }
				}  
			} ?>
	</article>

<?php include 'aside.php'; ?>

<?php get_footer();