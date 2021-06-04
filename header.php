<!DOCTYPE html>
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

		<?php if ( has_nav_menu( 'sports_bar' ) ) :
				wp_nav_menu( array( 'container_class' => 'sports_bar', 'theme_location' => 'sports_bar' ) );
		endif;
		 get_template_part('components/navigation_mobile') ?>

		<div style="height:calc(var(--height-header) * 2.1);"></div>

	<?php if(is_active_sidebar('top_widget')) :
        dynamic_sidebar('top_widget');
    endif;
			
	