<?php
function load_forecast() {
	wp_reset_postdata();
	set_query_var( 'paged' , $_POST["page"] +1 );
	$args                = unserialize( stripslashes( $_POST['query'] ) );
	$args['paged'] = get_query_var( 'paged' );
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
	
	$query = new WP_Query( $args );
	
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
			var date_items_2 = document.querySelectorAll('.date_item_pronostico_top');
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
