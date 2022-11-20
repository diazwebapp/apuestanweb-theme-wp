<?php
function aw_email_templates($params=["blogname"=>"","username"=>""]){
    $html = '<div style="max-width:600px;padding:20px;border-radius:5px;margin:40px auto;font-family:Open Sans,Helvetica,Arial;font-size:15px;color:#5d5d5d"><div class="adM">
    </div><div style="background:#051421;text-align:left;font-weight:600;font-size:26px;padding:30px 30px 30px 30px;color:#5d5d5d">{blogname}</div>
    <div style="background:#051421;font-size:18px;text-align:left;line-height:40px;color:#5d5d5d;padding:30px 25px">
    <div>Hello {username},</div>
    <div style="padding-top:30px"></div>
    <div>Thanks for registering on {blogname}. Your account is waiting to be approved.</div>
    <div>Once your Account is approved you can login using your credentials on:<br>
         <a style="color:#68aeff;text-decoration:none" href="{vip_page}">pagina vip</a></div>
    <div>Your Username: {username}</div>
    <div style="padding-top:30px"></div>
    <div>Have a nice day!</div>
    <div style="padding-top:30px"></div>
    </div><span class="im">
    <div style="background:#051421;color:#fff;padding:20px 30px">
    <div>Thank you, The <a style="color:#fff" href="https://apuestan.ml">{blogname}</a> Team</div>
    </div>
    </span></div>';
    
    $vip_link = PERMALINK_VIP;
    $html = str_replace("{vip_page}",$vip_link,$html);
    $html = str_replace("{blogname}",$params["blogname"],$html);
    $html = str_replace("{username}",$params["username"],$html);
    return $html;
}