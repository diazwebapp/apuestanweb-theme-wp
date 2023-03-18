<?php
function shortcode_banner_bookmaker($atts)
{
    extract(shortcode_atts(array(
        'model' => false,
        'id' => get_post_type() == 'bk' ? get_the_ID() : false 
    ), $atts));
    //geolocation
    $location = json_decode($_SESSION["geolocation"]);
    #Detectamos si está configurado el pais
    $aw_system_country = aw_select_country(["country_code"=>$location->country_code]);
    $bookmaker_detected = aw_detect_bookmaker_on_country($aw_system_country->id,$id);
    

    //default bookmaker
    $bookmaker["name"]="";
    $bookmaker["logo"]= get_template_directory_uri( ) . "/assets/img/logo2.svg";
    $bookmaker["ref_link"]="#" ;
    $bookmaker["bonus_slogan"]= "" ;
    $bookmaker["feactures"]= [];

    //obtener datos del bookmaker
    if(isset($bookmaker_detected)):
        $bookmaker['name'] = get_the_title( $id );

        $bookmaker["background_color"] = carbon_get_post_meta($id, 'background-color');

        $bonuses = carbon_get_post_meta($id, 'country_bonus');
        if(isset($bonuses) and count($bonuses) > 0):
        foreach($bonuses as $bonus_data):
            if(strtoupper($bonus_data["country_code"]) == strtoupper($aw_system_country->country_code)):
                $bookmaker["bonus_slogan"] = $bonus_data['country_bonus_slogan'];
                $bookmaker["ref_link"] = $bonus_data['country_bonus_ref_link'];
            endif;
        endforeach;
        endif;

        $bookmaker["feactures"] = carbon_get_post_meta($id, 'feactures');

        if (carbon_get_post_meta($id, 'logo')):
            $logo = carbon_get_post_meta($id, 'logo');
            $bookmaker["logo"] = wp_get_attachment_url($logo);
        endif; 
    else:
        $aw_system_country = aw_select_country(["country_code"=>"WW"]);
        $bookmaker = aw_select_relate_bookmakers($aw_system_country->id, ["unique"=>true,"random"=>false]);
    endif;

    $ret = '
    <div class="banner-bookmaker container my-4">
        <div class="row px-5 py-3">
            <div class="col-lg-3 d-flex flex-column justify-content-center text-center my-4" style="border-radius:10px;background:'.($bookmaker["background_color"] ? $bookmaker["background_color"] : "black").';min-height:100px;">
                <img width="{w-logo}"  height="{h-logo}" src="{logo}" alt="{alt_logo}" style="margin:auto;" />
            </div>
            <div class="list-feactures col-lg-3 my-4 d-flex flex-column justify-content-center text-center">
                <ul>
                    {feactures}
                </ul>
            </div>
            <div class="col-lg-6 my-4">
                <p class="text-body text-center text-uppercase font-weight-bold mb-5">{bonus_slogan}</p>
                <a href="{ref_link}" id="btn-bookmaker" class="text-uppercase badge badge-primary px-5 d-block py-4" rel="nofollow noreferrer noopener" target="_blank">visitar</a>
            </div>
        </div>
    </div>
    ';
    
    $feactures_html = '';
    
    if($bookmaker["feactures"] and count($bookmaker["feactures"]) > 0): 
        foreach($bookmaker["feactures"] as $key => $feacture):
            $feactures_html .= '<li class="my-1">
                <i class="fa fa-check text-white bg-success rounded px-1 py-1 font-weight-light"></i>
                <span class="text-uppercase text-success align-middle ml-3">'.$feacture["feacture"].'</span>
            </li>';
        endforeach;
    endif;
    $ret = str_replace("{feactures}",$feactures_html,$ret);
    $ret = str_replace("{logo}",$bookmaker["logo"],$ret);
    $ret = str_replace("{w-logo}",70,$ret);
    $ret = str_replace("{h-logo}",25,$ret);
    $ret = str_replace("{alt_logo}",$bookmaker["name"],$ret);
    $ret = str_replace("{bonus_slogan}",$bookmaker["bonus_slogan"],$ret);
    $ret = str_replace("{ref_link}",$bookmaker["ref_link"],$ret);
    
    return $ret;
}

add_shortcode('banner_bookmaker', 'shortcode_banner_bookmaker');

//shortcode payment methods for bookmaker

function shortcode_banner_bookmaker_payments_methods($atts){
    extract(shortcode_atts(array(
        'model' => false,
        'bookmaker_id' => get_post_type() == 'bk' ? get_the_ID() : false 
    ), $atts));
    $location = json_decode($_SESSION["geolocation"]);
    $aw_system_location = aw_select_country(["country_code"=>$location->country_code]);
    
    $payment_methods = get_bookmaker_payments($bookmaker_id);
    
    $table = '
    <style>
        .table-bookmaker-payment{
            margin:2rem;box-shadow:0px 0px 2px black;border-radius:10px;min-width:50rem;
        }
        .table-bookmaker-payment > thead{
            padding:5px;border-bottom:2px solid lightgrey;
        }
        
        .table-bookmaker-payment > thead th, .table-bookmaker-payment > tbody td{
            padding:10px 20px;
            color:black;
            position:relative;
            z-index:1;
            text-transform:uppercase;
            font-weight:bold;
            font-size:14px;
            text-align:center;
        }
        
        
        .table-bookmaker-payment > tbody td::after{
            content:"";
            background:lightgrey;
            width:2px;
            height:100%;
            top:0;
            right:1px;
            position:absolute;
            z-index:2;
        }
        .table-bookmaker-payment > tbody tr:first-child td::after{
            height:90%;
            top:10%;
        }
        .table-bookmaker-payment > tbody tr:last-child td::after{
            height:90%;
            bottom:10%;
        }
        .table-bookmaker-payment > tbody td:last-child::after{
            display:none;
        }
        .table-bookmaker-payment > tbody td:first-child{
            width:90px !important;
        }
    </style>
    <div class="table-responsive">
        <table class="table-bookmaker-payment">
            <thead>
                {replace_th}
            </thead>
            <tbody>
                {replace_tr}
            </tbody>
        </table>
    </div>
    ';
    $th = '<th>Method</th>';
    $tr = '';
    foreach ($payment_methods as $key => $data) {
        $tr .= '<tr>
            <td><img src="'.$data->logo_2x1.'" width="70" height="25" /></td>
        ';
        if(count($data->payment_method_chars) > 0):
            foreach($data->payment_method_chars as $charkey => $char):
                if($key == 0):
                    $th .= '<th>'.$char->titulo.'</th>';
                endif;
                $tr .= '<td>'.$char->contenido.'</td>';
            endforeach;
        endif;
        $tr .= '</tr>';
    }
    $table = str_replace("{replace_th}",$th,$table);
    $table = str_replace("{replace_tr}",$tr,$table);
    return $table;
}

add_shortcode('banner_bookmaker_payment_methods', 'shortcode_banner_bookmaker_payments_methods');