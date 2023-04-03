<?php
function shortcode_profile_forecaster($atts)
{
    extract(shortcode_atts(array(
        'model' => 1,
    ), $atts));

    $ret = "";
   
    $args = [];
    $args['paged_vip']  = isset($_GET['page_vip']) ? $_GET['page_vip'] : 1 ;
    $args['paged']  = isset($_GET['current_page']) ? $_GET['current_page'] : 1 ;
    $args['paged_posts']  = isset($_GET['page_posts']) ? $_GET['page_posts'] : 1 ;
    $args['rest_uri'] = get_rest_url(null,'forecaster/forecasts');
    $args["author_id"] =  isset($_GET['profile']) ? $_GET['profile'] : 1;
    $args["posts_per_page"] = 3;
    
    $get_params_vip = "?author_id={$args["author_id"]}&post_type=forecast&vip=yes&paged={$args['paged_vip']}";
    $get_params_free = "?author_id={$args["author_id"]}&post_type=forecast&paged={$args['paged']}";
    $get_params_posts = "?author_id={$args["author_id"]}&post_type=post&paged={$args['paged_posts']}";
    
    wp_add_inline_script( 'common-js', "let forecaster_fetch_vars = ". json_encode($args) );
    //TABLE VIP
        $request_vip = wp_remote_get($args['rest_uri'].$get_params_vip,array('timeout'=>10));
        $response_vip =  wp_remote_retrieve_body( $request_vip );
        $data_json_vip = json_decode($response_vip);   
        $table_vip = $data_json_vip->html;

        $paginate_vip = '<ul class="pagination_list">
            {replace_a_vip}
            </ul>'
            ;
        $a_elements_vip = '';        
        if(intval($data_json_vip->max_pages) > 0):
            for($i=1;$i<=intval($data_json_vip->max_pages);$i++):
                $a_elements_vip .= '<a class="page-numbers '.($args['paged_vip'] == $i ? 'current' : '').'" href="?profile='.$args["author_id"].'&page_vip='.$i.'">'.$i.'</a>';
            endfor;
        endif;
        $paginate_vip = str_replace("{replace_a_vip}",$a_elements_vip,$paginate_vip);
        
        $table_vip .= $paginate_vip;
    //TABLE FREE
        $request_free = wp_remote_get($args['rest_uri'].$get_params_free,array('timeout'=>10));
        $response_free =  wp_remote_retrieve_body( $request_free );
        $data_json_free = json_decode($response_free);
        $table_free = $data_json_free->html;

        $paginate_free = '<ul class="pagination_list">
            {replace_a_vip}
            </ul>'
            ;
        $a_elements_free = '';        
        if(intval($data_json_free->max_pages) > 0):
            for($i=1;$i<=intval($data_json_free->max_pages);$i++):
                $a_elements_free .= '<a class="page-numbers '.($args['paged_vip'] == $i ? 'current' : '').'" href="?profile='.$args["author_id"].'&page_free='.$i.'">'.$i.'</a>';
            endfor;
        endif;
        $paginate_free = str_replace("{replace_a_vip}",$a_elements_free,$paginate_free);
        
        $table_free .= $paginate_free;
    //TABLE POSTS
        $request_posts = wp_remote_get($args['rest_uri'].$get_params_posts,array('timeout'=>10));
        $response_posts =  wp_remote_retrieve_body( $request_posts );
        $data_json_posts = json_decode($response_posts);
        $table_posts = $data_json_posts->html;

        $paginate_posts = '<ul class="pagination_list">
            {replace_a_posts}
            </ul>'
            ;
        $a_elements_posts = '';        
        if(intval($data_json_posts->max_pages) > 0):
            for($i=1;$i<=intval($data_json_posts->max_pages);$i++):
                $a_elements_posts .= '<a class="page-numbers '.($args['paged_posts'] == $i ? 'current' : '').'" href="?profile='.$args["author_id"].'&page_posts='.$i.'">'.$i.'</a>';
            endfor;
        endif;
        $paginate_posts = str_replace("{replace_a_posts}",$a_elements_posts,$paginate_posts);
        
        $table_posts .= $paginate_posts;
    
    $view_data = [];
    $view_data["table_forecasts_free"] = $table_free;
    $view_data["table_forecasts_vip"] = $table_vip;
    $view_data["table_forecasts_posts"] = $table_posts;
    $ret = load_template_part("loop/profile-forecaster-{$model}",null,$view_data); 

    return $ret;
}


add_shortcode('profile-forecaster', 'shortcode_profile_forecaster');