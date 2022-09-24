<?php
function shortcode_banner_bookmaker($atts)
{
    extract(shortcode_atts(array(
        'model' => false,
        'id' => get_post_type() == 'bk' ? get_the_ID() : false 
    ), $atts));
    //geolocation
    $location = json_decode(GEOLOCATION);
    $aw_system_location = aw_select_country(["country_code"=>$location->country_code]);

    //default bookmaker
    $bookmaker["name"]="";
    $bookmaker["logo"]="";
    $bookmaker["background_color"]="";
    $bookmaker["ref_link"]="#" ;
    $bookmaker["bonus_slogan"]= "" ;
    $bookmaker["bonus_amount"]= "0";
    $bookmaker["feactures"]= [];

    //obtener datos del bookmaker
    $post = get_post($id);
    $bookmaker["feactures"] = carbon_get_post_meta($post->ID,'feactures');
    $bookmaker["bonus_slogan"] = carbon_get_post_meta($post->ID,'bonus_slogan');
    $bookmaker["ref_link"] = carbon_get_post_meta($post->ID,'ref');
    if (carbon_get_post_meta($post->ID, 'mini_img')):
        $logo = carbon_get_post_meta($post->ID, 'mini_img');
        $bookmaker['logo'] = wp_get_attachment_url($logo);
    endif;

    //Detectando si existe en el pais actual
    $exists = aw_detect_bookmaker_on_country($aw_system_location->id,$id);
    if(!isset($exists)): //si nó existe pedimos un bookmaker aleatorio 
        $bookmaker = aw_select_relate_bookakers($aw_system_location->id, ["unique"=>true,"random"=>true,"limit"=>1]);
    endif;


    $ret = '
    <div class="container my-4">
        <div class="row px-5 py-3" style="border:1px solid grey;border-radius:10px;">
            <div class="col-lg-3 d-flex flex-column justify-content-center text-center my-4" style="border-radius:10px;background:black;min-height:100px;">
                <img width="150rem" height="50rem" src="{logo}" alt="{alt_logo}" style="margin:auto;" />
            </div>
            <div class="col-lg-3 my-4">
                <ul>
                    {feactures}
                </ul>
            </div>
            <div class="col-lg-6 my-4">
                <p class="text-body text-center text-uppercase font-weight-bold mb-5" style="font-size:22px;" >{bonus_slogan}</p>
                <a href="{ref_link}" class="text-uppercase badge badge-primary px-5 d-block py-4" style="font-size:15px;border-radius:.5rem;font-weight: 500" target="_blank">visitar <i class="fa fa-external-link ml-5" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
    ';
    $feactures_html = '';
    foreach($bookmaker["feactures"] as $key => $feacture):
        $feactures_html .= '<li class="my-1">
            <i class="fa fa-check text-white bg-success rounded px-1 py-1 font-weight-light" style="font-size:1rem;list-style:none;"></i>
            <span class="text-uppercase text-success align-middle ml-3" style="font-size:1.7rem;">'.$feacture["feacture"].'</span>
        </li>';
    endforeach;
    $ret = str_replace("{feactures}",$feactures_html,$ret);
    $ret = str_replace("{logo}",$bookmaker["logo"],$ret);
    $ret = str_replace("{alt_logo}",$bookmaker["name"],$ret);
    $ret = str_replace("{bonus_slogan}","excelente bono 10$",$ret);
    return $ret;
}

add_shortcode('banner_bookmaker', 'shortcode_banner_bookmaker');