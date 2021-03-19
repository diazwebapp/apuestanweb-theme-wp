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
							<img src="<?php if(function_exists('get_taxonomy_image') && get_taxonomy_image($tax_term->object_id)){echo get_taxonomy_image($tax_term->object_id);}else{echo 'https://cdn.iconscout.com/icon/premium/png-256-thumb/empty-80-1081639.png';} ?> " alt="<?php echo __($tax_term->title,'apuestanweb_lang') ?>"/>
							<b><?php echo $tax_term->title; ?></b>
						</a>
					<?php endforeach;

				endif;
				$data = get_terms(['taxonomy' => 'deportes','hide_empty' => false]);
				if(empty($data->errors)):
					foreach ($data as $tax_term): ?>
						<a href="/index.php/<?php echo $tax_term->taxonomy.'/'.$tax_term->slug ;?>" >
							<img src="<?php if(function_exists('get_taxonomy_image') && get_taxonomy_image($tax_term->term_id)){echo get_taxonomy_image($tax_term->term_id);}else{echo 'https://cdn.iconscout.com/icon/premium/png-256-thumb/empty-80-1081639.png';} ?> " alt="<?php echo __($tax_term->name,'apuestanweb_lang') ?>"/>
							<b><?php echo $tax_term->name; ?></b>
						</a>
					<?php endforeach;
				endif; 
				if($data->errors): ?>
						<b><?php __('Añada un menu sub_header', 'apuestanweb_lang') ?></b>
				<?php endif; ?>
			</div>
		</div>

		<!-- Menu mobile-->
		<?php get_template_part('components/navigation_mobile') ?>
	