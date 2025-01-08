<?php
$thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ;
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

echo '<div class="col-lg-3 col-md-6 mt-2" >

        <a class="media align-items-center" href="'.$permalink.'">
            <div>
                <img width="120" height="120" loading="lazy" style="object-fit:cover;border-radius:5px;" src="'.$thumbnail_url.'"  alt="'.$title.'">
                
            </div>
            <div class="media-body pl-2">
                <h3>'.$title.'</h3>
            </div>
        </a>

    </div>'; 
