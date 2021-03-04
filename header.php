<!DOCTYPE html>
<?php
	$posts_deportes = $wpdb->get_results( 
			$wpdb->prepare("SELECT * FROM {$wpdb->prefix}posts where post_status='publish' and post_type='Deporte' ")
	); 
?>
<html <?php language_attributes(); ?>>

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >

		<?php wp_head(); ?>

	</head>

	<body >

		<header>
			<nav>	
				<?php
				//Desktop menu
					if ( has_nav_menu( 'izquierda' ) ) {

						wp_nav_menu(
							array(
								'container'  => '',
								'theme_location' => 'izquierda',
							)
						);

					}else{ ?>
						<ul>
							<li><a href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']  ?>/e-sports" >e-sports</a></li>
							<li><a href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']  ?>/blog" >blog</a></li>
						</ul>
					<?php } 
				?>
				<div id="btn_menu_mobile" >menu</div>

				<?php the_custom_logo(); ?>
					
				<?php
				//Desktop menu
					if ( has_nav_menu( 'derecha' ) ) {

						wp_nav_menu(
							array(
								'container'  => '',
								'theme_location' => 'derecha',
							)
						);

					}else{ ?>
						<ul>
							<li><a href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']  ?>/pronosticos" >pronosticos</a></li>
							<li><a href="#" >contacto</a></li>
						</ul>
					<?php } 
				?>
				<div>Contact</div>
			</nav>
		</header>
		<div class="sub_header" >
			<div class="container" >
				<?php foreach ($posts_deportes as $key => $deporte) { ?>
					<span>
						<?php echo $deporte->post_title ;?>
				</span>
				<?php } ?>
			</div>
		</div>
		<div class="menu_mobile_bg"></div>
		<div class="menu_mobile" >
			<?php
				wp_nav_menu(
					array(
						'container'  => '',
						'theme_location' => 'derecha',
					)
				);
			?>
		</div>
	
	<main> 
		