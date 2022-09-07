<?php get_header(); ?>

<?php 

//Seteamos valores por defecto de la casa de apuesta
$bookmaker["name"] = "no bookmaker";
$bookmaker["logo"] = get_template_directory_uri() . '/assets/img/logo2.svg';
$bookmaker["wallpaper"] = get_template_directory_uri() . '/assets/img/baner2.png';
//Buscamos la casa de apuesta del pronostico

    //Si existe una casa de apuesta seteamos sus valores
    $bookmaker['name'] = get_the_title( get_the_ID() );
    $bookmaker["bonus_sum"] = carbon_get_post_meta(get_the_ID(), 'bonus_sum');
    $bookmaker["ref_link"] = carbon_get_post_meta(get_the_ID(), 'ref');
    $bookmaker["bonus"] = carbon_get_post_meta(get_the_ID(), 'bonus');
    
    if (carbon_get_post_meta(get_the_ID(), 'mini_img')):
        $logo = carbon_get_post_meta(get_the_ID(), 'mini_img');
        $bookmaker['logo'] = wp_get_attachment_url($logo);
    endif;
    if (carbon_get_post_meta(get_the_ID(), 'wbg')):
        $wallpaper = carbon_get_post_meta(get_the_ID(), 'wbg');
        $bookmaker['wallpaper'] = wp_get_attachment_url($wallpaper);
    endif; 

?>

<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <h1 class="title"><?php echo $bookmaker['name'] ?></h1>
            <div class="row">
                <div class="com-md-4 bookmaker_logo_box">
                    <img class="img-fluid" src="<?php echo $bookmaker['logo'] ?>" alt="">
                </div>
                <div class="com-md-4">raing,slogan</div>
                <div class="com-md-4">location</div>
            </div>
        </div>

        <div class="col-lg-3">
            
        </div>
    </div>
</div>

<?php get_footer(); ?>
