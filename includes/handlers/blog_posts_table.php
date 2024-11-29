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
                                <a href="'.get_the_permalink(get_the_ID()).'" class="blog_img">
                                    <img src="'.$thumb.'" class="w-100" alt="">
                                </a>
                            </div>
                        </div>
                                
                        <div class="blog_content">
                            <a href="'.get_the_permalink(get_the_ID()).'">
                                '.get_the_title().'
                            </a>
                            <span>#'.$sport.'</span>
                        </div>
                    </div>';
    endwhile;
    wp_reset_postdata();
	$template = '<div class="row small_gutter">
                    {data}
            </div>';

	return str_replace('{data}', $result, $template);
}

function aw_blog_posts_pagination($wp_query,$paged){
    $template = '<div class="col-lg-12">
                <div class="blog_pagination">
                    <ul class="pagination_list">
                        {pagination}
                    </ul>
                </div>
            </div>';

	$pagination = paginate_links( array(
        'base' => str_replace(999999999,'%#%',esc_url(get_pagenum_link(999999999))),
        'current' => $paged,
        'total' => $wp_query->max_num_pages,
        'type' => 'row',
        'prev_text' => '<',
        'next_text' => '>'
    ));

    return str_replace("{pagination}",$pagination,$template);
}

function blog_posts_table($post_type,$paginate,$per_page,$leagues=false){
    wp_reset_postdata();
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $args['post_type'] = $post_type;
    $args['posts_per_page'] = $per_page;
    $args['paged'] = $paged;

    if(isset($leagues) and $leagues !== '[all]'):
        $p = str_replace("[","",$leagues);
        $p = str_replace("]","",$leagues);
        $args['tax_query'] = [
            [
                'taxonomy' => 'league',
                'field' => 'slug',
                'terms' => [$p]
            ]
        ];
    endif;
    $query = new Wp_Query($args);
    
    $html = aw_blog_posts_table($query);
    if($paginate):
        $html .= aw_blog_posts_pagination($query,$paged);
    endif;
    return $html;
}