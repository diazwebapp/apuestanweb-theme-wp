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
        'paginate' => false
    ), $atts));
    $ret = "";
   
    $custom_h1 = carbon_get_post_meta(get_the_ID(), 'custom_h1');
    $title = empty($custom_h1) ? get_the_title( get_the_ID() ) : $custom_h1;

    if($filter)
        $ret .= "<div class='title_wrap'>
                    <h1 class='title mt_30 order-lg-1'>$title</h1>
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
    wp_reset_query();
    $args = [];
    $args['post_status']    = 'publish';
    $args['post_type']      = 'forecast';
    $args['posts_per_page'] = $num;
    $args['meta_key']       = '_data';
    $args['orderby']        = 'meta_value';
    $args['order']          = 'ASC';

   
    $league_arr=[];
    
    if(is_array($league))
        foreach ($league as $key => $value) {
            $league_arr[]= $value->slug ;
        }
    if(!is_array($league))
        $league_arr = explode(',',$league);
    if($league !== 'all')
        $args['tax_query'] = [
            [
                'taxonomy' => 'league',
                'field' => 'slug',
                'terms' => $league_arr
            ]
        ];

    
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
    
    if ($query->have_posts()) {
        $home_class = "event_wrap pt_30";
            if($model and $model != 1)
                $home_class = 'row';        
            
        $ret .="<div class='$home_class' style='align-items:baseline;' id='games_list' >";
                while ($query->have_posts()):
                    $query->the_post();
                    $ret .= load_template_part("loop/pronosticos_list_{$model}"); 
                endwhile; 
        $ret .="</div>";

        ?>
            <script>
                var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
                var posts = '<?php echo serialize( $query->query_vars ); ?>';
                var current_page = <?php echo ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; ?>;
                var max_pages = '<?php echo $query->max_num_pages; ?>';
                var model = '<?php echo $model ?>';
                //Parametros del shortcode 
                var time_format = '<?php echo $time_format ?>'
                var text_vip_link = '<?php echo $text_vip_link ?>'
                var vip = 'no';
                var unlock = 'no';
                var cpt = 'forecast';
            </script>

        <?php 
        if($query->max_num_pages > 1 and $paginate=='yes'):

            $ret .="<div class='container container_pagination text-md-center'>
                <br/>
                <br/>
                <button class='loadmore forecasts btn headerbtn'> ".__( 'Load more', 'jbetting' ) ."</button><br/>
                <br/>
            </div>";
        endif;
        
    } else {
        return '<h1>Nó hay datos</h1>';
    }
    
    return $ret;
}


add_shortcode('forecasts', 'shortcode_forecast');