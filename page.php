<?php get_header();
$faq_area = wpautop(carbon_get_post_meta(get_the_ID(), 'faq'));
$textbefore = carbon_get_post_meta(get_the_ID(), 'before_post');
$custom_h1 = carbon_get_post_meta(get_the_ID(), 'custom_h1');
$disable_sidebar = carbon_get_post_meta(get_the_ID(), 'sidebar');
$banner_top = carbon_get_post_meta(get_the_ID(), 'banner_top');
$custom_banner_top = carbon_get_post_meta(get_the_ID(), 'custom_banner_top');
$custom_banner_bottom = carbon_get_post_meta(get_the_ID(), 'custom_banner_bottom');
$disable_title = carbon_get_post_meta(get_the_ID(), 'disable_title');
$disable_table = carbon_get_post_meta( get_the_ID(), 'disable_table' );


if ( $textbefore ):
	echo do_shortcode("{$textbefore}");
endif;
?>

	<main>
	<?php 
	if($banner_top != 'yes'):
		if($custom_banner_top):
			echo do_shortcode($custom_banner_top);
		else:
			echo do_shortcode("[banner title=".(isset($custom_h1) ? $custom_h1:get_the_title( get_the_ID() ))."]");
		endif;
	endif;
	?>
		<div class="event_area pb_90">
			<div class="container">
			<?php if($disable_sidebar == 'yes'): echo '' ; else: ?>		
				<div class="row" >
			<?php endif;?>
							
					<?php if(!$disable_sidebar or $disable_sidebar == 'no') echo '<section class="col-lg-9 mt_25">'; ?>
						
						<?php 
							if ( have_posts() ):the_post();
							$content = get_the_content(get_the_ID()); 
							$content = str_replace(']]>', ']]>', $content);
							$formatted_content = do_shortcode($content);


								if(!$disable_title):
									echo "<h1 class='title mt_30 mb_30 order-lg-1' >".(!empty($custom_h1) ? $custom_h1:get_the_title(get_the_ID()))."</h1>";
								endif;
								

								echo "<section class='page_content text-break'>
										$formatted_content
									</section>";
								endif; 
							 if ($disable_table ):
								echo "<button class='btn btn-primary' type='button' data-toggle='collapse' data-target='#table-of-contents' aria-expanded='false' aria-controls='table-of-contents' style='font-size: 1.8rem; margin-block-start: 1rem; margin-block-end: 1rem;'>
										Tabla de Contenido
										<i class='fas fa-angle-down'></i>
									</button>

									<!-- Add the table of contents -->
									<div class='collapse' id='table-of-contents'>
										<div class='card mt-3'>
											<div class='card-header'>
												Tabla de Contenido
											</div>
											<ul class='list-group list-group-flush'>
											</ul>
										</div>
									</div>";
								endif;
							if ( $faq_area ):
								
								echo "<section class='single_event_content container_bottom text-break'>
								
									<div class='row'>
										<div>
											$faq_area										
										</div>
									</div>
								</section >";
							endif;
                        ?>

					<?php if(!$disable_sidebar or $disable_sidebar == 'no') echo '</section>'; ?>
				
					<?php if($disable_sidebar == 'yes'): echo '' ; else: ?> 
						<section class="col-lg-3">
							<div class="row">
								<?php dynamic_sidebar( 'forecast-right' ); ?>
							</div>
						</section>
					<?php endif;?>
			
			<?php if($disable_sidebar == 'yes'): echo '' ; else: ?>				
			<?php endif;?>
			</div>
			
		</div>
		<?php 
				if($custom_banner_bottom)
					echo do_shortcode($custom_banner_bottom);
					
		?>
	</main>
<?php get_footer();?>
