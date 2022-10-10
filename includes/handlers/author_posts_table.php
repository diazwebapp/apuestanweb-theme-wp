<?php 
function aw_print_table($items,$post_type){
	$result = '';
    
	// field names
	while ($items->have_posts()) :
        $items->the_post();
        $meta_pick = "";
        $status_text = '';
        $predictions = carbon_get_post_meta(get_the_ID(),'predictions');
        $meta_state = carbon_get_post_meta(get_the_ID(),'status');
        $time = carbon_get_post_meta(get_the_ID(), 'data');
        $fecha = date('d M', strtotime($time));
        $teams = get_forecast_teams(get_the_ID());
        $leagues = wp_get_post_terms(get_the_ID(), 'league', array('fields' => 'all'));
        $sport = '';
        if(count($leagues) > 0):
            foreach($leagues as $league):
                if($league->parent == 0):
                    $sport = $league->name;
                endif;
            endforeach;
        endif;
        //Si es un pronostico
        if($post_type === 'forecast'):
                if($predictions and count($predictions) > 0):
                    if($meta_state and $meta_state == 'ok'):
                        $meta_pick = $predictions[0]['title'];
                        $status_text = 'Acertado';
                    endif;
                    if($meta_state and $meta_state == 'fail'):
                        $meta_pick = $predictions[0]['title'];
                        $status_text = 'No acertado';
                    endif;
                endif;
                
                if($meta_state == 'undefined')
                    $meta_state = '?';
                
                $result .= '<tr>
                    <td>'.$fecha.'</td>
                    <td>'.$sport.'</td>
                    <td>'.$teams['team1']['acronimo'].' vs '.$teams['team2']['acronimo'].'</td>
                    <td>'.$meta_pick.'</td>
                    <td>'.$status_text.'</td>
                </tr>';
        endif;
        //Si es un post
        if($post_type === 'post'):
                $result .= '<tr>
                    <td>'.$fecha.'</td>
                    <td>'.get_the_title(get_the_ID()).'</td>
                    <td>'.$sport.'</td>
                </tr>';
        endif;
    endwhile;
    wp_reset_postdata();
    if($post_type === 'forecast'):
            $template = '<table class="table">
                        <tr>
                            <th scope="col">FECHA</th>
                            <th scope="col">LIGA</th>
                            <th scope="col">PARTIDO</th>
                            <th scope="col">PICK</th>
                            <th scope="col">ESTADO</th>
                        </tr>
                        {data}
                </table>';
    endif;
    if($post_type === 'post'):
            $template = '<table class="table">
                        <tr>
                            <th scope="col">FECHA</th>
                            <th scope="col">TITULO</th>
                            <th scope="col">LIGA</th>
                        </tr>
                        {data}
                </table>';
    endif;
	return str_replace('{data}', $result, $template);
}

function aw_print_pagination($wp_query,$paged){
    $html = '<ul class="pagination_list">';
	$html .= paginate_links( array(
        'base' => str_replace(999999999,'%#%',esc_url(get_pagenum_link(999999999))),
        'current' => $paged,
        'total' => $wp_query->max_num_pages,
        'type' => 'row',
        'prev_text' => '<',
        'next_text' => '>'
    ));
    $html .= '</ul>';
    return $html;
}

function print_table($post_type,$meta_key,$author,$paginate_view){
    wp_reset_postdata();
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $args['post_type'] = $post_type;
    $args['author'] = $author;
    $args['paged'] = $paged;
    if($meta_key == 'vip'):
        $args['meta_query'] = [
            [
                'key' => 'vip',
                'value' => 'yes',
                'compare' => '='
            ]
        ];
    endif;
    if($meta_key == 'free'):
        $args['meta_query'] = [
            [
                'key' => 'vip',
                'value' => 'yes',
                'compare' => '!='
            ]
        ];
    endif;
    $query = new Wp_Query($args);
    
    $html = aw_print_table($query,$post_type);
    if($paginate_view)
        $html .= aw_print_pagination($query,$paged);
    return $html;
}