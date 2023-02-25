<?php
function shortcode_user_stats($atts)
{
    extract(shortcode_atts(array(
        'id' =>  !empty(get_post_field( 'post_author', get_the_ID() )) ? get_post_field( 'post_author', get_the_ID() ) : 0,
    ), $atts));
    
    if($id):
        $acerted = get_the_author_meta("forecast_acerted", $id );
        $failed = get_the_author_meta("forecast_failed", $id );
        $nulled = get_the_author_meta("forecast_nulled", $id );
        $rank = get_the_author_meta("rank", $id );
        $display_name = get_the_author_meta("display_name", $id );
        $avatar_url = get_avatar_url($id);
        $avatar = isset($avatar_url) ? $avatar_url : get_template_directory_uri() . '/assets/img/logo2.svg';
        $stats = get_user_stats($id,true);
        
    endif;
    
    $img_perc = get_template_directory_uri(  ) .'/assets/img/s56.png';
    $fail_gradient = $stats['porcentaje_fallidos'] + $stats['porcentaje_fallidos'];
    $null_gradient = $fail_gradient + $stats['porcentaje_nulos'];
    $user_permalink = (defined("PERMALINK_PROFILE") ? PERMALINK_PROFILE : '#');
    $args = array(
        'post_type' => 'forecast',
        'author' => $id,
        'posts_per_page' => 5,
      );

    $posts = get_posts($args);

    
    $ret = "<div class='user-profile'>
            <div class='tab-menu-container'>
            <ul class='nav nav-tabs flex-column'>
            <li class='nav-item'>
            <a class='nav-link active' data-toggle='tab' href='#profile'>Perfil</a>
            </li>
            <!--  <li class='nav-item'>
            <a class='nav-link' data-toggle='tab' href='$user_permalink'>Stats</a>
            </li>-->
            <li class='nav-item'>
            <a class='nav-link' data-toggle='tab' href='$user_permalink'>Picks</a>
            </li>
            </ul>
            </div>
            <div class='tab-content'>
            <div id='profile' class='container tab-pane active'>
            <div class='row'>
            <div class='col-4 image-container'>
            <img class='rounded-circle' src='$avatar' width='70px' height='70px' alt='$display_name'>
            </div>
            <div class='col-8'>
            <h2 class='user-name'>$display_name</h2>
            <p class='user-bio'>".get_the_author_meta('description', $id)."</p>
            <div class='user-social'>
            ".(get_the_author_meta('facebook', $id) ? "<a href='".get_the_author_meta('facebook', $id)."' aria-label='follow me on facebook' rel='nofollow noreferrer noopener' target='_blank'><i class='fab fa-facebook'></i></a>" : "")."
            ".(get_the_author_meta('twitter', $id) ? "<a href='".get_the_author_meta('twitter', $id)."' aria-label='follow me on twitter' rel='nofollow noreferrer noopener' target='_blank'><i class='fab fa-twitter'></i></a>" : "")."
            ".(get_the_author_meta('instagram', $id) ? "<a href='".get_the_author_meta('instagram', $id)."' aria-label='follow me on instagram' rel='nofollow noreferrer noopener' target='_blank'><i class='fab fa-instagram'></i></a>" : "")."
            </div>
            </div>
            </div>
            </div>
           <!--<div id='stats' class='container tab-pane'>
            <h3 class='text-center mb-4'>Estadísticas</h3>
             <div class='d-flex justify-content-center user-stats flex-wrap'>
                <div class='d-flex flex-column m-3 stat-box'>
                    <p class='stat-value'>$rank</p>
                    <p class='stat-label'>Profit</p>
                </div>
                <div class='d-flex flex-column m-3 stat-box'>
                    <p class='stat-value'>$acerted</p>
                    <p class='stat-label'>Aciertos</p>
                </div>
                <div class='d-flex flex-column m-3 stat-box'>
                    <p class='stat-value'>$failed</p>
                    <p class='stat-label'>Fallos</p>
                </div>
                <div class='d-flex flex-column m-3 stat-box'>
                    <p class='stat-value'>$nulled</p>
                    <p class='stat-label'>Nulos</p>
                </div>
            </div>
            </div>-->
            <div id='posts' class='container tab-pane'>
            <h3 class='section-title'>Últimos pronósticos</h3>
            <div class='list-group'>";
            foreach ($posts as $post) {
                $ret .= "
                <a href='" . get_permalink($post->ID) . "' class='list-group-item list-group-item-action d-flex align-items-center'>
                    <div class='post-title'>" . get_the_title($post->ID) . "</div>
                    <div class='ml-auto'>" . get_the_date( '', $post->ID ) . "</div>
                </a>";
            }
            $ret .= "</div></div></div>
        </div>";




  return $ret;
}

add_shortcode('user_stats', 'shortcode_user_stats');