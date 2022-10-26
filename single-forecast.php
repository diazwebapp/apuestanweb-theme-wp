<?php get_header(); ?>
<?php
				
    /* 
    $time       = carbon_get_post_meta( get_the_ID(), 'data' );
    $link       = carbon_get_post_meta( get_the_ID(), 'link' );

    $geolocation = json_decode(GEOLOCATION);
    $date = new DateTime($time);
    $date = $date->setTimezone(new DateTimeZone($geolocation->timezone));

    $teams = get_forecast_teams(get_the_ID(),["w"=>50,"h"=>50]);
    
    // datos casa de apuesta

    */
 
?>

<main>
    <div class="event_area single_event_area pb_90">
        <div class="container">
            <div class="row">
                <?php
                    if(have_posts()):
                        while(have_posts()): the_post();
                            //forecast geolocation
                            $geolocation = json_decode(GEOLOCATION);
                            //forecast date
                            $date      = carbon_get_post_meta( get_the_ID(), 'data' );
                            $datetime = new DateTime($date);
                            $datetime = $datetime->setTimezone(new DateTimeZone($geolocation->timezone));
                            $link       = carbon_get_post_meta( get_the_ID(), 'link' );
                            //forecast backround
                            $background_header    = get_template_directory_uri() . '/assets/img/s49.png';
                            $img_att    = carbon_get_post_meta( get_the_ID(), 'wbg' );
                            if(!empty($img_att)):
                                $background_header    = aq_resize(wp_get_attachment_url( $img_att ), 1080, 600, true,true,true);
                            endif;
                            
                            //taxonomy league
                            $tax_leagues = wp_get_post_terms(get_the_ID(),'league');                            
                            $icon_img = get_template_directory_uri() . '/assets/img/logo2.svg';

                            //forecast sport
                            $sport = false;
                            if(isset($tax_leagues) and count($tax_leagues) > 0):
                                foreach($tax_leagues as $tax_league):
                                    if($tax_league->parent == 0):
                                        $sport = $tax_league; //define forecast sport
                                        $icon_class = carbon_get_term_meta($sport->term_id,'fa_icon_class');
                                        $sport->icon_html = !empty($icon_class) ? '<i class="'.$icon_class.'" ></i>' : '<img loading="lazy" src="'.$icon_img.'" />';
                                    endif;
                                endforeach;
                                if($sport):
                                    // Para mejorar el seo detectamos si existe una pagina para el deporte
                                    $sport_page = get_page_by_title($sport->name);
                                    $sport->permalink = isset($sport_page->ID) ? get_permalink($sport_page->ID) : get_term_link($sport, 'league');
                                endif;
                            endif;

                            //forecast League
                            $league = false;
                            
                            if(isset($sport)):
                                $leagues = get_terms( 'league', array( 'hide_empty' => true, 'parent' => $sport->term_id ) );
                                if(isset($leagues) and count($leagues) > 0):
                                    $league = $leagues[0]; //define forecast sport
                                    $icon_class = carbon_get_term_meta($league->term_id,'fa_icon_class');
                                    $league->icon_html = !empty($icon_class) ? '<i class="'.$icon_class.'" ></i>' : '<img loading="lazy" src="'.$icon_img.'" />';
                                endif;
                                if($league):
                                    // Para mejorar el seo detectamos si existe una pagina para el deporte
                                    $league_page = get_page_by_title($league->name);
                                    $league->permalink = isset($league_page->ID) ? get_permalink($league_page->ID) : get_term_link($league, 'league');
                                endif;
                            endif;

                            //forecast teams
                            $teams = get_forecast_teams(get_the_ID(),["w"=>50,"h"=>50]);
                            
                            ?>
                            <div class="col-lg-9 mt_30">
                    
                                    <div class="single_envent_heading">						
                                        <h1 class="title_lg"><?php the_title() ?></h1>
                                    </div>
                                    <!-- breadcrumb -->
                                    <div class="single_event_breadcrumb">
                                        <ul>
                                            <li>
                                                <a href="<?php echo get_home_url() ?>">
                                                    <i style="margin:0 5px;" ></i>
                                                    inicio
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo isset($sport->permalink) ? $sport->permalink : '/'  ?>">
                                                    <?php echo isset($sport->name) ? $sport->name : '' ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo isset($league->permalink) ? $league->permalink : '/'  ?>">
                                                    <?php echo isset($league->name) ? $league->name : '' ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                    <!-- header forecast-->
                                    <div class="single_event_banner" style="background-image: url(<?php echo $background_header ?>)">
                                        <div class="single_event_banner_top">
                                            <div class='single_banner_top_left'>
                                                <?php echo isset($sport->icon_html) ? $sport->icon_html : '' ?>
                                                <p><?php echo (isset($sport->name) ? $sport->name : '') ?></p>
                                            </div>
                                            <div class='single_banner_top_left'>
                                                <?php echo isset($league->icon_html) ? $league->icon_html : '' ?>
                                                <p><?php echo (isset($league->name) ? $league->name : '') ?></p>
                                            </div>
                                        </div>
                                        <div class="single_event_banner_middle">
                                            <div class="single_team1">
                                                <img loading="lazy" src="<?php echo isset($teams["team1"]["logo"]) ? $teams["team1"]["logo"] : $icon_img?>" alt="<?php echo isset($teams["team1"]["name"]) ? $teams["team1"]["name"] : ''?>" title="<?php echo isset($teams["team1"]["name"]) ? $teams["team1"]["name"] : ''?>">
                                                <p><?php echo isset($teams["team1"]["name"]) ? $teams["team1"]["name"] : ''?></p>
                                            </div>
                                            <div datetime="2022-09-20 08:30" class="single_match_time">                    
                                                <time datetime="<?php echo $datetime->format("Y-m-d h:i") ?>" ><?php echo $datetime->format("h:i a") ?></time>
                                                <?php echo $datetime->format("d M Y") ?>                          
                                            </div>
                                            <div class="single_team1">
                                                <img loading="lazy" src="<?php echo isset($teams["team2"]["logo"]) ? $teams["team2"]["logo"] : $icon_img?>" alt="<?php echo isset($teams["team2"]["name"]) ? $teams["team2"]["name"] : ''?>" title="<?php echo isset($teams["team1"]["name"]) ? $teams["team1"]["name"] : ''?>">
                                                <p><?php echo isset($teams["team2"]["name"]) ? $teams["team2"]["name"] : ''?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="single_event_content text-break">
                                        <?php echo do_shortcode("[predictions]") ?>		
                                        <?php the_content() ?>	
                                        <?php echo do_shortcode("[predictions]") ?>		
                                    </div>
                                    <?php echo do_shortcode("[user_stats]") ?>	
                                    <div class="title_wrap single_event_title_wrap">
                                        <h3 class="title mt_30 order-lg-1">Otros pronósticos de <?php echo (isset($sport->name) ? $sport->name : '') ?></h3>
                                        <a href="<?php echo (isset($sport->permalink) ? $sport->permalink : '/') ?>" class="mt_30 dropd order-lg-3">Ver Todo</a>
                                    </div>
                                    <?php echo do_shortcode("[forecasts model='2' num='4']") ?>		
                            </div>
                            <!-- sidebar -->
                            <div class="col-lg-3">
                                <div class="row"><?php dynamic_sidebar( "forecast-right" ) ?></div>
                            </div>
                    <?php endwhile;
                    endif;
                ?>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>