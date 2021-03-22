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
                <li><a href="<?php echo home_url().'/index.php'  ?>/e-sports" >e-sports</a></li>

                <li><a href="<?php echo home_url().'/index.php'  ?>/blog" >blog</a></li>
            </ul>
        <?php } 
    ?>
    <div id="btn_menu_mobile" >menu</div>

    <?php if(the_custom_logo()){the_custom_logo();}else{ ?>
        <a href="<?php echo home_url()  ?>" >
            <img src="https://apuestanweb.com/wp-content/uploads/2019/10/hh2.png" alt="logo">
		</a>
    <?php } ?>
        
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
                <li><a href="<?php echo get_post_type_archive_link('pronosticos'); ?>" ><?php echo __("pronósticos") ?></a></li>
                <?php 
                    if (is_user_logged_in())
                        {
                            echo '<li>
                                        <a href="'. wp_logout_url() .'">'. __("Salir") .'</a>
                                        </li>';
                        }
                        else
                        {
                            echo '<li>
                                        <a href="'. wp_login_url() .'">'. __("Acceder") .'</a>
                                        </li>';
                } ?>
            </ul>
        <?php } 
    ?>
    <div>Contact</div>
</nav>