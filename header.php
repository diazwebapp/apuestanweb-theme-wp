<?php global $current_user;
       
	   // Obtenemos la informacion del usuario conectado y asignamos los valores a las variables globales
	   // Mas info sobre 'get_currentuserinfo()': 
	   // http://codex.wordpress.org/Function_Reference/get_currentuserinfo
	  $current_user = wp_get_current_user();
?>
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
				$locations = get_nav_menu_locations();
				$menu = get_term( $locations['sports_bar'], 'nav_menu' );
				$menu_items = wp_get_nav_menu_items($menu->term_id); ?>
				<div class="sports_bar" >
					
					<div class="container" >
		
						<?php foreach ($menu_items as $tax_term): ?>
							<a href="<?php echo $tax_term->url ;?>" >
								<?php if(function_exists('get_taxonomy_image') && get_taxonomy_image($tax_term->object_id) != 'Please Upload Image First!'){ ?>
									<div class="icon_tag">
										<img src="<?php echo get_taxonomy_image($tax_term->object_id); ?> " alt="<?php echo __($tax_term->name,'apuestanweb_lang') ?>"/>
									</div>
								<?php }else{ ?>
									<div class="icon_tag">
										<img src='<?php echo get_the_post_thumbnail_url($tax_term->object_id) ?>' alt="<?php echo __($tax_term->name,'apuestanweb_lang') ?>"/>
									</div>
								<?php } ?>
								<p><?php echo $tax_term->title; ?></p>
							</a>
						<?php endforeach; ?>

					</div>
				</div>
			<?php endif;

		
		 get_template_part('components/navigation_mobile') ?>
	