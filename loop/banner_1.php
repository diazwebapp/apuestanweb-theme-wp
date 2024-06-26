<?php

$params = get_query_var("params");
$alt_logo = get_template_directory_uri() . '/assets/img/logo2.svg';
$html_logo = "<img src='$alt_logo' class='logo2' alt='{$params['title']}'>";
if($params['src_logo']):
    $html_logo = "<span class='{$params['src_logo']}' ></span>";
endif;

echo "<div class='container mt_55 home_container'>
    <div class='inner_bg' style='background:{$params['src_bg']};background-size:cover;'>
        <h2>
            $html_logo
            {$params['title']}
        </h2>
        <img src='$alt_logo' class='logo2' alt='apuestabweb mini logo'>
    </div>
</div>";