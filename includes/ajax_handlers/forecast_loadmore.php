<?php
function load_forecast() {

	$args                = unserialize( stripslashes( $_POST['query'] ) );
	$args['paged'] = $_POST['page'] +1;
	$args['post_type']   = $_POST['cpt'];
	
	$model = $_POST['model'];
    $leage = $_POST['league'];
    $fecha = $_POST['date'];
    $text_vip_link = $_POST['text_vip_link'];
    $vip = $_POST['vip'];
    $unlock = $_POST['unlock'];
	
	if($vip == 'yes'):
		$args['meta_query']   = [
			[
				'key' => 'vip',
				'value' => 'yes'
			]
		];
	endif;

	set_query_var( 'params', [
        "vip_link" => PERMALINK_VIP,
        "text_vip_link" => $text_vip_link
	] );
	wp_reset_query();
	$query = new WP_Query( $args );
	// print_r($query);
	if ( $query->have_posts() ) :
		if($vip == 'yes'):
			if($unlock == 'yes'):
				while ($query->have_posts()):
					$query->the_post();
					if($_POST['cpt'] == 'parley'):
						get_template_part("loop/parley_list_{$model}");
					endif;
					if($_POST['cpt'] == 'forecast'):
						get_template_part("loop/pronosticos_vip_list_{$model}_unlock"); 
					endif;
				endwhile;
			else:
				while ($query->have_posts()):
					$query->the_post();
					if($_POST['cpt'] == 'parley'):
						get_template_part("loop/parley_list_{$model}");
					endif;
					if($_POST['cpt'] == 'forecast'):
						get_template_part("loop/pronosticos_vip_list_{$model}"); 
					endif; 
				endwhile;
			endif;
		endif;
		if($vip != 'yes'):
			while ( $query->have_posts() ): $query->the_post();
				if($_POST['cpt'] == 'parley'):
					get_template_part("loop/parley_list_{$model}");
				endif;
				if($_POST['cpt'] == 'forecast'):
					get_template_part("loop/pronosticos_list_{$model}"); 
				endif;
			endwhile;
		endif;

	endif;
	?>
		<script>
			var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
			var posts = '<?php echo serialize( $query->query_vars ); ?>';
			var current_page = <?php echo $args['paged'] ?>;
			var max_pages = '<?php echo $query->max_num_pages; ?>';
			var model = '<?php echo $model ?>';
			var league = '<?php echo $league ?>';
			var vip_link = '<?php echo $vip_link?>'
			var text_vip_link = '<?php echo $text_vip_link ?>'
			var vip =  '<?php echo $vip ?>';
			var unlock = '<?php echo $unlock ?>';
			var cpt = '<?php echo $_POST['cpt'] ?>';
		</script>
		
	<?php  
	die();
}

add_action( 'wp_ajax_loadmore_forecast', 'load_forecast' );
add_action( 'wp_ajax_nopriv_loadmore_forecast', 'load_forecast' );
