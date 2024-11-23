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
                            <h2 class="title-h2 mt-5">'.$title.'</h3>
                        </div>
                    </div> ';
    endif;
    if(!$title and $link):
        $heading = '<div class="col-12">
                        <div class="title_wrap">
                            <a href="'.$link.'" class="mt-5 dropd">'.$text_link.'</a>
                        </div>
                    </div> ';
    endif;
    if($title and $link):
        $heading = '<div class="col-12">
                        <div class="title_wrap">
                            <h2 class="title-h2 mt-5">'.$title.'</h3>
                            <a href="'.$link.'" class="mt-5 dropd">'.$text_link.'</a>
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
        $id_principal = null;
        if($post_type == "post" and $post_type == "post" and is_single()):
            $id_principal = get_the_ID();
        endif;
        
    $query = new WP_Query($args);
    if ($query->have_posts()) {    
        $ret = "<hr class='mt-4 mb-4'/><section class='row small_gutter'>";
        $ret .= $heading;
                    while ($query->have_posts()):
                        $query->the_post();
                        $id = get_the_ID();
                        if(isset($id_principal) and $id_principal !== $id ):
                            $ret .= load_template_part("/loop/posts-grid_{$model}");
                        endif;
                        if(!isset($id_principal)):
                            $ret .= load_template_part("/loop/posts-grid_{$model}");
                        endif;
                    endwhile;
        $ret .= "</section><hr class='mt-4 mb-4'/>";
    
     } else {
        $ret = '<h2>Aún no hay contenido.</h2>';
    }
    
    return $ret;
}


add_shortcode('related_posts', 'shortcode_news');