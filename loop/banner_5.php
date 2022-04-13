<?php
// background pages or forecast

$params = get_query_var('params');

echo "<div class='blog_hero_area'>
    <div class='container'>
        <div class='blog_bg' style='background:{$params['src_bg']};background-size:cover;'>
            <div class='row'>
                <div class='col-lg-12'>
                    <div class='blog_hero_content'>
                        <div class='blog_top_content'>
                            <img style='width:80px;height:80px;' src='{$params['src_logo']}' alt='{$params['text']}' title='{$params['text']}' class='img-fluid' alt=''>
                            <p style='text-transform:capitalize;' ><b>{$params['title']}</b></p>
                        </div>
                        <h2>".get_bloginfo( 'description' )."</h2>
                        <div class='blog_hero_btn'>
                            <!--<a href='#' class='btn_2'>Leer Articulo</a>-->
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>";