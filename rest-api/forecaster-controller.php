<?php

function aw_get_forecaster_data(WP_REST_Request $request){
    $params = $request->get_params();
    $author_id = isset($params["author_id"]) ? $params["author_id"] : 1;
    $paged = isset($params["paged"]) ? $params["paged"] : 1;
    $meta_key = isset($params["vip"]) ? "vip" : "free";

    wp_reset_postdata();
    $args['post_type'] = $params["post_type"];
    $args['author'] = $author_id;
    $args['paged'] = $paged;
    $args['posts_per_page'] = 2;

    if($meta_key == 'vip'):
        $args['meta_query'] = [
            [
                'key' => 'vip',
                'value' => 'yes',
                'compare' => '='
            ]
        ];
    endif;
    if($meta_key == 'free'):
        $args['meta_query'] = [
            [
                'key' => 'vip',
                'value' => 'yes',
                'compare' => '!='
            ]
        ];
    endif;
    $query = new Wp_Query($args);
    
    $html = aw_print_table($query,$params["post_type"]);
    
    $loop_html = ["status" => 'ok',"html"=>$html,"page"=>$paged,"max_pages"=>$query->max_num_pages];

    return json_decode(json_encode($loop_html));
}