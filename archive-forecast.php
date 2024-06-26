<?php get_header();
$textafter = carbon_get_post_meta(get_the_ID(), 'after_post');
$textbefore = carbon_get_post_meta(get_the_ID(), 'before_post');
$custom_h1 = carbon_get_post_meta(get_the_ID(), 'custom_h1');
$sidebar = carbon_get_post_meta(get_the_ID(), 'sidebar');
// logo
$page_logo_att = carbon_get_post_meta(get_the_ID(), 'mini_img');
if($page_logo_att){
    $page_logo_src = aq_resize(wp_get_attachment_url($page_logo_att), 50, 50, true, true, true);
}else{
    $page_logo_src = false;
}

// background
$thumbnail_url = aq_resize(get_the_post_thumbnail_url(get_the_ID()), 600, 200, true, true, true);
$term_page_att = carbon_get_post_meta(get_the_ID(), 'wbg');
if($term_page_att){
    $thumbnail_url = aq_resize(wp_get_attachment_url($term_page_att), 600, 200, true, true, true);
}
if(!$thumbnail_url): $thumbnail_url = false; endif;
if(!$custom_h1)
	$custom_h1 = ' Forecast ';

 ?>

	<main>
	<?php if ( $textbefore ):echo $textbefore; endif;?>
	<?php echo do_shortcode('[banner] ') ?>
		<div class="event_area pb_90">
			<div class="container">
				<div class="row">
					<div class="<?php if($sidebar == 'no'):echo 'blog_box_wrapper';else: echo 'col-lg-9 mt_25'; endif;?>" >
					<div class="title_wrap">
						<h1 class="title mt_30 order-lg-1"><?php echo $custom_h1 ?></h1>
					</div>
						<?php echo do_shortcode("[forecasts model='2' paginate='yes']") ?>
						<?php
                            if ( $textafter ):
								echo '<br/> <br/>' ;
                                echo apply_filters( 'the_content', $textafter );
                            endif;
                        ?>
					</div>
					<?php if($sidebar == 'yes' || !$sidebar): ?>
						<div class="col-lg-3">
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
