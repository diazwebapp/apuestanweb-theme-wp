<!DOCTYPE html>
<?php
	$posts_deportes = $wpdb->get_results( 
			$wpdb->prepare("SELECT * FROM {$wpdb->prefix}posts where post_status='publish' and post_type='Deporte' ")
	); 
?>
<html <?php language_attributes(); ?>>

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" >

		<?php wp_head(); ?>

	</head>

	<body >

		<header>
			<?php get_template_part('components/navigation_desktop') ?>
		</header>

		<div class="sub_header" >
			
			<div class="container" >
			<?php if ( has_nav_menu( 'sub_header' ) ) {
					$locations = get_nav_menu_locations();
						$menu = get_term( $locations['sub_header'], 'nav_menu' );
						$menu_items = wp_get_nav_menu_items($menu->term_id);
			
				foreach ($menu_items as $tax_term) { ?>
					<a href="<?php echo $tax_term->url ;?>" >
						<img src="<?php echo get_taxonomy_image($tax_term->object_id)?> " alt="<?php echo __($tax_term->title,'apuestanweb_lang') ?>"/>
						<b><?php echo $tax_term->title; ?></b>
					</a>
				<?php }

				}else{
					foreach (get_terms(['taxonomy' => 'nav_menu_item','hide_empty' => false]) as $key => $tax_term) {
				
						?>
							<a href="<?php echo esc_attr(get_term_link($tax_term, 'deportes')) ;?>" >
								<img src="<?php echo get_taxonomy_image($tax_term->term_id)?> " alt="<?php echo __($tax_term->name,'apuestanweb_lang') ?>"/>
								<b><?php echo __($tax_term->name,'apuestanweb_lang') ;?></b>
							</a>
					<?php } 

				} ?>
				
			</div>
		</div>

		<!-- Menu mobile-->
		<?php get_template_part('components/navigation_mobile') ?>
	