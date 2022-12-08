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
                    <select id="select_odds_format" class="nice-select text-dark">
                        <option value="2" <?php if(get_option( "odds_type")=='2'): echo "selected"; endif; ?> >decimal</option>
                        <option value="3" <?php if(get_option( "odds_type")=='3'): echo "selected"; endif; ?>  >american</option>
                    </select>
                    <!-- <div class="social_icons">
                        <a href="#">
                            <i class="fab fa-facebook"></i>
                        </a>                        
                        <a href="#">
                            <i class="fab fa-twitter"></i>
                        </a>                        
                        <a href="#">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div> -->
                </div>
                <div class="col-12 text-center">
                <?php
                        $theme_regulation = carbon_get_theme_option( 'country_reg' );
                        $current_country = json_decode($_SESSION["geolocation"]);
                        
                        if(isset($theme_regulation) and count($theme_regulation) > 0):
                            foreach($theme_regulation as $regs):
                                if($regs["country_code"] == $current_country->country_code):
                                    echo '<p class="copyright" style="word-break:break-word;">'.$regs["text_reg"].'</p> ';
                                    echo '<div class="row justify-content-center">';
                                    foreach ($regs["images"] as $image) {
                                        $file_uri =  wp_get_attachment_url( $image['image'] );
                                        echo '<a class="mx-2" href="'.$image['url'].'" target="new" ><img class="img-fluid mx-2" src="'.$file_uri.'" /></a>';
                                    }
                                    echo '</div>';
                                    
                                endif;
                            endforeach;
                        endif;

                       
                    ?>
                    <p class="mt-5 py-2" ><?php echo carbon_get_theme_option( 'copy' ) ?></p>
                
                </div>
            </div>
        </div>
        <!--====== BACK TO TOP START ======-->
        <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>
        <!--====== BACK TO TOP ENDS ======-->
        <!--======MODAL MAYOR EDA ====-->
        <!-- Button trigger modal -->
            <div class="modal fade" id="modal_age_terms" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="row bg-light mx-auto text-center" style="width:320px;height:320px;border-radius:50%;align-items:center;">
                        <div class="col-12 text-center">
                            <b class="title d-block">¿Eres mayor de edad?</b>
                            <button type="button" class="btn btn-primary px-4 m-5" onclick="setAge('si')"><p class="h2" >si</p></button>
                            <button type="button" class="btn btn-secondary px-4 m-5" onclick="setAge('no')"><p class="h2" >no</p></button>
                        </div>
                    </div>
                </div>
            </div> 
</footer>
<?php wp_footer(); ?>

</body>
</html>