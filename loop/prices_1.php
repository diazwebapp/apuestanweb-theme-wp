<?php
$logo =  get_template_directory_uri().'/assets/img/logo.svg';
if ( carbon_get_theme_option( 'logo' ) )
    $logo = wp_get_attachment_url( carbon_get_theme_option( 'logo' ) );


echo "<div class='price_wrapper'>
<div class='container'>
    <div class='row justify-content-between'>
        <div class='col-lg-12'>
            <div class='price_heading'>
                <img src='$logo' class='img-fluid' alt=''>
                <h2>PREDICCIONES DEPORTIVAS, MLB, NBA, FÚTBOL!</h2>
            </div>
        </div>
        <div class='col-lg-12 d-md-none d-block'>
            <ul class='nav nav-pills' id='pills-tab'>
                <li class='nav-item'>
                    <a class='nav-link active' id='pills-home-tab' data-toggle='pill' href='#pills-mensual'>MENSUAL</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' id='pills-profile-tab' data-toggle='pill' href='#pills-trimestral'>TRIMESTRAL</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' id='pills-contact-tab' data-toggle='pill' href='#pills-anual'>ANUAL</a>
                </li>
            </ul>
        </div>
        <div class='col-lg-12 d-md-none d-block'>
            <div class='tab-content' id='pills-tabContent'>
                <div class='tab-pane fade show active' id='pills-mensual'>
                    <div class='price_box price_box1'>
                        <h5>MENSUAL</h5>
                        <p class='price'>$9.99</p>
                        <div class='box_p'>
                            <p>All-Access Pass for Every Pick: MLB, NBA, NFL, PGA, MMA, NHL, NCAAB, NCAAF, Tennis, and Soccer Includes Picks for Game Lines, Over/Under, Player Props, Futures &amp; More Our seasoned team of sports betting pros delivers a wide range of analysis and insights.</p>
                        </div>
                        <div class='price_btn'>
                            <a href='#' class='button'>Unirse</a>
                        </div>
                    </div>
                </div>
                <div class='tab-pane fade' id='pills-trimestral'>
                    <div class='price_box price_box2'>
                        <h5>TRIMESTRAL</h5>
                        <p class='price'>$24.99</p>
                        <div class='box_p'>
                            <p>All-Access Pass for Every Pick: MLB, NBA, NFL, PGA, MMA, NHL, NCAAB, NCAAF, Tennis, and Soccer Includes Picks for Game Lines, Over/Under, Player Props, Futures &amp; More Our seasoned team of sports betting pros delivers a wide range of analysis and insights.</p>
                        </div>
                        <div class='price_btn'>
                            <a href='#' class='button'>Unirse</a>
                        </div>
                    </div>
                </div>
                <div class='tab-pane fade' id='pills-anual'>
                    <div class='price_box price_box3'>
                        <h5>ANUAL</h5>
                        <p class='price'>$99.99</p>
                        <div class='box_p'>
                            <p>All-Access Pass for Every Pick: MLB, NBA, NFL, PGA, MMA, NHL, NCAAB, NCAAF, Tennis, and Soccer Includes Picks for Game Lines, Over/Under, Player Props, Futures &amp; More Our seasoned team of sports betting pros delivers a wide range of analysis and insights.</p>
                        </div>
                        <div class='price_btn'>
                            <a href='#' class='button'>Unirse</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='d-md-block d-none'>
        <div class='price_box_wrapper'>
            <div class='price_box price_box1'>
                <h5>MENSUAL</h5>
                <p class='price'>$9.99</p>
                <div class='box_p'>
                    <p>All-Access Pass for Every Pick: MLB, NBA, NFL, PGA, MMA, NHL, NCAAB, NCAAF, Tennis, and Soccer Includes Picks for Game Lines, Over/Under, Player Props, Futures &amp; More Our seasoned team of sports betting pros delivers a wide range of analysis and insights.</p>
                </div>
                <div class='price_btn'>
                    <a href='#' class='button'>Unirse</a>
                </div>
            </div>
            <div class='price_box price_box2'>
                <h5>TRIMESTRAL</h5>
                <p class='price'>$24.99</p>
                <div class='box_p'>
                    <p>All-Access Pass for Every Pick: MLB, NBA, NFL, PGA, MMA, NHL, NCAAB, NCAAF, Tennis, and Soccer Includes Picks for Game Lines, Over/Under, Player Props, Futures &amp; More Our seasoned team of sports betting pros delivers a wide range of analysis and insights.</p>
                </div>
                <div class='price_btn'>
                    <a href='#' class='button'>Unirse</a>
                </div>
            </div>
            <div class='price_box price_box3'>
                <h5>ANUAL</h5>
                <p class='price'>$99.99</p>
                <div class='box_p'>
                    <p>All-Access Pass for Every Pick: MLB, NBA, NFL, PGA, MMA, NHL, NCAAB, NCAAF, Tennis, and Soccer Includes Picks for Game Lines, Over/Under, Player Props, Futures &amp; More Our seasoned team of sports betting pros delivers a wide range of analysis and insights.</p>
                </div>
                <div class='price_btn'>
                    <a href='#' class='button'>Unirse</a>
                </div>
            </div>
        </div>
    </div>  
</div>
</div>";
