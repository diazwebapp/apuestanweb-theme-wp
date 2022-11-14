<?php get_header();
$faq_area = wpautop(carbon_get_post_meta(get_the_ID(), 'faq'));
$textbefore = carbon_get_post_meta(get_the_ID(), 'before_post');
$custom_h1 = carbon_get_post_meta(get_the_ID(), 'custom_h1');
$disable_sidebar = carbon_get_post_meta(get_the_ID(), 'sidebar');
$banner_top = carbon_get_post_meta(get_the_ID(), 'banner_top');
$custom_banner_top = carbon_get_post_meta(get_the_ID(), 'custom_banner_top');
$custom_banner_bottom = carbon_get_post_meta(get_the_ID(), 'custom_banner_bottom');
$disable_title = carbon_get_post_meta(get_the_ID(), 'disable_title');

if ( $textbefore ):
	echo do_shortcode("{$textbefore}");
else:
	echo do_shortcode("[menu_leagues] ");
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
							
					<?php if(!$disable_sidebar or $disable_sidebar == 'no') echo '<div class="col-lg-9 mt_25">'; ?>
						
						<?php 
							if ( have_posts() ):the_post();
								if(!$disable_title):
									echo "<h1 class='title mt_30 order-lg-1' >".(!empty($custom_h1) ? $custom_h1:get_the_title(get_the_ID()))."</h1>";
								endif;

								the_content();
							endif; 

							if ( $faq_area ):
								echo "<div class='single_event_content container_bottom text-break'>
									<div class='row'>
										<div>
											<p>
												$faq_area
											</p>
										</div>
									</div>
								</div>";
							endif;
                        ?>

					<?php if(!$disable_sidebar or $disable_sidebar == 'no') echo '</div>'; ?>
				
					<?php if($disable_sidebar == 'yes'): echo '' ; else: ?> 
						<div class="col-lg-3">
							<div class="row">
								<?php dynamic_sidebar( 'forecast-right' ); ?>
							</div>
						</div>
					<?php endif;?>
			
			<?php if($disable_sidebar == 'yes'): echo '' ; else: ?>				
			<?php endif;?>
			</div>
			<?php 
				if($custom_banner_bottom)
					echo do_shortcode($custom_banner_bottom);
					
			?>
		</div>
	</main>
<?php get_footer(); ?>
