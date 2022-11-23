<?php

function shortcode_forecast($atts)
{
    extract(shortcode_atts(array(
        'num' => 6,
        'league' => wp_get_post_terms(get_the_ID(), 'league', array('field' => 'slug')),
        'date' => "hoy",
        'model' => 1,
        'text_vip_link' => 'VIP',
        'filter' => null,
        'time_format' => null,
        'paginate' => null,
        'title' => null
    ), $atts));

    $ret = "";

    $geolocation = json_decode($_SESSION["geolocation"]);
    $odds = get_option( 'odds_type' );
    
    if(is_page() && !$title)
        $title = get_the_title( );
    if(is_post_type_archive() && !$title)
        $title = post_type_archive_title( '', false );
    if(is_category() or is_tax())
        $title = single_term_title('',false );
    if(is_tag())
        $title = single_tag_title('',false );

    $custom_h1 = carbon_get_post_meta(get_the_ID(), 'custom_h1');
    $title = empty($custom_h1) ? $title : $custom_h1;

    if($filter):
        $ret .= "<div class='title_wrap'>
                    <h1 class='title mt_30 order-lg-1'>".(isset($title) ? $title : '')."</h1>
                    <div class='mt_30 dropd order-lg-3'>
                        <div class='blog_select_box'>
                            <select name='ord' id='element_select_forecasts'>
                                <option value=''>Ordenar</option>
                                <option value='ayer' ".( $date == 'ayer' ? 'selected' : '')." > ".__('Ayer','jbetting')." </option>
                                <option value='hoy' ".( $date == 'hoy' ? 'selected' : '')." >".__('Hoy','jbetting')." </option>
                                <option value='mañana' ".( $date == 'mañana' ? 'selected' : '')." > ".__('Mañana','jbetting')." </option>
                            </select>
                        </div>
                    </div>
                    <div class='tag_wrap order-lg-2'>
                        <ul class='tag mt_25'>
                        </ul>
                    </div>
                </div>";
    endif;
    
    $args = [];
    $league_arr = null;
    
    if(is_array($league) and count($league) > 0):
        
        $league_arr = "[{replace-leagues}]";
        $temp_leages = '';
        foreach ($league as $key => $value) {
            $temp_leages .= $value->slug.',' ;
        }
        $league_arr = str_replace("{replace-leagues}",$temp_leages,$league_arr);
    endif;
    if(!is_array($league) and is_string($league)):
        
        $league_arr = "[{replace-leagues}]";
        $league_arr = str_replace("{replace-leagues}",$league,$league_arr);
    endif;
        
    //$query = new WP_Query($args);
    $args['paged']          = ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1);
    $args['posts_per_page'] = $num;
    $args['leagues'] =  $league_arr;
    $args['date'] = $date;
    $args['model'] = $model;
    $args['time_format'] = $time_format ;
    $args['text_vip_link'] = $text_vip_link;
    $args['rest_uri'] = get_rest_url(null,'aw-forecasts/forecasts');
    $args['country_code'] = $geolocation->country_code;
    $args['timezone'] = $geolocation->timezone;
    $args['odds'] = $odds;
    $args['exclude_post'] = null;
    $args['btn_load_more'] = "<button onclick='load_more_items(this)' class='loadmore forecasts btn loadbtn d-flex justify-content-center'> ".__( 'Cargar más', 'jbetting' ) ."</button><br/>";
    $post_type = get_post_type( );
    if($post_type == "forecast" and is_single()):
        $args['exclude_post']   = get_the_ID();
    endif;
    
    $params = "?paged=".$args['paged'];
    $params .= "&posts_per_page={$args['posts_per_page']}";
    $params .= isset($args['leagues']) ? "&leagues=${args['leagues']}":"";
    $params .= isset($args['date']) ? "&date={$args['date']}":"";
    $params .= "&model=$model";
    $params .= isset($args['time_format']) ? "&time_format={$args['time_format']}":"";
    $params .= isset($args['text_vip_link']) ? "&text_vip_link={$args['text_vip_link']}":"";
    $params .= isset($args['country_code']) ? "&country_code={$args['country_code']}":"";
    $params .= isset($args['timezone']) ? "&timezone={$args['timezone']}":"";
    $params .= isset($args['exclude_post']) ? "&exclude_post={$args['exclude_post']}":"";
    $params .= "&odds=$odds";
    
    $response = wp_remote_get($args['rest_uri'].$params,array('timeout'=>10));
    
    $query =  wp_remote_retrieve_body( $response );
    
    if ($query) {
        $home_class = "event_wrap pt_30";
            if($model and $model != 1)
                $home_class = 'row';        
        
        $loop_html = ''; 
        $ret .="<div class='$home_class' style='align-items:baseline;' id='games_list' >{replace_loop}</div>";
        $data_json = json_decode($query);
        
        $loop_html = $data_json->html;
        $ret = str_replace("{replace_loop}",$loop_html,$ret);
        
        wp_add_inline_script( 'common-js', "let forecasts_fetch_vars = ". json_encode($args) );
        
        $ret .="<div class='container container_pagination text-md-center'>
                <br/>
                <br/>";
        if($paginate=='yes' and $data_json->max_pages > 0):

            $ret .=$args['btn_load_more'];
        endif;
        $ret .="
                <br/>
            </div>";
    } else {
        return '<h1>No hay datos. Vuelve más tarde.</h1>';
    }
    
    return $ret;
}


add_shortcode('forecasts', 'shortcode_forecast');