<?php
function shortcode_blog($atts)
{
    extract(shortcode_atts(array(
        'model' => false,
        'filter' => false,
        'title' => false,
        'num' => ''
    ), $atts));
    //Set default title
    if(!$title):
        $custom_h1 = carbon_get_post_meta(get_the_ID(), 'custom_h1');
        $title = empty($custom_h1) ? get_the_title( get_the_ID() ) : $custom_h1;
    endif;
    //Set search bar
    if($filter):
            $url = site_url();
            $search_icon = get_template_directory_uri() . '/assets/img/s4.png';
            $ret = '<div style="margin:20px auto;" class="col-lg-12">
                        <div class="blog_heading">
                            <h2 class="title">'.$title.'</h2>
                            <div class="blog_heading_right_content">
                                
                                <form role="search" method="get" action="'.$url.'" class="serach_box">
                                    <input type="search" id="wp-block-search__input-1" class="wp-block-search__input " name="s" placeholder="Buscar">
                                    <img src="'.$search_icon.'" alt="">
                                </form>
                            </div>
                        </div>
                    </div>';
    endif;
    $ret .= blog_posts_table('post',true,$num);
    
    return $ret;
}

add_shortcode('blog', 'shortcode_blog');