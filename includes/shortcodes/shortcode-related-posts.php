<?php
function shortcode_news($atts)
{
    extract(shortcode_atts(array(
        'num' => 6,
        'league' => wp_get_post_terms(get_the_ID(), 'league', array('field' => 'slug')),
        'model' => 1,
        'title' => false,
        'link' => false,
        'text_link' => 'view all'
    ), $atts));
    $ret = '';
    $heading = '';

    if($title and !$link):
        $heading = '<div class="col-12">
                        <div class="title_wrap">
                            <h3 class="title mt_30">'.$title.'</h3>
                        </div>
                    </div> ';
    endif;
    if(!$title and $link):
        $heading = '<div class="col-12">
                        <div class="title_wrap">
                            <a href="'.$link.'" class="mt_30 dropd">'.$text_link.'</a>
                        </div>
                    </div> ';
    endif;
    if($title and $link):
        $heading = '<div class="col-12">
                        <div class="title_wrap">
                            <h3 class="title mt_30">'.$title.'</h3>
                            <a href="'.$link.'" class="mt_30 dropd">'.$text_link.'</a>
                        </div>
                    </div> ';
    endif;
    $args['post_status']    = 'publish';
    $args['post_type']      = 'post';
    $args['posts_per_page'] = $num;
    
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
                'terms' => $league_arr,
            ]
        ];    

        $post_type = get_post_type( );
        if($post_type == "post" and is_single()):
            var_dump("singular => ".get_the_ID());
            $id = get_the_ID();
            $args['post__not_in']   = [$id];
        endif;
        var_dump($args);
    $query = new WP_Query($args);
    if ($query->have_posts()) {    
        $ret = "<hr class='mt-2 mb-3'/><div class='row small_gutter'>";
        $ret .= $heading;
                    while ($query->have_posts()):
                        $query->the_post();
                        $ret .= load_template_part("/loop/posts-grid_{$model}");
                    endwhile;
        $ret .= "</div><hr class='mt-2 mb-3'/>";
    
     } else {
        $ret = '<h1>Nó hay datos</h1>';
    }
    
    return $ret;
}


add_shortcode('related_posts', 'shortcode_news');