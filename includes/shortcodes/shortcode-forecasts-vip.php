<?php
function shortcode_forecast_vip($atts)
{
    extract(shortcode_atts(array(
        'num' => 6,
        'league' => wp_get_post_terms(get_the_ID(), 'league', array('field' => 'slug')),
        'date' => null,
        'model' => 1,
        'unlock' => null,
        'title' => null,
        'text_vip_link' => 'VIP',
        'time_format' => null,
        'filter' => null
    ), $atts));
    $ret = "";

    $geolocation = json_decode($_SESSION["geolocation"]);
    $odds = get_option( 'odds_type' );

    
    if($filter)
        $ret .= "<div class='row'>
        <h2 class='title col-8'>$title</h2>       
            <div class='col-4 event_select d-flex justify-content-end'>
                <select name='ord' data-type='forecast_vip' id='element_select_forecasts' onchange='filter_date_items(this)'>
                    <option value='' ".( !$date ? 'selected' : '').">".__('Todo','jbetting')."</option>
                    <option value='ayer' ".( $date == 'ayer' ? 'selected' : '')." > ".__('Ayer','jbetting')." </option>
                    <option value='hoy' ".( $date == 'hoy' ? 'selected' : '')." >".__('Hoy','jbetting')." </option>
                    <option value='mañana' ".( $date == 'mañana' ? 'selected' : '')." > ".__('Mañana','jbetting')." </option>
                </select>
            </div>
        
    </div>";

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
    $args['unlock'] = $unlock;
    $args['time_format'] = $time_format ;
    $args['text_vip_link'] = $text_vip_link;
    $args['rest_uri'] = get_rest_url(null,'aw-forecasts/forecasts/vip');
    $args['country_code'] = $geolocation->country_code;
    $args["current_user_id"] =  get_current_user_id();
    $args['odds'] = $odds;
    $args['timezone'] = $geolocation->timezone;
    $args['btn_load_more'] = "<button onclick='load_more_items(this)' data-page='{$args['paged']}' data-type='forecast_vip' id='load_more_forecast_vip' class='loadbtn btn d-flex justify-content-center py-2 px-3'> ".__( 'Cargar más', 'jbetting' ) ."</button><br/>";


    $params = "?paged=".$args['paged'];
    $params .= "&posts_per_page={$args['posts_per_page']}";
    $params .= isset($args['leagues']) ? "&leagues={$args['leagues']}":"";
    $params .= isset($args['date']) ? "&date={$args['date']}":"";
    $params .= "&model=$model";
    $params .= isset($args['unlock']) ? "&unlock={$args['unlock']}":"";
    $params .= isset($args['time_format']) ? "&time_format={$args['time_format']}":"";
    $params .= isset($args['text_vip_link']) ? "&text_vip_link={$args['text_vip_link']}":"";
    $params .= isset($args['country_code']) ? "&country_code={$args['country_code']}":"";
    $params .= isset($args['timezone']) ? "&timezone={$args['timezone']}":"";
    $params .= "&current_user_id={$args['current_user_id']}";
    $params .= "&odds=$odds";
    
    $response = wp_remote_get($args['rest_uri'].$params,array('timeout'=>10));
    
    $query =  wp_remote_retrieve_body( $response );
    
    set_query_var( 'params', [
        "vip_link" => PERMALINK_VIP,
        "text_vip_link" => $text_vip_link
    ] );

    if ($query):
        
        $loop_html = '';
        $ret .="<div id='games_list' >{replace_loop}</div>";
        $data_json = json_decode($query);
        $loop_html = $data_json->html;

        $ret = str_replace("{replace_loop}",$loop_html,$ret);
        
        wp_add_inline_script( 'common-js', "let forecasts_fetch_vars = ". json_encode($args) );

        $ret .="<div class='container container_pagination_forecast_vip text-md-center mt-2'>";
        if($data_json->page < $data_json->max_pages):
            
            $ret .= $args['btn_load_more'];
            
        endif;
        $ret .=" </div>";

        $ret .= '<div class="container my-2 text-center text-muted page-status-indicator" >
                '.__("pagina ","jbetting").'
                <span id="current-page-number">'.($data_json->max_pages == 0 ? 0 :$data_json->page).' </span> de 
                <span id="max-page-number" >'.$data_json->max_pages.'</span>
                </div>';
    else:
        return '<h2>Aún no hay contenido.</h2>';
    endif;

    return $ret;
}


add_shortcode('forecasts_vip', 'shortcode_forecast_vip');