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
                function aw_timeAgo ($oldTime, $newTime) {
                    $timeCalc = strtotime($newTime) - strtotime($oldTime);
                    if ($timeCalc >= (60*60*24*30*12*2)){
                        $timeCalc = intval($timeCalc/60/60/24/30/12) . " years ago";
                        }else if ($timeCalc >= (60*60*24*30*12)){
                            $timeCalc = intval($timeCalc/60/60/24/30/12) . " year ago";
                        }else if ($timeCalc >= (60*60*24*30*2)){
                            $timeCalc = intval($timeCalc/60/60/24/30) . " months ago";
                        }else if ($timeCalc >= (60*60*24*30)){
                            $timeCalc = intval($timeCalc/60/60/24/30) . " month ago";
                        }else if ($timeCalc >= (60*60*24*2)){
                            $timeCalc = intval($timeCalc/60/60/24) . " days ago";
                        }else if ($timeCalc >= (60*60*24)){
                            $timeCalc = " Yesterday";
                        }else if ($timeCalc >= (60*60*2)){
                            $timeCalc = intval($timeCalc/60/60) . " hours ago";
                        }else if ($timeCalc >= (60*60)){
                            $timeCalc = intval($timeCalc/60/60) . " hour ago";
                        }else if ($timeCalc >= 60*2){
                            $timeCalc = intval($timeCalc/60) . " minutes ago";
                        }else if ($timeCalc >= 60){
                            $timeCalc = intval($timeCalc/60) . " minute ago";
                        }else if ($timeCalc > 0){
                            $timeCalc .= " seconds ago";
                        }
                    return $timeCalc;
                    }
                    if(is_user_logged_in( )):
                       $noti = select_notification_not_view();
                       $html = '<ul class="navbar-nav mx-3">
                            <li class="nav-item dropdown">
                                    <a class="nav-link btn btn-primary text-light font-weight-bold py-3" text-uppercase href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-bell" style="color:'. (count($noti) > 0? "green" : "" ) .' !important;font-size:13px !important;"></i>
                                        <span id="notification-counter" class="badge badge-light mx-1" style="font-size:11px !important;">'.count($noti).'</span>
                                    </a>

                                    <div class="dropdown-menu position-absolute text-center" style="font-size: 1.5rem;" aria-labelledby="navbarDropdownMenuLink">
                                        {list}
                                        
                                        <hr class="mt-2 mb-3">
                                        <p role="button" class="dropdown-item text-dark my-3" id="btn_quitar_notificaciones" ><i class="fas fa-sign-out"></i>'.__('quitar todo','jbetting').'</p>

                                    </div>
                                </li>
                       </ul>';
                       if(count($noti) > 0){
                            $li = '';
                            $newTime = date("Y-m-d H:i:s");
                            foreach($noti as $post_noticode){
                                $oldTime = $post_noticode->post_modified;
                                $timeAgo = aw_timeAgo ($oldTime, $newTime);

                                $li .= '<p role="button" class="dropdown-item text-dark my-2 text-truncate" style="max-width:100px;" data-postid="'.$post_noticode->ID.'" onclick="quitar_notificacion(this)">
                                    '. $post_noticode->post_title .'
                                    <span style="font-size:7px;" class="w-100 d-block">'. $timeAgo .'</span>
                                </p>';
                            }
                            $html = str_replace("{list}",$li,$html);
                       }
                    
                    $notificaciones = carbon_get_theme_option('notificaciones');

                    echo '
                    
                    <div class="navbar navbar-expand-lg">
                        <div class="navbar-collapse row" id="navbarSupportedContent">
                            '.(($notificaciones) ? $html : '').'
                            <ul class="navbar-nav">
                                
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-light font-weight-bold" text-uppercase href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <p class="d-inline-block text-truncate align-top" style="max-width:120px;" id="header-username" >'.get_userdata(get_current_user_id( ))->user_login .'</p>
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
