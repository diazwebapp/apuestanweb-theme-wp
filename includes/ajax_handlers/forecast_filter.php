<?php
function filter_forecast() {
    wp_reset_postdata( );
	$args['post_status'] = 'publish';
    $args['post_type']   = $_POST['cpt'];
    $args['posts_per_page']       = 6;
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
    
    if ($fecha and $fecha != "") {
        if($fecha == 'hoy')
            $current_date = date('Y-m-d');
        if($fecha == 'ayer')
            $current_date = date('Y-m-d', strtotime('-1 days'));
        if($fecha == 'mañana')
            $current_date = date('Y-m-d',strtotime('+1 days'));
            
        $args['meta_query']   = [
                [
                    'key' => '_data',
                    'compare' => '==',
                    'value' => $current_date,
                    'type' => 'DATE'
                ]
            ];
    }
    set_query_var( 'params', [
        "vip_link" => PERMALINK_VIP,
        "text_vip_link" => $text_vip_link,
        "time_format" => $time_format
        ] );
    
    
    $query = new WP_Query( $args );
    
	// print_r($query);
	if ( count($query->posts) > 0 ) :
        $html = '';
		if($vip == 'yes'):
            $html = '';
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
		else:
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
            
        <?php 
    endif;
    
	die();
}

add_action( 'wp_ajax_filter_forecast', 'filter_forecast' );
add_action( 'wp_ajax_nopriv_filter_forecast', 'filter_forecast' );
