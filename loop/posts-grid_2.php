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
            <img loading="lazy" style="width:115px;height:115px;object-fit:cover;border-radius:5px;" src="'.$thumbnail_url.'"  alt="'.$title.'">
            <div style="padding-left:10px;" class="media-body">
                <a href="'.$permalink.'">
                    <h4>'.$title.'</h4>
                </a>
                <p class="mt_20">#'.$sport.'</p>
            </div>
        </div>
        </div>' ; 
