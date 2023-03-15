<?php
$logo = get_template_directory_uri() . '/assets/img/logo.svg';

?>
<footer class="footer mt-5">
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
                    <ul class="menu text-uppercase" >
                        <?php
                        
                            if ( get_key() ):
                                $ret = strip_tags( wp_nav_menu( array(
                                    'theme_location' => 'footer',
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
                <!--RRSS-->
                <?php
                echo get_option('tl');
                echo '<div class="col-lg-2 col-6 mt_20 text-right"> 
                    <div class="social_icons">
                            <a href="'.tl.'" aria-label="follow us on telegram" rel="nofollow noreferrer noopener" target="_blank">
                                 <i class="fab fa-telegram-plane"></i>
                            </a>                                                     
                            <a href="'.fb.'" aria-label="follow us on facebook" rel="nofollow noreferrer noopener" target="_blank">
                                <i class="fab fa-facebook"></i>
                            </a>                        
                            <a href="'.tw.'" aria-label="follow us on twitter" rel="nofollow noreferrer noopener" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>                        
                            <a href="'.ig.'" aria-label="follow us on instagram" rel="nofollow noreferrer noopener" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                    </div>
                </div>'
                ?>
                <div class="d-inline-flex mt_30 p-2 bd-highlight mx-auto align-items-center">   
                    <span class="mr-4 font-weight-bold s-f f-f">FORMATO DE CUOTAS</span>                       
                    <select id="select_odds_format" class="nice-select text-dark text-capitalize">
                        <option value="2" <?php if(get_option( "odds_type")=='2'): echo "selected"; endif; ?> >decimal</option>
                        <option value="3" <?php if(get_option( "odds_type")=='3'): echo "selected"; endif; ?>  >american</option>
                    </select>
                </div>

                <div class="col-12 text-center">
                <?php
                        $theme_regulation = carbon_get_theme_option( 'country_reg' );
                        $current_country = json_decode($_SESSION["geolocation"]);
                        $agesvg = get_template_directory_uri() . '/assets/img/age.svg';
                        $aw_system_location = aw_select_country(["country_code"=>$current_country->country_code]);
                        if(isset($theme_regulation) and count($theme_regulation) > 0):
                            foreach($theme_regulation as $regs):
                                if(isset($aw_system_location) and $regs["country_code"] == $aw_system_location->country_code):
                                    echo '<p class="p-reg s-f text-break">'.$regs["text_reg"].'</p> ';
                                    echo '<div class="row justify-content-center footer-reg">';
                                    echo '<div class="flex justify-center  flex-wrap">';
                                    foreach ($regs["images"] as $image) {
                                        $file_uri =  wp_get_attachment_url( $image['image'] );
                                        $alt = get_the_title($image['image']); // Obtener el título de la imagen
                                        echo '<a href="'.$image['url'].'"  rel="nofollow" target="new" ><img height="43px" width="133px" class="img-fluid mx-2" src="'.$file_uri.'" aria-label="'.$alt.'" alt="'.$alt.'" /></a>';
                                    }
                                    echo '</div>';
                                    echo '</div>';
                                    if($regs["text_reg2"] and $regs["text_reg2"] !== ''):
                                       echo '<div id="modal_age_terms" style="backdrop-filter: blur(3px);display:none;align-content: center;width:100%;height:100%;position:fixed;top:0;left:0;background:rgba(0,0,0, .2);z-index:99999999;" >
                                                <div class="row bg-light mx-auto text-center" style="width:320px;height:320px;border-radius:5%;align-items:center;">
                                                <img class=mx-auto width="240" height="125" src='.$agesvg.'>
                                                <div class="col-12 text-center">
                                                        <b class="title d-block">'.$regs["text_reg2"].'</b>
                                                        <button type="button" class="btn btn-primary px-4 m-5 text-uppercase" onclick="setAge(this)"><p class="h2" >si</p></button>
                                                        <button type="button" class="btn btn-secondary px-4 m-5 text-uppercase" onclick="setAge(this)"><p class="h2" >no</p></button>
                                                    </div>
                                                </div>
                                            </div> ';
                                    endif;
                                endif;

                                if(!isset($aw_system_location) and $regs["country_code"] == "WW"):
                                    echo '<p class="p-reg s-f text-break">'.$regs["text_reg"].'</p> ';
                                    echo '<div class="row justify-content-center footer-reg">';
                                    echo '<div class="flex justify-center  flex-wrap">';
                                    foreach ($regs["images"] as $image) {
                                        $file_uri =  wp_get_attachment_url( $image['image'] );
                                        $alt = get_the_title($image['image']); // Obtener el título de la imagen
                                        echo '<a href="'.$image['url'].'"  rel="nofollow" target="new" ><img height="43px" width="133px" class="img-fluid mx-2" src="'.$file_uri.'" aria-label="'.$alt.'" alt="'.$alt.'" /></a>';
                                    }
                                    echo '</div>';
                                    echo '</div>';
                                    if($regs["text_reg2"] and $regs["text_reg2"] !== ''):
                                       echo '<div id="modal_age_terms" style="backdrop-filter: blur(3px);display:none;align-content: center;width:100%;height:100%;position:fixed;top:0;left:0;background:rgba(0,0,0, .2);z-index:99999999;" >
                                                <div class="row bg-light mx-auto text-center" style="width:320px;height:320px;border-radius:5%;align-items:center;">
                                                <img class=mx-auto width="240" height="125" src='.$agesvg.'>
                                                <div class="col-12 text-center">
                                                        <b class="title d-block">'.$regs["text_reg2"].'</b>
                                                        <button type="button" class="btn btn-primary px-4 m-5 text-uppercase" onclick="setAge(this)"><p class="h2" >si</p></button>
                                                        <button type="button" class="btn btn-secondary px-4 m-5 text-uppercase" onclick="setAge(this)"><p class="h2" >no</p></button>
                                                    </div>
                                                </div>
                                            </div> ';
                                    endif;
                                endif;
                                
                            endforeach;
                        endif;

                       
                    ?>
                    <p class="copy mt-5 py-2 s-f" ><?php echo carbon_get_theme_option( 'copy' ) ?></p>
                    <?php echo carbon_get_theme_option( 'footer_code' ) ?>

                </div>
            </div>
        </div>
        <!--====== BACK TO TOP START ======-->
        <a href="#" aria-label="back to top" class="back-to-top"><i class="fa fa-angle-up"></i></a>
        <!--====== BACK TO TOP ENDS ======-->
</footer>
<?php wp_footer(); ?>

</body>
</html>
