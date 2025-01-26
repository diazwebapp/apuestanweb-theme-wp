<?php
function shortcode_parley($atts)
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
    ), $atts));

    $ret = "";

    $geolocation = json_decode($_SESSION["geolocation"]);
    $odds = get_option( 'odds_type' );


    if($filter)
        $ret .= "<div class='row my-5'>
        <h2 class='title col-8'>$title</h2>
            <div class='col-4 justify-content-end d-flex parley-select'>
                <select name='ord' data-type='parley' id='element_select_parley' onchange='filter_date_items(this)'>
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
    $args['text_vip_link'] = $text_vip_link;
    $args['rest_uri'] = get_rest_url(null,'aw-parley/parley');
    $args['country_code'] = $geolocation->country_code;
    $args['timezone'] = $geolocation->timezone;
    $args['odds'] = $odds;
    $args["current_user_id"] =  get_current_user_id();
    $args['exclude_parley'] = null;
    $args['btn_load_more'] = "<button onclick='load_more_items(this)' data-type='parley' data-page='{$args['paged']}' id='load_more_parley' class='loadbtn btn d-flex justify-content-center py-2 px-3'> ".__( 'Cargar más', 'jbetting' ) ."</button><br/>";

    if(is_single() or is_singular()):
        $args['post__not_in']   = [get_the_ID()];
    endif;

    $params = "?paged=".$args['paged'];
    $params .= "&posts_per_page={$args['posts_per_page']}";
    $params .= isset($args['leagues']) ? "&leagues={$args['leagues']}":"";
    $params .= isset($args['date']) ? "&date={$args['date']}":"";
    $params .= "&model=$model";
    $params .= isset($args['text_vip_link']) ? "&text_vip_link={$args['text_vip_link']}":"";
    $params .= isset($args['country_code']) ? "&country_code={$args['country_code']}":"";
    $params .= isset($args['timezone']) ? "&timezone={$args['timezone']}":"";
    $params .= isset($args['exclude_parley']) ? "&exclude_parley={$args['exclude_parley']}":"";
    $params .= "&current_user_id={$args['current_user_id']}";
    $params .= "&odds=$odds";
    
    $response = wp_remote_get($args['rest_uri'] . $params, array('timeout' => 10));
    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        echo "Error: $error_message";
    } else {
        $query = wp_remote_retrieve_body($response);
        $data_json = json_decode($query);
        $loop_html = '';
        $ret .="<section id='games_list' >{replace_loop}</section>";
        $data_json = json_decode($query);
        
        $loop_html = $data_json->html;
        $ret = str_replace("{replace_loop}",$loop_html,$ret);
        
        wp_add_inline_script( 'common-js', "forecasts_fetch_vars = ". json_encode($args) );

        $ret .="<div class='container container_pagination_parley text-md-center mt-3'>";
        if($data_json->page < $data_json->max_pages):
            
            $ret .= $args['btn_load_more'];

        endif;
        $ret .=" </div>";

        $ret .= '<div class="container my-2 text-center text-muted page-status-indicator" >
                '.__("pagina ","jbetting").'
                <span id="current-page-number">'.($data_json->max_pages == 0 ? 0 :$data_json->page).' </span> de 
                <span id="max-page-number" >'.$data_json->max_pages.'</span>
                </div>';
    }

    return $ret;
}


add_shortcode('parley', 'shortcode_parley');
// Cargar common.js condicionalmente
function load_common_js_if_parley() {
    global $post;
    if (isset($post) && is_a($post, 'WP_Post') && (has_shortcode($post->post_content, 'parley') || is_single())) {
        wp_enqueue_script('common-js', get_template_directory_uri() . '/assets/js/common.js', array(), null, true);
        wp_enqueue_style( 's-parley-css', get_template_directory_uri( ) .'/assets/css/parley-styles.css', null, false, 'all' );
    }
}
add_action('wp_enqueue_scripts', 'load_common_js_if_parley');