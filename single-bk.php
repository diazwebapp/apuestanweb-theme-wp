<?php 
get_header();


$location = json_decode($_SESSION["geolocation"]);
if (empty($location) || !isset($location->country_code)) {
    die("<p>Error: Geolocation data is missing or invalid.</p>");
}

$aw_system_country = aw_select_country(["country_code" => $location->country_code]);
if (empty($aw_system_country) || !isset($aw_system_country->id)) {
    die("<p>Error: Country system data is missing or invalid.</p>");
}

$bookmaker_detected = aw_detect_bookmaker_on_country($aw_system_country->id, get_the_ID());
if (empty($bookmaker_detected)) {
    die("<p>Error: Bookmaker detection failed for the selected country.</p>");
}

if (isset($bookmaker_detected)) { 
    // Si está configurado en el país
    $bookmaker = [
        'name' => get_the_title(get_the_ID()),
        "bonus_slogan" => "",
        "bonus_amount" => "",
        "ref_link" => "#",
        "background_color" => carbon_get_post_meta(get_the_ID(), 'background-color'),
        "feactures" => carbon_get_post_meta(get_the_ID(), 'feactures'),
        "rating" => carbon_get_post_meta(get_the_ID(), 'rating'),
        "general_feactures" => carbon_get_post_meta(get_the_ID(), 'general_feactures'),
        "payment_methods" => get_bookmaker_payments(get_the_ID()),
        "logo" => get_template_directory_uri() . '/assets/img/logo2.svg',
    ];

    $bonuses = carbon_get_post_meta(get_the_ID(), 'country_bonus');
    if (!empty($bonuses)) {
        foreach ($bonuses as $bonus_data) {
            if (strtoupper($bonus_data["country_code"]) == strtoupper($aw_system_country->country_code)) {
                $bookmaker["bonus_slogan"] = $bonus_data['country_bonus_slogan'] ?? "";
                $bookmaker["bonus_amount"] = $bonus_data['country_bonus_amount'] ?? 0;
                $bookmaker["ref_link"] = $bonus_data['country_bonus_ref_link'] ?? "#";
            }
        }
    }

    if ($logo = carbon_get_post_meta(get_the_ID(), 'logo')) {
        $bookmaker["logo"] = wp_get_attachment_url($logo);
    }
    if ($logo_2x1 = carbon_get_post_meta(get_the_ID(), 'logo_2x1')) {
        $bookmaker["logo_2x1"] = wp_get_attachment_url($logo_2x1);
    }
} else {
    // Si está configurado el país, pero no existen bookmakers, buscamos un WW
    $aw_system_country = aw_select_country(["country_code" => "WW"]);
    if (empty($aw_system_country) || !isset($aw_system_country->id)) {
        die("<p>Error: Country system data is missing or invalid.</p>");
    }

    //$bookmaker = aw_select_relate_bookmakers($aw_system_country->id, ["unique" => true, "random" => false]);
}



$disable_table = carbon_get_post_meta( get_the_ID(), 'disable_table' );
$post_date = get_the_modified_date( "Y-m-d H:i:s", get_the_ID());

