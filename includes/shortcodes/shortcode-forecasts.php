<?php
function shortcode_forecast($atts)
{
    extract(shortcode_atts(array(
        'num' => 6,
        'league' => wp_get_post_terms(get_the_ID(), 'league', array('field' => 'slug')),
        'date' => null,
        'model' => 1,
        'text_vip_link' => 'VIP',
        'filter' => null,
        'time_format' => null,
        'paginate' => null,
        'title' => null
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

    $params = "?paged=".$args['paged'];
    $params .= "&posts_per_page={$args['posts_per_page']}";
    $params .= isset($args['leagues']) ? "&leagues=${args['leagues']}":"";
    $params .= isset($args['date']) ? "&date={$args['date']}":"";
    $params .= "&model=$model";
    $params .= isset($args['time_format']) ? "&time_format={$args['time_format']}":"";
    $params .= isset($args['text_vip_link']) ? "&text_vip_link={$args['text_vip_link']}":"";

    
    $response = wp_remote_get($args['rest_uri'].$params,array('timeout'=>10));
    
    $query =  wp_remote_retrieve_body( $response );
    
    if ($query) {
        $home_class = "event_wrap pt_30";
            if($model and $model != 1)
                $home_class = 'row';        
            
        $ret .="<div class='$home_class' style='align-items:baseline;' id='games_list' >{replace_loop}</div>";
        $loop_html = $query;
        $ret = str_replace("{replace_loop}",$loop_html,$ret);
        
        wp_add_inline_script( 'common-js', "let forecasts_fetch_vars = ". json_encode($args) );
        
        if($paginate=='yes'):

            $ret .="<div class='container container_pagination text-md-center'>
                <br/>
                <br/>
                <button class='loadmore forecasts btn headerbtn'> ".__( 'Cargar más', 'jbetting' ) ."</button><br/>
                <br/>
            </div>";
        endif;
        
    } else {
        return '<h1>Nó hay datos</h1>';
    }
    
    return $ret;
}


add_shortcode('forecasts', 'shortcode_forecast');