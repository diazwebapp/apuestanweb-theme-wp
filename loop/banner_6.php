<?php
// background pages or forecast

$params = get_query_var("params");
$alt_logo = get_template_directory_uri() . '/assets/img/logo2.svg';
if(!isset($params['src_logo'])){
    $params['src_logo'] = $alt_logo;
}
echo "<div class='eventbanner_wrapper'>
        <div class='container'>
            <div class='row align-items-center'>
                <div class='col-lg-9'>
                    <div class='event_banner_left_content_wrapper'>
                        <div class='event_banner_left_img'>
                            <img src='{$params['src_logo']}' class='img-fluid' alt=''>
                        </div>
                        <div class='event_banner_left_content'>
                            <h5>{$params['title']}</h5>
                            <p>{$params['text']}</p>
                        </div>
                    </div>
                </div>
                <div class='col-lg-3'>
                    <div class='event_banner'>
                        <a href='{$params['link']}'>{$params['text_link']}</a>
                    </div>
                </div>
            </div>
        </div>
</div>";