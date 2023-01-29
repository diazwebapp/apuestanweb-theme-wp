<!DOCTYPE html>
<html lang="<?php echo substr(get_locale(), 0, 2); ?>">
<head>
    <title><?php wp_title('');?></title>
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
        <div class="col-6 logo_col order-lg-1 col-lg-2">
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
        <div class="col-6 order-lg-3 col-lg-2 text-right">
                <?php 
                    if(is_user_logged_in( )):
                    echo '
                    
                    <div class="navbar navbar-expand-lg">

                    <div class="dropdown">
                        <button id="notification-button" class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="
                        font-size: 1.5rem; margin-right: 1rem;">
                            <i class="fas fa-bell"></i>
                            <span id="notification-counter" class="badge badge-light">0</span>
                        </button>
                        <div class="dropdown-menu" id="notification-dropdown" aria-labelledby="dropdownMenuButton">
                            <!-- Aquí se agregarán las notificaciones -->
                            <button id="clear-btn">Clear All</button>
                        </div>
                    </div>
                  

                    <div class="navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-light font-weight-bold" text-uppercase href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <p class="d-inline-block text-truncate align-top" style="max-width:120px;">'.get_userdata(get_current_user_id( ))->user_login .'</p>
                                </a>

                                <div class="dropdown-menu position-absolute text-center" style="font-size: 1.5rem;" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item text-dark font-weight-bold my-3" href="'. esc_url( !empty(get_option( 'ihc_general_user_page' )) ? get_the_permalink(get_option( 'ihc_general_user_page' )) :'/') .'"><i class="fas fa-user"></i>'.__(' Cuenta','jbetting').'</a>
                                    <a class="dropdown-item text-dark font-weight-bold my-3" href="/picks"><i class="fas fa-badge-check"></i>'.__(' Picks Plus','jbetting').'</a>

                                    <hr class="mt-2 mb-3">
                                    <a class="dropdown-item text-dark my-3" href="'. add_query_arg( 'ihcdologout', 'true', wp_logout_url() ).'"><i class="fas fa-sign-out"></i>'.__(' Cerrar sesion','jbetting').'</a>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>';
                    else:
                        echo '<a href="'. esc_url( !empty(get_option( 'ihc_general_login_default_page' )) ? get_the_permalink(get_option( 'ihc_general_login_default_page' )) : wp_login_url()) .'" class="btn_2 headerlgn mr-2" aria-label="Acceder"><i class="far fa-user"></i></a>';
                        echo '<a href="'. PERMALINK_MEMBERSHIPS .'" class="headerbtn">'.__('SÉ MIEMBRO','jbetting').'</a>';
                    endif;
                ?>
            </div>
        <div class="col-6 col-lg-8 order-lg-2">
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
        
    </div>
</div>
</header>

<?php
