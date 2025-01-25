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

echo '<article class="col-lg-3 col-sm-6 my-2" >
        <header class="d-flex align-items-center">
            <img width="120" height="120" loading="lazy" style="object-fit:cover;border-radius:5px;" class="align-self-center mr-1" src="'.$thumbnail_url.'"  alt="'.$title.'"> 
        
            <div>
                <a href="'.$permalink.'" title="Leer mas sobre '.$title.'">
                    <h5 style="font-size:1rem;" class="text-dark pl-2" >'.$title.'</h5>
                </a> 
            </div> 
        </header>
    </article>'; 
