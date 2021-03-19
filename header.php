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

		<div class="sub_header" >
			
			<div class="container" >
			<?php if ( has_nav_menu( 'sub_header' ) ) :
					$locations = get_nav_menu_locations();
					$menu = get_term( $locations['sub_header'], 'nav_menu' );
					$menu_items = wp_get_nav_menu_items($menu->term_id);
			
					foreach ($menu_items as $tax_term): ?>
						<a href="<?php echo $tax_term->url ;?>" >
							<img src="<?php if(get_taxonomy_image($tax_term->object_id)){echo get_taxonomy_image($tax_term->object_id);}else{echo 'https://cdn.iconscout.com/icon/premium/png-256-thumb/empty-80-1081639.png';} ?> " alt="<?php echo __($tax_term->title,'apuestanweb_lang') ?>"/>
							<b><?php echo $tax_term->title; ?></b>
						</a>
					<?php endforeach;

				endif;
				$data = get_terms(['taxonomy' => 'nav_menu_item','hide_empty' => false]);
				if(!$data->errors):
					foreach ($menu_items as $tax_term): ?>
						<a href="<?php echo $tax_term->url ;?>" >
							<img src="<?php if(get_taxonomy_image($tax_term->object_id)){echo get_taxonomy_image($tax_term->object_id);}else{echo 'https://cdn.iconscout.com/icon/premium/png-256-thumb/empty-80-1081639.png';} ?> " alt="<?php echo __($tax_term->title,'apuestanweb_lang') ?>"/>
							<b><?php echo $tax_term->title; ?></b>
						</a>
					<?php endforeach;
				endif; 
				if($data->errors): ?>
						<b>Añada taxonomias de tipo deportes para habilitar la navegacion</b>
				<?php endif; ?>
			</div>
		</div>

		<!-- Menu mobile-->
		<?php get_template_part('components/navigation_mobile') ?>
	