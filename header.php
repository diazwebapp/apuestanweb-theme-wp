<!DOCTYPE html>
<html>
<head>
    <title><?php wp_title(''); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <script src="https://unpkg.com/@popperjs/core@2"></script>
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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
<?php
