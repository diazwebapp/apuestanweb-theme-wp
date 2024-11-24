<?php
$logo = get_template_directory_uri() . '/assets/img/logo.svg';

?>
<footer class="footer mt-5">
<div class="container">
            <div class="row align-items-center form-row">
                <div class="col-lg-2 col-6 mt-3">
                <?php if ( carbon_get_theme_option( 'logo' ) )
					$logo = wp_get_attachment_url( carbon_get_theme_option( 'logo' ) );
				?>
                    <!--logo start-->
                    <a href="/">
                        <img src="<?php echo $logo; ?>" class="img-fluid" width="183" height="19" alt="Apuestanweb">
                    </a>
                    <!--logo end-->
                </div>
                <div class="col-lg-7 .d-none .d-lg-block mt-3">
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
                echo '<div class="col-lg-3 col-6 mt-3 text-right"> 
                    <div class="social_icons">
                            <a href="'.tl.'" aria-label="follow us on telegram" rel="nofollow noreferrer noopener" target="_blank">
                                 <i><?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
<svg fill="#ffffff" width="24px" height="24px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
  <path d="M231.25586,31.73635a15.9634,15.9634,0,0,0-16.29-2.76758L30.40869,101.47365a15.99988,15.99988,0,0,0,2.7124,30.58106L80,141.43069V199.9844a15.99415,15.99415,0,0,0,27.31348,11.31347L133.25684,185.355l39.376,34.65088a15.86863,15.86863,0,0,0,10.51709,4.00293,16.15674,16.15674,0,0,0,4.96338-.78711,15.86491,15.86491,0,0,0,10.68457-11.65332L236.41162,47.43557A15.96073,15.96073,0,0,0,231.25586,31.73635ZM183.20215,207.99416,100.81006,135.4883l118.64453-85.687Z"/>
</svg></i>
                            </a>                                                     
                            <a href="'.fb.'" aria-label="follow us on facebook" rel="nofollow noreferrer noopener" target="_blank">
                                <i><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white">
  <path d="M22.675 0H1.326C.595 0 0 .597 0 1.33V22.67C0 23.403.595 24 1.326 24H12.82v-9.294H9.692v-3.622h3.128V8.288c0-3.096 1.893-4.78 4.655-4.78 1.324 0 2.46.097 2.792.142v3.237l-1.916.001c-1.503 0-1.796.716-1.796 1.765v2.315h3.591l-.468 3.622h-3.123V24h6.117C23.405 24 24 23.403 24 22.67V1.33C24 .597 23.405 0 22.675 0z"/>
</svg>
</i>
                            </a>                        
                            <a href="'.tw.'" aria-label="follow us on twitter" rel="nofollow noreferrer noopener" target="_blank">
                                <i><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white">
  <path d="M22.46 6.004c-.77.343-1.596.57-2.465.675.886-.531 1.565-1.371 1.88-2.372-.831.49-1.755.847-2.734 1.04-.785-.837-1.904-1.36-3.145-1.36-2.38 0-4.312 1.923-4.312 4.291 0 .334.041.66.115.974C7.691 9.134 4.067 7.343 1.64 4.345c-.37.638-.578 1.381-.578 2.18 0 1.506.769 2.835 1.932 3.615-.714-.022-1.387-.215-1.975-.54-.001.018-.001.036-.001.054 0 2.105 1.498 3.86 3.483 4.26-.364.1-.75.156-1.147.156-.281 0-.554-.026-.822-.078.556 1.732 2.164 2.993 4.073 3.026-1.491 1.166-3.377 1.864-5.419 1.864-.353 0-.7-.019-1.043-.061 1.933 1.24 4.23 1.965 6.702 1.965 8.035 0 12.433-6.56 12.433-12.246 0-.187-.004-.374-.014-.56.856-.617 1.6-1.39 2.188-2.27z"/>
</svg>
</i>
                            </a>                        
                            <a href="'.ig.'" aria-label="follow us on instagram" rel="nofollow noreferrer noopener" target="_blank">
                                <i><svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M12 18C15.3137 18 18 15.3137 18 12C18 8.68629 15.3137 6 12 6C8.68629 6 6 8.68629 6 12C6 15.3137 8.68629 18 12 18ZM12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16Z" fill="#ffffff"/>
