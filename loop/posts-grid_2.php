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
//<div class="category-grid"><span class="mt-3">#'.$sport.'</span></div>
echo '<div class="col-6 col-md-4 col-lg-3 mt-2">
        <div class="row">
            <a href="'.$permalink.'" class="col-12" >
                <img width="320" height="180" class="w-100" loading="lazy" style="object-fit:cover;border-radius:5px;" src="'.$thumbnail_url.'"  alt="'.$title.'">
            </a>
            
            <a href="'.$permalink.'" class="col-12">
                <h3>'.$title.'</h3>
            </a>
        </div>
        </div>'; 
