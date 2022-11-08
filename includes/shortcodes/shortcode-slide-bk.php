<?php
function shortcode_slide_bk($atts)
{
    extract(shortcode_atts(array(
        'num' => 10,
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'title' => false,
        'slogan' => false,
        'model' => 1
    ), $atts));
    $ret = '';
    wp_reset_query();

    $args['post_type'] = 'bk';
    $args['posts_per_page'] = -1;
    $args['order'] = 'DESC';
    $args['orderby'] = 'meta_value_num';
    $args['meta_key'] = '_rating';
    
    $query = new WP_Query($args);

    if ($query) {
        $new_bks = [];
        $location = isset($_SESSION["geolocation"]) ? json_decode($_SESSION["geolocation"]) : json_decode(GEOLOCATION);
        $aw_system_country = aw_select_country(["country_code"=>$location->country_code]);
        foreach ($query->posts as $bookmaker): 
            $exists = null;
            if(isset($aw_system_country->id)):
                $exists = aw_detect_bookmaker_on_country($aw_system_country->id,$bookmaker->ID);
            endif;
            if(!isset($aw_system_country->id)):
                $exists = aw_detect_bookmaker_on_country(1,$bookmaker->ID);
            endif;
            if(isset($exists)):
                $new_bks[] = $bookmaker;
            endif;
        endforeach;
    }
    if (count($new_bks) > 0) { 
        $ret =  "<div class='testimonial_area'>
                <div class='container'>
                    <div class='row small_gutter'>
                        <div class='col-12 text-center pb_30'>
                            <h5 class='sub_title'> $slogan </h5>
                            <h2 class='title_lg mt_5'> $title </h2>
                        </div>
                        {replace}
            </div>
                </div>
            </div>";
        if($model == 1): 
            $html = '';
            $html =  "<div class='owl-carousel slider2 owl-loaded owl-drag'>
                        <div class='owl-stage-outer'>
                            <div class='owl-stage' style='transform: translate3d(-517px, 0px, 0px); transition: all 1s ease 0s; width: 1410px; padding-left: 15px; padding-right: 15px;'>";
                        foreach ($new_bks as $keybk => $bookmaker):
                            $html .= load_template_part("loop/slide_bk_$model",null,['bookmaker'	=> $bookmaker,]);                            
                        endforeach;
            $html .=  "          </div>
                        </div>
                    <div class='owl-nav'>
                    </div>
                    <div class='owl-dots disabled'></div>
            </div>";
            $ret = str_replace("{replace}",$html,$ret);
        endif;
        if($model == 2): 
            $html =  "<div style='margin:15px auto;' class='container bonus_wrap'>
                        <div class='row'>";
                        foreach ($new_bks as $keybk => $bookmaker):
                            $html .= load_template_part("loop/slide_bk_$model",null,['bookmaker'=> $bookmaker,"position"=>$keybk+1]);                            
                        endforeach;
            $html .=  " </div>
                </div>";
            $ret = str_replace("{replace}",$html,$ret);
        endif;
    } 
    return $ret;
}

add_shortcode('slide_bk', 'shortcode_slide_bk');
