<?php
$params = get_query_var('params');

echo "<div class='blog_banner_wrapper'>
            <div class='container'>
                <div class='blog_banner_content_wrapper'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-12'>
                            <div class='blog_banner_content'>
                                <p>{$params['text']} </p>
                                <h2>{$params['title']} </h2>
                            </div>
                        </div>
                        <div class='col-lg-10'>
                            <div class='row small_gutter justify-content-center'>
                                <div class='col mt_30'>
                                    <a href='/pronosticos-futbol/' class='blog_banner_box'>    
                                        <div class='blog_banner_img'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='45' height='45' viewBox='0 0 45 45'>
                                                <path id='Futbol' d='M22.5,0a22.316,22.316,0,0,0-7.448,1.294.141.141,0,0,0-.037.014,22.557,22.557,0,0,0-10.5,7.734c0,.006-.008.011-.014.02A22.471,22.471,0,1,0,22.5,0ZM40,13.514a19.543,19.543,0,0,1,2.045,6.677l-2.824-3.083ZM37.839,10.19l-1.381,6.365-4.413,2.16L23.929,12.8V7.313L29.714,4.2A19.707,19.707,0,0,1,37.839,10.19ZM30.226,20.869l-3.094,8.663H17.871l-3.049-8.66,7.7-5.617ZM22.5,2.813a19.666,19.666,0,0,1,3.3.3L22.528,4.871,19.254,3.1A19.9,19.9,0,0,1,22.5,2.813Zm-7.166,1.37L21.119,7.3v5.5L13,18.714,8.57,16.549l-1.378-6.4A19.752,19.752,0,0,1,15.334,4.182Zm-10.3,9.281.785,3.642-2.855,3.1A19.475,19.475,0,0,1,5.029,13.463Zm1.24,20.157a19.558,19.558,0,0,1-3.361-9.208L7.67,19.24l4.343,2.123,3.271,9.29-2.759,3.313Zm2.492,2.956,3.33.183.968,3.009A19.886,19.886,0,0,1,8.761,36.577Zm18.754,4.939a19.325,19.325,0,0,1-11.031-.276l-1.769-5.51,2.818-3.386h9.939l2.77,3.282ZM31.269,40.1l1.6-3.451,4.061-.8A19.745,19.745,0,0,1,31.269,40.1Zm1.17-6.233-2.72-3.22,3.313-9.284,4.323-2.118,4.733,5.167a19.482,19.482,0,0,1-2.652,8.075Z' fill='#00203A'></path>
                                            </svg>
                                        </div>
                                        <p>Fútbol</p>  
                                    </a>
                                </div>
                                <div class='col mt_30'>
                                    <a href='/pronosticos-nba/' class='blog_banner_box'>    
                                        <div class='blog_banner_img'>
                                            <img src='".get_template_directory_uri() . '/assets/img/s13.svg'."' class='img-fluid' alt='basketball'>
                                        </div>
                                        <p>NBA</p>  
                                    </a>
                                </div>
                                <div class='col mt_30'>
                                    <a href='/mlb/pronosticos-mlb/' class='blog_banner_box'>    
                                        <div class='blog_banner_img'>
                                            <img src='".get_template_directory_uri() . '/assets/img/s14.svg'."' class='img-fluid' alt='baseball'>
                                        </div>
                                        <p>MLB</p>  
                                    </a>
                                </div>
                                <div class='col mt_30'>
                                    <a href='/pronosticos-nfl/' class='blog_banner_box'>    
                                        <div class='blog_banner_img'>
                                            <img src='".get_template_directory_uri() . '/assets/img/s15.svg'."' class='img-fluid' alt='americanfootaball'>
                                        </div>
                                        <p>NFL</p>  
                                    </a>
                                </div>
                                <div class='col mt_30'>
                                    <a href='/e-sports/' class='blog_banner_box'>    
                                        <div class='blog_banner_img'>
                                            <img src='".get_template_directory_uri() . '/assets/img/s16.svg'."' class='img-fluid' alt='football'>
                                        </div>
                                        <p>E-Sport</p>  
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>";