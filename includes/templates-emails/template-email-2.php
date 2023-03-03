<?php
function aw_email_templates_2($params=["blogname"=>"","username"=>"","vip_link"=>"#","message"=>"","blogurl"=>"","admin_email"=>""]){
    $logo_lg_uri = $params["blogurl"] . "/wp-content/themes/aw_wp_theme/assets/img/logo-email.png";
    
    $html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
            <title>{blogname}</title> 
            <style>
                table{
                    margin:auto !important;
                    border: hidden !important; 
                }
                table thead,table tfooter{
                    background-color: #051421;
                }
                table thead th, table tfooter td{
                    color:white;
                }
            </style>   
        </head>
    <body>
            <table >
                <thead>
                    <tr>
                        <th>
                            <img src="'.$logo_lg_uri.'" height="40"/>
                        </th>
                        <th>
                            Notification
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{message}</td>
                    </tr>
                </tbody>
                <tfooter>
                    <tr>
                        <td>apuestan 2023</td>
                    </tr>
                </tfooter>
            </table>
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