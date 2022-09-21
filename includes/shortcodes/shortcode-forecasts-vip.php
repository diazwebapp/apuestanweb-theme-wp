<?php
function shortcode_forecast_vip($atts)
{
    extract(shortcode_atts(array(
        'num' => 6,
        'league' => wp_get_post_terms(get_the_ID(), 'league', array('field' => 'slug')),
        'date' => false,
        'model' => 1,
        'unlock' => false,
        'title' => false,
        'paginate' => false,
        'text_vip_link' => 'VIP',
        'filter' => false,
    ), $atts));
    $ret = "";
    //default title
    if(!$title){
        $custom_h1 = carbon_get_post_meta(get_the_ID(), 'custom_h1');
        $title = empty($custom_h1) ? get_the_title( get_the_ID() ) : $custom_h1;
    }
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
    $args['meta_query']     = [
        [
            'key' => 'vip',
            'value' => 'yes',
        ]
    ];
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
        "memberships_page" => PERMALINK_MEMBERSHIPS,
        "text_vip_link" => $text_vip_link
    ] );

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        if(!$model || $model == 1):
            if($unlock):
                $ret .="<div class='' id='games_list' >";
                        while ($query->have_posts()):
                            $query->the_post();
                            $ret .= load_template_part("loop/pronosticos_vip_list_{$model}_unlock"); 
                        endwhile;
                $ret .="</div>";
                    else:
                        $ret .="<div class='' id='games_list' >";
                                while ($query->have_posts()):
                                    $query->the_post();
                                    $ret .= load_template_part("loop/pronosticos_vip_list_{$model}"); 
                                endwhile;
                        $ret .="</div>";
                endif;
        endif;

        ?>
            <script>
                var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
                var posts = '<?php echo serialize( $query->query_vars ); ?>';
                var current_page = <?php echo ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; ?>;
                var max_pages = '<?php echo $query->max_num_pages; ?>';
                var model = '<?php echo $model ?>';
                var text_vip_link = '<?php echo $text_vip_link ?>'
                var vip = 'yes';
                var unlock = '<?php if($unlock): echo 'yes' ;else: echo 'no' ; endif; ?>';
                var cpt = 'forecast';
            </script>

        <?php 
        if($paginate=='yes'):

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


add_shortcode('forecasts_vip', 'shortcode_forecast_vip');