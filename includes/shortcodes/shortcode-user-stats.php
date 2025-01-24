<?php
function shortcode_user_stats($atts)
{
    extract(shortcode_atts(array(
        'id' =>  !empty(get_post_field( 'post_author', get_the_ID() )) ? get_post_field( 'post_author', get_the_ID() ) : 0,
    ), $atts));
    
    if($id):
        $display_name = get_the_author_meta("display_name", $id );
        $avatar_url = get_the_author_meta( 'profile_image',$id );
        $avatar = aq_resize($avatar_url,70,70,true,true,true);
        if (!$avatar) { $avatar = get_template_directory_uri() . '/assets/img/user-svgrepo-com.svg'; }
        
    endif;
    $args = array(
        'post_type' => 'forecast', 
        'author' => $id,
        'posts_per_page' => 5,
      );

    $posts = get_posts($args);

    
    $ret = "<div class='user-profile' style='overflow-x: hidden;''>
        
            <ul class='nav nav-tabs flex-column' id='myTab' role='tablist'>
                <li class='nav-item'>
                    <a class='nav-link active' id='profile-tab' data-toggle='tab' href='#profile' aria-controls='home' aria-selected='true'>Perfil</a>
                </li>

                <li class='nav-item'>
                    <a class='nav-link' id='posts-tab' data-toggle='tab' href='#posts' aria-controls='home' aria-selected='false'>Picks</a>
                </li>
            </ul>
        
        <div class='tab-content w-100' id='myTabContent'>

            <div id='profile' class='container tab-pane fade show active' role='tabpanel' aria-labelledby='profile-tab'>
                <div class='row'>
                    <div class='col-3 image-container'>
                        <img class='rounded-circle bg-dark' loading='lazy' src='$avatar' width='70px' height='70px' alt='foto $display_name'>
                    </div>
                    <div class='col-8'>
                        <span class='user-name'>$display_name</span>
                        <p class='user-bio'>".get_the_author_meta('description', $id)."</p>
                        <div class='user-social'>
                            ".(get_the_author_meta('facebook', $id) ? "<a href='".get_the_author_meta(' facebook',
                                $id)."' aria-label='follow me on facebook' rel='nofollow noreferrer noopener'
                                target='_blank'><i class='fab fa-facebook'></i></a>" : "")."
                            ".(get_the_author_meta('twitter', $id) ? "<a href='".get_the_author_meta(' twitter', $id)."'
                                aria-label='follow me on twitter' rel='nofollow noreferrer noopener' target='_blank'><i
                                    class='fab fa-twitter'></i></a>" : "")."
                            ".(get_the_author_meta('instagram', $id) ? "<a href='".get_the_author_meta(' instagram',
                                $id)."' aria-label='follow me on instagram' rel='nofollow noreferrer noopener'
                                target='_blank'><i class='fab fa-instagram'></i></a>" : "")."
                        </div>
                    </div>
                </div>
            </div>

            <div id='posts' class='container tab-pane fade w-100' role='tabpanel' aria-labelledby='posts-tab'>
                <span class='section-title'>Últimos pronósticos</span>
                <div class='list-group'>";
            foreach ($posts as $post) {
                $ret .= "
                <a href='" . get_permalink($post->ID) . "' class='row p-1 border'>
                    <div style='font-size:.75rem !important;' class='font-weight-bold text-muted text-truncate col-12 col-lg-8'>" . get_the_title($post->ID) . "</div>
                    <div style='font-size:.75rem !important;' class='text-secondary col-12 col-lg-4'>" . get_the_date( '', $post->ID ) . "</div>
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
        //wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/jquery-3.6.0.min.js', [], '3.6.0', true);
    }
}
add_action('wp_enqueue_scripts', 'load_js_user_stats');