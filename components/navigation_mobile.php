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
                <li><a href="<?php echo home_url().'/index.php'  ?>/e-sports" >e-sports</a></li>

                <li><a href="<?php echo home_url().'/index.php'  ?>/blog" >blog</a></li>

                <li><a href="<?php echo get_post_type_archive_link('pronosticos'); ?>" >pronosticos</a></li>

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
        <?php } ?>
</div>