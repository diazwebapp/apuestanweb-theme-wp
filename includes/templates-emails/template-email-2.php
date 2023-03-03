<?php
function aw_email_templates_2($params=["blogname"=>"","username"=>"","vip_link"=>"#","message"=>"","blogurl"=>"","admin_email"=>""]){
    $image_uri = $params["blogurl"] . "/wp-content/themes/aw_wp_theme/assets/img/event-logo.png";
    $base64 = base64_encode(file_get_contents($image_uri));
    $html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
            <!--[if gte mso 9]>
            <xml>
            <o:OfficeDocumentSettings>
                <o:AllowPNG/>
                <o:AllowSVG/>
            </o:OfficeDocumentSettings>
            </xml>
            <![endif]-->
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="x-apple-disable-message-reformatting">
            <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]-->
            <title>{blogname}</title>    
        </head>
    <body>
            <table class="" >
                <thead>
                    <tr>
                        <th>
                            <img src="'.$base64.'" width="150"/>
                        </th>
                        <th>
                            Notification
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>'.$image_uri.' {message}</td>
                    </tr>
                </tbody>
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