<?php
$thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
$thumbnail_url = aq_resize($thumbnail_url,320,180,true,true,true);
if(!$thumbnail_url)
    $thumbnail_url = get_template_directory_uri() . '/assets/img/cross.png';

$permalink = get_the_permalink( get_the_ID() );
$title = get_the_title(get_the_ID());
$leagues = wp_get_post_terms(get_the_ID(), 'league', array('fields' => 'all'));
$sport = '';
if(count($leagues) > 0):
    foreach($leagues as $league):
        if($league->parent == 0):
            $sport = $league->name;
        endif;
    endforeach;
endif;
echo "
    <article class='col-12 col-sm-6 col-md-4 col-xl-3 my-2 blog_box' >
        
        <header class='img_box'>
            <img width='320' height='180' alt='$title' loading='lazy' src='$thumbnail_url'>
        </header>
        <div class='desc_box border px-3 py-1' >
            <a href='$permalink' title='Leer mas sobre $title' class=''>$title</a>
        </div>
    
    </article>
";