<?php 
get_header(); ?>

<?php 
$location = json_decode(GEOLOCATION);
//Seteamos valores por defecto de la casa de apuesta
$bookmaker["name"] = "no bookmaker";
$bookmaker["logo"] = get_template_directory_uri() . '/assets/img/logo2.svg';
//Buscamos la casa de apuesta del pronostico

    //Si existe una casa de apuesta seteamos sus valores
    $bookmaker['name'] = get_the_title( get_the_ID() );
    $bookmaker["bonus_amount"] = carbon_get_post_meta(get_the_ID(), 'bonus_amount');
    $bookmaker["ref_link"] = carbon_get_post_meta(get_the_ID(), 'ref');
    $bookmaker["bonus_slogan"] = carbon_get_post_meta(get_the_ID(), 'bonus_slogan');
    $bookmaker["rating"] = carbon_get_post_meta(get_the_ID(), 'rating');
    $bookmaker["feactures"] = carbon_get_post_meta(get_the_ID(), 'feactures');
    $bookmaker["general_feactures"] = carbon_get_post_meta(get_the_ID(), 'general_feactures');

    $bookmaker["payment_methods"] = get_bookmaker_payments(get_the_ID());

    if (carbon_get_post_meta(get_the_ID(), 'mini_img')):
        $logo = carbon_get_post_meta(get_the_ID(), 'mini_img');
        $bookmaker['logo'] = wp_get_attachment_url($logo);
    endif;
?>

<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <h1 class="title mt-5 pt-4"><?php echo $bookmaker['name'] ?></h1>
            
            <div class="container my-4"> 
                <div class="row">
                    <!-- Heading -->
                    <div class="col-md-12 col-lg-3 text-center d-flex align-items-center container_logo_review" style="background:black; min-height:139px;">
                        <!-- rating movil-->
                        <div class="d-md-none text-center" style="position: absolute;z-index: 2; width: 100%;top:10px;left:0;" >
                            <span class="text-uppercase text-light" style="font-size:1.9rem;" ><?php echo $bookmaker["rating"]?></span>
                            <?php 
                                if(isset($bookmaker["rating"])):
                                    for($i=0; $i<intval($bookmaker["rating"]);$i++):
                                        echo '<i class="fa fa-star text-warning px-1 py-1" ></i>';
                                    endfor;
                                endif;
                            ?>
                        </div>
                        <img width="130rem" height="40rem" class="mx-auto" src="<?php echo $bookmaker['logo'] ?>" alt="">
                    </div>
                    <div class="col-md-12 col-lg-9" style="box-shadow: 0px 0px 9px #00000009, 0px 0px 9px #00000009;border-radius:0 8px 8px 0;">
                        <div class="row">

                            <div class="col-md-12 col-lg-8" >
                                <div class="row text-center">                        
                                    <div class="col-md-12 d-md-block d-lg-none my-3">
                                        <small style="font-size:2rem;" class="align-middle" >acepts player from </small>
                                        <img width="40px" height="17px" style="border-radius:1rem;object-fit:contain;" src="<?php echo $location->flag_uri ?>" alt="<?php echo $location->country ?>">
                                    </div>
                                    <div class="col-md-12 col-lg-6 my-3">
                                        <i class="fa fa-check text-white bg-success rounded px-1 py-1 font-weight-light" style="font-size:1rem"></i>
                                        <span class="text-uppercase text-success align-middle ml-3" style="font-size:1.7rem;"> Calificación</span>                            
                                    </div>
                                    <!-- rating -->
                                    <div class="col-md-12 col-lg-6 d-none d-lg-block my-3" >
                                        <span class="text-uppercase text-body " style="font-size:1.9rem;" ><?php echo $bookmaker["rating"]?></span>
                                        <?php 
                                            if(isset($bookmaker["rating"])):
                                                for($i=0; $i<intval($bookmaker["rating"]);$i++):
                                                    echo '<i class="fa fa-star text-warning px-1 py-1 align-text-bottom" ></i>';
                                                endfor;
                                            endif;
                                        ?>
                                    </div>
            
                                    <div class="col-12 my-4 special-single-bk-button" >
                                        <b style="background:lightgray;font-size:18px;border-radius:.5rem;" class="px-2 text-body text-uppercase" ><?php echo $bookmaker["bonus_slogan"] ?></b>
                                    </div>
                                    <div class="col-12 my-3 special-single-bk-button">                                
                                        <a href="<?php echo $bookmaker["ref_link"] ?>" class="text-uppercase badge badge-primary px-5" style="font-size:15px;border-radius:.5rem;font-weight: 500" target="_blank"><?php echo _e("Visitar") ?> <i class="fa fa-external-link ml-5" aria-hidden="true"></i></a>                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4">
                                <div class="row">
        
                                    <div class="col-12 text-right d-none d-sm-block my-3">
                                        <small style="font-size:1.6rem;" class="align-middle">acepts player from </small>
                                        <img width="40px" height="17px" style="border-radius:1rem;object-fit:contain;" src="<?php echo $location->flag_uri ?>" alt="<?php echo $location->country ?>">
                                    </div>
                                    <div class="col-12 d-none d-sm-block my-3">
                                        <?php
                                            if(isset($bookmaker["feactures"]) and count($bookmaker["feactures"]) > 0):
                                                foreach($bookmaker["feactures"] as $feacture):
                                                    echo '<p style="color:#00203A;" >- '.$feacture['feacture'].' </p>';
                                                endforeach;
                                            endif;
                                        ?>
                                    </div>
                                    <div class="col-12 my-3 text-center">
                                        <?php 
                                            if( isset($bookmaker["payment_methods"]) and count($bookmaker["payment_methods"]) > 0){
                                                foreach ($bookmaker["payment_methods"] as $key => $payment) {
                                                    echo '<img width="'.$payment->img_icon[1].'" class="mx-2" height="'.$payment->img_icon[2].'" src="'.$payment->img_icon[0].'" />';
                                                }
                                            }
                                        ?>
                                    </div>
        
                                </div>
                            </div>

                        </div>
                    </div>

                </div>               
            </div>
            <!-- Content -->
            
        </div>

        <div class="col-lg-3 mt-3">
            <div class="row mt-5">
                <div class="col-lg-12 col-md-6 ">                    

                    <div class="side_box mt-5">
                        <div class="box_header">Información</div>
                        <div class="py-5 px-5 mb-5 bg-white" style="box-shadow: inset 0px 3px 6px #00000029, 0px 3px 6px #00000029;border-radius:0 0 18px 18px;">
                            <?php
                                if(isset($bookmaker["general_feactures"]) and count($bookmaker["general_feactures"]) > 0):
                                    foreach($bookmaker["general_feactures"] as $feacture):
                                        echo '<p class="d-flex justify-content-between my-2 text-uppercase" style="color:black;">'.$feacture['feacture'].' <span style="color:black;" >'.$feacture['points'].' <i class="fa fa-star text-warning"></i></span></p>';
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

                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
