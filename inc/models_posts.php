<?php 
function post_1($data,$post){
    $excerpt;
    if($post->post_excerpt == "" || !$post->post_excerpt){ $excerpt = $post->post_title ;}else{ $excerpt = $post->post_excerpt; }
    $html = '<div class="tarjetita_post" >
        <div class="img_post" >
            <img src="'.$data['thumb'].'" alt="'.$post->post_title.'">
        </div>
        <p>'.$excerpt.'</p>
        <a class="btn_outline" href="'.$data['link'].'">Ver más</a>
    </div>';
    return $html;
}
function post_2($data,$post){
    $html = '<a href="'.$data['link'].'" class="tarjetita_post_'.$data['model'].'" >
        <div class="img_post" >
            <img src="'.$data['thumb'].'" alt="'.$post->post_title.'">
        </div>
        <div class="content_post" >
            <p><b>'.$data['deporte'].'</b> '.$post->post_date.'</p>
            <b class="title_post" >'.$post->post_title.'</b>
            <p>'.$post->post_excerpt.'</p>
        </div>
        </a>';
    return $html;
}