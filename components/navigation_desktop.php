<nav>	
    <?php
    //Desktop menu
        if ( has_nav_menu( 'left' ) ) {

            wp_nav_menu(
                array(
                    'container'  => '',
                    'theme_location' => 'left',
                )
            );

        }else{ ?>
            <ul>
                <li><a href="<?php echo home_url() ?>/e-sports" >e-sports</a></li>

                <li><a href="<?php echo home_url() ?>/blog" >blog</a></li>
            </ul>
        <?php } 
    ?>
    <div id="btn_menu_mobile" ><a class="icon" href="#!" >☰</a></div>

    <?php if ( has_custom_logo() ){
            the_custom_logo();
        }else{ ?>
        <a href="<?php echo home_url()  ?>" >
            <img src="<?php echo get_template_directory_uri() ?>/assets/images/hh2.png" alt="logo">
		</a>
    <?php } ?>
        
    <?php
    //Desktop menu
        if ( has_nav_menu( 'right' ) ) {

           wp_nav_menu(
                array(
                    'container'  => '',
                    'theme_location' => 'right',
                )
            ); ?>
            
        <?php }else{ ?>
            <ul>
                <!-- <li><a href="<?php /* echo get_post_type_archive_link('pronosticos'); */ ?>" ><?php /* echo _e("pronósticos") */ ?></a></li> -->
                <li>
                <?php 
                    if (is_user_logged_in()):?>
                            <a title="Logout" href="<?php echo wp_logout_url() ?>"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512"><path d="M320,176V136a40,40,0,0,0-40-40H88a40,40,0,0,0-40,40V376a40,40,0,0,0,40,40H280a40,40,0,0,0,40-40V336" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"/><polyline points="384 176 464 256 384 336" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"/><line x1="191" y1="256" x2="464" y2="256" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"/></svg></a>
                    <?php else: ?>
                        <span id="aw_btn_login" class="icon" title="Login"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512"><path d="M192,176V136a40,40,0,0,1,40-40H392a40,40,0,0,1,40,40V376a40,40,0,0,1-40,40H240c-22.09,0-48-17.91-48-40V336" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"/><polyline points="288 336 368 256 288 176" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"/><line x1="80" y1="256" x2="352" y2="256" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"/></svg></span></li>
                <?php endif; ?>
                </li>
            </ul>
            
        <?php } ?>
     
    <div>
        <?php 
            if (is_user_logged_in()):?>
                    <a title="Logout" href="<?php echo wp_logout_url() ?>"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512"><path d="M320,176V136a40,40,0,0,0-40-40H88a40,40,0,0,0-40,40V376a40,40,0,0,0,40,40H280a40,40,0,0,0,40-40V336" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"/><polyline points="384 176 464 256 384 336" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"/><line x1="191" y1="256" x2="464" y2="256" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"/></svg></a>
            <?php else: ?>
                    <span id="aw_btn_login" class="icon" title="Login"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512"><path d="M192,176V136a40,40,0,0,1,40-40H392a40,40,0,0,1,40,40V376a40,40,0,0,1-40,40H240c-22.09,0-48-17.91-48-40V336" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"/><polyline points="288 336 368 256 288 176" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"/><line x1="80" y1="256" x2="352" y2="256" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"/></svg></span></li>
        <?php endif; ?>
    </div>
</nav>

