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
        $args['tax_query'] = [
            [
                'taxonomy' => 'league',
                'field' => 'slug',
                'terms' => $params['leagues']
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
    $query = new WP_Query($args);
    $loop_html = '';
    
    set_query_var( 'params', [
        "vip_link" => PERMALINK_VIP,
        "text_vip_link" => $params['text_vip_link'],
        "time_format" => isset($params['time_format']) ? $params['time_format'] : null,
        "model" => $params['model']
    ] );

    if ($query->have_posts()) :
        /* Si se necesita mostrar post relacionador excluyendo el post actual (single-parley)
        foreach($query->posts as $forecast):
            if(isset($params["exclude_post"]) and $params["exclude_post"] != $forecast->ID):
                $loop_html .= load_template_part("loop/pronosticos_list_{$params['model']}",null,[
                    "forecast"=>$forecast,
                    "country_code"=>isset($params['country_code']) ? $params['country_code'] : null,
                    "timezone" => isset($params['timezone']) ? $params['timezone'] : null,
                    "odds" => isset($params['odds']) ? $params['odds'] : null
                ]);
            endif;
            if(!isset($params["exclude_post"])):
                $loop_html .= load_template_part("loop/pronosticos_list_{$params['model']}",null,[
                    "forecast"=>$forecast,
                    "country_code"=>isset($params['country_code']) ? $params['country_code'] : null,
                    "timezone" => isset($params['timezone']) ? $params['timezone'] : null,
                    "odds" => isset($params['odds']) ? $params['odds'] : null
                ]);
            endif;
        endforeach; */
        while ($query->have_posts()):
            $query->the_post();
            $loop_html .= load_template_part("loop/parley_list_{$params['model']}",null,[
                "country_code"=>isset($params['country_code']) ? $params['country_code'] : null,
                "timezone" => isset($params['timezone']) ? $params['timezone'] : null,
                "odds" => isset($params['odds']) ? $params['odds'] : null
        ]); 
        endwhile;

    else:

        $loop_html = "no mas";

    endif;

    echo $loop_html;
}
