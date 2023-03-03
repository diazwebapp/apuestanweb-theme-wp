<?php
function aw_email_templates_2($params=["blogname"=>"","username"=>"","vip_link"=>"#","message"=>"","blogurl"=>"","admin_email"=>""]){
    $logo_lg_uri = $params["blogurl"] . "/wp-content/themes/aw_wp_theme/assets/img/logo-email.png";
    
    $html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
            <title>{blogname}</title> 
            <style>
                .header{
                    background-color: #051421 !important;
                    display:flex;
                    flex-flow:row wrap;
                    justify-content:space-between;
                    align:items:center;
                    color:white;
                }
                .header,.footer,.main{
                    width:100% !important;
                }
                .header,.footer{
                    padding:0 20px;
                }
            </style>   
        </head>
        <body>
            <div class="header">
                <img src="'.$logo_lg_uri.'" height="30"/>
                <b>
                    Notification
                </b>
            </div>
            
            <div class="main">
                <p>{message}</p>
            </div>
        </body>
    </html>'
    ;
    
    
    
    if($params["message"] != ""){
        $message = $params["message"]; 
    }
    $html = str_replace("{message}",$message,$html);
    $html = str_replace("{vip_page}",$params["vip_link"],$html);
    $html = str_replace("{blogname}",$params["blogname"],$html);
    $html = str_replace("{username}",$params["username"],$html);
    $html = str_replace("{blogurl}",$params["blogurl"],$html);
    $html = str_replace("{admin_email}",$params["admin_email"],$html);

    return $html;
}