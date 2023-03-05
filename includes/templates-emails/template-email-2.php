<?php
function aw_email_templates_2($params=["blogname"=>"","username"=>"","message"=>"","blogurl"=>"","admin_email"=>""]){
    $logo_lg_uri = '<svg xmlns="http://www.w3.org/2000/svg" width="183.257" height="19.111" viewBox="0 0 183.257 19.111">
    <g id="Logotipo" transform="translate(-353.659 -472.324)">
      <g id="Logotipo-2" data-name="Logotipo">
        <path id="Trazado_2" data-name="Trazado 2" d="M370.108,491.435H365.33l.91-5.406h-6.893l-.91,5.406h-4.778l2.753-16.545a3.183,3.183,0,0,1,.921-1.856,2.381,2.381,0,0,1,1.7-.71h11.034a2.274,2.274,0,0,1,1.172.314,2.778,2.778,0,0,1,.9.846,3.427,3.427,0,0,1,.512,1.215,3.585,3.585,0,0,1,.011,1.42Zm-12.035-14.661,2.475,1.94-.473,2.838h6.916l.66-4.014a.711.711,0,0,0-.114-.532.479.479,0,0,0-.409-.232Zm14.2,14.661,3.185-19.111h15.993a1.972,1.972,0,0,1,1.013.273,2.41,2.41,0,0,1,.785.751,3.4,3.4,0,0,1,.466,1.078,3.024,3.024,0,0,1,.034,1.256l-1.3,7.781a3.177,3.177,0,0,1-.921,1.856,2.374,2.374,0,0,1-1.7.71H378.207l-.887,5.406Zm15.289-9.883c.257,0,.423-.164.5-.492l.591-3.522a.711.711,0,0,0-.114-.532.478.478,0,0,0-.409-.232h-8.372l-.8,4.778Zm8.44,9.883a2.277,2.277,0,0,1-1.172-.314,2.7,2.7,0,0,1-.888-.846,3.7,3.7,0,0,1-.511-1.229,3.763,3.763,0,0,1-.045-1.433l2.548-15.289h4.777l-2.3,13.9a.721.721,0,0,0,.114.533.481.481,0,0,0,.41.232h5.8q.41,0,.524-.519l2.366-14.142H412.4l-2.753,16.544a3.182,3.182,0,0,1-.921,1.857,2.376,2.376,0,0,1-1.7.71Zm21.477-4.45h10.079l-.751,4.45H411.947l3.186-19.111h14.856l-.728,4.45h-10.1l-.477,2.867h8.508l-.751,4.477h-8.486Zm17.016-14.661H445a2.382,2.382,0,0,1,1.263.355,3.383,3.383,0,0,1,.989.928,3.634,3.634,0,0,1,.58,1.324,4.029,4.029,0,0,1,.034,1.57l-.272,1.556h-4.779l.091-.519a.724.724,0,0,0-.113-.532.482.482,0,0,0-.409-.232h-5.826q-.432,0-.522.519l-.251,1.583a.717.717,0,0,0,.114.532.479.479,0,0,0,.409.233h6.348q.546,0,1.229.027a2.422,2.422,0,0,1,1.194.423,3.381,3.381,0,0,1,.91.942,3.707,3.707,0,0,1,.524,1.3,4.076,4.076,0,0,1,.011,1.515l-.8,4.778a3.558,3.558,0,0,1-1.012,2.02,2.574,2.574,0,0,1-1.854.792h-10.4a2.435,2.435,0,0,1-1.275-.355,3.061,3.061,0,0,1-.977-.928,3.846,3.846,0,0,1-.558-1.338,4.1,4.1,0,0,1-.034-1.584l.25-1.529h4.777l-.09.519a.712.712,0,0,0,.114.533.478.478,0,0,0,.409.232H440.8c.272,0,.447-.173.523-.519l.319-1.911a.715.715,0,0,0-.115-.532.478.478,0,0,0-.409-.233h-7.371a2.429,2.429,0,0,1-1.274-.355,3.067,3.067,0,0,1-.979-.928,3.876,3.876,0,0,1-.557-1.337,4.124,4.124,0,0,1-.035-1.584l.729-4.45a3.571,3.571,0,0,1,1.013-2.021A2.575,2.575,0,0,1,434.492,472.324Zm19.406,4.45h-5.619l.751-4.45h16.244l-.751,4.45h-5.3l-2.457,14.661h-5.3Zm26.575,14.661h-4.779l.91-5.406h-6.893l-.91,5.406h-4.778l2.753-16.545a3.183,3.183,0,0,1,.921-1.856,2.382,2.382,0,0,1,1.7-.71h11.034a2.277,2.277,0,0,1,1.172.314,2.785,2.785,0,0,1,.9.846,3.427,3.427,0,0,1,.512,1.215,3.6,3.6,0,0,1,.012,1.42Zm-3.118-9.883.661-4.014a.716.716,0,0,0-.115-.532.479.479,0,0,0-.409-.232h-5.8q-.455,0-.523.519l-.728,4.259Zm12.582-5.242-2.526,15.125h-4.777l3.185-19.111h8.236l2.525,15.125,2.5-15.125h4.777l-3.184,19.111h-8.214Z" fill="#fff"/>
        <path id="Trazado_3" data-name="Trazado 3" d="M515.988,491.434h-7l8.576-9.555-8.576-9.555h7l8.815,9.555Z" fill="#03b0f4"/>
        <path id="Trazado_4" data-name="Trazado 4" d="M528.1,491.434h-7l8.576-9.555-8.576-9.555h7l8.815,9.555Z" fill="#dc213e"/>
      </g>
    </g>
  </svg>'
  ;
    
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
                                        <td class="column column-1" width="33.333333333333336%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 20px; padding-left: 30px; padding-right: 10px; padding-top: 20px; vertical-align: middle; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                            <table class="image_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                <tr>
                                                    <td class="pad" style="width:100%;padding-right:0px;padding-left:0px;">
                                                        <div class="alignment" align="center" style="line-height:10px"><a href="{blogurl}" target="_self" style="outline:none" tabindex="-1">'.$logo_lg_uri.'</a></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="column column-2" width="66.66666666666667%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-left: 25px; padding-right: 30px; padding-top: 5px; vertical-align: middle; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
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
                                                    <div class="alignment" align="center" style="line-height:10px"><a href="{blogurl}" target="_self" style="outline:none" tabindex="-1">'.$logo_lg_uri.'</a></div>
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