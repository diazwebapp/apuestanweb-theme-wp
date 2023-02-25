<?php 
function get_forecast_teams($id,$size_logo=["w"=>30,"h"=>30]){
    $no_logo = get_template_directory_uri() . '/assets/img/logo2.svg';
    $team1 = isset(carbon_get_post_meta($id, 'team1')[0]) ? carbon_get_post_meta($id, 'team1')[0]['id']:false;
    $team2 = isset(carbon_get_post_meta($id, 'team2')[0]) ? carbon_get_post_meta($id, 'team2')[0]['id']:false;
    $teams = [
        "team1" => [
            "name" => "no team",
            "logo" => $no_logo,
            "acronimo" => ""
        ],
        "team2" => [
            "name" => "no team",
            "logo" => $no_logo,
            "acronimo" => ""
        ],
    ];
    if($team1):
        $teams['team1']['name'] = get_the_title( $team1 );
        $teams['team1']['acronimo'] = carbon_get_post_meta( $team1, 'acronimo' );
        if (carbon_get_post_meta($team1, 'team_logo')):
            $team_logo_att = carbon_get_post_meta($team1, 'team_logo');
            $teams['team1']['logo'] = wp_get_attachment_url($team_logo_att);
        endif;
    endif;
    if($team2):
        $teams['team2']['name'] = get_the_title( $team2 );
        $teams['team2']['acronimo'] = carbon_get_post_meta( $team2, 'acronimo' );
        if (carbon_get_post_meta($team2, 'team_logo')):
            $team_logo_att = carbon_get_post_meta($team2, 'team_logo');
            $teams['team2']['logo'] = wp_get_attachment_url($team_logo_att);
        endif;
    endif;
    return $teams;
} 

function get_user_stats($user_id,$vip=false,$interval_date=["start_date"=>false,"last_date"=>false],$limit=10){
    $user_stats['acertados'] = 0;
    $user_stats['fallidos'] = 0;
    $user_stats['nulos'] = 0;
    $user_stats['total'] = 0;
    $user_stats['porcentaje'] = 0;
    $user_stats['porcentaje_fallidos'] = 0;
    $user_stats['porcentaje_nulos'] = 0;
    $user_stats['tvalue'] = 0;
    
        $forecast_args['author'] = $user_id;
        $forecast_args['post_type'] = 'forecast';
        $forecast_args['post_per_page'] = $limit;
        
        $forecast_args['meta_query']     = [
            ($vip) ? [
                'key' => 'vip',
                'value'=>'yes',
                'compare' => $vip
                ] : '',
                [
                    'key'     => 'data',
                    'value'   => ($interval_date["start_date"] and $interval_date["last_date"]) ? [$interval_date["start_date"],$interval_date["last_date"]] : [],
                    'compare' => 'BETWEEN',
                    'type'    => 'DATE'
                ],
        ];

        $user_posts_query = new WP_Query($forecast_args);
        

        if($user_posts_query->have_posts()):
            //Loop de los forecasts del autor
            while($user_posts_query->have_posts()): $user_posts_query->the_post();
                
                $status = carbon_get_post_meta(get_the_ID(), 'status');
                
                $predictions = carbon_get_post_meta(get_the_ID(), 'predictions');
                if($predictions and count($predictions) > 0):
                    if($status and $status == 'ok'):
                        $user_stats['acertados'] += 1;
                        $cuote = floatval($predictions[0]['cuote']);
                        $tvalue = floatval($predictions[0]['tvalue']);
                        $inversion = $tvalue * 20;
                        $user_stats['tvalue'] += $inversion * $cuote - $inversion;
                    endif;
                    if($status and $status == 'fail'):
                        $user_stats['fallidos'] += 1;
                        $tvalue = floatval($predictions[0]['tvalue']);
                        $inversion = $tvalue * 20;
                        $user_stats['tvalue'] -= $inversion;
                    endif;
                    if($status and $status == 'null'):
                        $user_stats['nulos'] += 1;
                    endif;
                endif;
            endwhile;
            //Completando estadisticas total y porcentaje
            $user_stats['total'] = $user_stats['acertados'] + $user_stats['fallidos'] + $user_stats['nulos'] ;
            $user_stats['porcentaje'] = ($user_stats['acertados'] != 0 and $user_stats['total'] != 0) ?$user_stats['acertados'] * 100 / $user_stats['total'] : 0;
            $user_stats['porcentaje_fallidos'] = ( $user_stats['fallidos'] != 0 and $user_stats['total'] != 0) ? $user_stats['fallidos'] * 100 / $user_stats['total'] : 0;
            $user_stats['porcentaje_nulos'] = ($user_stats['nulos'] != 0 and  $user_stats['total'] != 0) ? $user_stats['nulos'] * 100 / $user_stats['total'] : 0;
        
        endif;
        wp_reset_query();
        
        return $user_stats;
}
