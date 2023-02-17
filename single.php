<?php get_header();

// background
$thumbnail_url = aq_resize(get_the_post_thumbnail_url(get_the_ID()), 600, 350, true, true, true);
$term_page_att = carbon_get_post_meta(get_the_ID(), 'wbg');
if($term_page_att){
    $thumbnail_url = aq_resize(wp_get_attachment_url($term_page_att), 600, 350, true, true, true);
}
if(!$thumbnail_url): $thumbnail_url = get_template_directory_uri( ) . '/assets/img/baner2.png'; endif;
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
                                $post_date = get_the_date( "d M h:i a", get_the_ID());
                                $time = carbon_get_post_meta(get_the_ID(), 'data');
                                $date = new DateTime($time);
                                $date = $date->setTimezone(new DateTimeZone($geolocation->timezone));

                                $fecha = date_i18n('D M', strtotime($date->format("y-m-d h:i:s")));
                                $hora = date('g:i a', strtotime($date->format('y-m-d h:i:s')));

                                $title = get_the_title( get_the_ID() ); 
                                
                                $author_name = get_the_author_meta("display_name" );
                                $author_id =  get_the_author_meta('ID') ;
                                $author_url = PERMALINK_PROFILE.'?profile='.$author_id;
                                $avatar_url = get_avatar_url($author_id);
                                $avatar = isset($avatar_url) ? $avatar_url : get_template_directory_uri() . '/assets/img/logo2. svg';
                            ?>
                                    <h1 class="blog_title"><?php echo $title ?></h1>
                                    <section class="post-author-section">
                                    <div class="row">
                                    <div class="col-sm-12">
                                        <div class="author-info d-flex align-items-center m-3">
                                        <img src="<?php echo $avatar ?>" class="author-img img-fluid rounded-circle mr-3" alt="">
                                        <div class="author-details d-flex flex-column">
                                            <h4 class="author-name mb-1"><a href="<?php echo $author_url ?>"><?php echo $author_name ?></a></h4>
                                            <span class="post-date text-muted mb-0"><?php echo __("Publicado: $post_date");  ?></span>
                                        </div>
                                        </div>
                                    </div>
                                    </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <img src="<?php echo $thumbnail_url ?>" class="post-featured-img img-fluid" alt="<?php echo $title ?>">
                                                
                                                <?php
                                                if (has_post_thumbnail()) {
                                                    $thumbnail_id = get_post_thumbnail_id();
                                                    $thumbnail_caption = get_post($thumbnail_id)->post_excerpt;
                                                    if (!empty($thumbnail_caption)) { ?>
                                                        <div class="caption">
                                                            <?php echo $thumbnail_caption; ?>
                                                            
                                                        </div>
                                                    <?php }
                                                } ?>
                                                <hr class="mt-2 mb-3">
                                            </div>
                                        </div>
                                </section>
                                    <div class="post-content single_event_content text-break">
                                    <?php the_content(); ?>
                                        <?php   endwhile; }?>
                                        <div class="share-buttons-container">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink( $post->ID )); ?>" class="share-button" rel="nofollow noreferrer noopener" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                            <a href="https://twitter.com/home?status=<?php echo urlencode(get_permalink( $post->ID )); ?>" class="share-button" rel="nofollow noreferrer noopener" target="_blank"><i class="fab fa-twitter"></i></a>
                                            <a href="https://api.whatsapp.com/send?text=<?php echo urlencode(get_permalink( $post->ID )); ?>" class="share-button" rel="nofollow noreferrer noopener" target="_blank"><i class="fab fa-whatsapp"></i></a>
                                            <a href="tg://msg?text=Mira este artículo interesante: '<?php echo urlencode(get_permalink( $post->ID )); ?>'" class="share-button" rel="nofollow noreferrer noopener" target="_blank"><i class="fab fa-telegram-plane"></i></a>
                                        </div>
                                    </div>


                        <?php echo do_shortcode( "[related_posts model='1' num='4' title='Lee también']" )?>
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
