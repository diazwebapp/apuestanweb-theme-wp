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
						$time1      = date( 'd M Y', strtotime( $time ) );
						$time2      = date( 'g:i a', strtotime( $time ) );
						$link       = carbon_get_post_meta( get_the_ID(), 'link' );
						
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
                        $bookmaker = get_bookmaker_by_post(get_the_ID(),["w"=>79,"h"=>18]);

						$x1 = carbon_get_post_meta( get_the_ID(), 'p1' );
						$x  = carbon_get_post_meta( get_the_ID(), 'x' );
						$x2 = carbon_get_post_meta( get_the_ID(), 'p2' );
                        
						// datos casa de apuesta
						$term_parent = false;
                        foreach($sport_term as $term):
                            if($term->parent == 0){
                                $term_parent = $term->name;
                                $bg_league_src = aq_resize(wp_get_attachment_url(carbon_get_term_meta($term->term_id, 'wbg')), 24, 24, true, true, true);
                                if($term->parent == 0 and !$img_att and $bg_league_src)
                                    $img_src = $bg_league_src;
                            }
                        endforeach;
                        $term_link = get_term_link( $term_parent, 'league' );
						?>
						<div class="single_envent_heading">						
                            <h1 class="title_lg"><?php echo get_the_title(); ?></h1>
                        </div>

						<div class="single_event_banner" style="background-image: url(<?php echo $img_src ?>)">
                            <div class="single_event_banner_top">
                                <?php echo implode( ' ', $arr_sport ); ?>
                            </div>
                            <div class="single_event_banner_middle">
                                <div class="single_team1">
                                    <img loading="lazy" src="<?php echo $teams['team1']['logo'] ?>" class="img-fluid" alt="<?php echo $teams['team1']['name'] ?>" title="<?php echo $teams['team1']['name'] ?>">
                                    <p><?php echo $teams['team1']['name'] ?></p>
                                </div>
                                <div class="single_match_time">                    
                                    <time><?php echo $time2 ?></time>
                                    <?php echo $time1 ?>
                                </div>
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