<path d="M18 5C17.4477 5 17 5.44772 17 6C17 6.55228 17.4477 7 18 7C18.5523 7 19 6.55228 19 6C19 5.44772 18.5523 5 18 5Z" fill="#ffffff"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M1.65396 4.27606C1 5.55953 1 7.23969 1 10.6V13.4C1 16.7603 1 18.4405 1.65396 19.7239C2.2292 20.8529 3.14708 21.7708 4.27606 22.346C5.55953 23 7.23969 23 10.6 23H13.4C16.7603 23 18.4405 23 19.7239 22.346C20.8529 21.7708 21.7708 20.8529 22.346 19.7239C23 18.4405 23 16.7603 23 13.4V10.6C23 7.23969 23 5.55953 22.346 4.27606C21.7708 3.14708 20.8529 2.2292 19.7239 1.65396C18.4405 1 16.7603 1 13.4 1H10.6C7.23969 1 5.55953 1 4.27606 1.65396C3.14708 2.2292 2.2292 3.14708 1.65396 4.27606ZM13.4 3H10.6C8.88684 3 7.72225 3.00156 6.82208 3.0751C5.94524 3.14674 5.49684 3.27659 5.18404 3.43597C4.43139 3.81947 3.81947 4.43139 3.43597 5.18404C3.27659 5.49684 3.14674 5.94524 3.0751 6.82208C3.00156 7.72225 3 8.88684 3 10.6V13.4C3 15.1132 3.00156 16.2777 3.0751 17.1779C3.14674 18.0548 3.27659 18.5032 3.43597 18.816C3.81947 19.5686 4.43139 20.1805 5.18404 20.564C5.49684 20.7234 5.94524 20.8533 6.82208 20.9249C7.72225 20.9984 8.88684 21 10.6 21H13.4C15.1132 21 16.2777 20.9984 17.1779 20.9249C18.0548 20.8533 18.5032 20.7234 18.816 20.564C19.5686 20.1805 20.1805 19.5686 20.564 18.816C20.7234 18.5032 20.8533 18.0548 20.9249 17.1779C20.9984 16.2777 21 15.1132 21 13.4V10.6C21 8.88684 20.9984 7.72225 20.9249 6.82208C20.8533 5.94524 20.7234 5.49684 20.564 5.18404C20.1805 4.43139 19.5686 3.81947 18.816 3.43597C18.5032 3.27659 18.0548 3.14674 17.1779 3.0751C16.2777 3.00156 15.1132 3 13.4 3Z" fill="#ffffff"/>
</svg></i>
                            </a>
                    </div>
                </div>'
                ?>
                <div class="col-12 text-center my-5">   
                    
                        <label for="select_odds_format" class="mr-4 font-weight-bold">FORMATO DE CUOTAS</label>   
                        

                        <select id="select_odds_format" class="myselect">
                            <option value="2" <?php if(get_option( "odds_type")=='2'): echo "selected"; endif; ?> >decimal</option>
                            <option value="3" <?php if(get_option( "odds_type")=='3'): echo "selected"; endif; ?>  >american</option>
                        </select>
                    
                        
                                       
                </div>

                <div class="col-12 text-center">
                <?php
                        $theme_regulation = carbon_get_theme_option( 'country_reg' );
                        $current_country = json_decode($_SESSION["geolocation"]);
                        $agesvg = get_template_directory_uri() . '/assets/img/age.svg';
                        
                        if(isset($theme_regulation) and count($theme_regulation) > 0):

                            $regulation = null;
                            foreach($theme_regulation as $regs):
                                
                                if($regs["country_code"] == "WW"):
                                    $regulation = $regs;
                                endif;
                                if($regs["country_code"] == $current_country->country_code):
                                    $regulation = $regs;
                                endif;
                                
                            endforeach;
                            if(isset($regulation)):
                                echo '<p class="p-reg s-f text-break">'.$regulation["text_reg"].'</p> ';
                                echo '<div class="row justify-content-center footer-reg">';
                                echo '<div class="flex justify-center  flex-wrap">';
                                foreach ($regulation["images"] as $image) {
                                    $file_uri =  wp_get_attachment_url( $image['image'] );
                                    $alt = get_the_title($image['image']); // Obtener el título de la imagen
                                    echo '<a href="'.$image['url'].'"  rel="nofollow" target="new" ><img height="43px" width="133px" class="img-fluid mx-2" src="'.$file_uri.'" aria-label="'.$alt.'" alt="'.$alt.'" /></a>';
                                }
                                echo '</div>';
                                echo '</div>';
                                if($regulation["text_reg2"] and $regulation["text_reg2"] !== ''):
                                echo '<div id="modal_age_terms" style="backdrop-filter: blur(3px);display:none;align-content: center;width:100%;height:100%;position:fixed;top:0;left:0;background:rgba(0,0,0, .2);z-index:99999999;" >
                                            <div class="row bg-light mx-auto text-center" style="width:320px;height:320px;border-radius:5%;align-items:center;">
                                            <img class=mx-auto width="240" height="125" src='.$agesvg.'>
                                            <div class="col-12 text-center">
                                                    <b class="title d-block">'.$regulation["text_reg2"].'</b>
                                                    <button type="button" class="btn btn-primary px-4 m-5 text-uppercase" onclick="setAge(this)"><p class="h2" >si</p></button>
                                                    <button type="button" class="btn btn-secondary px-4 m-5 text-uppercase" onclick="setAge(this)"><p class="h2" >no</p></button>
                                                </div>
                                            </div>
                                        </div> ';
                                endif;
                            endif;

                        endif;

                       
                    ?>
                    <p class="copy mt-5 py-2 s-f" ><?php echo carbon_get_theme_option( 'copy' ) ?></p>
                    <?php echo carbon_get_theme_option( 'footer_code' ) ?>

                </div>
            </div>
        </div>
        <!--====== BACK TO TOP START ======-->
        <a href="#" aria-label="back to top" class="back-to-top"><i><?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
<svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M12 7C12.2652 7 12.5196 7.10536 12.7071 7.29289L19.7071 14.2929C20.0976 14.6834 20.0976 15.3166 19.7071 15.7071C19.3166 16.0976 18.6834 16.0976 18.2929 15.7071L12 9.41421L5.70711 15.7071C5.31658 16.0976 4.68342 16.0976 4.29289 15.7071C3.90237 15.3166 3.90237 14.6834 4.29289 14.2929L11.2929 7.29289C11.4804 7.10536 11.7348 7 12 7Z" fill="#ffffff"/>
</svg></i></a>
        <!--====== BACK TO TOP ENDS ======-->
</footer>
<?php wp_footer(); ?>

</body>
</html>
