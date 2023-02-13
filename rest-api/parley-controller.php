<?php

function aw_get_parleys(WP_REST_Request $request){
    $params = $request->get_params();
    $args = [];
    $args['post_type']      = 'parley';
    $args['paged']          = isset($params['paged']) ? $params['paged'] : 1;
    $args['posts_per_page'] = isset($params['posts_per_page']) ? $params['posts_per_page'] : 1;
    $args['meta_key']       = '_data';
    $args['orderby']        = 'meta_value';
    $args['order']          = 'ASC';

    if(isset($params['leagues']) and $params['leagues'] !== '[all]'):
        $p = str_replace("[","",$params['leagues']);
        $p = str_replace("]","",$params['leagues']);
        $args['tax_query'] = [
            [
                'taxonomy' => 'league',
                'field' => 'slug',
                'terms' => [$p]
            ]
        ];
    endif;

    if (isset($params['date'])) {
        if($params['date'] == 'hoy')
            $current_date = date('Y-m-d');
        if($params['date'] == 'ayer')
            $current_date = date('Y-m-d', strtotime('-1 days'));
        if($params['date'] == 'mañana')
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
    //var_dump($args);
    $query = new WP_Query($args);
    $loop_html = ["args"=>$args,"status" => 'ok',"html"=>'',"max_pages"=>$query->max_num_pages,"page"=>$args['paged']];
    
    set_query_var( 'params', [
        "vip_link" => PERMALINK_VIP,
        "text_vip_link" => $params['text_vip_link'],
        "time_format" => isset($params['time_format']) ? $params['time_format'] : null,
        "model" => $params['model']
    ] );

    if ($query->have_posts()) :

        while ($query->have_posts()):
            $query->the_post();
            $loop_html["html"] .= load_template_part("loop/parley_list_{$params['model']}",null,[
                "country_code"=>isset($params['country_code']) ? $params['country_code'] : null,
                "timezone" => isset($params['timezone']) ? $params['timezone'] : null,
                "odds" => isset($params['odds']) ? $params['odds'] : null
        ]); 
        endwhile;

    else:
        $home_url = get_home_url( null, '/', null );
        $loop_html["status"] = 'fail';
        $loop_html["html"] = '<div class="container">
        <div class="row mt-5">
          <div class="col-md-6 offset-md-3">
            <div class="jumbotron">
                <h2 class="display-5 col-aw">'.__("Sin pronósticos disponibles.","jbetting").'</h2>
                <p class="small col-aw"><strong>'.__("Regresa más tarde para ver los pronósticos.","jbetting").'</strong></p>
              <hr class="my-4">
              <a href="'.$home_url.'" class="button btn-lg">'.__("Ir al Inicio","jbetting").'</a>
            </div>
          </div>
        </div>
      </div>';

    endif;

    return json_decode(json_encode($loop_html));
}
