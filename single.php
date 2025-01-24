<?php get_header();

$sidebar=false;

$geolocation = json_decode($_SESSION["geolocation"]);

 ?>

	<main>
		<div class="bookmaker_wrapper pb_100">
			<div class="container">
                <div class="row" >
                    <div class="col-lg-9">
                        <?php if(have_posts()){
                            while (have_posts()):the_post();
                                $post_date = get_the_date( "Y-m-d H:i:s", get_the_ID());
                                $date = new DateTime($post_date);
                                $date = $date->setTimezone(new DateTimeZone($geolocation->timezone));

                                $fecha = date_i18n('F j, Y', strtotime($date->format("F j, Y")));
                                $hora = date('g:i a', strtotime($date->format('g:i a')));

                                $title = get_the_title( get_the_ID() ); 
                                
                                $author_name = get_the_author_meta("display_name" );
                                $author_id =  get_the_author_meta('ID') ;
                                
                                $avatar_url = get_the_author_meta( 'profile_image',$author_id );
                                $avatar = aq_resize($avatar_url,40,40,true,true,true);
                                if (!$avatar) { $avatar = get_template_directory_uri() . '/assets/img/user-svgrepo-com.svg'; }
                            ?>
                                    <h1 class="title"><?php echo $title ?></h1>
                                    <section class="post-author-section">
                                    
                                        <div class="d-flex align-items-center my-3">
                                            <img width="40" height="40" src="<?php echo $avatar ?>" class="rounded-circle bg-dark" alt="foto <?php echo $author_name ?>">
                                            <div class="ml-3">
                                                <div class="text-capitalize d-block" ><?php the_author_posts_link(); ?></div>
                                                <time datetime="<?php echo $post_date ?>" ><?php echo __("Publicado: $fecha $hora"); ?></time>
                                            </div>
                                        </div>
                                    

                                        <div class="row">
                                            <div class="col-sm-12">
                                                
                                                <?php
                                                    if (has_post_thumbnail()) {
                                                        the_post_thumbnail('large',['class' => 'img-fluid, post-featured-img']);
                                                        
                                                        } else {
                                                            ?>
                                                            <div class="caption">
                                                                Esta publicación no tiene imagen destacada.
                                                            </div>
                                                            <?php
                                                        }

                                                    ?>
                                                <hr class="my-3">
                                            </div>
                                        </div>
                                </section>
                                    <div class="single_event_content row ">
                                        <div class="col-12 col-lg-1 order-2 order-lg-1"><?php echo do_shortcode("[social_contact model='2']"); ?></div>
                                        <div class="col-12 col-lg-11 order-1 order-lg-2"><?php the_content(); ?></div>
                            <?php  endwhile; }?>
                                    </div>

                        <?php echo do_shortcode( "[related_posts num='4' title='Lee también']" )?>
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
