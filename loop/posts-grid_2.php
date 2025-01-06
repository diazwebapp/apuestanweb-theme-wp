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
//
echo '<div class="col-lg-3 col-md-6 mt-2">
        <div class="row">
            <a href="'.$permalink.'"><img width="320" height="180" loading="lazy" class="col-sm col-md-6 col-lg-3" style="object-fit:cover;border-radius:5px;" src="'.$thumbnail_url.'"  alt="'.$title.'"></a>
            <div class="col-sm col-md-6 col-lg-3">
                <a href="'.$permalink.'">
                    <h3>'.$title.'</h3>
                </a>
                <div class="category-grid"><span class="mt-3">#'.$sport.'</span></div>
            </div>
        </div>
        </div>'; 
