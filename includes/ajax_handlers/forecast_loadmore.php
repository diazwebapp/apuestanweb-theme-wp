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
	$time_format = $_POST['time_format'];
	
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
        "text_vip_link" => $text_vip_link,
		"time_format" => $time_format
	] );
	wp_reset_postdata();
	$query = new WP_Query( $args );
	// print_r($query);
	if ( count($query->posts) > 0 ) :
		$html = '';
		if($vip == 'yes'):
			if($unlock == 'yes'):
				foreach ($query->posts as $key => $forecast):
					if($_POST['cpt'] == 'parley'):
						$html .= load_template_part("loop/parley_list_{$model}",null,["forecast"=>$forecast]);
					endif;
					if($_POST['cpt'] == 'forecast'):
						$html .= load_template_part("loop/pronosticos_vip_list_{$model}_unlock",null,["forecast"=>$forecast]); 
					endif;
				endforeach;
			else:
				foreach ($query->posts as $key => $forecast):
					if($_POST['cpt'] == 'parley'):
						$html .= load_template_part("loop/parley_list_{$model}",null,["forecast"=>$forecast]);
					endif;
					if($_POST['cpt'] == 'forecast'):
						$html .= load_template_part("loop/pronosticos_vip_list_{$model}",null,["forecast"=>$forecast]); 
					endif; 
				endforeach;
			endif;
		endif;
		if($vip != 'yes'):
			foreach ( $query->posts as $key => $forecast ):
				if($_POST['cpt'] == 'parley'):
					$html .= load_template_part("loop/parley_list_{$model}",null,["forecast"=>$forecast]);
				endif;
				if($_POST['cpt'] == 'forecast'):
					$html .= load_template_part("loop/pronosticos_list_{$model}",null,["forecast"=>$forecast]); 
				endif;
			endforeach;
		endif;
		echo $html;
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
			var time_format = '<?php echo $time_format ?>'
			const date_items_2 = document.querySelectorAll('.date_item_pronostico_top');
			if(date_items_2.length > 0){
				date_items_2.forEach(item=>{
					setInterval(()=>{
						updateCountdown(item)
					},1000)
				})
			}
		</script>
		
	<?php  endif;
	die();
}

add_action( 'wp_ajax_loadmore_forecast', 'load_forecast' );
add_action( 'wp_ajax_nopriv_loadmore_forecast', 'load_forecast' );
