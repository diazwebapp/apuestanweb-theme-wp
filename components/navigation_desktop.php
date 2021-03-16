<nav>	
    <?php
    //Desktop menu
        if ( has_nav_menu( 'izquierda' ) ) {

            wp_nav_menu(
                array(
                    'container'  => '',
                    'theme_location' => 'izquierda',
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
            </ul>
        <?php } 
    ?>
    <div id="btn_menu_mobile" >menu</div>

    <?php the_custom_logo(); ?>
        
    <?php
    //Desktop menu
        if ( has_nav_menu( 'derecha' ) ) {

            wp_nav_menu(
                array(
                    'container'  => '',
                    'theme_location' => 'derecha',
                )
            );

        }else{ ?>
            <ul>
                <li><a href="http://<?php if($_SERVER["SERVER_NAME"] == "localhost"){
                    echo $_SERVER["HTTP_HOST"] ;
                }else{echo $_SERVER['SERVER_NAME']; }  ?>/index.php/pronosticos" >pronosticos</a></li>
                <li><a href="#" >contacto</a></li>
            </ul>
        <?php } 
    ?>
    <div>Contact</div>
</nav>