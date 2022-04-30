<?php get_header(); ?>
<main>
<div class="event_area single_event_area pb_90">
    <div class="container">
		<div class="row">
			<div class="col-lg-9 mt_30">
				<?php
					while ( have_posts() ){
                        the_post();
                        $img_src    = get_template_directory_uri() . '/assets/img/banner2.png';
						$img_att    = carbon_get_post_meta( get_the_ID(), 'wbg' );
						if($img_att):$img_src    = aq_resize(wp_get_attachment_url( $img_att ), 1080, 600, true,true,true);  endif;
						$time       = carbon_get_post_meta( get_the_ID(), 'data' );
						$link       = carbon_get_post_meta( get_the_ID(), 'link' );

                        $geolocation = json_decode(GEOLOCATION);
                        $date = new DateTime($time);
                        if($geolocation->success !== false):
                            $date = $date->setTimezone(new DateTimeZone($geolocation->timezone));
                        endif;
						$sport_term = wp_get_post_terms( get_the_ID(), 'league', array( 'fields' => 'all' ) );
						$arr_sport  = array();
						if ( $sport_term ) {
							foreach ( $sport_term as $item ) {
								$logo_league_src = aq_resize(wp_get_attachment_url(carbon_get_term_meta($item->term_id, 'mini_img')), 24, 24, true, true, true);
								if(!$logo_league_src)$logo_league_src = get_template_directory_uri() . '/assets/img/logo2.svg';
                                $arr_sport[] = "<div class='single_banner_top_left'>
                                    <img loading='lazy' src='{$logo_league_src}' class='img-fluid' alt='{$item->name}' title='{$item->name}'>
                                    <p>{$item->name}</p>
                                </div>";
							}
							$arr_sport = array_reverse( $arr_sport );
						}

						$teams = get_forecast_teams(get_the_ID(),["w"=>50,"h"=>50]);
                        
						// datos casa de apuesta

                        $sport['title'] = '';
                        $sport['slug'] = '';
                        $sport['class'] = '';

                        $home['title'] = '';
                        $home['slug'] = '';
                        $home['class'] = '';

                        $league['title'] = '';
                        $league['slug'] = '';
                        $league['class'] = '';
                        foreach($sport_term as $term):
                            if($term->parent == 0){
                                $page = get_page_by_title($term->name);
                                $sport['title'] = get_the_title($page->ID);
                                $sport['class'] = carbon_get_post_meta($page->ID,'fa_icon_class');
                                $sport['slug'] = get_the_permalink( $page->ID );
                            }
                            if($term->parent != 0){
                                $league_page = get_page_by_title($term->name);
                                if(!is_wp_error( $league_page ) and !empty($league_page)):
                                    $league['title'] = get_the_title($league_page->ID);
                                    $league['class'] = carbon_get_post_meta($league_page->ID,'fa_icon_class');
                                    $league['slug'] = get_the_permalink( $league_page->ID );
                                endif;
                            }
                        endforeach;
                        $homepage = get_page_by_title('home');
                        $home['title'] = get_the_title($homepage->ID);
                        $home['class'] = carbon_get_post_meta($homepage->ID,'fa_icon_class');
                        $home['slug'] = get_the_permalink( $homepage->ID );

						?>

						<div class="single_envent_heading">						
                            <h1 class="title_lg"><?php echo get_the_title(); ?></h1>
                        </div>
                        <div class="single_event_breadcrumb">
                            <ul>
                                <li>
                                    <a href="<?php echo bloginfo( 'url' ) ?>">
                                    <i style="margin:0 5px;" class="<?php echo $home['class'] ?>" ></i><?php echo $home['title'] ?>

<<<<<<< HEAD

=======
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $sport['slug'] ?>">
                                        <i style="margin:0 5px;" class="<?php echo $sport['class'] ?>" ></i><?php echo $sport['title'] ?>
                                    </a>
                                </li>
                                <?php if($league['title'] != ''):
                                    echo '<li>
                                        <a href="'.$sport['slug'].'">
                                            <i style="margin:0 5px;" class="'.$league['class'].'" ></i>"'.$league['title'].'
                                        </a>';
                                endif;
                                ?>
                                </li>
                                <li>
                                    <span>
                                        <?php echo $teams['team1']['name'] . " - " . $teams['team2']['name'] ?>
                                    </span>
                                </li>
                            </ul>
                        </div>
>>>>>>> 1c69f1192b30429135cab971d5de21f415a5aa25
						<div class="single_event_banner" style="background-image: url(<?php echo $img_src ?>)">
                            <div class="single_event_banner_top">
                                <?php echo implode( ' ', $arr_sport ); ?>
                            </div>
                            <div class="single_event_banner_middle">
                                <div class="single_team1">
                                    <img loading="lazy" src="<?php echo $teams['team1']['logo'] ?>" class="img-fluid" alt="<?php echo $teams['team1']['name'] ?>" title="<?php echo $teams['team1']['name'] ?>">
                                    <p><?php echo $teams['team1']['name'] ?></p>
                                </div>
                                <time datetime="<?php echo $date->format('Y-m-d h:i')?>" class="single_match_time">
                                    <?php echo $date->format('d M Y')."<br/><b>".$date->format('g:i a')."</b>"?>
                                </time>
                                    
                                
                                <div class="single_team1">
                                    <img loading="lazy" src="<?php echo $teams['team2']['logo'] ?>" class="img-fluid" alt="<?php echo $teams['team2']['name'] ?>">
                                    <p><?php echo $teams['team2']['name'] ?></p>
                                </div>
                            </div>
                        </div>

						<?php echo do_shortcode("[predictions]") ?>					
							
						<div class="single_event_content text-break">
						
							<?php
                                the_content();
                                wp_reset_query();
							?>
						</div>
                        
						<?php wp_reset_query();?>
						
					<?php } ?>
		
			</div>
			<div class="col-lg-3">
                <div class="row">
					<?php dynamic_sidebar( 'forecast-right' ); ?>
				</div>
			</div>
		</div>
    </div>
    
</div>
</main>
<?php get_footer(); ?>