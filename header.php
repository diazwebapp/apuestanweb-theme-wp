<!DOCTYPE html>
<html>
<head>
    <title><?php wp_title(''); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<?php wp_head(); ?>
</head>
<body>
<?php
    var_dump($_SERVER["REMOTE_ADDR"]);
    $post_type = get_post_type( );
    if($post_type == "bk" and is_single()):
        echo do_shortcode("[slide_forecasts model='2']");
    endif;
?>
<header class="sticky-top">
<div class="container">
            <div class="row align-items-center form-row">
                <div class="col-lg-2 order-lg-1 col-6 logo_col">
                    <!-- menu toggler -->
                    <div class="hamburger-menu">
                        <span class="line-top"></span>
                        <span class="line-center"></span>
                        <span class="line-bottom"></span>
                    </div>
                    <!--logo start-->
                    <?php if ( carbon_get_theme_option( 'logo' ) ):
                            $logo = wp_get_attachment_url( carbon_get_theme_option( 'logo' ) );
                        else:
                            $logo =  get_template_directory_uri().'/assets/img/logo.svg';
                        endif;
                    ?>
                    <a href="<?php echo get_home_url('/')?>" class="logo_box" ><img class="img-fluid" alt="apuestanweb logo" src="<?php echo $logo; ?>"></a>
                    <!--logo end-->
                </div>
                <div class="col-lg-2 order-lg-3 btn_group col-6">
                    <a href="#" class="icon_box mr_10">
                        <img src="<?php echo get_template_directory_uri() . '/assets/img/icon8.svg'?>" alt="">
                    </a>
                    <a href="<?php echo PERMALINK_VIP ?>" class="headerbtn"><?php $loc = json_decode($_SESSION["geolocation"]); echo $loc->country; ?> </a>
                    <a href="#" class="headerbtn v2">LOGIN</a>
                </div>
                <div class="col-lg-8 order-lg-2">
                    <!--menu start-->
                    <ul class="menu">                    
                    <?php
                        
                        $ret = strip_tags( wp_nav_menu( array(
                            'theme_location' => 'top',
                            'echo'           => false
                        ) ), '<li><a>' );
                        if ( $ret ):
                            echo $ret;
                        else:
                            echo "";
                        endif;
                        
                    ?>
                    </ul> <!--menu end-->
                </div>
            </div>
        </div>
</header>
<?php
