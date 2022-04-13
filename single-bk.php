<?php get_header();
$title = get_the_title(get_the_ID());
$id = get_the_ID();
//Logo
$logo_src = get_template_directory_uri() . '/assets/img/logo.svg';
$meta_logo = carbon_get_post_meta(get_the_ID(), 'mini_img');
if($meta_logo)
    $logo_src = wp_get_attachment_url($meta_logo);
//Background
$bg_png = get_template_directory_uri() . '/assets/img/banner2.png';
$meta_bg = carbon_get_post_meta(get_the_ID(), 'wbg');
if($meta_bg)
    $bg_png = wp_get_attachment_url($meta_bg);

$ref = carbon_get_post_meta(get_the_ID(), 'ref');
$permalink = get_the_permalink();
$num_comments = get_comments_number();
$bonus = carbon_get_post_meta(get_the_ID(), 'bonus');
$bonus_sum = carbon_get_post_meta(get_the_ID(), 'bonus_sum');

$feactures = carbon_get_post_meta(get_the_ID(), 'feactures');
$html_feactures = "";
if(!empty($feactures) and count($feactures) > 0):
    foreach($feactures as $feacture):
        $html_feactures .= '<li><span><i class="fa-solid fa-check"></i></span>'.$feacture['feacture'].'</li>' ;
    endforeach; 
endif;


$rating_ceil = ceil(carbon_get_post_meta(get_the_ID(), 'rating'));
$html_rating_ceil = "";
$class = "";
for($i=0; $i < 5; $i++):
    if(intval($rating_ceil) ==  $i)
        $class = 'cl';
    $html_rating_ceil .= '<a href="#" class="'.$class.'" ><i class="fa-solid fa-star"></i></a>' ;
endfor; 

?>

<div class="review__area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="review__wrap">
                            <div class="review__fx">
                                <div class="review__lf">
                                    <div class="review__title">
                                        <h1><?php echo $title ?> Review 2022</h1>
                                    </div>
                                    
                                    <div class="review__reting__box">
                                        <div class="review__reting--top__fx">
                                           <div class="str str-mobile">
                                                    <?php echo $html_rating_ceil ?>                                 
                                                </div> 
                                            <a href="#"><img src="<?php echo $logo_src ?>" alt="<?php echo $title ?>"></a>
                                            <div class="reting__star">
                                                <h5>Rating</h5>
                                                <div class="str">
                                                    <?php echo $html_rating_ceil ?>                             
                                                </div>
                                            </div>
                                        </div>
                                        <div class="reting__menu--fx">
                                           <div class="reting__menu--ri mbl--ret">
                                                <h3><?php echo $bonus ?></h3>
                                            </div>
                                            <div class="reting__menu">
                                                <ul>
                                                    <?php echo $html_feactures ?>
                                                </ul>
                                            </div>
                                            <div class="reting__menu--ri">
                                                <h3><?php echo $bonus ?></h3>
                                            </div>
                                            <div class="payment__btn pay--mobl">
                                                <a href="<?php echo $ref ?>">VISITAR</a>
                                            </div>
                                        </div>
                                        <div class="payment__fx">
                                            <div class="payment__wrap--lf">
                                                <div class="payment__wrap">
                                                    <div class="payment-vs">
                                                        <p>Payments / payouts</p>
                                                    </div>
                                                    <div class="payment--img">
                                                        <a href="#"><i class="fa-brands fa-cc-visa"></i></a>
                                                        <a href="#"><i class="fa-brands fa-cc-mastercard"></i></a>
                                                        <a href="#"><i class="fa-brands fa-cc-paypal"></i></a>
                                                        <a href="#"><i class="fa-brands fa-cc-paypal"></i></a>
                                                    </div>
                                                </div>
                                                <div class="payment__wrap">
                                                    <div class="payment-vs">
                                                        <p>Rapidez del pago:</p>
                                                    </div>
                                                    <div class="payment--clock">
                                                        <p><i class="fa-solid fa-clock-desk"></i>1-2 Dias</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="payment__btn">
                                                <a href="<?php echo $ref ?>">VISITAR</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="review__box">
                                       <?php 
                                        if(have_posts()):
                                            while (have_posts()) {
                                                the_post();
                                                the_content();
                                            }
                                        endif;
                                       ?>
                                    </div>
                                    <!-- banner-->
                                    <div class="visister__box">
                                        <div class="visit--logo">
                                            <a href="#"><img src="<?php echo $logo_src ?>" alt=""></a>
                                        </div>
                                        <div class="visister--text">
                                            <p><?php echo $bonus ?></p>
                                        </div>
                                        <div class="vist__btn">
                                            <a href="<?php echo $ref ?>">VISITAR</a>
                                        </div>
                                    </div>
                                    <div class="bono__mobile">
                                        <div class="visister--text vis__tx-sec">
                                            <p><?php echo $bonus ?></p>
                                        </div>
                                        <div class="vist__btn vis__bt">
                                            <a href="<?php echo $ref ?>">VISITAR</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="review__ri">
                                    <?php dynamic_sidebar( 'forecast-right' ); ?>
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php get_footer(); ?>
