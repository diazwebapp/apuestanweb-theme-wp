<?php
function aw_email_templates_2($params=["blogname"=>"","username"=>"","vip_link"=>"#","message"=>"","blogurl"=>"","admin_email"=>""]){
    $logo_lg_uri = $params["blogurl"] . "/wp-content/themes/aw_wp_theme/assets/img/logo-email.png";
    
    $html = '<!DOCTYPE html>
    <html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en">
    
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
        <!--[if !mso]><!-->
        <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css2?family=Inter&amp;family=Work+Sans:wght@700&amp;display=swap" rel="stylesheet" type="text/css">
        <!--<![endif]-->
        <style>
            * {
                box-sizing: border-box;
            }
    
            body {
                margin: 0;
                padding: 0;
            }
            .test{
                background:red !important;
            }
            .header,footer,main{
                background-color: #040636 !important;
                display:flex ;
                flex-flow:row wrap ;
                justify-content:space-between ;
                align-content:center ;
                padding:20px;
            }
            main{
                background-color: white !important; 
            }
        </style>
    </head>
    
    <body style="background-color: #f7f7f7; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
        <div class="header">
            <div>
                <img src="'.$logo_lg_uri.'" height="30"/>
            </div>
            <div>
                <b style="color:white;">apuestan<b>
            </div>
        </div>
        <main> 
            {message}
        </main>
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