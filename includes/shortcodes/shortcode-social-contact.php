<?php
function shortcode_social_contact($atts)
{
    extract(shortcode_atts(array(
        'model' => false,
        'filter' => false,
        'title' => false,
        'league' => wp_get_post_terms(get_the_ID(), 'league', array('field' => 'slug')),
        'num' => 6
    ), $atts));
    $html = '<div class="apn-social">
    <span>SIGUENOS</span>
    <a href="'.tl.'" rel="nofollow noreferrer noopener">
        <i class="fab fa-telegram-plane"></i>
    </a>                                                     
    <a href="'.fb.'" rel="nofollow noreferrer noopener">
        <i class="fab fa-facebook"></i>
    </a>                        
    <a href="'.tw.'" rel="nofollow noreferrer noopener">
        <i class="fab fa-twitter"></i>
    </a>                        
    <a href="'.ig.'" rel="nofollow noreferrer noopener">
        <i class="fab fa-instagram"></i>
    </a></div>';
    return $html;
}

add_shortcode('social_contact', 'shortcode_social_contact');