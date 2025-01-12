<?php get_header();
$textafter = carbon_get_post_meta(get_the_ID(), 'after_post');
$textbefore = carbon_get_post_meta(get_the_ID(), 'before_post');
$custom_h1 = carbon_get_post_meta(get_the_ID(), 'custom_h1');
$sidebar = carbon_get_post_meta(get_the_ID(), 'sidebar');


 ?>

	<main>
	<?php if ( $textbefore ):echo $textbefore; endif;?>
		<div class="bookmaker_wrapper">
			<div class="container">
				<div class="row">
					<div class="<?php if($sidebar == 'no'):echo 'blog_box_wrapper';else: echo 'col-lg-8 col-xl-9'; endif;?>" >
					<div class="bookmaker_heading">
						<h2><?php if(!$custom_h1): echo get_bloginfo('title') . ' Bookmakers ' ; else: echo $custom_h1; endif;  ?></h2>
					</div>
                    
                        <?php echo do_shortcode("[bookmakers]"); ?>
						<?php
                            if ( $textafter ):
								echo '<br/> <br/>' ;
                                echo $textafter;
                            endif;
                        ?>
					</div>
					<?php if($sidebar == 'yes' || !$sidebar): ?>
						<div class="col-lg-4 col-xl-3">
							<div class="row">
								<?php dynamic_sidebar( 'forecast-right' ); ?>
							</div>
						</div>
					<?php endif;?>					
				</div>
			</div>
		</div>
	</main>
<?php get_footer(); ?>