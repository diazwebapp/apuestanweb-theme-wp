<?php
function aw_email_templates_2($params=["blogname"=>"","username"=>"","message"=>""]){
    $html = '<div>{blogname} {username} {message}</div>';
    
    
    
    $html = str_replace("{blogname}",$params["blogname"],$html);
    $html = str_replace("{username}",$params["username"],$html);
    $html = str_replace("{message}",$params["message"],$html);

    return $html;
}