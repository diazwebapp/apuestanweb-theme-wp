<?php

$params = get_query_var("params");
$alt_logo = get_template_directory_uri() . '/assets/img/logo2.svg';
$html_logo = "<img src='$alt_logo' class='logo2' alt='{$params['title']}'>";
if($params['src_logo']):
    $html_logo = "<span class='{$params['src_logo']}' ></span>";
endif;

echo "<div class='container mt_55 home_container'>
    <div class='inner_bg' style='background:{$params['src_bg']};background-size:cover;'>

        <p class='d-flex'>
            <div class='p-2 icon-news'>
                 $html_logo
            </div>
            <div class='p-2'>
                <h1>{$params['title']}</h1>
            </div>
        </p>
        <img src='$alt_logo' class='logo2' alt='apuestanlogo'>
    </div>
</div>";