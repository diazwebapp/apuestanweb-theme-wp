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
			<?php include 'template/navigation_desktop.php' ?>
		</header>
		<div class="sub_header" >
			<div class="container" >
				<?php foreach ($posts_deportes as $key => $deporte) {
					$imagen_url = get_the_post_thumbnail_url($deporte->ID); ?>
						<a href="http://<?php if($_SERVER["SERVER_NAME"] == "localhost"){
								echo $_SERVER["HTTP_HOST"];
							}else{echo $_SERVER['SERVER_NAME']; } ?>/index.php?category=<?php echo $deporte->post_name ;?>" >
							<img src="<?php echo $imagen_url ?>" />
							<b><?php echo $deporte->post_title ;?></b>
						</a>
				<?php } ?>
			</div>
		</div>

		<!-- Menu mobile-->
		<?php include 'template/navigation_mobile.php' ?>
	<!-- banner top -->
	<?php include 'template/banner_top.php' ?>
	<main> 
		