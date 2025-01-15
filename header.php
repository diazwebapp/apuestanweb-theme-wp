<!DOCTYPE html>
<html lang="<?php echo substr(get_locale(), 0, 2); ?>">
<head>
    <title><?php wp_title('');?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
	<?php wp_head(); ?>
</head>
<body>

<header class="sticky-top py-1">
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
            <a href="<?php echo get_home_url('/')?>" class="logo_box" ><img class="img-fluid" width="183" height="19" alt="apuestan logo" src="<?php echo $logo; ?>"></a>
            <!--logo end-->
            
        </div>
        <div class="col-6 order-lg-3 col-lg-2 d-flex justify-content-end py-2">
                
                        <div id="open-search-modal" class="headerbtnsearch rounded py-1 px-2">
                            <svg width="30px" height="30px" viewBox="0 -0.5 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 10.7655C5.50003 8.01511 7.44296 5.64777 10.1405 5.1113C12.8381 4.57483 15.539 6.01866 16.5913 8.55977C17.6437 11.1009 16.7544 14.0315 14.4674 15.5593C12.1804 17.0871 9.13257 16.7866 7.188 14.8415C6.10716 13.7604 5.49998 12.2942 5.5 10.7655Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17.029 16.5295L19.5 19.0005" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <!-- <a href="<?php // echo wp_login_url() ?> " class="border ml-1 rounded border-secondary py-2 px-3" aria-label="Acceder">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 12C14.7614 12 17 9.53756 17 6.5C17 3.46243 14.7614 1 12 1C9.23858 1 7 3.46243 7 6.5C7 9.53756 9.23858 12 12 12ZM12 9.8C10.3431 9.8 9 8.32254 9 6.5C9 4.67746 10.3431 3.2 12 3.2C13.6569 3.2 15 4.67746 15 6.5C15 8.32254 13.6569 9.8 12 9.8Z" fill="#ffffff"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M19.1029 14.1087C18.2604 13.2634 16.957 13.0811 15.9161 13.6987C15.7257 13.8117 15.5581 13.9151 15.4036 14.0105C14.9937 14.2635 14.6755 14.4598 14.2654 14.6283C13.75 14.8401 13.0835 15 12 15C10.9268 15 10.2493 14.8491 9.72609 14.6447C9.26355 14.464 8.89822 14.237 8.41685 13.9378C8.32296 13.8795 8.22448 13.8183 8.12019 13.7543C7.07587 13.1132 5.73464 13.2622 4.86415 14.1419C4.48443 14.5256 4.04036 15.0219 3.6849 15.5626C3.34603 16.0781 3 16.7638 3 17.5V20.0003C3 21.6574 4.34334 23 6 23H18C19.6567 23 21 21.6574 21 20.0003V17.5C21 16.7541 20.6447 16.0592 20.2996 15.5391C19.937 14.9927 19.4852 14.4923 19.1029 14.1087ZM16.9367 15.4187C17.1759 15.2768 17.478 15.3116 17.6863 15.5205C18.0214 15.8568 18.3724 16.2521 18.6331 16.645C18.9113 17.0642 19 17.352 19 17.5V20.0003C19 20.5524 18.5525 21 18 21H6C5.44752 21 5 20.5524 5 20.0003V17.5C5 17.3549 5.08549 17.0729 5.35613 16.6613C5.61017 16.2748 5.95358 15.8844 6.28579 15.5487C6.49412 15.3381 6.81106 15.2974 7.07389 15.4588C7.15661 15.5095 7.24087 15.5621 7.32694 15.6159C7.80938 15.9171 8.34918 16.254 8.99836 16.5076C9.79304 16.8181 10.7242 17 12 17C13.3002 17 14.2313 16.8046 15.0254 16.4783C15.6006 16.242 16.1079 15.9282 16.5558 15.6512C16.6879 15.5695 16.8148 15.491 16.9367 15.4187Z" fill="#ffffff"/>
                            </svg>
                        </a> -->
                
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



    <!-- Ventana modal de búsqueda -->
    <div id="search-modal" class="modal">
        <div class="modal-content">
            <span class="close" id="close-search-modal">&times;</span>
            <span>Búsqueda de pronósticos</span>
            <form id="custom-search-form" class="mt-3 mb-3">
                <input type="text" id="search" name="search" placeholder="Introduce el nombre del equipo">
            </form>
            <div id="search-results"></div>
        </div>
    </div>

        
    </div>
</div>
</header>
