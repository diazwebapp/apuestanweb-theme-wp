<?php get_header();
$faq_area = carbon_get_post_meta(get_the_ID(), 'faq');
$textbefore = carbon_get_post_meta(get_the_ID(), 'before_post');
$custom_h1 = carbon_get_post_meta(get_the_ID(), 'custom_h1');
$h1 = isset($custom_h1) ? $custom_h1 : get_the_title( get_the_ID() );
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

$headers[]= 'From: Apuestan <apuestan@gmail.com>';
    $headers[]= 'Cc: Persona1 <diazwebapp@gmail.com>';
    $headers[]= 'Cc: Persona2 <nohe.zambrano69@gmail.com>';
    
    function tipo_de_contenido_html() {
        return 'text/html';
    }
    add_filter( 'wp_mail_content_type', 'tipo_de_contenido_html' );
    wp_mail( 'erickoficial69@gmail.com',
    'Ejemplo de la función mail en WP',
    '<h1>Correo de apuestan</h1>',
    $headers
    );
 ?>

	<main>
	<?php 
	if($banner_top != 'yes'):
		if($custom_banner_top):
			echo do_shortcode($custom_banner_top);
		else:
			echo do_shortcode("[banner title='$h1']");
		endif;
	endif;
	?>
		<div class="event_area pb_90">
			<div class="container">
			<?php if($disable_sidebar == 'yes'): echo '' ; else: ?>		
				<div class="row" >
			<?php endif;?>
							
						<?php if(!$disable_sidebar or $disable_sidebar == 'no') echo '<div class="col-lg-9 mt_25">'; ?>
						
						<?php if ( have_posts() ):the_post();
						if(!$disable_title)
							echo "<h1>$h1</h1>";
							the_content();
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
				</div>
			<?php endif;?>
			</div>
			<?php 
				if($custom_banner_bottom)
					echo do_shortcode($custom_banner_bottom);
					
				if ( $faq_area ):
					echo "<div class='container_bottom'>
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
		</div>
	</main>
<?php get_footer(); ?>
