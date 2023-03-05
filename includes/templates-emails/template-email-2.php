<?php
function aw_email_templates_2($params=["blogname"=>"","username"=>"","message"=>"","blogurl"=>"","admin_email"=>""]){
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
    
            a[x-apple-data-detectors] {
                color: inherit !important;
                text-decoration: inherit !important;
            }
    
            p {
                line-height: inherit
            }
    
            .image_block img+div {
                display: none;
            }
    
            @media (max-width:720px) {
    
                .row-content {
                    width: 100% !important;
                }
    
    
                .stack .column {
                    width: 100%;
                    display: block;
                }
    
                .row-2 .column-2 .block-1.paragraph_block td.pad>div,
                .row-7 .column-1 .block-1.heading_block h1,
                .row-7 .column-2 .block-1.paragraph_block td.pad>div,
                .row-8 .column-2 .block-1.paragraph_block td.pad>div {
                    text-align: center !important;
                }
    
                .row-7 .column-2 .block-1.paragraph_block td.pad {
                    padding: 0 !important;
                }
    
                .row-2 .column-1,
                .row-5 .column-1,
                .row-8 .column-1 {
                    padding: 20px 10px !important;
                }
    
                .row-2 .column-2 {
                    padding: 5px 25px 20px !important;
                }
    
                .row-7 .column-1 {
                    padding: 40px 25px 25px !important;
                }
    
                .row-7 .column-2 {
                    padding: 5px 25px 30px !important;
                }
    
                .row-8 .column-2 {
                    padding: 5px 30px 20px 25px !important;
                }
            }
        </style>
    </head>
    
    <body style="background-color: #f7f7f7; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
        
                        <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-radius: 0; color: #000000; background-size: auto; background-color: #051421; width: 100%;">
                            <tbody>
                                    <tr>
                                        <td class="column column-1" width="25%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 20px; padding-left: 30px; padding-right: 10px; padding-top: 20px; vertical-align: middle; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                            <table class="image_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                <tr>
                                                    <td class="pad" style="width:100%;padding-right:0px;padding-left:0px;">
                                                        <div class="alignment" align="center" style="line-height:10px"><a href="{blogurl}" target="_self" style="outline:none" tabindex="-1"><img src="'.$logo_lg_uri.'" style="display: block; height: auto; border: 0; width: 155px; max-width: 100%;" width="120" alt="{blogname}" title="{blogname}"></a></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="column column-2" width="75%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-left: 25px; padding-right: 30px; padding-top: 5px; vertical-align: middle; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                <tr>
                                                    <td class="pad">
                                                        <div style="color:#ffffff;direction:ltr;font-family:Inter, sans-serif;font-size:14px;font-weight:400;letter-spacing:0px;line-height:120%;text-align:right;mso-line-height-alt:16.8px;">
                                                            <p style="margin: 0;">{blogname}</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                            </tbody>
                        </table>

                        <table class="paragraph_block block-3" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                            <tr>
                                <td class="pad" style="padding-left:10px;padding-right:10px;">
                                    <div style="color:#051421;direction:ltr;font-family:Inter, sans-serif;font-size:16px;font-weight:400;letter-spacing:0px;line-height:180%;text-align:center;mso-line-height-alt:28.8px;">
                                        {message}
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="pad" style="padding-bottom:15px;padding-top:20px;text-align:center;">
                                    <div class="alignment" align="center">
                                        <a href="{blogurl}" target="Blank" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#051421;border-radius:0px;width:auto;border-top:1px solid #051421;font-weight:400;border-right:1px solid #051421;border-bottom:1px solid #051421;border-left:1px solid #051421;padding-top:5px;padding-bottom:5px;font-family:Noto Serif, Georgia, serif;font-size:16px;text-align:center;mso-border-alt:none;word-break:keep-all;"><span style="padding-left:30px;padding-right:30px;font-size:16px;display:inline-block;letter-spacing:normal;"><span style="word-break: break-word; line-height: 32px;">Ir a Apuestan</span></span></a>
                                        
                                    </div>
                                </td>
                            </tr>
                        </table>
                        
                       
                        
                        <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-radius: 0; color: #000000; background-size: auto; background-color: #051421; width: 100%;" >
                            <tbody>
                                <tr>
                                    <td class="column column-1" width="33.333333333333336%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 20px; padding-left: 30px; padding-right: 10px; padding-top: 20px; vertical-align: middle; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                        <table class="image_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                            <tr>
                                                <td class="pad" style="width:100%;padding-right:0px;padding-left:0px;">
                                                    <div class="alignment" align="center" style="line-height:10px"><a href="{blogurl}" target="_self" style="outline:none" tabindex="-1"><img src="'.$logo_lg_uri.'" style="display: block; height: auto; border: 0; width: 155px; max-width: 100%;" width="155" alt="{blogname}" title="{blogname}"></a></div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="column column-2" width="66.66666666666667%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-left: 25px; padding-right: 30px; padding-top: 5px; vertical-align: middle; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                        <table class="paragraph_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                            <tr>
                                                <td class="pad">
                                                    <div style="color:#ffffff;direction:ltr;font-family:Inter, sans-serif;font-size:14px;font-weight:400;letter-spacing:0px;line-height:120%;text-align:right;mso-line-height-alt:16.8px;">
                                                        <p style="margin: 0;">Copyright © {year} {blogname}, All rights reserved.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- End -->
    </body>
    
    </html>'
    ;
    
    $message = '
    <p style="font-size: 14px; line-height: 140%;">Estamos revisando tu solicitud y nos pondremos en contacto contigo por correo electrónico una vez que tu cuenta haya sido aprobada. Mientras tanto, puedes explorar nuestro sitio y aprender más sobre Apuestan.com</p>
    <p style="font-size: 14px; line-height: 140%;"> </p>
    <p style="font-size: 14px; line-height: 140%;">Recuerda que tu nombre de usuario es: {username}</p>
    <p style="font-size: 14px; line-height: 140%;"> </p>
    <p style="font-size: 14px; line-height: 140%;">Si tienes alguna pregunta o problema, no dudes en ponerte en contacto con nuestro equipo de soporte en contacto@apuestan.com.</p>
    <p style="font-size: 14px; line-height: 140%;"> </p>
    <p style="font-size: 14px; line-height: 140%;">¡Gracias de nuevo y que tengas un excelente día!</p>';
    
    if($params["message"] != ""){
        $message = $params["message"]; 
    }
    $year = date_i18n( "Y" );
    $html = str_replace("{message}",$message,$html);
    $html = str_replace("{year}",$year,$html);
    $html = str_replace("{blogname}",$params["blogname"],$html);
    $html = str_replace("{username}",$params["username"],$html);
    $html = str_replace("{blogurl}",$params["blogurl"],$html);
    $html = str_replace("{admin_email}",$params["admin_email"],$html);

    return $html;
}