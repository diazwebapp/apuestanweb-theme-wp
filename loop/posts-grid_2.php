<?php
$thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full') ;
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
echo '<div class="col-lg-3 col-md-6 mt_30">
        <div class="media align-items-center">
        <a href="'.$permalink.'"><img loading="lazy" style="width:115px;height:115px;object-fit:cover;border-radius:5px;margin-bottom: 5rem;margin-bottom: 4rem;" src="'.$thumbnail_url.'"  alt="'.$title.'"></a>
            <div style="padding-left:10px;" class="media-body">
                <a href="'.$permalink.'">
                    <h3>'.$title.'</h3>
                </a>
                <div class="category-grid"><span class="mt_20">#'.$sport.'</span></div>
            </div>
        </div>
        </div>'; 
