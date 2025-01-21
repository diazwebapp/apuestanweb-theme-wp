<?php get_header();

$h1 = '';
$permalink = '';
$thumb = '';
$alt_logo = get_template_directory_uri() . '/assets/img/logo2.svg';

if(have_posts()){
    the_post();
    echo "<br>";
    $h1 = get_the_title();
    $permalink = get_permalink();
    $thumb = get_the_post_thumbnail_url() ?: $alt_logo;
}

?>

<main>
    <div class="blog_hero_area">
        <div class="container">
            <div class="inner_bg mt-5" style="background-image:linear-gradient(145deg,#03b0f4 0,#051421c4 50%,#dc213e 100%), url(<?php echo esc_url($thumb); ?>)">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="">
                            <div class="blog_top_content mb-4">
                                <img width="65" height="27" src="<?php echo esc_url($alt_logo); ?>" alt="icon-apuestan">
                                <h1 class="text-light">Blog &amp; Noticias</h1>
                            </div>
                            <h2 class="text-light"><?php echo esc_html($h1); ?></h2>
                            <a href="<?php echo esc_url($permalink); ?>" class="btn_2">Leer Articulo</a>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="blog_box_wrapper">
        <div class="container">
            <?php echo do_shortcode("[blog model='1' paginate='yes']"); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
