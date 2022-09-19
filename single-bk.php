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
            <h1 class="title"><?php echo $bookmaker['name'] ?></h1>
            <!-- Heading -->
            <div class="row my-4">
                <div class="col-md-3 d-flex flex-column justify-content-center" style="background:black;height:25rem; border-radius:1rem 0 0 1rem;">
                    <img width="130rem" height="33rem" class="mx-auto" src="<?php echo $bookmaker['logo'] ?>" alt="">
                </div>
                <div class="col-md-6 px-2 d-flex flex-column justify-content-around" >
                    <div class="d-flex justify-content-around">
                        <div>
                            <i class="fa fa-check text-white bg-success rounded px-1 py-1 font-weight-light" style="font-size:1rem"></i>
                            <sub class="text-uppercase text-success" style="font-size:1.9rem;"> Calificación</sub>                            
                        </div>
                        <!-- rating -->
                        <div>
                            <span class="text-uppercase text-body" style="font-size:1.9rem;" ><?php echo $bookmaker["rating"]?></span>
                            <?php 
                                if(isset($bookmaker["rating"])):
                                    for($i=0; $i<intval($bookmaker["rating"]);$i++):
                                        echo '<i class="fa fa-star text-warning px-1 py-1" ></i>';
                                    endfor;
                                endif;
                            ?>
                        </div>
                    </div>
                    <div class="text-center mt-3" >
                        <b style="background:lightgray;font-size:2.7rem;" class="px-4 py-2 rounded text-body" ><?php echo $bookmaker["bonus_slogan"] ?></b>
                    </div>
                    <div class="text-center">
                        <a href="<?php echo $bookmaker["ref_link"] ?>" class="badge badge-primary px-5 py-2 font-weight-light" style="font-size:2rem;" target="_blank"><?php echo _e("Haz tu apuesta") ?></a>
                    </div>
                </div>
                <div class="col-md-3 px-2 d-flex flex-column justify-content-around">
                    <div class="text-right">
                        <small>acepts player from </small>
                        <img width="40px" height="17px" style="border-radius:1rem;object-fit:contain;" src="<?php echo $location->flag_uri ?>" alt="<?php echo $location->country ?>">
                    </div>
                    <div>
                        <?php
                            if(isset($bookmaker["feactures"]) and count($bookmaker["feactures"]) > 0):
                                foreach($bookmaker["feactures"] as $feacture):
                                    echo '<p style="color:black;" >- '.$feacture['feacture'].' </p>';
                                endforeach;
                            endif;
                        ?>
                    </div>
                    <div>
                        <?php 
                            if( isset($bookmaker["payment_methods"]) and count($bookmaker["payment_methods"]) > 0){
                                foreach ($bookmaker["payment_methods"] as $key => $payment) {
                                    echo '<img width="'.$payment->img_icon[1].'" height="'.$payment->img_icon[2].'" src="'.$payment->img_icon[0].'" />';
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
            <!-- Content -->
            
        </div>

        <div class="col-lg-3">
                <div class="col-lg-12 col-md-6">
                    <div class="side_box mt_30">
                        <div class="box_header">Información</div>
                        <div class="box_body shadow py-5 mb-5 bg-white rounded">
                            <?php
                                if(isset($bookmaker["general_feactures"]) and count($bookmaker["general_feactures"]) > 0):
                                    foreach($bookmaker["general_feactures"] as $feacture):
                                        echo '<p class="d-flex justify-content-between my-2" style="color:black;">'.$feacture['feacture'].' <span style="color:black;" >'.$feacture['points'].' <i class="fa fa-star text-warning"></i></span></p>';
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
                                            <strong class="title" >Total '.round($suma_total / count($bookmaker['general_feactures']),2).'</strong>
                                        </div>';
                                endif;
                            ?>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
