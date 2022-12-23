<?php
function aw_email_templates_2($params=["blogname"=>"","username"=>""]){
    $html = '<div>{vip_page} {blogname} {username}</div>';
    
    $vip_link = PERMALINK_VIP;
    $html = str_replace("{vip_page}",$vip_link,$html);
    $html = str_replace("{blogname}",$params["blogname"],$html);
    $html = str_replace("{username}",$params["username"],$html);

    return $html;
}