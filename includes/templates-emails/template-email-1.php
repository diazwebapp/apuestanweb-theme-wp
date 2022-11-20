<?php
function aw_email_templates($params=["blogname"=>"","username"=>""]){
    $html = '<div style="max-width:600px;padding:20px;border-radius:5px;margin:40px auto;font-family:Open Sans,Helvetica,Arial;font-size:15px;color:#5d5d5d"><div class="adM">
    </div><div style="background:#eaeaea;text-align:left;font-weight:600;font-size:26px;padding:30px 30px 30px 30px;color:#5d5d5d">{blogname}</div>
    <div style="background:#fff;font-size:18px;text-align:left;line-height:40px;color:#5d5d5d;padding:30px 25px">
    <div>Hello {username},</div>
    <div style="padding-top:30px"></div>
    <div>Thanks for registering on {blogname}. Your account is waiting to be approved.</div>
    <div>Once your Account is approved you can login using your credentials on:<br>
         <a style="color:#68aeff;text-decoration:none" href="https://eiihajh.r.bh.d.sendibt3.com/tr/cl/nDJ0fcTokLneR2gfMfeC9z4X3ADYWrbH9hTUOwLDw2W4XAoA99zx3NA80UWkcjJEFSLcTN8qncddW1WEj-o-w6ZrsBgWv7m_lQ3j-73BXXH2B125Sl_sInMNWgl2cdPl1W8QkNn_yJRxYbizkIK9DD2pWUVKYzfc0loGE7F1HH7oEjqVSZSg1_Rh0gRG0KhCacwiw1Wn3qhim7c" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://eiihajh.r.bh.d.sendibt3.com/tr/cl/nDJ0fcTokLneR2gfMfeC9z4X3ADYWrbH9hTUOwLDw2W4XAoA99zx3NA80UWkcjJEFSLcTN8qncddW1WEj-o-w6ZrsBgWv7m_lQ3j-73BXXH2B125Sl_sInMNWgl2cdPl1W8QkNn_yJRxYbizkIK9DD2pWUVKYzfc0loGE7F1HH7oEjqVSZSg1_Rh0gRG0KhCacwiw1Wn3qhim7c&amp;source=gmail&amp;ust=1668997801018000&amp;usg=AOvVaw110O8OKR02tSEiTQn6OxnO">{login_page}</a></div>
    <div>Your Username: {username}</div>
    <div style="padding-top:30px"></div>
    <div>Have a nice day!</div>
    <div style="padding-top:30px"></div>
    </div><span class="im">
    <div style="background:#545454;color:#fff;padding:20px 30px">
    <div>Thank you, The <a style="color:#fff" href="https://eiihajh.r.bh.d.sendibt3.com/tr/cl/Ngj5s4k92bZoZmKkDIO62inglsLPQaSQjO0Zlq6YaovsEu9jkVxAtJe3rIB8lFBqdKki3rgcMVUEfgjHuisFsEuXaHcKEMeTAWyrb3iDV-xlZd2OfKG9ZlXIrER31CglSgQSLowOs1vEnaiN95IzrptCAha__POAU1aEfyP6E14y7sSsJ7Qcgv-Ns1G1YJzjMpawLBDHgSU" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://eiihajh.r.bh.d.sendibt3.com/tr/cl/Ngj5s4k92bZoZmKkDIO62inglsLPQaSQjO0Zlq6YaovsEu9jkVxAtJe3rIB8lFBqdKki3rgcMVUEfgjHuisFsEuXaHcKEMeTAWyrb3iDV-xlZd2OfKG9ZlXIrER31CglSgQSLowOs1vEnaiN95IzrptCAha__POAU1aEfyP6E14y7sSsJ7Qcgv-Ns1G1YJzjMpawLBDHgSU&amp;source=gmail&amp;ust=1668997801018000&amp;usg=AOvVaw3I5eTgncMe1DcrdO2G8WP2">{blogname}</a> Team</div>
    </div>
    </span></div>';
    $html = str_replace("{blogname}",$params["blogname"],$html);
    $html = str_replace("{username}",$params["username"],$html);
    return $html;
}