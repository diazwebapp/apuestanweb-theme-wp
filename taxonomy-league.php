<?php
get_header();

$term = get_term_by('slug',$term,'league' );
$migas_de_pan_html = '';
if($term){
    $migas_de_pan_html = '<li><a href="'.get_home_url().'">Inicio</a></li>';
    $taxonomy_page = !empty($term) ? carbon_get_term_meta($term->term_id,'taxonomy_page') : null ;
    $term->permalink = !empty($taxonomy_page[0]) ? get_permalink($taxonomy_page[0]["id"]) : get_term_link($term, 'league');
    $migas_de_pan_html .= '<li><a href="'.$term->permalink.'" >'.$term->name.'</a></li>' ;
}

 ?>
	<main>
    
            <div class="event_area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 mt-3">
                        <h1 class="title mt-5"> <?php echo $term->name ?></h1>
                        <div class="single_event_breadcrumb text-capitalize">                              
                            <ul>
                                <?php echo $migas_de_pan_html ?>
                            </ul>
                        </div>
                        <?php 
                            $slug =  $term ? $term->slug : 'all';
                            echo do_shortcode("[forecasts model='2' num='6' filter='yes' league='$slug']");
                        ?>

                        </div>
                        <div class="col-lg-3 mt-3">
                            <div class="row">
                                <?php dynamic_sidebar( 'forecast-right' ); ?>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
    </main>
	
    <?php get_footer();?>

