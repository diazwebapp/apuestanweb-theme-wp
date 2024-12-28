<?php 

function blog_posts_table($post_type,$paginate,$per_page,$leagues=false,$model){
   
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
    
    $html = '';
    
	// field names
	while ($query->have_posts()) :
        $query->the_post();
        $html .= load_template_part("loop/posts-grid_{$model}",null,[]);
    endwhile;
    
	$template = '<div class="row">
                    {data}
            </div>';

	$html = str_replace('{data}', $html, $template);

    if($paginate):
        //$html .= aw_blog_posts_pagination($query,$paged);
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
            'total' => $query->max_num_pages,
            'type' => 'plain',
            'prev_text' => '<',
            'next_text' => '>'
        ));
        var_dump($pagination);
        $html .= str_replace("{pagination}",$pagination,$template);
    endif;
    return $html;
}