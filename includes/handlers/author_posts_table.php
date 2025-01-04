<?php 
/* function aw_print_table($items,$post_type){
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
            $fecha = get_the_date("d M",get_the_ID());
            $permalink = get_the_permalink( get_the_ID() );
                $result .= '<tr>
                    <td>'.$fecha.'</td>
                    <td><a href="'.$permalink.'" >'.get_the_title(get_the_ID()).'</a></td>
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

function print_table($post_type,$meta_key,$author,$paginate_view=null,$page=1){
    wp_reset_postdata();
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : $page;
    
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
    if(isset($paginate_view)):
        $html .= aw_print_pagination($query,$paged);
    endif;
    return $html;
} */

if(!function_exists('generate_table_tr')){
    function generate_table_tr($query){
        $tr_pronosticos_vip = '';
        while ($query->have_posts()) :
            $query->the_post();
            $type = get_post_type();
            if($type == 'forecast'):
                // OBTENER Y CONFIGURAR FECHA
                $date = carbon_get_post_meta(get_the_ID(), 'data');
                $datetime = new DateTime($date);
                $datetime->setTimezone(new DateTimeZone($geolocation->timezone ?? 'UTC'));
                // Obtener los términos de la taxonomía personalizada 'leagues'
                $terms = get_the_terms(get_the_ID(), 'league');
                $parent_taxonomy = '';
                
                if ($terms && !is_wp_error($terms)) {
                    // Filtrar solo los términos principales (parent = 0)
                    $parent_terms = array_filter($terms, function ($term) {
                        return $term->parent === 0;
                    });

                    // Obtener los nombres de los términos principales
                    $parent_taxonomy = implode(', ', wp_list_pluck($parent_terms, 'name'));
                } else {
                    $parent_taxonomy = 'No main league assigned'; // Texto predeterminado si no hay términos principales
                }

                /////////OBTENER LOS TEAMS////////////////
                $teams = get_forecast_teams(get_the_ID(), ["w" => 50, "h" => 50]);
                $fulldate = esc_attr($datetime->format("Y-m-d H:i:s"));
                $fecha =date('d M', strtotime($fulldate));
                
                $meta_pick = "";
                $status_text = '';
                $predictions = carbon_get_post_meta(get_the_ID(),'predictions');
                $meta_state = carbon_get_post_meta(get_the_ID(),'status');
                
                if($predictions and count($predictions) > 0):
                    if($meta_state == 'ok'):
                        $meta_pick = $predictions[0]['title'];
                        $status_text = 'Acertado';
                    endif;
                    if($meta_state == 'fail'):
                        $meta_pick = $predictions[0]['title'];
                        $status_text = 'No acertado';
                    endif;
                endif;

                if($meta_state == 'undefined'):
                    $status_text = '?';
                endif;
                $tr_pronosticos_vip .= "<tr>
                                <td><time datetime='{$fulldate}'>{$fecha}</time></td>
                                <td>{$parent_taxonomy}</td>
                                <td>{$teams['team1']['name']} vs {$teams['team2']['name']}</td>
                                <td>{$meta_pick}</td>
                                <td>{$status_text}</td>
                            </tr>";
            endif;
            if($type=='post'):
                $title = get_the_title();
                $date = get_the_date();
                $datetime = new DateTime($date);
                $datetime->setTimezone(new DateTimeZone($geolocation->timezone ?? 'UTC'));
                $fulldate = esc_attr($datetime->format("Y-m-d H:i:s"));
                $fecha =date('d M', strtotime($fulldate));
                $tr_pronosticos_vip .= "<tr>
                                <td><time datetime='{$fulldate}'>{$fecha}</time></td>
                                <td>{$title}</td>
                                <td></td>
                            </tr>";
            endif;
        endwhile;
        return $tr_pronosticos_vip;
    }
}