<?php

function aw_get_forecasts(WP_REST_Request $request){
    $params = $request->get_params();
    $args = [];
    $args['post_type']      = 'forecast';
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
    if($query->posts):
        foreach($query->posts as $forecast):
            if(isset($params["exclude_post"]) and $params["exclude_post"] != $forecast->ID):
                $loop_html .= load_template_part("loop/pronosticos_list_{$params['model']}",null,[
                    "forecast"=>$forecast,
                    "country_code"=>isset($params['country_code']) ? $params['country_code'] : null,
                    "timezone" => isset($params['timezone']) ? $params['timezone'] : null
                ]);
            endif;
            if(!isset($params["exclude_post"])):
                $loop_html .= load_template_part("loop/pronosticos_list_{$params['model']}",null,[
                    "forecast"=>$forecast,
                    "country_code"=>isset($params['country_code']) ? $params['country_code'] : null,
                    "timezone" => isset($params['timezone']) ? $params['timezone'] : null
                ]);
            endif;
        endforeach;
    else:
        $loop_html = "no mas";
    endif;
    echo $loop_html;
}

function aw_get_forecasts_vip(WP_REST_Request $request){
    $params = $request->get_params();
    $args = [];
    $args['post_type']      = 'forecast';
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

    $args['meta_query']     = [
        [
            'key' => 'vip',
            'value' => 'yes',
        ]
    ];

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
        "memberships_page" => PERMALINK_MEMBERSHIPS,
        "text_vip_link" => $params['text_vip_link'],
        "time_format" => isset($params['time_format']) ? $params['time_format'] : false,
        "model" => $params['model']
    ] );

    if ($query->posts):
        
        if(isset($params['unlock'])):
            
            foreach ($query->posts as $key => $forecast):
                $loop_html .= load_template_part("loop/pronosticos_vip_list_{$params['model']}_unlock",null,[
                "forecast"=>$forecast,
                "country_code"=>isset($params['country_code']) ? $params['country_code'] : null,
                "timezone" => isset($params['timezone']) ? $params['timezone'] : null
            ]); 
            endforeach;

        else:
            
            foreach ($query->posts as $key => $forecast):
                $loop_html .= load_template_part("loop/pronosticos_vip_list_{$params['model']}",null,[
                "forecast"=>$forecast,
                "country_code"=>isset($params['country_code']) ? $params['country_code'] : null,
                "timezone" => isset($params['timezone']) ? $params['timezone'] : null
            ]); 
            endforeach;
            
        endif;
        
    else:
        $loop_html = "no mas";
    endif;
    echo $loop_html;
}