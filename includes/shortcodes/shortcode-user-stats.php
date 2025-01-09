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
        $avatar_url = get_the_author_meta( 'profile_image',$id );
        $avatar = isset($avatar_url) ? $avatar_url : get_template_directory_uri() . '/assets/img/logo2.svg';
        
    endif;
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
            
            <li class='nav-item'>
            <a class='nav-link' data-toggle='tab' href='#posts'>Picks</a>
            </li>
            </ul>
            </div>
            <div class='tab-content w-100'>
            <div id='profile' class='container tab-pane active'>
            <div class='row'>
            <div class='col-3 image-container'>
            <img class='rounded-circle' src='$avatar' width='70px' height='70px' alt='$display_name'>
            </div>
            <div class='col-8'>
            <span class='user-name'>$display_name</span>
            <p class='user-bio'>".get_the_author_meta('description', $id)."</p>
            <div class='user-social'>
            ".(get_the_author_meta('facebook', $id) ? "<a href='".get_the_author_meta('facebook', $id)."' aria-label='follow me on facebook' rel='nofollow noreferrer noopener' target='_blank'><i class='fab fa-facebook'></i></a>" : "")."
            ".(get_the_author_meta('twitter', $id) ? "<a href='".get_the_author_meta('twitter', $id)."' aria-label='follow me on twitter' rel='nofollow noreferrer noopener' target='_blank'><i class='fab fa-twitter'></i></a>" : "")."
            ".(get_the_author_meta('instagram', $id) ? "<a href='".get_the_author_meta('instagram', $id)."' aria-label='follow me on instagram' rel='nofollow noreferrer noopener' target='_blank'><i class='fab fa-instagram'></i></a>" : "")."
            </div>
            </div>
            </div>
            </div>
           
            <div id='posts' class='container tab-pane w-100'>
            <span class='section-title'>Últimos pronósticos</span>
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

// Cargar common.js condicionalmente
function load_js_user_stats() {
    global $post;
    if (isset($post) && is_a($post, 'WP_Post') && (has_shortcode($post->post_content, 'aw-login-form')) || is_single()) {
        wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/jquery-3.6.0.min.js', [], '3.6.0', true);
    }
}
add_action('wp_enqueue_scripts', 'load_js_user_stats');