?>
<main>
<div class="container">
    <div class="row">
        <?php 
            if(have_posts(  )){
                    
                while (have_posts()):
                    the_post(  ); 
                    $author_id =  get_the_author_meta('ID') ;
                    $author_name = get_the_author_meta("display_name");
                    $avatar_url = get_the_author_meta( 'profile_image',$author_id );
                    $avatar = isset($avatar_url) ? $avatar_url : get_template_directory_uri() . '/assets/img/logo2. svg';
            ?>
                <div class="col-lg-9">
                    <h1 class="my-3"><?php echo $bookmaker['name'] ?></h1>
                    
                    <div class="container "> 
                        <!-- Heading -->
                        <div class="row">

                            <div class="col-md-12 col-lg-4 col-xl-3 text-center d-flex flex-column align-items-center container_logo_review" style="background-color:<?php echo ($bookmaker["background_color"] ? $bookmaker["background_color"] : "black") ?>;">
                                <!-- rating movil-->
                                <div class="d-lg-none text-center py-3">
                                    <span style="font-size:1.5rem;" class="text-uppercase font-weight-500 mr-2 text-light" ><?php echo $bookmaker["rating"]?></span>
                                    <?php 
                                        if(isset($bookmaker["rating"])):
                                            for($i=1; $i<=5;$i++):
                                                echo '<span style="font-size:1.5rem;" class=" '.($i <= intval($bookmaker["rating"]) ? "text-warning" : "").' px-1" >★</span>';
                                            endfor;
                                        endif;
                                    ?>
                                </div>
                                <img loading="lazy" width="100" height="100" class="mx-auto" src="<?php echo $bookmaker['logo'] ?>" alt="<?php echo $bookmaker['name'] ?>">
                            </div>
                            <div class="col-md-12 col-lg-8 col-xl-9 bk-box">
                                <div class="row">

                                    <div class="col-md-12 col-lg-7" >
                                        <div class="row text-center">                        
                                            <div class="col-md-12 d-md-block d-lg-none py-3" >
                                                <small class="text-muted" >acepts player from </small>
                                                <img width="40px" height="17px" style="border-radius:1rem;object-fit:contain;" src="<?php echo $location->flag_uri ?>" alt="<?php echo $location->country ?>">
                                            </div>
                                            <div class="col-md-12 col-lg-6 py-3">
                                                <b class="text-white bg-success rounded font-weight-light px-1" style="font-size:1.2rem">-</b>
                                                <small style="font-size:1.2rem;" class="text-uppercase text-success"> Calificación</small>                            
                                            </div>
                                            <!-- rating -->
                                            <div class="col-md-12 col-lg-6 d-none d-lg-block py-3" >
                                                <small style="font-size:1.2rem;" class="text-uppercase text-body"><?php echo $bookmaker["rating"]?></small>
                                                <?php 
                                                    if(isset($bookmaker["rating"])):
                                                        for($i=1; $i<=5;$i++):
                                                            echo '<span style="font-size:1.2rem; margin-top:-10px !important; position:relative;" class=" '.($i <= intval($bookmaker["rating"]) ? "text-warning" : "").' my-0 px-1" >★</span>';
                                                        endfor;
                                                    endif;
                                                ?>
                                            </div>
                    
                                            <div class="col-12 py-3 special-single-bk-button" >
                                                <b style="border-radius:.5rem;" class="px-2 text-body text-uppercase" ><?php echo $bookmaker["bonus_slogan"] ?></b>
                                            </div>
                                            <div class="col-12 py-3 special-single-bk-button"> 
                                                                            
                                                <a href="<?php echo $bookmaker["ref_link"] ?>" class="btn btn-success " rel="nofollow noreferrer noopener" target="_blank"><?php echo _e("Visitar") ?> <span class="ml-2" aria-hidden="true">🡵</span></a>                                    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-5">
                                        <div class="row">
                
                                            <div class="col-12 text-right d-none d-sm-block py-3">
                                                <small class="text-muted" >acepts player from </small>
                                                <img width="40px" height="17px" style="border-radius:.5rem;object-fit:contain;" src="<?php echo $location->flag_uri ?>" alt="<?php echo $location->country ?>">
                                            </div>
                                            <div class="col-12 d-none d-sm-block ">
                                                <?php
                                                    if(isset($bookmaker["feactures"]) and count($bookmaker["feactures"]) > 0):
                                                        foreach($bookmaker["feactures"] as $feacture):
                                                            echo '<p style="color:#00203A;" ><i class="mr-1">°</i> '.$feacture['feacture'].' </p>';
                                                        endforeach;
                                                    endif;
                                                ?>
                                            </div>
                                            <div class="col-12 my-3 text-center">
                                                <?php 
                                                    if( isset($bookmaker["payment_methods"]) and count($bookmaker["payment_methods"]) > 0){
                                                        foreach ($bookmaker["payment_methods"] as $key => $payment) {
                                                            if($key < 3):
                                                                echo '<img loading="lazy" width="60" height="60" class="mx-2" src="'.$payment->logo_1x1.'" />';
                                                            endif;
                                                        }
                                                        
                                                    }
                                                ?>
                                                <i class="fal fa-plus"></i>
                                            </div>
                
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>               
                    </div>
                    
                        
                    <div class="row">
                                            <div class="col-sm-12">
                                                <div class="author-info d-flex align-items-center m-3 mt-4">
                                                <img src="<?php echo esc_attr($avatar) ?>" class="rounded-circle mr-3" width="40" height="40" alt="Foto <?php echo $author_name ?>">
                                                <div class="author-details d-flex flex-column">
                                                    <span class="author-name mb-1"><?php the_author_posts_link(); ?></span>
                                                    <time datetime="<?php echo $post_date ?>" class="post-date mb-1"><?php echo __("Actualizado $post_date"); ?></time>
                                                </div>
                                                </div>
                                            </div>
                    </div>
                    <!-- Content -->
                    <?php if ( !$disable_table ): ?>
                                                        <!-- Add the button to toggle the table of contents -->
                                                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#table-of-contents" aria-expanded="false" aria-controls="table-of-contents" style="margin-block-end: 1rem;">
                                                            <?php echo __('Contenido de la reseña', 'jbetting' );?>
                                                        </button>

                                                        <!-- Add the table of contents -->
                                                        <div class="collapse" id="table-of-contents">
                                                            <div class="card mt-3">
                                                                <div class="card-header">
                                                                <?php echo __('Tabla de Contenido', 'jbetting' );?>
                                                                </div>
                                                                <ul class="list-group list-group-flush">
                                                                </ul>
                                                            </div>
                                                        </div>
                    <?php endif; ?>
                    <div class="single_event_content text-break">
                        
                    <?php  the_content() ; ?>
                </div>
        <?php endwhile; } ?>
    </div>

        <div class="d-none d-lg-block col-lg-3 mt-3">
            <div class="row mt-5">
                <div class="col-lg-12 col-md-6 ">                    

                    <div class="side_box mt-5">
                        <div class="box_header">Información</div>
                        <div class="py-5 px-5 mb-5 bg-white" style="box-shadow: inset 0px 3px 6px #00000029, 0px 3px 6px #00000029;border-radius:0 0 18px 18px; min-height:190px;">
                            <?php
                                if(isset($bookmaker["general_feactures"]) and count($bookmaker["general_feactures"]) > 0):
                                    foreach($bookmaker["general_feactures"] as $feacture):
                                        echo '<p class="d-flex justify-content-between  text-uppercase" style="color:black;">'.$feacture['feacture'].' <span style="color:black;" >'.$feacture['points'].' ★</span></p>';
                                    endforeach;
                                endif;
                            ?>
                            <!-- CALCULAR EL PROMEDIO -->
                            <?php
                                if(isset($bookmaker["general_feactures"]) and count($bookmaker["general_feactures"]) > 0):
                                    $suma_total = 0;
                                    foreach($bookmaker["general_feactures"] as $feacture):
                                        $suma_total = $suma_total + $feacture['points'];
                                    endforeach;
                                    echo '<div class="text-center mt-5">
                                            <strong style="color:#001F39;font-size:25px;" >Total '.round($suma_total / count($bookmaker['general_feactures']),2).'</strong>
                                        </div>';
                                endif;
                            ?>
                        </div>
                    </div>
                    <div class="row">
                            <?php dynamic_sidebar( 'forecast-right' ); ?>
                        </div>	

                </div>
            </div>
        </div>
        
    </div>
</div>
</main>
<?php get_footer(); ?>
