<?php
$logo = get_template_directory_uri() . '/assets/img/logo.svg';
?>
<footer class="footer">
<div class="container">
            <div class="row align-items-center form-row">
                <div class="col-lg-2 col-6 mt_20">
                <?php if ( carbon_get_theme_option( 'logo' ) )
					$logo = wp_get_attachment_url( carbon_get_theme_option( 'logo' ) );
				?>
                    <!--logo start-->
                    <a href="index.html">
                        <img src="<?php echo $logo; ?>" class="img-fluid" alt="Apuestanweb">
                    </a>
                    <!--logo end-->
                </div>
                <div class="col-lg-8 footer_menu_col mt_20">
                    <!--menu start-->
                    <ul class="menu" >
                        <?php
                        
                            if ( get_key() ):
                                $ret = strip_tags( wp_nav_menu( array(
                                    'theme_location' => 'top',
                                    'echo'           => false
                                ) ), '<li><a>' );
                                if ( $ret ):
                                    echo $ret;
                                else:
                                    echo "";
                                endif;
                            else:
                                echo notice();
                            endif;
                         // echo apply_filters( 'the_content', carbon_get_theme_option( 'pod_logo' ) ); 
                         ?>
                    </ul>
                    <!--menu end-->
                </div>
                <div class="col-lg-2 col-6 mt_20 text-right">
                    <div class="social_icons">
                        <a href="#">
                            <i class="fab fa-facebook"></i>
                        </a>                        
                        <a href="#">
                            <i class="fab fa-twitter"></i>
                        </a>                        
                        <a href="#">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <p class="copyright"><?php echo carbon_get_theme_option( 'copy' ); ?></p>
                </div>
            </div>
        </div>
        <!--====== BACK TO TOP START ======-->
        <a href="#" class="back-to-top"><i class="fal fa-angle-up"></i></a>
        <!--====== BACK TO TOP ENDS ======-->
            
</footer>
<?php wp_footer();
$footer_code = carbon_get_theme_option( 'footer_code' );
if ( $footer_code ) {
    echo $footer_code;
}
?>

</body>
</html>