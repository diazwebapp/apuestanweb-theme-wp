<div class="menu_mobile_bg"></div>
<div class="menu_mobile" >

<?php
    //Mobile menu
        if ( has_nav_menu( 'mobile' ) ) {

            wp_nav_menu(
                array(
                    'container'  => '',
                    'theme_location' => 'mobile',
                )
            );

        }else{ ?>
            <ul>
                <li><a href="http://<?php if($_SERVER["SERVER_NAME"] == "localhost"){
                    echo $_SERVER["HTTP_HOST"] ;
                }else{echo $_SERVER['SERVER_NAME'] ; }  ?>/index.php/e-sports" >e-sports</a></li>

                <li><a href="http://<?php if($_SERVER["SERVER_NAME"] == "localhost"){
                    echo $_SERVER["HTTP_HOST"] ;
                }else{ echo $_SERVER["SERVER_NAME"] ;} ?>/index.php/blog" >blog</a></li>

                <li><a href="http://<?php if($_SERVER["SERVER_NAME"] == "localhost"){
                    echo $_SERVER["HTTP_HOST"] ;
                }else{echo $_SERVER['SERVER_NAME'] ; }  ?>/index.php/pronosticos" >pronosticos</a></li>

                <li><a href="#" >contacto</a></li>
            </ul>
        <?php } ?>
</div>