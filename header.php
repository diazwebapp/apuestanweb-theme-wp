<!DOCTYPE html>
<html>
<head>
    <title><?php wp_title(''); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<?php wp_head(); ?>
</head>
<body>
<?php /*
    $post_type = get_post_type( );
    if($post_type == "bk" and is_single()):
        echo do_shortcode("[slide_forecasts model='2']");
    endif;*/
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
<<<<<<< HEAD
                </div>
                <div class="col-lg-2 order-lg-3 col-6">
                <?php 
                    if(is_user_logged_in( )):
                    echo '<div class="navbar navbar-expand-lg ">

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                      <ul class="navbar-nav mr-auto menu">
                        
                        <li class="dropdown">
                          <a class="dropdown-toggle nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dropdown
                          </a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" style="line-height:2 !important;color:black !important;" href="#">Action</a>
                            <a class="dropdown-item" style="line-height:2 !important;color:black !important;" href="#">Another action</a>
                          </div>
                        </li>
                        
                      </ul>
                      
                    </div>
                  </div>';
                    else:
                        echo '<a href="/member-login" class="btn_2 headerlgn mr-2"><i class="far fa-user"></i></a>';
                        echo '<a href="<?php echo PERMALINK_VIP ?>" class="headerbtn"><?php $loc = json_decode($_SESSION["geolocation"]); echo $loc->country; ?> </a>';
                    endif;
                 ?>

                   

=======
                    
>>>>>>> f967b86946f338ccccaeef6207c265794336377d
                </div>
                <div class="col-lg-8 order-lg-2">
                    <!--menu start-->
                    <ul class="menu text-uppercase">                    
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
                <div class="col-lg-2 order-lg-3 col-md-6">
                        <?php 
                            if(is_user_logged_in( )):
                            echo '<div class="navbar navbar-expand-lg ">
        
                            <div class="navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto ">
                                
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Dropdown link
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                              <a class="dropdown-item" href="#">Action</a>
                              <a class="dropdown-item" href="#">Another action</a>
                              <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                          </li>
                                
                            </ul>
                            
                            </div>
                        </div>';
                            else:
                                echo '<a href="http://betmaste.com" class="btn_2 headerlgn mr-2"> Login</a>';
                            endif;
                        ?>
    
                    </div>
            </div>
        </div>
</header>

<?php