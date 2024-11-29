<?php 
function aw_blog_posts_table($items){
    $result = '';
    
    // field names
    while ($items->have_posts()) :
        $items->the_post();
        $thumb = get_the_post_thumbnail_url(get_the_ID());
        $leagues = wp_get_post_terms(get_the_ID(), 'league', array('fields' => 'all'));
        $sport = '';
        if(count($leagues) > 0):
            foreach($leagues as $league):
                if($league->parent == 0):
                    $sport = $league->name;
                endif;
            endforeach;
        endif;
        $result .= '<div class="col-lg-3 col-md-4 col-6 mt-4">
                        <div class="blog_box">
                            <div class="img_box">
                                <a href="' . get_the_permalink() . '"><img src="' . esc_url($thumb) . '" alt="' . esc_attr(get_the_title()) . '"></a>
                            </div>
                            <div class="text_box">
                                <h4><a href="' . get_the_permalink() . '">' . esc_html(get_the_title()) . '</a></h4>
                                <p>' . esc_html($sport) . '</p>
                            </div>
                        </div>
                    </div>';
    endwhile;

    return $result;
}

function blog_posts_table($post_type, $paginate, $per_page, $leagues = false){
    wp_reset_postdata();
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    
    $args = [
        'post_type' => $post_type,
        'posts_per_page' => $per_page,
        'paged' => $paged,
    ];
    
    if (isset($leagues) && $leagues !== '[all]'):
        $args['tax_query'] = [
            [
                'taxonomy' => 'league',
                'field'    => 'slug',
                'terms'    => $leagues,
            ],
        ];
    endif;
    
    $wp_query = new WP_Query($args);
    $template = '<div class="row">{pagination}</div>';
    
    $pagination = paginate_links([
        'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
        'current'   => $paged,
        'total'     => $wp_query->max_num_pages,
        'type'      => 'plain',
        'prev_text' => '<',
        'next_text' => '>',
    ]);

    return str_replace("{pagination}", $pagination, $template ?? '');
}
