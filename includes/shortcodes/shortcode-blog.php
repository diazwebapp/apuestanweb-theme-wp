<?php
function shortcode_blog($atts)
{
    extract(shortcode_atts(array(
        'model' => false,
        'filter' => false,
        'title' => false,
        'league' => wp_get_post_terms(get_the_ID(), 'league', array('field' => 'slug')),
        'paginate' => false,
        'num' => 6
    ), $atts));
    //Set default title
    if(!$title):
        $custom_h1 = carbon_get_post_meta(get_the_ID(), 'custom_h1');
        $title = empty($custom_h1) ? get_the_title( get_the_ID() ) : $custom_h1;
    endif;
    //Set search bar
    $ret = '';
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
    $league_arr = null;
    
    if(is_array($league) and count($league) > 0):
        
        $league_arr = "[{replace-leagues}]";
        $temp_leages = '';
        foreach ($league as $key => $value) {
            $temp_leages .= $value->slug.',' ;
        }
        $league_arr = str_replace("{replace-leagues}",$temp_leages,$league_arr);
    endif;
    if(!is_array($league) and is_string($league)):
        
        $league_arr = "[{replace-leagues}]";
        $league_arr = str_replace("{replace-leagues}",$league,$league_arr);
    endif;
    
    $ret .= '<div class="container">' . blog_posts_table('post',$paginate,$num,$league_arr) . '</div>';
    
    return $ret;
}

add_shortcode('blog', 'shortcode_blog');