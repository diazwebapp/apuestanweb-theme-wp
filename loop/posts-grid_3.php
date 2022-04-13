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
echo "<div class='col-6 col-lg-4 mt_30'>
    <div class='notis_box'>
    <img class='img-fluid' alt='$title' loading='lazy' src='$thumbnail_url'>
        <a href='$permalink'>
            <h4 class='text-white'>$title</h4>
        </a>
        <p class='mt_15' >$sport</p>
    </div>
</div> "; 
