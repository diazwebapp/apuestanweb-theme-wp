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
            $table = '<table border="1" width="100%"><thead><tr><td><b>FORMAT</b></td><td><b>RESULT 1</b></td><td><b>RESULT 2</b></td></tr></thead><tbody>{data}</tbody></table>';
            $tr = '';
            foreach($predictions as $prediction):
                $oOddsConverter = new Converter($prediction['cuote'], 'eu');
                $result_eu = $oOddsConverter->doConverting();
                $oOddsConverter_2 = new Converter($prediction['cuote'], 'usa');
                $result_usa = $oOddsConverter_2->doConverting();
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
                $tr .="<tr>
                    <td><b>result_eu:</b></td>
                    <td><b>{$result_eu[2]}</b></td>
                    <td><b>{$result_eu[3]}</b></td>
                </tr>
                <tr>
                    <td><b>result_usa:</b></td>
                    <td><b>{$result_usa[2]}</b></td>
                    <td><b>{$result_usa[3]}</b></td>
                </tr>"; 
            endforeach;
            $ret .= str_replace('{data}',$tr,$table);
        endif;
    }
    
    return $ret;
}


add_shortcode('predictions', 'shortcode_predictions');