<?php
function shortcode_parley_vip($atts)
{
    extract(shortcode_atts(array(
        'num' => 6,
        'league' => wp_get_post_terms(get_the_ID(), 'league', array('field' => 'slug')),
        'date' => null,
        'model' => 1,
        'title' => null,
        'paginate' => null,
        'text_vip_link' => 'VIP',
        'filter' => null,
        'time_format' => null,
        'unlock' => null
    ), $atts));
    global $post;

    if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'parley_vip' ) ) {
        wp_enqueue_style( 's-parley-css', get_template_directory_uri( ) .'/assets/css/parley-styles.css', null, false, 'all' );
    }else if(is_single(  )){
        wp_enqueue_style( 's-parley-css', get_template_directory_uri( ) .'/assets/css/parley-styles.css', null, false, 'all' );
    }

    $ret = "";

    $geolocation = json_decode($_SESSION["geolocation"]);
    $odds = get_option( 'odds_type' );
    
    //default title
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
    
    if($filter)
        $ret .= "<div class='row my-5'>
        <h1 class='title col-8'>$title</h1>       
            <div class='col-4 justify-content-end d-flex parley-select'>
                <select name='ord' data-type='parley_vip' id='element_select_parley' onchange='filter_date_items(this)'>
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
    $args['rest_uri'] = get_rest_url(null,'aw-parley/parley/vip');
    $args['country_code'] = $geolocation->country_code;
    $args['odds'] = $odds;
    $args['timezone'] = $geolocation->timezone;
    $args['btn_load_more'] = "<button onclick='load_more_items(this)' data-type='parley_vip' id='load_more_parley_vip' class='loadbtn btn d-flex justify-content-center mt-5'> ".__( 'Cargar más', 'jbetting' ) ."</button><br/>";


    $params = "?paged=".$args['paged'];
    $params .= "&posts_per_page={$args['posts_per_page']}";
    $params .= isset($args['leagues']) ? "&leagues=${args['leagues']}":"";
    $params .= isset($args['date']) ? "&date={$args['date']}":"";
    $params .= "&model=$model";
    $params .= isset($args['unlock']) ? "&unlock={$args['unlock']}":"";
    $params .= isset($args['time_format']) ? "&time_format={$args['time_format']}":"";
    $params .= isset($args['text_vip_link']) ? "&text_vip_link={$args['text_vip_link']}":"";
    $params .= isset($args['country_code']) ? "&country_code={$args['country_code']}":"";
    $params .= isset($args['timezone']) ? "&timezone={$args['timezone']}":"";
    $params .= "&odds=$odds";
    
    $response = wp_remote_get($args['rest_uri'].$params,array('timeout'=>10));
    
    $query =  wp_remote_retrieve_body( $response );
    
    set_query_var( 'params', [
        "vip_link" => PERMALINK_VIP,
        "memberships_page" => PERMALINK_MEMBERSHIPS,
        "text_vip_link" => $text_vip_link
    ] );

    if ($query):
        
        $loop_html = '';
        $ret .="<div id='games_list' >{replace_loop}</div>";
        $data_json = json_decode($query);
        $loop_html = $data_json->html;

        $ret = str_replace("{replace_loop}",$loop_html,$ret);
        
        wp_add_inline_script( 'common-js', "let forecasts_fetch_vars = ". json_encode($args) );

        $ret .="<div class='container container_pagination_parley_vip text-md-center'>";
        if($paginate=='yes' and $data_json->max_pages > 1):

            $ret .=$args['btn_load_more'];
        endif;
        $ret .="</div>";
    else:
        return '<h1>Nó hay datos</h1>';
    endif;

    return $ret;
}


add_shortcode('parley_vip', 'shortcode_parley_vip');