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
<div class="side_box mt_30">
  <div class="box_header">Casas de apuestas</div>
  <div class="box_body">
    <div class="top_box">
      <div class="d-flex align-items-center justify-content-between">
        <div class="top_serial"> <span class="serial">1</span> 
          <img src="https://www.apuestan.com/wp-content/uploads/2023/12/logo-1.webp" width="80" height="20" class="img-fluid" alt="" style="background:#000000;padding: 6px;border-radius: 6px;width: 10rem;height: 3.3rem;">
        </div>
        <div class="ratings"> 
          <span>5</span> 
          <i class="fas fa-star"></i>
        </div>
      </div>
      <div class="btn_groups"> 
        <a href="https://www.apuestan.com/casas-apuestas/bc-game-analisis-y-bonos-2023/" class="button">Revision</a> 
        <a rel="nofollow noopener noreferrer" target="_blank" href="https://www.apuestan.com/link/bcgame" class="button">Apostar</a>
      </div>
    </div>
  </div>
</div>
<div class="side_box mt-5">
                            <div class="box_header">
                                PRONOSTICOS
                            </div>
                            <div class="box_body">   <a href="http://localhost/jeff-local/prediccion/pronostico-cleveland-cavaliers-vs-memphis-grizzlies-01-02-2024-nba-4/" class="top_box top_box3">

                            <div class="top_box3_right_content league_box1">
                                NBA                             
                            </div>
                    
                            <div class="top_box3_left_content">
                                <div class="top_box3_img">
                                    <img width="25px" height="25px" src="http://localhost/jeff-local/wp-content/uploads/2024/11/cleveland-cavaliers-logo.svg" alt="Cleveland Cavaliers">
                                    <p>Cleveland Cavaliers</p>
                                </div>
                                <div class="top_box3_img top_box3_img2">
                                    <img width="25px" height="25px" src="http://localhost/jeff-local/wp-content/uploads/2024/11/memphis-grizzlies-logo.svg" alt="Memphis Grizzlies">
                                    <p>Memphis Grizzlies</p>
                                </div>
                            </div>
                            

                            <i class="fas fa-chevron-right"></i>
                       </a> </div> </div>
    <div class="blog_hero_area">
        <div class="container">
            <div class="blog_bg" style="background-image: url(<?php echo $thumb ?>);">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="blog_hero_content">
                            <div class="blog_top_content">
                                <img src="<?php echo $alt_logo ?>" class="img-fluid" alt="icon-apuestan">
                                <p>Blog &amp; Noticias</p>
                            </div>
                            <h2><?php echo $h1 ?></h2>
                            <div class="blog_hero_btn">
                                <a href="<?php echo $permalink ?>" class="btn_2">Leer Articulo</a>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="blog_box_wrapper">
        <div class="container">
            <?php 
                echo do_shortcode("[blog filter='yes' title='Lo más reciente']"); 
            ?>
        </div>
    </div>
</main>

<?php get_footer();?>