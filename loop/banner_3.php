<?php 
$params = get_query_var('params');
$link = $params['link'];

echo "<div class='container'>
    <div class='row small_gutter'>
        <div class='col-lg-8'>
            <div class='notis_wrap' style='background:{$params['src_bg']};background-size:cover;'>
                <p class='sub_title text-white'>{$params['text']}</p>
                <h3 class='title_lg text-white mt_5 pb_25'>{$params['title']}</h3>";
                
                echo do_shortcode("[related_posts model='3' num='3' league='all']");
echo          "<div class='col-12 mt_45'>
                <a href='$link' class='button w-100'>Ver mas</a>
            </div>
         </div>
        </div>
    </div>
</div>";
