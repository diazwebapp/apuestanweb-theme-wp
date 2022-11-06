<?php
function shortcode_forecast($atts)
{
    extract(shortcode_atts(array(
        'num' => 6,
        'league' => wp_get_post_terms(get_the_ID(), 'league', array('field' => 'slug')),
        'date' => false,
        'model' => 1,
        'text_vip_link' => 'VIP',
        'filter' => false,
        'time_format' => false,
        'paginate' => false,
        'title' => false
    ), $atts));
    $ret = "";
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
                                <option value='yesterday'> ".__('Yesterday','jbetting')." </option>
                                <option value='today'> ".__('Today','jbetting')." </option>
                                <option value='tomorrow'> ".__('Tomorrow','jbetting')." </option>
                            </select>
                        </div>
                    </div>
                    <div class='tag_wrap order-lg-2'>
                        <ul class='tag mt_25'>
                        </ul>
                    </div>
                </div>";
    endif;
    wp_reset_postdata();
    $args = [];
    $args['post_status']    = 'publish';
    $args['post_type']      = 'forecast';
    $args['paged']          = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $args['posts_per_page'] = $num;
    $args['meta_key']       = '_data';
    $args['orderby']        = 'meta_value';
    $args['order']          = 'ASC';

  
    $league_arr=[];
    
    if(is_array($league)):
        foreach ($league as $key => $value) {
            $league_arr[] = $value->slug ;
        }
    endif;
    if(!is_array($league) and is_string($league)):
        $league_arr = $league;
    endif;

    if($league !== 'all'):
        $args['tax_query'] = [
            [
                'taxonomy' => 'league',
                'field' => 'slug',
                'terms' => $league_arr
            ]
        ];
    endif;

    
    if ($date and $date != "") {
        if($date == 'today')
            $current_date = date('Y-m-d');
        if($date == 'yesterday')
            $current_date = date('Y-m-d', strtotime('-1 days'));
        if($date == 'tomorrow')
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

    
    $query = new WP_Query($args);
    
    if ($query->posts) {
        $home_class = "event_wrap pt_30";
            if($model and $model != 1)
                $home_class = 'row';        
            
        $ret .="<div class='$home_class' style='align-items:baseline;' id='games_list' >{replace_loop}</div>";
        $loop_html = '';
        foreach($query->posts as $forecast):
            $loop_html .= load_template_part("loop/pronosticos_list_{$model}",null,["forecast"=>$forecast]); 
        endforeach;
        $ret = str_replace("{replace_loop}",$loop_html,$ret);

        $jsdata = json_encode([
            "ajaxurl" => site_url() . '/wp-admin/admin-ajax.php',
            "posts" => serialize( $query->query_vars ),
            "current_page" => $args['paged'] ,
            "max_pages" => $query->max_num_pages,
            "model" => $model,
            "league" =>  $league,
            "link" => false,
            "text_link" => false,
			"vip_link" =>  PERMALINK_VIP,
			"text_vip_link" =>  $text_vip_link,
            "time_format" =>  $time_format,
            "vip "=> 'no',
            "unlock" => 'no',
            "cpt" => 'forecast',
        ]);
        wp_add_inline_script( 'common-js', "let forecasts_fetch_vars = $jsdata " );
        
        if($query->max_num_pages > 1 and $paginate=='yes'):

            $ret .="<div class='container container_pagination text-md-center'>
                <br/>
                <br/>
                <button class='loadmore forecasts btn loadbtn d-flex justify-content-center'> ".__( 'Cargar más', 'jbetting' ) ."</button><br/>
                <br/>
            </div>";
        endif;
        
    } else {
        return '<h1>No hay datos. Vuelve más tarde.</h1>';
    }
    
    return $ret;
}


add_shortcode('forecasts', 'shortcode_forecast');