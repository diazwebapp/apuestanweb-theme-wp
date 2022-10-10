<?php get_header(); 

$args['post_type'] = 'post';
$args['posts_per_page'] = 1;
$args['paged'] = 1;
$query_home = new Wp_Query($args);
$h1 = '';
$permalink = '';
$thumb = '';
$alt_logo = get_template_directory_uri() . '/assets/img/logo2.svg';

if($query_home->have_posts()):
    while($query_home->have_posts()):
        $query_home->the_post();
        $h1 = get_the_title(get_the_ID());
        $permalink = get_the_permalink(get_the_ID());
        $thumb = get_the_post_thumbnail_url(get_the_ID());
    endwhile;
endif;
?>

<main>
    <div class="blog_hero_area">
        <div class="container">
            <div class="blog_bg" style="background-image: url(<?php echo $thumb ?>);">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="blog_hero_content">
                            <div class="blog_top_content">
                                <img src="<?php echo $alt_logo ?>" class="img-fluid" alt="">
                                <p></p>
                            </div>
                            <h2>Resultados de Busqueda:</h2>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="blog_box_wrapper">
        <div class="container">
            <div class="row">
                <?php
                    if(have_posts()):
                        while (have_posts()):
                            the_post();
                            get_template_part("loop/posts-grid_1"); 
                        endwhile; 
                    endif;
                ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>