<?php 
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