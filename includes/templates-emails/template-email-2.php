<?php
function aw_email_templates_2($params=["blogname"=>"","username"=>"","vip_link"=>"#","message"=>"","blogurl"=>"","admin_email"=>""]){
    $html = '<div>
            <table class="" >
                <thead>
                    <tr>
                        <th>
                            <img src="{blogurl}/wp-content/themes/aw_wp_theme/assets/img/apnpls.svg" width="150"/>
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
            </table>
        </div>'
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