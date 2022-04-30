<?php
function shortcode_predictions($atts)
{
    ob_start();
    
    extract(shortcode_atts(array(
        'model' => 1,
        'text' => '',
        'title' => '',
        'src_logo' => false,
        'src_bg' => false,
        'link' => false
    ), $atts));
    $ret = "";
    if($model == 1){

        $id_post = get_the_ID();
        $bk        = get_bookmaker_by_post( $id_post, ["w"=>69,"h"=>28], ["w"=>100,"h"=>50] );
        $predictions = carbon_get_post_meta($id_post, 'predictions');
        if($predictions and count($predictions)> 0):
            foreach($predictions as $prediction):
                $ret .= "<br/><div class='single_event_match_title_box'>
                            <div class='match_title_left_box'>
                                <div class='match_title_img_box'>
                                    <img width='90' loading='lazy' src='{$bk['logo']}' class='img-fluid' alt='{$bk['name']}'>
                                </div>
                                <div class='match_title_left_content'>
                                    <p style='text-transform:uppercase;' ><span class='match_title_left_text'>pronóstico: </span> {$prediction['title']}</p>
                                    <div class='ratings'>
                                        <span>{$prediction['tvalue']}</span>
                                        <i class='fas fa-star'></i>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class='match_title_right_box'>
                                <div class='match_title_right_point'>
                                    <p>{$prediction['cuote']}</p>
                                </div>
                            </div>    
                        </div><br/>";
            endforeach;
        endif;
    }
    
    return $ret;
}


add_shortcode('predictions', 'shortcode_predictions');