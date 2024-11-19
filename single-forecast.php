<?php get_header(); 

?>

<main>
    <div class="event_area single_event_area pb_90">
        <div class="container">
            <div class="row">
                <?php 
                    if(have_posts()):
                        
                        while(have_posts()): the_post();
                            global $wpdb;
                            $post_id = get_the_ID();
                            //forecast geolocation
                            $geolocation = json_decode($_SESSION["geolocation"]);
                            
                            $date      = carbon_get_post_meta( get_the_ID(), 'data' );
                            $datetime = new DateTime($date);
                            $datetime = $datetime->setTimezone(new DateTimeZone($geolocation->timezone));
                            $link       = carbon_get_post_meta( get_the_ID(), 'link' );
                            $vip = carbon_get_post_meta(get_the_ID(),'vip');
                            $disable_table = carbon_get_post_meta( get_the_ID(), 'disable_table' );

                            
                            
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
                                        $sport->icon_html = !empty($icon_class) ? '<i class="'.$icon_class.'" ></i>' : '<img loading="lazy" src="'.$icon_img.'" alt="icon"/>';
                                    endif;
                                endforeach;
                                if($sport):
                                    // Para mejorar el seo detectamos si existe una pagina para el deporte
                                    wp_reset_postdata(  );
                                    $pages = new WP_Query( array( 'post_type' => 'page', 'title' => $sport->name) );
                                    foreach($pages->posts as $page){
                                        $sport_page = $page;
                                    }
                                    $taxonomy_page = carbon_get_term_meta($sport->term_id,'taxonomy_page');
                                    $sport->redirect = isset($taxonomy_page[0]) ? $taxonomy_page[0] : null;
                                    $sport->permalink = isset($sport->redirect) ? get_permalink($sport->redirect["id"]) : get_term_link($sport, 'league');
                                endif;
                            endif;

                            //forecast League
                            $league = false;
                            
                            if(isset($sport)):
                                $img_att   = carbon_get_term_meta( $sport->term_id, 'wbg' );
                                if(!empty($img_att)):
                                    $background_header    = aq_resize(wp_get_attachment_url( $img_att ), 1080, 600, true,true,true);
                                endif;
                                if(isset($tax_leagues) and count($tax_leagues) > 0):
                                    foreach($tax_leagues as $leaguefor):
                                        if($leaguefor->parent == $sport->term_id):
                                            $league = $leaguefor; //define forecast sport
                                            $icon_class = carbon_get_term_meta($league->term_id,'fa_icon_class');                                            
                                            $league->icon_html = !empty($icon_class) ? '<i class="'.$icon_class.'" ></i>' : '<img loading="lazy" src="'.$icon_img.'" alt="icon" />';
                                        endif;
                                    endforeach;
                                endif;
                                if($league):
                                    // Para mejorar el seo detectamos si existe una pagina para el deporte
                                    wp_reset_postdata(  );
                                    $pages = new WP_Query( array( 'post_type' => 'page', 'title' => $league->name) );
                                    foreach($pages->posts as $page){
                                        $league_page = $page;
                                    }
                                    $taxonomy_page = carbon_get_term_meta($league->term_id,'taxonomy_page');
                                    $league->redirect = isset($taxonomy_page[0]) ? $taxonomy_page[0] : null;
                                    $league->permalink = isset($league->redirect) ? get_permalink($league->redirect["id"]) : get_term_link($league, 'league');
                                endif;
                            endif;
                            wp_reset_postdata(  );
                            //forecast teams
                            $teams = get_forecast_teams(get_the_ID(),["w"=>50,"h"=>50]);
                            
                            ?>
                            <section class="col-lg-8 mt_30 con-t">
                                <article>                   
                                    <div class="single_envent_heading">						
                                        <h1 class="title_lg"><?php the_title() ?></h1>
                                    </div>
                                    <!-- breadcrumb -->
                                    <?php echo migas_de_pan(); ?>
                                    <!-- header forecast-->
                                    <div class="single_event_banner" style="background-image:linear-gradient(145deg,#03b0f4 0,#051421c4 50%,#dc213e 100%), url(<?php echo $background_header ?>);">
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
                                            <div class="event_start">                    
                                                <time datetime="<?php echo $datetime->format("Y-m-d H:i:s") ?>" ><?php echo $datetime->format("h:i a") ?></time>
                                                <?php echo date_i18n("d M Y", strtotime($datetime->format("d M Y")));?>   
                                                                       
                                            </div>
                                            <div class="single_team1">
                                                <img loading="lazy" src="<?php echo isset($teams["team2"]["logo"]) ? $teams["team2"]["logo"] : $icon_img?>" alt="<?php echo isset($teams["team2"]["name"]) ? $teams["team2"]["name"] : ''?>" title="<?php echo isset($teams["team2"]["name"]) ? $teams["team1"]["name"] : ''?>">
                                                <p><?php echo isset($teams["team2"]["name"]) ? $teams["team2"]["name"] : ''?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="single_event_content text-break">
                                        
                                        <?php echo do_shortcode("[predictions]"); ?>
                                        <?php remove_filter( 'the_content', 'wpautop' );?>	
                                        <?php if ( !$disable_table ): ?>
                                                <!-- Add the button to toggle the table of contents -->
                                                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#table-of-contents" aria-expanded="false" aria-controls="table-of-contents" style="font-size: 1.8rem; margin-block-end: 1rem;">
                                                    <?php echo __('Contenidos', 'jbetting' );?>
                                                    <i class="fas fa-angle-down"></i>
                                                </button>

                                                <!-- Add the table of contents -->
                                                <div class="collapse" id="table-of-contents">
                                                    <div class="card mt-3">
                                                        <div class="card-header">
                                                        <?php echo __('Tabla de Contenido', 'jbetting' );?>
                                                        </div>
                                                        <ul class="list-group list-group-flush">
                                                        </ul>
                                                    </div>
                                                </div>
                                        <?php endif; ?>
                                        <?php the_content() ?>                                                                        	
                                        <?php echo do_shortcode("[predictions]"); ?>
                                        <?php echo do_shortcode("[social_contact]");?> 
                                        <p class="text-muted"><?php echo __('Las cuotas mostradas son una aproximacion, verifica antes de hacer tu apuesta')?></p>

                                    </div>
                                    <div class="stats-w"><?php echo do_shortcode("[user_stats]") ?></div>
                                    <section>	
                                        <div class="title_wrap single_event_title_wrap">
                                            <h2 class="title-b mt_30 order-lg-1">Otros pronósticos de <?php echo (isset($sport->name) ? $sport->name : '') ?></h2>
                                            <a href="<?php echo (isset($sport->permalink) ? $sport->permalink : '/') ?>" class="mt_30 dropd order-lg-3">Ver Todo</a>
                                        </div>
                                        <?php echo do_shortcode("[related-forecasts model='2' num='6' league='$sport->name']") ?>		
                                    </section>
                                </article>
                            </section>
                        
                            <!-- sidebar -->
        
                            <section class="col-lg-3">
                                <div class="row justify-content-end"><?php dynamic_sidebar( "forecast-right" ) ?></div>
                                
                            </section>
                    <?php endwhile;
                    endif;
                ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>








