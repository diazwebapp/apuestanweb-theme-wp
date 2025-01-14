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
            <div class="inner_bg mt-5" style="background-image:linear-gradient(145deg,#03b0f4 0,#051421c4 50%,#dc213e 100%), url(<?php echo $thumb ?>)">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="">
                            <div class="blog_top_content mb-4">
                                <img width="65" height="27" src="<?php echo $alt_logo ?>" alt="icon-apuestan">
                                <p>Blog &amp; Noticias</p>
                            </div>
                            <h2><?php echo $h1 ?></h2>
                            
                                <a href="<?php echo $permalink ?>" class="btn_2">Leer Articulo</a>
                            
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="blog_box_wrapper">
        <div class="container">
            <?php 
                echo do_shortcode("[blog filter='yes' title='Lo más reciente' model='1']"); 
            ?>
        </div>
    </div>
</main>

<?php get_footer();?>